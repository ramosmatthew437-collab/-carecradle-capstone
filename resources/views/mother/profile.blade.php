<x-app-layout>

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

        <p>View your personal and maternal information</p>

    </div>

</div>

            {{-- =====================================================
                 PROFILE HERO
                 ===================================================== --}}
            <section class="mthp-hero">

                <div class="mthp-hero-glow mthp-hero-glow-a"></div>
                <div class="mthp-hero-glow mthp-hero-glow-b"></div>

                <div class="mthp-hero-inner">

                    <div class="mthp-profile-main">

                        <div class="mthp-avatar">
                            {{ strtoupper(
                                substr($mother->first_name ?? '', 0, 1) .
                                substr($mother->last_name ?? '', 0, 1)
                            ) }}
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

                                @if(isset($mother->status))
                                    <span class="mthp-chip mthp-chip-status">
                                        {{ $mother->status }}
                                    </span>
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

        </div>

    </div>

</x-app-layout>