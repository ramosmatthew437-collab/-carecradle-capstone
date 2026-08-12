<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SmsNotification;

class MotherSmsController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        $smsNotifications = SmsNotification::where(
            'mother_id',
            $mother->id
        )
        ->latest()
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