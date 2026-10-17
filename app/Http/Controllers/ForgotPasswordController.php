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

    public function show()
    {
        return view('auth.forgot-password');
    }

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
        | EMAIL OTP
        |--------------------------------------------------------------------------
        */
        if ($method === 'email') {
            $email = Str::lower($identifier);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors([
                    'identifier' => 'Please enter a valid email address.',
                ])->withInput();
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->withErrors([
                    'identifier' => 'No account was found with that email address.',
                ])->withInput();
            }

            $otp = (string) random_int(100000, 999999);

            PasswordOtp::where('user_id', $user->id)
                ->where('channel', 'email')
                ->where('verified', false)
                ->delete();

            $passwordOtp = PasswordOtp::create([
                'user_id' => $user->id,
                'email' => $email,
                'channel' => 'email',
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'attempts' => 0,
                'verified' => false,
            ]);

            try {
                Mail::raw(
                    "Your CareCradle password reset OTP is: {$otp}\n\n"
                    . "This OTP expires in 10 minutes.\n\n"
                    . "If you did not request a password reset, ignore this email.",
                    function ($message) use ($email) {
                        $message->to($email)
                            ->subject('CareCradle Password Reset OTP');
                    }
                );
            } catch (\Throwable $e) {
                Log::error('CARECRADLE PASSWORD RESET EMAIL ERROR', [
                    'user_id' => $user->id,
                    'message' => $e->getMessage(),
                ]);

                $passwordOtp->delete();

                return back()->withErrors([
                    'identifier' =>
                        'We could not send the email verification code. Please try again.',
                ])->withInput();
            }

            session([
                'password_reset_user_id' => $user->id,
                'email' => $email,
                'otp_channel' => 'email',
                'otp_identifier' => $identifier,
                'otp_recipient' => null,
            ]);

            return redirect()->route('password.otp')
                ->with('status', 'Verification code sent to your email address.');
        }

        /*
        |--------------------------------------------------------------------------
        | SMS OTP — MOTHER ACCOUNTS
        |--------------------------------------------------------------------------
        */
        $localPhone = $this->normalizePhilippineMobile($identifier);

        if (!$localPhone) {
            return back()->withErrors([
                'identifier' => 'Please enter a valid 11-digit Philippine mobile number.',
            ])->withInput();
        }

        $mother = Mother::where('contact_number', $localPhone)->first();

        if (!$mother) {
            $internationalPhone = '+63' . substr($localPhone, 1);

            $mother = Mother::where(
                'contact_number',
                $internationalPhone
            )->first();
        }

        if (!$mother) {
            return back()->withErrors([
                'identifier' => 'No account was found with that registered mobile number.',
            ])->withInput();
        }

        $user = $mother->user;

        if (!$user && $mother->user_id) {
            $user = User::find($mother->user_id);
        }

        if (!$user) {
            return back()->withErrors([
                'identifier' =>
                    'This mobile number is registered, but it is not connected to a valid account.',
            ])->withInput();
        }

        if ($user->role !== 'Mother') {
            return back()->withErrors([
                'identifier' => 'This mobile number is not connected to a valid Mother account.',
            ])->withInput();
        }

        // Email is optional for SMS recovery. The user ID identifies the account.
        $email = filled($user->email)
            ? Str::lower(trim($user->email))
            : null;

        $otp = (string) random_int(100000, 999999);

        PasswordOtp::where('user_id', $user->id)
            ->where('channel', 'sms')
            ->where('verified', false)
            ->delete();

        $smsRecipient = $this->normalizePhilippineMobile(
            (string) $mother->contact_number
        );

        if (!$smsRecipient) {
            return back()->withErrors([
                'identifier' => 'The registered mobile number is invalid. Please contact the health worker.',
            ])->withInput();
        }

        $result = $this->textBeeService->send(
            $smsRecipient,
            "CareCradle password reset OTP: {$otp}. "
            . "This code expires in 10 minutes. "
            . "If you did not request this, ignore this message."
        );

        if (empty($result['success'])) {
            Log::error('CARECRADLE PASSWORD RESET SMS ERROR', [
                'user_id' => $user->id,
                'mother_id' => $mother->id,
                'error' => $result['error'] ?? 'Unknown TextBee error.',
            ]);

            return back()->withErrors([
                'identifier' => 'We could not send the SMS verification code. Please try again.',
            ])->withInput();
        }

        PasswordOtp::create([
            'user_id' => $user->id,
            'email' => $email,
            'channel' => 'sms',
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
            'verified' => false,
        ]);

        $maskedPhone = substr($smsRecipient, 0, 4)
            . '•••••'
            . substr($smsRecipient, -2);

        session([
            'password_reset_user_id' => $user->id,
            'email' => $email,
            'otp_channel' => 'sms',
            'otp_identifier' => $identifier,
            'otp_recipient' => $maskedPhone,
        ]);

        return redirect()->route('password.otp')
            ->with('status', 'Verification code sent to your registered mobile number.');
    }

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

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = session('password_reset_user_id');
        $email = session('email');
        $channel = session('otp_channel');

        if (!$userId || !in_array($channel, ['email', 'sms'], true)) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'Your password reset session has expired. Please request a new OTP.',
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'The account could not be found. Please request a new OTP.',
            ]);
        }

        $passwordOtp = PasswordOtp::where('user_id', $userId)
            ->where('channel', $channel)
            ->where('verified', false)
            ->latest()
            ->first();

        // Backward compatibility for older OTP records created before user_id was added.
        if (!$passwordOtp && $email) {
            $passwordOtp = PasswordOtp::whereNull('user_id')
                ->where('email', $email)
                ->where('channel', $channel)
                ->where('verified', false)
                ->latest()
                ->first();
        }

        if (!$passwordOtp) {
            return back()->withErrors([
                'otp' => 'No active verification code was found. Please request a new OTP.',
            ]);
        }

        if ($passwordOtp->expires_at->isPast()) {
            $passwordOtp->delete();

            return back()->withErrors([
                'otp' => 'This verification code has expired. Please request a new OTP.',
            ]);
        }

        if ($passwordOtp->attempts >= 5) {
            $passwordOtp->delete();

            return back()->withErrors([
                'otp' => 'Too many incorrect attempts. Please request a new OTP.',
            ]);
        }

        if (!hash_equals((string) $passwordOtp->otp, (string) $request->otp)) {
            $passwordOtp->increment('attempts');

            return back()->withErrors([
                'otp' => 'The verification code is incorrect.',
            ])->withInput();
        }

        $passwordOtp->update(['verified' => true]);

        session([
            'password_reset_user_id' => $user->id,
            'email' => $user->email,
            'otp_channel' => $passwordOtp->channel,
        ]);

        $message = $passwordOtp->channel === 'sms'
            ? 'Mobile number verified. You can now create a new password.'
            : 'Email verified. You can now create a new password.';

        return redirect()->route('password.reset')->with('status', $message);
    }

    public function showResetPassword(Request $request)
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'Please request a password reset first.',
            ]);
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $userId = session('password_reset_user_id');
        $channel = session('otp_channel');

        if (!$userId || !in_array($channel, ['email', 'sms'], true)) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'Your password reset session is invalid. Please request a new OTP.',
            ]);
        }

        $passwordOtp = PasswordOtp::where('user_id', $userId)
            ->where('channel', $channel)
            ->where('verified', true)
            ->latest()
            ->first();

        if (!$passwordOtp || $passwordOtp->expires_at->isPast()) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'Your verified OTP is missing or expired. Please request a new one.',
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('password.request')->withErrors([
                'identifier' => 'No account was found.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        PasswordOtp::where('user_id', $userId)->delete();

        session()->forget([
            'password_reset_user_id',
            'email',
            'otp_channel',
            'otp_identifier',
            'otp_recipient',
        ]);

        return redirect()->route('login')->with(
            'status',
            'Your password has been reset successfully. You can now log in with your new password.'
        );
    }
}