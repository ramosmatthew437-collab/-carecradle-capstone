{{-- ============================= --}}
{{-- 1. PERSONAL INFORMATION --}}
{{-- ============================= --}}
<section class="adm-form-section">

    {{-- Header --}}
    <div class="adm-form-section-head">
        <div class="adm-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <h2 class="adm-form-section-title">Personal Information</h2>
            <p class="adm-form-section-sub">The midwife's legal name and contact details.</p>
        </div>
    </div>

    {{-- Body --}}
    <div class="adm-form-grid adm-form-grid-2">

        {{-- First Name --}}
        <div class="adm-field">
            <label for="first_name">
                First Name <span class="adm-required">*</span>
            </label>

            <input
                id="first_name"
                type="text"
                name="first_name"
                value="{{ old('first_name', $midwife->first_name ?? '') }}"
                placeholder="Enter first name"
                class="adm-input"
                required>

            @error('first_name')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Middle Name --}}
        <div class="adm-field">
            <label for="middle_name">
                Middle Name
            </label>

            <input
                id="middle_name"
                type="text"
                name="middle_name"
                value="{{ old('middle_name', $midwife->middle_name ?? '') }}"
                placeholder="Enter middle name"
                class="adm-input">

            @error('middle_name')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Last Name --}}
        <div class="adm-field">
            <label for="last_name">
                Last Name <span class="adm-required">*</span>
            </label>

            <input
                id="last_name"
                type="text"
                name="last_name"
                value="{{ old('last_name', $midwife->last_name ?? '') }}"
                placeholder="Enter last name"
                class="adm-input"
                required>

            @error('last_name')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contact Number --}}
        <div class="adm-field">
            <label for="contact_number">
                Contact Number
            </label>

            <input
                id="contact_number"
                type="text"
                name="contact_number"
                value="{{ old('contact_number', $midwife->contact_number ?? '') }}"
                placeholder="09XXXXXXXXX"
                class="adm-input">

            @error('contact_number')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="adm-field adm-span-2">
            <label for="email">
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $midwife->email ?? '') }}"
                placeholder="name@example.com"
                class="adm-input">

            @error('email')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

    </div>

</section>

{{-- ============================= --}}
{{-- 2. ACCOUNT INFORMATION --}}
{{-- ============================= --}}
<section class="adm-form-section">

    {{-- Header --}}
    <div class="adm-form-section-head">
        <div class="adm-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5V12a1.5 1.5 0 011.5-1.5z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <h2 class="adm-form-section-title">Account Information</h2>
            <p class="adm-form-section-sub">
                @if(!isset($midwife))
                    Login credentials for accessing the CareCradle system.
                @else
                    The midwife's system login username.
                @endif
            </p>
        </div>
    </div>

    {{-- Body --}}
    <div class="adm-form-grid adm-form-grid-2">

        {{-- Username --}}
        <div class="adm-field {{ !isset($midwife) ? '' : 'adm-span-2' }}">
            <label for="username">
                Username <span class="adm-required">*</span>
            </label>

            {{-- On Edit the username is read-only: `readonly` (not `disabled`)
                 so the existing value is still submitted, which the current
                 update validation requires. --}}
            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username', $midwife->username ?? '') }}"
                placeholder="Enter username"
                class="adm-input"
                @isset($midwife) readonly aria-readonly="true" aria-describedby="username-help" @endisset
                required>

            @isset($midwife)
                <p class="adm-field-help" id="username-help">
                    The username is the midwife's login ID and cannot be changed here.
                </p>
            @endisset

            @error('username')
                <p class="adm-field-error">{{ $message }}</p>
            @enderror
        </div>

        @if(isset($midwife))

            {{-- Password is never shown or edited on this form. --}}
            <div class="adm-field adm-span-2">
                <div class="adm-note" role="note">
                    <span class="adm-note-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="10.5" width="16" height="10" rx="2"/>
                            <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>
                        </svg>
                    </span>
                    <div>
                        <p class="adm-note-title">Password</p>
                        <p class="adm-note-text">
                            For security, passwords are never displayed or changed on this page.
                            Password resets are handled separately through account security.
                        </p>
                    </div>
                </div>
            </div>

        @endif

        @if(!isset($midwife))

            {{-- Password --}}
            <div class="adm-field">
                <label for="password">
                    Password <span class="adm-required">*</span>
                </label>

                <div class="adm-input-wrap">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        class="adm-input"
                        required>

                    <button
                        type="button"
                        data-password-toggle="password"
                        aria-label="Show password"
                        aria-pressed="false"
                        class="adm-input-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                @error('password')
                    <p class="adm-field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="adm-field">
                <label for="password_confirmation">
                    Confirm Password <span class="adm-required">*</span>
                </label>

                <div class="adm-input-wrap">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Re-enter password"
                        class="adm-input"
                        required>

                    <button
                        type="button"
                        data-password-toggle="password_confirmation"
                        aria-label="Show confirm password"
                        aria-pressed="false"
                        class="adm-input-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                @error('password_confirmation')
                    <p class="adm-field-error">{{ $message }}</p>
                @enderror
            </div>

        @endif

    </div>

</section>


<script>
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', function () {
            const inputId = this.dataset.passwordToggle;
            const passwordInput = document.getElementById(inputId);

            if (!passwordInput) return;

            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            this.setAttribute('aria-pressed', String(isPassword));
            this.setAttribute(
                'aria-label',
                isPassword ? 'Hide password' : 'Show password'
            );
        });
    });
</script>
