<?php

namespace App\Http\Controllers\Mother;



use App\Http\Controllers\Controller;
use App\Models\Infant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaternalVaccination;

class MotherPrintRecordsController extends Controller
{
    /**
     * Printable categories, in document order. Emergency Contact is hidden
     * for now: the mothers table has no emergency contact fields.
     */
    private const CATEGORIES = [
        'personal',
        'maternal',
        'prenatal',
        'infant',
        'vaccinations',
    ];

    /**
     * Display the centralized print-records page.
     */
    public function index(Request $request)
    {
        $mother = Auth::user()?->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        // Only retrieve infants belonging to the logged-in mother.
        $infants = $mother->infants()
            ->orderBy('first_name')
            ->get(['id', 'mother_id', 'first_name', 'middle_name', 'last_name', 'sex', 'birth_date', 'birth_weight', 'birth_length', 'head_circumference', 'birth_status']);

        $allowedCategories = self::CATEGORIES;

        $requestedCategories = $request->input('categories');

        if ($requestedCategories === null) {
            // Show all categories on the initial page.
            $selectedCategories = $allowedCategories;
        } else {
            $requested = is_array($requestedCategories) ? $requestedCategories : [];

            // Keep document order; ignore unknown or hidden categories.
            $selectedCategories = array_values(array_filter(
                $allowedCategories,
                fn ($category) => in_array($category, $requested, true)
            ));
        }

        // Selected infant: only one of this mother's own children. An infant
        // that is not hers (or no longer available) is never replaced by
        // another child; the page shows a notice instead.
        $selectedInfant = null;
        $infantNotice = null;

        if ($request->filled('infant')) {
            $selectedInfant = $infants->firstWhere('id', (int) $request->input('infant'));

            if (!$selectedInfant) {
                $infantNotice = 'The selected child record is not available. Please choose one of your children from the list.';
            }
        } else {
            // No child chosen yet: start with the first of her children.
            $selectedInfant = $infants->first();
        }

        // Only the columns the printout shows (staff-only fields are not loaded).
        $vaccinations = $selectedInfant
            ? $selectedInfant->vaccinations()
                ->reorder()
                ->orderByDesc('date_given')
                ->orderByDesc('id')
                ->get(['id', 'infant_id', 'vaccine_name', 'dose', 'date_given', 'next_due_date'])
            : collect();

        // Maternal vaccinations, newest dose administered first.
        $maternalVaccinations = MaternalVaccination::where('mother_id', $mother->id)
            ->orderByDesc('date_given')
            ->orderByDesc('id')
            ->get(['id', 'mother_id', 'vaccine_name', 'dose', 'date_given', 'next_due_date']);

        $growthRecords = $selectedInfant
            ? $selectedInfant->growthMonitorings()
                ->get(['id', 'infant_id', 'date_measured', 'age_in_months', 'weight', 'height', 'head_circumference', 'remarks'])
            : collect();

        // Prenatal visits (newest first); maternal condition and notes are not loaded.
        $prenatalCheckups = $mother->prenatalCheckups()
            ->orderByDesc('visit_date')
            ->orderByDesc('id')
            ->get(['id', 'mother_id', 'visit_date', 'gestational_age_weeks', 'weight', 'systolic_bp', 'diastolic_bp', 'fundal_height', 'fetal_heart_rate', 'fetal_movement', 'urine_protein', 'urine_glucose', 'next_visit_date']);

        return view('mother.print-records', compact(
            'mother',
            'infants',
            'selectedInfant',
            'infantNotice',
            'selectedCategories',
            'allowedCategories',
            'vaccinations',
            'maternalVaccinations',
            'prenatalCheckups',
            'growthRecords'
        ));
    }
}
