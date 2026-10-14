<x-app-layout>

    <div class="apt-wrap">

        <div class="apt-container">

            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
            <div class="apt-page-head">

                <button
                    type="button"
                    onclick="window.history.back()"
                    aria-label="Go back"
                    class="apt-back-btn"
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

                <div class="apt-page-copy">

                    <span>Visits & Care</span>

                    <h1>My Appointments</h1>

                    <p>
                        Manage and track your scheduled visits
                    </p>

                    <small>
                        {{ $appointments->total() }}
                        {{ Str::plural('appointment', $appointments->total()) }}
                        recorded
                    </small>

                </div>

            </div>


            @if($appointments->count())

                @php

                    /*
                     * Presentation-only status styling.
                     * Existing database values remain unchanged.
                     */
                    $appointmentStatus = function ($status) {

                        return match ($status) {

                            'Scheduled' => [
                                'dot'  => 'apt-dot-blue',
                                'bg'   => 'apt-status-blue',
                                'text' => 'apt-text-blue',
                            ],

                            'Completed' => [
                                'dot'  => 'apt-dot-green',
                                'bg'   => 'apt-status-green',
                                'text' => 'apt-text-green',
                            ],

                            'Cancelled' => [
                                'dot'  => 'apt-dot-rose',
                                'bg'   => 'apt-status-rose',
                                'text' => 'apt-text-rose',
                            ],

                            default => [
                                'dot'  => 'apt-dot-slate',
                                'bg'   => 'apt-status-slate',
                                'text' => 'apt-text-slate',
                            ],

                        };

                    };


                    /*
                     * Keep the existing presentation-only split.
                     * This operates on the paginator's current page,
                     * just like the original version.
                     */
                    $upcoming = $appointments
                        ->getCollection()
                        ->filter(
                            fn ($a) =>
                                \Carbon\Carbon::parse($a->appointment_date)
                                    ->startOfDay()
                                    ->gte(now()->startOfDay())
                        )
                        ->sortBy(
                            fn ($a) =>
                                \Carbon\Carbon::parse(
                                    $a->appointment_date . ' ' . $a->appointment_time
                                )
                        );


                    $past = $appointments
                        ->getCollection()
                        ->filter(
                            fn ($a) =>
                                \Carbon\Carbon::parse($a->appointment_date)
                                    ->startOfDay()
                                    ->lt(now()->startOfDay())
                        )
                        ->sortByDesc(
                            fn ($a) =>
                                \Carbon\Carbon::parse(
                                    $a->appointment_date . ' ' . $a->appointment_time
                                )
                        );


                    /*
                     * Soonest upcoming appointment on this page.
                     */
                    $nextAppointment = $upcoming->first();

                @endphp


                {{-- =====================================================
                     NEXT APPOINTMENT
                     ===================================================== --}}
                @if($nextAppointment)

                    @php
                        $nextStatus = $appointmentStatus(
                            $nextAppointment->status
                        );

                        $nextDate = \Carbon\Carbon::parse(
                            $nextAppointment->appointment_date
                        );

                        $nextTime = \Carbon\Carbon::parse(
                            $nextAppointment->appointment_time
                        );

                        $today = now()->startOfDay();

                        $daysRemaining = $today->diffInDays(
                            $nextDate->copy()->startOfDay(),
                            false
                        );

                        $countdownLabel = match(true) {

                            $daysRemaining === 0 => 'Today',

                            $daysRemaining === 1 => 'Tomorrow',

                            $daysRemaining > 1 =>
                                $daysRemaining . ' days remaining',

                            default =>
                                $nextDate->diffForHumans(),

                        };
                    @endphp


                    <section class="apt-hero">

                        <div class="apt-hero-shape apt-hero-shape-a"></div>
                        <div class="apt-hero-shape apt-hero-shape-b"></div>

                        <div class="apt-hero-inner">

                            <div class="apt-hero-top">

                                <div class="apt-hero-label">

                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                                        />
                                    </svg>

                                    Next Appointment

                                </div>


                                @if(strtolower(trim((string) $nextAppointment->status)) !== 'completed')

                                    <span class="apt-countdown">
                                        {{ $countdownLabel }}
                                    </span>

                                @else

                                    <span class="apt-countdown apt-countdown-completed">
                                        Completed
                                    </span>

                                @endif

                            </div>


                            <p class="apt-hero-type">
                                {{ $nextAppointment->appointment_type }}
                            </p>


                            <h2 class="apt-hero-date">
                                {{ $nextDate->format('l, F d, Y') }}
                            </h2>


                            <div class="apt-hero-details">

                                <span class="apt-hero-time">

                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 7v5l3 2"
                                        />
                                    </svg>

                                    {{ $nextTime->format('g:i A') }}

                                </span>


                                <span class="apt-hero-status">

                                    <span></span>

                                    {{ $nextAppointment->status }}

                                </span>

                            </div>

                        </div>

                    </section>

                @else

                    <div class="apt-no-upcoming">

                        <div class="apt-no-upcoming-icon">
                            <svg
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3>
                                No upcoming appointments
                            </h3>

                            <p>
                                You're all caught up for now.
                            </p>
                        </div>

                    </div>

                @endif


                {{-- =====================================================
                     UPCOMING
                     ===================================================== --}}
                @if($upcoming->count())

                    <section class="apt-section">

                        <div class="apt-section-head">

                            <div>
                                <span>Scheduled Visits</span>

                                <h2>
                                    Upcoming
                                </h2>
                            </div>

                            <span class="apt-section-count">
                                {{ $upcoming->count() }}
                            </span>

                        </div>


                        <div class="apt-list">

                            @foreach($upcoming as $appointment)

                                @php
                                    $status = $appointmentStatus(
                                        $appointment->status
                                    );

                                    $appointmentDate = \Carbon\Carbon::parse(
                                        $appointment->appointment_date
                                    );

                                    $appointmentTime = \Carbon\Carbon::parse(
                                        $appointment->appointment_time
                                    );
                                @endphp


                                <article class="apt-card">

                                    <div class="apt-card-date">

                                        <span>
                                            {{ $appointmentDate->format('M') }}
                                        </span>

                                        <strong>
                                            {{ $appointmentDate->format('d') }}
                                        </strong>

                                        <small>
                                            {{ $appointmentDate->format('Y') }}
                                        </small>

                                    </div>


                                    <div class="apt-card-main">

                                        <div class="apt-card-top">

                                            <h3>
                                                {{ $appointment->appointment_type }}
                                            </h3>

                                            <span class="apt-status {{ $status['bg'] }} {{ $status['text'] }}">

                                                <span class="apt-status-dot {{ $status['dot'] }}"></span>

                                                {{ $appointment->status }}

                                            </span>

                                        </div>


                                        <div class="apt-card-meta">

                                            <span>

                                                <svg
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    aria-hidden="true"
                                                >
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="9"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M12 7v5l3 2"
                                                    />
                                                </svg>

                                                {{ $appointmentTime->format('g:i A') }}

                                            </span>

                                            <span>
                                                {{ $appointmentDate->format('l') }}
                                            </span>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                     PAST
                     ===================================================== --}}
                @if($past->count())

                    <section class="apt-section">

                        <div class="apt-section-head">

                            <div>
                                <span>Visit History</span>

                                <h2>
                                    Past Appointments
                                </h2>
                            </div>

                            <span class="apt-section-count apt-section-count-muted">
                                {{ $past->count() }}
                            </span>

                        </div>


                        <div class="apt-list">

                            @foreach($past as $appointment)

                                @php
                                    $status = $appointmentStatus(
                                        $appointment->status
                                    );

                                    $appointmentDate = \Carbon\Carbon::parse(
                                        $appointment->appointment_date
                                    );

                                    $appointmentTime = \Carbon\Carbon::parse(
                                        $appointment->appointment_time
                                    );
                                @endphp


                                <article class="apt-card apt-card-past">

                                    <div class="apt-card-date apt-card-date-past">

                                        <span>
                                            {{ $appointmentDate->format('M') }}
                                        </span>

                                        <strong>
                                            {{ $appointmentDate->format('d') }}
                                        </strong>

                                        <small>
                                            {{ $appointmentDate->format('Y') }}
                                        </small>

                                    </div>


                                    <div class="apt-card-main">

                                        <div class="apt-card-top">

                                            <h3>
                                                {{ $appointment->appointment_type }}
                                            </h3>

                                            <span class="apt-status {{ $status['bg'] }} {{ $status['text'] }}">

                                                <span class="apt-status-dot {{ $status['dot'] }}"></span>

                                                {{ $appointment->status }}

                                            </span>

                                        </div>


                                        <div class="apt-card-meta">

                                            <span>

                                                <svg
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    aria-hidden="true"
                                                >
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="9"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M12 7v5l3 2"
                                                    />
                                                </svg>

                                                {{ $appointmentTime->format('g:i A') }}

                                            </span>

                                            <span>
                                                {{ $appointmentDate->format('l, F d, Y') }}
                                            </span>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                     PAGINATION
                     ===================================================== --}}
                @if($appointments->hasPages())

                    <div class="apt-pagination">
                        {{ $appointments->links() }}
                    </div>

                @endif


            @else

                {{-- =====================================================
                     EMPTY STATE
                     ===================================================== --}}
                <section class="apt-empty">

                    <div class="apt-empty-icon">
                        📅
                    </div>

                    <h2>
                        No appointments found
                    </h2>

                    <p>
                        You currently have no scheduled appointments.
                    </p>

                </section>

            @endif

        </div>

    </div>

</x-app-layout>