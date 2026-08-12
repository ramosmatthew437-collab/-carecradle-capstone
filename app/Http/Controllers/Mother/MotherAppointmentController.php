<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class MotherAppointmentController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        $appointments = Appointment::where(
            'mother_id',
            $mother->id
        )
        ->latest('appointment_date')
        ->paginate(10);

        $totalAppointments = Appointment::where(
            'mother_id',
            $mother->id
        )->count();

        $completedAppointments = Appointment::where(
            'mother_id',
            $mother->id
        )
        ->where('status', 'Completed')
        ->count();

        $scheduledAppointments = Appointment::where(
            'mother_id',
            $mother->id
        )
        ->where('status', 'Scheduled')
        ->count();

        $cancelledAppointments = Appointment::where(
            'mother_id',
            $mother->id
        )
        ->where('status', 'Cancelled')
        ->count();

        return view(
            'mother.appointments',
            compact(
                'mother',
                'appointments',
                'totalAppointments',
                'completedAppointments',
                'scheduledAppointments',
                'cancelledAppointments'
            )
        );
    }
}