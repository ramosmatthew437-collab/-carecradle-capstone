{{--
    Change password (PUT password.change, error bag "updatePassword").
    Fields and security rules are unchanged (Auth\PasswordController).
--}}
@php
    $pwBag = $errors->updatePassword;
    $pwHas = fn (string $field) => $pwBag->has($field) ? ' has-error' : '';
@endphp

<form method="post" action="{{ route('password.change') }}">
    @csrf
    @method('put')

    <div class="prf-grid">
        <div class="prf-field prf-span-all{{ $pwHas('current_password') }}" style="max-width: 26rem;">
            <label for="update_password_current_password" class="prf-label">Current Password <span class="prf-req">*</span></label>
            <input id="update_password_current_password" name="current_password" type="password" class="prf-input" autocomplete="current-password" required
                   @if ($pwBag->has('current_password')) aria-invalid="true" aria-describedby="current_password_error" @endif>
            @if ($pwBag->has('current_password')) <p class="prf-error" id="current_password_error">{{ $pwBag->first('current_password') }}</p> @endif
        </div>

        <div class="prf-field{{ $pwHas('password') }}">
            <label for="update_password_password" class="prf-label">New Password <span class="prf-req">*</span></label>
            <input id="update_password_password" name="password" type="password" class="prf-input" autocomplete="new-password" required
                   @if ($pwBag->has('password')) aria-invalid="true" aria-describedby="password_error" @endif>
            @if ($pwBag->has('password')) <p class="prf-error" id="password_error">{{ $pwBag->first('password') }}</p> @endif
        </div>

        <div class="prf-field{{ $pwHas('password_confirmation') }}">
            <label for="update_password_password_confirmation" class="prf-label">Confirm New Password <span class="prf-req">*</span></label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="prf-input" autocomplete="new-password" required>
            @if ($pwBag->has('password_confirmation')) <p class="prf-error">{{ $pwBag->first('password_confirmation') }}</p> @endif
        </div>
    </div>

    <div class="prf-actions">
        <p class="prf-actions-note">You stay signed in after changing your password.</p>
        <div class="prf-actions-buttons">
            <button type="submit" class="prf-btn prf-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                Update Password
            </button>
        </div>
    </div>
</form>
