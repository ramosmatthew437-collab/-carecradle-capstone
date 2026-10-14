
<x-guest-layout>

    <div class="cc-forgot-password">

        {{-- Header --}}
        <div class="cc-forgot-header">

            <div class="cc-forgot-icon">
                🔐
            </div>

            <h2>
                Set a New Password
            </h2>

            <p>
                Your verification was successful.
                Create a strong new password for your CareCradle account.
            </p>

        </div>


        {{-- Status Message --}}
        @if (session('status'))

            <div class="cc-forgot-status">
                <span>✓</span>

                <div>
                    {{ session('status') }}
                </div>
            </div>

        @endif


        {{-- Error Message --}}
        @if ($errors->any())

            <div class="cc-forgot-error">
                <span>!</span>

                <div>
                    {{ $errors->first() }}
                </div>
            </div>

        @endif


        {{-- Reset Password Form --}}
        <form
            method="POST"
            action="{{ route('password.update') }}"
        >

            @csrf


            <input
                type="hidden"
                name="email"
                value="{{ session('email') }}"
            >


            {{-- =================================================
                 NEW PASSWORD
                 ================================================= --}}

            <div class="cc-forgot-field">

                <x-input-label
                    for="password"
                    :value="__('New Password')"
                />

                <div class="cc-password-wrapper">

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autofocus
                        autocomplete="new-password"
                    />

                    <button
                        type="button"
                        class="cc-password-toggle"
                        id="password-toggle"
                        aria-label="Show password"
                    >
                        👁
                    </button>

                </div>


                {{-- Password Requirements --}}
                <div
                    id="password-requirements"
                    class="cc-password-requirements"
                >

                    <p class="cc-password-requirements-title">
                        Your password must contain:
                    </p>


                    <div
                        class="cc-password-rule"
                        id="rule-length"
                    >
                        <span class="cc-password-rule-icon">✓</span>
                        <span>At least 8 characters</span>
                    </div>


                    <div
                        class="cc-password-rule"
                        id="rule-uppercase"
                    >
                        <span class="cc-password-rule-icon">✓</span>
                        <span>At least one uppercase letter</span>
                    </div>


                    <div
                        class="cc-password-rule"
                        id="rule-lowercase"
                    >
                        <span class="cc-password-rule-icon">✓</span>
                        <span>At least one lowercase letter</span>
                    </div>


                    <div
                        class="cc-password-rule"
                        id="rule-number"
                    >
                        <span class="cc-password-rule-icon">✓</span>
                        <span>At least one number</span>
                    </div>


                    <div
                        class="cc-password-rule"
                        id="rule-symbol"
                    >
                        <span class="cc-password-rule-icon">✓</span>
                        <span>At least one special character</span>
                    </div>

                </div>


                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />

            </div>


            {{-- =================================================
                 CONFIRM PASSWORD
                 ================================================= --}}

            <div class="mt-4">

                <x-input-label
                    for="password_confirmation"
                    :value="__('Confirm New Password')"
                />

                <div class="cc-password-wrapper">

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <button
                        type="button"
                        class="cc-password-toggle"
                        id="password-confirmation-toggle"
                        aria-label="Show password"
                    >
                        👁
                    </button>

                </div>


                <x-input-error
                    :messages="$errors->get('password_confirmation')"
                    class="mt-2"
                />

            </div>


            {{-- =================================================
                 RESET BUTTON
                 ================================================= --}}

            <button
                type="submit"
                class="cc-forgot-submit"
            >
                <span>Set New Password</span>
                <span aria-hidden="true">→</span>
            </button>


            {{-- Back to Login --}}
            <a
                href="{{ route('login') }}"
                class="cc-forgot-back"
            >
                ← Back to Login
            </a>

        </form>

    </div>


    {{-- =========================================================
         PASSWORD JAVASCRIPT
         ========================================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const password =
                document.getElementById('password');


            /* =====================================================
               PASSWORD VISIBILITY
               ===================================================== */

            function setupToggle(inputId, toggleId) {

                const input =
                    document.getElementById(inputId);

                const toggle =
                    document.getElementById(toggleId);

                if (!input || !toggle) {
                    return;
                }


                toggle.addEventListener('click', function () {

                    const isPassword =
                        input.type === 'password';


                    input.type =
                        isPassword
                            ? 'text'
                            : 'password';


                    toggle.textContent =
                        isPassword
                            ? '🙈'
                            : '👁';


                    toggle.setAttribute(
                        'aria-label',
                        isPassword
                            ? 'Hide password'
                            : 'Show password'
                    );

                });

            }


            setupToggle(
                'password',
                'password-toggle'
            );


            setupToggle(
                'password_confirmation',
                'password-confirmation-toggle'
            );


            /* =====================================================
               PASSWORD REQUIREMENTS
               ===================================================== */

            function updateRule(
                ruleId,
                passed
            ) {

                const rule =
                    document.getElementById(ruleId);

                if (!rule) {
                    return;
                }


                if (passed) {

                    rule.classList.add(
                        'is-valid'
                    );

                } else {

                    rule.classList.remove(
                        'is-valid'
                    );

                }

            }


            /* =====================================================
               LIVE PASSWORD CHECKING
               ===================================================== */

            if (password) {

                password.addEventListener(
                    'input',
                    function () {

                        const value =
                            password.value;


                        updateRule(
                            'rule-length',
                            value.length >= 8
                        );


                        updateRule(
                            'rule-uppercase',
                            /[A-Z]/.test(value)
                        );


                        updateRule(
                            'rule-lowercase',
                            /[a-z]/.test(value)
                        );


                        updateRule(
                            'rule-number',
                            /[0-9]/.test(value)
                        );


                        updateRule(
                            'rule-symbol',
                            /[^A-Za-z0-9]/.test(value)
                        );

                    }
                );

            }

        });
    </script>

</x-guest-layout>

