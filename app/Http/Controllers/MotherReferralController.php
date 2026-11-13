<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\MotherReferral;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Midwife referral workflow. A referral is recorded alongside the mother's
 * pregnancy status and never changes it, her account, her records, her
 * appointments or her SMS reminders. Referrals are never deleted: a mistake
 * is marked "Entered in error" with a reason. Activity-log entries name the
 * signed-in staff member and never contain the clinical reason or notes.
 */
class MotherReferralController extends Controller
{
    public const MODULE = 'Mother Referrals';

    /** Readable field names for validation messages. */
    private const ATTRIBUTES = [
        'referred_at' => 'referral date',
        'receiving_facility' => 'receiving facility',
        'reason' => 'reason for referral',
        'outcome_at' => 'follow-up date',
        'outcome_notes' => 'follow-up notes',
        'outcome_source' => 'information source',
        'voided_reason' => 'reason',
    ];

    public function __construct(private ActivityLogger $logger)
    {
    }

    public function create(Mother $mother): View|RedirectResponse
    {
        if ($mother->referrals()->where('status', MotherReferral::ACTIVE)->exists()) {
            return $this->toProfile($mother, 'referral_error', 'This mother already has an active referral. Update it or record its follow-up instead.');
        }

        return view('mothers.referrals.create', compact('mother'));
    }

    public function store(Request $request, Mother $mother): RedirectResponse
    {
        $data = $request->validate($this->detailRules(), $this->messages(), self::ATTRIBUTES);
        $user = $request->user();

        $referral = DB::transaction(function () use ($mother, $data, $user) {
            // Lock the mother row so two staff cannot open two active referrals at once.
            Mother::whereKey($mother->id)->lockForUpdate()->first();

            if (MotherReferral::where('mother_id', $mother->id)->where('status', MotherReferral::ACTIVE)->exists()) {
                return null;
            }

            return MotherReferral::create($data + [
                'mother_id' => $mother->id,
                'status' => MotherReferral::ACTIVE,
                'referred_by' => $user->id,
                'referred_by_name' => $user->name ?: $user->username,
            ]);
        });

        if (! $referral) {
            return $this->toProfile($mother, 'referral_error', 'This mother already has an active referral. Nothing was added.');
        }

        $this->logger->log('referred', self::MODULE,
            "Recorded referral #{$referral->id} for mother {$mother->mother_code} to {$referral->receiving_facility} on {$referral->referred_at->toDateString()}.", $referral->id);

        return $this->toProfile($mother, 'referral_success', 'Referral recorded. Her pregnancy status, records, appointments and reminders were not changed.');
    }

    public function edit(MotherReferral $referral): View|RedirectResponse
    {
        $referral->load('mother');

        if (! $referral->isActive()) {
            return $this->toProfile($referral->mother, 'referral_error', "This referral is {$referral->status} and can no longer be edited.");
        }

        return view('mothers.referrals.edit', ['referral' => $referral, 'mother' => $referral->mother]);
    }

    public function update(Request $request, MotherReferral $referral): RedirectResponse
    {
        $data = $request->validate($this->detailRules(), $this->messages(), self::ATTRIBUTES);
        $referral->load('mother');
        $before = $referral->only(array_keys($data));

        $changed = MotherReferral::whereKey($referral->id)->where('status', MotherReferral::ACTIVE)->update($data + ['updated_at' => now()]);

        if ($changed !== 1) {
            return $this->toProfile($referral->mother, 'referral_error', 'This referral was closed or changed by someone else. Nothing was saved.');
        }

        $after = $referral->fresh()->only(array_keys($data));
        $parts = [];
        foreach ($after as $field => $value) {
            $old = $before[$field] instanceof \DateTimeInterface ? $before[$field]->format('Y-m-d') : $before[$field];
            $new = $value instanceof \DateTimeInterface ? $value->format('Y-m-d') : $value;
            if ((string) $old === (string) $new) {
                continue;
            }
            // Clinical free text is not copied into the log; only that it changed.
            $parts[] = in_array($field, ['reason', 'notes'], true)
                ? str_replace('_', ' ', $field) . ' changed'
                : str_replace('_', ' ', $field) . ' from "' . ($old ?? '-') . '" to "' . ($new ?? '-') . '"';
        }

        if ($parts) {
            $this->logger->log('updated', self::MODULE,
                "Updated referral #{$referral->id} for mother {$referral->mother->mother_code}: " . implode('; ', $parts) . '.', $referral->id);
        }

        return $this->toProfile($referral->mother, 'referral_success', $parts ? 'Referral updated.' : 'No changes to save.');
    }

