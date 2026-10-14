<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMotherRequest;
use App\Http\Requests\UpdateMotherRequest;
use App\Models\Appointment;
use App\Models\Infant;
use App\Models\Mother;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MotherController extends Controller
{
    /**
     * Display a listing of mothers.
     */
    public function index(): View
    {
        $search = request('search');
        $status = request('status');

        // Dashboard statistics
        $totalMothers = Mother::count();

        $pregnantMothers = Mother::where('status', 'Pregnant')->count();

        $deliveredMothers = Mother::where('status', 'Delivered')->count();

        $referredMothers = Mother::where('status', 'Referred')->count();

        $totalInfants = Infant::count();

        $upcomingAppointments = Appointment::where('status', 'Scheduled')
            ->whereDate('appointment_date', '>=', today())
            ->count();

        // Search and status filters
        $mothers = Mother::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('mother_code', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('barangay', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($status && $status !== 'All', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('admin.mothers.index', compact(
            'mothers',
            'search',
            'status',
            'totalMothers',
            'pregnantMothers',
            'deliveredMothers',
            'referredMothers',
            'totalInfants',
            'upcomingAppointments'
        ));
    }

    /**
     * Show the form for creating a new mother.
     */
    public function create(): View
    {
        return view('admin.mothers.create');
    }

    /**
     * Store a newly created mother and linked user account.
     */
    public function store(
        StoreMotherRequest $request,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $mother = DB::transaction(function () use ($request) {
            $user = User::create([
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

                'email' => null,
                'password' => Hash::make($request->password),
                'role' => 'Mother',
                'is_active' => true,
            ]);

            // Generate the mother code.
            $motherCode = 'MTH-' . str_pad(
                Mother::max('id') + 1,
                6,
                '0',
                STR_PAD_LEFT
            );

            // Create the mother profile.
            return Mother::create([
                'user_id' => $user->id,
                'mother_code' => $motherCode,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'barangay' => $request->barangay,
                'blood_type' => $request->blood_type,
                'civil_status' => $request->civil_status,
                'occupation' => $request->occupation,
                'philhealth_number' => $request->philhealth_number,
                'height' => $request->height,
                'weight' => $request->weight,
                'last_menstrual_period' => $request->last_menstrual_period,
                'expected_delivery_date' => $request->expected_delivery_date,
                'pregnancy_number' => $request->pregnancy_number,
                'status' => 'Pregnant',
            ]);
        });

        // Log only after the enrollment transaction succeeds.
        $activityLogger->log(
            'created',
            'Mother Management',
            "Registered a mother profile (code: {$mother->mother_code}).",
            $mother->id
        );

        return redirect()
            ->route('mothers.index')
            ->with('success', 'Mother registered successfully!');
    }

    /**
     * Display the specified mother.
     */
    public function show(string $id): View
    {
        $mother = Mother::with([
            'prenatalCheckups',
            'appointments',
            'infants',
        ])->findOrFail($id);

        return view('admin.mothers.show', compact('mother'));
    }

    /**
     * Show the form for editing the specified mother.
     */
    public function edit(string $id): View
    {
        $mother = Mother::findOrFail($id);

        return view('admin.mothers.edit', compact('mother'));
    }

    /**
     * Update the specified mother.
     */
    public function update(
        UpdateMotherRequest $request,
        string $id,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $mother = Mother::findOrFail($id);

        DB::transaction(function () use ($mother, $request) {
            // Update the linked user account.
            $mother->user->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'contact_number' => $request->contact_number,

                'name' => trim(
                    $request->first_name . ' ' .
                    ($request->middle_name ? $request->middle_name . ' ' : '') .
                    $request->last_name
                ),
            ]);

            // Update the mother profile.
            $mother->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'barangay' => $request->barangay,
                'blood_type' => $request->blood_type,
                'civil_status' => $request->civil_status,
                'occupation' => $request->occupation,
                'philhealth_number' => $request->philhealth_number,
                'height' => $request->height,
                'weight' => $request->weight,
                'last_menstrual_period' => $request->last_menstrual_period,
                'expected_delivery_date' => $request->expected_delivery_date,
                'pregnancy_number' => $request->pregnancy_number,
                'status' => $request->status,
            ]);
        });

        $activityLogger->log(
            'updated',
            'Mother Management',
            "Updated a mother profile (code: {$mother->mother_code}).",
            $mother->id
        );

        return redirect()
            ->route('mothers.index')
            ->with('success', 'Mother updated successfully!');
    }

    /**
     * Permanently delete the specified mother and related records.
     */
    public function destroy(
        string $id,
        ActivityLogger $activityLogger
    ): RedirectResponse {
        $mother = Mother::findOrFail($id);

        // Keep the reference before deleting the profile.
        $motherCode = $mother->mother_code;
        $motherId = $mother->id;

        DB::transaction(function () use ($mother) {
            $mother->smsNotifications()->delete();
            $mother->appointments()->delete();
            $mother->prenatalCheckups()->delete();
            $mother->medicalLogs()->delete();
            $mother->infants()->delete();
            $mother->user()->delete();
            $mother->delete();
        });

        // Record the deletion after the transaction succeeds.
        $activityLogger->log(
            'deleted',
            'Mother Management',
            "Deleted a mother profile (code: {$motherCode}).",
            $motherId
        );

        return redirect()
            ->route('mothers.index')
            ->with('success', 'Mother deleted successfully!');
    }
}