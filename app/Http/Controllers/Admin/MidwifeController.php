<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMidwifeRequest;
use App\Http\Requests\UpdateMidwifeRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MidwifeController extends Controller
{
    /**
     * Display a listing of the midwives.
     */
    public function index(): View
    {
        $search = request('search');
        $status = request('status', 'all');

        // Dashboard statistics
        $totalMidwives = User::where('role', 'Midwife')->count();

        $activeMidwives = User::where('role', 'Midwife')
            ->where('is_active', true)
            ->count();

        $inactiveMidwives = User::where('role', 'Midwife')
            ->where('is_active', false)
            ->count();

        // Midwife listing with search and status filters
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
            ->when($status === 'active', function ($query) {
                $query->where('is_active', true);
            })
            ->when($status === 'inactive', function ($query) {
                $query->where('is_active', false);
            })
            ->latest()
            ->get();

        return view('admin.midwives.index', compact(
            'midwives',
            'search',
            'status',
            'totalMidwives',
            'activeMidwives',
            'inactiveMidwives'
        ));
    }

    /**
     * Show the form for creating a new midwife.
     */
    public function create(): View
    {
        return view('admin.midwives.create');
    }

    /**
     * Store a newly created midwife.
     */
    public function store(
        StoreMidwifeRequest $request,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $midwife = User::create([
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

        $activityLogger->log(
            'created',
            'Midwife Management',
            "Created a midwife account for {$midwife->name}.",
            $midwife->id
        );

        return redirect()
            ->route('midwives.index')
            ->with('success', 'Midwife added successfully!');
    }

    /**
     * Display the specified midwife.
     */
    public function show(string $id)
    {
        // Existing behavior retained.
    }

    /**
     * Show the form for editing the specified midwife.
     */
    public function edit(string $id): View
    {
        $midwife = User::where('role', 'Midwife')
            ->findOrFail($id);

        return view('admin.midwives.edit', compact('midwife'));
    }

    /**
     * Update the specified midwife.
     */
    public function update(
        UpdateMidwifeRequest $request,
        string $id,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $midwife = User::where('role', 'Midwife')
            ->findOrFail($id);

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

        $activityLogger->log(
            'updated',
            'Midwife Management',
            "Updated the account details for {$midwife->name}.",
            $midwife->id
        );

        return redirect()
            ->route('midwives.index')
            ->with('success', 'Midwife updated successfully!');
    }

    /**
     * Deactivate the specified midwife.
     */
    public function destroy(
        string $id,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $midwife = User::where('role', 'Midwife')
            ->findOrFail($id);

        if ($midwife->is_active) {
            $midwife->update([
                'is_active' => false,
            ]);

            $activityLogger->log(
                'deactivated',
                'Midwife Management',
                "Deactivated the midwife account for {$midwife->name}.",
                $midwife->id
            );
        }

        return redirect()
            ->route('midwives.index')
            ->with('success', 'Midwife deactivated successfully!');
    }

    /**
     * Activate the specified midwife.
     */
    public function activate(
        string $id,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $midwife = User::where('role', 'Midwife')
            ->findOrFail($id);

        if (! $midwife->is_active) {
            $midwife->update([
                'is_active' => true,
            ]);

            $activityLogger->log(
                'activated',
                'Midwife Management',
                "Activated the midwife account for {$midwife->name}.",
                $midwife->id
            );
        }

        return redirect()
            ->route('midwives.index')
            ->with('success', 'Midwife activated successfully!');
    }
}

