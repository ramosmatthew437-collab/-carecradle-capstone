<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class MotherAppointmentController extends Controller
{
    /**
     * Read-only list of the signed-in mother's own appointments.
     * Every query is restricted to her mother_id; nothing is written.
     */
    public function index()
    {
        $mother = Auth::user()->mother;
        $today = today();

        $own = fn () => Appointment::where('mother_id', $mother->id);

        // Next appointment: the same query and sorting as the Mother
        // Dashboard, queried independently of the paginated history so a
        // mother with many visits always sees her real next visit.
        $nextAppointment = $own()
            ->where('status', 'Scheduled')
            ->whereDate('appointment_date', '>=', $today)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        // Upcoming: only Scheduled visits dated today or later, soonest first.
        $upcomingAppointments = $own()
            ->where('status', 'Scheduled')
            ->whereDate('appointment_date', '>=', $today)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->orderBy('id')
            ->get(['id', 'mother_id', 'appointment_type', 'appointment_date', 'appointment_time', 'status']);

        // History: Completed, Missed, and Cancelled visits (any date) plus
        // past visits still marked Scheduled. Newest first, paginated.
        $historyAppointments = $own()
            ->where(function ($query) use ($today) {
                $query->where('status', '!=', 'Scheduled')
                    ->orWhereDate('appointment_date', '<', $today);
            })
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->orderByDesc('id')
            ->select(['id', 'mother_id', 'appointment_type', 'appointment_date', 'appointment_time', 'status'])
            ->paginate(10)
            ->fragment('appointment-history');

        // Summary counts (actual records of this mother).
        $totalAppointments = $own()->count();
        $upcomingCount = $upcomingAppointments->count();
        $completedAppointments = $own()->where('status', 'Completed')->count();
        $missedAppointments = $own()->where('status', 'Missed')->count();
        $cancelledAppointments = $own()->where('status', 'Cancelled')->count();

        return view('mother.appointments', compact(
            'mother',
            'nextAppointment',
            'upcomingAppointments',
            'historyAppointments',
            'totalAppointments',
            'upcomingCount',
            'completedAppointments',
            'missedAppointments',
            'cancelledAppointments'
        ));
    }
}
