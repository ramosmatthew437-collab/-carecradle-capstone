<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SmsNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public const MOTHER_CLOSURE_MESSAGE = 'Mother accounts cannot be deleted from the Mother Portal. To close or deactivate your account, please contact an authorized RHU administrator. Your maternal health records are kept by the Rural Health Unit.';

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the signed-in user's own profile information.
     * Nothing is sent by SMS or email here.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        DB::transaction(function () use ($request, $user) {
            if ($user->isMother() && $user->mother) {
                $user->fill([
                    'name' => $request->validated('name'),
                    'email' => $request->validated('email'),
                ]);
            } else {
                // Staff: the display name is built from the name parts, the
                // same way Midwife Management builds it.
                $first = $request->validated('first_name');
                $middle = $request->validated('middle_name');
                $last = $request->validated('last_name');

                $user->fill([
                    'first_name' => $first,
                    'middle_name' => $middle,
                    'last_name' => $last,
                    'name' => trim($first . ' ' . ($middle ? $middle . ' ' : '') . $last),
                    'email' => $request->validated('email'),
                    'contact_number' => $request->validated('contact_number'),
                ]);
            }

            // Reset email verification if the email was changed
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Mother accounts: the registered mobile number lives on the Mother
            // record (used for SMS reminders and SMS password recovery). The
            // copy kept on the user account at registration is updated to the
            // same value so the two never disagree.
            if ($user->isMother() && $user->mother) {
                $mother = $user->mother;
                $number = $request->validated('contact_number');
                $changed = $mother->contact_number !== $number;

                $mother->update(['contact_number' => $number]);
                $user->contact_number = $number;

                // Reminders of THIS mother that have not been sent yet will go
                // to the new number. Sent and Failed notifications keep the
                // number they were sent to. Nothing is sent here.
                if ($changed) {
                    SmsNotification::where('mother_id', $mother->id)
                        ->where('status', 'Pending')
                        ->update(['recipient_number' => $number]);
                }
            }

            $user->save();
        });

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * Mother accounts cannot delete themselves: deleting the account would
     * cascade to the Mother record and its clinical history (prenatal visits,
     * appointments, infants, vaccinations, SMS records). Account closure for
     * mothers is handled by an authorized RHU administrator. Administrator and
     * Midwife deletion is unchanged (no clinical records reference them).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isMother() || $user->mother()->exists()) {
            abort(403, self::MOTHER_CLOSURE_MESSAGE);
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
