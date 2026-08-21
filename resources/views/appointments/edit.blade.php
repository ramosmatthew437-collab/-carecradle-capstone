<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Appointment
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-6 sm:space-y-8">

                {{-- ====================================== --}}
                {{-- Section 1 : Hero Header --}}
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

                                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                        Edit Appointment
                                    </h1>

                                    <p class="mt-2 text-sm sm:text-base text-pink-100">
                                        CareCradle Appointment Management
                                    </p>

                                    <p class="mt-4 max-w-3xl text-sm leading-6 sm:leading-7 text-pink-100/90">
                                        Update the appointment schedule, consultation details,
                                        appointment status, and healthcare notes while maintaining
                                        accurate maternal health records within the CareCradle
                                        Electronic Medical Record System.
                                    </p>

                                </div>

                            </div>

                            <div class="lg:w-80">

                                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                        Patient Information
                                    </p>

                                    <div class="mt-4">

                                        <h2 class="truncate text-xl sm:text-2xl font-bold text-white">

                                            {{ $appointment->mother->first_name }}
                                            {{ $appointment->mother->last_name }}

                                        </h2>

                                        <div class="mt-3">

                                            <span class="inline-flex items-center rounded-xl bg-white px-4 py-2 font-mono text-sm font-semibold text-pink-700 shadow-sm">

                                                {{ $appointment->mother->mother_code }}

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 2 : Validation Error Card --}}
                {{-- ====================================== --}}

                @if ($errors->any())

                    <div class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

                        <div class="border-b border-red-100 bg-red-50 px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-5 w-5 sm:h-6 sm:w-6">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z"/>

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h2 class="text-base sm:text-lg font-semibold text-red-700">
                                        Validation Errors
                                    </h2>

                                    <p class="mt-1 text-xs sm:text-sm text-red-600">
                                        Please review the following information before updating this appointment record.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="p-5 sm:p-6">

                            <ul class="space-y-3">

                                @foreach ($errors->all() as $error)

                                    <li class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-600">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z"/>

                                        </svg>

                                        <span class="text-sm text-red-700">
                                            {{ $error }}
                                        </span>

                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- Section 3 : Appointment Information Form --}}
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
                                    Update the appointment schedule, status, and clinical notes for this patient.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Form --}}
                    <div class="p-5 sm:p-8">

                        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                                {{-- Appointment Type --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Appointment Type
                                    </label>

                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                            </svg>
                                        </div>

                                        <select
                                            name="appointment_type"
                                            class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
@foreach(['Prenatal Checkup', 'Vaccination', 'Postpartum Checkup'] as $type)
    <option value="{{ $type }}"
        {{ old('appointment_type', $appointment->appointment_type) == $type ? 'selected' : '' }}>
        {{ $type }}
    </option>
@endforeach
                                            

                                        </select>
                                    </div>

                                </div>

                                {{-- Appointment Date --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Appointment Date
                                    </label>

                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                            </svg>
                                        </div>

                                        <input
                                            type="date"
                                            name="appointment_date"
                                            value="{{ old('appointment_date', $appointment->appointment_date) }}"
                                            class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                    </div>

                                </div>

                                {{-- Appointment Time --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Appointment Time
                                    </label>

                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>
                                            </svg>
                                        </div>

                                        <input
                                            type="time"
                                            name="appointment_time"
                                            value="{{ old('appointment_time', $appointment->appointment_time) }}"
                                            class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                    </div>

                                </div>

                                {{-- Status --}}
                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                                        Status
                                    </label>

                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>
                                            </svg>
                                        </div>

                                        <select
                                            name="status"
                                            class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                                            @foreach(['Scheduled','Completed','Cancelled','Missed'] as $status)

                                                <option value="{{ $status }}"
                                                    {{ old('status', $appointment->status) == $status ? 'selected' : '' }}>

                                                    {{ $status }}

                                                </option>

                                            @endforeach

                                        </select>
                                    </div>

                                </div>

                            </div>

                            {{-- Notes --}}
                            <div class="mt-6 sm:mt-8">

                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Clinical Notes
                                </label>

                                <textarea
                                    name="notes"
                                    rows="5"
                                    placeholder="Enter clinical observations, reminders, or healthcare notes..."
                                    class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-4 text-sm leading-7 text-gray-700 placeholder:text-gray-400 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('notes', $appointment->notes) }}</textarea>

                            </div>

                            {{-- ====================================== --}}
                            {{-- Section 4 : Action Buttons --}}
                            {{-- ====================================== --}}

                            <div class="mt-6 sm:mt-8 flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 lg:flex-row lg:items-center lg:justify-between">

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
                                            Appointment Update
                                        </p>

                                        <p class="mt-1 text-sm leading-6 text-gray-600">
                                            Review all appointment details before saving your changes. Updates will immediately be reflected throughout the CareCradle Electronic Medical Record System.
                                        </p>

                                    </div>

                                </div>

                                {{-- Buttons --}}
                                <div class="flex flex-col gap-3 sm:flex-row">

                                    {{-- Update --}}
                                    <button
                                        type="submit"
                                        class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 active:scale-[0.98]">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="h-5 w-5">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 3.75H6.75A2.25 2.25 0 004.5 6v12A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V6.75A3 3 0 0016.5 3.75Z"/>

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 3.75v4.5h6v-4.5"/>

                                        </svg>

                                        Update Appointment

                                    </button>

                                    {{-- Back --}}
                                    <a
                                        href="{{ route('appointments.show', $appointment->id) }}"
                                        class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 active:scale-[0.98]">

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

                                        Back to Appointment

                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>