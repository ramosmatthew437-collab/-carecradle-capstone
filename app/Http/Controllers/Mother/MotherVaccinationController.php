<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Vaccination;
use App\Models\MaternalVaccination;

class MotherVaccinationController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        if (!$mother) {
            abort(403, 'Mother profile not found.');
        }

        // Existing infant vaccination records — preserved.
        $vaccinations = Vaccination::whereHas(
            'infant',
            function ($query) use ($mother) {
                $query->where('mother_id', $mother->id);
            }
        )
        ->latest()
        ->paginate(10);

        // New maternal vaccination records.
        $maternalVaccinations = MaternalVaccination::where(
            'mother_id',
            $mother->id
        )
        ->latest()
        ->get();

        return view(
            'mother.vaccinations',
            compact(
                'mother',
                'vaccinations',
                'maternalVaccinations'
            )
        );
    }
}