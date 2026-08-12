<x-app-layout>
    <x-slot name="header">
     <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    CareCradle Administrator Dashboard
</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">

            {{-- ====================================== --}}
{{-- Welcome Banner --}}
{{-- ====================================== --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 to-pink-700 shadow-sm">

    <div class="px-8 py-8 lg:px-10">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-start gap-4">

                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-8 w-8 text-white">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v12.75a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75V4.5a.75.75 0 01.75-.75Zm5.25 5.25h4.5m-4.5 3h4.5m-4.5 3h2.25" />
                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Welcome back, {{ Auth::user()->name }}
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        CareCradle Administrator Portal
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Monitor maternal and infant healthcare records, manage midwife accounts,
                        and generate official reports for the Irosin Rural Health Unit.
                    </p>

                </div>

            </div>

            <div class="flex-shrink-0">

                <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-4 backdrop-blur-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5 text-white">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z" />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-medium uppercase tracking-wider text-pink-100">
                                Today
                            </p>

                            <p class="mt-1 text-sm font-semibold text-white">
                                {{ now()->format('l, F d, Y') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

{{-- ====================================== --}}
{{-- System Overview --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                System Overview
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Real-time summary of CareCradle records and healthcare services.
            </p>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-5">

        {{-- Registered Midwives --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Registered Midwives
                    </p>

                    <h3 class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $midwives }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Registered Mothers --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Registered Mothers
                    </p>

                    <h3 class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $mothers }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Registered Infants --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Registered Infants
                    </p>

                    <h3 class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $infants }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Vaccinations --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Vaccinations
                    </p>

                    <h3 class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $vaccinations }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Upcoming Appointments --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Upcoming Appointments
                    </p>

                    <h3 class="mt-3 text-4xl font-bold text-gray-900">
                        {{ $appointments }}
                    </h3>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                    </svg>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ====================================== --}}
{{-- Administrator Actions --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">
            Administrator Actions
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Manage users and administrative reports for the CareCradle EMR.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Manage Midwives --}}
        <a href="{{ route('midwives.index') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-pink-300 hover:shadow-md">

            <div class="p-6">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-7 w-7">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-lg font-semibold text-gray-900">
                                Manage Midwives
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Add, edit, activate, or deactivate registered
                                midwife accounts.
                            </p>

                        </div>

                    </div>

                    <div class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-pink-600">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="h-6 w-6">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>

                    </div>

                </div>

            </div>

        </a>

        {{-- Generate Reports --}}
        <a href="{{ route('reports.index') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-green-300 hover:shadow-md">

            <div class="p-6">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-7 w-7">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 17v-2m3 2v-4m3 4V7m5 12H4.5A2.25 2.25 0 012.25 16.75V4.5A2.25 2.25 0 014.5 2.25h15A2.25 2.25 0 0121.75 4.5v12.25A2.25 2.25 0 0119.5 19Z"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-lg font-semibold text-gray-900">
                                Generate Reports
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                View, export, and print maternal and infant
                                healthcare reports.
                            </p>

                        </div>

                    </div>

                    <div class="text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-600">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor"
                             class="h-6 w-6">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>

                    </div>

                </div>

            </div>

        </a>

    </div>

</div>


{{-- ====================================== --}}
{{-- Today's Appointments --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Today's Appointments
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Monitor today's scheduled maternal healthcare consultations.
            </p>
        </div>

    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @if($todayAppointments->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Appointment Time
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Mother
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Appointment Type
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($todayAppointments as $appointment)

                            @php
                                $statusClasses = match($appointment->status) {
                                    'Scheduled' => 'bg-blue-100 text-blue-700',
                                    'Completed' => 'bg-green-100 text-green-700',
                                    'Cancelled' => 'bg-red-100 text-red-700',
                                    'Missed' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                            </svg>

                                        </div>

                                        <span class="font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        </span>

                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="font-semibold text-gray-900">
                                        {{ $appointment->mother->first_name }}
                                        {{ $appointment->mother->last_name }}
                                    </div>

                                    <div class="mt-1 text-sm text-gray-500">
                                        Maternal Patient
                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    <span class="inline-flex rounded-xl bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700">
                                        {{ $appointment->appointment_type }}
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClasses }}">
                                        {{ $appointment->status }}
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16">

                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-10 w-10">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-lg font-semibold text-gray-900">
                    No Appointments Today
                </h3>

                <p class="mt-2 max-w-md text-center text-sm text-gray-500">
                    There are no scheduled maternal appointments for today.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- ====================================== --}}
{{-- Upcoming Vaccinations --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Upcoming Vaccinations
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Track infants with upcoming immunization schedules.
            </p>
        </div>

    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @if($upcomingVaccinations->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Infant
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Vaccine
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Next Due Date
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($upcomingVaccinations as $vaccination)

                            <tr class="transition hover:bg-gray-50">

                                {{-- Infant --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <div class="font-semibold text-gray-900">
                                                {{ $vaccination->infant->first_name }}
                                                {{ $vaccination->infant->last_name }}
                                            </div>

                                            <div class="mt-1 text-sm text-gray-500">
                                                Infant Record
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- Vaccine --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <div class="font-semibold text-gray-900">
                                                {{ $vaccination->vaccine_name }}
                                            </div>

                                            <div class="mt-1 text-sm text-gray-500">
                                                Scheduled Vaccine
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                {{-- Due Date --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-yellow-100 text-yellow-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                                            </svg>

                                        </div>

                                        <span class="font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                        </span>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16">

                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-10 w-10">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-lg font-semibold text-gray-900">
                    No Upcoming Vaccinations
                </h3>

                <p class="mt-2 max-w-md text-center text-sm text-gray-500">
                    Upcoming infant immunization schedules will appear here once
                    vaccination records are available.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- ====================================== --}}
{{-- Recent Infant Registrations --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Recent Infant Registrations
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                View the most recently registered infant records in the CareCradle EMR.
            </p>
        </div>

    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        @if($recentInfants->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Infant
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Mother
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Registration Date
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @foreach($recentInfants as $infant)

                            <tr class="transition duration-200 hover:bg-gray-50">

                                {{-- Infant --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-900">
                                                {{ $infant->first_name }}
                                                {{ $infant->last_name }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Infant Record
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- Mother --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-6 w-6">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="font-semibold text-gray-900">
                                                {{ $infant->mother->first_name }}
                                                {{ $infant->mother->last_name }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Registered Mother
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- Registration Date --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5"
                                                 stroke="currentColor"
                                                 class="h-5 w-5">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="font-medium text-gray-900">
                                                {{ $infant->created_at->format('M d, Y') }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $infant->created_at->format('l') }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="flex flex-col items-center justify-center px-8 py-16">

                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-10 w-10">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                    </svg>

                </div>

                <h3 class="mt-6 text-lg font-semibold text-gray-900">
                    No Infant Records Yet
                </h3>

                <p class="mt-2 max-w-md text-center text-sm text-gray-500">
                    Newly registered infant records will appear here once patients
                    are enrolled in the CareCradle system.
                </p>

            </div>

        @endif

    </div>

</div>

</x-app-layout>

{{-- ====================================== --}}
{{-- Footer --}}
{{-- ====================================== --}}
<footer class="mt-10 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="px-8 py-6">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            {{-- System Information --}}
            <div class="flex items-start gap-4">

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-7 w-7">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>

                </div>

                <div>

                    <h3 class="text-lg font-semibold text-gray-900">
                        CareCradle Maternal & Infant Health Monitoring System
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Administrator Portal
                    </p>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                        A centralized healthcare information system that supports
                        maternal and infant monitoring, appointment management,
                        immunization tracking, and administrative reporting for
                        the Irosin Rural Health Unit.
                    </p>

                </div>

            </div>

            {{-- Version Information --}}
            <div class="flex flex-col items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 px-6 py-5 lg:items-end">

                <div class="flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-5 w-5 text-pink-600">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5.637 13.863a2.25 2.25 0 000 3.182l1.318 1.318a2.25 2.25 0 003.182 0l3.454-3.454a2.25 2.25 0 011.591-.659h5.714"/>
                    </svg>

                    <span class="text-sm font-semibold text-gray-900">
                        Version 1.0
                    </span>

                </div>

                <div class="text-sm text-gray-500">
                    Administrator Dashboard
                </div>

                <div class="text-sm text-gray-500">
                    © {{ date('Y') }} Irosin Rural Health Unit
                </div>

                <div class="text-xs text-gray-400">
                    All Rights Reserved.
                </div>

            </div>

        </div>

    </div>

</footer>