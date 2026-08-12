<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mother Profile
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

<!-- ====================================== -->
<!-- PROFILE HEADER -->
<!-- ====================================== -->

<div class="mb-10 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

    <div class="bg-gradient-to-r from-pink-600 to-pink-700 p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-5">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm ring-1 ring-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-pink-100">
                        Mother Profile
                    </p>

                    <h1 class="mt-1 text-3xl font-bold tracking-tight text-white">
                        {{ $mother->first_name }} {{ $mother->last_name }}
                    </h1>

                    <div class="mt-3 inline-flex items-center rounded-xl bg-white/15 px-4 py-2 text-sm font-medium text-pink-50 backdrop-blur-sm ring-1 ring-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M7.5 4.5h9A2.25 2.25 0 0118.75 6.75v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75A2.25 2.25 0 017.5 4.5Z"/>
                        </svg>
                        Mother ID: {{ $mother->mother_code }}
                    </div>
                </div>

            </div>

            <div class="lg:text-right">

                @php
                    $statusClasses = match($mother->status) {
                        'Pregnant' => 'bg-blue-100 text-blue-700',
                        'Delivered' => 'bg-green-100 text-green-700',
                        'Referred' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-pink-100">
                    Current Status
                </p>

                <span class="inline-flex items-center rounded-full {{ $statusClasses }} px-5 py-2 text-sm font-semibold shadow-sm">
                    {{ $mother->status }}
                </span>

            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 divide-y divide-gray-200 bg-gray-50 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

        <div class="flex items-center gap-4 p-6">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75h18M3 12h18M3 17.25h18"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500">Prenatal Visits</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $mother->prenatalCheckups->count() }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-4 p-6">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.75V18a6 6 0 00-12 0v.75M12 12a3 3 0 100-6 3 3 0 000 6Z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500">Registered Infants</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $mother->infants->count() }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-4 p-6">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 2.25v2.25M15.75 2.25v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                </svg>
            </div>

            <div>
                <p class="text-sm text-gray-500">Appointments</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $mother->appointments->count() }}
                </p>
            </div>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- PERSONAL INFORMATION --}}
{{-- ====================================== --}}

<div class="mt-12">

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">

        <!-- Section Header -->
        <div class="mb-8">

            <h2 class="text-2xl font-bold text-gray-800">
                👤 Personal Information
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Basic personal and contact information of the registered mother.
            </p>

        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Full Name -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975M15 9a3 3 0 11-6 0 3 3 0 016 0Z"/>
                    </svg>

                    Full Name

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ $mother->first_name }}
                    {{ $mother->middle_name }}
                    {{ $mother->last_name }}
                </p>

            </div>

            <!-- Birth Date -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 9.75h18M4.5 5.25h15A1.5 1.5 0 0121 6.75v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12A1.5 1.5 0 014.5 5.25Z"/>
                    </svg>

                    Birth Date

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($mother->birth_date)->format('F d, Y') }}
                </p>

            </div>

            <!-- Age -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-600">
                    🎂 Age
                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                </p>

            </div>

            <!-- Contact Number -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                    </svg>

                    Contact Number

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ $mother->contact_number }}
                </p>

            </div>

            <!-- Barangay -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                    </svg>

                    Barangay

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ $mother->barangay }}
                </p>

            </div>

            <!-- Blood Type -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3s6 6.5 6 10a6 6 0 11-12 0c0-3.5 6-10 6-10z"/>
                    </svg>

                    Blood Type

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ $mother->blood_type }}
                </p>

            </div>

            <!-- Address -->
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 md:col-span-2 transition duration-200 hover:shadow-md">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12 12 3l9.75 9M4.5 10.5v9.75h15V10.5"/>
                    </svg>

                    Address

                </p>

                <p class="mt-3 text-lg font-semibold text-gray-800">
                    {{ $mother->address }}
                </p>

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- PREGNANCY INFORMATION --}}
{{-- ====================================== --}}

