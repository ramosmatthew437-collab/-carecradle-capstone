<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\PrenatalCheckup;
use App\Models\Infant;
use App\Models\SmsNotification;
use App\Models\Vaccination;

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

    $pregnancyWeek = null;
$trimester = null;

if ($mother->last_menstrual_period) {
    $weeksSinceLmp = (int) \Carbon\Carbon::parse($mother->last_menstrual_period)->diffInWeeks(now());

    if ($weeksSinceLmp >= 1 && $weeksSinceLmp <= 42) {
        $pregnancyWeek = $weeksSinceLmp;
        $trimester = match(true) {
            $pregnancyWeek <= 13 => '1st',
            $pregnancyWeek <= 27 => '2nd',
            default => '3rd',
        };
    }
}

$infant = Infant::where('mother_id', $mother->id)
    ->latest('birth_date')
    ->first();

    
$nextVaccination = Vaccination::whereHas('infant', function ($query) use ($mother) {
        $query->where('mother_id', $mother->id);
    })
    ->whereNotNull('next_due_date')
    ->whereDate('next_due_date', '>=', today())
    ->orderBy('next_due_date')
    ->first();

    dd($nextVaccination);

    return view('mother.dashboard', compact(
    'mother',
    'nextAppointment',
    'appointmentCount',
    'prenatalCount',
    'infantCount',
    'smsCount',
    'pregnancyWeek',
    'trimester',
    'infant',
    'nextVaccination'
));
}
}