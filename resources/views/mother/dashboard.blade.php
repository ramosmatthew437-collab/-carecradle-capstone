<x-app-layout>

    <div class="mth-wrap">

        <div class="mth-container">

            {{-- ====================================== --}}
            {{-- GREETING + PREGNANCY OVERVIEW --}}
            {{-- ====================================== --}}

            <section class="mth-hero">

                <div class="mth-hero-glow mth-hero-glow-a"></div>
                <div class="mth-hero-glow mth-hero-glow-b"></div>

                <div class="mth-hero-inner">

                    <div class="mth-hero-content">

                        <div class="mth-eyebrow">
                            <span class="mth-eyebrow-dot"></span>

                            <span>
                                @if(now()->hour < 12)
                                    Good morning
                                @elseif(now()->hour < 18)
                                    Good afternoon
                                @else
                                    Good evening
                                @endif
                            </span>
                        </div>

                        <h1 class="mth-hero-title">
                            {{ $mother->first_name }} {{ $mother->last_name }}
                        </h1>

                        <div class="mth-meta-row">

                            <span>
                                {{ now()->format('l, F d, Y') }}
                            </span>

                            @if($pregnancyWeek)
                                <span class="mth-meta-dot">•</span>

                                <span class="mth-pregnancy-badge">
                                    Week {{ $pregnancyWeek }} · {{ $trimester }} trimester
                                </span>
                            @endif

                        </div>

                        @if($pregnancyWeek)

                            <div class="mth-progress-wrap">

                                <div class="mth-progress-top">

                                    <span>
                                        Pregnancy Journey
                                    </span>

                                    <strong>
                                        Week {{ $pregnancyWeek }} of 40
                                    </strong>

                                </div>

                                <div
                                    class="mth-progress-track"
                                    role="progressbar"
                                    aria-valuenow="{{ $pregnancyWeek }}"
                                    aria-valuemin="0"
                                    aria-valuemax="40"
                                    aria-label="Pregnancy progress: week {{ $pregnancyWeek }} of 40"
                                >
                                    <div
                                        class="mth-progress-fill"
                                        style="width: {{ min(100, round(($pregnancyWeek / 40) * 100)) }}%"
                                    ></div>
                                </div>

                            </div>

                        @endif

                    </div>

                    <div class="mth-avatar">

                        <div
                            class="mth-avatar-inner"
                            role="img"
                            aria-label="{{ $mother->first_name }} {{ $mother->last_name }}"
                        >
                            {{ strtoupper(substr($mother->first_name, 0, 1) . substr($mother->last_name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </section>


            {{-- ====================================== --}}
            {{-- NEXT APPOINTMENT --}}
            {{-- ====================================== --}}

            @if($nextAppointment)

                @php
                    $appointmentDate = \Carbon\Carbon::parse($nextAppointment->appointment_date);

                    $daysRemaining = now()
                        ->startOfDay()
                        ->diffInDays(
                            $appointmentDate->copy()->startOfDay(),
                            false
                        );

                    $countdownLabel = match(true) {
                        $daysRemaining === 0 => 'Today',
                        $daysRemaining === 1 => 'Tomorrow',
                        $daysRemaining > 1 => $daysRemaining . ' days remaining',
                        default => $appointmentDate->diffForHumans(),
                    };
                @endphp

                <section class="mth-appointment">

                    <div class="mth-floating-circle mth-floating-circle-a"></div>
                    <div class="mth-floating-circle mth-floating-circle-b"></div>

                    <div class="mth-appointment-top">

                        <div class="mth-appointment-label">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                                />
                            </svg>

                            Next Appointment
                        </div>

                        <span class="mth-countdown">
                            {{ $countdownLabel }}
                        </span>

                    </div>

                    @if(isset($nextAppointment->appointment_type))

                        <p class="mth-appointment-type">
                            {{ $nextAppointment->appointment_type }}
                        </p>

                    @endif

                    <h2 class="mth-appointment-date">
                        {{ $appointmentDate->format('F d, Y') }}
                    </h2>

                    <div class="mth-appointment-details">

                        <span class="mth-time">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"
                                />
                            </svg>

                            {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}

                        </span>

                        @if(isset($nextAppointment->status))

                            <span class="mth-status">
                                {{ $nextAppointment->status }}
                            </span>

                        @endif

                    </div>

                    <a
                        href="{{ route('mother.appointments') }}"
                        class="mth-white-btn"
                    >
                        View Details

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>

                </section>

            @else

                <section class="mth-empty">

                    <div class="mth-empty-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                            />
                        </svg>

                    </div>

                    <h3>
                        No Upcoming Appointments
                    </h3>

                    <p>
                        You're all caught up! Your next clinic visit will automatically appear here once scheduled by your midwife.
                    </p>

                    <a
                        href="{{ route('mother.appointments') }}"
                        class="mth-primary-btn"
                    >
                        View Appointments History

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>

                </section>

            @endif


            {{-- ====================================== --}}
            {{-- VACCINATION REMINDER --}}
            {{-- ====================================== --}}

            @if($nextVaccination)

                @php
                    $vaxDaysRemaining = now()
                        ->startOfDay()
                        ->diffInDays(
                            \Carbon\Carbon::parse($nextVaccination->next_due_date)->startOfDay(),
                            false
                        );

                    $isOverdue = $vaxDaysRemaining < 0;

                    $vaxLabel = match(true) {
                        $isOverdue =>
                            abs($vaxDaysRemaining) .
                            ' day' .
                            (abs($vaxDaysRemaining) === 1 ? '' : 's') .
                            ' overdue',

                        $vaxDaysRemaining === 0 => 'Due today',
                        $vaxDaysRemaining === 1 => 'Due tomorrow',

                        default => 'Due in ' . $vaxDaysRemaining . ' days',
                    };
                @endphp

                <section class="mth-vax {{ $isOverdue ? 'mth-vax-overdue' : '' }}">

                    <div class="mth-vax-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                            />
                        </svg>

                    </div>

                    <div class="mth-vax-content">

                        <p class="mth-vax-title">
                            {{ $nextVaccination->vaccine_name }} Vaccination
                        </p>

                        <p class="mth-vax-label">
                            {{ $vaxLabel }}
                        </p>

                    </div>

                    <a
                        href="{{ route('mother.infant-records') }}"
                        class="mth-vax-arrow"
                        aria-label="View vaccination details for {{ $nextVaccination->vaccine_name }}"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </a>

                </section>

            @endif


            {{-- ====================================== --}}
            {{-- INFANT RECORDS --}}
            {{-- ====================================== --}}

            <section class="mth-infant">

                <div class="mth-infant-shape mth-infant-shape-a"></div>
                <div class="mth-infant-shape mth-infant-shape-b"></div>

                <div class="mth-infant-content">

                    <div class="mth-infant-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"
                            />
                        </svg>

                    </div>

                    <div class="mth-infant-text">

                        <h2>
                            Infant & Child Records
                        </h2>

                        @if($infant)

                            @php
                                $ageInDays = (int) \Carbon\Carbon::parse($infant->birth_date)->diffInDays(now());

                                if ($ageInDays < 30) {
                                    $infantAgeText =
                                        $ageInDays .
                                        ' day' .
                                        ($ageInDays === 1 ? '' : 's') .
                                        ' old';
                                } else {
                                    $ageInMonths = (int) floor($ageInDays / 30.44);

                                    $infantAgeText =
                                        $ageInMonths .
                                        ' month' .
                                        ($ageInMonths === 1 ? '' : 's') .
                                        ' old';
                                }
                            @endphp

                            <p class="mth-infant-name">
                                {{ $infant->first_name }}

                                <span>
                                    · {{ $infantAgeText }}
                                </span>
                            </p>

                            <p class="mth-infant-description">
                                Monitor vaccinations, growth charts, and clinic assessments in one place.
                            </p>

                            @if($infant->sex || $infant->birth_weight)

                                <div class="mth-infant-tags">

                                    @if($infant->sex)

                                        <span>
                                            {{ ucfirst($infant->sex) }}
                                        </span>

                                    @endif

                                    @if($infant->birth_weight)

                                        <span>
                                            {{ $infant->birth_weight }} kg at birth
                                        </span>

                                    @endif

                                </div>

                            @endif

                        @else

                            <p class="mth-infant-description">
                                Access infant profile details, vaccination logs, growth monitoring, and official WHO growth charts—all in one place.
                            </p>

                        @endif

                    </div>

                </div>

                <a
                    href="{{ route('mother.infant-records') }}"
                    class="mth-white-btn"
                >
                    View Infant Records

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </a>

            </section>


            {{-- ====================================== --}}
            {{-- QUICK ACTIONS --}}
            {{-- ====================================== --}}

            @php
                $navLinks = [
                    [
                        'title' => 'My Profile',
                        'description' => 'Personal & health details',
                        'route' => 'mother.profile',
                        'icon' => 'profile',
                        'theme' => 'pink',
                    ],
                    [
                        'title' => 'Appointments',
                        'description' => 'Upcoming & past visits',
                        'route' => 'mother.appointments',
                        'icon' => 'calendar',
                        'theme' => 'fuchsia',
                    ],
                    [
                        'title' => 'Prenatal Records',
                        'description' => 'Checkup history & stats',
                        'route' => 'mother.prenatal-records',
                        'icon' => 'heartbeat',
                        'theme' => 'rose',
                    ],
                    [
                        'title' => 'SMS History',
                        'description' => 'Clinic message reminders',
                        'route' => 'mother.sms-history',
                        'icon' => 'sms',
                        'theme' => 'pink',
                    ],
                ];
            @endphp


            <section class="mth-actions">

                <div class="mth-section-heading">

                    <div>
                        <span>CareCradle</span>
                        <h2>Quick Actions</h2>
                    </div>

                    <p>
                        Access your care tools
                    </p>

                </div>


                <div class="mth-action-grid">

                    @foreach($navLinks as $link)

                        <a
                            href="{{ route($link['route']) }}"
                            class="mth-action-card"
                        >

                            <div class="mth-action-icon mth-action-{{ $link['theme'] }}">

                                @switch($link['icon'])

                                    @case('profile')

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"
                                            />
                                        </svg>

                                        @break

                                    @case('calendar')

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                                            />
                                        </svg>

                                        @break

                                    @case('heartbeat')

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                                            />
                                        </svg>

                                        @break

                                    @case('sms')

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25V6.75A2.25 2.25 0 014.5 4.5h15A2.25 2.25 0 0121.75 6.75Z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m3 7.5 8.291 5.527a1.25 1.25 0 001.418 0L21 7.5"
                                            />
                                        </svg>

                                        @break

                                @endswitch

                            </div>

                            <div class="mth-action-copy">

                                <h3>
                                    {{ $link['title'] }}
                                </h3>

                                <p>
                                    {{ $link['description'] }}
                                </p>

                            </div>

                            <div class="mth-action-arrow">

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>

                            </div>

                        </a>

                    @endforeach

                </div>

            </section>

        </div>

    </div>

</x-app-layout>