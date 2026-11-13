<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One submission attempt of an SMS notification to TextBee.
 * recipient_masked and error never contain a full number or credentials.
 */
class SmsNotificationAttempt extends Model
{
    public const OUTCOME_LABELS = [
        'sending' => 'In progress',
        'accepted' => 'Accepted by TextBee',
        'rejected' => 'Rejected by TextBee',
        'not_submitted' => 'Not submitted',
        'unknown' => 'Outcome unknown',
    ];

    protected $fillable = [
        'sms_notification_id', 'attempt_number', 'source', 'recipient_masked', 'outcome',
        'gateway_batch_id', 'http_status', 'error', 'started_at', 'finished_at', 'user_id',
        'resolved_at', 'resolved_by', 'resolution', 'resolution_note',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function notification()
    {
        return $this->belongsTo(SmsNotification::class, 'sms_notification_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /** Automatic = the scheduled reminder command; Manual = sent by a Midwife. */
    public function sourceLabel(): string
    {
        return $this->source === 'scheduled' ? 'Automatic' : 'Manual';
    }

    public function outcomeLabel(): string
    {
        return self::OUTCOME_LABELS[$this->outcome] ?? ucfirst((string) $this->outcome);
    }
}
