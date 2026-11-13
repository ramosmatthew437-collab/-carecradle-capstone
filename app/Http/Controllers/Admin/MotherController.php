<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMotherRequest;
use App\Http\Requests\UpdateMotherRequest;
use App\Models\Appointment;
use App\Models\Infant;
use App\Models\Mother;
use App\Models\SmsNotification;
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

        // Referred is derived (active referral, or an older Referred record);
        // a referred mother is still counted under her pregnancy status.
        $referredMothers = Mother::referred()->count();

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
            ->when($status === 'Referred', fn ($query) => $query->referred())
            ->when($status && ! in_array($status, ['All', 'Referred'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->withReferralFlag()
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

                'father_first_name' => $request->father_first_name,
'father_middle_name' => $request->father_middle_name,
'father_last_name' => $request->father_last_name,
'father_birth_date' => $request->father_birth_date,
'father_contact_number' => $request->father_contact_number,
'father_occupation' => $request->father_occupation,
                'philhealth_number' => $request->philhealth_number,
                'height' => $request->height,
                'weight' => $request->weight,
                'last_menstrual_period' => $request->last_menstrual_period,
                // Calculated on the server (LMP + 280 days), never taken from the browser.
                'expected_delivery_date' => $request->expectedDeliveryDate(),
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
        'maternalVaccinations',
        'referrals',
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
        $oldStatus = $mother->status;

        DB::transaction(function () use ($mother, $request) {
            $numberChanged = $mother->contact_number !== $request->contact_number;

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

                'father_first_name' => $request->father_first_name,
'father_middle_name' => $request->father_middle_name,
'father_last_name' => $request->father_last_name,
'father_birth_date' => $request->father_birth_date,
'father_contact_number' => $request->father_contact_number,
'father_occupation' => $request->father_occupation,
                'philhealth_number' => $request->philhealth_number,
                'height' => $request->height,
                'weight' => $request->weight,
                'last_menstrual_period' => $request->last_menstrual_period,
                // Existing EDD kept while the LMP is unchanged; recalculated
                // (LMP + 280 days) only when the LMP changes.
                'expected_delivery_date' => $request->expectedDeliveryDate(),
                'pregnancy_number' => $request->pregnancy_number,
                'status' => $request->status,
            ]);

            // Same rule as the Mother Portal: this mother's reminders that are
            // still Pending go to her new number. Sent and Failed notifications
            // keep the number they were sent to. Nothing is sent here.
            if ($numberChanged) {
                SmsNotification::where('mother_id', $mother->id)
                    ->where('status', 'Pending')
                    ->update(['recipient_number' => $request->contact_number]);
            }
        });

        $activityLogger->log(
            'updated',
            'Mother Management',
            "Updated a mother profile (code: {$mother->mother_code}).",
            $mother->id
        );

        if ($oldStatus !== $mother->status) {
            $label = fn (string $s) => $s === Mother::LEGACY_REFERRED ? 'Unknown (older Referred record)' : $s;
            $activityLogger->log(
                'status_changed',
                'Mother Management',
                "Pregnancy status changed from {$label($oldStatus)} to {$label($mother->status)} (code: {$mother->mother_code}).",
                $mother->id
            );
        }

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

        // Protected history: a mother with appointment records or SMS
        // notification history is never deleted, so that history (including
        // SMS delivery attempts) stays available for auditing. Nothing is
        // deleted or changed in that case.
        $hasAppointments = $mother->appointments()->exists();
        $hasSmsHistory = $mother->smsNotifications()->exists();

        if ($hasAppointments || $hasSmsHistory) {
            $kept = implode(' and ', array_filter([
                $hasAppointments ? 'appointment records' : null,
                $hasSmsHistory ? 'SMS notification history' : null,
            ]));

            return redirect()
                ->route('mothers.index')
                ->with('error', "This mother record (code: {$mother->mother_code}) cannot be permanently deleted because it has {$kept}. "
                    . 'These records are kept for the RHU\'s audit history. Nothing was deleted.');
        }

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