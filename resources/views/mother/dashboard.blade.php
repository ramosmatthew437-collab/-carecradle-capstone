<x-app-layout>

    @php
        $greeting = now()->hour < 12 ? 'Good morning' : (now()->hour < 18 ? 'Good afternoon' : 'Good evening');
        $initials = strtoupper(mb_substr((string) $mother->first_name, 0, 1) . mb_substr((string) $mother->last_name, 0, 1));
        $plural = fn (int $n, string $word) => $n . ' ' . $word . ($n === 1 ? '' : 's');
        $isDelivered = $mother->status === 'Delivered';

        // Welcome line that matches the mother's recorded status. It never
        // implies an ongoing pregnancy unless the status is Pregnant.
        $welcomeLine = match (true) {
            $isPregnant => 'Here is an overview of your pregnancy care and your family\'s health records.',
            $isDelivered => 'Wishing you and your little one good health. Your maternal and child health records are here whenever you need them.',
            default => 'Here is an overview of your maternal and child health records.',
        };

        // Age of a child from the recorded birth date.
        $childAge = function ($birthDate) use ($plural) {
            $born = \Carbon\Carbon::parse($birthDate)->startOfDay();
            $days = (int) $born->diffInDays(today());
            $months = (int) $born->diffInMonths(today());

            return match (true) {
                $days < 30 => $plural($days, 'day') . ' old',
                $months < 24 => $plural($months, 'month') . ' old',
                default => $plural((int) $born->diffInYears(today()), 'year') . ' old',
            };
        };

        $childrenShown = 3;
        $number = fn ($value) => rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
    @endphp

    <div class="mdb mdb-home" style="--cc-rhu-image: url('{{ asset('images/irosin-rhu-building.png') }}');">

        <div class="mdb-container">

            {{-- ================= HERO ================= --}}
            <section class="mdb-hero" aria-labelledby="mdb-hero-name">

                <div class="mdb-hero-body">

                    <p class="mdb-hero-eyebrow">Mother Portal</p>

                    <p class="mdb-hero-top">
                        <span class="mdb-greeting">{{ $greeting }}</span>
                        <span class="mdb-hero-sep" aria-hidden="true">·</span>
                        <span class="mdb-hero-date">{{ now()->format('l, F d, Y') }}</span>
                    </p>

                    <h1 class="mdb-hero-name" id="mdb-hero-name">
                        {{ $mother->first_name }} {{ $mother->last_name }}
                    </h1>

                    <p class="mdb-hero-lead">{{ $welcomeLine }}</p>

                    {{-- Pregnancy details: only while the recorded status is Pregnant. --}}
                    @if($isPregnant && ($pregnancyWeek || $expectedDeliveryDate))
                        <div class="mdb-pregnancy">

                            <div class="mdb-pregnancy-meta">
                                @if($pregnancyWeek)
                                    <span class="mdb-pregnancy-week">Week {{ $pregnancyWeek }} <span>· {{ $trimester }} trimester</span></span>
                                @endif

                                @if($expectedDeliveryDate)
                                    <span class="mdb-pregnancy-edd">
                                        Expected delivery <strong>{{ $expectedDeliveryDate->format('M d, Y') }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if($pregnancyWeek)
                                <div class="mdb-progress"
                                     role="progressbar"
                                     aria-valuenow="{{ $pregnancyWeek }}"
                                     aria-valuemin="0"
                                     aria-valuemax="40"
                                     aria-label="Pregnancy progress: week {{ $pregnancyWeek }} of 40">
                                    <span style="width: {{ min(100, round(($pregnancyWeek / 40) * 100)) }}%"></span>
                                </div>

                                <div class="mdb-progress-scale">
                                    <span>Pregnancy journey</span>
                                    <span>Week {{ $pregnancyWeek }} of 40</span>
                                </div>
                            @endif

                        </div>
                    @endif

                </div>

                <div class="mdb-hero-side">
                    <div class="mdb-avatar" role="img" aria-label="{{ $mother->first_name }} {{ $mother->last_name }}">
                        {{ $initials }}
                    </div>
                </div>

                {{-- Secondary institutional identity (CareCradle stays primary in the sidebar). --}}
                <p class="mdb-hero-institution">
                    <img class="mdb-hero-logo" src="{{ asset('images/irosin-rhu-logo.jpg') }}" alt="Irosin Rural Health Unit logo" width="26" height="26">
                    <span>Irosin Rural Health Unit</span>
                </p>

            </section>


            {{-- ================= CURRENT REFERRAL (facility and date only) ================= --}}
            @if($currentReferral)
                <a href="{{ route('mother.referrals') }}" class="mdb-referral">
                    <span class="mdb-referral-icon" aria-hidden="true">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                    </span>
                    <span class="mdb-referral-text">
                        <strong>You have a current referral</strong>
                        To {{ $currentReferral->receiving_facility }} since {{ \Illuminate\Support\Carbon::parse($currentReferral->referred_at)->format('F d, Y') }}.
                    </span>
                    <span class="mdb-referral-link">View <span aria-hidden="true">&rarr;</span></span>
                </a>
            @endif


            <div class="mdb-home-grid">

                {{-- ================= NEXT APPOINTMENT ================= --}}
                <section class="mdb-card mdb-home-appt" aria-labelledby="mdb-appt-title">

                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="mdb-appt-title">Next appointment</h2>

                        @if($nextAppointment)
                            @php
                                $appointmentDate = \Carbon\Carbon::parse($nextAppointment->appointment_date)->startOfDay();
                                $daysAway = (int) today()->diffInDays($appointmentDate, false);
                                $countdownLabel = match (true) {
                                    $daysAway === 0 => 'Today',
                                    $daysAway === 1 => 'Tomorrow',
                                    default => 'In ' . $daysAway . ' days',
                                };
                            @endphp
                            <span class="mdb-chip mdb-chip-rose mdb-card-chip">{{ $countdownLabel }}</span>
                        @endif
                    </header>

                    @if($nextAppointment)
                        <div class="mdb-appt">
                            <div class="mdb-datetile" aria-hidden="true">
                                <span class="mdb-datetile-month">{{ $appointmentDate->format('M') }}</span>
                                <span class="mdb-datetile-day">{{ $appointmentDate->format('d') }}</span>
                                <span class="mdb-datetile-dow">{{ $appointmentDate->format('D') }}</span>
                            </div>

                            <div class="mdb-appt-info">
                                <p class="mdb-appt-type">{{ $nextAppointment->appointment_type }}</p>
                                <p class="mdb-appt-date">{{ $appointmentDate->format('l, F d, Y') }}</p>
                                <p class="mdb-appt-meta">
                                    <span class="mdb-appt-time">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/></svg>
                                        {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}
                                    </span>
                                    <span class="mdb-chip">{{ $nextAppointment->status }}</span>
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('mother.appointments') }}" class="mdb-btn mdb-btn-primary">
                            View appointment details
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No upcoming appointments</p>
                            <p class="mdb-empty-text">You're all caught up. Your next clinic visit will appear here once your midwife schedules it.</p>
                        </div>

                        <a href="{{ route('mother.appointments') }}" class="mdb-btn mdb-btn-outline">
                            View appointment history
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif

                </section>


                {{-- ================= VACCINATION REMINDERS (you + your children) ================= --}}
                <section class="mdb-card mdb-home-vax" aria-labelledby="mdb-vax-title">

                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m14 4 6 6M12.5 5.5l6 6M4 20l5.5-1.5L20 8a2.12 2.12 0 0 0-3-3L6.5 15.5 4 20Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m8 14 2 2M6.5 16.5l2 2"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="mdb-vax-title">Vaccination reminders</h2>

                        @if($vaccinationReminderTotal > 0)
                            <span class="mdb-card-count">{{ $vaccinationReminderTotal }}</span>
                        @endif
                    </header>

                    @if($vaccinationReminders->isNotEmpty())
                        <ul class="mdb-vax-list">
                            @foreach($vaccinationReminders as $reminder)
                                @php
                                    // Presentation only: overdue, due soon (within 7 days), or upcoming.
                                    [$stateClass, $stateLabel, $whenLabel] = match (true) {
                                        $reminder['overdue'] => ['is-overdue', 'Overdue', $plural(abs($reminder['days']), 'day') . ' overdue'],
                                        $reminder['days'] === 0 => ['is-soon', 'Due soon', 'Due today'],
                                        $reminder['days'] === 1 => ['is-soon', 'Due soon', 'Due tomorrow'],
                                        $reminder['days'] <= 7 => ['is-soon', 'Due soon', 'In ' . $reminder['days'] . ' days'],
                                        default => ['is-upcoming', 'Upcoming', 'In ' . $reminder['days'] . ' days'],
                                    };
                                @endphp
                                <li class="mdb-vax-item {{ $stateClass }}">
                                    <span class="mdb-vax-who {{ $reminder['maternal'] ? 'is-you' : '' }}">{{ $reminder['who'] }}</span>
                                    <div class="mdb-vax-main">
                                        <p class="mdb-vax-name">{{ $reminder['vaccine'] }}</p>
                                        <p class="mdb-vax-sub">
                                            Due {{ $reminder['due']->format('M d, Y') }} · next dose after {{ $reminder['lastDose'] }}
                                        </p>
                                    </div>
                                    <span class="mdb-vax-when">
                                        <span class="mdb-vax-state">{{ $stateLabel }}</span>
                                        {{ $whenLabel }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        @if($vaccinationReminderTotal > $vaccinationReminders->count())
                            <p class="mdb-more">+ {{ $plural($vaccinationReminderTotal - $vaccinationReminders->count(), 'more reminder') }}</p>
                        @endif
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No vaccinations due</p>
                            <p class="mdb-empty-text">When your midwife records a vaccination with a next due date for you or your child, the reminder will appear here.</p>
                        </div>
                    @endif

                    <a href="{{ route('mother.vaccinations') }}" class="mdb-btn mdb-btn-outline">
                        View my vaccinations
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>

                </section>


                {{-- ================= INFANT & CHILD RECORDS ================= --}}
                <section class="mdb-card mdb-home-children" aria-labelledby="mdb-children-title">

                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="mdb-children-title">Infant &amp; child records</h2>

                        @if($infantCount > 0)
                            <span class="mdb-card-count">{{ $infantCount }}</span>
                        @endif
                    </header>

                    @if($infants->isNotEmpty())
                        <ul class="mdb-children">
                            @foreach($infants->take($childrenShown) as $child)
                                <li class="mdb-child">
                                    <span class="mdb-child-initial" aria-hidden="true">{{ strtoupper(mb_substr((string) $child->first_name, 0, 1)) }}</span>
                                    <div class="mdb-child-main">
                                        <p class="mdb-child-name">{{ $child->first_name }} {{ $child->last_name }}</p>
                                        <p class="mdb-child-sub">
                                            {{ $childAge($child->birth_date) }}@if($child->sex) · {{ ucfirst($child->sex) }}@endif
                                        </p>
                                        <p class="mdb-child-birth">
                                            Born {{ \Carbon\Carbon::parse($child->birth_date)->format('M d, Y') }}@if($child->birth_weight) · {{ $number($child->birth_weight) }} kg at birth @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        @if($infants->count() > $childrenShown)
                            <p class="mdb-more">+ {{ $plural($infants->count() - $childrenShown, 'more child record') }}</p>
                        @endif

                        <a href="{{ route('mother.infant-records') }}" class="mdb-btn mdb-btn-outline">
                            {{ $infants->count() > 1 ? 'View all ' . $infants->count() . ' child records' : 'View infant records' }}
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No child records yet</p>
                            <p class="mdb-empty-text">Your baby's profile, vaccinations, growth monitoring, and WHO growth charts will appear here once your midwife registers them.</p>
                        </div>

                        <a href="{{ route('mother.infant-records') }}" class="mdb-btn mdb-btn-outline">
                            View infant records
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif

                </section>


                {{-- ================= AT A GLANCE (actual record counts) ================= --}}
                <section class="mdb-card mdb-home-glance" aria-labelledby="mdb-glance-title">

                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125Z"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="mdb-glance-title">At a glance</h2>
                    </header>

                    @php
                        $stats = [
                            ['route' => 'mother.appointments', 'count' => $appointmentCount, 'label' => $appointmentCount === 1 ? 'Appointment' : 'Appointments', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z'],
                            ['route' => 'mother.prenatal-records', 'count' => $prenatalCount, 'label' => $prenatalCount === 1 ? 'Prenatal visit' : 'Prenatal visits', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M8.25 8.25H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z'],
                            ['route' => 'mother.infant-records', 'count' => $infantCount, 'label' => $infantCount === 1 ? 'Child' : 'Children', 'icon' => 'M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z'],
                            ['route' => 'mother.sms-history', 'count' => $smsCount, 'label' => $smsCount === 1 ? 'SMS message' : 'SMS messages', 'icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z'],
                        ];
                    @endphp

                    <div class="mdb-stats">
                        @foreach($stats as $stat)
                            <a href="{{ route($stat['route']) }}" class="mdb-stat">
                                <span class="mdb-stat-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/></svg>
                                </span>
                                <span class="mdb-stat-value">{{ $stat['count'] }}</span>
                                <span class="mdb-stat-label">{{ $stat['label'] }}</span>
                            </a>
                        @endforeach
                    </div>

                </section>

            </div>


            {{-- ================= QUICK ACTIONS ================= --}}
            @php
                $quickActions = [
                    [
                        'title' => 'My Profile',
                        'description' => 'View your personal and maternal information.',
                        'route' => 'mother.profile',
                        'icon' => 'M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z',
                    ],
                    [
                        'title' => 'My Vaccinations',
                        'description' => 'Review vaccination records and upcoming doses.',
                        'route' => 'mother.vaccinations',
                        'icon' => 'm14 4 6 6M12.5 5.5l6 6M4 20l5.5-1.5L20 8a2.12 2.12 0 0 0-3-3L6.5 15.5 4 20Z',
                    ],
                    [
                        'title' => 'Featured Health Tips',
                        'description' => 'Practical guidance for a healthy pregnancy and baby.',
                        'route' => 'mother.health-tips',
                        'icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z',
                    ],
                ];
            @endphp

            <section class="mdb-actions" aria-labelledby="mdb-actions-title">
                <h2 class="mdb-section-title" id="mdb-actions-title">Quick actions</h2>

                <div class="mdb-action-grid">
                    @foreach($quickActions as $action)
                        <a href="{{ route($action['route']) }}" class="mdb-action">
                            <span class="mdb-action-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/></svg>
                            </span>
                            <span class="mdb-action-copy">
                                <span class="mdb-action-title">{{ $action['title'] }}</span>
                                <span class="mdb-action-desc">{{ $action['description'] }}</span>
                            </span>
                            <svg class="mdb-action-arrow" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            </section>

        </div>

    </div>

</x-app-layout>
