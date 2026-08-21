<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            CareCradle Administrator Dashboard
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">

            {{-- ====================================== --}}
            {{-- 1. Header --}}
            {{-- ====================================== --}}
            <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-6 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v12.75a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75V4.5a.75.75 0 01.75-.75Zm5.25 5.25h4.5m-4.5 3h4.5m-4.5 3h2.25" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">
                            Administrator Control Center
                        </p>
                        <h1 class="mt-0.5 text-lg sm:text-xl font-bold text-gray-900">
                            Welcome back, {{ Auth::user()->name }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Centralized management of maternal and infant healthcare services.
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2.5 self-start rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 sm:self-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ now()->format('l, F d, Y') }}</span>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 2. System Overview --}}
            {{-- ====================================== --}}
            <div>

                <div class="mb-4 sm:mb-5">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">System Overview</h2>
                    <p class="mt-1 text-sm text-gray-500">Real-time summary of CareCradle records and healthcare services.</p>
                </div>

                {{-- Primary row — most important statistics, visually dominant --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                                </svg>
                            </div>
                            <span class="rounded-full bg-pink-50 px-2 py-0.5 text-[11px] font-semibold text-pink-600">Mothers</span>
                        </div>
                        <h3 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $mothers }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Registered Mothers</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                </svg>
                            </div>
                            <span class="rounded-full bg-cyan-50 px-2 py-0.5 text-[11px] font-semibold text-cyan-600">Infants</span>
                        </div>
                        <h3 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $infants }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Registered Infants</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                                </svg>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-600">Midwives</span>
                        </div>
                        <h3 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $midwives }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Registered Midwives</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                                </svg>
                            </div>
                            <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-600">Appointments</span>
                        </div>
                        <h3 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $appointments }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Upcoming Appointments</p>
                    </div>

                </div>

                {{-- Secondary row --}}
                <div class="mt-3 sm:mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-xl font-bold text-gray-900">{{ $vaccinations }}</h3>
                                <p class="text-xs text-gray-500">Vaccinations</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 3. Quick Actions --}}
            {{-- ====================================== --}}
            <div>

                <div class="mb-4 sm:mb-5">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Quick Actions</h2>
                    <p class="mt-1 text-sm text-gray-500">Manage users and administrative reports for the CareCradle EMR.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                    {{-- Midwife Management --}}
                    <a href="{{ route('midwives.index') }}"
                       class="group flex items-start justify-between gap-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:border-pink-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600 transition group-hover:bg-pink-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Midwife Management</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500">
                                    Manage registered midwives and their access to the CareCradle system.
                                </p>
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 flex-shrink-0 text-gray-300 transition group-hover:translate-x-1 group-hover:text-pink-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>

                    </a>

                    {{-- Reports --}}
                    <a href="{{ route('reports.index') }}"
                       class="group flex items-start justify-between gap-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:border-emerald-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4V7m5 12H4.5A2.25 2.25 0 012.25 16.75V4.5A2.25 2.25 0 014.5 2.25h15A2.25 2.25 0 0121.75 4.5v12.25A2.25 2.25 0 0119.5 19Z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Reports</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-500">
                                    View and generate maternal, infant, appointment, and vaccination reports.
                                </p>
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 flex-shrink-0 text-gray-300 transition group-hover:translate-x-1 group-hover:text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>

                    </a>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- 4. System Insights --}}
            {{-- (the three tables the controller already provides, --}}
            {{-- presented as this dashboard's real "insights" section) --}}
            {{-- ====================================== --}}
            <div class="space-y-8 sm:space-y-10">

                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">System Insights</h2>
                    <p class="mt-1 text-sm text-gray-500">Live operational detail behind the summary statistics above.</p>
                </div>

                {{-- Today's Appointments --}}
                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Today's Appointments</h3>
                        <span class="text-xs text-gray-400">{{ $todayAppointments->count() }} today</span>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        @if($todayAppointments->count())

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Time</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Mother</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Type</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($todayAppointments as $appointment)

                                            @php
                                                $statusClasses = match($appointment->status) {
                                                    'Scheduled' => 'bg-blue-50 text-blue-700',
                                                    'Completed' => 'bg-emerald-50 text-emerald-700',
                                                    'Cancelled' => 'bg-red-50 text-red-700',
                                                    'Missed' => 'bg-amber-50 text-amber-700',
                                                    default => 'bg-gray-100 text-gray-700',
                                                };
                                            @endphp

                                            <tr class="transition hover:bg-gray-50">
                                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                                        {{ $appointment->appointment_type }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                                        {{ $appointment->status }}
                                                    </span>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else

                            <div class="flex flex-col items-center justify-center px-8 py-12 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                                    </svg>
                                </div>
                                <h4 class="mt-4 text-sm font-semibold text-gray-900">No Appointments Today</h4>
                                <p class="mt-1 max-w-sm text-sm text-gray-500">There are no scheduled maternal appointments for today.</p>
                            </div>

                        @endif

                    </div>
                </div>

                {{-- Upcoming Vaccinations --}}
                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Upcoming Vaccinations</h3>
                        <span class="text-xs text-gray-400">{{ $upcomingVaccinations->count() }} upcoming</span>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        @if($upcomingVaccinations->count())

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Infant</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Vaccine</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Next Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($upcomingVaccinations as $vaccination)
                                            <tr class="transition hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $vaccination->vaccine_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else

                            <div class="flex flex-col items-center justify-center px-8 py-12 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>
                                <h4 class="mt-4 text-sm font-semibold text-gray-900">No Upcoming Vaccinations</h4>
                                <p class="mt-1 max-w-sm text-sm text-gray-500">
                                    Upcoming infant immunization schedules will appear here once vaccination records are available.
                                </p>
                            </div>

                        @endif

                    </div>
                </div>

                {{-- Recent Infant Registrations --}}
                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900">Recent Infant Registrations</h3>
                        <span class="text-xs text-gray-400">{{ $recentInfants->count() }} recent</span>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        @if($recentInfants->count())

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Infant</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Mother</th>
                                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Registration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($recentInfants as $infant)
                                            <tr class="transition hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    {{ $infant->first_name }} {{ $infant->last_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $infant->created_at->format('M d, Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else

                            <div class="flex flex-col items-center justify-center px-8 py-12 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                    </svg>
                                </div>
                                <h4 class="mt-4 text-sm font-semibold text-gray-900">No Infant Records Yet</h4>
                                <p class="mt-1 max-w-sm text-sm text-gray-500">
                                    Newly registered infant records will appear here once patients are enrolled in the CareCradle system.
                                </p>
                            </div>

                        @endif

                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 5. System Information --}}
            {{-- ====================================== --}}
            <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-6">

                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">CareCradle Maternal &amp; Infant Health Monitoring System</p>
                        <p class="mt-0.5 text-xs text-gray-500">Rural Health Unit Electronic Maternal and Infant Records Management</p>
                    </div>
                </div>

                <div class="text-xs text-gray-400 sm:text-right">
                    <p class="font-medium text-gray-500">Version 1.0 · Administrator Dashboard</p>
                    <p class="mt-0.5">© {{ date('Y') }} Irosin Rural Health Unit. All Rights Reserved.</p>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>