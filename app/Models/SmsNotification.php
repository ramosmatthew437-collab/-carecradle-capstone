<?php

namespace App\Models;

use App\Support\PhilippinePhone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * An SMS notification and its delivery state.
 *
 * Status meanings:
 * - Pending:   created, not yet submitted.
 * - Sending:   claimed by one sender; a submission to TextBee is in progress.
 * - Sent:      TextBee ACCEPTED the request (not proof that the phone received it).
 * - Failed:    confirmed not accepted (rejected, or never submitted). May be retried.
 * - Unknown:   the outcome could not be confirmed (e.g. timeout). Needs staff review.
 * - Cancelled: will not be sent (appointment cancelled/deleted, or staff decision).
 * - Expired:   will not be sent because the appointment has passed or is closed.
 *
 * delivered_at is written only from a verified TextBee status response.
 */
class SmsNotification extends Model
{
    public const STATUSES = ['Pending', 'Sending', 'Sent', 'Failed', 'Unknown', 'Cancelled', 'Expired'];

    /** A Sending claim older than this is treated as interrupted (outcome unknown). */
    public const STUCK_AFTER_MINUTES = 10;

    protected $fillable = [
        'mother_id',
        'appointment_id',
        'recipient_number',
        'message',
        'notification_type',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'sending_started_at' => 'datetime',
        'last_attempt_at' => 'datetime',
        'delivery_checked_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'appointment_snapshot' => 'array',
        'attempts' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function attemptRecords()
    {
        return $this->hasMany(SmsNotificationAttempt::class)->orderBy('attempt_number');
    }

    public function latestAttempt()
    {
        return $this->hasOne(SmsNotificationAttempt::class)->latestOfMany('attempt_number');
    }

    /** "Automatic" / "Manual" for the most recent attempt, or null when none was recorded. */
    public function sourceLabel(): ?string
    {
        $attempt = $this->relationLoaded('latestAttempt') ? $this->latestAttempt : $this->latestAttempt()->first();

        return $attempt ? ($attempt->source === 'scheduled' ? 'Automatic' : 'Manual') : null;
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /** Stored number differs from the mother's current registered number. */
    public function scopeRecipientMismatch(Builder $query): Builder
    {
        $table = $this->getTable();

        return $query->whereExists(function ($q) use ($table) {
            $q->select(DB::raw(1))
                ->from('mothers')
                ->whereColumn('mothers.id', "{$table}.mother_id")
                ->where(function ($w) use ($table) {
                    $w->whereNull('mothers.contact_number')
                        ->orWhereRaw(PhilippinePhone::sqlTail('mothers.contact_number') . ' <> ' . PhilippinePhone::sqlTail("{$table}.recipient_number"));
                });
        });
    }

    /**
     * Messages a mother may see in her SMS History (and count on her
     * dashboard): only notifications TextBee accepted (Sent). A verified
     * delivery (delivered_at) is only ever recorded on a Sent notification,
     * so it is included here and shown with a separate Delivered label.
     * Pending, Sending, Failed, Unknown, Cancelled and Expired are excluded.
     */
    public function scopeVisibleToMother(Builder $query): Builder
    {
        return $query->where('status', 'Sent');
    }

    public function scopeStuckSending(Builder $query): Builder
    {
        return $query->where('status', 'Sending')
            ->where(fn ($w) => $w->whereNull('sending_started_at')
                ->orWhere('sending_started_at', '<', now()->subMinutes(self::STUCK_AFTER_MINUTES)));
    }

    /** Pending reminders whose appointment date has passed. */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'Pending')
            ->whereHas('appointment', fn ($a) => $a->whereDate('appointment_date', '<', today()));
    }

    /** Records a midwife should look at before anything is sent or retried. */
    public function scopeNeedsReview(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('status', 'Unknown')
                ->orWhere(fn ($s) => $s->stuckSending())
                ->orWhere(fn ($s) => $s->whereIn('status', ['Pending', 'Failed'])->recipientMismatch())
                ->orWhere(fn ($s) => $s->where('status', 'Pending')
                    ->where('notification_type', 'Appointment Reminder')
                    ->where(fn ($o) => $o->whereNull('appointment_id')
                        ->orWhereHas('appointment', fn ($a) => $a->where('status', '!=', 'Scheduled'))));
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isStuck(): bool
    {
        return $this->status === 'Sending'
            && ($this->sending_started_at === null
                || $this->sending_started_at->lt(now()->subMinutes(self::STUCK_AFTER_MINUTES)));
    }

    public function recipientMatchesMother(): bool
    {
        return $this->mother !== null
            && PhilippinePhone::same($this->recipient_number, $this->mother->contact_number);
    }

    public function maskedRecipient(): string
    {
        return PhilippinePhone::mask($this->recipient_number);
    }

    /** Readable reason a notification was closed (Cancelled / Expired), or null. */
    public const CLOSED_REASONS = [
        'appointment_deleted' => 'Appointment deleted',
        'appointment_cancelled' => 'Appointment cancelled',
        'appointment_completed' => 'Appointment marked completed',
        'appointment_missed' => 'Appointment marked missed',
        'manual_cancel' => 'Cancelled by staff',
        'manual_expire' => 'Expired by staff',
    ];

    public function closedReasonLabel(): ?string
    {
        return $this->closed_reason ? (self::CLOSED_REASONS[$this->closed_reason] ?? ucfirst(str_replace('_', ' ', $this->closed_reason))) : null;
    }

    /** True for an appointment reminder whose appointment no longer exists. */
    public function appointmentWasDeleted(): bool
    {
        return $this->appointment === null
            && ($this->appointment_snapshot !== null || $this->notification_type === 'Appointment Reminder');
    }

    /** Appointment details: the live record, or the snapshot kept when it was deleted. */
    public function appointmentDetails(): ?array
    {
        if ($this->appointment) {
            return [
                'type' => $this->appointment->appointment_type,
                'date' => (string) $this->appointment->appointment_date,
                'time' => (string) $this->appointment->appointment_time,
                'status' => $this->appointment->status,
                'deleted' => false,
            ];
        }

        if (is_array($this->appointment_snapshot)) {
            return $this->appointment_snapshot + ['deleted' => true];
        }

        return null;
    }
}
