<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use App\Models\Infant;
use App\Models\MaternalVaccination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MotherVaccinationController extends Controller
{
    /**
     * Dose columns shown to mothers. Staff-only fields (administered_by,
     * remarks) are never loaded for the Mother Portal.
     */
    private const DOSE_COLUMNS = ['id', 'vaccine_name', 'dose', 'date_given', 'next_due_date'];

    /** Due-soon window, the same as the Mother and Midwife dashboards. */
    private const SOON_DAYS = 7;

    public function index()
    {
        $mother = Auth::user()->mother;

        if (!$mother) {
            abort(403, 'Mother profile not found.');
        }

        $today = Carbon::today();

        // The signed-in mother's own children (same order as Infant Records),
        // each with the COMPLETE vaccination history, newest dose first.
        $infants = Infant::where('mother_id', $mother->id)
            ->with(['vaccinations' => fn ($query) => $query
                ->select([...self::DOSE_COLUMNS, 'infant_id'])
                ->reorder()
                ->orderByDesc('date_given')
                ->orderByDesc('id')])
            ->latest()
            ->get(['id', 'mother_id', 'first_name', 'middle_name', 'last_name', 'birth_date']);

        // All infant doses (kept for reference; already scoped to her children).
        $vaccinations = $infants->flatMap->vaccinations->values();

        // The mother's own maternal records, newest dose first.
        $maternalVaccinations = MaternalVaccination::where('mother_id', $mother->id)
            ->orderByDesc('date_given')
            ->orderByDesc('id')
            ->get([...self::DOSE_COLUMNS, 'mother_id']);

        // Next-dose status of each record, using the model rules:
        // isSupersededWithin() first (a later dose closes the next due date,
        // as on the Mother Dashboard), then dueStatus() for overdue/upcoming.
        $describe = function ($dose, $records) use ($today) {
            if (blank($dose->next_due_date)) {
                return ['key' => 'none', 'label' => 'No next dose date recorded', 'due' => null];
            }

            $due = Carbon::parse($dose->next_due_date)->startOfDay();

            if ($dose->isSupersededWithin($records)) {
                return ['key' => 'recorded', 'label' => 'Next dose already recorded', 'due' => $due];
            }

            $days = (int) $today->diffInDays($due, false);

            if ($dose->dueStatus($records, $today) === 'overdue') {
                return ['key' => 'overdue', 'label' => 'Overdue by ' . abs($days) . ' ' . ($days === -1 ? 'day' : 'days'), 'due' => $due];
            }

            if ($days === 0) {
                return ['key' => 'today', 'label' => 'Due today', 'due' => $due];
            }

            $inDays = 'in ' . $days . ' ' . ($days === 1 ? 'day' : 'days');

            return $days <= self::SOON_DAYS
                ? ['key' => 'soon', 'label' => 'Due soon — ' . $inDays, 'due' => $due]
                : ['key' => 'upcoming', 'label' => 'Upcoming — ' . $inDays, 'due' => $due];
        };

        $infantStatus = [];
        foreach ($infants as $infant) {
            foreach ($infant->vaccinations as $dose) {
                $infantStatus[$dose->id] = $describe($dose, $infant->vaccinations);
            }
        }

        $maternalStatus = [];
        foreach ($maternalVaccinations as $dose) {
            $maternalStatus[$dose->id] = $describe($dose, $maternalVaccinations);
        }

        // Summary counts from the complete record sets, maternal and infant separately.
        $count = fn (array $statuses, array $keys) => collect($statuses)->whereIn('key', $keys)->count();

        $infantSummary = [
            'doses' => count($infantStatus),
            'children' => $infants->count(),
            'overdue' => $count($infantStatus, ['overdue']),
            'soon' => $count($infantStatus, ['today', 'soon']),
            'upcoming' => $count($infantStatus, ['upcoming']),
        ];

        $maternalSummary = [
            'doses' => count($maternalStatus),
            'overdue' => $count($maternalStatus, ['overdue']),
            'soon' => $count($maternalStatus, ['today', 'soon']),
            'upcoming' => $count($maternalStatus, ['upcoming']),
        ];

        // Shared Td/TT series progress (RHU-confirmed rule, unchanged):
        // the next eligible dose follows the highest approved dose recorded.
        $seriesNextDose = MaternalVaccination::nextEligibleDose($mother->id);
        $seriesTotal = count(MaternalVaccination::DOSES);
        $seriesRecorded = $seriesNextDose === null
            ? $seriesTotal
            : (int) array_search($seriesNextDose, MaternalVaccination::DOSES, true);

        return view(
            'mother.vaccinations',
            compact(
                'mother',
                'infants',
                'vaccinations',
                'maternalVaccinations',
                'infantStatus',
                'maternalStatus',
                'infantSummary',
                'maternalSummary',
                'seriesNextDose',
                'seriesTotal',
                'seriesRecorded'
            )
        );
    }
}
