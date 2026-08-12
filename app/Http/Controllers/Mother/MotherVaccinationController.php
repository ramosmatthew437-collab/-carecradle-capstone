<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Vaccination;

class MotherVaccinationController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        $vaccinations = Vaccination::whereHas(
            'infant',
            function ($query) use ($mother) {
                $query->where('mother_id', $mother->id);
            }
        )
        ->latest()
        ->paginate(10);

        return view(
            'mother.vaccinations',
            compact(
                'mother',
                'vaccinations'
            )
        );
    }
}