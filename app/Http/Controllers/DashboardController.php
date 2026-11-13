<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mother;
use App\Models\Infant;
use App\Models\Appointment;
use App\Models\PrenatalCheckup;
use App\Models\GrowthMonitoring;
use App\Models\Vaccination;
use App\Models\MaternalVaccination;


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
    // Midwife-only figures are added here so the Administrator dashboard
    // receives exactly the same data as before.
    return view('dashboard.midwife', $data + $this->midwifeDashboardData($todayAppointments, $recentInfants, $infants));
}

abort(403);
    }

    /**
     * Accurate counts for the Midwife Dashboard.
     *
     * Every count is calculated from the full matching records, never from
     * the five-item lists shown on the dashboard. Read-only: no record or
     * appointment status is changed.
     */
    private function midwifeDashboardData($todayAppointments, $recentInfants, int $infantsTotal): array
    {
        // Today's appointments: true total and a breakdown by recorded status.
        $todayAppointmentsTotal = Appointment::whereDate('appointment_date', today())->count();

        $statusOrder = ['Scheduled', 'Completed', 'Cancelled', 'Missed'];
        $todayAppointmentStatusCounts = Appointment::whereDate('appointment_date', today())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->sortBy(fn ($total, $status) => [
                array_search($status, $statusOrder, true) === false ? count($statusOrder) : array_search($status, $statusOrder, true),
                $status,
            ])
            ->all();

        // Upcoming vaccinations: infant and maternal doses due today or later.
        $upcomingInfantVaccinationsTotal = Vaccination::whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', today())
            ->count();

        $upcomingMaternalVaccinationsTotal = MaternalVaccination::whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', today())
            ->count();

        // The five soonest doses across both tables (existing records only, nothing is created).
        $infantDoses = Vaccination::with('infant')
            ->whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', today())
            ->orderBy('next_due_date')
            ->orderBy('id')
            ->take(5)
            ->get()
            ->map(fn ($vaccination) => [
                'recipient' => 'Infant',
                'name' => trim(($vaccination->infant?->first_name ?? '') . ' ' . ($vaccination->infant?->last_name ?? '')),
                'vaccine' => $vaccination->vaccine_name,
                'due' => $vaccination->next_due_date,
                'order' => 0,
                'id' => $vaccination->id,
            ]);

        $maternalDoses = MaternalVaccination::with('mother')
            ->whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', today())
            ->orderBy('next_due_date')
            ->orderBy('id')
            ->take(5)
            ->get()
            ->map(fn ($vaccination) => [
                'recipient' => 'Mother',
                'name' => trim(($vaccination->mother?->first_name ?? '') . ' ' . ($vaccination->mother?->last_name ?? '')),
                'vaccine' => $vaccination->vaccine_name,
                'due' => $vaccination->next_due_date,
                'order' => 1,
                'id' => $vaccination->id,
            ]);

        $midwifeUpcomingVaccinations = $infantDoses
            ->concat($maternalDoses)
            ->sortBy(fn ($dose) => [\Carbon\Carbon::parse($dose['due'])->toDateString(), $dose['order'], $dose['id']])
            ->take(5)
            ->values();

        $upcomingVaccinationsTotal = $upcomingInfantVaccinationsTotal + $upcomingMaternalVaccinationsTotal;

        // System Overview "Vaccinations Given": administered doses only, i.e.
        // infant and maternal records whose date given is today or earlier.
        // Next due dates and appointments are not counted. Two COUNT queries.
        $vaccinationsGiven = Vaccination::whereNotNull('date_given')->whereDate('date_given', '<=', today())->count()
            + MaternalVaccination::whereNotNull('date_given')->whereDate('date_given', '<=', today())->count();

        return array_merge($this->midwifeAttentionData(), [
            'midwifeVaccinationsGiven' => $vaccinationsGiven,
            'todayAppointmentsTotal' => $todayAppointmentsTotal,
            'todayAppointmentStatusCounts' => $todayAppointmentStatusCounts,
            'todayAppointmentsMore' => max(0, $todayAppointmentsTotal - $todayAppointments->count()),
            'midwifeUpcomingVaccinations' => $midwifeUpcomingVaccinations,
            'upcomingInfantVaccinationsTotal' => $upcomingInfantVaccinationsTotal,
            'upcomingMaternalVaccinationsTotal' => $upcomingMaternalVaccinationsTotal,
            'upcomingVaccinationsTotal' => $upcomingVaccinationsTotal,
            'upcomingVaccinationsMore' => max(0, $upcomingVaccinationsTotal - $midwifeUpcomingVaccinations->count()),
            'recentInfantsMore' => max(0, $infantsTotal - $recentInfants->count()),
        ]);
    }

    /**
     * "Attention required" panel for the Midwife Dashboard.
     *
     * READ-ONLY. Nothing is updated: appointments are only flagged for the
     * midwife to review, and vaccination doses are only flagged as past due
     * or due soon. Every total is counted from the full matching records;
     * each list shows at most five.
     */
    private function midwifeAttentionData(): array
    {
        $today = today();
        $soonEnd = $today->copy()->addDays(7);

        // 1. Appointments still "Scheduled" although their date has passed.
        $reviewQuery = Appointment::where('status', 'Scheduled')
            ->whereDate('appointment_date', '<', $today);

        $attentionReviewTotal = (clone $reviewQuery)->count();

        $attentionReview = (clone $reviewQuery)
            ->with('mother')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->orderBy('id')
            ->take(5)
            ->get()
            ->map(function ($appointment) use ($today) {
                $date = \Carbon\Carbon::parse($appointment->appointment_date)->startOfDay();

                return [
                    'date' => $date,
                    'days' => (int) $date->diffInDays($today),
                    'name' => trim(($appointment->mother?->first_name ?? '') . ' ' . ($appointment->mother?->last_name ?? '')),
                    'type' => $appointment->appointment_type,
                    'url' => route('appointments.show', $appointment->id),
                ];
            });

        // 2. Overdue doses: next due date has passed and no later dose of the
        //    same vaccine (compared case-insensitively, ignoring spaces) has
        //    been recorded for the same patient.
        $overdueInfantQuery = $this->pastDueDoseQuery(Vaccination::class, 'vaccinations', 'infant_id', $today);
        $overdueMaternalQuery = $this->pastDueDoseQuery(MaternalVaccination::class, 'maternal_vaccinations', 'mother_id', $today);

        $attentionOverdueTotal = (clone $overdueInfantQuery)->count() + (clone $overdueMaternalQuery)->count();

        $attentionOverdue = $this->mergeDoses(
            (clone $overdueInfantQuery)->with('infant')->orderBy('dose.next_due_date')->orderBy('dose.id')->take(5)->get(),
            (clone $overdueMaternalQuery)->with('mother')->orderBy('dose.next_due_date')->orderBy('dose.id')->take(5)->get(),
            $today
        );

        // 3. Doses due from today through the next 7 days (inclusive).
        $soonInfantQuery = Vaccination::whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', $today)
            ->whereDate('next_due_date', '<=', $soonEnd);

        $soonMaternalQuery = MaternalVaccination::whereNotNull('next_due_date')
            ->whereDate('next_due_date', '>=', $today)
            ->whereDate('next_due_date', '<=', $soonEnd);

        $attentionSoonTotal = (clone $soonInfantQuery)->count() + (clone $soonMaternalQuery)->count();

        $attentionSoon = $this->mergeDoses(
            (clone $soonInfantQuery)->with('infant')->orderBy('next_due_date')->orderBy('id')->take(5)->get(),
            (clone $soonMaternalQuery)->with('mother')->orderBy('next_due_date')->orderBy('id')->take(5)->get(),
            $today
        );

        return [
            'attentionReview' => $attentionReview,
            'attentionReviewTotal' => $attentionReviewTotal,
            'attentionReviewMore' => max(0, $attentionReviewTotal - $attentionReview->count()),
            'attentionOverdue' => $attentionOverdue,
            'attentionOverdueTotal' => $attentionOverdueTotal,
            'attentionOverdueMore' => max(0, $attentionOverdueTotal - $attentionOverdue->count()),
            'attentionSoon' => $attentionSoon,
            'attentionSoonTotal' => $attentionSoonTotal,
            'attentionSoonMore' => max(0, $attentionSoonTotal - $attentionSoon->count()),
            'attentionTotal' => $attentionReviewTotal + $attentionOverdueTotal + $attentionSoonTotal,
        ];
    }

    /**
     * Doses whose next due date is before $today and that have not been
     * followed by a later dose of the same vaccine for the same patient.
     * A dose counts as "later" when it was given after this one, or on the
     * same day but recorded afterwards.
     */
    private function pastDueDoseQuery(string $model, string $table, string $patientColumn, $today)
    {
        $normalisedName = fn (string $alias) => "LOWER(REPLACE({$alias}.vaccine_name, ' ', ''))";

        return $model::query()
            ->from("{$table} as dose")
            ->select('dose.*')
            ->whereNotNull('dose.next_due_date')
            ->whereDate('dose.next_due_date', '<', $today)
            ->whereNotExists(function ($later) use ($table, $patientColumn, $normalisedName) {
                $later->selectRaw('1')
                    ->from("{$table} as later")
                    ->whereColumn("later.{$patientColumn}", "dose.{$patientColumn}")
                    ->whereRaw($normalisedName('later') . ' = ' . $normalisedName('dose'))
                    ->where(function ($when) {
                        $when->whereColumn('later.date_given', '>', 'dose.date_given')
                            ->orWhere(function ($sameDay) {
                                $sameDay->whereColumn('later.date_given', 'dose.date_given')
                                    ->whereColumn('later.id', '>', 'dose.id');
                            });
                    });
            });
    }

    /**
     * Combine infant and maternal doses into one list (soonest / most overdue
     * first) and keep five. Each input list is already limited to five.
     */
    private function mergeDoses($infantDoses, $maternalDoses, $today)
    {
        $infantRows = $infantDoses->map(fn ($dose) => [
            'recipient' => 'Infant',
            'name' => trim(($dose->infant?->first_name ?? '') . ' ' . ($dose->infant?->last_name ?? '')),
            'vaccine' => $dose->vaccine_name,
            'due' => \Carbon\Carbon::parse($dose->next_due_date)->startOfDay(),
            'url' => route('infants.show', $dose->infant_id),
            'order' => 0,
            'id' => $dose->id,
        ]);

        $maternalRows = $maternalDoses->map(fn ($dose) => [
            'recipient' => 'Mother',
            'name' => trim(($dose->mother?->first_name ?? '') . ' ' . ($dose->mother?->last_name ?? '')),
            'vaccine' => $dose->vaccine_name,
            'due' => \Carbon\Carbon::parse($dose->next_due_date)->startOfDay(),
            'url' => route('mothers.show', $dose->mother_id),
            'order' => 1,
            'id' => $dose->id,
        ]);

        return $infantRows
            ->concat($maternalRows)
            ->sortBy(fn ($row) => [$row['due']->toDateString(), $row['order'], $row['id']])
            ->take(5)
            ->map(function ($row) use ($today) {
                $row['days'] = (int) $today->diffInDays($row['due'], false);

                return $row;
            })
            ->values();
    }
}