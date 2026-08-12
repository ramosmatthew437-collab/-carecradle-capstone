<?php

namespace App\Http\Controllers;

use App\Models\Infant;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function create(Infant $infant)
    {
        return view('vaccinations.create', compact('infant'));
    }

    public function store(Request $request, Infant $infant)
    {
  $validated = $request->validate([
        'vaccine_name' => 'required|string|max:255',
        'dose' => 'required|string|max:255',
        'date_given' => 'required|date',
        'next_due_date' => 'nullable|date',
        'administered_by' => 'required|string|max:255',
        'remarks' => 'nullable|string',
    ]);

    $infant->vaccinations()->create($validated);

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Vaccination record added successfully.');
    }

    public function show(Vaccination $vaccination)
    {
        $vaccination->load('infant');

    return view('vaccinations.show', compact('vaccination'));

    }

    public function edit(Vaccination $vaccination)
    {
         $vaccination->load('infant');

    return view('vaccinations.edit', compact('vaccination'));
    }

    public function update(Request $request, Vaccination $vaccination)
    {
         $validated = $request->validate([
        'vaccine_name' => 'required|string|max:255',
        'dose' => 'required|string|max:255',
        'date_given' => 'required|date',
        'next_due_date' => 'nullable|date',
        'administered_by' => 'required|string|max:255',
        'remarks' => 'nullable|string',
    ]);

    $vaccination->update($validated);

    return redirect()
        ->route('vaccinations.show', $vaccination)
        ->with('success', 'Vaccination record updated successfully.');

    }

    public function destroy(Vaccination $vaccination)
    {
           $infant = $vaccination->infant;

    $vaccination->delete();

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Vaccination record deleted successfully.');

    }
}