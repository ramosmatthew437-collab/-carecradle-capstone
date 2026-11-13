<?php

namespace App\Support;

use App\Models\Appointment;
use App\Models\Mother;

/**
 * The single appointment-reminder template, used when a reminder is created,
 * when its appointment is edited, and when it is restored. The wording is the
 * one CareCradle already stores with appointment reminders.
 */
final class AppointmentReminderMessage
{
    public static function for(Mother $mother, Appointment $appointment): string
    {
        return
"Good day {$mother->first_name}!

This is a reminder that you have a {$appointment->appointment_type} appointment.

Date:
" . date('F d, Y', strtotime((string) $appointment->appointment_date)) . "

Time:
" . date('g:i A', strtotime((string) $appointment->appointment_time)) . "

Please arrive on time.

-Irosin RHU";
    }

    /** Details kept on the notification so its history survives appointment deletion. */
    public static function snapshot(Appointment $appointment): array
    {
        return [
            'type' => $appointment->appointment_type,
            'date' => date('Y-m-d', strtotime((string) $appointment->appointment_date)),
            'time' => date('H:i:s', strtotime((string) $appointment->appointment_time)),
            'status' => $appointment->status,
        ];
    }
}
