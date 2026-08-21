<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mother;
use App\Models\Infant;
use App\Models\Appointment;
use App\Models\PrenatalCheckup;
use App\Models\GrowthMonitoring;
use App\Models\Vaccination;


class DashboardController extends Controller

{
    public function index()
    {
        // Dashboard Cards
        $midwives = User::where('role', 'Midwife')->count();

        $mothers = Mother::count();

        $prenatalVisits = PrenatalCheckup::count();
        
$appointments = Appointment::where('status', 'Scheduled')
    ->whereDate('appointment_date', '>=', today())
    ->count();

$infants = Infant::count();

$growthRecords = GrowthMonitoring::count();

$vaccinations = Vaccination::count();



        // Today's Appointments
        $todayAppointments = Appointment::with('mother')
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Recent Prenatal Visits
        $recentPrenatalVisits = PrenatalCheckup::with('mother')
            ->latest('visit_date')
            ->take(5)
            ->get();

             // Upcoming Vaccinations
            $upcomingVaccinations = Vaccination::with('infant')
    ->whereNotNull('next_due_date')
    ->whereDate('next_due_date', '>=', today())
    ->orderBy('next_due_date')
    ->take(5)
    ->get();

      $recentInfants = Infant::with('mother')
        ->latest()
        ->take(5)
        ->get();


       $user = auth()->user();

$data = compact(
    'midwives',
    'mothers',
    'prenatalVisits',
    'appointments',
    'infants',
    'growthRecords',
    'vaccinations',
    'todayAppointments',
    'upcomingVaccinations',
    'recentInfants'
);

if ($user->isAdministrator()) {
    return view('dashboard.admin', $data);
}

if ($user->isMidwife()) {
    return view('dashboard.midwife', $data);
}

abort(403);
    }
}