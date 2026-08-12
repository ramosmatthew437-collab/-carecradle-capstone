<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\PrenatalCheckup;
use App\Models\Infant;
use App\Models\SmsNotification;

class MotherDashboardController extends Controller
{
    public function index()
{
    $mother = auth()->user()->mother;

    $nextAppointment = \App\Models\Appointment::where('mother_id', $mother->id)
        ->whereDate('appointment_date', '>=', now())
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->first();

    $appointmentCount = \App\Models\Appointment::where('mother_id', $mother->id)->count();

    $prenatalCount = \App\Models\PrenatalCheckup::where('mother_id', $mother->id)->count();

    $infantCount = \App\Models\Infant::where('mother_id', $mother->id)->count();

    $smsCount = \App\Models\SmsNotification::where('mother_id', $mother->id)->count();

    return view('mother.dashboard', compact(
        'mother',
        'nextAppointment',
        'appointmentCount',
        'prenatalCount',
        'infantCount',
        'smsCount'
    ));
}
}