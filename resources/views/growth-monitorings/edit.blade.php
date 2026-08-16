<x-app-layout>

    <x-slot name="header">
        <h2 class="text-lg sm:text-xl font-semibold leading-tight text-gray-800">
            Edit Growth Record
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="mx-auto max-w-6xl space-y-6 sm:space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- Section 1 : Hero Header --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-14 right-24 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative p-5 sm:p-8">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Content --}}
                        <div class="flex items-start gap-4 sm:gap-5">

                            <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-7 w-7 sm:h-8 sm:w-8 text-white">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                        Recorded {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('M d, Y') }}
                                    </span>
                                </div>

                                <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                    Edit Growth Record
                                </h1>

                                <p class="mt-2 max-w-2xl text-sm leading-6 sm:leading-7 text-pink-100/90">
                                    Update the infant's anthropometric measurements and clinical
                                    observations to maintain an accurate electronic growth
                                    monitoring record within CareCradle.
                                </p>

                            </div>

                        </div>

                        {{-- Infant Information Card --}}
                        <div class="w-full rounded-2xl border border-white/20 bg-white/10 p-5 sm:p-6 backdrop-blur-sm lg:max-w-sm">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                        Infant
                                    </p>
                                    <p class="truncate text-base sm:text-lg font-semibold text-white">
                                        {{ $growthMonitoring->infant->first_name }}
                                        {{ $growthMonitoring->infant->last_name }}
                                    </p>
                                </div>

                            </div>

                            <div class="mt-4 border-t border-white/20 pt-4">
                                <p class="flex items-center gap-2 text-xs sm:text-sm text-pink-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                                    </svg>
                                    Mother: <span class="font-semibold text-white">{{ $growthMonitoring->infant->mother->first_name }} {{ $growthMonitoring->infant->mother->last_name }}</span>
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Section 2 : Current Growth Summary --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-4">

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Weight</p>
                            <h2 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                {{ number_format($growthMonitoring->weight, 2) }}<span class="text-sm font-medium text-gray-500"> kg</span>
                            </h2>
                        </div>
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-cyan-100 text-cyan-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Height / Length</p>
                            <h2 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                {{ number_format($growthMonitoring->height, 2) }}<span class="text-sm font-medium text-gray-500"> cm</span>
                            </h2>
                        </div>
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Head Circumference</p>
                            <h2 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                {{ $growthMonitoring->head_circumference ? number_format($growthMonitoring->head_circumference, 2) : '-' }}<span class="text-sm font-medium text-gray-500"> cm</span>
                            </h2>
                        </div>
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Age</p>
                            <h2 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                {{ $growthMonitoring->age_in_months }}<span class="text-sm font-medium text-gray-500"> mo</span>
                            </h2>
                        </div>
                        <div class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Section : Validation Error Card --}}
            {{-- ====================================== --}}

            @if ($errors->any())

                <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">

                    <div class="border-b border-red-200 px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-red-700">
                                    Validation Errors
                                </h2>
                                <p class="mt-1 text-xs sm:text-sm text-red-600">
                                    Please correct the following fields before updating this growth record.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="px-5 py-5 sm:px-6">

                        <ul class="space-y-3">

                            @foreach ($errors->all() as $error)

                                <li class="flex items-start gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0"/>
                                    </svg>
                                    <span>{{ $error }}</span>
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif

            <form action="{{ route('growth-monitorings.update', $growthMonitoring) }}" method="POST" class="space-y-6 sm:space-y-8">

                @csrf
                @method('PUT')

                {{-- ====================================== --}}
                {{-- CARD C : Patient Information (Read Only) --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Patient Information</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Read-only reference for the infant this record belongs to.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6">

                        <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2 xl:grid-cols-4">

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Infant Name</p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                    {{ $growthMonitoring->infant->first_name }} {{ $growthMonitoring->infant->last_name }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Infant Code</p>
                                <p class="mt-2 font-mono text-sm sm:text-base font-semibold text-gray-900">
                                    {{ $growthMonitoring->infant->infant_code ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Name</p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                    {{ $growthMonitoring->infant->mother->first_name }} {{ $growthMonitoring->infant->mother->last_name }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Birth Date</p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($growthMonitoring->infant->birth_date)->format('F d, Y') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- CARD A : Measurement Information --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Measurement Information</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Update the infant's anthropometric measurements recorded during the growth monitoring visit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8">

                        <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                            {{-- Date Measured --}}
                            <div>
                                <label for="date_measured" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Date Measured <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="date_measured"
                                        type="date"
                                        name="date_measured"
                                        value="{{ old('date_measured', $growthMonitoring->date_measured) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                </div>
                            </div>

                            {{-- Age --}}
                            <div>
                                <label for="age_in_months" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Age (Months) <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="age_in_months"
                                    type="number"
                                    name="age_in_months"
                                    value="{{ old('age_in_months', $growthMonitoring->age_in_months) }}"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                            {{-- Weight --}}
                            <div>
                                <label for="weight" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Weight (kg) <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="weight"
                                    type="number"
                                    step="0.01"
                                    name="weight"
                                    value="{{ old('weight', $growthMonitoring->weight) }}"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                            {{-- Height --}}
                            <div>
                                <label for="height" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Height / Length (cm) <span class="text-red-500">*</span>
                                </label>

                                <input
                                    id="height"
                                    type="number"
                                    step="0.01"
                                    name="height"
                                    value="{{ old('height', $growthMonitoring->height) }}"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                            {{-- Head Circumference --}}
                            <div class="md:col-span-2">
                                <label for="head_circumference" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Head Circumference (cm)
                                </label>

                                <input
                                    id="head_circumference"
                                    type="number"
                                    step="0.01"
                                    name="head_circumference"
                                    value="{{ old('head_circumference', $growthMonitoring->head_circumference) }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 4 : Clinical Notes --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Clinical Remarks</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Update the healthcare provider's observations, findings, recommendations,
                                    or additional notes for this growth monitoring record.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8">

                        <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                            Remarks
                        </label>

                        <textarea
                            id="remarks"
                            name="remarks"
                            rows="6"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-4 text-sm leading-7 text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('remarks', $growthMonitoring->remarks) }}</textarea>

                        <p class="mt-3 text-xs sm:text-sm text-gray-500">
                            Document nutritional status, developmental observations, counseling provided,
                            referrals, or any other clinically relevant information regarding the infant's
                            growth assessment.
                        </p>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 5 : Action Buttons --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-pink-200 bg-pink-50 shadow-sm">

                    <div class="p-5 sm:p-6">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            {{-- Left Content --}}
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-pink-700">
                                    Update Growth Record
                                </h3>
                                <p class="mt-1 text-xs sm:text-sm text-pink-600">
                                    Review all growth measurements and clinical remarks before saving.
                                    Updating this record will immediately reflect the latest growth
                                    monitoring information in the infant's CareCradle Electronic Medical Record.
                                </p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col gap-3 sm:flex-row">

                                {{-- Back to Records --}}
                                <a
                                    href="{{ route('infants.show', $growthMonitoring->infant) }}"
                                    class="inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-13.5 5.25L3.75 12l6-5.25"/>
                                    </svg>
                                    Back to Records
                                </a>

                                {{-- Cancel --}}
                                <a
                                    href="{{ route('growth-monitorings.show', $growthMonitoring) }}"
                                    class="inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                    </svg>
                                    Cancel
                                </a>

                                {{-- Update --}}
                                <button
                                    type="submit"
                                    class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>
                                    </svg>
                                    Update Growth Record
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>