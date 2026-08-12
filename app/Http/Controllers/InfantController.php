<?php

namespace App\Http\Controllers;

use App\Models\Infant;
use App\Models\Mother;
use Illuminate\Http\Request;

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
public function create(Mother $mother)
{
    return view('infants.create', compact('mother'));
}

  /**
 * Store a newly registered infant.
 */
public function store(Request $request, Mother $mother)
{
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

    $mother->infants()->create([

        'first_name' => $request->first_name,

        'middle_name' => $request->middle_name,

        'last_name' => $request->last_name,

        'sex' => $request->sex,

        'birth_date' => $request->birth_date,

        'birth_weight' => $request->birth_weight,

        'birth_length' => $request->birth_length,

        'head_circumference' => $request->head_circumference,

        'birth_status' => $request->birth_status,

        'remarks' => $request->remarks,

    ]);

    return redirect()
        ->route('mothers.show', $mother->id)
        ->with('success', 'Infant registered successfully!');
}

    /**
     * Display the specified resource.
     */
  public function show(Infant $infant)
{
    $infant->load([
        'mother',
        'growthMonitorings'
    ]);

    return view('infants.show', compact('infant'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Infant $infant)
{
     $infant->load('mother');

    return view('infants.edit', compact('infant'));
}

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Infant $infant)
{
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

    return redirect()
        ->route('infants.show', $infant)
        ->with('success', 'Infant updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Infant $infant)
{
    $mother = $infant->mother;

    $infant->delete();

    return redirect()
        ->route('mothers.show', $mother)
        ->with('success', 'Infant record deleted successfully!');
}
}
