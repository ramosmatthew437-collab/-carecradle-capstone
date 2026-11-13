<?php

namespace App\Http\Controllers\Mother;

use App\Http\Controllers\Controller;
use App\Models\MotherReferral;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Mother Portal: "My Referrals" (read-only).
 *
 * - The mother is always the signed-in account's own record; no mother or
 *   referral ID is accepted from the URL or request.
 * - Only Active ("Current") and Closed referrals are shown. Referrals marked
 *   "Entered in error" are staff corrections and are never shown.
 * - Only the columns a mother may see are loaded: referral date, receiving
 *   facility, status and follow-up date. Staff names and IDs, internal notes,
 *   information source, follow-up notes, closure details and the referral
 *   reason are not queried at all. The reason and follow-up notes are written
 *   by staff as clinical documentation; until the RHU approves a way to share
 *   patient-appropriate wording, mothers are asked to contact the RHU instead.
 */
class MotherReferralController extends Controller
{
    /** Columns visible to mothers. */
    public const VISIBLE_COLUMNS = ['id', 'mother_id', 'referred_at', 'receiving_facility', 'status', 'outcome_at'];

    public function index(): View
    {
        $mother = Auth::user()?->mother;

        abort_unless($mother, 404, 'Mother profile not found.');

        $referrals = $mother->referrals()
            ->whereIn('status', [MotherReferral::ACTIVE, MotherReferral::CLOSED])
            ->get(self::VISIBLE_COLUMNS);

        return view('mother.referrals', [
            'mother' => $mother,
            'current' => $referrals->where('status', MotherReferral::ACTIVE)->values(),
            'closed' => $referrals->where('status', MotherReferral::CLOSED)->values(),
            'isLegacyReferred' => $mother->isLegacyReferred(),
        ]);
    }
}
