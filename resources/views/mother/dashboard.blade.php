<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- GREETING SECTION --}}
            {{-- ====================================== --}}

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-[13px] sm:text-sm font-medium text-pink-500">
                        {{ now()->format('A') === 'AM' ? 'Good morning' : 'Good afternoon' }}
                    </p>

                    <h1 class="text-[22px] sm:text-3xl font-bold text-slate-900 leading-tight">
                        {{ $mother->first_name }} {{ $mother->last_name }}
                    </h1>

                    @if(isset($mother->pregnancy_week) || isset($mother->trimester))
                        <p class="mt-0.5 text-[13px] sm:text-sm text-slate-500">
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

                <div class="h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 rounded-full bg-pink-100 border border-pink-200 flex items-center justify-center text-pink-600 font-bold text-sm sm:text-base">
                    {{ strtoupper(substr($mother->first_name, 0, 1) . substr($mother->last_name, 0, 1)) }}
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- NEXT APPOINTMENT CARD --}}
            {{-- ====================================== --}}

            @if($nextAppointment)

                <div class="mt-5 rounded-2xl bg-pink-500 p-5 sm:p-6 text-white shadow-sm shadow-pink-200 relative overflow-hidden">

                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white/10"></div>
                    <div class="absolute -right-1 bottom-2 h-14 w-14 rounded-full bg-white/10"></div>

                    <div class="relative flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-pink-50">
                            Next appointment
                        </p>
                    </div>

                    <h2 class="relative mt-2 text-lg sm:text-xl font-bold">
                        {{ \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('F d, Y') }}
                    </h2>

                    <p class="relative mt-1 text-[13px] sm:text-sm text-pink-50">
                        {{ \Carbon\Carbon::parse($nextAppointment->appointment_time)->format('g:i A') }}
                    </p>

                    <a href="{{ route('mother.appointments') }}"
                       class="relative mt-4 inline-flex items-center gap-1 rounded-full bg-white px-4 py-2 text-[13px] sm:text-sm font-semibold text-pink-600 transition">
                        View details
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>

            @else

                <div class="mt-5 rounded-2xl bg-pink-50 border border-pink-100 px-4 py-3 flex items-center gap-3">

                    <div class="h-9 w-9 flex-shrink-0 rounded-full bg-white flex items-center justify-center text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </div>

                    <p class="text-[13px] sm:text-sm font-medium text-pink-700">
                        No upcoming appointments — you're all caught up.
                    </p>

                </div>

            @endif

            {{-- ====================================== --}}
            {{-- VACCINATION REMINDER CARD --}}
            {{-- Placeholder: bind to real reminder/vaccination data once available --}}
            {{-- ====================================== --}}

            <div class="mt-4 rounded-2xl bg-white border border-rose-100 p-4 sm:p-5 flex items-center gap-3 shadow-sm">

                <div class="h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                        Vaccination due soon
                    </p>
                    <p class="text-[12px] sm:text-[13px] text-slate-500">
                        Baby's next dose is due in 3 days
                    </p>
                </div>

                <a href="{{ route('mother.infant-records') }}" aria-label="View vaccination details">
                    <svg class="h-4 w-4 flex-shrink-0 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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
               class="mt-6 block w-full text-left rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-6 shadow-md shadow-pink-200 transition hover:shadow-lg relative overflow-hidden">

                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/10"></div>
                <div class="absolute -right-2 bottom-3 h-16 w-16 rounded-full bg-white/10"></div>

                <div class="relative flex items-start gap-4">

                    <div class="h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 rounded-xl bg-white/20 flex items-center justify-center text-white">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-[16px] sm:text-lg font-bold text-white">
                            Infant records
                        </p>
                        <p class="text-[12px] sm:text-sm text-pink-50 mt-1">
                            Infant details, vaccinations, growth monitoring, and growth charts — all in one place.
                        </p>
                    </div>

                    <svg class="h-5 w-5 flex-shrink-0 text-pink-100 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>

                </div>

            </a>

            {{-- ====================================== --}}
            {{-- NAVIGATION CARDS --}}
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

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">

                @foreach($navLinks as $link)

                    <a href="{{ route($link['route']) }}"
                       class="block text-left rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition hover:border-pink-200">

                        <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-xl {{ $link['iconBg'] }} flex items-center justify-center {{ $link['iconColor'] }} mb-3">

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

</x-app-layout>