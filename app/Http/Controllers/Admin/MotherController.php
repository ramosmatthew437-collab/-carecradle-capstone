<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mother;
use App\Models\User;
use App\Http\Requests\StoreMotherRequest;
use App\Http\Requests\UpdateMotherRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Infant;
use App\Models\Appointment;

class MotherController extends Controller
{
    /**
     * Display a listing of mothers.
     */
    public function index()
    {
        $search = request('search');

    // Dashboard Statistics (Always Total Records)
$totalMothers = Mother::count();

$pregnantMothers = Mother::where('status', 'Pregnant')->count();

$totalInfants = Infant::count();

$upcomingAppointments = Appointment::where('status', 'Scheduled')
    ->whereDate('appointment_date', '>=', today())
    ->count();

    // Search Results
    $mothers = Mother::query()

        ->when($search, function ($query) use ($search) {

            $query->where('mother_code', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('middle_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('barangay', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");

        })

        ->latest()
        ->get();
return view('admin.mothers.index', compact(
    'mothers',
    'search',
    'totalMothers',
    'pregnantMothers',
    'totalInfants',
    'upcomingAppointments'
));
    }

    /**
     * Show the form for creating a new mother.
     */
    public function create()
    {
        return view('admin.mothers.create');
    }

    /**
     * Store a newly created mother.
     */
    public function store(StoreMotherRequest $request)
    {
         DB::transaction(function () use ($request) {

        // Create Mother User Account
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

        // Generate Mother Code
        $motherCode = 'MTH-' . str_pad(
            Mother::max('id') + 1,
            6,
            '0',
            STR_PAD_LEFT
        );

        // Create Mother Profile
        Mother::create([

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

    return redirect()
        ->route('mothers.index')
        ->with('success', 'Mother registered successfully!');
    }

    /**
     * Display the specified mother.
     */
    public function show(string $id)
    {
         $mother = Mother::with([

        'prenatalCheckups',

        'appointments',

        'infants'

    ])->findOrFail($id);

    return view('admin.mothers.show', compact('mother'));
    }

    /**
     * Show the form for editing the specified mother.
     */
    public function edit(string $id)
    {
         $mother = Mother::findOrFail($id);

    return view('admin.mothers.edit', compact('mother'));
    }

    /**
     * Update the specified mother.
     */
    public function update(UpdateMotherRequest $request, string $id)
    {
         $mother = Mother::findOrFail($id);

    // Update the linked user account
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

    // Update mother profile
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

    return redirect()
        ->route('mothers.index')
        ->with('success', 'Mother updated successfully!');
    }

    /**
     * Remove the specified mother.
     */
    public function destroy(string $id)
    {
          $mother = Mother::findOrFail($id);

    DB::transaction(function () use ($mother) {

        // Delete SMS Notifications
        $mother->smsNotifications()->delete();

        // Delete Appointments
        $mother->appointments()->delete();

        // Delete Prenatal Visits
        $mother->prenatalCheckups()->delete();

        // Delete Medical Logs
        $mother->medicalLogs()->delete();

        // Delete Infants
        $mother->infants()->delete();

        // Delete linked User Account
        $mother->user()->delete();

        // Finally delete Mother
        $mother->delete();

    });

    return redirect()
        ->route('mothers.index')
        ->with('success', 'Mother deleted successfully!');
    }
}