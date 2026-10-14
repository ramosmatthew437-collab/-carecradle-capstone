<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrivacyConsentController extends Controller
{
    /**
     * Display the privacy notice and consent page.
     */
    public function show(): View
    {
        return view('privacy.consent');
    }

    /**
     * Record the Mother's consent.
     */
    public function accept(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$user->isMother() || !$user->mother) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'privacy_consent' => ['required', 'accepted'],
        ]);

        $user->mother->update([
            'privacy_consent' => true,
            'privacy_consent_at' => now(),
        ]);

        return redirect()
            ->route('mother.dashboard')
            ->with('status', 'privacy-consent-accepted');
    }

    /**
     * Cancel consent and log the Mother out.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$user->isMother()) {
            abort(403, 'Unauthorized access.');
        }

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'privacy-consent-cancelled');
    }
}
