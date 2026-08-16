<x-app-layout>

    <x-slot name="header">
        <h2 class="text-lg sm:text-xl font-semibold leading-tight text-gray-800">
            Growth Record Details
        </h2>
    </x-slot>

    @php
        $heightInMeters = $growthMonitoring->height ? $growthMonitoring->height / 100 : null;
        $bmi = ($growthMonitoring->weight && $heightInMeters) ? $growthMonitoring->weight / ($heightInMeters ** 2) : null;
    @endphp

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-6xl space-y-6 sm:space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- Section 1 : Hero Header --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-50 via-white to-white shadow-sm">

                <div class="p-5 sm:p-8">

                    <div class="flex flex-col gap-6 sm:gap-8 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Content --}}
                        <div class="flex items-start gap-4 sm:gap-5">

                            <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 sm:h-8 sm:w-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"/>
                                </svg>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-600">
                                    Growth Monitoring
                                </p>

                                <h1 class="mt-1 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                    {{ $growthMonitoring->infant->first_name }} {{ $growthMonitoring->infant->last_name }}
                                </h1>

                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-pink-100 px-3 py-1 text-xs sm:text-sm font-semibold text-pink-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs sm:text-sm font-semibold text-gray-700">
                                        {{ $growthMonitoring->age_in_months }} month(s) old
                                    </span>
                                </div>

                                <p class="mt-4 max-w-2xl text-sm leading-6 sm:leading-7 text-gray-600">
                                    Review infant growth measurements, anthropometric records, and developmental
                                    monitoring information documented during this health assessment.
                                </p>

                            </div>

                        </div>

                        {{-- Infant Information Card --}}
                        <div class="w-full rounded-2xl border border-pink-200 bg-white p-5 sm:p-6 shadow-sm lg:max-w-sm">

                            <div class="mb-4 flex items-center gap-3">

                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-medium uppercase tracking-wide text-pink-600">
                                        Mother
                                    </p>
                                    <p class="truncate text-base sm:text-lg font-semibold text-gray-900">
                                        {{ $growthMonitoring->infant->mother->first_name }} {{ $growthMonitoring->infant->mother->last_name }}
                                    </p>
                                </div>

                            </div>

                            <div class="space-y-3 border-t border-gray-100 pt-4">

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Mother Code</span>
                                    <span class="font-mono text-sm font-semibold text-pink-700">
                                        {{ $growthMonitoring->infant->mother->mother_code }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Weight</span>
                                    <span class="font-semibold text-gray-900">{{ number_format($growthMonitoring->weight, 2) }} kg</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Height</span>
                                    <span class="font-semibold text-gray-900">{{ number_format($growthMonitoring->height, 2) }} cm</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Section 2 : Growth Metrics Overview --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-5">

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Weight</p>
                            <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">{{ number_format($growthMonitoring->weight, 2) }}<span class="text-xs font-medium text-gray-500"> kg</span></p>
                        </div>
                        <div class="flex h-9 w-9 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Height</p>
                            <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">{{ number_format($growthMonitoring->height, 2) }}<span class="text-xs font-medium text-gray-500"> cm</span></p>
                        </div>
                        <div class="flex h-9 w-9 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Head Circ.</p>
                            <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">
                                {{ $growthMonitoring->head_circumference ? number_format($growthMonitoring->head_circumference, 2) : '-' }}<span class="text-xs font-medium text-gray-500"> cm</span>
                            </p>
                        </div>
                        <div class="flex h-9 w-9 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">BMI</p>
                            <p class="mt-2 text-xl sm:text-2xl font-bold text-gray-900">
                                {{ $bmi ? number_format($bmi, 1) : '-' }}
                            </p>
                        </div>
                        <div class="flex h-9 w-9 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Growth Status</p>
                            <p class="mt-2 text-base sm:text-lg font-bold text-gray-400">Not assessed</p>
                        </div>
                        <div class="flex h-9 w-9 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <p class="-mt-3 text-xs text-gray-400">
                BMI shown for reference only. Infant growth is best assessed using WHO weight-for-age and length-for-age charts, not BMI alone.
            </p>

            {{-- ====================================== --}}
            {{-- Section 3 : Growth Record Information --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">

                {{-- Card A : Measurement Details --}}
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:col-span-2">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Measurement Details</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Anthropometric measurements recorded at this visit.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6">

                        <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2">

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Weight</p>
                                <p class="mt-2 text-base sm:text-lg font-semibold text-gray-900">{{ number_format($growthMonitoring->weight, 2) }} kg</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Height</p>
                                <p class="mt-2 text-base sm:text-lg font-semibold text-gray-900">{{ number_format($growthMonitoring->height, 2) }} cm</p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Head Circumference</p>
                                <p class="mt-2 text-base sm:text-lg font-semibold text-gray-900">
                                    {{ $growthMonitoring->head_circumference ? number_format($growthMonitoring->head_circumference, 2).' cm' : '-' }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Measurement Date</p>
                                <p class="mt-2 text-base sm:text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Card C : Patient Information --}}
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Patient Information</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Linked infant and maternal record.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 space-y-4">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Infant Name</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                {{ $growthMonitoring->infant->first_name }} {{ $growthMonitoring->infant->last_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Name</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                {{ $growthMonitoring->infant->mother->first_name }} {{ $growthMonitoring->infant->mother->last_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Code</p>
                            <p class="mt-2 font-mono text-sm sm:text-base font-semibold text-pink-700">
                                {{ $growthMonitoring->infant->mother->mother_code }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Card B : Assessment --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Assessment</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Growth status summary for this visit.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <div class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-gray-200 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-700">Growth status not recorded</p>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                                This system doesn't currently classify growth status. A proper assessment
                                (underweight, normal, overweight, stunted) requires comparing this measurement
                                against WHO weight-for-age and length-for-age reference charts.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Section 4 : Medical Notes --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Medical Notes</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Healthcare provider observations and remarks recorded during this visit.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                        <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                            <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-wide text-pink-600">Remarks</h3>
                        </div>
                        <div class="px-5 py-5 sm:px-6 sm:py-6">
                            <p class="whitespace-pre-line text-sm sm:text-base leading-7 text-gray-700">
                                {{ $growthMonitoring->remarks ?: '-' }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Section 5 : Action Buttons --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-pink-200 bg-pink-50 p-5 sm:p-6">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-pink-700">Growth Record Management</h3>
                        <p class="mt-1 text-xs sm:text-sm text-pink-600">
                            Review this growth monitoring record carefully. You may return to the infant
                            profile, edit the measurements, or permanently delete this record if necessary.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('infants.show', $growthMonitoring->infant) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            Back to Infant
                        </a>

                        <a
                            href="{{ route('growth-monitorings.edit', $growthMonitoring) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>
                            </svg>
                            Edit Record
                        </a>

                        <form action="{{ route('growth-monitorings.destroy', $growthMonitoring) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this growth record?')"
                                class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5"/>
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