<x-guest-layout>

    <style>
        /* ── Login form skin — scoped to .cc-card ─────────────────────── */

        /* Heading block */
        .lf-heading {
            margin-bottom: 1.75rem;
            text-align: center;
        }
        .lf-heading h2 {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.625rem;
            font-weight: 400;
            color: #1e293b;
            letter-spacing: -0.02em;
            margin: 0 0 0.375rem;
            line-height: 1.2;
        }
        .lf-heading p {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* Status banner */
        .lf-status {
            margin-bottom: 1.25rem;
            padding: 0.75rem 1rem;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #be123c;
        }

        /* Field group */
        .lf-field {
            margin-bottom: 1.125rem;
        }
        .lf-field:last-of-type { margin-bottom: 0; }

        /* Labels — override x-input-label output */
        .lf-field label,
        .lf-field > label {
            display: block;
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-bottom: 0.4rem;
            letter-spacing: 0.005em;
        }

        /* Text inputs — override x-text-input output */
        .lf-field input[type="text"],
        .lf-field input[type="password"],
        .lf-field input[type="email"] {
            display: block;
            width: 100%;
            padding: 0.6875rem 1rem !important;
            font-size: 0.9375rem !important;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
            color: #0f172a !important;
            background: #f8fafc !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 0.75rem !important;
            box-shadow: none !important;
            outline: none !important;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s !important;
            margin-top: 0 !important;
            -webkit-appearance: none;
        }
        .lf-field input[type="text"]:focus,
        .lf-field input[type="password"]:focus,
        .lf-field input[type="email"]:focus {
            border-color: #e11d48 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.12) !important;
        }
        .lf-field input[type="text"]::placeholder,
        .lf-field input[type="password"]::placeholder {
            color: #94a3b8 !important;
        }

        /* Password wrapper for toggle button */
        .lf-password-wrap {
            position: relative;
        }
        .lf-password-wrap input {
            padding-right: 2.75rem !important;
        }
        .lf-pw-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0.25rem;
            cursor: pointer;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: color 0.15s;
            line-height: 0;
        }
        .lf-pw-toggle:hover { color: #e11d48; }
        .lf-pw-toggle:focus-visible {
            outline: 2px solid #e11d48;
            outline-offset: 1px;
        }
        .lf-pw-toggle svg { width: 18px; height: 18px; }

        /* Inline field errors — override x-input-error */
        .lf-field p.text-sm,
        .lf-field ul.text-sm,
        .lf-field span.text-sm {
            font-size: 0.8rem !important;
            color: #dc2626 !important;
            margin-top: 0.375rem !important;
        }

        /* Divider row */
        .lf-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.25rem;
        }

        /* Remember me */
        .lf-remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .lf-remember input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            border-radius: 0.3rem !important;
            border: 1.5px solid #cbd5e1 !important;
            background: #f8fafc !important;
            accent-color: #e11d48;
            cursor: pointer;
            flex-shrink: 0;
        }
        .lf-remember input[type="checkbox"]:focus {
            outline: 2px solid rgba(225, 29, 72, 0.3);
            outline-offset: 1px;
        }
        .lf-remember span {
            font-size: 0.8125rem !important;
            color: #475569 !important;
        }

        /* Forgot password link */
        .lf-forgot {
            font-size: 0.8125rem !important;
            color: #e11d48 !important;
            text-decoration: none !important;
            font-weight: 500;
            transition: color 0.15s;
            border-radius: 0.375rem;
        }
        .lf-forgot:hover { color: #be123c !important; text-decoration: underline !important; }
        .lf-forgot:focus-visible { outline: 2px solid #e11d48; outline-offset: 2px; }

        /* Sign in button — override x-primary-button */
        .lf-submit-row {
            margin-top: 1.5rem;
        }
        .lf-submit-row button,
        .lf-submit-row [type="submit"] {
            width: 100%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.8125rem 1.5rem !important;
            font-size: 0.9375rem !important;
            font-weight: 600 !important;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif !important;
            letter-spacing: 0.01em;
            color: #fff !important;
            background: linear-gradient(135deg, #be185d 0%, #db2777 100%) !important;
            border: none !important;
            border-radius: 0.875rem !important;
            box-shadow: 0 2px 12px rgba(219, 39, 119, 0.32), 0 1px 3px rgba(0,0,0,0.08) !important;
            cursor: pointer;
            transition: filter 0.18s, box-shadow 0.18s, transform 0.12s !important;
        }
        .lf-submit-row button:hover,
        .lf-submit-row [type="submit"]:hover {
            filter: brightness(1.06) !important;
            box-shadow: 0 4px 18px rgba(219, 39, 119, 0.38), 0 1px 4px rgba(0,0,0,0.1) !important;
        }
        .lf-submit-row button:active,
        .lf-submit-row [type="submit"]:active {
            transform: translateY(1px) !important;
        }
        .lf-submit-row button:focus-visible,
        .lf-submit-row [type="submit"]:focus-visible {
            outline: 3px solid rgba(219, 39, 119, 0.45) !important;
            outline-offset: 2px !important;
        }
    </style>

    {{-- ── Heading ─────────────────────────────────────── --}}
    <div class="lf-heading">
        <h2>Welcome back</h2>
        <p>Sign in to your CareCradle account</p>
    </div>

    {{-- ── Session status ───────────────────────────────── --}}
   
@if (session('status'))
    <div class="lf-status" role="status">
        <span class="lf-status-icon">✓</span>

        <div class="lf-status-content">
            <strong>Notice</strong>
            <span>{{ session('status') }}</span>
        </div>
    </div>
@endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- Username --}}
        <div class="lf-field">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username"
                type="text"
                name="username"
                :value="old('username')"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter your username" />
            <x-input-error :messages="$errors?->get('username') ?? []" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="lf-field">
            <x-input-label for="password" :value="__('Password')" />
            <div class="lf-password-wrap">
                <x-text-input id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password" />

                {{-- Show / hide toggle --}}
                <button type="button"
                        class="lf-pw-toggle"
                        id="pw-toggle-btn"
                        aria-label="Show password"
                        aria-pressed="false">
                    <svg id="pw-icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <svg id="pw-icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                        <path d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors?->get('password') ?? []" class="mt-2" />
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="lf-row">
            <label class="lf-remember">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="lf-forgot" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="lf-submit-row">
            <x-primary-button>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="flex-shrink:0;">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

    </form>

    {{-- ── Password toggle script ───────────────────────── --}}
    <script>
        (function () {
            var btn   = document.getElementById('pw-toggle-btn');
            var input = document.getElementById('password');
            var iconShow = document.getElementById('pw-icon-show');
            var iconHide = document.getElementById('pw-icon-hide');
            if (!btn || !input) return;

            btn.addEventListener('click', function () {
                var isHidden = input.type === 'password';
                input.type        = isHidden ? 'text' : 'password';
                btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
                btn.setAttribute('aria-label',   isHidden ? 'Hide password' : 'Show password');
                iconShow.style.display = isHidden ? 'none'  : '';
                iconHide.style.display = isHidden ? ''      : 'none';
                input.focus();
            });
        })();
    </script>

</x-guest-layout>