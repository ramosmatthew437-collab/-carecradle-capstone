<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\PrenatalCheckup;
use App\Http\Requests\StorePrenatalCheckupRequest;
use Illuminate\Support\Facades\Storage;

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
     * Store a newly created prenatal visit and its attachments.
     */
    public function store(
        StorePrenatalCheckupRequest $request,
        Mother $mother
    ) {
        $prenatalCheckup = $mother->prenatalCheckups()->create([
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

        $this->storeLaboratoryAttachments($request, $prenatalCheckup);

        return redirect()
            ->route('mothers.show', $mother->id)
            ->with('success', 'Prenatal visit added successfully!');
    }

    /**
     * Display the specified prenatal visit.
     */
    public function show(PrenatalCheckup $prenatalCheckup)
    {
        $prenatalCheckup->load([
            'mother',
            'attachments',
        ]);

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
        $prenatalCheckup->load([
            'mother',
            'attachments',
        ]);

        return view(
            'prenatal-checkups.edit',
            compact('prenatalCheckup')
        );
    }

    /**
     * Update the prenatal visit and add new attachments.
     */
    public function update(
        StorePrenatalCheckupRequest $request,
        PrenatalCheckup $prenatalCheckup
    ) {
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

        $this->storeLaboratoryAttachments($request, $prenatalCheckup);

        return redirect()
            ->route('prenatal-checkups.show', $prenatalCheckup->id)
            ->with('success', 'Prenatal visit updated successfully!');
    }

    /**
     * Store uploaded laboratory documents privately.
     */
    private function storeLaboratoryAttachments(
        StorePrenatalCheckupRequest $request,
        PrenatalCheckup $prenatalCheckup
    ): void {
        $files = $request->file('laboratory_attachments', []);

        foreach ($files as $file) {
            $path = $file->store(
                'prenatal-laboratory-results',
                'local'
            );

            $prenatalCheckup->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    /**
     * Remove the prenatal visit and its stored documents.
     */
    public function destroy(PrenatalCheckup $prenatalCheckup)
    {
        $motherId = $prenatalCheckup->mother_id;

        foreach ($prenatalCheckup->attachments as $attachment) {
            Storage::disk('local')->delete($attachment->file_path);
        }

        $prenatalCheckup->delete();

        return redirect()
            ->route('mothers.show', $motherId)
            ->with('success', 'Prenatal visit deleted successfully.');
    }
}