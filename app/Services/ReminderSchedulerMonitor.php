<?php

namespace App\Services;

use App\Models\SmsSchedulerRun;
use Illuminate\Support\Carbon;

/**
 * Reports whether the automatic reminder command is VERIFIED to be running,
 * based only on execution records written by the command itself, and only on
 * runs started by Laravel's scheduler (--scheduled). Manual CLI runs never
 * make the scheduler appear Active.
 *
 * - Active:        the most recent expected run (08:00 Asia/Manila) was recorded
 *                  and completed, or a run is in progress, or today's run is not
 *                  yet due and yesterday's run completed.
 * - Delayed:       a recent run exists (within 48 hours) but the latest expected
 *                  run is missing, failed, or has been running too long.
 * - Not Reporting: no run has ever been recorded, or the last one is older than
 *                  48 hours.
 */
class ReminderSchedulerMonitor
{
    public const TIMEZONE = 'Asia/Manila';
    public const HOUR = 8;
    public const GRACE_MINUTES = 30;
    public const STALE_HOURS = 48;

    public function status(?Carbon $now = null): array
    {
        $now = ($now ?? now())->copy()->setTimezone(self::TIMEZONE);
        $todaySlot = $now->copy()->setTime(self::HOUR, 0);
        $latestSlot = $now->gte($todaySlot) ? $todaySlot : $todaySlot->copy()->subDay();
        $nextRun = $now->lt($todaySlot) ? $todaySlot : $todaySlot->copy()->addDay();

        // Only scheduler-triggered runs are evidence. Manual CLI runs are listed
        // in the history but never affect the status or the result shown here.
        $scheduled = fn () => SmsSchedulerRun::reminderRuns()->scheduled()->latest('started_at')->latest('id');
        $last = $scheduled()->first();
        $lastSuccessful = $scheduled()->where('status', 'completed')->first();
        $newerManual = SmsSchedulerRun::reminderRuns()->where('trigger', '!=', SmsSchedulerRun::TRIGGER_SCHEDULER)
            ->when($last, fn ($q) => $q->where('started_at', '>', $last->started_at))
            ->latest('started_at')->latest('id')->first();

        [$state, $reason] = $this->evaluate($now, $latestSlot, $last);

        return [
            'state' => $state,
            'label' => ['active' => 'Active', 'delayed' => 'Delayed', 'not_reporting' => 'Not Reporting'][$state],
            'reason' => $reason,
            'schedule' => 'Daily at 8:00 AM (Asia/Manila)',
            'last' => $last,                     // latest scheduler run: "Last run" and "Last result"
            'lastSuccessful' => $lastSuccessful, // shown separately only when it is not $last
            'newerManual' => $newerManual,       // a newer manual CLI run, for information only
            'nextRun' => $nextRun,
            'timezone' => self::TIMEZONE,
        ];
    }

    private function evaluate(Carbon $now, Carbon $latestSlot, ?SmsSchedulerRun $last): array
    {
        if (! $last) {
            return ['not_reporting', 'No run started by the scheduler has been recorded yet. Check that "php artisan schedule:run" is set to run every minute (cron or Windows Task Scheduler).'];
        }

        $started = $last->started_at->copy()->setTimezone(self::TIMEZONE);

        if ($last->status === 'running') {
            return $started->gt($now->copy()->subMinutes(self::GRACE_MINUTES))
                ? ['active', 'A reminder run is in progress (started ' . $started->format('g:i A') . ').']
                : ['delayed', 'The run that started ' . $started->format('M d, g:i A') . ' has not finished. It may have been interrupted.'];
        }

        if ($started->lt($now->copy()->subHours(self::STALE_HOURS))) {
            return ['not_reporting', 'The last recorded run was ' . $started->format('M d, Y g:i A') . '. No run has been recorded in the last ' . self::STALE_HOURS . ' hours.'];
        }

        $coversLatest = $started->gte($latestSlot->copy()->subMinutes(5));
        $withinGrace = $now->lt($latestSlot->copy()->addMinutes(self::GRACE_MINUTES));
        $coversPrevious = $started->gte($latestSlot->copy()->subDay()->subMinutes(5));

        if ($last->status === 'failed') {
            return ['delayed', 'The last run (' . $started->format('M d, g:i A') . ') stopped with an error. Reminders from that run may not have been processed.'];
        }

        if ($coversLatest || ($withinGrace && $coversPrevious)) {
            return ['active', 'The last expected run was recorded and completed.'];
        }

        return ['delayed', 'The run expected at ' . $latestSlot->format('g:i A \o\n M d') . ' has not been recorded.'];
    }
}
