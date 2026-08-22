<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 sm:space-y-6">

            {{-- ====================================== --}}
            {{-- GREETING SECTION --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl bg-white border border-slate-100 p-5 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-[13px] sm:text-sm font-semibold text-pink-500">
                            {{ now()->format('A') === 'AM' ? 'Good morning' : 'Good afternoon' }}
                        </p>

                        <h1 class="mt-0.5 text-[22px] sm:text-3xl font-bold text-slate-900 leading-tight truncate">
                            {{ $mother->first_name }} {{ $mother->last_name }}
                        </h1>

                        <div class="mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1">
                            <p class="text-[12px] sm:text-sm text-slate-400">
                                {{ now()->format('l, F d, Y') }}
                            </p>

                            @if(isset($mother->pregnancy_week) || isset($mother->trimester))
                                <span class="text-slate-300">&middot;</span>
                                <p class="text-[12px] sm:text-sm font-medium text-pink-600">
                                    @if(isset($mother->pregnancy_week))
                                        Week {{ $mother->pregnancy_week }}
                                    @endif
                                    @if(isset($mother->pregnancy_week) && isset($mother->trimester))
                                        &middot;
                                    @endif
                                    @if(isset($mother->trimester))
                                        {{ $mother->trimester }} trimester
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 rounded-full bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white font-bold text-sm sm:text-base shadow-sm shadow-pink-200">
                        {{ strtoupper(substr($mother->first_name, 0, 1) . substr($mother->last_name, 0, 1)) }}
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- NEXT APPOINTMENT CARD (Hero) --}}
            {{-- ====================================== --}}

            @if($nextAppointment)

                @php
                    $appointmentDate = \Carbon\Carbon::parse($nextAppointment->appointment_date);
                    $daysRemaining = now()->startOfDay()->diffInDays($appointmentDate->copy()->startOfDay(), false);

                    $countdownLabel = match(true) {
                        $daysRemaining === 0 => 'Today',
                        $daysRemaining === 1 => 'Tomorrow',
                        $daysRemaining > 1 => $daysRemaining . ' days remaining',
                        default => $appointmentDate->diffForHumans(),
                    };
                @endphp

                <div class="rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-7 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -right-2 bottom-2 h-16 w-16 rounded-full bg-white/10"></div>

                    <div class="relative flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-pink-50">
                                Next appointment
                            </p>
                        </div>

                        <span class="flex-shrink-0 rounded-full bg-white/20 px-3 py-1 text-[11px] font-bold text-white backdrop-blur-sm">
                            {{ $countdownLabel }}
                        </span>
                    </div>

                    @if(isset($nextAppointment->appointment_type))
                        <p class="relative mt-4 text-[13px] sm:text-sm font-semibold text-pink-50">
                            {{ $nextAppointment->appointment_type }}
                        </p>
                    @endif

                    <h2 class="relative mt-1 text-lg sm:text-2xl font-bold">
                        {{ $appointmentDate->format('F d, Y') }}
                    </h2>

                    <p class="relative mt-1 flex items-center gap-1.5 text-[13px] sm:text-sm text-pink-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}

                        @if(isset($nextAppointment->status))
                            <span class="ml-1 rounded-full bg-white/20 px-2.5 py-0.5 text-[11px] font-semibold text-white">
                                {{ $nextAppointment->status }}
                            </span>
                        @endif
                    </p>

                    <a href="{{ route('mother.appointments') }}"
                       class="relative mt-5 inline-flex items-center gap-1.5 rounded-full bg-white px-4 py-2 text-[13px] sm:text-sm font-semibold text-pink-600 transition hover:bg-pink-50">
                        View details
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>

            @else

                {{-- Empty State --}}
                <div class="rounded-2xl bg-white border border-dashed border-pink-200 p-6 sm:p-8 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-50 text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-[15px] sm:text-base font-bold text-slate-900">
                        No upcoming appointments
                    </h3>
                    <p class="mt-1 text-[13px] sm:text-sm text-slate-500">
                        You're all caught up. Your next visit will appear here once it's scheduled.
                    </p>

                    <a href="{{ route('mother.appointments') }}"
                       class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-pink-600 px-5 py-2.5 text-[13px] sm:text-sm font-semibold text-white transition hover:bg-pink-700">
                        View Appointments
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>

            @endif

            {{-- ====================================== --}}
            {{-- VACCINATION REMINDER CARD --}}
            {{-- Placeholder: bind to real reminder/vaccination data once available --}}
            {{-- Styling only — text and logic unchanged. Urgent styling applied --}}
            {{-- because the current placeholder text ("due in 3 days") falls --}}
            {{-- within the 7-day urgency window. --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-4 sm:p-5 flex items-center gap-3 shadow-sm">

                <div class="h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                        Vaccination due soon
                    </p>
                    <p class="text-[12px] sm:text-[13px] text-amber-700">
                        Baby's next dose is due in 3 days
                    </p>
                </div>

                <a href="{{ route('mother.infant-records') }}"
                   aria-label="View vaccination details"
                   class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-white text-amber-600 shadow-sm transition hover:bg-amber-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>

            {{-- ====================================== --}}
            {{-- FEATURED: INFANT RECORDS --}}
            {{-- Full-width, primary feature — consolidated hub for --}}
            {{-- infant details, vaccinations, growth monitoring, growth charts --}}
            {{-- ====================================== --}}

            <a href="{{ route('mother.infant-records') }}"
               class="block w-full text-left rounded-2xl bg-gradient-to-br from-rose-500 via-pink-500 to-pink-600 p-5 sm:p-7 shadow-md shadow-pink-200 transition hover:shadow-lg hover:-translate-y-0.5 relative overflow-hidden">

                <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-white/10"></div>
                <div class="absolute -right-2 bottom-2 h-20 w-20 rounded-full bg-white/10"></div>
                <div class="absolute left-1/2 top-0 h-24 w-24 -translate-x-1/2 rounded-full bg-white/5"></div>

                <div class="relative flex items-start gap-4">

                    <div class="h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 rounded-2xl bg-white/20 flex items-center justify-center text-white backdrop-blur-sm">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[16px] sm:text-lg font-bold text-white">
                            Infant Records
                        </p>
                        <p class="text-[12px] sm:text-sm text-pink-50 mt-1 leading-relaxed">
                            Infant details, vaccinations, growth monitoring, and growth charts — all in one place.
                        </p>
                    </div>

                    <svg class="h-5 w-5 flex-shrink-0 text-pink-100 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>

                </div>

            </a>

            {{-- ====================================== --}}
            {{-- NAVIGATION CARDS (Quick Actions) --}}
            {{-- Mobile-first: 2-col on mobile, 4-col from sm --}}
            {{-- ====================================== --}}

            @php
                $navLinks = [
                    [
                        'title' => 'My profile',
                        'description' => 'Personal details',
                        'route' => 'mother.profile',
                        'icon' => 'profile',
                        'iconBg' => 'bg-rose-50',
                        'iconColor' => 'text-rose-500',
                    ],
                    [
                        'title' => 'Appointments',
                        'description' => 'Upcoming & past',
                        'route' => 'mother.appointments',
                        'icon' => 'calendar',
                        'iconBg' => 'bg-fuchsia-50',
                        'iconColor' => 'text-fuchsia-500',
                    ],
                    [
                        'title' => 'Prenatal records',
                        'description' => 'Checkup history',
                        'route' => 'mother.prenatal-records',
                        'icon' => 'heartbeat',
                        'iconBg' => 'bg-pink-50',
                        'iconColor' => 'text-pink-600',
                    ],
                    [
                        'title' => 'SMS history',
                        'description' => 'Reminder log',
                        'route' => 'mother.sms-history',
                        'icon' => 'sms',
                        'iconBg' => 'bg-rose-50',
                        'iconColor' => 'text-rose-500',
                    ],
                ];
            @endphp

            <div>
                <p class="mb-3 px-1 text-[12px] sm:text-sm font-semibold uppercase tracking-wide text-slate-400">
                    Quick Actions
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">

                    @foreach($navLinks as $link)

                        <a href="{{ route($link['route']) }}"
                           class="group block text-left rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-pink-200 hover:shadow-md">

                            <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl {{ $link['iconBg'] }} flex items-center justify-center {{ $link['iconColor'] }} mb-3 transition group-hover:scale-105">

                                @switch($link['icon'])

                                    @case('profile')
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                        </svg>
                                        @break

                                    @case('calendar')
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                        @break

                                    @case('heartbeat')
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"/>
                                        </svg>
                                        @break

                                    @case('sms')
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25V6.75A2.25 2.25 0 014.5 4.5h15A2.25 2.25 0 0121.75 6.75Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 7.5 8.291 5.527a1.25 1.25 0 001.418 0L21 7.5"/>
                                        </svg>
                                        @break

                                @endswitch

                            </div>

                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ $link['title'] }}
                            </p>
                            <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                                {{ $link['description'] }}
                            </p>

                        </a>

                    @endforeach

                </div>
            </div>

        </div>

    </div>

</x-app-layout>