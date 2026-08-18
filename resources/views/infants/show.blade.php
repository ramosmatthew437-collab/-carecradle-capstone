<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Infant Profile
        </h2>
    </x-slot>

    @php
        $totalVaccinations = $infant->vaccinations->count();
        $totalGrowthRecords = $infant->growthMonitorings->count();

        $upcomingVaccinations = $infant->vaccinations->filter(function ($v) {
            return $v->next_due_date && \Carbon\Carbon::parse($v->next_due_date)->isFuture();
        })->count();

        $missedVaccinations = $infant->vaccinations->filter(function ($v) {
            return $v->next_due_date && \Carbon\Carbon::parse($v->next_due_date)->isPast();
        })->count();

        $latestGrowth = $infant->growthMonitorings->sortByDesc('date_measured')->first();

        $ageDiff = \Carbon\Carbon::parse($infant->birth_date)->diff(now());
    @endphp

    <div class="py-4 sm:py-8">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- SECTION 1 : HERO PROFILE CARD --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-cyan-600 via-cyan-600 to-blue-600 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-14 right-24 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative flex flex-col gap-6 p-5 sm:p-8 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-start gap-4 sm:gap-5">

                        <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-7 w-7 sm:h-8 sm:w-8 text-white"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z" />

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 3.75v1.5" />

                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-cyan-100">
                                Infant Health Record
                            </p>

                            <h1 class="mt-1 truncate text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                {{ $infant->first_name }}
                                {{ $infant->middle_name }}
                                {{ $infant->last_name }}
                            </h1>

                            <div class="mt-3 flex flex-wrap items-center gap-2">

                                <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs sm:text-sm font-semibold text-white">
                                    {{ $infant->sex }}
                                </span>

                                @if($infant->birth_status == 'Alive')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs sm:text-sm font-semibold text-white">
                                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                                        Alive
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs sm:text-sm font-semibold text-white">
                                        <span class="h-2 w-2 rounded-full bg-red-300"></span>
                                        Stillbirth
                                    </span>
                                @endif

                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-cyan-50">

                                <span class="inline-flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($infant->birth_date)->format('F d, Y') }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                    </svg>
                                    @if($ageDiff->y > 0)
                                        {{ $ageDiff->y }} {{ Str::plural('year', $ageDiff->y) }} {{ $ageDiff->m }} {{ Str::plural('month', $ageDiff->m) }} old
                                    @else
                                        {{ $ageDiff->m }} {{ Str::plural('month', $ageDiff->m) }} {{ $ageDiff->d }} {{ Str::plural('day', $ageDiff->d) }} old
                                    @endif
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"/>
                                    </svg>
                                    {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 2 : STATISTICS CARDS --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Vaccinations</p>
                            <h2 class="mt-2 sm:mt-3 text-2xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $totalVaccinations }}</h2>
                            <p class="mt-1 hidden sm:block text-sm text-gray-500">Doses received</p>
                        </div>
                        <div class="flex h-10 w-10 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Growth Records</p>
                            <h2 class="mt-2 sm:mt-3 text-2xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $totalGrowthRecords }}</h2>
                            <p class="mt-1 hidden sm:block text-sm text-gray-500">Recorded checkups</p>
                        </div>
                        <div class="flex h-10 w-10 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-cyan-100 text-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Upcoming</p>
                            <h2 class="mt-2 sm:mt-3 text-2xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $upcomingVaccinations }}</h2>
                            <p class="mt-1 hidden sm:block text-sm text-gray-500">Vaccinations due</p>
                        </div>
                        <div class="flex h-10 w-10 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Missed</p>
                            <h2 class="mt-2 sm:mt-3 text-2xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $missedVaccinations }}</h2>
                            <p class="mt-1 hidden sm:block text-sm text-gray-500">Past due date</p>
                        </div>
                        <div class="flex h-10 w-10 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 3 : INFANT INFORMATION --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-cyan-100 text-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3-6.72A9 9 0 1 0 3 12a9.094 9.094 0 0 0 3 6.72M9 10.5h6M9 13.5h3"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Infant Information</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Demographic and birth details recorded during infant registration.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-6">

                    <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2 xl:grid-cols-3">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Full Name</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                {{ $infant->first_name }} {{ $infant->middle_name }} {{ $infant->last_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Gender</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">{{ $infant->sex }}</p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Date of Birth</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($infant->birth_date)->format('F d, Y') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Age</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                @if($ageDiff->y > 0)
                                    {{ $ageDiff->y }} {{ Str::plural('yr', $ageDiff->y) }}, {{ $ageDiff->m }} {{ Str::plural('mo', $ageDiff->m) }}
                                @else
                                    {{ $ageDiff->m }} {{ Str::plural('mo', $ageDiff->m) }}, {{ $ageDiff->d }} {{ Str::plural('day', $ageDiff->d) }}
                                @endif
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Birth Weight</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ number_format($infant->birth_weight, 2) }} kg
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Birth Height</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ number_format($infant->birth_length, 2) }} cm
                            </p>
                        </div>

                        

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Name</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Code</p>
                            <p class="mt-2 font-mono text-sm sm:text-base font-semibold text-cyan-700">
                                {{ $infant->mother->mother_code }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5 sm:col-span-2 xl:col-span-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Address</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                {{ $infant->mother->address ?? '-' }}
                            </p>
                        </div>

                    </div>

                    {{-- Remarks --}}
                    <div class="mt-5 sm:mt-6 rounded-xl border border-gray-200 bg-gray-50 p-5 sm:p-6">
                        <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-wide text-gray-500">Clinical Remarks</h3>
                        <div class="mt-3 rounded-xl border border-gray-200 bg-white p-4 text-sm leading-7 text-gray-700">
                            {{ $infant->remarks ?: '-' }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 4 : GROWTH MONITORING --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6 md:flex-row md:items-center md:justify-between">

                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Growth Monitoring</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Track the infant's physical growth through regular health assessments.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('growth-monitorings.create', $infant) }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 hover:shadow-md active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add Growth Record
                    </a>

                </div>

                <div class="p-5 sm:p-6">

                    @if($latestGrowth)

                        <p class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400">Latest Measurement</p>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">

                            <div class="rounded-2xl border border-cyan-100 bg-cyan-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-cyan-600">Weight</p>
                                <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">{{ number_format($latestGrowth->weight, 2) }}<span class="text-sm font-medium text-gray-500"> kg</span></p>
                            </div>

                            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Height</p>
                                <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">{{ number_format($latestGrowth->height, 2) }}<span class="text-sm font-medium text-gray-500"> cm</span></p>
                            </div>

                            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Head Circumference</p>
                                <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">
                                    {{ $latestGrowth->head_circumference ? number_format($latestGrowth->head_circumference, 2) : '-' }}<span class="text-sm font-medium text-gray-500"> cm</span>
                                </p>
                            </div>

                            <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Measured On</p>
                                <p class="mt-2 text-base sm:text-lg font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($latestGrowth->date_measured)->format('M d, Y') }}
                                </p>
                            </div>

                        </div>

                    @endif

                    @if ($infant->growthMonitorings->isEmpty())

                        <div class="px-2 py-10 sm:py-12 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18"/>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-base sm:text-lg font-semibold text-gray-900">No Growth Records</h3>
                            <p class="mt-2 text-sm text-gray-500">No growth monitoring records have been recorded yet.</p>
                        </div>

                    @else

                        <div class="mt-6 -mx-5 sm:mx-0 overflow-x-auto rounded-xl border border-gray-200">

                            <table class="min-w-full">

                                <thead class="bg-gray-50">
                                    <tr class="border-b border-gray-200">
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Date Measured</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Age</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Weight</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Height</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Head Circumference</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white">

                                    @foreach($infant->growthMonitorings as $growth)
                                        <tr class="transition hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ \Carbon\Carbon::parse($growth->date_measured)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $growth->age_in_months }} month(s)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ number_format($growth->weight, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ number_format($growth->height, 2) }} cm
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $growth->head_circumference ? number_format($growth->head_circumference, 2).' cm' : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('growth-monitorings.show', $growth) }}"
                                                   class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-cyan-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.01 9.964 7.178a1 1 0 010 .644C20.577 16.49 16.639 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                                    </svg>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 5 : VACCINATION TIMELINE --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6 md:flex-row md:items-center md:justify-between">

                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl sm:rounded-2xl bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.5 16.5 4.5m0 0L9 12m7.5-7.5 3 3M9 12l-4.5 4.5M6 18l-1.5 1.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Vaccination Timeline</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Immunization history and scheduled vaccine doses for the infant.
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('vaccinations.create', $infant) }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Add Vaccination
                    </a>

                </div>

                @if ($infant->vaccinations->isEmpty())

                    <div class="px-6 py-10 sm:py-12 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.5 16.5 4.5m0 0L9 12m7.5-7.5 3 3M9 12l-4.5 4.5M6 18l-1.5 1.5"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-base sm:text-lg font-semibold text-gray-900">No Vaccination Records</h3>
                        <p class="mt-2 text-sm text-gray-500">No vaccination records have been added for this infant.</p>
                    </div>

                @else

                    <div class="p-5 sm:p-8">

                        <div class="relative space-y-6 sm:space-y-8 pl-8 sm:pl-10">

                            <div class="absolute bottom-2 left-[9px] top-2 w-px bg-gray-200 sm:left-[11px]"></div>

                            @foreach($infant->vaccinations as $vaccination)

                                @php
                                    $isPastDue = $vaccination->next_due_date && \Carbon\Carbon::parse($vaccination->next_due_date)->isPast();
                                    $isUpcoming = $vaccination->next_due_date && \Carbon\Carbon::parse($vaccination->next_due_date)->isFuture();
                                @endphp

                                <div class="relative">

                                    <span class="absolute -left-8 top-1 flex h-5 w-5 sm:-left-10 sm:h-6 sm:w-6 items-center justify-center rounded-full border-4 border-white bg-blue-500 shadow"></span>

                                    <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 sm:p-5 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="min-w-0">
                                            <p class="text-sm sm:text-base font-semibold text-gray-900">
                                                {{ $vaccination->vaccine_name }}
                                                <span class="ml-1 text-xs font-medium text-gray-500">· Dose {{ $vaccination->dose }}</span>
                                            </p>

                                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs sm:text-sm text-gray-600">
                                                <span class="inline-flex items-center gap-1.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                                    </svg>
                                                    Given {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}
                                                </span>

                                                @if($vaccination->next_due_date)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 font-semibold {{ $isPastDue ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                                        {{ $isPastDue ? 'Past due' : 'Next due' }}: {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('vaccinations.show', $vaccination) }}"
                                           class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 text-sm font-medium text-white transition hover:bg-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.01 9.964 7.178a1 1 0 010 .644C20.577 16.49 16.639 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                            </svg>
                                            View
                                        </a>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 6 : ACTION BUTTONS --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 px-5 py-6 sm:px-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">Record Management</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">
                            Manage this infant's medical profile and return to the linked maternal record.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-row sm:flex-wrap">

                        {{-- Add Growth Record --}}
                        <a href="{{ route('growth-monitorings.create', $infant) }}"
                           class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 sm:px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 hover:shadow-md active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Growth Record
                        </a>

                        {{-- Add Vaccination Record --}}
                        <a href="{{ route('vaccinations.create', $infant) }}"
                           class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 sm:px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Vaccination
                        </a>

                        {{-- Edit Infant --}}
                        <a href="{{ route('infants.edit', $infant->id) }}"
                           class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 sm:px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 hover:shadow-md active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 1 1 3.182 3.182L7.5 20.25 3 21l.75-4.5L16.862 4.487Z"/>
                            </svg>
                            Edit
                        </a>

                        {{-- Back to Mother --}}
                        <a href="{{ route('mothers.show', $infant->mother->id) }}"
                           class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 sm:px-5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow-md active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                            Mother
                        </a>

                        {{-- Delete Infant --}}
                        <form action="{{ route('infants.destroy', $infant->id) }}" method="POST" class="col-span-2 sm:col-span-1">
                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this infant record?')"
                                class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 sm:px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 hover:shadow-md active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12M9.75 7.5V6a2.25 2.25 0 0 1 2.25-2.25h0A2.25 2.25 0 0 1 14.25 6v1.5m2.25 0v10.125A2.625 2.625 0 0 1 13.875 20.25h-3.75A2.625 2.625 0 0 1 7.5 17.625V7.5m3 3v5.25m3-5.25v5.25"/>
                                </svg>
                                Delete
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>