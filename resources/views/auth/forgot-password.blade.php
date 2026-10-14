<x-guest-layout>

    <style>
        /* =========================================================
           CARECRADLE — FORGOT PASSWORD
           ========================================================= */

        .cc-forgot-password {
            width: 100%;
        }

        /* ---------------------------------------------------------
           Header
           --------------------------------------------------------- */

        .cc-forgot-header {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .cc-forgot-icon {
            width: 3.5rem;
            height: 3.5rem;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
            border-radius: 1rem;
            color: #be185d;
            box-shadow:
                0 4px 12px rgba(236, 72, 153, 0.08);
        }

        .cc-forgot-icon svg {
            width: 1.65rem;
            height: 1.65rem;
        }

        .cc-forgot-header h2 {
            margin: 0 0 0.4rem;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.7rem;
            font-weight: 400;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: #1e293b;
        }

        .cc-forgot-header p {
            margin: 0;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.875rem;
            line-height: 1.55;
            color: #64748b;
        }

        /* ---------------------------------------------------------
           Status / Error
           --------------------------------------------------------- */

        .cc-forgot-status {
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            margin-bottom: 1.25rem;
            padding: 0.8rem 1rem;
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
            border-radius: 0.8rem;
            color: #9d174d;
            font-size: 0.84rem;
            line-height: 1.45;
        }

        .cc-forgot-status > span {
            width: 1.3rem;
            height: 1.3rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #ec4899;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .cc-forgot-error {
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            margin-bottom: 1.25rem;
            padding: 0.8rem 1rem;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 0.8rem;
            color: #be123c;
            font-size: 0.84rem;
            line-height: 1.45;
        }

        .cc-forgot-error > span {
            width: 1.3rem;
            height: 1.3rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e11d48;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
        }

        /* ---------------------------------------------------------
           Field
           --------------------------------------------------------- */

        .cc-forgot-field {
            margin-bottom: 1.25rem;
        }

        .cc-forgot-field label {
            display: block;
            margin-bottom: 0.45rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
        }

        .cc-forgot-input-wrap {
            position: relative;
        }

        .cc-forgot-input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.1rem;
            height: 1.1rem;
            color: #94a3b8;
            pointer-events: none;
            transition: color 0.18s ease;
        }

        .cc-forgot-input-wrap:focus-within
        .cc-forgot-input-icon {
            color: #ec4899;
        }

        .cc-forgot-input {
            display: block;
            width: 100%;
            padding: 0.72rem 1rem 0.72rem 2.7rem !important;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.9375rem;
            color: #0f172a;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            outline: none !important;
            box-shadow: none !important;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .cc-forgot-input:focus {
            background: #fff;
            border-color: #ec4899 !important;
            box-shadow:
                0 0 0 3px rgba(236, 72, 153, 0.12) !important;
        }

        .cc-forgot-input::placeholder {
            color: #94a3b8;
        }

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
           Submit
           --------------------------------------------------------- */

        .cc-forgot-submit {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            padding: 0.78rem 1.25rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(
                135deg,
                #be185d 0%,
                #db2777 100%
            );
            border: none;
            border-radius: 0.8rem;
            box-shadow:
                0 2px 12px rgba(219, 39, 119, 0.28),
                0 1px 3px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition:
                filter 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.12s ease,
                opacity 0.18s ease;
        }

        .cc-forgot-submit:hover {
            filter: brightness(1.05);
            box-shadow:
                0 4px 18px rgba(219, 39, 119, 0.34),
                0 1px 4px rgba(0, 0, 0, 0.08);
        }

        .cc-forgot-submit:active {
            transform: translateY(1px);
        }

        .cc-forgot-submit:focus-visible {
            outline: 3px solid rgba(236, 72, 153, 0.28);
            outline-offset: 2px;
        }

        .cc-forgot-submit.is-loading {
            cursor: wait;
            opacity: 0.82;
        }

        .cc-forgot-submit:disabled {
            cursor: wait;
        }

        /* ---------------------------------------------------------
           Spinner
           --------------------------------------------------------- */

        .cc-submit-spinner {
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: cc-forgot-spin 0.7s linear infinite;
        }

        @keyframes cc-forgot-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ---------------------------------------------------------
           Back Link
           --------------------------------------------------------- */

        .cc-forgot-back {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1.15rem;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .cc-forgot-back:hover {
            color: #be185d;
        }

        .cc-forgot-back:focus-visible {
            outline: 2px solid #ec4899;
            outline-offset: 3px;
            border-radius: 0.35rem;
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