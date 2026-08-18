<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CareCradle Midwife Dashboard
        </h2>
    </x-slot>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">
        <div class="max-w-2xl lg:max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- WELCOME BANNER --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl bg-gradient-to-br from-pink-600 to-pink-700 p-5 sm:p-8 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                <div class="absolute -right-8 -top-8 h-28 w-28 sm:h-40 sm:w-40 rounded-full bg-white/10"></div>
                <div class="absolute -right-2 bottom-3 h-16 w-16 sm:h-24 sm:w-24 rounded-full bg-white/10"></div>

                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>
                        <div class="flex items-center gap-3">
                            <div class="h-11 w-11 sm:h-14 sm:w-14 flex-shrink-0 rounded-xl sm:rounded-2xl bg-white/15 ring-1 ring-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5.5 w-5.5 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-sm font-semibold uppercase tracking-widest text-pink-100">Midwife Portal</p>
                        </div>

                        <h1 class="mt-3 text-xl sm:text-3xl font-bold">
                            Welcome back, {{ Auth::user()->name }}
                        </h1>

                        <p class="mt-1 text-[13px] sm:text-sm text-pink-100 max-w-xl">
                            Manage maternal records, prenatal consultations, appointments, infant monitoring, growth tracking, and vaccination schedules.
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 rounded-xl bg-white/10 ring-1 ring-white/20 px-3 py-2 sm:px-4 sm:py-3 self-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                        <div>
                            <p class="text-[10px] sm:text-xs uppercase tracking-widest text-pink-100">Today</p>
                            <p class="text-[12px] sm:text-sm font-semibold">{{ now()->format('l, F d, Y') }}</p>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SYSTEM OVERVIEW --}}
            {{-- Same $infants / $mothers / $vaccinations / $appointments --}}
            {{-- ====================================== --}}

            <div>
                <h2 class="text-[15px] sm:text-xl font-bold text-slate-900">System overview</h2>
                <p class="text-[12px] sm:text-sm text-slate-500 mb-3 sm:mb-4">Real-time summary of maternal and infant healthcare records</p>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[11px] sm:text-sm text-slate-400">Registered infants</p>
                                <p class="mt-1 text-[22px] sm:text-3xl font-bold text-slate-900">{{ $infants }}</p>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-xl sm:rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[11px] sm:text-sm text-slate-400">Registered mothers</p>
                                <p class="mt-1 text-[22px] sm:text-3xl font-bold text-slate-900">{{ $mothers }}</p>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-xl sm:rounded-2xl bg-pink-100 flex items-center justify-center text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[11px] sm:text-sm text-slate-400">Vaccinations given</p>
                                <p class="mt-1 text-[22px] sm:text-3xl font-bold text-slate-900">{{ $vaccinations }}</p>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-xl sm:rounded-2xl bg-green-100 flex items-center justify-center text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-[11px] sm:text-sm text-slate-400">Upcoming appointments</p>
                                <p class="mt-1 text-[22px] sm:text-3xl font-bold text-slate-900">{{ $appointments }}</p>
                            </div>
                            <div class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-xl sm:rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75V3m7.5 3.75V3M3.75 9.75h16.5m-15 10.5h13.5A1.5 1.5 0 0020.25 18V6A1.5 1.5 0 0018.75 4.5H5.25A1.5 1.5 0 003.75 6v12A1.5 1.5 0 005.25 20.25Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- QUICK ACTIONS --}}
            {{-- mothers.index / sms-notifications.index routes --}}
            {{-- ====================================== --}}

            <div>
                <h2 class="text-[15px] sm:text-xl font-bold text-slate-900">Quick actions</h2>
                <p class="text-[12px] sm:text-sm text-slate-500 mb-3 sm:mb-4">Jump into the core CareCradle modules</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 max-w-3xl mx-auto">

                    {{-- Mother Management --}}
                    <a href="{{ route('mothers.index') }}"
                       class="group relative overflow-hidden rounded-2xl bg-white border border-slate-100 p-6 sm:p-8 shadow-sm transition duration-200 hover:shadow-lg hover:border-pink-200 hover:-translate-y-0.5">

                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-pink-50 transition group-hover:bg-pink-100"></div>

                        <div class="relative">
                            <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-600 mb-4 sm:mb-6 transition group-hover:bg-pink-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Zm9 0v.01M6 12v.01"/>
                                </svg>
                            </div>

                            <p class="text-[15px] sm:text-xl font-bold text-slate-900">Mother management</p>
                            <p class="mt-2 text-[12px] sm:text-sm leading-relaxed text-slate-500">
                                Manage maternal records, prenatal visits, appointments, infant registration, and growth monitoring in one centralized module.
                            </p>

                            <p class="mt-4 sm:mt-6 flex items-center gap-1.5 text-[12px] sm:text-sm font-semibold text-pink-600">
                                Open module
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </p>
                        </div>
                    </a>

                    {{-- SMS Notifications --}}
                    <a href="{{ route('sms-notifications.index') }}"
                       class="group relative overflow-hidden rounded-2xl bg-white border border-slate-100 p-6 sm:p-8 shadow-sm transition duration-200 hover:shadow-lg hover:border-amber-200 hover:-translate-y-0.5">

                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-amber-50 transition group-hover:bg-amber-100"></div>

                        <div class="relative">
                            <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 mb-4 sm:mb-6 transition group-hover:bg-amber-500 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </div>

                            <p class="text-[15px] sm:text-xl font-bold text-slate-900">SMS notifications</p>
                            <p class="mt-2 text-[12px] sm:text-sm leading-relaxed text-slate-500">
                                View appointment reminders, monitor notification status, and send healthcare SMS alerts to mothers.
                            </p>

                            <p class="mt-4 sm:mt-6 flex items-center gap-1.5 text-[12px] sm:text-sm font-semibold text-amber-600">
                                Open module
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </p>
                        </div>
                    </a>

                </div>
            </div>
            {{-- ====================================== --}}
            {{-- TODAY'S APPOINTMENTS + UPCOMING VACCINATIONS --}}
            {{-- Same $todayAppointments / $upcomingVaccinations, --}}
            {{-- table markup replaced with stacked cards --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                {{-- Today's Appointments --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-[15px] sm:text-lg font-bold text-slate-900">Today's appointments</h2>
                        <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-700">
                            {{ $todayAppointments->count() }} scheduled
                        </span>
                    </div>

                    @if($todayAppointments->count())

                        @php
                            $appointmentStatusClasses = fn ($status) => match ($status) {
                                'Scheduled' => 'bg-blue-50 text-blue-700',
                                'Completed' => 'bg-emerald-50 text-emerald-700',
                                'Cancelled' => 'bg-rose-50 text-rose-600',
                                'Missed' => 'bg-yellow-50 text-yellow-700',
                                default => 'bg-slate-100 text-slate-600',
                            };

                            $appointmentDotClasses = fn ($status) => match ($status) {
                                'Scheduled' => 'bg-blue-500',
                                'Completed' => 'bg-emerald-500',
                                'Cancelled' => 'bg-rose-500',
                                'Missed' => 'bg-yellow-500',
                                default => 'bg-slate-400',
                            };
                        @endphp

                        <div class="space-y-3">

                            @foreach($todayAppointments as $appointment)

                                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                    <div class="flex items-center gap-2 mb-1.5">
                                        <div class="h-8 w-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                            </svg>
                                        </div>
                                        <p class="text-[13px] sm:text-sm font-bold text-slate-900">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        </p>
                                    </div>

                                    <p class="text-[13px] sm:text-sm font-semibold text-slate-700">
                                        {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}
                                    </p>

                                    <p class="text-[12px] sm:text-[13px] text-slate-400">
                                        {{ $appointment->appointment_type }}
                                    </p>

                                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-full {{ $appointmentStatusClasses($appointment->status) }} px-2.5 py-1 text-[11px] sm:text-xs font-semibold">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $appointmentDotClasses($appointment->status) }}"></span>
                                        {{ $appointment->status }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl bg-white border border-slate-100 p-8 sm:p-10 text-center shadow-sm">
                            <div class="h-14 w-14 sm:h-16 sm:w-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75V3m7.5 3.75V3M3.75 9.75h16.5m-15 10.5h13.5A1.5 1.5 0 0020.25 18V6A1.5 1.5 0 0018.75 4.5H5.25A1.5 1.5 0 003.75 6v12A1.5 1.5 0 005.25 20.25Z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-[14px] sm:text-base font-semibold text-slate-900">No appointments today</h3>
                            <p class="mt-1 text-[12px] sm:text-sm text-slate-500">There are no scheduled appointments for today.</p>
                        </div>

                    @endif

                </div>

                {{-- Upcoming Vaccinations --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-[15px] sm:text-lg font-bold text-slate-900">Upcoming vaccinations</h2>
                        <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-700">
                            {{ $upcomingVaccinations->count() }} upcoming
                        </span>
                    </div>

                    @if($upcomingVaccinations->count())

                        <div class="space-y-3">

                            @foreach($upcomingVaccinations as $vaccination)

                                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="h-9 w-9 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                            </svg>
                                        </div>
                                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                            {{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }}
                                        </p>
                                    </div>

                                    <p class="text-[12px] sm:text-[13px] text-slate-500">
                                        {{ $vaccination->vaccine_name }}
                                    </p>

                                    <span class="inline-flex mt-1.5 items-center rounded-full bg-yellow-100 px-3 py-1 text-[11px] sm:text-xs font-semibold text-yellow-700">
                                        Due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl bg-white border border-slate-100 p-8 sm:p-10 text-center shadow-sm">
                            <div class="h-14 w-14 sm:h-16 sm:w-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-[14px] sm:text-base font-semibold text-slate-900">No upcoming vaccinations</h3>
                            <p class="mt-1 text-[12px] sm:text-sm text-slate-500">Upcoming vaccination schedules will appear here once available.</p>
                        </div>

                    @endif

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- RECENT INFANT REGISTRATIONS --}}
            {{-- Same $recentInfants --}}
            {{-- ====================================== --}}

            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-[15px] sm:text-lg font-bold text-slate-900">Recent infant registrations</h2>
                    <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-700">
                        {{ $recentInfants->count() }} recent
                    </span>
                </div>

                @if($recentInfants->count())

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">

                        @foreach($recentInfants as $infant)

                            <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                <div class="flex items-center gap-3 mb-1.5">
                                    <div class="h-9 w-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                        {{ $infant->first_name }} {{ $infant->last_name }}
                                    </p>
                                </div>

                                <p class="text-[12px] sm:text-[13px] text-slate-500">
                                    Mother: {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                </p>

                                <span class="inline-flex mt-1.5 items-center rounded-full bg-green-100 px-3 py-1 text-[11px] sm:text-xs font-semibold text-green-700">
                                    Registered {{ $infant->created_at->format('M d, Y') }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="rounded-2xl bg-white border border-slate-100 p-8 sm:p-10 text-center shadow-sm">
                        <div class="h-14 w-14 sm:h-16 sm:w-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-[14px] sm:text-base font-semibold text-slate-900">No infant records yet</h3>
                        <p class="mt-1 text-[12px] sm:text-sm text-slate-500">Newly registered infant records will appear here once available.</p>
                    </div>

                @endif

            </div>

            {{-- ====================================== --}}
            {{-- FOOTER --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl bg-white border border-slate-100 p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">

                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 rounded-xl sm:rounded-2xl bg-pink-100 flex items-center justify-center text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442a.563.563 0 01.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.386a.562.562 0 01-.84.61L12 18.354l-4.917 2.986a.562.562 0 01-.84-.61l1.285-5.386a.563.563 0 00-.182-.557L3.142 10.385a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[13px] sm:text-base font-semibold text-slate-900">CareCradle Maternal & Infant Health Monitoring System</p>
                        <p class="text-[11px] sm:text-sm text-slate-500 mt-0.5">Rural Health Unit Electronic Maternal and Infant Records Management</p>
                    </div>
                </div>

                <div class="text-[11px] sm:text-sm text-slate-500 flex-shrink-0">
                    <p class="font-medium text-slate-700">Version 1.0</p>
                    <p class="mt-0.5">&copy; 2026 Veritas College of Irosin</p>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>