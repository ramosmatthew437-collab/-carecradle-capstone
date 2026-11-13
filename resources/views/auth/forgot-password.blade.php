<x-guest-layout>

    <style>
        /* =========================================================
           CARECRADLE — FORGOT PASSWORD
           ========================================================= */

        /* Shared header, status, field, submit, spinner and back-link
           styles now live in layouts/guest.blade.php so the verify and
           reset pages use them too. Only the delivery-method cards
           are specific to this page. */

        /* ---------------------------------------------------------
           Delivery Method
           --------------------------------------------------------- */

        .cc-method-label {
            display: block;
            margin-bottom: 0.6rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
        }

        .cc-method-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1.35rem;
        }

        .cc-method-option {
            position: relative;
            cursor: pointer;
        }

        .cc-method-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .cc-method-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-height: 4.25rem;
            padding: 0.8rem 0.85rem;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.85rem;
            transition:
                border-color 0.18s ease,
                background 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.12s ease;
        }

        .cc-method-option:hover .cc-method-card {
            border-color: #f9a8d4;
            background: #fffafd;
        }

        .cc-method-option input:focus-visible
        + .cc-method-card {
            outline: 3px solid rgba(236, 72, 153, 0.16);
            outline-offset: 2px;
        }

        .cc-method-option input:checked
        + .cc-method-card {
            border-color: #ec4899;
            background: #fdf2f8;
            box-shadow:
                0 0 0 3px rgba(236, 72, 153, 0.08);
        }

        .cc-method-option:active .cc-method-card {
            transform: translateY(1px);
        }

        /* ---------------------------------------------------------
           Method Icon
           --------------------------------------------------------- */

        .cc-method-icon {
            width: 2.25rem;
            height: 2.25rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.65rem;
            color: #64748b;
            transition:
                color 0.18s ease,
                background 0.18s ease,
                border-color 0.18s ease;
        }

        .cc-method-icon svg {
            width: 1.15rem;
            height: 1.15rem;
        }

        .cc-method-option input:checked
        + .cc-method-card
        .cc-method-icon {
            background: #fce7f3;
            border-color: #f9a8d4;
            color: #be185d;
        }

        /* ---------------------------------------------------------
           Method Text
           --------------------------------------------------------- */

        .cc-method-content {
            min-width: 0;
            flex: 1;
        }

        .cc-method-title {
            display: block;
            margin-bottom: 0.12rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.84rem;
            font-weight: 700;
            color: #334155;
        }

        .cc-method-description {
            display: block;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.72rem;
            line-height: 1.3;
            color: #94a3b8;
        }

        .cc-method-option input:checked
        + .cc-method-card
        .cc-method-title {
            color: #9d174d;
        }

        /* ---------------------------------------------------------
           Radio Indicator
           --------------------------------------------------------- */

        .cc-method-radio {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
            border: 1.5px solid #cbd5e1;
            border-radius: 50%;
            position: relative;
            transition:
                border-color 0.18s ease,
                background 0.18s ease;
        }

        .cc-method-option input:checked
        + .cc-method-card
        .cc-method-radio {
            border-color: #ec4899;
            background: #ec4899;
        }

        .cc-method-option input:checked
        + .cc-method-card
        .cc-method-radio::after {
            content: '';
            position: absolute;
            width: 0.35rem;
            height: 0.35rem;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border-radius: 50%;
        }

        /* ---------------------------------------------------------
           Responsive
           --------------------------------------------------------- */

        @media (max-width: 480px) {

            .cc-method-options {
                grid-template-columns: 1fr;
            }

            .cc-method-card {
                min-height: 3.9rem;
            }

        }
    </style>


    <div class="cc-forgot-password">

        {{-- Recovery progress: step 1 of 3 --}}
        <ol class="cc-steps" aria-label="Password recovery steps">
            <li class="cc-step is-current" aria-current="step">
                <span class="cc-step-dot">1</span>
                <span class="cc-step-label">Request</span>
            </li>
            <li class="cc-step">
                <span class="cc-step-dot">2</span>
                <span class="cc-step-label">Verify</span>
            </li>
            <li class="cc-step">
                <span class="cc-step-dot">3</span>
                <span class="cc-step-label">New password</span>
            </li>
        </ol>

        {{-- =====================================================
             HEADER
             ===================================================== --}}

        <div class="cc-forgot-header">

            <div class="cc-forgot-icon" aria-hidden="true">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect
                        x="4"
                        y="10"
                        width="16"
                        height="10"
                        rx="2"
                    />

                    <path d="M8 10V7a4 4 0 018 0v3" />

                    <circle
                        cx="12"
                        cy="15"
                        r="1"
                    />
                </svg>

            </div>

            <h2>Forgot Password?</h2>

            <p>
                Enter your information and choose how you'd like
                to receive your verification code.
            </p>

        </div>


        {{-- =====================================================
             STATUS
             ===================================================== --}}

        @if (session('status'))

            <div
                class="cc-forgot-status"
                role="status"
                aria-live="polite"
            >
                <span>✓</span>

                <div>
                    {{ session('status') }}
                </div>
            </div>

        @endif


        {{-- =====================================================
             ERRORS
             ===================================================== --}}

        @if ($errors->any())

            <div
                class="cc-forgot-error"
                role="alert"
                aria-live="assertive"
            >
                <span>!</span>

                <div>
                    {{ $errors->first() }}
                </div>
            </div>

        @endif


        {{-- =====================================================
             FORM
             ===================================================== --}}

        <form
            method="POST"
            action="{{ route('password.send-otp') }}"
            id="forgot-password-form"
        >

            @csrf


            {{-- =================================================
                 DYNAMIC IDENTIFIER
                 ================================================= --}}

            <div class="cc-forgot-field">

                <label
                    for="identifier"
                    id="identifier-label"
                >
                    Email Address
                </label>

                <div class="cc-forgot-input-wrap">

                    {{-- Dynamic Email / Mobile Icon --}}

                    <svg
                        id="identifier-icon-email"
                        class="cc-forgot-input-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="14"
                            rx="2"
                        />

                        <path d="m3 7 9 6 9-6" />
                    </svg>


                    <svg
                        id="identifier-icon-phone"
                        class="cc-forgot-input-icon"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                        style="display:none;"
                    >
                        <rect
                            x="6"
                            y="2.5"
                            width="12"
                            height="19"
                            rx="2"
                        />

                        <path d="M9 5h6" />

                        <circle
                            cx="12"
                            cy="18"
                            r="1"
                        />
                    </svg>


                    <input
                        id="identifier"
                        type="email"
                        name="identifier"
                        value="{{ old('identifier') }}"
                        class="cc-forgot-input"
                        placeholder="Enter your registered email"
                        autocomplete="email"
                        required
                        autofocus
                    >

                </div>

            </div>


            {{-- =================================================
                 DELIVERY METHOD
                 ================================================= --}}

            <span class="cc-method-label">
                Send verification code via
            </span>


            <div class="cc-method-options">

                {{-- EMAIL --}}

                <label class="cc-method-option">

                    <input
                        type="radio"
                        name="delivery_method"
                        value="email"
                        {{ old('delivery_method', 'email') === 'email' ? 'checked' : '' }}
                    >

                    <span class="cc-method-card">

                        <span
                            class="cc-method-icon"
                            aria-hidden="true"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2"
                                />

                                <path d="m3 7 9 6 9-6" />
                            </svg>

                        </span>


                        <span class="cc-method-content">

                            <span class="cc-method-title">
                                Email
                            </span>

                            <span class="cc-method-description">
                                Receive code by email
                            </span>

                        </span>


                        <span
                            class="cc-method-radio"
                            aria-hidden="true"
                        ></span>

                    </span>

                </label>


                {{-- SMS --}}

                <label class="cc-method-option">

                    <input
                        type="radio"
                        name="delivery_method"
                        value="sms"
                        {{ old('delivery_method') === 'sms' ? 'checked' : '' }}
                    >

                    <span class="cc-method-card">

                        <span
                            class="cc-method-icon"
                            aria-hidden="true"
                        >

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M20 15a3 3 0 01-3 3H9l-5 3v-6a3 3 0 01-1-2.5V8a3 3 0 013-3h11a3 3 0 013 3z"
                                />

                                <path d="M8 11h.01" />
                                <path d="M12 11h.01" />
                                <path d="M16 11h.01" />

                            </svg>

                        </span>


                        <span class="cc-method-content">

                            <span class="cc-method-title">
                                SMS
                            </span>

                            <span class="cc-method-description">
                                Receive code by text message
                            </span>

                        </span>


                        <span
                            class="cc-method-radio"
                            aria-hidden="true"
                        ></span>

                    </span>

                </label>

            </div>


            {{-- =================================================
                 SUBMIT
                 ================================================= --}}

            <button
                type="submit"
                class="cc-forgot-submit"
                id="cc-send-code"
            >

                <span
                    class="cc-submit-spinner"
                    id="cc-submit-spinner"
                    style="display:none;"
                    aria-hidden="true"
                ></span>

                <span id="cc-submit-text">
                    Send Verification Code
                </span>

                <span
                    id="cc-submit-arrow"
                    aria-hidden="true"
                >
                    →
                </span>

            </button>


            {{-- =================================================
                 BACK
                 ================================================= --}}

            <a
                href="{{ route('login') }}"
                class="cc-forgot-back"
            >
                ← Back to Login
            </a>

        </form>

    </div>


    {{-- =========================================================
         DYNAMIC INPUT INTERACTION
         ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('forgot-password-form');

            const identifier =
                document.getElementById('identifier');

            const identifierLabel =
                document.getElementById('identifier-label');

            const emailIcon =
                document.getElementById('identifier-icon-email');

            const phoneIcon =
                document.getElementById('identifier-icon-phone');

            const submitButton =
                document.getElementById('cc-send-code');

            const submitText =
                document.getElementById('cc-submit-text');

            const submitSpinner =
                document.getElementById('cc-submit-spinner');

            const submitArrow =
                document.getElementById('cc-submit-arrow');

            const methodInputs =
                document.querySelectorAll(
                    'input[name="delivery_method"]'
                );


            if (
                !form ||
                !identifier ||
                !identifierLabel ||
                !submitButton
            ) {
                return;
            }


            /*
             * Update the identifier field based
             * on selected delivery method.
             */

            function updateIdentifierField() {

                const selectedMethod =
                    document.querySelector(
                        'input[name="delivery_method"]:checked'
                    );


                const method =
                    selectedMethod
                        ? selectedMethod.value
                        : 'email';


                if (method === 'sms') {

                    /*
                     * SMS state
                     */

                    identifierLabel.textContent =
                        'Mobile Number';

                    identifier.placeholder =
                        'Enter your 11-digit mobile number (e.g., 09123456789)';

                    identifier.type = 'tel';

                    identifier.name = 'identifier';

                    identifier.autocomplete =
                        'tel';

                    emailIcon.style.display = 'none';

                    phoneIcon.style.display = 'block';

                    submitText.textContent =
                        'Send SMS Code';


                } else {

                    /*
                     * Email state
                     */

                    identifierLabel.textContent =
                        'Email Address';

                    identifier.placeholder =
                        'Enter your registered email';

                    identifier.type = 'email';

                    identifier.name = 'identifier';

                    identifier.autocomplete =
                        'email';

                    emailIcon.style.display = 'block';

                    phoneIcon.style.display = 'none';

                    submitText.textContent =
                        'Send Email Code';
                }
            }


            /*
             * Switch field when method changes.
             */

            methodInputs.forEach(function (input) {

                input.addEventListener(
                    'change',
                    updateIdentifierField
                );

            });


            /*
             * Format Philippine mobile number.
             *
             * Only digits are allowed for SMS.
             */

            identifier.addEventListener(
                'input',
                function () {

                    const selectedMethod =
                        document.querySelector(
                            'input[name="delivery_method"]:checked'
                        );


                    if (
                        selectedMethod &&
                        selectedMethod.value === 'sms'
                    ) {

                        this.value =
                            this.value
                                .replace(/\D/g, '')
                                .slice(0, 11);
                    }

                }
            );


            /*
             * Loading state
             * Prevent double submission.
             */

            form.addEventListener(
                'submit',
                function () {

                    if (submitButton.disabled) {
                        return;
                    }


                    const selectedMethod =
                        document.querySelector(
                            'input[name="delivery_method"]:checked'
                        );


                    const method =
                        selectedMethod
                            ? selectedMethod.value
                            : 'email';


                    if (method === 'sms') {

                        submitText.textContent =
                            'Sending SMS code...';

                    } else {

                        submitText.textContent =
                            'Sending email code...';

                    }


                    submitButton.disabled = true;

                    submitButton.classList.add(
                        'is-loading'
                    );

                    submitSpinner.style.display =
                        'block';

                    submitArrow.style.display =
                        'none';

                }
            );


            /*
             * Initialize field state.
             */

            updateIdentifierField();

        });

    </script>

</x-guest-layout>