<div class="mt-10">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15.75 9.75M21 12A9 9 0 1112 3a9 9 0 019 9Z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Pregnancy Information
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Current pregnancy details and maternal health information.
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 gap-6 p-8 md:grid-cols-2">

            <!-- Civil Status -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-pink-100 p-2 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 4.5a4.5 4.5 0 00-4.5 4.5A4.5 4.5 0 007.5 4.5 4.5 4.5 0 003 9c0 5.25 9 11.25 9 11.25S21 14.25 21 9a4.5 4.5 0 00-4.5-4.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Civil Status
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $mother->civil_status }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Occupation -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-pink-100 p-2 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M7.5 3.75h9A1.5 1.5 0 0118 5.25V7.5H6V5.25A1.5 1.5 0 017.5 3.75ZM4.5 7.5h15v10.5A2.25 2.25 0 0117.25 20.25H6.75A2.25 2.25 0 014.5 18V7.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Occupation
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $mother->occupation ?: '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Height -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-pink-100 p-2 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3v18M5.25 5.25h4.5M5.25 18.75h4.5M16.5 6v12M14.25 8.25h4.5M14.25 15.75h4.5"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Height
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ number_format($mother->height, 2) }} cm
                        </p>
                    </div>
                </div>
            </div>

            <!-- Weight -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-pink-100 p-2 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3.314 0 6 2.686 6 6v7.5A1.5 1.5 0 0116.5 18h-9A1.5 1.5 0 016 16.5V9c0-3.314 2.686-6 6-6Zm0 4.5v.008"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Weight
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ number_format($mother->weight, 2) }} kg
                        </p>
                    </div>
                </div>
            </div>

            <!-- Last Menstrual Period -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-pink-100 p-2 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Last Menstrual Period
                        </p>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($mother->last_menstrual_period)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Expected Delivery Date -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-xl bg-green-100 p-2 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Expected Delivery Date
                        </p>
                        <p class="mt-1 text-base font-semibold text-green-700">
                            {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pregnancy Number -->
            <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6 shadow-sm md:col-span-2">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15.75 9.75M21 12A9 9 0 1112 3a9 9 0 019 9Z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                                Pregnancy Number
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-900">
                                Pregnancy #{{ $mother->pregnancy_number }}
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex items-center rounded-full bg-pink-600 px-5 py-2 text-sm font-semibold text-white shadow-sm">
                        Active Pregnancy Record
                    </span>

                </div>
            </div>

        </div>

    </div>
</div>
{{-- ====================================== --}}
{{-- PRENATAL CHECKUPS --}}
{{-- ====================================== --}}

{{-- ====================================== --}}
{{-- QUICK ACTIONS --}}
{{-- ====================================== --}}

<div class="mt-10">

    <!-- Section -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Quick Actions
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Perform common actions for this mother's medical record.
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-1 gap-6 p-8 lg:grid-cols-2">

            <!-- Add Prenatal Visit -->
            <a href="{{ route('prenatal-checkups.create', $mother->id) }}"
               class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-pink-300 hover:shadow-lg">

                <div class="flex items-start gap-5">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 transition group-hover:bg-pink-600 group-hover:text-white">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-7 w-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>

                    </div>

                    <div class="flex-1">

                        <div class="flex items-center justify-between">

                            <h3 class="text-lg font-semibold text-gray-900">
                                Add Prenatal Visit
                            </h3>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-gray-400 transition group-hover:translate-x-1 group-hover:text-pink-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>

                        </div>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Record a new prenatal consultation, assessment, and maternal health information.
                        </p>

                    </div>

                </div>

            </a>

            <!-- Schedule Appointment -->
            <a href="{{ route('appointments.create', $mother->id) }}"
               class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-pink-300 hover:shadow-lg">

                <div class="flex items-start gap-5">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 transition group-hover:bg-pink-600 group-hover:text-white">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-7 w-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>

                    </div>

                    <div class="flex-1">

                        <div class="flex items-center justify-between">

                            <h3 class="text-lg font-semibold text-gray-900">
                                Schedule Appointment
                            </h3>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-gray-400 transition group-hover:translate-x-1 group-hover:text-pink-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>

                        </div>

                        <p class="mt-2 text-sm leading-6 text-gray-500">
                            Schedule a prenatal consultation or follow-up appointment for this patient.
                        </p>

                    </div>

                </div>

            </a>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- PRENATAL RECORDS --}}
{{-- ====================================== --}}

