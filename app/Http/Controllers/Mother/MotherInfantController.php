<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Infant;

class MotherInfantController extends Controller
{
   public function index()
{
    $mother = Auth::user()->mother;

    $infants = Infant::where(
        'mother_id',
        $mother->id
    )->latest()->get();

    $selectedInfantId = request('infant');

    $selectedInfant = $selectedInfantId
        ? $infants->where('id', $selectedInfantId)->first()
        : $infants->first();

        $vaccinations = $selectedInfant
    ? $selectedInfant->vaccinations
    : collect();

$growthRecords = $selectedInfant
    ? $selectedInfant->growthMonitorings
    : collect();

    return view(
        'mother.infant-records',
       compact(
    'mother',
    'infants',
    'selectedInfant',
    'vaccinations',
    'growthRecords'
)
    );
}
    }
