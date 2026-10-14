<?php

namespace App\Http\Middleware;


use App\Models\StaffConfidentialityAcknowledgment;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaffConfidentialityAcknowledgment
{
    private const POLICY_VERSION = '1.0';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Mothers and guests are not subject to staff acknowledgment.
        if (
            !$user ||
            (!$user->isMidwife() && !$user->isAdministrator())
        ) {
            return $next($request);
        }

        // Allow the acknowledgment page, submission, and logout.
        if ($request->routeIs(
            'staff.confidentiality.show',
            'staff.confidentiality.accept',
            'logout'
        )) {
            return $next($request);
        }

        $hasAcknowledged = StaffConfidentialityAcknowledgment::query()
            ->where('user_id', $user->id)
            ->where('policy_version', self::POLICY_VERSION)
            ->exists();

        if (!$hasAcknowledged) {
            return redirect()->route('staff.confidentiality.show');
        }

        return $next($request);
    }
}