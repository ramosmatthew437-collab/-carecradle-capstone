<x-app-layout>

    @php
        // Pregnancy Number → ordinal wording
        $pregnancyOrdinal = match(true) {
            in_array($mother->pregnancy_number % 100, [11, 12, 13]) => $mother->pregnancy_number . 'th',
            $mother->pregnancy_number % 10 == 1 => $mother->pregnancy_number . 'st',
            $mother->pregnancy_number % 10 == 2 => $mother->pregnancy_number . 'nd',
            $mother->pregnancy_number % 10 == 3 => $mother->pregnancy_number . 'rd',
            default => $mother->pregnancy_number . 'th',
        };

        // EDD countdown
        $eddLabel = null;
        $eddTheme = 'mshow-text-pink';

        if ($mother->status === 'Pregnant' && $mother->expected_delivery_date) {
            $edd = \Carbon\Carbon::parse($mother->expected_delivery_date);
            $eddDaysRemaining = today()->diffInDays($edd->copy()->startOfDay(), false);

            if ($eddDaysRemaining < 0) {
                $eddLabel = abs($eddDaysRemaining) . ' ' .
                    \Illuminate\Support\Str::plural('day', abs($eddDaysRemaining)) .
                    ' overdue';

                $eddTheme = 'mshow-text-red';
            } elseif ($eddDaysRemaining <= 7) {
                $eddLabel = 'Due in ' .
                    $eddDaysRemaining . ' ' .
                    \Illuminate\Support\Str::plural('day', $eddDaysRemaining);

                $eddTheme = 'mshow-text-amber';
            } else {
                $eddLabel = 'Due in ' . $eddDaysRemaining . ' days';
            }
        }

        // Blood pressure classification
        $bpTheme = function ($systolic, $diastolic) {
            if ($systolic >= 140 || $diastolic >= 90) {
                return [
                    'classes' => 'mshow-bp-high',
                    'label' => 'High Risk'
                ];
            }

            if ($systolic >= 130 || $diastolic >= 85) {
                return [
                    'classes' => 'mshow-bp-elevated',
                    'label' => 'Elevated'
                ];
            }

            return [
                'classes' => 'mshow-bp-normal',
                'label' => 'Normal'
            ];
        };

        // Latest prenatal visit
        $latestVisit = $mother->prenatalCheckups
            ->sortByDesc('visit_date')
            ->first();

        $latestWeight = optional($latestVisit)->weight ?? $mother->weight;

        // Next upcoming appointment
        $nextAppointment = $mother->appointments
            ->filter(function ($appointment) {
                return $appointment->status === 'Scheduled'
                    && \Carbon\Carbon::parse($appointment->appointment_date)->gte(today());
            })
            ->sortBy('appointment_date')
            ->first();

        // Mother status
        $statusClasses = match($mother->status) {
            'Pregnant' => 'mshow-status-pregnant',
            'Delivered' => 'mshow-status-delivered',
            'Referred' => 'mshow-status-referred',
            default => 'mshow-status-default',
        };

        $statusTextClass = match($mother->status) {
            'Pregnant' => 'mshow-text-emerald',
            'Referred' => 'mshow-text-amber',
            'Delivered' => 'mshow-text-muted',
            default => 'mshow-text-pink',
        };
    @endphp

    <div class="mshow-wrap">
        <div class="mshow-container">

            {{-- =====================================================
                 PAGE HERO
                 ===================================================== --}}

            <section class="mshow-hero">

                <div class="mshow-hero-blob mshow-hero-blob-a"></div>
                <div class="mshow-hero-blob mshow-hero-blob-b"></div>
                <div class="mshow-hero-blob mshow-hero-blob-c"></div>

                <div class="mshow-hero-inner">

                    <div class="mshow-hero-main">

                        <div class="mshow-hero-eyebrow">
                            <div class="mshow-hero-eyebrow-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                </svg>
                            </div>

                            <span>Mother Profile</span>
                        </div>

                        <h1 class="mshow-hero-title">
                            {{ $mother->first_name }} {{ $mother->last_name }}
                        </h1>

                        <p class="mshow-hero-code">
                            {{ $mother->mother_code }}
                        </p>

                        <p class="mshow-hero-description">
                            Complete maternal health record, prenatal care history,
                            appointments, and associated infant records.
                        </p>

                    </div>

                    <div class="mshow-hero-side">

                        <span class="mshow-status {{ $statusClasses }}">
                            <span class="mshow-status-dot"></span>
                            {{ $mother->status }}
                        </span>

                        <div class="mshow-hero-mini">
                            <span>Barangay</span>
                            <strong>{{ $mother->barangay }}</strong>
                        </div>

                    </div>

                </div>
            </section>

            {{-- =====================================================
                 STATISTICS
                 ===================================================== --}}

            <section class="mshow-stats">

                <div class="mshow-stat mshow-stat-pink">
                    <div class="mshow-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 6.75h18M3 12h18M3 17.25h18"/>
                        </svg>
                    </div>

                    <div class="mshow-stat-content">
                        <p class="mshow-stat-label">Prenatal Checkups</p>
                        <p class="mshow-stat-value">
                            {{ $mother->prenatalCheckups->count() }}
                        </p>
                    </div>
                </div>

                <div class="mshow-stat mshow-stat-amber">
                    <div class="mshow-stat-icon">
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

                    <div class="mshow-stat-content">
                        <p class="mshow-stat-label">Appointments</p>
                        <p class="mshow-stat-value">
                            {{ $mother->appointments->count() }}
                        </p>
                    </div>
                </div>

                <div class="mshow-stat mshow-stat-blue">
                    <div class="mshow-stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div class="mshow-stat-content">
                        <p class="mshow-stat-label">Registered Infants</p>
                        <p class="mshow-stat-value">
                            {{ $mother->infants->count() }}
                        </p>
                    </div>
                </div>

            </section>

            {{-- =====================================================
                 CONTACT DETAILS
                 ===================================================== --}}

            <section class="mshow-contact-card">

                <div class="mshow-contact-item">

                    <div class="mshow-contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6M7.5 4.5h9A2.25 2.25 0 0118.75 6.75v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 017.5 4.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="mshow-contact-label">Mother Code</p>
                        <p class="mshow-contact-value">{{ $mother->mother_code }}</p>
                    </div>

                </div>

                <div class="mshow-contact-item">

                    <div class="mshow-contact-icon">
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

                    <div>
                        <p class="mshow-contact-label">Contact Number</p>
                        <p class="mshow-contact-value">{{ $mother->contact_number }}</p>
                    </div>

                </div>

                <div class="mshow-contact-item">

                    <div class="mshow-contact-icon">
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

                    <div>
                        <p class="mshow-contact-label">Barangay</p>
                        <p class="mshow-contact-value">{{ $mother->barangay }}</p>
                    </div>

                </div>

            </section>

            {{-- =====================================================
                 CLINICAL SUMMARY
                 ===================================================== --}}

            <section class="mshow-section">

                <div class="mshow-section-head">

                    <div>
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            At a Glance
                        </p>

                        <h2 class="mshow-section-title">
                            Clinical Summary
                        </h2>

                        <p class="mshow-section-sub">
                            Key indicators for this mother's current care status.
                        </p>
                    </div>

                </div>

                <div class="mshow-metric-grid">

                    {{-- Status --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-emerald">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>

                        <p class="mshow-metric-label">Status</p>

                        <p class="mshow-metric-value {{ $statusTextClass }}">
                            {{ $mother->status }}
                        </p>

                    </div>

                    {{-- EDD --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-pink">
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

                        <p class="mshow-metric-label">Expected Delivery</p>

                        <p class="mshow-metric-value {{ $eddLabel ? $eddTheme : 'mshow-text-muted' }}">
                            {{ $eddLabel ?? '—' }}
                        </p>

                    </div>

                    {{-- Latest BP --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-rose">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"/>
                            </svg>
                        </div>

                        <p class="mshow-metric-label">Latest BP</p>

                        @if($latestVisit)

                            @php
                                $latestBp = $bpTheme(
                                    $latestVisit->systolic_bp,
                                    $latestVisit->diastolic_bp
                                );
                            @endphp

                            <div class="mshow-metric-inline">
                                <p class="mshow-metric-value">
                                    {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                </p>

                                <span class="mshow-bp-badge {{ $latestBp['classes'] }}">
                                    {{ $latestBp['label'] }}
                                </span>
                            </div>

                        @else

                            <p class="mshow-metric-value mshow-text-muted">
                                No data yet
                            </p>

                        @endif

                    </div>

                    {{-- Latest Weight --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-fuchsia">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                            </svg>
                        </div>

                        <p class="mshow-metric-label">Latest Weight</p>

                        <p class="mshow-metric-value">
                            {{ $latestWeight ? number_format($latestWeight, 1) . ' kg' : 'Not recorded' }}
                        </p>

                    </div>

                    {{-- Last Visit --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-sky">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 6.75h18M3 12h18M3 17.25h18"/>
                            </svg>
                        </div>

                        <p class="mshow-metric-label">Last Prenatal Visit</p>

                        <p class="mshow-metric-value">
                            {{ $latestVisit
                                ? \Carbon\Carbon::parse($latestVisit->visit_date)->format('M d, Y')
                                : 'None recorded' }}
                        </p>

                    </div>

                    {{-- Next Appointment --}}
                    <div class="mshow-metric">

                        <div class="mshow-metric-icon mshow-metric-amber">
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

                        <p class="mshow-metric-label">Next Appointment</p>

                        <p class="mshow-metric-value">
                            {{ $nextAppointment
                                ? \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M d, Y')
                                : 'None scheduled' }}
                        </p>

                    </div>

                </div>

            </section>

            {{-- =====================================================
                 QUICK ACTIONS
                 ===================================================== --}}

            <section class="mshow-actions">

                <a href="{{ route('prenatal-checkups.create', $mother->id) }}"
                   class="mshow-action mshow-action-primary">

                    <span class="mshow-action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </span>

                    <span>
                        <strong>Add Prenatal Visit</strong>
                        <small>Record a new prenatal checkup</small>
                    </span>

                    <svg class="mshow-action-arrow"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m9 5 7 7-7 7"/>
                    </svg>

                </a>

                <a href="{{ route('appointments.create', $mother->id) }}"
                   class="mshow-action mshow-action-secondary">

                    <span class="mshow-action-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </span>

                    <span>
                        <strong>Schedule Appointment</strong>
                        <small>Create a new care appointment</small>
                    </span>

                    <svg class="mshow-action-arrow"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m9 5 7 7-7 7"/>
                    </svg>

                </a>

            </section>

            {{-- =====================================================
                 PRENATAL CHECKUPS
                 ===================================================== --}}

            <section class="mshow-card">

                <div class="mshow-card-header">

                    <div>
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            Care History
                        </p>

                        <h2 class="mshow-card-title">
                            Prenatal Checkups
                        </h2>

                        <p class="mshow-section-sub">
                            Complete history of prenatal visits.
                        </p>
                    </div>

                    <span class="mshow-count">
                        {{ $mother->prenatalCheckups->count() }}
                        {{ Str::plural('visit', $mother->prenatalCheckups->count()) }}
                    </span>

                </div>

                @if($mother->prenatalCheckups->count())

                    @php
                        $latestBpHighlight = $bpTheme(
                            $latestVisit->systolic_bp,
                            $latestVisit->diastolic_bp
                        );
                    @endphp

                    {{-- Latest Visit Highlight --}}
                    <div class="mshow-latest">

                        <div class="mshow-latest-header">
                            <span class="mshow-latest-label">Latest Visit</span>

                            <span class="mshow-latest-date">
                                {{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('F d, Y') }}
                            </span>
                        </div>

                        <div class="mshow-latest-grid">

                            <div class="mshow-latest-item">
                                <span>Gestational Age</span>
                                <strong>
                                    {{ $latestVisit->gestational_age_weeks }} wks
                                </strong>
                            </div>

                            <div class="mshow-latest-item">
                                <span>Blood Pressure</span>

                                <div class="mshow-latest-value-row">
                                    <strong>
                                        {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                    </strong>

                                    <span class="mshow-bp-badge {{ $latestBpHighlight['classes'] }}">
                                        {{ $latestBpHighlight['label'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="mshow-latest-item">
                                <span>Weight</span>
                                <strong>
                                    {{ number_format($latestVisit->weight, 1) }} kg
                                </strong>
                            </div>

                        </div>

                    </div>

                    {{-- Desktop Table --}}
                    <div class="mshow-table-wrap">

                        <table class="mshow-table">

                            <thead>
                                <tr>
                                    <th>Visit Date</th>
                                    <th class="center">Gestational Age</th>
                                    <th class="center">Blood Pressure</th>
                                    <th class="center">Weight</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($mother->prenatalCheckups as $visit)

                                    @php
                                        $rowBp = $bpTheme(
                                            $visit->systolic_bp,
                                            $visit->diastolic_bp
                                        );
                                    @endphp

                                    <tr>

                                        <td class="mshow-table-date">
                                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                        </td>

                                        <td class="center">
                                            <span class="mshow-pill mshow-pill-pink">
                                                {{ $visit->gestational_age_weeks }} weeks
                                            </span>
                                        </td>

                                        <td class="center">
                                            <span class="mshow-pill {{ $rowBp['classes'] }}">
                                                {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }}
                                                · {{ $rowBp['label'] }}
                                            </span>
                                        </td>

                                        <td class="center">
                                            {{ number_format($visit->weight, 1) }} kg
                                        </td>

                                        <td class="center">
                                            <a href="{{ route('prenatal-checkups.show', $visit->id) }}"
                                               class="mshow-view-link">
                                                View
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="1.8">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="m9 5 7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- Mobile --}}
                    <div class="mshow-mobile-list">

                        @foreach($mother->prenatalCheckups as $visit)

                            @php
                                $rowBpMobile = $bpTheme(
                                    $visit->systolic_bp,
                                    $visit->diastolic_bp
                                );
                            @endphp

                            <div class="mshow-mobile-item">

                                <div class="mshow-mobile-top">
                                    <strong>
                                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                    </strong>

                                    <span class="mshow-pill mshow-pill-pink">
                                        {{ $visit->gestational_age_weeks }} wks
                                    </span>
                                </div>

                                <div class="mshow-mobile-grid">

                                    <div class="mshow-mobile-box">
                                        <span>Blood Pressure</span>

                                        <strong>
                                            {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }}
                                        </strong>

                                        <small class="{{ $rowBpMobile['classes'] }}">
                                            {{ $rowBpMobile['label'] }}
                                        </small>
                                    </div>

                                    <div class="mshow-mobile-box">
                                        <span>Weight</span>

                                        <strong>
                                            {{ number_format($visit->weight, 1) }} kg
                                        </strong>
                                    </div>

                                </div>

                                <a href="{{ route('prenatal-checkups.show', $visit->id) }}"
                                   class="mshow-mobile-view">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m9 5 7 7-7 7"/>
                                    </svg>
                                </a>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="mshow-empty">

                        <div class="mshow-empty-icon mshow-empty-pink">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M19.5 7.5v9A2.25 2.25 0 0117.25 18.75H6.75A2.25 2.25 0 014.5 16.5v-9A2.25 2.25 0 016.75 5.25h10.5A2.25 2.25 0 0119.5 7.5ZM9 12h6M12 9v6"/>
                            </svg>
                        </div>

                        <h3>No prenatal records found</h3>

                        <p>
                            No prenatal visits have been recorded for this mother yet.
                        </p>

                        <a href="{{ route('prenatal-checkups.create', $mother->id) }}"
                           class="mshow-empty-button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add First Prenatal Visit
                        </a>

                    </div>

                @endif

            </section>

            {{-- =====================================================
                 APPOINTMENTS
                 ===================================================== --}}

            <section class="mshow-card">

                <div class="mshow-card-header">

                    <div>
                        <p class="mshow-section-kicker mshow-kicker-amber">
                            <span class="mshow-section-kicker-dot"></span>
                            Scheduling
                        </p>

                        <h2 class="mshow-card-title">
                            Appointments
                        </h2>

                        <p class="mshow-section-sub">
                            Upcoming and completed appointments.
                        </p>
                    </div>

                    <span class="mshow-count">
                        {{ $mother->appointments->count() }} total
                    </span>

                </div>

                @if($mother->appointments->count())

                    @php
                        $apptStatusClasses = fn($status) => match($status) {
                            'Scheduled' => 'mshow-pill-amber',
                            'Completed' => 'mshow-pill-emerald',
                            'Cancelled' => 'mshow-pill-red',
                            default => 'mshow-pill-gray',
                        };
                    @endphp

                    <div class="mshow-appointment-list">

                        @foreach($mother->appointments as $appointment)

                            @php
                                $isToday = \Carbon\Carbon::parse(
                                    $appointment->appointment_date
                                )->isToday();
                            @endphp

                            <div class="mshow-appointment {{ $isToday ? 'mshow-appointment-today' : '' }}">

                                <div class="mshow-appointment-left">

                                    <div class="mshow-appointment-icon">
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

                                    <div class="mshow-appointment-content">

                                        <div class="mshow-appointment-date-row">

                                            <p class="mshow-appointment-date">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </p>

                                            @if($isToday)
                                                <span class="mshow-today">
                                                    Today
                                                </span>
                                            @endif

                                        </div>

                                        <p class="mshow-appointment-meta">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            <span>·</span>
                                            {{ $appointment->appointment_type }}
                                        </p>

                                    </div>

                                </div>

                                <div class="mshow-appointment-right">

                                    <span class="mshow-pill {{ $apptStatusClasses($appointment->status) }}">
                                        {{ $appointment->status }}
                                    </span>

                                    <a href="{{ route('appointments.show', $appointment->id) }}"
                                       class="mshow-appointment-view">
                                        View
                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="mshow-empty">

                        <div class="mshow-empty-icon mshow-empty-amber">
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

                        <h3>No appointments found</h3>

                        <p>
                            There are currently no scheduled appointments for this mother.
                        </p>

                        <a href="{{ route('appointments.create', $mother->id) }}"
                           class="mshow-empty-button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Schedule Appointment
                        </a>

                    </div>

                @endif

            </section>

            {{-- =====================================================
                 PERSONAL INFORMATION
                 ===================================================== --}}

            <section class="mshow-info-card">

                <div class="mshow-info-head">
                    <div class="mshow-info-head-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="mshow-section-kicker mshow-kicker-slate">
                            <span class="mshow-section-kicker-dot"></span>
                            Patient Record
                        </p>

                        <h2 class="mshow-card-title">
                            Personal Information
                        </h2>

                        <p class="mshow-section-sub">
                            Biographical and contact details on file.
                        </p>
                    </div>
                </div>

                <dl class="mshow-info-grid">

                    <div class="mshow-info-item">
                        <dt>Full Name</dt>
                        <dd>
                            {{ $mother->first_name }}
                            {{ $mother->middle_name }}
                            {{ $mother->last_name }}
                        </dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Birth Date</dt>
                        <dd>
                            {{ \Carbon\Carbon::parse($mother->birth_date)->format('F d, Y') }}
                        </dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Age</dt>
                        <dd>
                            {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                        </dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Civil Status</dt>
                        <dd>{{ $mother->civil_status }}</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Occupation</dt>
                        <dd>{{ $mother->occupation ?: '-' }}</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Address</dt>
                        <dd>{{ $mother->address }}</dd>
                    </div>

                </dl>

            </section>

            {{-- =====================================================
                 PREGNANCY INFORMATION
                 ===================================================== --}}

            <section class="mshow-info-card">

                <div class="mshow-info-head">
                    <div class="mshow-info-head-icon mshow-info-pink">
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
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            Patient Record
                        </p>

                        <h2 class="mshow-card-title">
                            Pregnancy Information
                        </h2>

                        <p class="mshow-section-sub">
                            Obstetric details on file for this pregnancy.
                        </p>
                    </div>
                </div>

                <dl class="mshow-info-grid">

                    <div class="mshow-info-item">
                        <dt>Blood Type</dt>
                        <dd>{{ $mother->blood_type }}</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Pregnancy Number</dt>
                        <dd>{{ $pregnancyOrdinal }} pregnancy</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Height (Registration)</dt>
                        <dd>{{ number_format($mother->height, 2) }} cm</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Weight (Registration)</dt>
                        <dd>{{ number_format($mother->weight, 2) }} kg</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Last Menstrual Period</dt>
                        <dd>
                            {{ \Carbon\Carbon::parse($mother->last_menstrual_period)->format('F d, Y') }}
                        </dd>
                    </div>

                    <div class="mshow-info-item mshow-edd-item">
                        <dt>Expected Delivery Date</dt>
                        <dd>
                            {{ $mother->expected_delivery_date
                                ? \Carbon\Carbon::parse($mother->expected_delivery_date)->format('F d, Y')
                                : '—' }}
                        </dd>
                    </div>

                </dl>

            </section>

            {{-- =====================================================
                 INFANT RECORDS
                 ===================================================== --}}

            <section class="mshow-card">

                <div class="mshow-card-header">

                    <div>
                        <p class="mshow-section-kicker mshow-kicker-blue">
                            <span class="mshow-section-kicker-dot"></span>
                            Newborn Records
                        </p>

                        <h2 class="mshow-card-title">
                            Infant Records
                        </h2>

                        <p class="mshow-section-sub">
                            Registered infants associated with this mother.
                        </p>
                    </div>

                    <div class="mshow-card-actions">

                        <span class="mshow-count">
                            {{ $mother->infants->count() }}
                            {{ Str::plural('infant', $mother->infants->count()) }}
                        </span>

                        <a href="{{ route('infants.create', $mother->id) }}"
                           class="mshow-register-button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Register Infant
                        </a>

                    </div>

                </div>

                @if($mother->infants->count())

                    <div class="mshow-infant-grid">

                        @foreach($mother->infants as $infant)

                            <article class="mshow-infant">

                                <div class="mshow-infant-head">

                                    <div class="mshow-infant-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="mshow-infant-name">
                                            {{ $infant->first_name }}
                                            {{ $infant->middle_name }}
                                            {{ $infant->last_name }}
                                        </p>

                                        <p class="mshow-infant-subtitle">
                                            Infant Record
                                        </p>
                                    </div>

                                </div>

                                <div class="mshow-infant-details">

                                    <div>
                                        <span>Gender</span>
                                        <strong>{{ $infant->sex }}</strong>
                                    </div>

                                    <div>
                                        <span>Birth Date</span>
                                        <strong>
                                            {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}
                                        </strong>
                                    </div>

                                </div>

                                <span class="mshow-infant-status">
                                    {{ $infant->birth_status }}
                                </span>

                                <a href="{{ route('infants.show', $infant->id) }}"
                                   class="mshow-infant-view">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m9 5 7 7-7 7"/>
                                    </svg>
                                </a>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="mshow-empty">

                        <div class="mshow-empty-icon mshow-empty-blue">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>

                        <h3>No infant records found</h3>

                        <p>
                            There are currently no registered infant records associated with this mother.
                        </p>

                        <a href="{{ route('infants.create', $mother->id) }}"
                           class="mshow-empty-button">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Register First Infant
                        </a>

                    </div>

                @endif

            </section>

        </div>
    </div>

</x-app-layout>