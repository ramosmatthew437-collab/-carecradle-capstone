<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SmsNotification;

class MotherSmsController extends Controller
{
    public function index()
    {
        $mother = Auth::user()?->mother;

        // A Mother account without a mother profile has no SMS history.
        abort_unless($mother, 403, 'Mother profile not found.');

        // Only the messages actually sent to her (see visibleToMother),
        // newest first by the time TextBee accepted them. Only the fields
        // the page shows are loaded (no gateway or staff-only details).
        $smsNotifications = SmsNotification::where('mother_id', $mother->id)
            ->visibleToMother()
            ->orderByRaw('sent_at IS NULL')
            ->orderByDesc('sent_at')
            ->orderByDesc('id')
            ->select(['id', 'mother_id', 'message', 'notification_type', 'status', 'sent_at', 'delivered_at'])
            ->paginate(10);

        return view(
            'mother.sms-history',
            compact(
                'mother',
                'smsNotifications'
            )
        );
    }
}
