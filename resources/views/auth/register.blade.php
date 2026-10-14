<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- =====================================================
             NAME
             ===================================================== -->

        <div>
            <x-input-label
                for="name"
                :value="__('Name')"
            />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>


        <!-- =====================================================
             EMAIL
             ===================================================== -->

        <div class="mt-4">

            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        <!-- =====================================================
             PASSWORD
             ===================================================== -->

        <div class="mt-4">

            <x-input-label
                for="password"
                :value="__('Password')"
            />

            <div class="cc-password-wrapper">

                <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
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


            <!-- =================================================
                 PASSWORD REQUIREMENTS
                 ================================================= -->

            <div
                id="password-requirements"
                class="cc-password-requirements"
            >

                <p class="cc-password-requirements-title">
                    Password must contain:
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


        <!-- =====================================================
             CONFIRM PASSWORD
             ===================================================== -->

        <div class="mt-4">

            <x-input-label
                for="password_confirmation"
                :value="__('Confirm Password')"
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


        <!-- =====================================================
             ACTIONS
             ===================================================== -->

        <div class="flex items-center justify-end mt-4">

            <a
                class="underline text-sm text-gray-600 dark:text-gray-400
                       hover:text-gray-900 dark:hover:text-gray-100
                       rounded-md
                       focus:outline-none
                       focus:ring-2
                       focus:ring-offset-2
                       focus:ring-indigo-500
                       dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}"
            >
                {{ __('Already registered?') }}
            </a>


            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>

        </div>

    </form>


    <!-- =========================================================
         PASSWORD JAVASCRIPT
         ========================================================= -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const password =
                document.getElementById('password');

            const confirmation =
                document.getElementById('password_confirmation');


            /* =====================================================
               PASSWORD VISIBILITY TOGGLE
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


                        // At least 8 characters
                        updateRule(
                            'rule-length',
                            value.length >= 8
                        );


                        // Uppercase
                        updateRule(
                            'rule-uppercase',
                            /[A-Z]/.test(value)
                        );


                        // Lowercase
                        updateRule(
                            'rule-lowercase',
                            /[a-z]/.test(value)
                        );


                        // Number
                        updateRule(
                            'rule-number',
                            /[0-9]/.test(value)
                        );


                        // Special character
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