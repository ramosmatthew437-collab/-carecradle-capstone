<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** A recorded execution of the automatic appointment-reminder command. */
class SmsSchedulerRun extends Model
{
    public const REMINDER_COMMAND = 'app:send-appointment-reminders';

    /** Started by Laravel's scheduler (command called with --scheduled). */
    public const TRIGGER_SCHEDULER = 'scheduler';

    /** Started by hand from the command line. Never counts as scheduler evidence. */
    public const TRIGGER_CLI = 'cli';

    protected $fillable = [
        'command', 'trigger', 'status', 'started_at', 'finished_at', 'processed', 'sent',
        'failed', 'unknown', 'skipped', 'error', 'host',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function scopeReminderRuns(Builder $query): Builder
    {
        return $query->where('command', self::REMINDER_COMMAND);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('trigger', self::TRIGGER_SCHEDULER);
    }

    public function triggerLabel(): string
    {
        return $this->trigger === self::TRIGGER_SCHEDULER ? 'Scheduler' : 'Manual (CLI)';
    }
}
