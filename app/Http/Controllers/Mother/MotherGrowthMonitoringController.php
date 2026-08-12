<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\GrowthMonitoring;

class MotherGrowthMonitoringController extends Controller
{
    public function index()
    {
        $mother = Auth::user()->mother;

        $growthRecords = GrowthMonitoring::whereHas('infant', function ($query) use ($mother) {
            $query->where('mother_id', $mother->id);
        })
        ->latest('date_measured')
        ->paginate(10);

        return view('mother.growth-monitoring', compact(
            'mother',
            'growthRecords'
        ));
    }
}