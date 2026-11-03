<?php

namespace App\Http\Controllers\Midwife;



use App\Http\Controllers\Controller;
use App\Models\MaternalVaccination;
use App\Models\Mother;
use Illuminate\Http\Request;

class MaternalVaccinationController extends Controller
{
    /**
     * Display the form for recording a maternal vaccination.
     */
    public function create(Mother $mother)
    {
        return view('midwife.maternal-vaccinations.create', compact('mother'));
    }

    /**
     * Store a maternal vaccination record.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'dose' => 'required|string|max:255',
            'date_given' => 'required|date|before_or_equal:today',
            'next_due_date' => 'nullable|date|after_or_equal:date_given',
            'administered_by' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $mother->maternalVaccinations()->create($validated);

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Maternal vaccination record added successfully.');
    }

    /**
     * Display the form for editing a vaccination record.
     */
    public function edit(Mother $mother, MaternalVaccination $vaccination)
    {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        return view(
            'midwife.maternal-vaccinations.edit',
            compact('mother', 'vaccination')
        );
    }

    /**
     * Update an existing vaccination record.
     */
    public function update(
        Request $request,
        Mother $mother,
        MaternalVaccination $vaccination
    ) {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        $validated = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'dose' => 'required|string|max:255',
            'date_given' => 'required|date|before_or_equal:today',
            'next_due_date' => 'nullable|date|after_or_equal:date_given',
            'administered_by' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $vaccination->update($validated);

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Maternal vaccination record updated successfully.');
    }

    /**
     * Delete a vaccination record.
     */
    public function destroy(Mother $mother, MaternalVaccination $vaccination)
    {
        $vaccination = $mother->maternalVaccinations()
            ->whereKey($vaccination->id)
            ->firstOrFail();

        $vaccination->delete();

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Maternal vaccination record deleted successfully.');
    }
}