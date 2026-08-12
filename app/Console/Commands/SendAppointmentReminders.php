<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\SmsNotification;
use App\Services\TextBeeService;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Send SMS reminders for tomorrow\'s appointments';

    public function handle(TextBeeService $textBee)
    {
        $appointments = Appointment::with('mother')
            ->whereDate('appointment_date', Carbon::tomorrow())
            ->where('status', 'Scheduled')
            ->get();

        $this->info("Found {$appointments->count()} appointment(s) to process.");

        foreach ($appointments as $appointment) {

            // Get the mother
            $mother = $appointment->mother;

            if (!$mother) {
                $this->warn("Appointment #{$appointment->id} has no mother.");
                continue;
            }

            // Check if mother has a contact number
            if (empty($mother->contact_number)) {
                $this->warn("Mother {$mother->first_name} has no contact number.");
                continue;
            }

            // Find existing Pending SMS Notification
            $smsNotification = SmsNotification::where('appointment_id', $appointment->id)
                ->where('status', 'Pending')
                ->first();

            if (!$smsNotification) {
                $this->warn("No pending SMS found for Appointment #{$appointment->id}");
                continue;
            }

            // Build reminder message
            $message =
                "Good day {$mother->first_name}! "
                ."This is a reminder that your prenatal appointment is scheduled on "
                .Carbon::parse($appointment->appointment_date)->format('F d, Y')
                ." at "
                .Carbon::parse($appointment->appointment_time)->format('g:i A')
                .". Please arrive on time. - Irosin RHU";

            // Send SMS
            $result = $textBee->send(
                $mother->contact_number,
                $message
            );

            if ($result['success']) {

                $smsNotification->update([
                    'status' => 'Sent',
                    'sent_at' => now(),
                    'error_message' => null,
                    'message' => $message,
                ]);

                $this->info("✅ SMS sent to {$mother->first_name}");

            } else {

                $error = is_array($result['error'])
                    ? ($result['error']['message'] ?? json_encode($result['error']))
                    : $result['error'];

                $smsNotification->update([
                    'status' => 'Failed',
                    'error_message' => $error,
                    'message' => $message,
                ]);

                $this->error("❌ Failed to send SMS to {$mother->first_name}");
                $this->error("Reason: {$error}");
            }
        }

        $this->info("Appointment reminder process completed.");
    }
}