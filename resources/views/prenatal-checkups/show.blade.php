<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Prenatal Visit Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-8 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- Section 1 : Hero Header --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-50 via-white to-white shadow-sm">

                <div class="p-8">

                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Side --}}
                        <div class="flex items-start gap-5">

                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-8 w-8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                                </svg>

                            </div>

                            <div>

                                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                                    Prenatal Visit Details
                                </h1>

                                <p class="mt-2 text-gray-600">
                                    Review the complete prenatal consultation record including maternal assessment,
                                    laboratory findings, clinical observations, and scheduled follow-up care.
                                </p>

                            </div>

                        </div>

                        {{-- Mother Information Card --}}
                        <div class="w-full rounded-2xl border border-pink-200 bg-white p-6 shadow-sm lg:max-w-sm">

                            <div class="mb-4 flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-6 w-6">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-sm font-medium uppercase tracking-wide text-pink-600">
                                        Mother Information
                                    </p>

                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $prenatalCheckup->mother->first_name }}
                                        {{ $prenatalCheckup->mother->last_name }}
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-3 border-t border-gray-100 pt-4">

                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-gray-500">
                                        Mother Code
                                    </span>

                                    <span class="font-semibold text-pink-600">
                                        {{ $prenatalCheckup->mother->mother_code }}
                                    </span>

                                </div>

                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-gray-500">
                                        Visit Date
                                    </span>

                                    <span class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 2 : Action Toolbar --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Visit Summary --}}
                    <div class="grid flex-1 grid-cols-1 gap-4 sm:grid-cols-3">

                        {{-- Visit Date --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Visit Date
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Gestational Age --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Gestational Age
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $prenatalCheckup->gestational_age_weeks }} Weeks
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Blood Pressure --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M21.75 9v.906a2.25 2.25 0 01-.664 1.591l-7.5 7.5a2.25 2.25 0 01-3.182 0l-7.5-7.5A2.25 2.25 0 012.25 9V5.25A2.25 2.25 0 014.5 3h3.75a2.25 2.25 0 011.591.659l1.06 1.06a2.25 2.25 0 001.59.659H19.5a2.25 2.25 0 012.25 2.25V9Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Blood Pressure
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $prenatalCheckup->systolic_bp }}/{{ $prenatalCheckup->diastolic_bp }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('prenatal-checkups.edit', $prenatalCheckup->id) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

                            </svg>

                            Edit

                        </a>

                        <form
                            action="{{ route('prenatal-checkups.destroy', $prenatalCheckup->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this prenatal visit? This action cannot be undone.');">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-5 w-5">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5"/>

                                </svg>

                                Delete

                            </button>

                        </form>

                        <a
                            href="{{ route('mothers.show', $prenatalCheckup->mother_id) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

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

                            Back

                        </a>

                    </div>

                </div>

            </div>
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
                                      d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Visit Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Clinical measurements and observations recorded during this prenatal consultation.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                        {{-- Visit Date --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Visit Date
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                            </p>

                        </div>

                        {{-- Gestational Age --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Gestational Age
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $prenatalCheckup->gestational_age_weeks }} Weeks
                            </p>

                        </div>

                        {{-- Blood Pressure --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Blood Pressure
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $prenatalCheckup->systolic_bp }}/{{ $prenatalCheckup->diastolic_bp }}
                            </p>

                        </div>

                        {{-- Weight --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Weight
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ number_format($prenatalCheckup->weight, 2) }} kg
                            </p>

                        </div>

                        {{-- Fundal Height --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Fundal Height
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $prenatalCheckup->fundal_height ?? '-' }} cm
                            </p>

                        </div>

                        {{-- Fetal Heart Rate --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Fetal Heart Rate
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $prenatalCheckup->fetal_heart_rate ?? '-' }} bpm
                            </p>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 4 : Laboratory Findings --}}
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
                                Laboratory screening results collected during this prenatal consultation.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Urine Protein --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-sm font-medium text-gray-500">
                                        Urine Protein
                                    </p>

                                    <p class="mt-2 text-lg font-semibold text-gray-900">
                                        {{ $prenatalCheckup->urine_protein ?? '-' }}
                                    </p>

                                </div>

                                <div class="rounded-xl bg-pink-100 p-3 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-6 w-6">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591l-4.87 4.87a2.25 2.25 0 000 3.182l1.318 1.318a2.25 2.25 0 003.182 0l4.87-4.87a2.25 2.25 0 011.591-.659h5.714" />

                                    </svg>

                                </div>

                            </div>

                        </div>

                        {{-- Urine Glucose --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-sm font-medium text-gray-500">
                                        Urine Glucose
                                    </p>

                                    <p class="mt-2 text-lg font-semibold text-gray-900">
                                        {{ $prenatalCheckup->urine_glucose ?? '-' }}
                                    </p>

                                </div>

                                <div class="rounded-xl bg-pink-100 p-3 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-6 w-6">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 3v18m9-9H3" />

                                    </svg>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 5 : Assessment --}}
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
                                      d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Assessment
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Clinical assessment, maternal condition, and healthcare provider observations documented during this prenatal visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="space-y-6 p-8">

                    {{-- Maternal Condition --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">

                        <div class="border-b border-gray-200 px-6 py-4">

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-pink-600">
                                Maternal Condition
                            </h3>

                        </div>

                        <div class="px-6 py-5">

                            <p class="whitespace-pre-line leading-7 text-gray-700">
                                {{ $prenatalCheckup->maternal_condition ?: '-' }}
                            </p>

                        </div>

                    </div>

                    {{-- Clinical Notes --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">

                        <div class="border-b border-gray-200 px-6 py-4">

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-pink-600">
                                Clinical Notes
                            </h3>

                        </div>

                        <div class="px-6 py-5">

                            <p class="whitespace-pre-line leading-7 text-gray-700">
                                {{ $prenatalCheckup->notes ?: '-' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 6 : Follow-up --}}
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
                                Follow-up Care
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Scheduled return appointment and navigation actions for continuing maternal prenatal care.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="space-y-8 p-8">

                    {{-- Next Visit --}}
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <p class="text-sm font-semibold uppercase tracking-wide text-pink-600">
                                    Next Prenatal Visit
                                </p>

                                <p class="mt-2 text-lg font-semibold text-gray-900">

                                    {{ $prenatalCheckup->next_visit_date
                                        ? \Carbon\Carbon::parse($prenatalCheckup->next_visit_date)->format('F d, Y')
                                        : '-' }}

                                </p>

                            </div>

                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-7 w-7">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />

                                </svg>

                            </div>

                        </div>

                    </div>

                    {{-- Action Toolbar --}}
                    <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            <div>

                                <h3 class="text-lg font-semibold text-pink-700">
                                    Visit Record Actions
                                </h3>

                                <p class="mt-1 text-sm text-pink-600">
                                    Manage this prenatal visit record by editing the information,
                                    deleting the record, or returning to the mother's profile.
                                </p>

                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">

                                <a
                                    href="{{ route('prenatal-checkups.edit', $prenatalCheckup->id) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">

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

                                    Edit Visit

                                </a>

                                <form
                                    action="{{ route('prenatal-checkups.destroy', $prenatalCheckup->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this prenatal visit? This action cannot be undone.');">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             class="h-5 w-5">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5" />

                                        </svg>

                                        Delete

                                    </button>

                                </form>

                                <a
                                    href="{{ route('mothers.show', $prenatalCheckup->mother_id) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />

                                    </svg>

                                    Back to Mother

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>