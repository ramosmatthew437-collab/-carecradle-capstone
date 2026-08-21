<?php

namespace App\Http\Controllers;

use App\Models\SmsNotification;
use App\Services\TextBeeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmsNotificationController extends Controller
{
    /**
     * Display SMS Notifications.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $notifications = SmsNotification::with([
                'mother',
                'appointment',
            ])
            ->whereHas('appointment')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('recipient_number', 'like', "%{$search}%")
                        ->orWhere('notification_type', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('mother', function ($motherQuery) use ($search) {
                            $motherQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('mother_code', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $totalNotifications = SmsNotification::whereHas('appointment')->count();

        $pendingNotifications = SmsNotification::whereHas('appointment')
            ->where('status', 'Pending')
            ->count();

        $sentNotifications = SmsNotification::whereHas('appointment')
            ->where('status', 'Sent')
            ->count();

        $failedNotifications = SmsNotification::whereHas('appointment')
            ->where('status', 'Failed')
            ->count();

        return view('sms-notifications.index', compact(
            'notifications',
            'totalNotifications',
            'pendingNotifications',
            'sentNotifications',
            'failedNotifications'
        ));
    }

    /**
     * Display a specific SMS Notification.
     */
    public function show(SmsNotification $smsNotification)
    {
        $smsNotification->load([
            'mother',
            'appointment',
        ]);

        // Prevent opening orphaned notifications
        if (!$smsNotification->appointment) {
            return redirect()
                ->route('sms-notifications.index')
                ->with(
                    'error',
                    'This notification is no longer available because its appointment has been deleted.'
                );
        }

        return view(
            'sms-notifications.show',
            compact('smsNotification')
        );
    }

    /**
     * Send an SMS notification.
     */
    public function send(
        SmsNotification $smsNotification,
        TextBeeService $textBee
    ) {
        $result = $textBee->send(
            $smsNotification->recipient_number,
            $smsNotification->message
        );

        // SMS successfully accepted by TextBee
        if ($result['success']) {
            $smsNotification->update([
                'status' => 'Sent',
                'sent_at' => Carbon::now(),
                'error_message' => null,
            ]);

            return back()->with(
                'success',
                'SMS sent successfully!'
            );
        }

        // Extract a readable error message
        $error = $result['error'] ?? 'Unknown SMS gateway error.';

        if (is_array($error)) {
            $error = $error['message']
                ?? json_encode($error);
        }

        $error = (string) $error;

        // Save failed status and error details
        $smsNotification->update([
            'status' => 'Failed',
            'error_message' => $error,
            'sent_at' => null,
        ]);

        return back()->with(
            'error',
            'SMS failed: ' . $error
        );
    }
}