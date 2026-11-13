<?php

namespace App\Http\Controllers;

use App\Models\SmsNotification;
use App\Models\SmsSchedulerRun;
use App\Services\ReminderSchedulerMonitor;
use App\Services\SmsDispatcher;
use App\Support\PhilippinePhone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class SmsNotificationController extends Controller
{
    /** Attention filters: extra conditions that overlap with statuses. */
    private const ATTENTION = ['review', 'overdue'];

    public function __construct(
        private SmsDispatcher $dispatcher,
        private ReminderSchedulerMonitor $monitor,
    ) {
    }

    /**
     * Communication Center: list, search, filters and statistics.
     * The statistics always describe the current search and type filter.
     */
    public function index(Request $request): View
    {
        // Read-only: viewing never changes a notification. Interrupted sends
        // are listed under Needs review (stuck flag) and are marked Unknown by
        // the scheduled reconciliation (sms:reconcile) or the reminder run.

        $search = trim(preg_replace('/\s+/', ' ', (string) $request->input('search', '')));
        $search = mb_substr($search, 0, 100);

        // Status = a real notification status. Attention = an extra condition
        // (Needs review / Overdue) that overlaps with statuses.
        $requested = $request->input('status');
        $status = in_array($requested, SmsNotification::STATUSES, true) ? $requested : 'All';
        $attention = in_array($request->input('attention'), self::ATTENTION, true) ? $request->input('attention') : '';
        if ($attention === '' && in_array($requested, self::ATTENTION, true)) {
            $attention = $requested; // older links used ?status=review / ?status=overdue
        }

        $scoped = fn (): Builder => $this->applySearch(SmsNotification::query(), $search);

        $byStatus = $scoped()->selectRaw('status, COUNT(*) AS c')->groupBy('status')->pluck('c', 'status');
        $total = (int) $byStatus->sum();
        $stats = [
            'total' => $total,
            'pending' => (int) ($byStatus['Pending'] ?? 0),
            'sent' => (int) ($byStatus['Sent'] ?? 0),
            'failed' => (int) ($byStatus['Failed'] ?? 0),
        ];
        // Statuses not shown as cards, so Total is never left unexplained.
        $otherStatuses = collect(['Sending', 'Unknown', 'Cancelled', 'Expired'])
            ->mapWithKeys(fn ($s) => [$s => (int) ($byStatus[$s] ?? 0)])
            ->filter();
        $attentionCounts = [
            'review' => $scoped()->needsReview()->count(),
            'overdue' => $scoped()->overdue()->count(),
        ];

        $notifications = $scoped()
            ->with(['mother', 'appointment', 'latestAttempt'])
            ->when($status !== 'All', fn ($q) => $q->where('status', $status))
            ->when($attention === 'review', fn ($q) => $q->needsReview())
            ->when($attention === 'overdue', fn ($q) => $q->overdue())
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $flags = $notifications->getCollection()->mapWithKeys(fn (SmsNotification $n) => [$n->id => $this->flags($n)]);

        return view('sms-notifications.index', [
            'notifications' => $notifications,
            'flags' => $flags,
            'stats' => $stats,
            'otherStatuses' => $otherStatuses,
            'attentionCounts' => $attentionCounts,
            'search' => $search,
            'status' => $status,
            'attention' => $attention,
            'filtered' => $search !== '',
            'monitor' => $this->monitor->status(),
        ]);
    }

    /** Recent recorded executions of the automatic reminder command (read-only). */
    public function schedulerRuns(): View
    {
        return view('sms-notifications.scheduler-runs', [
            'monitor' => $this->monitor->status(),
            'runs' => SmsSchedulerRun::where('command', SmsSchedulerRun::REMINDER_COMMAND)
                ->latest('started_at')->latest('id')->paginate(20),
        ]);
    }

    public function show(SmsNotification $smsNotification): View
    {
        // Read-only (see index): no reconciliation on page view.
        $smsNotification->refresh()->load(['mother', 'appointment', 'attemptRecords.user', 'attemptRecords.resolver', 'reviewer']);

        return view('sms-notifications.show', [
            'sms' => $smsNotification,
            'flags' => $this->flags($smsNotification),
            'sendBlockers' => $smsNotification->status === 'Pending' ? $this->dispatcher->blockers($smsNotification, 'send') : [],
            'retryBlockers' => $smsNotification->status === 'Failed' ? $this->dispatcher->blockers($smsNotification, 'retry') : [],
            'reviewActions' => $this->dispatcher->reviewActions($smsNotification),
            'appointment' => $smsNotification->appointmentDetails(),
        ]);
    }

    public function send(Request $request, SmsNotification $smsNotification): RedirectResponse
    {
        return $this->respond($this->dispatcher->dispatch($smsNotification, 'manual', $request->user(), 'send'));
    }

    public function retry(Request $request, SmsNotification $smsNotification): RedirectResponse
    {
        return $this->respond($this->dispatcher->dispatch($smsNotification, 'manual', $request->user(), 'retry'));
    }

    public function review(Request $request, SmsNotification $smsNotification): RedirectResponse
    {
        $data = $request->validate([
            'action' => ['required', 'in:mark_sent,mark_failed,cancel,expire,use_current_number'],
            'seen_status' => ['required', 'in:' . implode(',', SmsNotification::STATUSES)],
            'note' => ['nullable', 'string', 'max:250', 'required_if:action,mark_sent,mark_failed'],
        ], [
            'note.required_if' => 'Please add a short note explaining how you confirmed the outcome.',
        ]);

        $r = $this->dispatcher->review($smsNotification, $data['action'], $request->user(), $data['note'] ?? null, $data['seen_status']);

        return back()->with($r['ok'] ? 'success' : 'error', $r['message']);
    }

    public function checkStatus(Request $request, SmsNotification $smsNotification): RedirectResponse
    {
        $r = $this->dispatcher->checkStatus($smsNotification, $request->user());

        return back()->with($r['ok'] ? 'success' : 'warning', $r['message']);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function respond(array $r): RedirectResponse
    {
        $key = match ($r['result']) {
            'sent' => 'success',
            'unknown', 'already', 'busy' => 'warning',
            default => 'error',
        };

        return back()->with($key, $r['message']);
    }

    /** Row-level state for the screens. */
    private function flags(SmsNotification $n): array
    {
        $appointment = $n->appointment;
        $mismatch = $n->mother !== null && ! PhilippinePhone::same($n->recipient_number, $n->mother->contact_number);
        $overdue = $n->status === 'Pending' && $appointment
            && Carbon::parse($appointment->appointment_date)->startOfDay()->lt(today());
        $orphan = $n->notification_type === 'Appointment Reminder' && ! $appointment;
        $closedAppointment = $appointment && $appointment->status !== 'Scheduled';
        $stuck = $n->isStuck();

        $canSend = $n->status === 'Pending' && $this->dispatcher->blockers($n, 'send') === [];
        $canRetry = $n->status === 'Failed' && $this->dispatcher->blockers($n, 'retry') === [];

        $review = $n->status === 'Unknown' || $stuck
            || (in_array($n->status, ['Pending', 'Failed'], true) && $mismatch)
            || ($n->status === 'Pending' && ($orphan || $closedAppointment));

        return compact('mismatch', 'overdue', 'orphan', 'closedAppointment', 'stuck', 'canSend', 'canRetry', 'review');
    }

    /** Search by full or partial name, Mother Code, phone number in any format, type or status. */
    private function applySearch(Builder $query, string $search): Builder
    {
        if ($search === '') {
            return $query;
        }

        $like = '%' . addcslashes($search, '%_\\') . '%';
        $digits = preg_replace('/\D+/', '', $search);
        $canonical = PhilippinePhone::normalize($search);

        // Partial number: drop a leading 63 / 0 so "+63 917 12" and "0917 12" both match.
        $partial = $digits;
        if (str_starts_with($partial, '63') && strlen($partial) > 3) {
            $partial = substr($partial, 2);
        } elseif (str_starts_with($partial, '0')) {
            $partial = substr($partial, 1);
        }
        $isNumberish = $digits !== '' && preg_match('/^[\d\s\-.()+]+$/', $search) && strlen($partial) >= 3;

        return $query->where(function ($q) use ($like, $canonical, $partial, $isNumberish, $search) {
            $q->where('notification_type', 'like', $like)
                ->orWhere('status', $search)
                ->orWhereHas('mother', function ($m) use ($like) {
                    $m->where('mother_code', 'like', $like)
                        ->orWhere('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$like])
                        ->orWhereRaw("CONCAT(last_name, ', ', first_name) LIKE ?", [$like]);
                });

            if ($canonical !== null) {
                $tail = substr($canonical, 1);
                $q->orWhereRaw(PhilippinePhone::sqlTail('recipient_number') . ' = ?', [$tail])
                    ->orWhereHas('mother', fn ($m) => $m->whereRaw(PhilippinePhone::sqlTail('contact_number') . ' = ?', [$tail]));
            } elseif ($isNumberish) {
                $p = '%' . $partial . '%';
                $q->orWhereRaw(PhilippinePhone::sqlTail('recipient_number') . ' LIKE ?', [$p])
                    ->orWhereHas('mother', fn ($m) => $m->whereRaw(PhilippinePhone::sqlTail('contact_number') . ' LIKE ?', [$p]));
            }
        });
    }
}
