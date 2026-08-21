<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\SmsNotification;
use App\Services\TextBeeService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     */
    protected $description = "Send SMS reminders for tomorrow's appointments";

    /**
     * Execute the console command.
     */
    public function handle(TextBeeService $textBee): int
    {
        $appointments = Appointment::with('mother')
            ->whereDate('appointment_date', Carbon::tomorrow())
            ->where('status', 'Scheduled')
            ->get();

        $this->info(
            "Found {$appointments->count()} appointment(s) to process."
        );

        foreach ($appointments as $appointment) {

            // Get the mother
            $mother = $appointment->mother;

            if (!$mother) {
                $this->warn(
                    "Appointment #{$appointment->id} has no mother."
                );

                continue;
            }

            // Check contact number
            if (empty($mother->contact_number)) {
                $this->warn(
                    "Mother {$mother->first_name} has no contact number."
                );

                continue;
            }

            // Find the existing pending SMS notification
            $smsNotification = SmsNotification::where(
                    'appointment_id',
                    $appointment->id
                )
                ->where('status', 'Pending')
                ->first();

            if (!$smsNotification) {
                $this->warn(
                    "No pending SMS found for Appointment #{$appointment->id}"
                );

                continue;
            }

            // Format appointment details
            $appointmentType = $appointment->appointment_type;

            $appointmentDate = Carbon::parse(
                $appointment->appointment_date
            )->format('F d, Y');

            $appointmentTime = Carbon::parse(
                $appointment->appointment_time
            )->format('g:i A');

            // Build SMS message
            $message =
                "Good day {$mother->first_name}!\n\n"
                . "This is a reminder that you have a "
                . "{$appointmentType} appointment.\n\n"
                . "Date: {$appointmentDate}\n"
                . "Time: {$appointmentTime}\n\n"
                . "Please arrive on time.\n\n"
                . "-Irosin RHU";

            // Send SMS through TextBee
            $result = $textBee->send(
                $mother->contact_number,
                $message
            );

            // Successful TextBee request
            if ($result['success']) {

                $smsNotification->update([
                    'status' => 'Sent',
                    'sent_at' => now(),
                    'error_message' => null,
                    'message' => $message,
                ]);

                $this->info(
                    "SMS queued successfully for {$mother->first_name} "
                    . "(Appointment #{$appointment->id})"
                );

                continue;
            }

            // Extract readable error
            $error = $result['error'] ?? 'Unknown SMS gateway error.';

            if (is_array($error)) {
                $error = $error['message']
                    ?? json_encode($error);
            }

            $error = (string) $error;

            // Record failure
            $smsNotification->update([
                'status' => 'Failed',
                'error_message' => $error,
                'sent_at' => null,
                'message' => $message,
            ]);

            $this->error(
                "Failed to send SMS to {$mother->first_name} "
                . "(Appointment #{$appointment->id})"
            );

            $this->error("Reason: {$error}");
        }

        $this->info(
            'Appointment reminder process completed.'
        );

        return self::SUCCESS;
    }
}