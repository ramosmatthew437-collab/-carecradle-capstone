<x-guest-layout>

    <div class="cc-forgot-password">

        {{-- =========================================================
             HEADER
             ========================================================= --}}
        <div class="cc-forgot-header">

            <div class="cc-forgot-icon" aria-hidden="true">
                🔐
            </div>

            <h2>
                @if (session('otp_channel') === 'sms')
                    Verify Your Mobile Number
                @else
                    Verify Your Email
                @endif
            </h2>

            <p>
                @if (session('otp_channel') === 'sms')
                    Enter the 6-digit code sent to your registered
                    mobile number to continue.
                @else
                    Enter the 6-digit code sent to your registered
                    email address to continue.
                @endif
            </p>

        </div>


        {{-- =========================================================
             STATUS MESSAGE
             ========================================================= --}}
        @if (session('status'))

            <div
                class="cc-forgot-status"
                role="status"
            >

                <span aria-hidden="true">✓</span>

                <div>
                    {{ session('status') }}
                </div>

            </div>

        @endif


        {{-- =========================================================
             ERROR MESSAGE
             ========================================================= --}}
        @if ($errors->any())

            <div
                class="cc-forgot-error"
                role="alert"
            >

                <span aria-hidden="true">!</span>

                <div>
                    {{ $errors->first() }}
                </div>

            </div>

        @endif


        {{-- =========================================================
             OTP FORM
             ========================================================= --}}
        <form
            method="POST"
            action="{{ route('password.verify-otp') }}"
            id="otp-form"
        >

            @csrf

            <input
                type="hidden"
                name="email"
                value="{{ session('email') }}"
            >


            {{-- =====================================================
                 VERIFICATION CODE
                 ===================================================== --}}
            <div class="cc-forgot-field">

                <x-input-label
                    for="otp"
                    :value="__('Verification Code')"
                />

                <x-text-input
                    id="otp"
                    class="block mt-1 w-full cc-otp-input"
                    type="text"
                    name="otp"
                    inputmode="numeric"
                    maxlength="6"
                    minlength="6"
                    pattern="[0-9]{6}"
                    required
                    autofocus
                    autocomplete="one-time-code"
                    placeholder="Enter your 6-digit code"
                    aria-describedby="otp-help"
                />

                <p
                    id="otp-help"
                    class="mt-2 text-sm text-gray-500"
                >
                    The verification code expires in
                    <strong>5 minutes</strong>.
                </p>

            </div>


            {{-- =====================================================
                 VERIFY BUTTON
                 ===================================================== --}}
            <button
                type="submit"
                class="cc-forgot-submit"
                id="verify-otp-button"
            >

                <span id="verify-text">
                    Verify & Continue
                </span>

                <span
                    id="verify-arrow"
                    aria-hidden="true"
                >
                    →
                </span>

            </button>


            {{-- =====================================================
                 BACK TO LOGIN
                 ===================================================== --}}
            <a
                href="{{ route('login') }}"
                class="cc-forgot-back"
            >
                ← Back to Login
            </a>

        </form>


        {{-- =========================================================
             SECURITY NOTE
             ========================================================= --}}
        <div
            class="cc-otp-security"
            aria-label="Security information"
        >

            <span aria-hidden="true">🛡️</span>

            <p>
                For your security, never share your
                verification code with anyone.
            </p>

        </div>

    </div>


    {{-- =============================================================
         OTP INPUT SCRIPT
         ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const otpInput =
                document.getElementById('otp');

            const otpForm =
                document.getElementById('otp-form');

            const verifyButton =
                document.getElementById('verify-otp-button');

            const verifyText =
                document.getElementById('verify-text');

            const verifyArrow =
                document.getElementById('verify-arrow');


            if (!otpInput) {
                return;
            }


            /*
             * Allow numbers only.
             */
            otpInput.addEventListener('input', function () {

                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 6);

            });


            /*
             * Prevent accidental double submission
             * and provide visual feedback.
             */
            if (otpForm) {

                otpForm.addEventListener('submit', function () {

                    if (!verifyButton) {
                        return;
                    }

                    verifyButton.disabled = true;

                    if (verifyText) {
                        verifyText.textContent =
                            'Verifying...';
                    }

                    if (verifyArrow) {
                        verifyArrow.style.display =
                            'none';
                    }

                });

            }

        });
    </script>


    {{-- =============================================================
         SMALL ADDITIONAL STYLING
         ============================================================= --}}
    <style>

        .cc-otp-input {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.45rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .cc-otp-input::placeholder {
            font-size: 0.95rem;
            font-weight: 400;
            letter-spacing: normal;
        }

        .cc-otp-security {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            margin-top: 1.5rem;
            padding: 0.85rem 1rem;
            border-radius: 0.85rem;
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
        }

        .cc-otp-security span {
            flex-shrink: 0;
            font-size: 1rem;
            line-height: 1.4;
        }

        .cc-otp-security p {
            margin: 0;
            font-size: 0.78rem;
            line-height: 1.45;
            color: #9d174d;
        }

        .cc-forgot-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        @media (max-width: 640px) {

            .cc-otp-input {
                font-size: 1.35rem;
                letter-spacing: 0.35rem;
            }

        }

    </style>

</x-guest-layout>