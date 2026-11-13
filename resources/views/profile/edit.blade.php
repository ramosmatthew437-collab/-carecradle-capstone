<x-app-layout>
    @include('profile._styles')

    @php
        $prfUser = auth()->user();
        $prfIsMother = $prfUser->isMother() && $prfUser->mother;
        $prfPortal = $prfUser->isMidwife() ? 'Midwife Portal' : ($prfUser->isAdministrator() ? 'Administrator Portal' : 'Mother Portal');

        // Current photo: staff photos live on the user account, a mother's on her Mother record.
        $prfPhotoUrl = null;
        if ($prfIsMother && $prfUser->mother->profile_photo_path) {
            $prfPhotoUrl = asset('storage/' . $prfUser->mother->profile_photo_path);
        } elseif (! $prfIsMother && $prfUser->profile_photo_path) {
            $prfPhotoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($prfUser->profile_photo_path);
        }

        $prfInitials = $prfIsMother
            ? strtoupper(substr($prfUser->mother->first_name ?? '', 0, 1) . substr($prfUser->mother->last_name ?? '', 0, 1))
            : strtoupper(substr($prfUser->first_name ?: $prfUser->name, 0, 1) . substr($prfUser->last_name ?? '', 0, 1));
    @endphp

    <div class="prf">
        <div class="prf-container">

            {{-- Header --}}
            <header class="prf-head">
                <div class="prf-identity">
                    <div class="prf-avatar">
                        @if ($prfPhotoUrl)
                            <img src="{{ $prfPhotoUrl }}" alt="Profile photo of {{ $prfUser->name }}">
                        @else
                            <span aria-hidden="true">{{ $prfInitials }}</span>
                        @endif
                    </div>
                    <div style="min-width: 0;">
                        <p class="prf-kicker">{{ $prfPortal }} · Account</p>
                        <h1 class="prf-title">My Profile</h1>
                        <p class="prf-subtitle">Manage your personal information and keep your CareCradle account secure.</p>
                    </div>
                </div>
                <nav class="prf-nav" aria-label="Account settings sections">
                    <a href="#personal-information">Personal information</a>
                    @if ($prfUser->isMidwife() || $prfIsMother)
                        <a href="#profile-photo">Profile photo</a>
                    @endif
                    <a href="#account-security">Password</a>
                    @if ($prfIsMother)
                        <a href="#account-closure">Account closure</a>
                    @else
                        <a href="#delete-account">Delete account</a>
                    @endif
                </nav>
            </header>

            @if (session('status') === 'profile-updated')
                <div class="prf-alert prf-alert-success" role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Your profile information has been saved.
                </div>
            @elseif (session('status') === 'password-updated')
                <div class="prf-alert prf-alert-success" role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Your password has been changed.
                </div>
            @elseif (session('success'))
                <div class="prf-alert prf-alert-success" role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Personal information --}}
            <section class="prf-card" id="personal-information" aria-labelledby="prf-info-title">
                <div class="prf-card-head">
                    <span class="prf-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    </span>
                    <div>
                        <h2 class="prf-card-title" id="prf-info-title">Personal Information</h2>
                        <p class="prf-card-sub">
                            {{ $prfIsMother ? 'Your account name, email address, and registered mobile number.' : 'Your name, email address, and contact number.' }}
                        </p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </section>

            {{-- Profile photo --}}
            @if ($prfUser->isMidwife())
                <section class="prf-card" id="profile-photo" aria-labelledby="prf-photo-title">
                    <div class="prf-card-head">
                        <span class="prf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/></svg>
                        </span>
                        <div>
                            <h2 class="prf-card-title" id="prf-photo-title">Profile Photo</h2>
                            <p class="prf-card-sub">Shown in the Midwife Portal sidebar.</p>
                        </div>
                    </div>

                    <div class="prf-photo">
                        <div class="prf-avatar prf-avatar-lg">
                            @if ($prfPhotoUrl)
                                <img src="{{ $prfPhotoUrl }}" alt="Current profile photo">
                            @else
                                <span aria-hidden="true">{{ $prfInitials }}</span>
                            @endif
                        </div>
                        <div class="prf-photo-body">
                            <form method="POST" action="{{ route('midwife.profile-photo.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="prf-file">
                                    <label class="prf-file-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                                        Choose photo
                                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" required data-prf-file aria-describedby="prf-photo-hint">
                                    </label>
                                    <span class="prf-file-name" data-prf-file-name>No file chosen</span>
                                </div>
                                <p class="prf-hint" id="prf-photo-hint">JPG, PNG, or WebP · up to 2 MB.</p>
                                @error('profile_photo') <p class="prf-error">{{ $message }}</p> @enderror
                                <div class="prf-actions-buttons" style="margin-top: 0.875rem;">
                                    <button type="submit" class="prf-btn prf-btn-primary">Upload Photo</button>
                                </div>
                            </form>
                            @if ($prfPhotoUrl)
                                <form method="POST" action="{{ route('midwife.profile-photo.destroy') }}" style="margin-top: 0.5rem;"
                                      onsubmit="return confirm('Remove your profile photo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="prf-btn prf-btn-danger">Remove Photo</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </section>
            @elseif ($prfIsMother)
                <section class="prf-card" id="profile-photo" aria-labelledby="prf-photo-title">
                    <div class="prf-card-head">
                        <span class="prf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 9.574c0-1.067.75-1.994 1.802-2.169l1.134-.175a2.31 2.31 0 0 0 1.64-1.055l.822-1.316a2.192 2.192 0 0 1 1.736-1.039 48.774 48.774 0 0 1 5.232 0 2.192 2.192 0 0 1 1.736 1.039l.821 1.316a2.31 2.31 0 0 0 1.64 1.055l1.135.175c1.052.175 1.802 1.102 1.802 2.169V18a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 18V9.574Z"/></svg>
                        </span>
                        <div>
                            <h2 class="prf-card-title" id="prf-photo-title">Profile Photo</h2>
                            <p class="prf-card-sub">Your photo and your maternal record details are on My Profile.</p>
                        </div>
                    </div>
                    <div class="prf-photo">
                        <div class="prf-avatar prf-avatar-lg">
                            @if ($prfPhotoUrl)
                                <img src="{{ $prfPhotoUrl }}" alt="Current profile photo">
                            @else
                                <span aria-hidden="true">{{ $prfInitials }}</span>
                            @endif
                        </div>
                        <div class="prf-photo-body">
                            <p class="prf-hint" style="margin-top: 0;">Upload, replace, or remove your photo from your My Profile page (JPG, PNG, or WebP · up to 2 MB).</p>
                            <div class="prf-actions-buttons" style="margin-top: 0.75rem;">
                                <a href="{{ route('mother.profile') }}" class="prf-btn prf-btn-secondary">Go to My Profile</a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Password --}}
            <section class="prf-card" id="account-security" aria-labelledby="prf-security-title">
                <div class="prf-card-head">
                    <span class="prf-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                    </span>
                    <div>
                        <h2 class="prf-card-title" id="prf-security-title">Password</h2>
                        <p class="prf-card-sub">Use a strong password that you do not use anywhere else.</p>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </section>

            @if ($prfIsMother)
                {{-- Mothers cannot self-delete (it would remove maternal clinical history); enforced in ProfileController::destroy. --}}
                <section class="prf-card" id="account-closure" aria-labelledby="prf-closure-title">
                    <div class="prf-card-head">
                        <span class="prf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                        </span>
                        <div>
                            <h2 class="prf-card-title" id="prf-closure-title">Account Closure</h2>
                            <p class="prf-card-sub">Your maternal health records are kept by the Rural Health Unit.</p>
                        </div>
                    </div>
                    <p class="prf-hint" style="margin: 0; font-size: 0.8125rem;">
                        Mother accounts cannot be deleted from the Mother Portal. To close or deactivate your account,
                        please contact an authorized RHU administrator.
                    </p>
                </section>
            @else
            {{-- Delete account: existing behaviour preserved for Administrator and Midwife accounts --}}
            <section class="prf-card prf-card-danger" id="delete-account" aria-labelledby="prf-delete-title">
                <div class="prf-card-head">
                    <span class="prf-card-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    </span>
                    <div>
                        <h2 class="prf-card-title" id="prf-delete-title">Delete Account</h2>
                        <p class="prf-card-sub">Permanently remove this account. This cannot be undone.</p>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </section>
            @endif

        </div>
    </div>

    <script>
        (function () {
            var input = document.querySelector('[data-prf-file]');
            var label = document.querySelector('[data-prf-file-name]');
            if (!input || !label) return;
            input.addEventListener('change', function () {
                label.textContent = input.files && input.files.length ? input.files[0].name : 'No file chosen';
            });
        })();
    </script>
</x-app-layout>
