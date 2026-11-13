<x-app-layout>

    <style>
        .mthp-avatar-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.55rem;
            flex-shrink: 0;
        }

        .mthp-avatar-photo {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }

        .mthp-avatar-initials {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
        }

        .mthp-photo-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
        }

        .mthp-photo-button,
        .mthp-photo-save,
        .mthp-photo-remove {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            border: 1px solid #fbcfe8;
            border-radius: 999px;
            padding: 0.48rem 0.8rem;
            background: #fff;
            color: #be185d;
            font: inherit;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 160ms ease, color 160ms ease, border-color 160ms ease;
        }

        .mthp-photo-button svg {
            width: 15px;
            height: 15px;
        }

        .mthp-photo-button:hover,
        .mthp-photo-save:hover {
            background: #db2777;
            border-color: #db2777;
            color: #fff;
        }

        .mthp-photo-save {
            background: #db2777;
            border-color: #db2777;
            color: #fff;
        }

        .mthp-photo-remove {
            border-color: #e2e8f0;
            color: #64748b;
        }

        .mthp-photo-remove:hover {
            background: #fff1f2;
            border-color: #fecdd3;
            color: #be123c;
        }

        .mthp-photo-help {
            margin: 0;
            color: #64748b;
            font-size: 0.68rem;
            text-align: center;
        }

        .mthp-photo-alert {
            margin: 0 0 1rem;
            padding: 0.85rem 1rem;
            border: 1px solid;
            border-radius: 0.85rem;
            font-size: 0.875rem;
        }

        .mthp-photo-alert-success {
            border-color: #a7f3d0;
            background: #ecfdf5;
            color: #065f46;
        }

        .mthp-photo-alert-error {
            border-color: #fecdd3;
            background: #fff1f2;
            color: #9f1239;
        }

        .mthp-photo-alert ul {
            margin: 0.35rem 0 0;
            padding-left: 1.25rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .mthp-photo-button,
            .mthp-photo-save,
            .mthp-photo-remove {
                transition: none;
            }
        }

        /* =====================================================
           MOTHER PROFILE — REFINED PROFILE HERO
           Visual-only overrides; upload forms and routes unchanged.
           ===================================================== */

        .mthp-hero {
            position: relative;
            overflow: hidden;
            border: 1px solid #fbcfe8;
            border-radius: 1.5rem;
            padding: clamp(1.25rem, 3vw, 2rem);
            color: #831843;
            background:
                radial-gradient(circle at 95% 0%, rgba(249, 168, 212, 0.25), transparent 28%),
                linear-gradient(125deg, #fff 0%, #fff5fa 54%, #fce7f3 100%);
            box-shadow: 0 14px 36px rgba(190, 24, 93, 0.09);
        }

        .mthp-hero-glow {
            pointer-events: none;
            opacity: 0.45;
        }

        .mthp-hero-glow-a {
            width: 230px;
            height: 230px;
            top: -145px;
            right: -75px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.18), transparent 70%);
        }

        .mthp-hero-glow-b {
            width: 160px;
            height: 160px;
            right: 24%;
            bottom: -120px;
            background: radial-gradient(circle, rgba(244, 114, 182, 0.16), transparent 70%);
        }

        .mthp-hero-inner {
            position: relative;
            z-index: 1;
        }

        .mthp-profile-main {
            display: grid;
            grid-template-columns: minmax(285px, auto) minmax(0, 1fr);
            align-items: center;
            gap: clamp(1.25rem, 3vw, 2.25rem);
            width: 100%;
        }

        .mthp-avatar-area {
            display: grid;
            grid-template-columns: 104px minmax(130px, 1fr);
            grid-template-rows: auto auto;
            align-items: center;
            gap: 0.55rem 1rem;
            min-width: 0;
        }

        .mthp-avatar {
            grid-column: 1;
            grid-row: 1 / span 2;
            width: 104px;
            height: 104px;
            overflow: hidden;
            border: 4px solid #fff;
            border-radius: 50%;
            background: #fce7f3;
            color: #be185d;
            box-shadow: 0 0 0 1px #f9a8d4, 0 8px 22px rgba(190, 24, 93, 0.14);
        }

        .mthp-photo-form {
            grid-column: 2;
            align-items: flex-start;
            justify-content: center;
            gap: 0.4rem;
            min-width: 0;
        }

        .mthp-photo-button,
        .mthp-photo-save,
        .mthp-photo-remove {
            min-height: 36px;
            padding: 0.55rem 0.85rem;
            font-size: 0.75rem;
            box-shadow: 0 2px 7px rgba(190, 24, 93, 0.06);
        }

        .mthp-photo-button {
            border-color: #f9a8d4;
            color: #9d174d;
        }

        .mthp-photo-button:hover,
        .mthp-photo-save:hover {
            background: #be185d;
            border-color: #be185d;
            color: #fff;
            transform: translateY(-1px);
        }

        .mthp-photo-save {
            background: #be185d;
            border-color: #be185d;
            color: #fff;
        }

        .mthp-photo-remove-form {
            grid-column: 2;
            align-self: start;
        }

        .mthp-photo-remove {
            min-height: 32px;
            padding: 0.4rem 0.75rem;
            background: rgba(255, 255, 255, 0.8);
            border-color: #fbcfe8;
            color: #9f1239;
        }

        .mthp-photo-remove:hover {
            background: #fff1f2;
            border-color: #fda4af;
            color: #9f1239;
        }

        .mthp-photo-help {
            color: #9f5676;
            font-size: 0.68rem;
            line-height: 1.45;
            text-align: left;
        }

        .mthp-profile-copy {
            min-width: 0;
            padding: 0.25rem 0;
        }

        .mthp-eyebrow {
            margin-bottom: 0.45rem;
            color: #be185d;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .mthp-title {
            margin: 0 0 0.8rem;
            color: #831843;
            font-size: clamp(1.8rem, 3.4vw, 2.65rem);
            line-height: 1.12;
            overflow-wrap: anywhere;
        }

        .mthp-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .mthp-chip {
            border: 1px solid #fbcfe8;
            background: rgba(255, 255, 255, 0.82);
            color: #9d174d;
        }

        @media (max-width: 760px) {
            .mthp-hero {
                border-radius: 1.2rem;
                padding: 1.15rem;
            }

            .mthp-profile-main {
                grid-template-columns: minmax(0, 1fr);
                gap: 1.25rem;
            }

            .mthp-avatar-area {
                grid-template-columns: 84px minmax(0, 1fr);
                gap: 0.5rem 0.85rem;
            }

            .mthp-avatar {
                width: 84px;
                height: 84px;
            }

            .mthp-title {
                font-size: clamp(1.65rem, 7vw, 2.15rem);
            }

            .mthp-profile-copy {
                padding-top: 0;
            }
        }

        @media (max-width: 420px) {
            .mthp-avatar-area {
                grid-template-columns: 72px minmax(0, 1fr);
                column-gap: 0.7rem;
            }

            .mthp-avatar {
                width: 72px;
                height: 72px;
            }

            .mthp-photo-button,
            .mthp-photo-save,
            .mthp-photo-remove {
                min-height: 34px;
                padding: 0.45rem 0.65rem;
                font-size: 0.7rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mthp-photo-button,
            .mthp-photo-save,
            .mthp-photo-remove {
                transition: none;
            }

            .mthp-photo-button:hover,
            .mthp-photo-save:hover {
                transform: none;
            }
        }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('mthp-profile-photo-input');
            const preview = document.getElementById('mthp-avatar-preview');
            const saveButton = document.getElementById('mthp-photo-save');

            if (!input || !preview || !saveButton) {
                return;
            }

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    saveButton.hidden = true;
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                if (!allowedTypes.includes(file.type)) {
                    alert('Please choose a JPG, PNG, or WebP image.');
                    this.value = '';
                    saveButton.hidden = true;
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Please choose an image smaller than 2 MB.');
                    this.value = '';
                    saveButton.hidden = true;
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    preview.innerHTML = '';
                    const image = document.createElement('img');
                    image.src = event.target.result;
                    image.alt = 'Selected profile photo preview';
                    image.className = 'mthp-avatar-photo';
                    preview.appendChild(image);
                    saveButton.hidden = false;
                };

                reader.readAsDataURL(file);
            });
        });
    </script>



    <div class="mthp-wrap">

        <div class="mthp-container">

        {{-- =====================================================
     PAGE HEADER
     ===================================================== --}}
