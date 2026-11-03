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
     * Display the centralized print-records page.
     */
    public function index(Request $request)
    {
        $mother = Auth::user()?->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        // Only retrieve infants belonging to the logged-in mother.
        $infants = $mother->infants()
            ->orderBy('first_name')
            ->get();

        $allowedCategories = [
            'personal',
            'maternal',
            'emergency',
            'prenatal',
            'infant',
            'vaccinations',
        ];

        $requestedCategories = $request->input('categories');

        if ($requestedCategories === null) {
            // Show all categories on the initial page.
            $selectedCategories = $allowedCategories;
        } else {
            $selectedCategories = collect(
                is_array($requestedCategories) ? $requestedCategories : []
            )
                ->filter(fn ($category) => in_array(
                    $category,
                    $allowedCategories,
                    true
                ))
                ->unique()
                ->values()
                ->all();
        }

        $selectedInfant = null;

        if ($request->filled('infant')) {
            $selectedInfant = $infants->firstWhere(
                'id',
                (int) $request->input('infant')
            );
        }

        // Default to the mother's first infant if none was selected.
        if (!$selectedInfant) {
            $selectedInfant = $infants->first();
        }

        $vaccinations = $selectedInfant
            ? $selectedInfant->vaccinations
            : collect();

            // Retrieve maternal vaccination records for the logged-in mother.
$maternalVaccinations = MaternalVaccination::where(
    'mother_id',
    $mother->id
)
    ->latest()
    ->get();

        $growthRecords = $selectedInfant
            ? $selectedInfant->growthMonitorings
            : collect();

            // Retrieve prenatal visit records belonging to the logged-in mother.
$prenatalCheckups = $mother->prenatalCheckups()
    ->orderByDesc('visit_date')
    ->get();

        return view('mother.print-records', compact(
            'mother',
            'infants',
            'selectedInfant',
            'selectedCategories',
            'allowedCategories',
            'vaccinations',
             'maternalVaccinations',
             'prenatalCheckups',
            'growthRecords'
        ));
    }
}