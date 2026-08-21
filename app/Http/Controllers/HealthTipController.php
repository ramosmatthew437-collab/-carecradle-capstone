<?php

namespace App\Http\Controllers;

use App\Models\HealthTip;

class HealthTipController extends Controller
{
    public function index()
    {
        $tips = HealthTip::latest()->get();

        return view('health-tips.index', compact('tips'));
    }

    public function show(HealthTip $healthTip)
    {
        return view('health-tips.show', compact('healthTip'));
    }
}