<div class="mthp-page-head">

    <button
        type="button"
        onclick="window.history.back()"
        aria-label="Go back"
        class="mthp-back-btn"
    >
        <svg
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2.5"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19l-7-7 7-7"
            />
        </svg>
    </button>

    <div class="mthp-page-copy">

        <span>Account</span>

        <h1>My Profile</h1>

        <p>Review your personal details and maternal health information in one place.</p>

    </div>

</div>

            @if (session('success'))
                <div class="mthp-photo-alert mthp-photo-alert-success" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('profile_photo'))
                <div class="mthp-photo-alert mthp-photo-alert-error" role="alert">
                    <strong>We couldn't upload that photo.</strong>
                    <ul>
                        @foreach ($errors->get('profile_photo') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- =====================================================
                 PROFILE HERO
                 ===================================================== --}}
            <section class="mthp-hero">

                <div class="mthp-hero-glow mthp-hero-glow-a"></div>
                <div class="mthp-hero-glow mthp-hero-glow-b"></div>

                <div class="mthp-hero-inner">

                    <div class="mthp-profile-main">

                        <div class="mthp-avatar-area">
                            <div class="mthp-avatar" id="mthp-avatar-preview">
                                @if ($mother->profile_photo_path)
                                    <img
                                        src="{{ asset('storage/' . $mother->profile_photo_path) }}"
                                        alt="Profile photo of {{ $mother->first_name }} {{ $mother->last_name }}"
                                        class="mthp-avatar-photo"
                                    >
                                @else
                                    <span class="mthp-avatar-initials">
                                        {{ strtoupper(
                                            substr($mother->first_name ?? '', 0, 1) .
                                            substr($mother->last_name ?? '', 0, 1)
                                        ) }}
                                    </span>
                                @endif
                            </div>

                            <form
                                action="{{ route('mother.profile.photo.update') }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="mthp-photo-form"
                            >
                                @csrf
                                <input
                                    type="file"
                                    name="profile_photo"
                                    id="mthp-profile-photo-input"
                                    accept="image/jpeg,image/png,image/webp"
                                    hidden
                                    required
                                >
                                <label for="mthp-profile-photo-input" class="mthp-photo-button">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5h3l1.5-2h7l1.5 2h3A1.5 1.5 0 0121.5 9v9A1.5 1.5 0 0120 19.5H4A1.5 1.5 0 012.5 18V9A1.5 1.5 0 014 7.5Z"/>
                                        <circle cx="12" cy="13" r="3.25"/>
                                    </svg>
                                    Choose photo
                                </label>
                                <p class="mthp-photo-help">JPG, PNG, or WebP · Max 2 MB</p>
                                <button type="submit" class="mthp-photo-save" id="mthp-photo-save" hidden>
                                    Save photo
                                </button>
                            </form>

                            @if ($mother->profile_photo_path)
                                <form
                                    action="{{ route('mother.profile.photo.remove') }}"
                                    method="POST"
                                    class="mthp-photo-remove-form"
                                    onsubmit="return confirm('Remove your profile photo?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mthp-photo-remove">Remove photo</button>
                                </form>
                            @endif
                        </div>

                        <div class="mthp-profile-copy">

                            <p class="mthp-eyebrow">
                                My Profile
                            </p>

                            <h1 class="mthp-title">
                                {{ $mother->first_name }} {{ $mother->last_name }}
                            </h1>

                            <div class="mthp-meta">

                                @if(isset($mother->mother_code))
                                    <span class="mthp-chip mthp-chip-code">
                                        {{ $mother->mother_code }}
                                    </span>
                                @endif

                                @if(isset($mother->birth_date))
                                    <span class="mthp-chip">
                                        {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                                    </span>
                                @endif

                                {{-- Pregnancy status and referral are shown separately.
                                     An older "Referred" record has no confirmed pregnancy
                                     status: shown as "To be confirmed" (nothing is changed). --}}
                                @if(isset($mother->status))
                                    <span class="mthp-chip mthp-chip-status" title="Pregnancy status">
                                        {{ $mother->isLegacyReferred() ? 'To be confirmed' : $mother->status }}
                                    </span>

                                    @if($mother->isReferred())
                                        <a href="{{ route('mother.referrals') }}" class="mthp-chip" title="View my referrals"
                                           style="color:#9d174d;background:#fdf2f7;border-color:#f8d3e2;text-decoration:none;">
                                            Referred
                                        </a>
                                    @endif
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                 PERSONAL INFORMATION
                 ===================================================== --}}
            <section class="mthp-section">

                <div class="mthp-section-heading">
                    <div>
                        <span>Personal Details</span>
                        <h2>Personal Information</h2>
                    </div>

                    <p>Your registered personal information</p>
                </div>

                <div class="mthp-card">

                    {{-- Full Name --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-pink">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Full Name</p>
                            <p class="mthp-value">
                                {{ trim(
                                    ($mother->first_name ?? '') . ' ' .
                                    ($mother->middle_name ?? '') . ' ' .
                                    ($mother->last_name ?? '')
                                ) ?: '—' }}
                            </p>
                        </div>
                    </div>


                    {{-- Date of Birth --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-fuchsia">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Date of Birth</p>
                            <p class="mthp-value">
                                {{ isset($mother->birth_date)
                                    ? \Carbon\Carbon::parse($mother->birth_date)->format('F d, Y')
                                    : '—' }}
                            </p>
                        </div>
                    </div>


                    {{-- Age --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-rose">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Age</p>
                            <p class="mthp-value">
                                {{ isset($mother->birth_date)
                                    ? \Carbon\Carbon::parse($mother->birth_date)->age . ' years old'
                                    : '—' }}
                            </p>
                        </div>
                    </div>


                    {{-- Contact Number --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-pink">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Contact Number</p>
                            <p class="mthp-value">
                                {{ $mother->contact_number ?? '—' }}
                            </p>
                            {{-- The registered mobile number is changed in Account Settings (profile.edit). --}}
                            <a href="{{ route('profile.edit') }}#personal-information"
                               style="display: inline-block; margin-top: 0.25rem; color: #be185d; font-size: 0.75rem; font-weight: 600; text-decoration: underline; text-underline-offset: 3px;">
                                Update mobile number
                            </a>
                        </div>
                    </div>


                    {{-- Address --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-fuchsia">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Address</p>
                            <p class="mthp-value mthp-break">
                                {{ trim(
                                    ($mother->address ?? '') .
                                    (isset($mother->barangay)
                                        ? ', ' . $mother->barangay
                                        : '')
                                ) ?: '—' }}
                            </p>
                        </div>
                    </div>


                    {{-- Civil Status --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-rose">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5V12a1.5 1.5 0 011.5-1.5z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Civil Status</p>
                            <p class="mthp-value">
                                {{ $mother->civil_status ?? '—' }}
                            </p>
                        </div>
                    </div>

                </div>

            </section>


            {{-- =====================================================
                 FATHER'S INFORMATION
                 ===================================================== --}}
            <section class="mthp-section">

                <div class="mthp-section-heading">
                    <div>
                        <span>Family Details</span>
                        <h2>Father's Information</h2>
                    </div>

                    <p>Father's personal and contact details</p>
                </div>

                <div class="mthp-card">

                    {{-- Full Name --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-pink">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Full Name</p>
                            <p class="mthp-value">
                                {{ trim(
                                    ($mother->father_first_name ?? '') . ' ' .
                                    ($mother->father_middle_name ?? '') . ' ' .
                                    ($mother->father_last_name ?? '')
                                ) ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    {{-- Birth Date --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-fuchsia">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Date of Birth</p>
                            <p class="mthp-value">
                                {{ $mother->father_birth_date
                                    ? \Carbon\Carbon::parse($mother->father_birth_date)->format('F d, Y')
                                    : 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    {{-- Contact Number --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-rose">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Contact Number</p>
                            <p class="mthp-value">
                                {{ $mother->father_contact_number ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    {{-- Occupation --}}
                    <div class="mthp-info-row">
                        <div class="mthp-info-icon mthp-icon-fuchsia">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3.75 7.5h16.5v12h-16.5v-12ZM9 7.5V5.25A1.5 1.5 0 0110.5 3.75h3A1.5 1.5 0 0115 5.25V7.5M3.75 12h16.5"/>
                            </svg>
                        </div>

                        <div class="mthp-info-content">
                            <p class="mthp-label">Occupation</p>
                            <p class="mthp-value">
                                {{ $mother->father_occupation ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                </div>

            </section>

            {{-- =====================================================
                 MATERNAL INFORMATION
                 ===================================================== --}}
            <section class="mthp-section">

                <div class="mthp-section-heading">
                    <div>
                        <span>Pregnancy Details</span>
                        <h2>Maternal Information</h2>
                    </div>

                    <p>Current maternal health details</p>
                </div>

                <div class="mthp-card mthp-maternal-card">

                    @if(isset($mother->pregnancy_week))
                        <div class="mthp-detail-card mthp-detail-pink">
                            <div class="mthp-detail-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>

                            <div>
                                <p>Pregnancy Week</p>
                                <strong>Week {{ $mother->pregnancy_week }}</strong>
                            </div>
                        </div>
                    @endif


                    @if(isset($mother->trimester))
                        <div class="mthp-detail-card mthp-detail-fuchsia">
                            <div class="mthp-detail-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 3v18M3 12h18"/>
                                </svg>
                            </div>

                            <div>
                                <p>Trimester</p>
                                <strong>{{ $mother->trimester }}</strong>
                            </div>
                        </div>
                    @endif


                    @if(isset($mother->expected_delivery_date))
                        <div class="mthp-detail-card mthp-detail-rose">
                            <div class="mthp-detail-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                </svg>
                            </div>

                            <div>
                                <p>Expected Delivery</p>
                                <strong>
                                    {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('M d, Y') }}
                                </strong>
                            </div>
                        </div>
                    @endif


                    @if(isset($mother->blood_type))
                        <div class="mthp-detail-card mthp-detail-slate">
                            <div class="mthp-detail-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 3.75s6 6.27 6 10.125a6 6 0 11-12 0C6 10.02 12 3.75 12 3.75Z"/>
                                </svg>
                            </div>

                            <div>
                                <p>Blood Type</p>
                                <strong>{{ $mother->blood_type }}</strong>
                            </div>
                        </div>
                    @endif


                    {{-- Risk Status --}}
                    @if(isset($mother->risk_status))

                        @php
                            $riskClass = match($mother->risk_status) {
                                'High Risk' => 'mthp-risk-high',
                                'Moderate Risk' => 'mthp-risk-moderate',
                                default => 'mthp-risk-normal',
                            };
                        @endphp

                        <div class="mthp-risk {{ $riskClass }}">

                            <div class="mthp-risk-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM10.29 3.86 2.82 17.1a1.75 1.75 0 001.52 2.63h15.32a1.75 1.75 0 001.52-2.63L13.71 3.86a1.75 1.75 0 00-3.42 0Z"/>
                                </svg>
                            </div>

                            <div>
                                <p>Risk Status</p>
                                <strong>{{ $mother->risk_status }}</strong>
                            </div>

                        </div>

                    @endif


                    @if(
                        !isset($mother->pregnancy_week) &&
                        !isset($mother->trimester) &&
                        !isset($mother->expected_delivery_date) &&
                        !isset($mother->blood_type) &&
                        !isset($mother->risk_status)
                    )

                        <div class="mthp-empty">
                            No maternal information on file yet.
                        </div>

                    @endif

                </div>

            </section>


            {{-- =====================================================
                 EMERGENCY CONTACT
                 ===================================================== --}}
            @if(isset($mother->emergency_contact_name) || isset($mother->emergency_contact_number))

                <section class="mthp-section">

                    <div class="mthp-section-heading">
                        <div>
                            <span>Important Contact</span>
                            <h2>Emergency Contact</h2>
                        </div>
                    </div>

                    <div class="mthp-emergency">

                        <div class="mthp-emergency-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                        </div>

                        <div class="mthp-emergency-content">

                            <p class="mthp-emergency-name">
                                {{ $mother->emergency_contact_name ?? '—' }}
                            </p>

                            <p class="mthp-emergency-number">
                                {{ $mother->emergency_contact_number ?? '—' }}
                            </p>

                        </div>

                    </div>

                </section>

            @endif


</x-app-layout>











