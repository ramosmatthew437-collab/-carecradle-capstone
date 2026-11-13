<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Mother;
use Illuminate\Http\Request;
use App\Models\SmsNotification;
use App\Services\ActivityLogger;
use App\Support\AppointmentReminderMessage;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /** Values allowed by the appointments.appointment_type column. */
    private const TYPES = ['Prenatal Checkup', 'Vaccination', 'Postpartum', 'Infant Checkup'];

    /** Values allowed by the appointments.status column. */
    private const STATUSES = ['Scheduled', 'Completed', 'Missed', 'Cancelled'];

    /**
     * The appointment reminder text stored with a Pending SMS notification
     * (unchanged wording; used when scheduling and when an appointment's
     * type, date, or time is edited).
     */
    private function reminderMessage(Mother $mother, Appointment $appointment): string
    {
        return AppointmentReminderMessage::for($mother, $appointment);
    }

    /**
     * Keep this appointment's reminders consistent with its status.
     * Only Pending reminders (and reminders this rule closed earlier) change;
     * Sent, Failed and Unknown notifications are never modified here.
     */
    private function syncReminderStatus(Appointment $appointment, string $oldStatus): void
    {
        $new = $appointment->status;

        if ($new === $oldStatus) {
            return;
        }

        if (in_array($new, ['Cancelled', 'Completed', 'Missed'], true)) {
            SmsNotification::where('appointment_id', $appointment->id)
                ->where('status', 'Pending')
                ->update([
                    'status' => $new === 'Cancelled' ? 'Cancelled' : 'Expired',
                    'closed_reason' => 'appointment_' . strtolower($new),
                    'status_note' => "Not sent: the appointment was marked {$new}.",
                ]);

            return;
        }

        // Back to Scheduled: reopen only the reminders this rule closed.
        if ($new === 'Scheduled' && $appointment->mother) {
            SmsNotification::where('appointment_id', $appointment->id)
                ->whereIn('status', ['Cancelled', 'Expired'])
                ->where('closed_reason', 'like', 'appointment\_%')
                ->update([
                    'status' => 'Pending',
                    'closed_reason' => null,
                    'status_note' => 'Reopened: the appointment was scheduled again.',
                    'recipient_number' => $appointment->mother->contact_number,
                    'message' => $this->reminderMessage($appointment->mother, $appointment),
                ]);
        }
    }

    /**
     * Show the appointment form.
     */
    public function create(Mother $mother)
    {
        return view('appointments.create', compact('mother'));
    }

    /**
 * Display appointment details.
 */
public function show(Appointment $appointment)
{
    return view('appointments.show', compact('appointment'));
}
/**
 * Show the edit form.
 */
public function edit(Appointment $appointment)
{
    return view('appointments.edit', compact('appointment'));
}
/**
 * Update an appointment.
 */
