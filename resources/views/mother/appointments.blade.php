<x-app-layout>

    @php
        $today = today();

        // Presentation of the four stored statuses: a text label, a distinct
        // icon, and a colour, so colour is never the only cue. Any other
        // stored value is shown as-is with neutral styling (no new statuses).
        $statusMeta = function (?string $status) {
            return match ($status) {
                'Scheduled' => ['class' => 'is-scheduled', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z'],
                'Completed' => ['class' => 'is-completed', 'icon' => 'M4.5 12.75l6 6 9-13.5'],
                'Missed'    => ['class' => 'is-missed',    'icon' => 'M12 9v3.75m0 3.75h.008M21 12a9 9 0 11-18 0 9 9 0 0118 0Z'],
                'Cancelled' => ['class' => 'is-cancelled', 'icon' => 'M6 18 18 6M6 6l12 12'],
                default     => ['class' => 'is-other',     'icon' => 'M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z'],
            };
        };

        $countdown = function ($date) use ($today) {
            $days = (int) $today->diffInDays(\Carbon\Carbon::parse($date)->startOfDay(), false);

            return match (true) {
                $days === 0 => 'Today',
                $days === 1 => 'Tomorrow',
                default => 'In ' . $days . ' days',
            };
        };

        $plural = fn (int $n, string $word) => $n . ' ' . $word . ($n === 1 ? '' : 's');
        $monthOf = fn ($appointment) => \Carbon\Carbon::parse($appointment->appointment_date)->format('F Y');
    @endphp

    <div class="mdb apx apx-appointments">

        <div class="mdb-container">

            {{-- ================= PAGE HEADER ================= --}}
            <header class="apx-head">
                <a href="{{ route('mother.dashboard') }}" class="apx-back" aria-label="Back to dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>

                <div class="apx-head-copy">
                    <p class="apx-eyebrow">Visits &amp; care</p>
                    <h1 class="apx-title">My Appointments</h1>
                    <p class="apx-lead">
                        Your clinic visits are scheduled by your midwife at the Irosin Rural Health Unit.
                        <span class="apx-lead-count">{{ $plural($totalAppointments, 'appointment') }} recorded.</span>
                    </p>
                </div>
            </header>

            @if($totalAppointments === 0)

                {{-- ================= NO APPOINTMENTS AT ALL ================= --}}
                <section class="mdb-card apx-empty-page" aria-labelledby="apx-empty-title">
                    <span class="mdb-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/></svg>
                    </span>
                    <h2 class="mdb-card-title" id="apx-empty-title">No appointments yet</h2>
                    <p class="mdb-empty-text">When your midwife schedules a clinic visit for you or your baby, it will appear here.</p>
                    <a href="{{ route('mother.dashboard') }}" class="mdb-btn mdb-btn-outline">
                        Back to dashboard
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </section>

            @else

                {{-- ================= SUMMARY (links jump to the matching list) ================= --}}
                <nav aria-label="Appointment summary" class="apx-summary">
                    @foreach([
                        ['label' => 'Upcoming', 'count' => $upcomingCount, 'status' => 'Scheduled', 'target' => '#appointment-upcoming'],
                        ['label' => 'Completed', 'count' => $completedAppointments, 'status' => 'Completed', 'target' => '#appointment-history'],
                        ['label' => 'Missed', 'count' => $missedAppointments, 'status' => 'Missed', 'target' => '#appointment-history'],
                        ['label' => 'Cancelled', 'count' => $cancelledAppointments, 'status' => 'Cancelled', 'target' => '#appointment-history'],
                    ] as $tile)
                        @php $meta = $statusMeta($tile['status']); @endphp
                        <a href="{{ $tile['target'] }}" class="apx-tile {{ $meta['class'] }}">
                            <span class="apx-tile-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $meta['icon'] }}"/></svg>
                            </span>
                            <span class="apx-tile-value">{{ $tile['count'] }}</span>
                            <span class="apx-tile-label">{{ $tile['label'] }}</span>
                        </a>
                    @endforeach
                </nav>


                {{-- ================= NEXT APPOINTMENT ================= --}}
                <section class="mdb-card apx-next" aria-labelledby="apx-next-title">
                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="apx-next-title">Next appointment</h2>
                        @if($nextAppointment)
                            <span class="mdb-chip mdb-chip-rose mdb-card-chip">{{ $countdown($nextAppointment->appointment_date) }}</span>
                        @endif
                    </header>

                    @if($nextAppointment)
                        @php
                            $nextDate = \Carbon\Carbon::parse($nextAppointment->appointment_date);
                            $nextMeta = $statusMeta($nextAppointment->status);
                        @endphp
                        <div class="mdb-appt">
                            <div class="mdb-datetile" aria-hidden="true">
                                <span class="mdb-datetile-month">{{ $nextDate->format('M') }}</span>
                                <span class="mdb-datetile-day">{{ $nextDate->format('d') }}</span>
                                <span class="mdb-datetile-dow">{{ $nextDate->format('D') }}</span>
                            </div>
                            <div class="mdb-appt-info">
                                <p class="mdb-appt-type">{{ $nextAppointment->appointment_type }}</p>
                                <p class="mdb-appt-date">{{ $nextDate->format('l, F d, Y') }}</p>
                                <p class="mdb-appt-meta">
                                    <span class="mdb-appt-time">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/></svg>
                                        {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}
                                    </span>
                                    <span class="apx-status {{ $nextMeta['class'] }}">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $nextMeta['icon'] }}"/></svg>
                                        {{ $nextAppointment->status }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        @if($upcomingCount > 1)
                            <a href="#appointment-upcoming" class="mdb-btn mdb-btn-outline">
                                See all {{ $upcomingCount }} upcoming visits
                                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </a>
                        @endif
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No upcoming appointments</p>
                            <p class="mdb-empty-text">You have no scheduled visits right now. Your next clinic visit will appear here once your midwife schedules it.</p>
                        </div>
                    @endif
                </section>


                {{-- ================= UPCOMING VISITS + APPOINTMENT HISTORY ================= --}}
                @php
                    $lists = [
                        [
                            'id' => 'appointment-upcoming',
                            'title' => 'Upcoming scheduled visits',
                            'items' => $upcomingAppointments,
                            'count' => $upcomingCount,
                            'upcoming' => true,
                            'paginator' => null,
                            'emptyTitle' => 'No upcoming scheduled visits',
                            'emptyText' => 'Scheduled visits from today onward will be listed here.',
                        ],
                        [
                            'id' => 'appointment-history',
                            'title' => 'Appointment history',
                            'items' => $historyAppointments->getCollection(),
                            'count' => $historyAppointments->total(),
                            'upcoming' => false,
                            'paginator' => $historyAppointments,
                            'emptyTitle' => 'No appointment history yet',
                            'emptyText' => 'Completed, missed, and cancelled visits will be listed here.',
                        ],
                    ];
                @endphp

                @foreach($lists as $list)
                    <section class="mdb-card" id="{{ $list['id'] }}" aria-labelledby="{{ $list['id'] }}-title">
                        <header class="mdb-card-head">
                            <h2 class="mdb-card-title" id="{{ $list['id'] }}-title">{{ $list['title'] }}</h2>
                            <span class="mdb-card-count">{{ $list['count'] }}</span>
                        </header>

                        @if($list['items']->isNotEmpty())
                            {{-- Grouped by month for easier scanning (order is unchanged). --}}
                            @foreach($list['items']->groupBy($monthOf) as $month => $monthItems)
                                <div class="apx-month-group">
                                    <h3 class="apx-month">{{ $month }}</h3>
                                    <ul class="apx-list">
                                        @foreach($monthItems as $appointment)
                                            @php
                                                $date = \Carbon\Carbon::parse($appointment->appointment_date)->startOfDay();
                                                $time = \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A');
                                                $meta = $statusMeta($appointment->status);
                                                $isNext = $list['upcoming'] && $nextAppointment && $appointment->id === $nextAppointment->id;
                                                // Date passed but staff have not updated the visit yet.
                                                $awaitingUpdate = $appointment->status === 'Scheduled' && $date->lt($today);
                                            @endphp
                                            <li class="apx-item">
                                                <details class="apx-details">
                                                    <summary class="apx-row">
                                                        <span class="apx-mini-date" aria-hidden="true">
                                                            <span>{{ $date->format('M') }}</span>
                                                            <strong>{{ $date->format('d') }}</strong>
                                                        </span>
                                                        <span class="apx-row-main">
                                                            <span class="apx-row-type">
                                                                {{ $appointment->appointment_type }}
                                                                @if($isNext)
                                                                    <span class="mdb-chip mdb-chip-rose apx-next-chip">Next</span>
                                                                @endif
                                                            </span>
                                                            <span class="apx-row-sub">
                                                                {{ $date->format('D, M d, Y') }} · {{ $time }}@if($list['upcoming']) · <span class="apx-row-countdown">{{ $countdown($appointment->appointment_date) }}</span>@endif
                                                            </span>
                                                            @if($awaitingUpdate)
                                                                <span class="apx-awaiting">Date passed · awaiting update from your midwife</span>
                                                            @endif
                                                        </span>
                                                        <span class="apx-status {{ $meta['class'] }}">
                                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $meta['icon'] }}"/></svg>
                                                            {{ $appointment->status }}
                                                        </span>
                                                        <svg class="apx-chevron" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                                    </summary>

                                                    <dl class="apx-facts">
                                                        <div><dt>Appointment type</dt><dd>{{ $appointment->appointment_type }}</dd></div>
                                                        <div><dt>Date</dt><dd>{{ $date->format('l, F d, Y') }}</dd></div>
                                                        <div><dt>Time</dt><dd>{{ $time }}</dd></div>
                                                        <div><dt>Status</dt><dd>{{ $appointment->status }}</dd></div>
                                                        @if($list['upcoming'])
                                                            <div><dt>Countdown</dt><dd>{{ $countdown($appointment->appointment_date) }}</dd></div>
                                                        @endif
                                                    </dl>
                                                </details>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach

                            @if($list['paginator'] && $list['paginator']->hasPages())
                                <nav class="apx-pagination" aria-label="Appointment history pages">
                                    {{ $list['paginator']->links() }}
                                </nav>
                            @endif
                        @else
                            <div class="mdb-empty">
                                <p class="mdb-empty-title">{{ $list['emptyTitle'] }}</p>
                                <p class="mdb-empty-text">{{ $list['emptyText'] }}</p>
                            </div>
                        @endif
                    </section>
                @endforeach

            @endif

        </div>

    </div>

</x-app-layout>
