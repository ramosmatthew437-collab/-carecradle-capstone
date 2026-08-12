<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Growth Record
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

                        {{-- Left Content --}}
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
                                          d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

                                </svg>

                            </div>

                            <div>

                                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                                    Edit Growth Record
                                </h1>

                                <p class="mt-2 text-gray-600">
                                    Update the infant's anthropometric measurements and clinical
                                    observations to maintain an accurate electronic growth
                                    monitoring record within CareCradle.
                                </p>

                            </div>

                        </div>

                        {{-- Infant Information Card --}}
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
                                        Infant Information
                                    </p>

                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $growthMonitoring->infant->first_name }}
                                        {{ $growthMonitoring->infant->last_name }}
                                    </p>

                                </div>

                            </div>

                            <div class="border-t border-gray-100 pt-4">

                                <p class="text-sm text-gray-500">
                                    You are updating the existing growth monitoring record for this infant. Review all measurements carefully before saving the changes.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 2 : Validation Error Card --}}
            {{-- ====================================== --}}

            <div class="space-y-6">

                @if ($errors->any())

                    <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">

                        <div class="border-b border-red-200 px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-red-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-6 w-6">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <h2 class="text-lg font-semibold text-red-700">
                                        Validation Errors
                                    </h2>

                                    <p class="mt-1 text-sm text-red-600">
                                        Please correct the following fields before updating this growth record.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="px-6 py-5">

                            <ul class="space-y-3">

                                @foreach ($errors->all() as $error)

                                    <li class="flex items-start gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm text-red-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             class="mt-0.5 h-5 w-5 flex-shrink-0">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0"/>

                                        </svg>

                                        <span>{{ $error }}</span>

                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif

                <form action="{{ route('growth-monitorings.update', $growthMonitoring) }}" method="POST">

                    @csrf
                    @method('PUT')

                                {{-- ====================================== --}}
            {{-- Section 3 : Growth Measurements --}}
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
                                      d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"/>

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Growth Measurements
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Update the infant's anthropometric measurements recorded during the growth monitoring visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Date Measured --}}
                        <div>

                            <label for="date_measured"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Date Measured
                            </label>

                            <input
                                id="date_measured"
                                type="date"
                                name="date_measured"
                                value="{{ old('date_measured', $growthMonitoring->date_measured) }}"
                                required
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                        </div>

                        {{-- Age --}}
                        <div>

                            <label for="age_in_months"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Age (Months)
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

                            <label for="weight"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Weight (kg)
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

                            <label for="height"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Height (cm)
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

                            <label for="head_circumference"
                                class="mb-2 block text-sm font-semibold text-gray-700">
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
            {{-- Section 4 : Remarks --}}
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
                                      d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z"/>

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Clinical Remarks
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Update the healthcare provider's observations, findings, recommendations,
                                or additional notes for this growth monitoring record.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <label for="remarks"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Remarks
                    </label>

                    <textarea
                        id="remarks"
                        name="remarks"
                        rows="6"
                        class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-700 shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('remarks', $growthMonitoring->remarks) }}</textarea>

                    <p class="mt-3 text-sm text-gray-500">
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

                <div class="p-6">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Content --}}
                        <div>

                            <h3 class="text-lg font-semibold text-pink-700">
                                Update Growth Record
                            </h3>

                            <p class="mt-1 text-sm text-pink-600">
                                Review all growth measurements and clinical remarks before saving.
                                Updating this record will immediately reflect the latest growth
                                monitoring information in the infant's CareCradle Electronic Medical Record.
                            </p>

                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col gap-3 sm:flex-row">

                            {{-- Cancel --}}
                            <a
                                href="{{ route('growth-monitorings.show', $growthMonitoring) }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200">

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
                                          d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

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

    </div>

</x-app-layout>