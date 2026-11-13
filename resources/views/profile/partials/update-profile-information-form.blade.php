{{--
    Personal information (signed-in user's own account; PATCH profile.update).
    Administrator / Midwife: first, middle and last name, email (required),
    mobile number (optional, saved on the user account).
    Mother: account name, email (optional), registered mobile number (saved on
    the Mother record and used for SMS reminders and SMS password recovery).
--}}
@php
    $piIsMother = $user->isMother() && $user->mother;
    $piHas = fn (string $field) => $errors->has($field) ? ' has-error' : '';
    $piInvalid = fn (string $field) => $errors->has($field) ? 'aria-invalid="true" aria-describedby="' . $field . '_error"' : '';
@endphp

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    @if ($errors->hasAny(['name', 'first_name', 'middle_name', 'last_name', 'email', 'contact_number']))
        <div class="prf-alert prf-alert-error" role="alert" style="margin-top: 0; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0Z"/></svg>
            <span>Your changes were not saved. Please check the highlighted fields.</span>
        </div>
    @endif

    <div class="prf-grid prf-grid-3">
        @if ($piIsMother)
            <div class="prf-field prf-span-all{{ $piHas('name') }}">
                <label for="name" class="prf-label">Account Name <span class="prf-req">*</span></label>
                <input id="name" name="name" type="text" class="prf-input" value="{{ old('name', $user->name) }}" maxlength="255" required autocomplete="name" {!! $piInvalid('name') !!}>
                <p class="prf-hint">Shown in your Mother Portal. The name on your maternal record is kept by the Rural Health Unit.</p>
                @error('name') <p class="prf-error" id="name_error">{{ $message }}</p> @enderror
            </div>
        @else
            <div class="prf-field{{ $piHas('first_name') }}">
                <label for="first_name" class="prf-label">First Name <span class="prf-req">*</span></label>
                <input id="first_name" name="first_name" type="text" class="prf-input" value="{{ old('first_name', $user->first_name) }}" maxlength="100" required autocomplete="given-name" {!! $piInvalid('first_name') !!}>
                @error('first_name') <p class="prf-error" id="first_name_error">{{ $message }}</p> @enderror
            </div>
            <div class="prf-field{{ $piHas('middle_name') }}">
                <label for="middle_name" class="prf-label">Middle Name <span class="prf-optional">Optional</span></label>
                <input id="middle_name" name="middle_name" type="text" class="prf-input" value="{{ old('middle_name', $user->middle_name) }}" maxlength="100" autocomplete="additional-name" {!! $piInvalid('middle_name') !!}>
                @error('middle_name') <p class="prf-error" id="middle_name_error">{{ $message }}</p> @enderror
            </div>
            <div class="prf-field{{ $piHas('last_name') }}">
                <label for="last_name" class="prf-label">Last Name <span class="prf-req">*</span></label>
                <input id="last_name" name="last_name" type="text" class="prf-input" value="{{ old('last_name', $user->last_name) }}" maxlength="100" required autocomplete="family-name" {!! $piInvalid('last_name') !!}>
                @error('last_name') <p class="prf-error" id="last_name_error">{{ $message }}</p> @enderror
            </div>
        @endif
    </div>

    <p class="prf-subhead">Contact details</p>

    <div class="prf-grid">
        <div class="prf-field{{ $piHas('email') }}">
            <label for="email" class="prf-label">
                Email Address
                @if ($piIsMother) <span class="prf-optional">Optional</span> @else <span class="prf-req">*</span> @endif
            </label>
            <input id="email" name="email" type="email" class="prf-input" value="{{ old('email', $user->email) }}" maxlength="255"
                   @unless ($piIsMother) required @endunless autocomplete="email" placeholder="name@example.com" {!! $piInvalid('email') !!}>
            <p class="prf-hint">Each email address can belong to only one CareCradle account.</p>
            @error('email') <p class="prf-error" id="email_error">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="prf-hint">
                    Your email address is unverified.
                    <button form="send-verification" class="prf-btn prf-btn-secondary" style="min-height: 2rem; margin-top: 0.375rem;">Resend verification email</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="prf-hint" style="color: #047857;">A new verification link has been sent to your email address.</p>
                @endif
            @endif
        </div>

        <div class="prf-field{{ $piHas('contact_number') }}">
            <label for="contact_number" class="prf-label">
                Mobile Number
                @if ($piIsMother) <span class="prf-req">*</span> @else <span class="prf-optional">Optional</span> @endif
            </label>
            <input id="contact_number" name="contact_number" type="tel" class="prf-input" inputmode="tel" maxlength="20"
                   value="{{ old('contact_number', $piIsMother ? $user->mother->contact_number : $user->contact_number) }}"
                   @if ($piIsMother) required @endif autocomplete="tel" placeholder="09171234567" {!! $piInvalid('contact_number') !!}>
            <p class="prf-hint">
                @if ($piIsMother)
                    Appointment reminders and SMS password recovery use this number. Reminders not yet sent will go to your new number; messages already sent keep the number they were sent to.
                @else
                    Philippine mobile number, e.g. 09171234567 or +63 917 123 4567.
                @endif
            </p>
            @error('contact_number') <p class="prf-error" id="contact_number_error">{{ $message }}</p> @enderror
        </div>
    </div>

    <p class="prf-subhead">Account</p>

    <dl class="prf-grid" style="margin: 0;">
        <div class="prf-field">
            <dt class="prf-label">Username</dt>
            <dd class="prf-readonly" style="margin: 0;">{{ $user->username }}</dd>
        </div>
        <div class="prf-field">
            <dt class="prf-label">{{ $piIsMother ? 'Mother Code' : 'Role' }}</dt>
            <dd class="prf-readonly" style="margin: 0;">{{ $piIsMother ? $user->mother->mother_code : $user->role }}</dd>
        </div>
    </dl>
    <p class="prf-hint">The username {{ $piIsMother ? 'and mother code are' : 'and role are' }} managed by {{ $piIsMother ? 'the Rural Health Unit' : 'an administrator' }}.</p>

    <div class="prf-actions">
        <p class="prf-actions-note">Fields marked <span class="prf-req">*</span> are required. Nothing is sent by SMS when you save.</p>
        <div class="prf-actions-buttons">
            <button type="submit" class="prf-btn prf-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                Save Changes
            </button>
        </div>
    </div>
</form>
