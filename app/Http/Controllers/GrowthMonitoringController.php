<?php

namespace App\Http\Controllers;

use App\Models\GrowthMonitoring;
use App\Models\Infant;
use Illuminate\Http\Request;

class GrowthMonitoringController extends Controller
{
    public function create(Infant $infant)
    {
        return view('growth-monitorings.create', compact('infant'));
    }

    public function store(Request $request, Infant $infant)
    {
         $validated = $request->validate([
        'date_measured' => 'required|date',
        'age_in_months' => 'required|integer|min:0',
        'weight' => 'required|numeric|min:0',
        'height' => 'required|numeric|min:0',
        'head_circumference' => 'nullable|numeric|min:0',
        'remarks' => 'nullable|string',
    ]);

    $infant->growthMonitorings()->create($validated);

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Growth record added successfully.');

    }

   public function show(GrowthMonitoring $growthMonitoring)
{
    $growthMonitoring->load('infant');

    return view('growth-monitorings.show', compact('growthMonitoring'));
}

    public function edit(GrowthMonitoring $growthMonitoring)
    {
         $growthMonitoring->load('infant');

    return view('growth-monitorings.edit', compact('growthMonitoring'));

    }

    public function update(Request $request, GrowthMonitoring $growthMonitoring)
    {
         $validated = $request->validate([
        'date_measured' => 'required|date',
        'age_in_months' => 'required|integer|min:0',
        'weight' => 'required|numeric|min:0',
        'height' => 'required|numeric|min:0',
        'head_circumference' => 'nullable|numeric|min:0',
        'remarks' => 'nullable|string',
    ]);

    $growthMonitoring->update($validated);

    return redirect()
        ->route('growth-monitorings.show', $growthMonitoring)
        ->with('success', 'Growth record updated successfully.');

    }

    public function destroy(GrowthMonitoring $growthMonitoring)
    {
         $infant = $growthMonitoring->infant;

    $growthMonitoring->delete();

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Growth record deleted successfully.');

    }
}