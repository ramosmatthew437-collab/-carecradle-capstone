<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Mother;
use Illuminate\Http\Request;
use App\Models\SmsNotification;

class AppointmentController extends Controller
{
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

        'appointment_type' => 'required',

        'appointment_date' => 'required|date',

        'appointment_time' => 'required',

        'status' => 'required',

        'notes' => 'nullable|string',

    ]);

    $appointment->update([

        'appointment_type' => $request->appointment_type,

        'appointment_date' => $request->appointment_date,

        'appointment_time' => $request->appointment_time,

        'status' => $request->status,

        'notes' => $request->notes,

    ]);

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

            'appointment_type' => 'required',

            'appointment_date' => 'required|date',

            'appointment_time' => 'required',

            'notes' => 'nullable|string',

            

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

       'message' =>
"Good day {$mother->first_name}!

This is a reminder that you have a {$appointment->appointment_type} appointment.

Date:
" . date('F d, Y', strtotime($appointment->appointment_date)) . "

Time:
" . date('g:i A', strtotime($appointment->appointment_time)) . "

Please arrive on time.

-Irosin RHU",

        'notification_type' => 'Appointment Reminder',

        'status' => 'Pending',

    ]);

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Appointment scheduled successfully!');
    }

    public function destroy(Appointment $appointment)
{
    $motherId = $appointment->mother_id;

    // Delete related SMS notification(s)
    SmsNotification::where('appointment_id', $appointment->id)->delete();

    // Delete appointment
    $appointment->delete();

    return redirect()
        ->route('mothers.show', $motherId)
        ->with('success', 'Appointment deleted successfully.');
}
}