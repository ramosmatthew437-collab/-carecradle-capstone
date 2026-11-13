<?php

namespace App\Console\Commands;

use App\Models\SmsNotification;
use App\Models\SmsSchedulerRun;
use App\Services\SmsDispatcher;
use App\Services\TextBeeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Sends the stored Pending reminder of each Scheduled appointment taking
 * place tomorrow, through the same SmsDispatcher used by the Midwife screens.
 *
 * - The stored message and the stored recipient number are sent unchanged.
 * - A reminder whose number differs from the mother's current registered
 *   number is not sent; it is listed for review on the SMS Notifications page.
 * - Already Sent, Sending, Failed, Unknown, Cancelled and Expired
 *   notifications are never touched, so running this twice sends nothing twice.
 */
class SendAppointmentReminders extends Command
{
    protected $signature = 'app:send-appointment-reminders
        {--dry-run : List what would be sent without sending}
        {--scheduled : Set only by the Laravel scheduler (routes/console.php); marks the run as scheduler-triggered}';

    protected $description = "Send SMS reminders for tomorrow's appointments";

    public function handle(SmsDispatcher $dispatcher): int
    {
        if ($this->option('dry-run')) {
            return $this->dryRun($dispatcher);
        }

        // Heartbeat: record the real start and completion of this run.
        $run = SmsSchedulerRun::create([
            'command' => SmsSchedulerRun::REMINDER_COMMAND,
            // Only runs started by the scheduler count toward the monitor's status.
            'trigger' => $this->option('scheduled') ? SmsSchedulerRun::TRIGGER_SCHEDULER : SmsSchedulerRun::TRIGGER_CLI,
            'status' => 'running',
            'started_at' => now(),
            'host' => substr((string) gethostname(), 0, 100),
        ]);

        try {
            $code = $this->process($dispatcher, $run);
            $run->update(['status' => 'completed', 'finished_at' => now()]);

            return $code;
        } catch (\Throwable $e) {
            $run->update(['status' => 'failed', 'finished_at' => now(),
                'error' => TextBeeService::safeText(class_basename($e) . ': ' . $e->getMessage())]);

            throw $e;
        }
    }

    /** Reminders the next run would consider: Pending, for a Scheduled appointment tomorrow. */
    private function dueTomorrow()
    {
        return SmsNotification::query()
            ->where('status', 'Pending')
            ->where('notification_type', 'Appointment Reminder')
            ->whereHas('appointment', fn ($a) => $a
                ->where('status', 'Scheduled')
                ->whereDate('appointment_date', Carbon::tomorrow()))
            ->with(['mother', 'appointment'])
            ->orderBy('id')
            ->get();
    }

    /**
     * Read-only preview. It does not release stuck sends, create a run
     * record, claim or send anything, or contact TextBee. As a safeguard it
     * runs inside a transaction that is always rolled back, and it stops with
     * an error if any write statement is attempted.
     */
    private function dryRun(SmsDispatcher $dispatcher): int
    {
        $writes = [];
        DB::listen(function ($query) use (&$writes) {
            if (preg_match('/^\s*(insert|update|delete|replace|alter|create|drop|truncate)\b/i', $query->sql)) {
                $writes[] = strtok($query->sql, ' ');
            }
        });

        DB::beginTransaction();

        try {
            $this->info('DRY RUN: nothing will be sent, claimed, released or recorded.');

            $stuck = SmsNotification::stuckSending()->count();
            if ($stuck > 0) {
                $this->warn("{$stuck} interrupted send(s) would be marked Unknown for review by a real run (not changed now).");
            }

            $notifications = $this->dueTomorrow();
            $this->info("Found {$notifications->count()} pending reminder(s) for tomorrow.");

            $wouldSend = 0;
            $wouldSkip = 0;

            foreach ($notifications as $n) {
                $code = $n->mother?->mother_code ?? 'unknown mother';
                $blockers = $dispatcher->blockers($n);
                $blockers ? $wouldSkip++ : $wouldSend++;
                $this->line("#{$n->id} ({$code}): " . ($blockers
                    ? 'would be skipped - ' . implode(' ', $blockers)
                    : 'would be sent to ' . $n->maskedRecipient()));
            }

            $this->info("Dry run summary: would process {$notifications->count()}, would send {$wouldSend}, would skip {$wouldSkip}.");
        } finally {
            DB::rollBack();
        }

        if ($writes !== []) {
            $this->error('Dry run attempted ' . count($writes) . ' database write(s); they were rolled back. Please report this.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function process(SmsDispatcher $dispatcher, SmsSchedulerRun $run): int
    {
        $released = $dispatcher->releaseStuck();

        if ($released > 0) {
            $this->warn("{$released} interrupted send(s) marked Unknown for review.");
        }

        $notifications = $this->dueTomorrow();

        $this->info("Found {$notifications->count()} pending reminder(s) for tomorrow.");

        $tally = ['sent' => 0, 'failed' => 0, 'unknown' => 0, 'blocked' => 0, 'already' => 0, 'busy' => 0];

        foreach ($notifications as $n) {
            $code = $n->mother?->mother_code ?? 'unknown mother';

            $r = $dispatcher->dispatch($n, 'scheduled');
            $tally[$r['result']] = ($tally[$r['result']] ?? 0) + 1;

            $run->update([
                'processed' => array_sum($tally),
                'sent' => $tally['sent'],
                'failed' => $tally['failed'],
                'unknown' => $tally['unknown'],
                'skipped' => $tally['blocked'] + $tally['already'] + $tally['busy'],
            ]);

            $line = "#{$n->id} ({$code}): {$r['result']} - {$r['message']}";
            in_array($r['result'], ['sent', 'already'], true) ? $this->info($line) : $this->warn($line);
        }

        $this->info('Done. ' . collect($tally)->map(fn ($c, $k) => "{$k}: {$c}")->implode(', '));

        return self::SUCCESS;
    }
}
