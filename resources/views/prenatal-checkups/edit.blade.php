<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Prenatal Visit
        </h2>
    </x-slot>

   <div class="py-8">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="space-y-8">

            {{-- ====================================== --}}
            {{-- Section 1 : Hero Header --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-pink-600 to-pink-700 shadow-sm">

                <div class="p-8 text-white">

                    <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">

                        {{-- Left Content --}}
                        <div class="flex-1">

                            <div class="flex items-start gap-5">

                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-8 w-8">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />

                                    </svg>

                                </div>

                                <div>

                                    <h1 class="text-4xl font-bold tracking-tight">
                                        Edit Prenatal Visit
                                    </h1>

                                    <p class="mt-2 text-lg text-pink-100">
                                        CareCradle Prenatal Care Management
                                    </p>

                                    <p class="mt-6 max-w-3xl text-sm leading-7 text-pink-50">
                                        Update prenatal consultation information including maternal assessment,
                                        laboratory findings, clinical observations, and follow-up schedules while
                                        maintaining accurate and comprehensive maternal healthcare records within
                                        the CareCradle Electronic Medical Record System.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Mother Information Card --}}
                    <div class="mt-10 rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm">

                        <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                            Mother Information
                        </p>

                        <h2 class="mt-3 text-3xl font-bold">
                            {{ $prenatalCheckup->mother->first_name }}
                            {{ $prenatalCheckup->mother->last_name }}
                        </h2>

                        <div class="mt-5 inline-flex items-center rounded-xl bg-white px-5 py-2">

                            <span class="text-sm font-semibold text-pink-600">
                                {{ $prenatalCheckup->mother->mother_code }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 2 : Validation Error Card --}}
            {{-- ====================================== --}}

            @if ($errors->any())

                <div class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

                    {{-- Header --}}
                    <div class="border-b border-red-100 bg-red-50 px-6 py-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm0-13.5a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Z" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-red-700">
                                    Validation Errors
                                </h2>

                                <p class="mt-1 text-sm text-red-600">
                                    Please review the information below and correct the highlighted fields before updating this prenatal visit.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Error List --}}
                    <div class="p-6">

                        <ul class="space-y-3">

                            @foreach ($errors->all() as $error)

                                <li class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-500">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm0-13.5a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Z" />

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

            <form action="{{ route('prenatal-checkups.update', $prenatalCheckup->id) }}" method="POST">

                @csrf
                @method('PUT')


                            {{-- ====================================== --}}
            {{-- Section 3 : Visit Information --}}
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
                                    d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Visit Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Update the consultation date and gestational age for this prenatal visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Visit Date --}}
                        <div>

                            <label for="visit_date"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Visit Date
                            </label>

                            <input
                                id="visit_date"
                                type="date"
                                name="visit_date"
                                value="{{ old('visit_date', $prenatalCheckup->visit_date) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                        </div>

                        {{-- Gestational Age --}}
                        <div>

                            <label for="gestational_age_weeks"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Gestational Age (Weeks)
                            </label>

                            <input
                                id="gestational_age_weeks"
                                type="number"
                                name="gestational_age_weeks"
                                value="{{ old('gestational_age_weeks', $prenatalCheckup->gestational_age_weeks) }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                        </div>

                    </div>

                </div>

            </div>


                {{-- ====================================== --}}
                {{-- Section 4 : Maternal Assessment --}}
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
                                        d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-gray-900">
                                    Maternal Assessment
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Record maternal vital signs and fetal assessment during this prenatal consultation.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-8">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            {{-- Weight --}}
                            <div>

                                <label for="weight"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Weight (kg)
                                </label>

                                <input
                                    id="weight"
                                    type="number"
                                    step="0.01"
                                    name="weight"
                                    value="{{ old('weight') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                            </div>

                            {{-- Fundal Height --}}
                            <div>

                                <label for="fundal_height"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Fundal Height (cm)
                                </label>

                                <input
                                    id="fundal_height"
                                    type="number"
                                    step="0.01"
                                    name="fundal_height"
                                    value="{{ old('fundal_height') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                            </div>

                            {{-- Systolic Blood Pressure --}}
                            <div>

                                <label for="systolic_bp"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Systolic Blood Pressure
                                </label>

                                <input
                                    id="systolic_bp"
                                    type="number"
                                    name="systolic_bp"
                                    value="{{ old('systolic_bp') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                            </div>

                            {{-- Diastolic Blood Pressure --}}
                            <div>

                                <label for="diastolic_bp"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Diastolic Blood Pressure
                                </label>

                                <input
                                    id="diastolic_bp"
                                    type="number"
                                    name="diastolic_bp"
                                    value="{{ old('diastolic_bp') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                            </div>

                            {{-- Fetal Heart Rate --}}
                            <div>

                                <label for="fetal_heart_rate"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Fetal Heart Rate (bpm)
                                </label>

                                <input
                                    id="fetal_heart_rate"
                                    type="number"
                                    name="fetal_heart_rate"
                                    value="{{ old('fetal_heart_rate') }}"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                            </div>

                            {{-- Fetal Movement --}}
                            <div>

                                <label for="fetal_movement"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Fetal Movement
                                </label>

                                <select
                                    id="fetal_movement"
                                    name="fetal_movement"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                                    <option value="">Select</option>

                                    @foreach (['Normal', 'Reduced', 'Not Yet Felt'] as $movement)

                                        <option value="{{ $movement }}"
                                            {{ old('fetal_movement') == $movement ? 'selected' : '' }}>

                                            {{ $movement }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>
                {{-- ====================================== --}}
                {{-- Section 5 : Laboratory Findings --}}
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
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H15V6.75A2.25 2.25 0 0012.75 4.5h-1.5A2.25 2.25 0 009 6.75v1.5H7.875A3.375 3.375 0 004.5 11.625v2.625A6.75 6.75 0 0011.25 21h1.5a6.75 6.75 0 006.75-6.75Z" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-semibold text-gray-900">
                                    Laboratory Findings
                                </h2>

                                <p class="mt-1 text-sm text-gray-500">
                                    Record urine screening results obtained during the prenatal consultation.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-8">

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            {{-- Urine Protein --}}
                            <div>

                                <label for="urine_protein"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Urine Protein
                                </label>

                                <select
                                    id="urine_protein"
                                    name="urine_protein"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                                    <option value="">Select</option>

                                    @foreach (['Negative', 'Trace', '+1', '+2', '+3'] as $value)

                                        <option value="{{ $value }}"
                                            {{ old('urine_protein') == $value ? 'selected' : '' }}>

                                            {{ $value }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- Urine Glucose --}}
                            <div>

                                <label for="urine_glucose"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Urine Glucose
                                </label>

                                <select
                                    id="urine_glucose"
                                    name="urine_glucose"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                                    <option value="">Select</option>

                                    @foreach (['Negative', 'Trace', '+1', '+2', '+3'] as $value)

                                        <option value="{{ $value }}"
                                            {{ old('urine_glucose') == $value ? 'selected' : '' }}>

                                            {{ $value }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>
            {{-- ====================================== --}}
            {{-- Section 6 : Assessment --}}
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
                                    d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Assessment
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Update the mother's clinical condition, assessment, and additional observations recorded during this prenatal visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="space-y-6 p-8">

                    {{-- Maternal Condition --}}
                    <div>

                        <label for="maternal_condition"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Maternal Condition
                        </label>

                        <textarea
                            id="maternal_condition"
                            name="maternal_condition"
                            rows="4"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('maternal_condition', $prenatalCheckup->maternal_condition) }}</textarea>

                    </div>

                    {{-- Notes --}}
                    <div>

                        <label for="notes"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Notes
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="5"
                            class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('notes', $prenatalCheckup->notes) }}</textarea>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 7 : Follow-up --}}
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
                                    d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Follow-up Schedule
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Update the patient's recommended return appointment to ensure continuous prenatal monitoring and timely maternal healthcare.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="max-w-md">

                        <label for="next_visit_date"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Next Visit Date
                        </label>

                        <input
                            id="next_visit_date"
                            type="date"
                            name="next_visit_date"
                            value="{{ old('next_visit_date', $prenatalCheckup->next_visit_date) }}"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                        <p class="mt-2 text-sm text-gray-500">
                            Select the recommended follow-up date for the mother's next prenatal consultation.
                        </p>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 8 : Action Buttons --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-pink-200 bg-pink-50 shadow-sm">

                <div class="p-6">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Content --}}
                        <div>

                            <h3 class="text-lg font-semibold text-pink-700">
                                Update Prenatal Visit
                            </h3>

                            <p class="mt-1 text-sm text-pink-600">
                                Review all information carefully before saving. Updating this record
                                will immediately reflect the latest prenatal consultation details in
                                the mother's CareCradle Electronic Medical Record.
                            </p>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col gap-3 sm:flex-row">

                            {{-- Cancel --}}
                            <a
                                href="{{ route('mothers.show', $prenatalCheckup->mother->id) }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />

                                </svg>

                                Cancel

                            </a>

                            {{-- Update --}}
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z" />

                                </svg>

                                Update Prenatal Visit

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

</div>

</x-app-layout>