public function update(Request $request, Appointment $appointment)
{
    $request->validate([

        'appointment_type' => ['required', 'in:' . implode(',', self::TYPES)],

        'appointment_date' => 'required|date',

        'appointment_time' => 'required',

        'status' => ['required', 'in:' . implode(',', self::STATUSES)],

        'notes' => 'nullable|string',

    ], [
        'appointment_type.in' => 'Please choose a valid appointment type.',
        'status.in' => 'Please choose a valid appointment status.',
    ]);

    $oldStatus = $appointment->status;

    $appointment->update([

        'appointment_type' => $request->appointment_type,

        'appointment_date' => $request->appointment_date,

        'appointment_time' => $request->appointment_time,

        'status' => $request->status,

        'notes' => $request->notes,

    ]);

    // Keep the text of this appointment's still-PENDING reminder in step with
    // the edited type/date/time. Nothing is sent here, and reminders that were
    // already sent or failed are left unchanged.
    if ($appointment->wasChanged(['appointment_type', 'appointment_date', 'appointment_time'])) {
        $appointment->loadMissing('mother');

        if ($appointment->mother) {
            SmsNotification::where('appointment_id', $appointment->id)
                ->where('status', 'Pending')
                ->update([
                    'message' => $this->reminderMessage($appointment->mother, $appointment),
                ]);
        }
    }

    $appointment->loadMissing('mother');
    $this->syncReminderStatus($appointment, $oldStatus);

    return redirect()
        ->route('appointments.show', $appointment->id)
        ->with('success', 'Appointment updated successfully!');
}

    /**
     * Store a new appointment.
     */
    public function store(Request $request, Mother $mother)
    {
        $request->validate([

            'appointment_type' => ['required', 'in:' . implode(',', self::TYPES)],

            'appointment_date' => 'required|date',

            'appointment_time' => 'required',

            'notes' => 'nullable|string',



        ], [
            'appointment_type.in' => 'Please choose a valid appointment type.',
        ]);

        // Create Appointment
    $appointment = $mother->appointments()->create([

        'appointment_type' => $request->appointment_type,

        'appointment_date' => $request->appointment_date,

        'appointment_time' => $request->appointment_time,

        'status' => 'Scheduled',

        'notes' => $request->notes,

        ]);
          // Automatically Create SMS Notification
    SmsNotification::create([

        'mother_id' => $mother->id,

        'appointment_id' => $appointment->id,

        'recipient_number' => $mother->contact_number,

       'message' => $this->reminderMessage($mother, $appointment),

        'notification_type' => 'Appointment Reminder',

        'status' => 'Pending',

    ]);

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Appointment scheduled successfully!');
    }

    /**
     * Delete an appointment while keeping its SMS history.
     *
     * - Pending reminders become Cancelled (reason: appointment_deleted), so they
     *   can never be sent manually or by the scheduler.
     * - Sent (incl. delivered), Failed, Unknown, Cancelled and Expired
     *   notifications are kept unchanged; the foreign key only clears their
     *   appointment link. Attempt history is untouched.
     * - If a reminder is being sent right now (Sending), nothing is deleted:
     *   the outcome is not known yet, so the reminder must not be cancelled or
     *   orphaned mid-send.
     * The notification rows are locked first, so a send that starts at the same
     * moment either finishes its claim before this check (and blocks deletion)
     * or waits and then finds the reminder Cancelled (and sends nothing).
     */
    public function destroy(Appointment $appointment, ActivityLogger $activityLogger)
    {
        $motherId = $appointment->mother_id;
        $details = AppointmentReminderMessage::snapshot($appointment);

        $result = DB::transaction(function () use ($appointment, $details) {
            $notifications = SmsNotification::where('appointment_id', $appointment->id)
                ->lockForUpdate()
                ->get(['id', 'status']);

            $sending = $notifications->where('status', 'Sending')->pluck('id');
            if ($sending->isNotEmpty()) {
                return ['blocked' => $sending->all()];
            }

            // Keep the appointment's details on its notifications (only where none
            // were recorded yet). Query builder: does not touch updated_at, so the
            // history of sent notifications keeps its original timestamps.
            DB::table('sms_notifications')
                ->where('appointment_id', $appointment->id)
                ->whereNull('appointment_snapshot')
                ->update(['appointment_snapshot' => json_encode($details)]);

            $cancel = $notifications->where('status', 'Pending')->pluck('id');
            if ($cancel->isNotEmpty()) {
                SmsNotification::whereIn('id', $cancel)
                    ->where('status', 'Pending')
                    ->update([
                        'status' => 'Cancelled',
                        'closed_reason' => 'appointment_deleted',
                        'status_note' => 'Not sent: the appointment was deleted.',
                    ]);
            }

            $appointment->delete();

            return ['cancelled' => $cancel->all(), 'kept' => $notifications->whereNotIn('status', ['Pending'])->pluck('id')->all()];
        });

        if (isset($result['blocked'])) {
            return back()->with('error',
                'This appointment cannot be deleted right now because its SMS reminder is being sent (notification #'
                . implode(', #', $result['blocked']) . '). Try again in a few minutes, after the send finishes '
                . 'or the attempt is reconciled on the SMS Notifications page. Nothing was deleted.');
        }

        $label = "{$details['type']} on {$details['date']}";
        $activityLogger->log('deleted', 'Appointment Management',
            "Deleted appointment #{$appointment->id} ({$label}); SMS history kept.", $appointment->id);

        foreach ($result['cancelled'] as $id) {
            $activityLogger->log('cancelled', 'SMS Notifications',
                "SMS notification #{$id} cancelled because its appointment #{$appointment->id} ({$label}) was deleted. It was never sent.", $id);
        }

        $note = '';
        if ($result['cancelled']) {
            $note .= ' ' . count($result['cancelled']) . ' unsent reminder(s) were cancelled.';
        }
        if ($result['kept']) {
            $note .= ' ' . count($result['kept']) . ' SMS record(s) were kept in SMS history.';
        }

        return redirect()
            ->route('mothers.show', $motherId)
            ->with('success', 'Appointment deleted successfully.' . $note);
    }
}