<?php

namespace App\Http\Controllers;

use App\Models\Infant;
use App\Models\Mother;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InfantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the infant registration form.
     */
    public function create(Mother $mother): View
    {
        return view('infants.create', compact('mother'));
    }

    /**
     * Store a newly registered infant.
     */
    public function store(
        Request $request,
        Mother $mother,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'birth_weight' => 'required|numeric|min:0',
            'birth_length' => 'required|numeric|min:0',
            'head_circumference' => 'nullable|numeric|min:0',
            'birth_status' => 'required|in:Alive,Stillbirth',
            'remarks' => 'nullable|string',
        ]);

        $infant = $mother->infants()->create($validated);

        $motherReference = $mother->mother_code ?: "Mother record #{$mother->id}";

        $activityLogger->log(
            'created',
            'Infant Management',
            "Registered an infant profile linked to {$motherReference}.",
            $infant->id
        );

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Infant registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Infant $infant): View
    {
        $infant->load([
            'mother',
            'growthMonitorings',
        ]);

        return view('infants.show', compact('infant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infant $infant): View
    {
        $infant->load('mother');

        return view('infants.edit', compact('infant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Infant $infant,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'birth_weight' => 'required|numeric|min:0',
            'birth_length' => 'required|numeric|min:0',
            'head_circumference' => 'nullable|numeric|min:0',
            'birth_status' => 'required|in:Alive,Stillbirth',
            'remarks' => 'nullable|string',
        ]);

        $mother = $infant->mother;
        $motherReference = $mother
            ? ($mother->mother_code ?: "Mother record #{$mother->id}")
            : 'an unavailable mother record';

        $infant->update($request->only([
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'birth_date',
            'birth_weight',
            'birth_length',
            'head_circumference',
            'birth_status',
            'remarks',
        ]));

        $activityLogger->log(
            'updated',
            'Infant Management',
            "Updated an infant profile linked to {$motherReference}.",
            $infant->id
        );

        return redirect()
            ->route('infants.show', $infant)
            ->with('success', 'Infant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Infant $infant,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $mother = $infant->mother;

        // Keep the reference before deleting the infant.
        $infantId = $infant->id;
        $motherReference = $mother
            ? ($mother->mother_code ?: "Mother record #{$mother->id}")
            : 'an unavailable mother record';

        $infant->delete();

        $activityLogger->log(
            'deleted',
            'Infant Management',
            "Deleted an infant profile linked to {$motherReference}.",
            $infantId
        );

        if ($mother) {
            return redirect()
                ->route('mothers.show', $mother)
                ->with('success', 'Infant record deleted successfully!');
        }

        return redirect()
            ->route('mothers.index')
            ->with('success', 'Infant record deleted successfully!');
    }
}