<div class="mt-10">

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19.5 7.5v9A2.25 2.25 0 0117.25 18.75H6.75A2.25 2.25 0 014.5 16.5v-9A2.25 2.25 0 016.75 5.25h10.5A2.25 2.25 0 0119.5 7.5ZM9 12h6M12 9v6"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Prenatal Records
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Complete history of prenatal check-ups and maternal health assessments.
                        </p>
                    </div>
                </div>

                <div class="rounded-xl bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-700">
                    Total Visits: {{ $mother->prenatalCheckups->count() }}
                </div>

            </div>
        </div>

        @if($mother->prenatalCheckups->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">

                            <th class="px-6 py-4 text-left">
                                Visit Date
                            </th>

                            <th class="px-6 py-4 text-center">
                                Gestational Age
                            </th>

                            <th class="px-6 py-4 text-center">
                                Blood Pressure
                            </th>

                            <th class="px-6 py-4 text-center">
                                Weight
                            </th>

                            <th class="px-6 py-4 text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($mother->prenatalCheckups as $visit)

                            <tr class="transition hover:bg-pink-50/50">

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex rounded-full bg-pink-100 px-4 py-2 text-sm font-semibold text-pink-700">
                                        {{ $visit->gestational_age_weeks }} weeks
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                                        {{ $visit->systolic_bp }}/{{ $visit->diastolic_bp }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="font-semibold text-gray-800">
                                        {{ number_format($visit->weight,1) }} kg
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <a href="{{ route('prenatal-checkups.show',$visit->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Zm9.75 3a3 3 0 100-6 3 3 0 000 6Z"/>
                                        </svg>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16 text-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 7.5v9A2.25 2.25 0 0117.25 18.75H6.75A2.25 2.25 0 014.5 16.5v-9A2.25 2.25 0 016.75 5.25h10.5A2.25 2.25 0 0119.5 7.5ZM9 12h6M12 9v6"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    No Prenatal Records Found
                </h3>

                <p class="mt-2 max-w-md text-sm text-gray-500">
                    No prenatal visits have been recorded for this mother yet.
                </p>

                <a href="{{ route('prenatal-checkups.create',$mother->id) }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>

                    Add First Prenatal Visit

                </a>

            </div>

        @endif

    </div>

</div>

{{-- ====================================== --}}
{{-- INFANT RECORDS --}}
{{-- ====================================== --}}

<div class="mt-10">

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Infant Records
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Registered infants associated with this mother.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <span class="rounded-xl bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-700">
                        Total Infants: {{ $mother->infants->count() }}
                    </span>

                    <a href="{{ route('infants.create', $mother->id) }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-lg">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>

                        Register Infant

                    </a>

                </div>

            </div>
        </div>

        @if($mother->infants->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">

                            <th class="px-6 py-4 text-left">
                                Infant
                            </th>

                            <th class="px-6 py-4 text-center">
                                Sex
                            </th>

                            <th class="px-6 py-4 text-center">
                                Birth Date
                            </th>

                            <th class="px-6 py-4 text-center">
                                Birth Status
                            </th>

                            <th class="px-6 py-4 text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($mother->infants as $infant)

                            <tr class="transition hover:bg-pink-50/40">

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-900">
                                                {{ $infant->first_name }}
                                                {{ $infant->middle_name }}
                                                {{ $infant->last_name }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                Infant Record
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                                        {{ $infant->sex }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                        {{ $infant->birth_status }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <a href="{{ route('infants.show', $infant->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Zm9.75 3a3 3 0 100-6 3 3 0 000 6Z"/>
                                        </svg>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16 text-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    No Infant Records Found
                </h3>

                <p class="mt-2 max-w-md text-sm text-gray-500">
                    There are currently no registered infant records associated with this mother.
                </p>

                <a href="{{ route('infants.create', $mother->id) }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>

                    Register First Infant

                </a>

            </div>

        @endif

    </div>

</div>

{{-- ====================================== --}}
{{-- APPOINTMENTS --}}
{{-- ====================================== --}}

<div class="mt-10">

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            Appointments
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Upcoming and completed appointments for this mother.
                        </p>
                    </div>
                </div>

                <div class="rounded-xl bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-700">
                    Total Appointments: {{ $mother->appointments->count() }}
                </div>

            </div>
        </div>

        @if($mother->appointments->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">

                            <th class="px-6 py-4 text-left">
                                Appointment
                            </th>

                            <th class="px-6 py-4 text-center">
                                Time
                            </th>

                            <th class="px-6 py-4 text-center">
                                Type
                            </th>

                            <th class="px-6 py-4 text-center">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($mother->appointments as $appointment)

                            <tr class="transition hover:bg-pink-50/40">

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                Scheduled Appointment
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">
                                        {{ $appointment->appointment_type }}
                                    </span>

                                </td>

                                <td class="px-6 py-5 text-center">

                                    @if($appointment->status == 'Scheduled')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                                            {{ $appointment->status }}
                                        </span>

                                    @elseif($appointment->status == 'Completed')

                                        <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                                            {{ $appointment->status }}
                                        </span>

                                    @elseif($appointment->status == 'Cancelled')

                                        <span class="inline-flex rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                            {{ $appointment->status }}
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">
                                            {{ $appointment->status }}
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-5 text-center">

                                    <a href="{{ route('appointments.show', $appointment->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-pink-300 hover:bg-pink-50 hover:text-pink-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Zm9.75 3a3 3 0 100-6 3 3 0 000 6Z"/>
                                        </svg>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16 text-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    No Appointments Found
                </h3>

                <p class="mt-2 max-w-md text-sm text-gray-500">
                    There are currently no scheduled appointments for this mother.
                </p>

                <a href="{{ route('appointments.create',$mother->id) }}"
                   class="mt-8 inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>

                    Schedule Appointment

                </a>

            </div>

        @endif

    </div>

</div>

</x-app-layout>
