<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePrivacyConsent
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user &&
            $user->isMother() &&
            $user->mother &&
            !$user->mother->privacy_consent_at &&
            !$request->routeIs(
                'privacy.consent',
                'privacy.consent.accept',
                'privacy.consent.cancel'
            )
        ) {
            return redirect()->route('privacy.consent');
        }

        return $next($request);
    }
}