    public function close(Request $request, MotherReferral $referral): RedirectResponse
    {
        $referral->load('mother');
        $data = $request->validate([
            'outcome_at' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:' . $referral->referred_at->toDateString()],
            'outcome_notes' => ['required', 'string', 'max:2000'],
            'outcome_source' => ['nullable', 'string', 'max:255'],
        ], [
            'outcome_at.after_or_equal' => 'The follow-up date cannot be before the referral date.',
            'outcome_at.before_or_equal' => 'The follow-up date cannot be in the future.',
            'outcome_notes.required' => 'Please describe the follow-up or outcome.',
        ], self::ATTRIBUTES);
        $user = $request->user();

        $changed = MotherReferral::whereKey($referral->id)->where('status', MotherReferral::ACTIVE)->update($data + [
            'status' => MotherReferral::CLOSED,
            'closed_at' => now(),
            'closed_by' => $user->id,
            'closed_by_name' => $user->name ?: $user->username,
            'updated_at' => now(),
        ]);

        if ($changed !== 1) {
            return $this->toProfile($referral->mother, 'referral_error', 'This referral was already closed or changed. Nothing was saved.');
        }

        $this->logger->log('closed', self::MODULE,
            "Closed referral #{$referral->id} for mother {$referral->mother->mother_code} with follow-up dated {$data['outcome_at']}"
            . (! empty($data['outcome_source']) ? " (information from {$data['outcome_source']})" : '') . '.', $referral->id);

        return $this->toProfile($referral->mother, 'referral_success', 'Follow-up recorded and the referral closed. The referral stays in her history.');
    }

    public function void(Request $request, MotherReferral $referral): RedirectResponse
    {
        $referral->load('mother');
        $data = $request->validate(
            ['voided_reason' => ['required', 'string', 'min:5', 'max:500']],
            ['voided_reason.required' => 'Please explain why this referral was entered in error.'],
            self::ATTRIBUTES
        );
        $user = $request->user();
        $from = $referral->status;

        $changed = MotherReferral::whereKey($referral->id)->whereIn('status', [MotherReferral::ACTIVE, MotherReferral::CLOSED])
            ->where('status', $from)
            ->update($data + [
                'status' => MotherReferral::VOIDED,
                'voided_at' => now(),
                'voided_by' => $user->id,
                'voided_by_name' => $user->name ?: $user->username,
                'updated_at' => now(),
            ]);

        if ($changed !== 1) {
            return $this->toProfile($referral->mother, 'referral_error', 'This referral could not be marked as entered in error (it may have changed). Nothing was saved.');
        }

        $this->logger->log('voided', self::MODULE,
            "Marked referral #{$referral->id} for mother {$referral->mother->mother_code} as entered in error (was {$from}).", $referral->id);

        return $this->toProfile($referral->mother, 'referral_success', 'Referral marked as entered in error. It is kept in her history for the audit trail.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function detailRules(): array
    {
        return [
            'referred_at' => ['required', 'date', 'before_or_equal:today'],
            'receiving_facility' => ['required', 'string', 'max:255'],
            'reason' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    private function messages(): array
    {
        return [
            'referred_at.before_or_equal' => 'The referral date cannot be in the future.',
            'receiving_facility.required' => 'Please enter the receiving facility.',
            'reason.required' => 'Please enter the reason for referral.',
        ];
    }

    private function toProfile(Mother $mother, string $key, string $message): RedirectResponse
    {
        return redirect()->to(route('mothers.show', $mother->id) . '#referral')->with($key, $message);
    }
}
