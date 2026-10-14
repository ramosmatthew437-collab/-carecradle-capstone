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
    $search = trim((string) $request->input('search', ''));

    // Accept only the supported status filters.
    $allowedStatuses = ['Pending', 'Sent', 'Failed'];

    $requestedStatus = $request->input('status', 'All');

    $status = in_array($requestedStatus, $allowedStatuses, true)
        ? $requestedStatus
        : 'All';

    // Base query: preserve the existing appointment requirement.
    $baseQuery = SmsNotification::whereHas('appointment');

    // Notification records with search and optional status filtering.
    $notifications = SmsNotification::with([
            'mother',
            'appointment',
        ])
        ->whereHas('appointment')
        ->when($search !== '', function ($query) use ($search) {
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
        ->when($status !== 'All', function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    // Statistics remain independent of the selected filter and search.
    $totalNotifications = (clone $baseQuery)->count();

    $pendingNotifications = (clone $baseQuery)
        ->where('status', 'Pending')
        ->count();

    $sentNotifications = (clone $baseQuery)
        ->where('status', 'Sent')
        ->count();

    $failedNotifications = (clone $baseQuery)
        ->where('status', 'Failed')
        ->count();

    return view('sms-notifications.index', compact(
        'notifications',
        'totalNotifications',
        'pendingNotifications',
        'sentNotifications',
        'failedNotifications',
        'search',
        'status'
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