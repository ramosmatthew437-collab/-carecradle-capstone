<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreMidwifeRequest;
use App\Http\Requests\UpdateMidwifeRequest;
use App\Models\Infant;
use App\Models\Appointment;

class MidwifeController extends Controller
{
    /**
     * Display a listing of the midwives.
     */
    public function index()
    {
        $search = request('search');

    // Dashboard Statistics
    $totalMidwives = User::where('role', 'Midwife')->count();
    $activeMidwives = User::where('role', 'Midwife')
        ->where('is_active', true)
        ->count();

    $inactiveMidwives = User::where('role', 'Midwife')
        ->where('is_active', false)
        ->count();

    // Search Results
    $midwives = User::where('role', 'Midwife')

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

            });

        })

        ->latest()
        ->get();

    return view('admin.midwives.index', compact(
        'midwives',
        'search',
        'totalMidwives',
        'activeMidwives',
        'inactiveMidwives'
    ));
    }

    /**
     * Show the form for creating a new midwife.
     */
    public function create()
    {
        return view('admin.midwives.create');
    }

    /**
     * Store a newly created midwife in storage.
     */
   public function store(StoreMidwifeRequest $request)
{
    User::create([

        'username' => $request->username,

        'first_name' => $request->first_name,

        'middle_name' => $request->middle_name,

        'last_name' => $request->last_name,

        'contact_number' => $request->contact_number,

        'name' => trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name
        ),

        'email' => $request->email,

        'password' => Hash::make($request->password),

        'role' => 'Midwife',

        'is_active' => true,

    ]);

    return redirect()
        ->route('midwives.index')
        ->with('success', 'Midwife added successfully!');
}

    /**
     * Display the specified midwife.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified midwife.
     */
    public function edit(string $id)
    {
        $midwife = User::findOrFail($id);

    return view('admin.midwives.edit', compact('midwife'));
    }

    /**
     * Update the specified midwife in storage.
     */
    public function update(UpdateMidwifeRequest $request, string $id)
    {
         $midwife = User::findOrFail($id);

    $midwife->update([

        'username' => $request->username,

        'first_name' => $request->first_name,

        'middle_name' => $request->middle_name,

        'last_name' => $request->last_name,

        'contact_number' => $request->contact_number,

        'name' => trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name
        ),

        'email' => $request->email,

    ]);

    return redirect()
        ->route('midwives.index')
        ->with('success', 'Midwife updated successfully!');
    }

    /**
     * Remove the specified midwife from storage.
     */
    public function destroy(string $id)
    {
         $midwife = User::findOrFail($id);

    $midwife->update([
        'is_active' => false,
    ]);

    return redirect()
        ->route('midwives.index')
        ->with('success', 'Midwife deactivated successfully!');
    }

    public function activate(string $id)
{
    $midwife = User::findOrFail($id);

    $midwife->update([
        'is_active' => true,
    ]);

    return redirect()
        ->route('midwives.index')
        ->with('success', 'Midwife activated successfully!');
}
}



