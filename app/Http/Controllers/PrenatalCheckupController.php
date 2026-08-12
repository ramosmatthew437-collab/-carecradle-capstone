<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mother;
use App\Models\PrenatalCheckup;
use App\Http\Requests\StorePrenatalCheckupRequest;


class PrenatalCheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a prenatal visit.
     */
   public function create(Mother $mother)
{
    return view('prenatal-checkups.create', compact('mother'));
}

    /**
     * Store a newly created prenatal visit.
     */
   public function store(StorePrenatalCheckupRequest $request, Mother $mother)
{
    
    $mother->prenatalCheckups()->create([

        'visit_date' => $request->visit_date,

        'gestational_age_weeks' => $request->gestational_age_weeks,

        'weight' => $request->weight,

        'systolic_bp' => $request->systolic_bp,

        'diastolic_bp' => $request->diastolic_bp,

        'fundal_height' => $request->fundal_height,

        'fetal_heart_rate' => $request->fetal_heart_rate,

        'fetal_movement' => $request->fetal_movement,

        'urine_protein' => $request->urine_protein,

        'urine_glucose' => $request->urine_glucose,

        'maternal_condition' => $request->maternal_condition,

        'notes' => $request->notes,

        'next_visit_date' => $request->next_visit_date,

    ]);

    return redirect()
        ->route('mothers.show', $mother->id)
        ->with('success', 'Prenatal visit added successfully!');
}

    /**
     * Display the specified prenatal visit.
     */
   public function show(PrenatalCheckup $prenatalCheckup)
{
   $prenatalCheckup->load('mother');

    return view(
        'prenatal-checkups.show',
        compact('prenatalCheckup')

    
    );
}

    /**
     * Show the form for editing the prenatal visit.
     */
   public function edit(PrenatalCheckup $prenatalCheckup)
{
    $prenatalCheckup->load('mother');

    return view(
        'prenatal-checkups.edit',
        compact('prenatalCheckup')
    );
}

    /**
     * Update the prenatal visit.
     */
  public function update(StorePrenatalCheckupRequest $request, PrenatalCheckup $prenatalCheckup)
{
    $prenatalCheckup->update([

        'visit_date' => $request->visit_date,

        'gestational_age_weeks' => $request->gestational_age_weeks,

        'weight' => $request->weight,

        'systolic_bp' => $request->systolic_bp,

        'diastolic_bp' => $request->diastolic_bp,

        'fundal_height' => $request->fundal_height,

        'fetal_heart_rate' => $request->fetal_heart_rate,

        'fetal_movement' => $request->fetal_movement,

        'urine_protein' => $request->urine_protein,

        'urine_glucose' => $request->urine_glucose,

        'maternal_condition' => $request->maternal_condition,

        'notes' => $request->notes,

        'next_visit_date' => $request->next_visit_date,

    ]);

    return redirect()
        ->route('prenatal-checkups.show', $prenatalCheckup->id)
        ->with('success', 'Prenatal visit updated successfully!');
}

    /**
     * Remove the prenatal visit.
     */
   public function destroy(PrenatalCheckup $prenatalCheckup)
{
    $motherId = $prenatalCheckup->mother_id;

    $prenatalCheckup->delete();

    return redirect()
        ->route('mothers.show', $motherId)
        ->with('success', 'Prenatal visit deleted successfully.');
}
}