<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PrenatalCheckup;

class MotherPrenatalController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        $prenatalRecords = PrenatalCheckup::where(
            'mother_id',
            $mother->id
        )
        ->latest()
        ->paginate(10);

        return view(
            'mother.prenatal-records',
            compact(
                'mother',
                'prenatalRecords'
            )
        );
    }
}