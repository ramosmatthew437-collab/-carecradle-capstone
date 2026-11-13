<?php

namespace App\Services;

use App\Models\SmsNotification;
use App\Models\SmsNotificationAttempt;
use App\Models\User;
use App\Support\PhilippinePhone;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * The one place where SMS notifications are sent, retried, reviewed and
 * reconciled. Used by the Midwife screens and by the scheduled command.
 *
 * Duplicate protection: a notification is "claimed" with a single conditional
 * UPDATE (status Pending/Failed -> Sending). Only the request whose UPDATE
 * changes the row may call TextBee; every other click, refresh, concurrent
 * request or scheduler run sees 0 affected rows and stops. TextBee has no
 * idempotency key, so a send whose outcome is unknown is never retried
 * automatically: a person must review it first.
 */
class SmsDispatcher
{
    public const MODULE = 'SMS Notifications';

    public function __construct(
        private TextBeeService $textBee,
        private ActivityLogger $logger,
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Eligibility
    |--------------------------------------------------------------------------
    */

    /**
     * Reasons this notification may not be sent now ([] = it may be sent).
     *
     * @param  string  $mode  'send' (from Pending) or 'retry' (from Failed)
     */
    public function blockers(SmsNotification $n, string $mode = 'send'): array
    {
        $n->loadMissing(['mother', 'appointment']);
        $reasons = [];
        $expected = $mode === 'retry' ? 'Failed' : 'Pending';

        if ($n->status !== $expected) {
            $reasons[] = $mode === 'retry'
                ? 'Only a notification that failed can be retried.'
                : "This notification is {$n->status}, not Pending.";

            return $reasons;
        }

        $mother = $n->mother;

        if (! $mother) {
            return ['The mother linked to this notification no longer exists.'];
        }

        if (PhilippinePhone::normalize($n->recipient_number) === null) {
            $reasons[] = 'The number on this notification is not a valid Philippine mobile number.';
        } elseif (PhilippinePhone::normalize($mother->contact_number) === null) {
            $reasons[] = "The mother's current registered number is missing or invalid.";
        } elseif (! PhilippinePhone::same($n->recipient_number, $mother->contact_number)) {
            $reasons[] = 'The number on this notification (' . PhilippinePhone::mask($n->recipient_number)
                . ") is not the mother's current registered number (" . PhilippinePhone::mask($mother->contact_number)
                . '). Review the recipient before sending.';
        }

        if (trim((string) $n->message) === '') {
            $reasons[] = 'The message is empty.';
        }

        if ($n->notification_type === 'Appointment Reminder' || $n->appointment_id !== null || $n->appointment_snapshot) {
            $appointment = $n->appointment;

            if (! $appointment) {
                $reasons[] = 'The linked appointment was deleted, so this reminder can no longer be sent.';
            } else {
                if ($appointment->mother_id !== $n->mother_id) {
                    $reasons[] = 'The linked appointment belongs to a different mother.';
                }

                if ($appointment->status !== 'Scheduled') {
                    $reasons[] = "The appointment is {$appointment->status}, so a reminder is no longer appropriate.";
                } elseif (Carbon::parse($appointment->appointment_date)->startOfDay()->lt(today())) {
                    $reasons[] = 'The appointment date has already passed (overdue reminder).';
                }
            }
        }

        return $reasons;
    }

    /*
    |--------------------------------------------------------------------------
    | Sending
    |--------------------------------------------------------------------------
    */

    /**
     * Send (from Pending) or retry (from Failed) one notification.
     *
     * @return array{result: string, message: string}
     *   result: sent | failed | unknown | blocked | already | busy
     */
    public function dispatch(SmsNotification $n, string $source = 'manual', ?User $user = null, string $mode = 'send'): array
    {
        $n->refresh();
        $n->unsetRelation('mother')->unsetRelation('appointment');

        if ($n->status === 'Sending') {
            return ['result' => 'busy', 'message' => 'This notification is already being sent. Refresh in a moment to see the outcome.'];
        }

        if ($n->status === 'Sent') {
            return ['result' => 'already', 'message' => 'This notification was already accepted by TextBee. It was not sent again.'];
        }

        if ($blockers = $this->blockers($n, $mode)) {
            return ['result' => 'blocked', 'message' => implode(' ', $blockers)];
        }

        // ---- Atomic claim -------------------------------------------------
        $token = (string) Str::uuid();
        $from = $mode === 'retry' ? 'Failed' : 'Pending';
        $now = now();

        $claimed = DB::table('sms_notifications')
            ->where('id', $n->id)
            ->where('status', $from)
            ->update([
                'status' => 'Sending',
                'attempt_token' => $token,
                'sending_started_at' => $now,
                'last_attempt_at' => $now,
                'attempts' => DB::raw('attempts + 1'),
                'updated_at' => $now,
            ]);

        if ($claimed !== 1) {
            $current = DB::table('sms_notifications')->where('id', $n->id)->value('status');

            return $current === 'Sent'
                ? ['result' => 'already', 'message' => 'This notification was already accepted by TextBee. It was not sent again.']
                : ['result' => 'busy', 'message' => "This notification is no longer {$from} (now {$current}). Nothing was sent."];
        }

        $attemptNumber = (int) DB::table('sms_notifications')->where('id', $n->id)->value('attempts');

        try {
            $attempt = SmsNotificationAttempt::create([
                'sms_notification_id' => $n->id,
                'attempt_number' => $attemptNumber,
                'source' => $source === 'scheduled' ? 'scheduled' : 'manual',
                'recipient_masked' => PhilippinePhone::mask($n->recipient_number),
                'outcome' => 'sending',
                'started_at' => $now,
                'user_id' => $user?->id,
            ]);
        } catch (\Throwable $e) {
            // Nothing was submitted: give the claim back unchanged.
            DB::table('sms_notifications')->where('id', $n->id)->where('attempt_token', $token)->update([
                'status' => $from, 'attempt_token' => null, 'sending_started_at' => null,
                'attempts' => DB::raw('GREATEST(attempts - 1, 0)'), 'updated_at' => now(),
            ]);

            throw $e;
        }

        // ---- Submit (outside any transaction; the claim protects it) ------
        $r = $this->textBee->submit((string) $n->recipient_number, (string) $n->message);

        // ---- Record the outcome --------------------------------------------
        $finished = now();
        $newStatus = match ($r['outcome']) {
            'accepted' => 'Sent',
            'unknown' => 'Unknown',
            default => 'Failed',
        };

        DB::transaction(function () use ($n, $attempt, $r, $token, $newStatus, $finished) {
            $attempt->update([
                'outcome' => $r['outcome'],
                'gateway_batch_id' => $r['batch_id'],
                'http_status' => $r['http_status'],
                'error' => $r['error'] ?? $r['note'],
                'finished_at' => $finished,
            ]);

            DB::table('sms_notifications')
                ->where('id', $n->id)
                ->where('attempt_token', $token)
                ->whereIn('status', ['Sending', 'Unknown'])
                ->update([
                    'status' => $newStatus,
                    'sent_at' => $newStatus === 'Sent' ? $finished : null,
                    'error_message' => $newStatus === 'Sent' ? null : $r['error'],
                    'status_note' => $r['note'],
                    'gateway_batch_id' => $r['batch_id'],
                    'gateway_status_code' => $r['http_status'],
                    'gateway_delivery_status' => null,
                    'delivery_checked_at' => null,
                    'delivered_at' => null,
                    'attempt_token' => null,
                    'sending_started_at' => null,
                    'updated_at' => $finished,
                ]);
        });

        $label = strtolower((string) $n->notification_type);
        $code = $n->mother?->mother_code ?? 'unknown mother';
        $how = $source === 'scheduled' ? 'scheduled' : 'manual';

        [$action, $verb, $message] = match ($newStatus) {
            'Sent' => ['sent', 'accepted by TextBee', 'SMS accepted by TextBee. Delivery to the phone is not yet confirmed.'],
            'Unknown' => ['send_unknown', 'outcome unknown', 'TextBee did not confirm the outcome. The notification is marked Unknown and needs review; it was not retried automatically.'],
            default => ['send_failed', 'not accepted', 'SMS was not sent: ' . ($r['error'] ?? 'TextBee did not accept it.')],
        };

        $this->logger->log(
            $action,
            self::MODULE,
            ucfirst($label) . " #{$n->id} for {$code}: {$verb} (attempt {$attemptNumber}, {$how}, to " . PhilippinePhone::mask($n->recipient_number) . ').',
            $n->id
        );

        return ['result' => strtolower($newStatus) === 'sent' ? 'sent' : strtolower($newStatus), 'message' => $message];
    }

    /*
    |--------------------------------------------------------------------------
    | Reconciliation
    |--------------------------------------------------------------------------
    */

    /**
     * Sending claims older than STUCK_AFTER_MINUTES were interrupted (e.g. the
     * process stopped mid-request). Their outcome is unknown: mark them Unknown
     * for review. They are never retried automatically.
     */
    public function releaseStuck(): int
    {
        $released = 0;

        foreach (SmsNotification::stuckSending()->get(['id', 'attempt_token']) as $row) {
            $released += DB::transaction(function () use ($row) {
                $n = DB::table('sms_notifications')
                    ->where('id', $row->id)
                    ->where('status', 'Sending')
                    ->where(fn ($w) => $row->attempt_token === null ? $w->whereNull('attempt_token') : $w->where('attempt_token', $row->attempt_token))
                    ->update([
                        'status' => 'Unknown',
                        'error_message' => 'The send was interrupted before TextBee\'s answer was recorded. TextBee may or may not have accepted the message.',
                        'sending_started_at' => null,
                        'updated_at' => now(),
                    ]);

                if ($n === 1) {
                    SmsNotificationAttempt::where('sms_notification_id', $row->id)
                        ->where('outcome', 'sending')
                        ->update(['outcome' => 'unknown', 'error' => 'Interrupted: no answer from TextBee was recorded.', 'finished_at' => now()]);
                }

                return $n;
            });
        }

        return $released;
    }

    /**
     * Ask TextBee for the status of an accepted batch. Only what TextBee itself
     * reports is recorded; "delivered" is recorded only when TextBee says so.
     *
     * @return array{ok: bool, message: string}
     */
    public function checkStatus(SmsNotification $n, ?User $user = null): array
    {
        $n->refresh();

        if (! $n->gateway_batch_id || ! in_array($n->status, ['Sent', 'Unknown'], true)) {
            return ['ok' => false, 'message' => 'There is no TextBee batch reference to check for this notification.'];
        }

        $r = $this->textBee->batchStatus($n->gateway_batch_id);

        if (! $r['ok']) {
            DB::table('sms_notifications')->where('id', $n->id)->update(['delivery_checked_at' => now(), 'updated_at' => now()]);

            return ['ok' => false, 'message' => $r['error']];
        }

        $status = $r['status'];
        $update = ['gateway_delivery_status' => $status, 'delivery_checked_at' => now(), 'updated_at' => now()];
        $from = $n->status;

        if ($status === 'delivered') {
            $update['delivered_at'] = $n->delivered_at ?? now();
        }

        if ($from === 'Unknown' && in_array($status, ['pending', 'dispatched', 'sent', 'delivered'], true)) {
            $update += ['status' => 'Sent', 'sent_at' => $n->last_attempt_at ?? now(), 'error_message' => null,
                'status_note' => 'TextBee confirmed it accepted this message (status lookup).'];
        }

        if ($status === 'failed') {
            $update += ['status' => 'Failed', 'sent_at' => null, 'delivered_at' => null,
                'error_message' => 'TextBee reported that the message failed after it was accepted.'];
        }

        DB::transaction(function () use ($n, $from, $update) {
            DB::table('sms_notifications')->where('id', $n->id)->where('status', $from)->update($update);

            if (isset($update['status'])) {
                SmsNotificationAttempt::where('sms_notification_id', $n->id)
                    ->orderByDesc('attempt_number')
                    ->limit(1)
                    ->whereNull('resolved_at')
                    ->update(['resolved_at' => now(), 'resolution' => 'gateway_status',
                        'resolution_note' => 'TextBee status lookup: ' . $update['gateway_delivery_status']]);
            }
        });

        $this->logger->log('status_checked', self::MODULE,
            "Checked TextBee status of SMS notification #{$n->id}: {$status}" . (isset($update['status']) ? " (now {$update['status']})." : '.'), $n->id);

        return ['ok' => true, 'message' => match ($status) {
            'delivered' => 'TextBee reports the message as delivered.',
            'failed' => 'TextBee reports the message as failed. It is now marked Failed and can be retried.',
            default => "TextBee reports the message as {$status}. Delivery is not yet confirmed.",
        }];
    }

    /*
    |--------------------------------------------------------------------------
    | Staff review
    |--------------------------------------------------------------------------
    */

    /** Which review actions are allowed for this notification right now. */
    public function reviewActions(SmsNotification $n): array
    {
        $n->loadMissing(['mother', 'appointment']);
        $actions = [];
        $mismatch = $n->mother
            && PhilippinePhone::normalize($n->mother->contact_number) !== null
            && ! PhilippinePhone::same($n->recipient_number, $n->mother->contact_number);

        switch ($n->status) {
            case 'Unknown':
                $actions = ['mark_sent', 'mark_failed', 'cancel'];
                break;
            case 'Pending':
                if ($mismatch) {
                    $actions[] = 'use_current_number';
                }
                $appointmentClosed = $n->appointment_id === null && $n->notification_type === 'Appointment Reminder'
                    || ($n->appointment && ($n->appointment->status !== 'Scheduled'
                        || Carbon::parse($n->appointment->appointment_date)->startOfDay()->lt(today())));
                if ($appointmentClosed) {
                    $actions[] = 'expire';
                }
                $actions[] = 'cancel';
                break;
            case 'Failed':
                if ($mismatch) {
                    $actions[] = 'use_current_number';
                }
                $actions[] = 'cancel';
                break;
        }

        return $actions;
    }

    /**
     * Apply a reviewed decision. Every change is conditional on the status the
     * reviewer saw, so two reviewers cannot overwrite each other.
     *
     * @return array{ok: bool, message: string}
     */
    public function review(SmsNotification $n, string $action, User $user, ?string $note, string $seenStatus): array
    {
        $n->refresh();
        $n->unsetRelation('mother')->unsetRelation('appointment');

        if ($n->status !== $seenStatus) {
            return ['ok' => false, 'message' => "This notification changed to {$n->status} while you were reviewing it. Nothing was changed."];
        }

        if (! in_array($action, $this->reviewActions($n), true)) {
            return ['ok' => false, 'message' => 'That action is not available for this notification.'];
        }

        $note = $note !== null ? mb_substr(trim(TextBeeService::safeText($note)), 0, 250) : null;
        $now = now();
        $who = $user->name ?: $user->username;
        $base = ['reviewed_by' => $user->id, 'reviewed_at' => $now, 'updated_at' => $now];

        [$update, $resolution, $done, $logText] = match ($action) {
            'mark_sent' => [
                ['status' => 'Sent', 'sent_at' => $n->last_attempt_at ?? $now, 'error_message' => null,
                    'status_note' => 'Marked as accepted after staff review' . ($note ? ": {$note}" : '.')],
                'confirmed_sent', 'Marked as Sent after review.', 'marked as Sent after review',
            ],
            'mark_failed' => [
                ['status' => 'Failed', 'sent_at' => null,
                    'status_note' => 'Marked as not sent after staff review' . ($note ? ": {$note}" : '.') . ' It can now be retried.'],
                'confirmed_failed', 'Marked as Failed after review. You can now retry it.', 'marked as Failed after review',
            ],
            'cancel' => [
                ['status' => 'Cancelled', 'closed_reason' => 'manual_cancel',
                    'status_note' => 'Cancelled by staff' . ($note ? ": {$note}" : '.')],
                'cancelled', 'Notification cancelled. It will not be sent.', 'cancelled',
            ],
            'expire' => [
                ['status' => 'Expired', 'closed_reason' => 'manual_expire',
                    'status_note' => 'Marked as expired by staff' . ($note ? ": {$note}" : '.')],
                null, 'Notification marked as expired. It will not be sent.', 'marked as expired',
            ],
            'use_current_number' => [
                ['recipient_number' => $n->mother->contact_number,
                    'status_note' => 'Recipient changed from ' . PhilippinePhone::mask($n->recipient_number)
                        . " to the mother's current registered number " . PhilippinePhone::mask($n->mother->contact_number)
                        . " by {$who}" . ($note ? ": {$note}" : '.')],
                null, "Recipient updated to the mother's current registered number. Nothing was sent.",
                'recipient changed from ' . PhilippinePhone::mask($n->recipient_number) . ' to ' . PhilippinePhone::mask($n->mother->contact_number),
            ],
        };

        $changed = DB::transaction(function () use ($n, $seenStatus, $update, $base, $resolution, $note, $user, $now) {
            $rows = DB::table('sms_notifications')->where('id', $n->id)->where('status', $seenStatus)
                ->where('recipient_number', $n->recipient_number)
                ->update($update + $base);

            if ($rows === 1 && $resolution && $seenStatus === 'Unknown') {
                SmsNotificationAttempt::where('sms_notification_id', $n->id)
                    ->whereNull('resolved_at')
                    ->whereIn('outcome', ['unknown', 'sending'])
                    ->update(['resolved_at' => $now, 'resolved_by' => $user->id, 'resolution' => $resolution, 'resolution_note' => $note]);
            }

            return $rows;
        });

        if ($changed !== 1) {
            return ['ok' => false, 'message' => 'This notification changed while you were reviewing it. Nothing was changed.'];
        }

        $this->logger->log('reviewed', self::MODULE, "SMS notification #{$n->id} ({$seenStatus}): {$logText}.", $n->id);

        return ['ok' => true, 'message' => $done];
    }
}
