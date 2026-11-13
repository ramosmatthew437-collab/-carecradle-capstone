<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PrenatalCheckup;
use App\Models\PrenatalCheckupAttachment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MotherPrenatalController extends Controller
{
    /**
     * Patient-facing prenatal fields. `notes` and `maternal_condition` are
     * deliberately NOT selected: they stay hidden from the Mother Portal.
     */
    private const VISIT_COLUMNS = [
        'id',
        'mother_id',
        'visit_date',
        'gestational_age_weeks',
        'weight',
        'systolic_bp',
        'diastolic_bp',
        'fundal_height',
        'fetal_heart_rate',
        'fetal_movement',
        'urine_protein',
        'urine_glucose',
        'next_visit_date',
    ];

    /** Attachment metadata only (never the stored file path). */
    private const ATTACHMENT_COLUMNS = ['id', 'prenatal_checkup_id', 'file_name', 'mime_type', 'file_size'];

    /**
     * Read-only prenatal history of the signed-in mother.
     * Every query is restricted to her mother_id; nothing is written.
     */
    public function index()
    {
        $mother = Auth::user()->mother;
        $today = today();
        $isDelivered = $mother->status === 'Delivered';

        $own = fn () => PrenatalCheckup::where('mother_id', $mother->id)->select(self::VISIT_COLUMNS);
        $withDocumentCount = fn ($query) => $query->withCount('attachments');

        // Latest visit by visit date (not by when it was entered), queried
        // independently so it stays the same on every history page.
        $latestVisit = $withDocumentCount($own())
            ->orderByDesc('visit_date')
            ->orderByDesc('id')
            ->first();

        // Previous visits: everything except the latest, newest first.
        $previousVisits = $withDocumentCount($own())
            ->when($latestVisit, fn ($query) => $query->where('id', '!=', $latestVisit->id))
            ->orderByDesc('visit_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->fragment('previous-checkups');

        $totalVisits = PrenatalCheckup::where('mother_id', $mother->id)->count();

        // Next actual Scheduled Prenatal Checkup appointment (same date and
        // status rules as the Appointments module). Not shown to Delivered
        // mothers as an upcoming prenatal visit.
        $nextPrenatalAppointment = $isDelivered
            ? null
            : Appointment::where('mother_id', $mother->id)
                ->where('appointment_type', 'Prenatal Checkup')
                ->where('status', 'Scheduled')
                ->whereDate('appointment_date', '>=', $today)
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->first(['id', 'mother_id', 'appointment_type', 'appointment_date', 'appointment_time', 'status']);

        // Recommended follow-up date recorded at the latest checkup. It is
        // never presented as a confirmed appointment.
        $recommendedFollowUp = $latestVisit?->next_visit_date
            ? Carbon::parse($latestVisit->next_visit_date)->startOfDay()
            : null;

        $followUpState = match (true) {
            $recommendedFollowUp === null => 'none',
            $isDelivered => 'historical',
            $recommendedFollowUp->lt($today) => 'passed',
            $nextPrenatalAppointment
                && Carbon::parse($nextPrenatalAppointment->appointment_date)->isSameDay($recommendedFollowUp) => 'matches',
            default => 'upcoming',
        };

        // Laboratory documents of all her visits, grouped by visit date.
        $documents = PrenatalCheckupAttachment::query()
            ->select(array_map(fn ($c) => "prenatal_checkup_attachments.$c", self::ATTACHMENT_COLUMNS))
            ->addSelect('prenatal_checkups.visit_date as visit_date')
            ->join('prenatal_checkups', 'prenatal_checkups.id', '=', 'prenatal_checkup_attachments.prenatal_checkup_id')
            ->where('prenatal_checkups.mother_id', $mother->id)
            ->orderByDesc('prenatal_checkups.visit_date')
            ->orderByDesc('prenatal_checkups.id')
            ->orderBy('prenatal_checkup_attachments.id')
            ->get();

        return view('mother.prenatal-records', compact(
            'mother',
            'isDelivered',
            'latestVisit',
            'previousVisits',
            'totalVisits',
            'nextPrenatalAppointment',
            'recommendedFollowUp',
            'followUpState',
            'documents'
        ));
    }
}
