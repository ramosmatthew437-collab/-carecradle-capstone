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




            <a href="{{ route('mothers.index') }}" class="mshow-back-button">
    <svg width="17" height="17" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round"
         aria-hidden="true">
        <path d="M19 12H5"/>
        <path d="m12 19-7-7 7-7"/>
    </svg>
    <span>Back to Mother Registry</span>
</a>

{{-- =====================================================
     MOTHER IDENTITY HEADER
     Identity (photo/initials, name, mother code, barangay)
     and a compact facts panel (maternal status, contact
     number). The contact number previously sat in a separate
     strip that also repeated the code and barangay.
     ===================================================== --}}

<section class="mshow-header" aria-labelledby="mshow-header-name">

    <div class="mshow-header-identity">

        {{-- Mother's Profile Photo --}}
        <div class="mshow-header-avatar">
            @if ($mother->profile_photo_path)
                <img
                    src="{{ asset('storage/' . $mother->profile_photo_path) }}"
                    alt="Profile photo of {{ $mother->first_name }} {{ $mother->last_name }}"
                    class="mshow-header-avatar-image"
                >
            @else
                <span class="mshow-header-avatar-initials" aria-hidden="true">
                    {{ strtoupper(
                        substr($mother->first_name ?? '', 0, 1) .
                        substr($mother->last_name ?? '', 0, 1)
                    ) }}
                </span>
            @endif
        </div>

        {{-- Name and identifiers --}}
        <div class="mshow-header-copy">

            <p class="mshow-header-eyebrow">Mother Profile</p>

            <h1 class="mshow-header-name" id="mshow-header-name">
                {{ $mother->first_name }} {{ $mother->last_name }}
            </h1>

            <dl class="mshow-header-ids">

                <div class="mshow-header-id">
                    <dt class="mshow-header-visually-hidden">Mother code</dt>
                    <dd class="mshow-header-code">{{ $mother->mother_code }}</dd>
                </div>

                <div class="mshow-header-id mshow-header-place">
                    <dt class="mshow-header-visually-hidden">Barangay</dt>
                    <dd>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                        </svg>
                        <span>Barangay {{ $mother->barangay }}</span>
                    </dd>
                </div>

            </dl>

        </div>

    </div>

    {{-- Key facts --}}
    <dl class="mshow-header-facts">

        <div class="mshow-header-fact">
            <dt class="mshow-header-fact-label">Pregnancy Status</dt>
            <dd class="mshow-header-fact-value">
                <span class="mshow-status {{ $statusClasses }}">
                    <span class="mshow-status-dot" aria-hidden="true"></span>
                    {{ $mother->pregnancyStatusLabel() }}
                </span>
                @if ($mother->isReferred())<span style="display:inline-flex;align-items:center;margin-left:0.375rem;padding:0.0625rem 0.5rem;color:#92400e;background:#fffbeb;border:1px solid #fde68a;border-radius:999px;font-size:0.6875rem;font-weight:700;white-space:nowrap;" title="Currently referred">Referred</span>@endif
            </dd>
        </div>

        <div class="mshow-header-fact">
            <dt class="mshow-header-fact-label">Contact Number</dt>
            <dd class="mshow-header-fact-value">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $mother->contact_number) }}"
                   class="mshow-header-phone">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8"
                         aria-hidden="true">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25Z"/>
                    </svg>
                    <span>{{ $mother->contact_number }}</span>
                </a>
            </dd>
        </div>

    </dl>

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
                 CLINICAL SUMMARY
                 One panel of six indicators. Values, colours, and
                 calculations are unchanged; only the layout differs.
                 ===================================================== --}}

            <section class="mshow-card mshow-summary" aria-labelledby="mshow-summary-title">

                <div class="mshow-card-header">
                    <div>
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            At a Glance
                        </p>
                        <h2 class="mshow-card-title" id="mshow-summary-title">
                            Clinical Summary
                        </h2>
                        <p class="mshow-section-sub">
                            Key indicators for this mother's current care status.
                        </p>
                    </div>
                </div>

                <div class="mshow-summary-grid">

                    {{-- Status --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Pregnancy Status</p>
                            <p class="mshow-summary-value {{ $statusTextClass }}">
                                {{ $mother->pregnancyStatusLabel() }}{{ $mother->isReferred() ? ' · Referred' : '' }}
                            </p>
                        </div>
                    </div>

                    {{-- EDD --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Expected Delivery</p>
                            <p class="mshow-summary-value {{ $eddLabel ? $eddTheme : 'mshow-text-muted' }}">
                                {{ $eddLabel ?? '—' }}
                            </p>
                            @if($eddLabel && $mother->expected_delivery_date)
                                <p class="mshow-summary-meta">
                                    {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('M d, Y') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Latest BP --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Latest Blood Pressure</p>
                            @if($latestVisit)
                                @php
                                    $latestBp = $bpTheme(
                                        $latestVisit->systolic_bp,
                                        $latestVisit->diastolic_bp
                                    );
                                @endphp
                                <div class="mshow-summary-inline">
                                    <p class="mshow-summary-value">
                                        {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                    </p>
                                    <span class="mshow-bp-badge {{ $latestBp['classes'] }}">
                                        {{ $latestBp['label'] }}
                                    </span>
                                </div>
                            @else
                                <p class="mshow-summary-value mshow-text-muted">
                                    No data yet
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Latest Weight --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Latest Weight</p>
                            <p class="mshow-summary-value">
                                {{ $latestWeight ? number_format($latestWeight, 1) . ' kg' : 'Not recorded' }}
                            </p>
                        </div>
                    </div>

                    {{-- Last Visit --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Last Prenatal Visit</p>
                            <p class="mshow-summary-value">
                                {{ $latestVisit
                                    ? \Carbon\Carbon::parse($latestVisit->visit_date)->format('M d, Y')
                                    : 'None recorded' }}
                            </p>
                        </div>
                    </div>

                    {{-- Next Appointment --}}
                    <div class="mshow-summary-item">
                        <span class="mshow-summary-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </span>
                        <div class="mshow-summary-body">
                            <p class="mshow-summary-label">Next Appointment</p>
                            <p class="mshow-summary-value">
                                {{ $nextAppointment
                                    ? \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M d, Y')
                                    : 'None scheduled' }}
                            </p>
                        </div>
                    </div>

                </div>

            </section>

            
{{-- =====================================================
     QUICK ACTIONS
     ===================================================== --}}

<section class="mshow-actions">

    {{-- Edit Mother --}}
    <a href="{{ route('mothers.edit', $mother->id) }}"
       class="mshow-action mshow-action-secondary">

        <span class="mshow-action-icon">
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
            </svg>
        </span>

        <span>
            <strong>Edit Mother</strong>
            <small>Update personal, contact, and pregnancy details</small>
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

    {{-- Record Maternal Vaccination --}}
    <a href="{{ route('midwife.maternal-vaccinations.create', $mother->id) }}"
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
            <strong>Record Maternal Vaccination</strong>
            <small>Add a vaccine to the mother's health record</small>
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

    {{-- Add Prenatal Visit --}}
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

    {{-- Schedule Appointment --}}
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


            {{-- Referral (separate from pregnancy status) --}}
            @include('mothers.referrals._card')


            {{-- =====================================================
                 PRENATAL CHECKUPS
                 Latest visit + full history (newest first). Blood
                 pressure labels come from the existing $bpTheme;
                 document counts are display only.
                 ===================================================== --}}

            <section class="mshow-card mshow-visits" aria-labelledby="mshow-visits-title">

                <div class="mshow-card-header">
                    <div>
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            Care History
                        </p>
                        <h2 class="mshow-card-title" id="mshow-visits-title">
                            Prenatal Checkups
                        </h2>
                        <p class="mshow-section-sub">
                            Complete history of prenatal visits.
                        </p>
                    </div>

                    <div class="mshow-card-actions">
                        <span class="mshow-vax-count">
                            {{ $mother->prenatalCheckups->count() }}
                            {{ Str::plural('visit', $mother->prenatalCheckups->count()) }}
                        </span>
                        <a href="{{ route('prenatal-checkups.create', $mother->id) }}" class="mshow-rec-add">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add Visit
                        </a>
                    </div>
                </div>

                @if($mother->prenatalCheckups->count())
                    @php
                        $latestBpHighlight = $bpTheme(
                            $latestVisit->systolic_bp,
                            $latestVisit->diastolic_bp
                        );
                        $visitsNewestFirst = $mother->prenatalCheckups
                            ->sortBy([['visit_date', 'desc'], ['id', 'desc']])
                            ->values();
                        $visitDocCounts = \App\Models\PrenatalCheckupAttachment::query()
                            ->whereIn('prenatal_checkup_id', $mother->prenatalCheckups->pluck('id'))
                            ->selectRaw('prenatal_checkup_id, COUNT(*) as aggregate')
                            ->groupBy('prenatal_checkup_id')
                            ->pluck('aggregate', 'prenatal_checkup_id');
                        $latestDocs = (int) ($visitDocCounts[$latestVisit->id] ?? 0);
                    @endphp

                    {{-- Latest visit --}}
                    <div class="mshow-visits-latest">
                        <div class="mshow-visits-latest-head">
                            <div>
                                <span class="mshow-visits-latest-label">Latest Visit</span>
                                <span class="mshow-visits-latest-date">
                                    {{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('F d, Y') }}
                                </span>
                            </div>
                            <a href="{{ route('prenatal-checkups.show', $latestVisit->id) }}" class="mshow-visits-link">
                                View visit
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        </div>

                        <div class="mshow-visits-latest-grid">
                            <div>
                                <span>Gestational Age</span>
                                <strong>{{ $latestVisit->gestational_age_weeks }} wks</strong>
                            </div>
                            <div>
                                <span>Blood Pressure</span>
                                <div class="mshow-visits-inline">
                                    <strong>{{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}</strong>
                                    <span class="mshow-bp-badge {{ $latestBpHighlight['classes'] }}">
                                        {{ $latestBpHighlight['label'] }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <span>Weight</span>
                                <strong>{{ number_format($latestVisit->weight, 1) }} kg</strong>
                            </div>
                            <div>
                                <span>Lab Documents</span>
                                <strong>{{ $latestDocs ?: '—' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Visit history: a table on wide screens, cards on narrow ones --}}
                    <div class="mshow-visits-wrap">
                        <table class="mshow-visits-table">
                            <thead>
                                <tr>
                                    <th scope="col">Visit Date</th>
                                    <th scope="col">Gestational Age</th>
                                    <th scope="col">Blood Pressure</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Documents</th>
                                    <th scope="col" class="mshow-visits-th-action"><span class="mshow-visits-sr">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitsNewestFirst as $visit)
                                    @php
                                        $rowBp = $bpTheme($visit->systolic_bp, $visit->diastolic_bp);
                                        $rowDocs = (int) ($visitDocCounts[$visit->id] ?? 0);
                                    @endphp
                                    <tr>
                                        <td class="mshow-visits-date" data-label="Visit Date">
                                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                            @if($visit->id === $latestVisit->id)
                                                <span class="mshow-visits-latest-tag">Latest</span>
                                            @endif
                                        </td>
                                        <td data-label="Gestational Age">
                                            <span class="mshow-visits-ga">{{ $visit->gestational_age_weeks }} wks</span>
                                        </td>
                                        <td data-label="Blood Pressure">
                                            <div class="mshow-visits-inline">
                                                <span class="mshow-visits-num">{{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }}</span>
                                                <span class="mshow-bp-badge {{ $rowBp['classes'] }}">{{ $rowBp['label'] }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Weight">
                                            <span class="mshow-visits-num">{{ number_format($visit->weight, 1) }} kg</span>
                                        </td>
                                        <td data-label="Documents">
                                            @if($rowDocs)
                                                <span class="mshow-visits-docs">{{ $rowDocs }} {{ Str::plural('file', $rowDocs) }}</span>
                                            @else
                                                <span class="mshow-visits-none">None</span>
                                            @endif
                                        </td>
                                        <td class="mshow-visits-action">
                                            <a href="{{ route('prenatal-checkups.show', $visit->id) }}"
                                               class="mshow-visits-view"
                                               aria-label="View visit on {{ \Carbon\Carbon::parse($visit->visit_date)->format('F d, Y') }}">
                                                View
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                 FATHER'S INFORMATION
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
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="mshow-section-kicker">
                            <span class="mshow-section-kicker-dot"></span>
                            Family Record
                        </p>

                        <h2 class="mshow-card-title">
                            Father's Information
                        </h2>

                        <p class="mshow-section-sub">
                            Father's personal and contact details, when provided.
                        </p>
                    </div>
                </div>

                <dl class="mshow-info-grid">

                    <div class="mshow-info-item">
                        <dt>Full Name</dt>
                        <dd>
                            {{ collect([
                                $mother->father_first_name,
                                $mother->father_middle_name,
                                $mother->father_last_name,
                            ])->filter()->implode(' ') ?: 'Not provided' }}
                        </dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Birth Date</dt>
                        <dd>
                            {{ $mother->father_birth_date
                                ? \Carbon\Carbon::parse($mother->father_birth_date)->format('F d, Y')
                                : 'Not provided' }}
                        </dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Contact Number</dt>
                        <dd>{{ $mother->father_contact_number ?: 'Not provided' }}</dd>
                    </div>

                    <div class="mshow-info-item">
                        <dt>Occupation</dt>
                        <dd>{{ $mother->father_occupation ?: 'Not provided' }}</dd>
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
     MATERNAL VACCINATION HISTORY
     One table; on narrow screens each row is shown as a
     card (cells carry data-label). Routes, the delete
     confirmation, and all values are unchanged.
     ===================================================== --}}
<section class="mshow-card mshow-vax" aria-labelledby="mshow-vax-title">

    <div class="mshow-card-header">
        <div>
            <p class="mshow-section-kicker">
                <span class="mshow-section-kicker-dot"></span>
                Maternal Health
            </p>
            <h2 class="mshow-card-title" id="mshow-vax-title">
                Maternal Vaccination History
            </h2>
            <p class="mshow-section-sub">
                Manage and review vaccines administered to this mother.
            </p>
        </div>

        <div class="mshow-card-actions">
            <span class="mshow-vax-count">
                {{ $mother->maternalVaccinations->count() }}
                {{ $mother->maternalVaccinations->count() === 1 ? 'Record' : 'Records' }}
            </span>
            <a href="{{ route('midwife.maternal-vaccinations.create', $mother->id) }}"
               class="mshow-rec-add">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Add Vaccination
            </a>
        </div>
    </div>

    @if(session('vaccination_success'))
        <div class="mshow-vax-flash" role="status" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
            </svg>
            <span>{{ session('vaccination_success') }}</span>
        </div>
    @endif

    @if($mother->maternalVaccinations->isNotEmpty())
        <div class="mshow-vax-wrap">
            <table class="mshow-vax-table">
                <thead>
                    <tr>
                        <th scope="col">Vaccine</th>
                        <th scope="col">Dose</th>
                        <th scope="col">Date Given</th>
                        <th scope="col">Next Due</th>
                        <th scope="col">Administered By</th>
                        <th scope="col" class="mshow-vax-th-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mother->maternalVaccinations->sortByDesc('date_given') as $record)
                        <tr>
                            <td class="mshow-vax-cell-vaccine" data-label="Vaccine">
                                <span class="mshow-vax-name">{{ $record->vaccine_name }}</span>
                                @if($record->remarks)
                                    <p class="mshow-vax-remarks">{{ $record->remarks }}</p>
                                @endif
                            </td>
                            <td class="mshow-vax-cell-dose" data-label="Dose">
                                <span class="mshow-vax-dose">{{ $record->dose }}</span>
                            </td>
                            <td class="mshow-vax-cell-date" data-label="Date Given">
                                {{ $record->date_given
                                    ? $record->date_given->format('M d, Y')
                                    : '—' }}
                            </td>
                            <td class="mshow-vax-cell-date {{ $record->next_due_date ? '' : 'mshow-vax-muted' }}" data-label="Next Due">
                                {{ $record->next_due_date
                                    ? $record->next_due_date->format('M d, Y')
                                    : 'Not scheduled' }}
                            </td>
                            <td class="mshow-vax-cell-by" data-label="Administered By">
                                {{ $record->administered_by }}
                            </td>
                            <td class="mshow-vax-cell-actions">
                                <div class="mshow-vax-actions">
                                    <a href="{{ route('midwife.maternal-vaccinations.edit', [$mother->id, $record->id]) }}"
                                       class="mshow-vax-btn mshow-vax-btn-edit"
                                       aria-label="Edit vaccination record">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST"
                                          action="{{ route('midwife.maternal-vaccinations.destroy', [$mother->id, $record->id]) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this maternal vaccination record? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="mshow-vax-btn mshow-vax-btn-delete"
                                                aria-label="Delete vaccination record">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="mshow-vax-empty">
            <span class="mshow-vax-empty-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
            </span>
            <p class="mshow-vax-empty-title">
                No maternal vaccination records yet
            </p>
            <p class="mshow-vax-empty-text">
                Start documenting this mother's vaccination history.
            </p>
            <a href="{{ route('midwife.maternal-vaccinations.create', $mother->id) }}"
               class="mshow-rec-add">
                Add First Vaccination
            </a>
        </div>
    @endif
</section>



            {{-- =====================================================
                 INFANT RECORDS
                 Responsive card grid with subtle blue accents.
                 Values, links, and routes are unchanged.
                 ===================================================== --}}

            @php
                // Panel requirement (Rule A): Register Infant needs a prenatal
                // checkup dated today or earlier (enforced again on the server).
                $canRegisterInfant = $mother->hasQualifyingPrenatalCheckup();
            @endphp

            <section class="mshow-card mshow-babies" aria-labelledby="mshow-babies-title">

                <div class="mshow-card-header">
                    <div>
                        <p class="mshow-section-kicker mshow-kicker-blue">
                            <span class="mshow-section-kicker-dot"></span>
                            Newborn Records
                        </p>
                        <h2 class="mshow-card-title" id="mshow-babies-title">
                            Infant Records
                        </h2>
                        <p class="mshow-section-sub">
                            Registered infants associated with this mother.
                        </p>
                    </div>

                    <div class="mshow-card-actions">
                        <span class="mshow-babies-count">
                            {{ $mother->infants->count() }}
                            {{ Str::plural('infant', $mother->infants->count()) }}
                        </span>
                        @if ($canRegisterInfant)
                            <a href="{{ route('infants.create', $mother->id) }}"
                               class="mshow-rec-add">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Register Infant
                            </a>
                        @else
                            <a href="{{ route('prenatal-checkups.create', $mother->id) }}"
                               class="mshow-rec-add">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Add Prenatal Visit
                            </a>
                        @endif
                    </div>
                </div>

                @unless ($canRegisterInfant)
                    @include('infants._profile-registration-notice', ['mother' => $mother])
                @endunless

                @if($mother->infants->count())
                    <div class="mshow-babies-grid">
                        @foreach($mother->infants as $infant)
                            @php
                                $babyStatusClass = match($infant->birth_status) {
                                    'Alive' => 'mshow-baby-status-alive',
                                    'Stillbirth' => 'mshow-baby-status-stillbirth',
                                    default => 'mshow-baby-status-other',
                                };
                            @endphp
                            <article class="mshow-baby">

                                <div class="mshow-baby-head">
                                    <div class="mshow-baby-avatar">
                                        @php
                                            // Photo only when the stored file exists; otherwise, or if it
                                            // fails to load, the default baby avatar is shown.
                                            $babyHasPhoto = $infant->photo_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($infant->photo_path);
                                        @endphp
                                        @if($babyHasPhoto)
                                            <img
                                                src="{{ route('midwife.infant-photo.show', $infant->id) }}"
                                                alt="{{ $infant->first_name }}'s photo"
                                                loading="lazy"
                                                onerror="this.style.display = 'none'; this.nextElementSibling.style.display = '';"
                                            >
                                        @endif
        <svg xmlns="http://www.w3.org/2000/svg"
             @if($babyHasPhoto) style="display: none;" @endif
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="1.8">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
        </svg>
                                    </div>

                                    @php
                                        $babyAge = \Carbon\Carbon::parse($infant->birth_date)->diff(now());
                                        $babyAgeText = $babyAge->y > 0
                                            ? $babyAge->y . ' ' . Str::plural('year', $babyAge->y) . ($babyAge->m ? ', ' . $babyAge->m . ' ' . Str::plural('month', $babyAge->m) : '')
                                            : ($babyAge->m > 0
                                                ? $babyAge->m . ' ' . Str::plural('month', $babyAge->m)
                                                : $babyAge->d . ' ' . Str::plural('day', $babyAge->d));
                                    @endphp
                                    <div class="mshow-baby-identity">
                                        <p class="mshow-baby-name">
                                            {{ $infant->first_name }}
                                            {{ $infant->middle_name }}
                                            {{ $infant->last_name }}
                                        </p>
                                        <p class="mshow-baby-sub">
                                            {{ $infant->sex }} · {{ $babyAgeText }} old
                                        </p>
                                    </div>

                                    <span class="mshow-baby-status {{ $babyStatusClass }}">
                                        {{ $infant->birth_status }}
                                    </span>
                                </div>

                                <div class="mshow-baby-details">
                                    <div>
                                        <span>Birth Date</span>
                                        <strong>
                                            {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}
                                        </strong>
                                    </div>
                                    <div>
                                        <span>Birth Weight</span>
                                        <strong>{{ number_format($infant->birth_weight, 2) }} kg</strong>
                                    </div>
                                    <div>
                                        <span>Birth Length</span>
                                        <strong>{{ number_format($infant->birth_length, 2) }} cm</strong>
                                    </div>
                                    <div>
                                        <span>Registration</span>
                                        <strong>{{ $infant->registrationException() ? 'Authorized exception' : 'Standard' }}</strong>
                                    </div>
                                </div>

                                <a href="{{ route('infants.show', $infant->id) }}"
                                   class="mshow-baby-link">
                                    View Infant Profile
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
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

                        @if ($canRegisterInfant)
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
                        @endif

                    </div>
                @endif
            </section>

        </div>
    </div>

</x-app-layout>