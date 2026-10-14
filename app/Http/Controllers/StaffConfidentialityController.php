<?php

namespace App\Http\Controllers;

use App\Models\StaffConfidentialityAcknowledgment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaffConfidentialityController extends Controller
{
    private const POLICY_VERSION = '1.0';

    /**
     * Display the staff confidentiality policy.
     */
    public function show(): View
    {
        $user = request()->user();

        if (
            !$user ||
            (!$user->isMidwife() && !$user->isAdministrator())
        ) {
            abort(403, 'Unauthorized access.');
        }

        return view('staff.confidentiality');
    }

    /**
     * Save the staff member's acknowledgment.
     */
    public function accept(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Allow only authorized staff.
        if (
            !$user ||
            (!$user->isMidwife() && !$user->isAdministrator())
        ) {
            abort(403, 'Unauthorized access.');
        }

        // Require the staff member to acknowledge the policy.
        $request->validate([
            'acknowledged' => ['required', 'accepted'],
        ]);

        // Save the acknowledgment once per policy version.
        StaffConfidentialityAcknowledgment::firstOrCreate(
            [
                'user_id' => $user->id,
                'policy_version' => self::POLICY_VERSION,
            ],
            [
                'acknowledged_at' => now(),
            ]
        );

        return redirect()
            ->route('dashboard')
            ->with('status', 'staff-confidentiality-accepted');
    }
}