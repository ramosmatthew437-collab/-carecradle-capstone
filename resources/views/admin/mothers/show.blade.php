<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Mother Profile
        </h2>
    </x-slot>

    @php
        // Pregnancy Number → ordinal wording (e.g. "3rd pregnancy")
        // Presentation-layer only, no schema change.
        $pregnancyOrdinal = match(true) {
            in_array($mother->pregnancy_number % 100, [11, 12, 13]) => $mother->pregnancy_number . 'th',
            $mother->pregnancy_number % 10 == 1 => $mother->pregnancy_number . 'st',
            $mother->pregnancy_number % 10 == 2 => $mother->pregnancy_number . 'nd',
            $mother->pregnancy_number % 10 == 3 => $mother->pregnancy_number . 'rd',
            default => $mother->pregnancy_number . 'th',
        };

        // EDD countdown / overdue indicator — only meaningful while Pregnant.
        // Non-diagnostic, presentation-layer only, derived from the existing
        // expected_delivery_date column. No schema change.
        $eddLabel = null;
        $eddTheme = 'text-pink-800';

        if ($mother->status === 'Pregnant' && $mother->expected_delivery_date) {
            $edd = \Carbon\Carbon::parse($mother->expected_delivery_date);
            $eddDaysRemaining = today()->diffInDays($edd->copy()->startOfDay(), false);

            if ($eddDaysRemaining < 0) {
                $eddLabel = abs($eddDaysRemaining) . ' ' . \Illuminate\Support\Str::plural('day', abs($eddDaysRemaining)) . ' overdue';
                $eddTheme = 'text-red-700';
            } elseif ($eddDaysRemaining <= 7) {
                $eddLabel = 'Due in ' . $eddDaysRemaining . ' ' . \Illuminate\Support\Str::plural('day', $eddDaysRemaining);
                $eddTheme = 'text-amber-700';
            } else {
                $eddLabel = 'Due in ' . $eddDaysRemaining . ' days';
                $eddTheme = 'text-pink-700';
            }
        }

        // Blood pressure risk color coding — reused for both the Clinical
        // Summary tile and the Prenatal Checkups history below. Non-diagnostic,
        // presentation-layer only, same thresholds already used on the
        // Mother Portal's Prenatal Records page.
        $bpTheme = function ($systolic, $diastolic) {
            if ($systolic >= 140 || $diastolic >= 90) {
                return ['classes' => 'bg-red-100 text-red-700', 'label' => 'High Risk'];
            }

            if ($systolic >= 130 || $diastolic >= 85) {
                return ['classes' => 'bg-amber-100 text-amber-700', 'label' => 'Elevated'];
            }

            return ['classes' => 'bg-emerald-100 text-emerald-700', 'label' => 'Normal'];
        };

        // Latest prenatal visit — drives both the Clinical Summary card
        // and the highlighted "Latest Visit" panel in the Prenatal Checkups
        // section. Computed from the already-loaded $mother->prenatalCheckups
        // collection — no new query.
        $latestVisit = $mother->prenatalCheckups->sortByDesc('visit_date')->first();
        $latestWeight = optional($latestVisit)->weight ?? $mother->weight;

        // Next upcoming appointment — computed from the already-loaded
        // $mother->appointments collection. No new query.
        $nextAppointment = $mother->appointments
            ->filter(function ($appointment) {
                return $appointment->status === 'Scheduled'
                    && \Carbon\Carbon::parse($appointment->appointment_date)->gte(today());
            })
            ->sortBy('appointment_date')
            ->first();
    @endphp

    <div class="py-4 sm:py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- STATISTICS SUMMARY --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-3">

                <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75h18M3 12h18M3 17.25h18"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Prenatal Checkups</p>
                            <p class="mt-0.5 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ $mother->prenatalCheckups->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Appointments</p>
                            <p class="mt-0.5 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ $mother->appointments->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Registered Infants</p>
                            <p class="mt-0.5 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">{{ $mother->infants->count() }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 1. MOTHER INFORMATION CARD --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-pink-100 bg-white shadow-sm">

                <div class="relative overflow-hidden bg-gradient-to-r from-pink-500 to-pink-600 px-5 py-6 sm:px-8 sm:py-8">

                    <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="pointer-events-none absolute -bottom-10 right-20 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 sm:h-16 sm:w-16">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-widest text-pink-100">
                                    Mother Profile
                                </p>
                                <h1 class="mt-1 truncate text-xl font-bold text-white sm:text-2xl">
                                    {{ $mother->first_name }} {{ $mother->last_name }}
                                </h1>
                                <p class="mt-1 font-mono text-xs text-pink-100/90">
                                    {{ $mother->mother_code }}
                                </p>
                            </div>
                        </div>

                        @php
                            // Status badge colors — matches the Mother Registry page exactly
                            // (Pregnant = emerald, Delivered = gray, Referred = amber)
                            $statusClasses = match($mother->status) {
                                'Pregnant' => 'bg-emerald-100 text-emerald-700',
                                'Delivered' => 'bg-gray-100 text-gray-600',
                                'Referred' => 'bg-amber-100 text-amber-700',
                                default => 'bg-blue-100 text-blue-700',
                            };
                        @endphp

                        <span class="inline-flex w-fit items-center rounded-full {{ $statusClasses }} px-4 py-1.5 text-sm font-semibold shadow-sm">
                            {{ $mother->status }}
                        </span>

                    </div>
                </div>

                <div class="grid grid-cols-1 divide-y divide-pink-50 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

                    <div class="p-5">
                        <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M7.5 4.5h9A2.25 2.25 0 0118.75 6.75v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 017.5 4.5Z"/>
                            </svg>
                            Mother Code
                        </p>
                        <p class="mt-2 text-base font-semibold text-gray-900 break-words">{{ $mother->mother_code }}</p>
                    </div>

                    <div class="p-5">
                        <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                            Contact Number
                        </p>
                        <p class="mt-2 text-base font-semibold text-gray-900 break-words">{{ $mother->contact_number }}</p>
                    </div>

                    <div class="p-5">
                        <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                            </svg>
                            Barangay
                        </p>
                        <p class="mt-2 text-base font-semibold text-gray-900 break-words">{{ $mother->barangay }}</p>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- CLINICAL SUMMARY --}}
            {{-- The single "what matters right now" panel — Status, EDD --}}
            {{-- countdown, latest BP, latest weight, latest prenatal visit, --}}
            {{-- and next appointment. All derived from data already loaded --}}
            {{-- above; no new queries. --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border-2 border-pink-200 bg-white shadow-sm">

                <div class="border-b border-pink-100 bg-pink-50/50 px-5 py-4 sm:px-8">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-pink-500"></span>
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">At a Glance</p>
                    </div>
                    <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Clinical Summary</h2>
                    <p class="mt-0.5 text-sm text-gray-500">Key indicators for this mother's current care status.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 p-5 sm:grid-cols-3 sm:gap-4 sm:p-8">

                    {{-- Status --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">Status</p>
                        <p class="mt-0.5 text-sm font-bold {{ match($mother->status) { 'Pregnant' => 'text-emerald-700', 'Delivered' => 'text-gray-600', 'Referred' => 'text-amber-700', default => 'text-blue-700' } }}">
                            {{ $mother->status }}
                        </p>
                    </div>

                    {{-- EDD Countdown --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">EDD</p>
                        <p class="mt-0.5 text-sm font-bold {{ $eddLabel ? $eddTheme : 'text-gray-400' }}">
                            {{ $eddLabel ?? '—' }}
                        </p>
                    </div>

                    {{-- Latest BP --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-100 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">Latest BP</p>
                        @if($latestVisit)
                            @php $latestBp = $bpTheme($latestVisit->systolic_bp, $latestVisit->diastolic_bp); @endphp
                            <p class="mt-0.5 text-sm font-bold text-gray-900">
                                {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                <span class="ml-1 inline-flex rounded-full {{ $latestBp['classes'] }} px-2 py-0.5 text-[10px] font-semibold align-middle">
                                    {{ $latestBp['label'] }}
                                </span>
                            </p>
                        @else
                            <p class="mt-0.5 text-sm font-semibold text-gray-400">No data yet</p>
                        @endif
                    </div>

                    {{-- Latest Weight --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-fuchsia-100 text-fuchsia-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">Latest Weight</p>
                        <p class="mt-0.5 text-sm font-bold text-gray-900">
                            {{ $latestWeight ? number_format($latestWeight, 1) . ' kg' : 'Not recorded' }}
                        </p>
                    </div>

                    {{-- Latest Prenatal Visit --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75h18M3 12h18M3 17.25h18"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">Last Prenatal Visit</p>
                        <p class="mt-0.5 text-sm font-bold text-gray-900">
                            {{ $latestVisit ? \Carbon\Carbon::parse($latestVisit->visit_date)->format('M d, Y') : 'None recorded' }}
                        </p>
                    </div>

                    {{-- Next Appointment --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs font-medium text-gray-500">Next Appointment</p>
                        <p class="mt-0.5 text-sm font-bold text-gray-900">
                            {{ $nextAppointment ? \Carbon\Carbon::parse($nextAppointment->appointment_date)->format('M d, Y') : 'None scheduled' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- QUICK ACTIONS --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                <a href="{{ route('prenatal-checkups.create', $mother->id) }}"
                   class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Add Prenatal Visit
                </a>

                <a href="{{ route('appointments.create', $mother->id) }}"
                   class="flex h-12 w-full items-center justify-center gap-2 rounded-xl border border-pink-200 bg-white px-5 text-sm font-semibold text-pink-700 shadow-sm transition hover:bg-pink-50 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                    </svg>
                    Schedule Appointment
                </a>

            </div>

            {{-- ====================================== --}}
            {{-- 2. PRENATAL CHECKUPS --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-2 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-pink-500"></span>
                            <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Care History</p>
                        </div>
                        <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Prenatal Checkups</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Complete history of prenatal visits.</p>
                    </div>
                    <span class="w-fit rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-semibold text-pink-700">
                        {{ $mother->prenatalCheckups->count() }} {{ Str::plural('visit', $mother->prenatalCheckups->count()) }}
                    </span>
                </div>

                @if($mother->prenatalCheckups->count())

                    {{-- Latest Visit highlight — the most recent record, --}}
                    {{-- surfaced above the full history for quick reference. --}}
                    @php $latestBpHighlight = $bpTheme($latestVisit->systolic_bp, $latestVisit->diastolic_bp); @endphp
                    <div class="mx-5 mt-5 rounded-xl border border-pink-200 bg-pink-50/60 p-4 sm:mx-8 sm:mt-8 sm:p-5">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-wide text-pink-600">Latest Visit</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('F d, Y') }}
                            </p>
                        </div>
                        <div class="mt-3 grid grid-cols-3 gap-3">
                            <div>
                                <p class="text-[11px] text-gray-500">Gestational Age</p>
                                <p class="mt-0.5 text-sm font-bold text-gray-900">{{ $latestVisit->gestational_age_weeks }} wks</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500">Blood Pressure</p>
                                <p class="mt-0.5 text-sm font-bold text-gray-900">
                                    {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                    <span class="ml-1 inline-flex rounded-full {{ $latestBpHighlight['classes'] }} px-2 py-0.5 text-[10px] font-semibold align-middle">
                                        {{ $latestBpHighlight['label'] }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500">Weight</p>
                                <p class="mt-0.5 text-sm font-bold text-gray-900">{{ number_format($latestVisit->weight, 1) }} kg</p>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop / tablet table — full history --}}
                    <div class="hidden md:block md:overflow-x-auto md:mt-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <th class="px-6 py-3 text-left">Visit Date</th>
                                    <th class="px-6 py-3 text-center">Gestational Age</th>
                                    <th class="px-6 py-3 text-center">Blood Pressure</th>
                                    <th class="px-6 py-3 text-center">Weight</th>
                                    <th class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($mother->prenatalCheckups as $visit)
                                    @php $rowBp = $bpTheme($visit->systolic_bp, $visit->diastolic_bp); @endphp
                                    <tr class="transition hover:bg-pink-50/50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">
                                                {{ $visit->gestational_age_weeks }} weeks
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center gap-1 rounded-full {{ $rowBp['classes'] }} px-3 py-1 text-xs font-semibold">
                                                {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }} · {{ $rowBp['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-gray-800">
                                            {{ number_format($visit->weight,1) }} kg
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('prenatal-checkups.show',$visit->id) }}"
                                               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile cards — full history --}}
                    <div class="divide-y divide-gray-100 md:hidden mt-4">
                        @foreach($mother->prenatalCheckups as $visit)
                            @php $rowBpMobile = $bpTheme($visit->systolic_bp, $visit->diastolic_bp); @endphp
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                    </p>
                                    <span class="shrink-0 rounded-full bg-pink-100 px-2.5 py-1 text-xs font-semibold text-pink-700">
                                        {{ $visit->gestational_age_weeks }} wks
                                    </span>
                                </div>

                                <div class="mt-3 grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Blood Pressure</p>
                                        <p class="mt-1 inline-flex rounded-full {{ $rowBpMobile['classes'] }} px-2 py-0.5 text-sm font-semibold">
                                            {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }}
                                        </p>
                                        <p class="mt-1 text-[11px] font-semibold {{ $rowBpMobile['classes'] }} inline-flex rounded-full px-2 py-0.5">
                                            {{ $rowBpMobile['label'] }}
                                        </p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Weight</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-800">
                                            {{ number_format($visit->weight,1) }} kg
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('prenatal-checkups.show',$visit->id) }}"
                                   class="mt-4 flex h-11 w-full items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="px-4 py-8 sm:px-6 sm:py-10">
                        <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.5v9A2.25 2.25 0 0117.25 18.75H6.75A2.25 2.25 0 014.5 16.5v-9A2.25 2.25 0 016.75 5.25h10.5A2.25 2.25 0 0119.5 7.5ZM9 12h6M12 9v6"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">No prenatal records found</h3>
                            <p class="mt-1 max-w-sm text-sm text-gray-500">No prenatal visits have been recorded for this mother yet.</p>
                            <a href="{{ route('prenatal-checkups.create',$mother->id) }}"
                               class="mt-6 flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Add First Prenatal Visit
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ====================================== --}}
            {{-- 3. APPOINTMENTS --}}
            {{-- Compact list — de-emphasized relative to Prenatal Checkups, --}}
            {{-- since clinical trend data (BP, weight) takes priority. --}}
            {{-- Same data, routes, and Today highlight as before. --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-2 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Scheduling</p>
                        </div>
                        <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Appointments</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Upcoming and completed appointments.</p>
                    </div>
                    <span class="w-fit rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-semibold text-pink-700">
                        {{ $mother->appointments->count() }} total
                    </span>
                </div>

                @if($mother->appointments->count())

                    @php
                        $apptStatusClasses = fn($status) => match($status) {
                            'Scheduled' => 'bg-amber-100 text-amber-700',
                            'Completed' => 'bg-emerald-100 text-emerald-700',
                            'Cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <div class="divide-y divide-gray-100">
                        @foreach($mother->appointments as $appointment)
                            @php
                                $isToday = \Carbon\Carbon::parse($appointment->appointment_date)->isToday();
                            @endphp
                            <div class="flex flex-wrap items-center justify-between gap-3 p-4 sm:px-8 {{ $isToday ? 'bg-pink-50/50' : '' }} transition hover:bg-gray-50">

                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </p>
                                            @if($isToday)
                                                <span class="inline-flex items-center rounded-full bg-pink-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-white">
                                                    Today
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                            &middot; {{ $appointment->appointment_type }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="rounded-full {{ $apptStatusClasses($appointment->status) }} px-3 py-1 text-xs font-semibold">
                                        {{ $appointment->status }}
                                    </span>
                                    <a href="{{ route('appointments.show', $appointment->id) }}"
                                       class="text-xs font-semibold text-gray-500 underline-offset-2 transition hover:text-pink-700 hover:underline">
                                        View
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="px-4 py-8 sm:px-6 sm:py-10">
                        <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">No appointments found</h3>
                            <p class="mt-1 max-w-sm text-sm text-gray-500">There are currently no scheduled appointments for this mother.</p>
                            <a href="{{ route('appointments.create',$mother->id) }}"
                               class="mt-6 flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Schedule Appointment
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ====================================== --}}
            {{-- PERSONAL INFORMATION --}}
            {{-- Grouped section 1 of 2 — static/biographical facts. --}}
            {{-- Contact Number intentionally excluded: already shown --}}
            {{-- in the Mother Information card above. --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">

                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">Patient Record</p>
                </div>
                <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Personal Information</h2>
                <p class="mt-0.5 text-sm text-gray-500">Biographical and contact details on file.</p>

                <dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 break-words">
                            {{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Birth Date</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($mother->birth_date)->format('F d, Y') }}
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Age</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                        </dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Civil Status</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mother->civil_status }}</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Occupation</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mother->occupation ?: '-' }}</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4 sm:col-span-2 lg:col-span-1">
                        <dt class="text-xs font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900 break-words">{{ $mother->address }}</dd>
                    </div>

                </dl>
            </div>

            {{-- ====================================== --}}
            {{-- PREGNANCY INFORMATION --}}
            {{-- Grouped section 2 of 2 — obstetric/clinical reference facts. --}}
            {{-- EDD shown here as the raw calendar date only; the countdown --}}
            {{-- framing lives in the Clinical Summary card above, to avoid --}}
            {{-- stating the same fact twice in two different formats. --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">

                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-pink-500"></span>
                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Patient Record</p>
                </div>
                <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Pregnancy Information</h2>
                <p class="mt-0.5 text-sm text-gray-500">Obstetric details on file for this pregnancy.</p>

                <dl class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Blood Type</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $mother->blood_type }}</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Pregnancy Number</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $pregnancyOrdinal }} pregnancy</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Height (Registration)</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ number_format($mother->height, 2) }} cm</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Weight (Registration)</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ number_format($mother->weight, 2) }} kg</dd>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-xs font-medium text-gray-500">Last Menstrual Period</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($mother->last_menstrual_period)->format('F d, Y') }}
                        </dd>
                    </div>

                    <div class="rounded-xl border border-pink-100 bg-pink-50 p-4">
                        <dt class="text-xs font-medium text-pink-600">Expected Delivery Date</dt>
                        <dd class="mt-1 text-sm font-semibold text-pink-800">
                            {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('F d, Y') }}
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- ====================================== --}}
            {{-- 4. INFANT RECORDS --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Newborn Records</p>
                        </div>
                        <h2 class="mt-1 text-base sm:text-lg font-bold text-gray-900">Infant Records</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Registered infants associated with this mother.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="rounded-lg bg-pink-50 px-3 py-1.5 text-xs font-semibold text-pink-700">
                            {{ $mother->infants->count() }} {{ Str::plural('infant', $mother->infants->count()) }}
                        </span>
                        <a href="{{ route('infants.create', $mother->id) }}"
                           class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-pink-600 px-3.5 text-xs font-semibold text-white shadow-sm transition hover:bg-pink-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Register Infant
                        </a>
                    </div>
                </div>

                @if($mother->infants->count())

                    <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 sm:p-8">
                        @foreach($mother->infants as $infant)
                            <div class="flex flex-col rounded-2xl border border-gray-200 p-5 transition hover:border-pink-200 hover:shadow-md">

                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-900">
                                            {{ $infant->first_name }} {{ $infant->middle_name }} {{ $infant->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">Infant Record</p>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-3">
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Gender</p>
                                        <p class="mt-1 text-sm font-semibold text-blue-700">{{ $infant->sex }}</p>
                                    </div>
                                    <div class="rounded-xl bg-gray-50 p-3">
                                        <p class="text-xs text-gray-500">Birth Date</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        {{ $infant->birth_status }}
                                    </span>
                                </div>

                                <a href="{{ route('infants.show', $infant->id) }}"
                                   class="mt-4 flex h-11 w-full items-center justify-center rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">
                                    View Details
                                </a>

                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="px-4 py-8 sm:px-6 sm:py-10">
                        <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base font-bold text-gray-900">No infant records found</h3>
                            <p class="mt-1 max-w-sm text-sm text-gray-500">There are currently no registered infant records associated with this mother.</p>
                            <a href="{{ route('infants.create', $mother->id) }}"
                               class="mt-6 flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Register First Infant
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-app-layout>