<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Appointment Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Main Layout Container --}}
            <div class="space-y-8">

                @php
                    $statusClasses = match($appointment->status) {
                        'Scheduled' => 'bg-blue-100 text-blue-700',
                        'Completed' => 'bg-green-100 text-green-700',
                        'Cancelled' => 'bg-red-100 text-red-700',
                        'Missed' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                {{-- ====================================== --}}
                {{-- Section 1 : Hero Header --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

                    <div class="px-8 py-8">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            <div class="flex items-start gap-5">

                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-8 w-8 text-white">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <h1 class="text-3xl font-bold tracking-tight text-white">
                                        Appointment Details
                                    </h1>

                                    <p class="mt-2 text-base text-pink-100">
                                        CareCradle Appointment Management
                                    </p>

                                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                                        Review the complete appointment information,
                                        consultation schedule, appointment status,
                                        and clinical notes recorded in the
                                        CareCradle Electronic Medical Record System.
                                    </p>

                                </div>

                            </div>

                            <div class="lg:w-80">

                                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                                    <div class="flex items-center justify-between">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                                Appointment Status
                                            </p>

                                            <div class="mt-3">

                                                <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold {{ $statusClasses }}">

                                                    @switch($appointment->status)

                                                        @case('Scheduled')
                                                            Scheduled
                                                            @break

                                                        @case('Completed')
                                                            Completed
                                                            @break

                                                        @case('Cancelled')
                                                            Cancelled
                                                            @break

                                                        @case('Missed')
                                                            Missed
                                                            @break

                                                        @default
                                                            {{ $appointment->status }}

                                                    @endswitch

                                                </span>

                                            </div>

                                        </div>

                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="h-6 w-6 text-white">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>

                                            </svg>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                                {{-- ====================================== --}}
                {{-- Section 2 : Appointment Information Card --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6.75v10.5m-7.5-10.5v10.5m-3-13.5h13.5A2.25 2.25 0 0121 6v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V6a2.25 2.25 0 012.25-2.25Z"/>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-gray-900">
                                    Appointment Information
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Patient profile, appointment schedule, and consultation details.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-8">

                        {{-- Mother Summary --}}
                        <div class="mb-8 rounded-2xl border border-pink-200 bg-pink-50 p-6">

                            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                                        Mother
                                    </p>

                                    <h3 class="mt-2 text-2xl font-bold text-gray-900">

                                        {{ $appointment->mother->first_name }}
                                        {{ $appointment->mother->last_name }}

                                    </h3>

                                    <div class="mt-3">

                                        <span class="inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-pink-700 shadow-sm">

                                            {{ $appointment->mother->mother_code }}

                                        </span>

                                    </div>

                                </div>

                                <div>

                                    <span class="inline-flex items-center rounded-full px-5 py-2 text-sm font-semibold {{ $statusClasses }}">

                                        @switch($appointment->status)

                                            @case('Scheduled')
                                                Scheduled
                                                @break

                                            @case('Completed')
                                                Completed
                                                @break

                                            @case('Cancelled')
                                                Cancelled
                                                @break

                                            @case('Missed')
                                                Missed
                                                @break

                                            @default
                                                {{ $appointment->status }}

                                        @endswitch

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Appointment Details --}}
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                            {{-- Appointment Type --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Appointment Type
                                </p>

                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ $appointment->appointment_type }}
                                </p>

                            </div>

                            {{-- Appointment Date --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Appointment Date
                                </p>

                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                                </p>

                            </div>

                            {{-- Appointment Time --}}
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">

                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Appointment Time
                                </p>

                                <p class="mt-3 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                                {{-- ====================================== --}}
                {{-- Section 3 : Patient Notes Card --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.5 2.25v4.875a1.125 1.125 0 001.125 1.125H19.5"/>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-gray-900">
                                    Patient Notes
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Clinical observations, reminders, and healthcare notes documented for this appointment.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-8">

                        @if($appointment->notes)

                            <div class="rounded-2xl border border-pink-200 bg-pink-50 p-5">

                                <div class="mb-5 flex items-center justify-between">

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-wider text-pink-600">
                                            Clinical Notes
                                        </p>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Notes entered by the attending healthcare provider during the patient's appointment.
                                        </p>

                                    </div>

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white shadow-sm">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-5 w-5 text-pink-600">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>

                                        </svg>

                                    </div>

                                </div>

                                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

    <p class="whitespace-pre-line text-sm leading-7 text-gray-700 min-h-[90px]">
        {{ $appointment->notes }}
    </p>

</div>

                                

                            </div>

                        @else

                            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-8 py-12 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-8 w-8">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>

                                    </svg>

                                </div>

                                <h3 class="mt-5 text-lg font-semibold text-gray-900">
                                    No Patient Notes
                                </h3>

                                <p class="mt-2 text-sm text-gray-500">
                                    No clinical notes have been recorded for this appointment.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                                {{-- ====================================== --}}
                {{-- Section 4 : Action Buttons --}}
                {{-- ====================================== --}}

                <div class="flex flex-col-reverse gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Information --}}
                    <div class="flex items-start gap-4 rounded-2xl border border-pink-200 bg-pink-50 px-5 py-4">

                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>

                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-gray-900">
                                Appointment Record
                            </p>

                            <p class="mt-1 text-sm leading-6 text-gray-600">
                                You may edit or remove this appointment record or return to the mother's profile. Any updates will immediately reflect throughout the CareCradle Electronic Medical Record System.
                            </p>

                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        {{-- Edit --}}
                        <a
                            href="{{ route('appointments.edit', $appointment->id) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>

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
                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 7.5h12m-9.75 0V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0114.25 6v1.5m-7.5 0v10.125A2.625 2.625 0 009.375 20.25h5.25a2.625 2.625 0 002.625-2.625V7.5M10.5 11.25v5.25m3-5.25v5.25"/>

                                </svg>

                                Delete Appointment

                            </button>

                        </form>

                        {{-- Back --}}
                        <a
                            href="{{ route('mothers.show', $appointment->mother_id) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>

                            </svg>

                            Back to Mother Profile

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>