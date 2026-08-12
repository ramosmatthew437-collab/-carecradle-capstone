<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Growth Record
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-xl p-8">

                <h1 class="text-3xl font-bold mb-2">
                    Growth Monitoring
                </h1>

                <p class="text-gray-500 mb-8">
                    Infant:
                    <strong>
                        {{ $infant->first_name }}
                        {{ $infant->last_name }}
                    </strong>
                </p>

                <form action="{{ route('growth-monitorings.store', $infant) }}" method="POST">

                    @csrf

                    {{-- ====================================== --}}
{{-- Section 1 : Hero Header --}}
{{-- Place INSIDE the <form>, immediately after @csrf --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

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
                            d="M3.75 12h16.5m-8.25-8.25v16.5" />

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.5 7.5h9v9h-9z" />

                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Growth Monitoring Record
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Infant Growth Monitoring Electronic Medical Record
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Record an infant's growth measurements including weight,
                        height, head circumference, and developmental progress.
                        These measurements become part of the child's permanent
                        Electronic Medical Record for continuous health monitoring.
                    </p>

                </div>

            </div>

            <div class="lg:w-72">

                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5 text-white">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0" />

                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                Record Date
                            </p>

                            <p class="mt-1 text-sm font-semibold text-white">
                                {{ now()->format('F d, Y h:i A') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- Section 2 : Validation Error Card --}}
{{-- Place directly BELOW the Hero Header --}}
{{-- Still INSIDE the <form> --}}
{{-- ====================================== --}}

@if ($errors->any())

    <div class="mb-8 overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-red-200 bg-red-50 px-6 py-5">

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
                            d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-semibold text-red-700">
                        Unable to Save Growth Record
                    </h2>

                    <p class="mt-1 text-sm text-red-600">
                        Please review the following validation errors before submitting this growth monitoring record.
                    </p>

                </div>

            </div>

        </div>

        {{-- Body --}}
        <div class="p-6">

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                <ul class="space-y-3">

                    @foreach ($errors->all() as $error)

                        <li class="flex items-start gap-3">

                            <div class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-red-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-4 w-4 text-red-600">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"/>

                                </svg>

                            </div>

                            <span class="text-sm leading-6 text-red-700">
                                {{ $error }}
                            </span>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif

{{-- ====================================== --}}
{{-- Section 3 : Growth Monitoring Form --}}
{{-- Place directly BELOW the Validation Error Card --}}
{{-- Still INSIDE the <form> --}}
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
                        d="M3.75 12h16.5m-8.25-8.25v16.5" />

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7.5 7.5h9v9h-9z" />

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Growth Monitoring Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Record the infant's physical growth measurements for continuous health monitoring.
                </p>

            </div>

        </div>

    </div>

    {{-- Form Body --}}
    <div class="p-8">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Date Measured --}}
            <div>

                <label for="date_measured" class="mb-2 block text-sm font-semibold text-gray-700">
                    Date Measured
                </label>

                <input
                    id="date_measured"
                    type="date"
                    name="date_measured"
                    value="{{ old('date_measured') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

            </div>

            {{-- Age --}}
            <div>

                <label for="age_in_months" class="mb-2 block text-sm font-semibold text-gray-700">
                    Age (Months)
                </label>

                <input
                    id="age_in_months"
                    type="number"
                    name="age_in_months"
                    value="{{ old('age_in_months') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

            </div>

            {{-- Weight --}}
            <div>

                <label for="weight" class="mb-2 block text-sm font-semibold text-gray-700">
                    Weight (kg)
                </label>

                <input
                    id="weight"
                    type="number"
                    step="0.01"
                    name="weight"
                    value="{{ old('weight') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

            </div>

            {{-- Height --}}
            <div>

                <label for="height" class="mb-2 block text-sm font-semibold text-gray-700">
                    Height (cm)
                </label>

                <input
                    id="height"
                    type="number"
                    step="0.01"
                    name="height"
                    value="{{ old('height') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

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
                    value="{{ old('head_circumference') }}"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

            </div>

            {{-- Remarks --}}
            <div class="md:col-span-2">

                <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                    Remarks
                </label>

                <textarea
                    id="remarks"
                    name="remarks"
                    rows="5"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    placeholder="Enter additional observations or notes...">{{ old('remarks') }}</textarea>

            </div>

        </div>

    </div>

</div>


{{-- ====================================== --}}
{{-- Section 4 : Action Buttons --}}
{{-- Place directly BELOW the Growth Monitoring Form --}}
{{-- KEEP THIS INSIDE THE <form> --}}
{{-- DO NOT close </form> until AFTER this section --}}
{{-- ====================================== --}}

<div class="mt-8 flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

    {{-- Information --}}
    <div class="flex items-start gap-3 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3">

        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>

            </svg>

        </div>

        <div>

            <p class="text-sm font-semibold text-gray-900">
                Review Before Saving
            </p>

            <p class="mt-1 text-sm leading-6 text-gray-600">
                Verify all growth measurements before saving. This record will become part of the infant's permanent Electronic Medical Record and may be used for future growth assessments.
            </p>

        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row">

        {{-- Cancel --}}
        <a
            href="{{ route('infants.show', $infant) }}"
            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 hover:bg-gray-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 19.5L8.25 12l7.5-7.5"/>

            </svg>

            Cancel

        </a>

        {{-- Save Growth Record --}}
        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75m6.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>

            </svg>

            Save Growth Record

        </button>

    </div>

</div>

</form>

</div>

</div>

</div>

</x-app-layout>

                 