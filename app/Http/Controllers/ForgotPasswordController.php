<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\PasswordOtp;
use App\Models\User;
use App\Services\TextBeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    protected TextBeeService $textBeeService;

    public function __construct(TextBeeService $textBeeService)
    {
        $this->textBeeService = $textBeeService;
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW FORGOT PASSWORD PAGE
    |--------------------------------------------------------------------------
    */

    public function show()
    {
        return view('auth.forgot-password');
    }

    /*
    |--------------------------------------------------------------------------
    | SEND OTP
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $request->validate([
            'delivery_method' => ['required', 'in:email,sms'],
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        $method = $request->input('delivery_method');
        $identifier = trim($request->input('identifier'));

        /*
        |--------------------------------------------------------------------------
        | EMAIL METHOD
        |--------------------------------------------------------------------------
        */

        if ($method === 'email') {

            $email = Str::lower($identifier);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()
                    ->withErrors([
                        'identifier' => 'Please enter a valid email address.',
                    ])
                    ->withInput();
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()
                    ->withErrors([
                        'identifier' => 'No account was found with that email address.',
                    ])
                    ->withInput();
            }

            $otp = (string) random_int(100000, 999999);
            

            PasswordOtp::where('email', $email)
                ->where('verified', false)
                ->delete();

            PasswordOtp::create([
                'email' => $email,
                'channel' => 'email',
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
                'verified' => false,
            ]);

            try {
                Mail::raw(
                    "Your CareCradle password reset OTP is: {$otp}\n\n"
                    . "This OTP will expire in 5 minutes.\n\n"
                    . "If you did not request a password reset, "
                    . "you can ignore this email.",
                    function ($message) use ($email) {
                        $message
                            ->to($email)
                            ->subject('CareCradle Password Reset OTP');
                    }
                );
            } catch (\Throwable $e) {

                Log::error('CARECRADLE PASSWORD RESET EMAIL ERROR', [
                    'message' => $e->getMessage(),
                ]);

                PasswordOtp::where('email', $email)
                    ->where('channel', 'email')
                    ->where('verified', false)
                    ->delete();

                return back()
                    ->withErrors([
                        'identifier' =>
                            'We could not send the email verification code. Please try again.',
                    ])
                    ->withInput();
            }

            session([
                'email' => $email,
                'otp_channel' => 'email',
                'otp_identifier' => $identifier,
            ]);

            return redirect()
                ->route('password.otp')
                ->with(
                    'status',
                    'Verification code sent to your email address.'
                );
        }
        

        /*
        |--------------------------------------------------------------------------
        | SMS METHOD
        |--------------------------------------------------------------------------
        */

        $localPhone = $this->normalizePhilippineMobile($identifier);

        if (!$localPhone) {
            return back()
                ->withErrors([
                    'identifier' =>
                        'Please enter a valid 11-digit Philippine mobile number.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | FIND MOTHER USING REGISTERED CONTACT NUMBER
        |--------------------------------------------------------------------------
        */

        $mother = Mother::where('contact_number', $localPhone)->first();

        /*
        |--------------------------------------------------------------------------
        | SUPPORT +63 FORMAT STORED IN DATABASE
        |--------------------------------------------------------------------------
        */

        if (!$mother) {

            $internationalPhone = '+63' . substr($localPhone, 1);

            $mother = Mother::where(
                'contact_number',
                $internationalPhone
            )->first();
        }

        /*
        |--------------------------------------------------------------------------
        | NO REGISTERED NUMBER
        |--------------------------------------------------------------------------
        */

        if (!$mother) {
            return back()
                ->withErrors([
                    'identifier' =>
                        'No account was found with that registered mobile number.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | GET LINKED USER ACCOUNT
        |--------------------------------------------------------------------------
        */

        $user = $mother->user;

        if (!$user && $mother->user_id) {
            $user = User::find($mother->user_id);
        }

        if (!$user) {
            return back()
                ->withErrors([
                    'identifier' =>
                        'This mobile number is registered, but it is not connected to a valid account.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | MAKE SURE THIS IS A MOTHER ACCOUNT
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'Mother') {
            return back()
                ->withErrors([
                    'identifier' =>
                        'This mobile number is not connected to a valid Mother account.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | MAKE SURE USER HAS AN EMAIL
        |--------------------------------------------------------------------------
        |
        | The email is used internally to associate the OTP
        | with the correct CareCradle account.
        |
        */

        if (!$user->email) {
            return back()
                ->withErrors([
                    'identifier' =>
                        'This Mother account does not have a valid email address.',
                ])
                ->withInput();
        }

        $email = Str::lower(trim($user->email));

        /*
        |--------------------------------------------------------------------------
        | GENERATE OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);
        

        /*
        |--------------------------------------------------------------------------
        | DELETE PREVIOUS OTP
        |--------------------------------------------------------------------------
        */

        PasswordOtp::where('email', $email)
            ->where('verified', false)
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | SEND SMS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | We send to $mother->contact_number resolved from the database,
        | not to an old hardcoded number.
        |
        */

        $smsRecipient = $mother->contact_number;

        if (str_starts_with($smsRecipient, '+63')) {
            $smsRecipient = '0' . substr($smsRecipient, 3);
        }

        $result = $this->textBeeService->send(
            $smsRecipient,
            "CareCradle password reset OTP: {$otp}. "
            . "This code expires in 5 minutes. "
            . "If you did not request this, ignore this message."
        );

        /*
        |--------------------------------------------------------------------------
        | HANDLE SMS FAILURE
        |--------------------------------------------------------------------------
        */

        if (!$result['success']) {

            Log::error('CARECRADLE PASSWORD RESET SMS ERROR', [
                'user_id' => $user->id,
                'mother_id' => $mother->id,
                'phone' => $smsRecipient,
                'error' => $result['error'] ?? 'Unknown TextBee error.',
            ]);

            return back()
                ->withErrors([
                    'identifier' =>
                        'We could not send the SMS verification code. Please try again.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE OTP AFTER SUCCESSFUL SMS
        |--------------------------------------------------------------------------
        */

        PasswordOtp::create([
            'email' => $email,
            'channel' => 'sms',
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
            'verified' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MASK PHONE NUMBER
        |--------------------------------------------------------------------------
        */

        $maskedPhone =
            substr($smsRecipient, 0, 4)
            . '•••••'
            . substr($smsRecipient, -2);

        /*
        |--------------------------------------------------------------------------
        | STORE RESET INFORMATION
        |--------------------------------------------------------------------------
        */

        session([
            'email' => $email,
            'otp_channel' => 'sms',
            'otp_identifier' => $identifier,
            'otp_recipient' => $maskedPhone,
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO OTP PAGE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('password.otp')
            ->with(
                'status',
                'Verification code sent to your registered mobile number.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE PHILIPPINE MOBILE NUMBER
    |--------------------------------------------------------------------------
    */

    private function normalizePhilippineMobile(string $phone): ?string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '63')) {
            $phone = '0' . substr($phone, 2);
        }

        if (!preg_match('/^09\d{9}$/', $phone)) {
            return null;
        }

        return $phone;
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'identifier' =>
                        'Your password reset session has expired. Please request a new OTP.',
                ]);
        }

        $passwordOtp = PasswordOtp::where('email', $email)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$passwordOtp) {
            return back()
                ->withErrors([
                    'otp' =>
                        'No active verification code was found. Please request a new OTP.',
                ]);
        }

        if ($passwordOtp->expires_at->isPast()) {

            $passwordOtp->delete();

            return back()
                ->withErrors([
                    'otp' =>
                        'This verification code has expired. Please request a new OTP.',
                ]);
        }

        if ($passwordOtp->attempts >= 5) {

            $passwordOtp->delete();

            return back()
                ->withErrors([
                    'otp' =>
                        'Too many incorrect attempts. Please request a new OTP.',
                ]);
        }

        if ($passwordOtp->otp !== $request->otp) {

            $passwordOtp->increment('attempts');

            return back()
                ->withErrors([
                    'otp' => 'The verification code is incorrect.',
                ])
                ->withInput();
        }

        $passwordOtp->update([
            'verified' => true,
        ]);

        session([
            'email' => $email,
            'otp_channel' => $passwordOtp->channel,
        ]);

        $verificationMessage =
            $passwordOtp->channel === 'sms'
                ? 'Mobile number verified. You can now create a new password.'
                : 'Email verified. You can now create a new password.';

        return redirect()
            ->route('password.reset')
            ->with('status', $verificationMessage);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW RESET PASSWORD PAGE
    |--------------------------------------------------------------------------
    */

    public function showResetPassword(Request $request)
    {
        $email = session('email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'identifier' =>
                        'Please request a password reset first.',
                ]);
        }

        return view('auth.reset-password');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => [
    'required',
    'confirmed',
    Rules\Password::defaults(),
],
        ]);

        $email = session('email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'identifier' =>
                        'Your password reset session is invalid. Please request a new OTP.',
                ]);
        }

        $passwordOtp = PasswordOtp::where('email', $email)
            ->where('verified', true)
            ->latest()
            ->first();

        if (!$passwordOtp) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'identifier' =>
                        'Your password reset session is invalid. Please request a new OTP.',
                ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'identifier' => 'No account was found.',
                ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $passwordOtp->delete();

        session()->forget([
            'email',
            'otp_channel',
            'otp_identifier',
            'otp_recipient',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Your password has been reset successfully. You can now log in with your new password.'
            );
    }
}