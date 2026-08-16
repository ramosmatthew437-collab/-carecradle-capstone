<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Appointment Details
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-6 sm:space-y-8">

                @php
                    $statusClasses = match($appointment->status) {
                        'Scheduled' => 'bg-blue-100 text-blue-700',
                        'Completed' => 'bg-emerald-100 text-emerald-700',
                        'Cancelled' => 'bg-red-100 text-red-700',
                        'Missed' => 'bg-amber-100 text-amber-700',
                        default => 'bg-gray-100 text-gray-700',
                    };

                    $motherStatusClasses = match($appointment->mother->status ?? null) {
                        'Pregnant' => 'bg-blue-100 text-blue-700',
                        'Delivered' => 'bg-emerald-100 text-emerald-700',
                        'Referred' => 'bg-amber-100 text-amber-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                {{-- ====================================== --}}
                {{-- Section 1 : Appointment Hero Card --}}
                {{-- ====================================== --}}

                <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

                    <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="pointer-events-none absolute -bottom-14 right-24 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>

                    <div class="relative px-5 py-6 sm:px-8 sm:py-8">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

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
                                            d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-100">
                                        CareCradle Appointment Management
                                    </p>

                                    <h1 class="mt-1 truncate text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                        {{ $appointment->appointment_type }}
                                    </h1>

                                    <p class="mt-2 text-sm text-pink-100">
                                        for <span class="font-semibold text-white">{{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}</span>
                                    </p>

                                    <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-pink-100">

                                        <span class="inline-flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                        </span>

                                        <span class="inline-flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="lg:w-72">

                                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                                    <div class="flex items-center justify-between gap-4">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                                Appointment Status
                                            </p>

                                            <div class="mt-3">

                                                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses }}">
                                                    {{ $appointment->status }}
                                                </span>

                                            </div>

                                        </div>

                                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-6 w-6 text-white">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                                            </svg>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 2 : Appointment Information --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 sm:h-6 sm:w-6">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25Z"/>

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                                    Appointment Information
                                </h2>

                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Schedule details and record history for this appointment.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-5 sm:p-8">

                        <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-3">

                            {{-- Appointment Type --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                    Appointment Type
                                </p>
                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ $appointment->appointment_type }}
                                </p>
                            </div>

                            {{-- Appointment Date --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                    Appointment Date
                                </p>
                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                </p>
                            </div>

                            {{-- Appointment Time --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                    </svg>
                                    Appointment Time
                                </p>
                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </p>
                            </div>

                            {{-- Status --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Status
                                </p>
                                <p class="mt-3">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $statusClasses }}">
                                        {{ $appointment->status }}
                                    </span>
                                </p>
                            </div>

                            {{-- Created Date --}}
                            @if($appointment->created_at)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Created Date
                                    </p>
                                    <p class="mt-3 text-base font-semibold text-gray-900">
                                        {{ $appointment->created_at->format('F d, Y') }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $appointment->created_at->format('g:i A') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Last Updated --}}
                            @if($appointment->updated_at)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Last Updated
                                    </p>
                                    <p class="mt-3 text-base font-semibold text-gray-900">
                                        {{ $appointment->updated_at->format('F d, Y') }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $appointment->updated_at->format('g:i A') }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        {{-- Notes --}}
                        <div class="mt-6">

                            @if($appointment->notes)

                                <div class="rounded-2xl border border-pink-200 bg-pink-50 p-5">

                                    <div class="mb-5 flex items-center justify-between gap-4">

                                        <div class="min-w-0">
                                            <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-pink-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                                </svg>
                                                Clinical Notes
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Notes entered by the attending healthcare provider during this appointment.
                                            </p>
                                        </div>

                                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                                            </svg>
                                        </div>

                                    </div>

                                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                        <p class="min-h-[90px] whitespace-pre-line text-sm leading-7 text-gray-700">
                                            {{ $appointment->notes }}
                                        </p>
                                    </div>

                                </div>

                            @else

                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center sm:px-8 sm:py-12">

                                    <div class="mx-auto flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 sm:mt-5 text-base sm:text-lg font-semibold text-gray-900">
                                        No Patient Notes
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        No clinical notes have been recorded for this appointment.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 3 : Mother Information --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                                    Mother Information
                                </h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Linked maternal record for this appointment.
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-5 sm:p-8">

                        {{-- Mother Summary Strip --}}
                        <div class="mb-6 rounded-2xl border border-pink-200 bg-pink-50 p-5 sm:p-6">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-4 min-w-0">

                                    <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                                            Mother
                                        </p>
                                        <h3 class="mt-1 truncate text-xl sm:text-2xl font-bold text-gray-900">
                                            {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}
                                        </h3>
                                        <span class="mt-2 inline-flex items-center rounded-lg bg-white px-3 py-1 font-mono text-xs font-semibold text-pink-700 shadow-sm">
                                            {{ $appointment->mother->mother_code }}
                                        </span>
                                    </div>

                                </div>

                                @if(isset($appointment->mother->status))
                                    <span class="w-fit shrink-0 inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold {{ $motherStatusClasses }}">
                                        {{ $appointment->mother->status }}
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">

                            {{-- Contact Number --}}
                            @if(isset($appointment->mother->contact_number))
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                                        </svg>
                                        Contact Number
                                    </p>
                                    <p class="mt-3 text-base font-semibold text-gray-900 break-words">
                                        {{ $appointment->mother->contact_number }}
                                    </p>
                                </div>
                            @endif

                            {{-- Barangay --}}
                            @if(isset($appointment->mother->barangay))
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                                    <p class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                                        </svg>
                                        Barangay
                                    </p>
                                    <p class="mt-3 text-base font-semibold text-gray-900 break-words">
                                        {{ $appointment->mother->barangay }}
                                    </p>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 4 : Quick Actions --}}
                {{-- ====================================== --}}

                <div class="flex flex-col-reverse gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Information --}}
                    <div class="flex items-start gap-4 rounded-2xl border border-pink-200 bg-pink-50 px-5 py-4">

                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                Appointment Record
                            </p>
                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                You may edit or remove this appointment record, or return to the mother's profile. Any updates will immediately reflect throughout the CareCradle Electronic Medical Record System.
                            </p>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        {{-- Edit --}}
                        <a
                            href="{{ route('appointments.edit', $appointment->id) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-amber-500 px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-200 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                            </svg>
                            Edit Appointment
                        </a>

                        {{-- Delete --}}
                        <form
                            action="{{ route('appointments.destroy', $appointment->id) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this appointment?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-red-600 px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200 active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-9.75 0V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0114.25 6v1.5m-7.5 0v10.125A2.625 2.625 0 009.375 20.25h5.25a2.625 2.625 0 002.625-2.625V7.5M10.5 11.25v5.25m3-5.25v5.25"/>
                                </svg>
                                Delete Appointment
                            </button>
                        </form>

                        {{-- Back to Mother Profile --}}
                        <a
                            href="{{ route('mothers.show', $appointment->mother_id) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            Mother Profile
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>