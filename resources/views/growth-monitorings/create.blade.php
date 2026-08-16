<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Add Growth Record
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('growth-monitorings.store', $infant) }}" method="POST" class="space-y-6 sm:space-y-8">

                @csrf

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
                                            d="M3.75 12h16.5m-8.25-8.25v16.5" />

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7.5 7.5h9v9h-9z" />

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                                        New Growth Record
                                    </span>

                                    <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                        Growth Monitoring Record
                                    </h1>

                                    <p class="mt-2 text-sm sm:text-base text-pink-100">
                                        for <span class="font-semibold text-white">{{ $infant->first_name }} {{ $infant->last_name }}</span>
                                        · Mother: <span class="font-semibold text-white">{{ $infant->mother->first_name }} {{ $infant->mother->last_name }}</span>
                                    </p>

                                    <p class="mt-3 sm:mt-4 max-w-3xl text-sm leading-6 sm:leading-7 text-pink-100/90">
                                        Record the infant's growth measurements including weight, height,
                                        head circumference, and developmental progress. These measurements
                                        become part of the child's permanent Electronic Medical Record.
                                    </p>

                                </div>

                            </div>

                            <div class="lg:w-72">

                                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">

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

                                        <div class="min-w-0">

                                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                                Record Date
                                            </p>

                                            <p class="mt-1 truncate text-sm font-semibold text-white">
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
                {{-- ====================================== --}}

                @if ($errors->any())

                    <div class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

                        <div class="border-b border-red-200 bg-red-50 px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-red-700">
                                        Unable to Save Growth Record
                                    </h2>
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">
                                        Please review the following validation errors before submitting this growth monitoring record.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="p-5 sm:p-6">

                            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 sm:p-5">

                                <ul class="space-y-3">

                                    @foreach ($errors->all() as $error)

                                        <li class="flex items-start gap-3">
                                            <div class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
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
                {{-- CARD C : Patient Information (Read Only) --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"/>
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
                                    {{ $infant->first_name }} {{ $infant->last_name }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Infant Code</p>
                                <p class="mt-2 font-mono text-sm sm:text-base font-semibold text-gray-900">
                                    {{ $infant->infant_code ?? '-' }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Name</p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                    {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Birth Date</p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($infant->birth_date)->format('F d, Y') }}
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-8.25-8.25v16.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h9v9h-9z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Measurement Information</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Enter the infant's physical growth measurements for this visit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8">

                        <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                            {{-- Date Measured --}}
                            <div>
                                <label for="date_measured" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Measurement Date <span class="text-red-500">*</span>
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
                                        value="{{ old('date_measured') }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-4 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
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
                                    value="{{ old('age_in_months') }}"
                                    placeholder="e.g. 3"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                    required>
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
                                    value="{{ old('weight') }}"
                                    placeholder="e.g. 4.5"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                    required>
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
                                    value="{{ old('height') }}"
                                    placeholder="e.g. 58"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
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
                                    placeholder="e.g. 40"
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 3 : Clinical Notes --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 2.25v4.875a1.125 1.125 0 001.125 1.125H19.5"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Clinical Notes</h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Additional observations or remarks about this growth assessment.
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
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-4 text-sm leading-7 shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                            placeholder="Enter additional observations or notes...">{{ old('remarks') }}</textarea>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 4 : Action Buttons --}}
                {{-- ====================================== --}}

                <div class="flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Information --}}
                    <div class="flex items-start gap-3 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3">

                        <div class="flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900">Review Before Saving</p>
                            <p class="mt-1 text-xs sm:text-sm leading-6 text-gray-600">
                                Verify all growth measurements before saving. This record will become part of the
                                infant's permanent Electronic Medical Record and may be used for future growth assessments.
                            </p>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row">

                        {{-- Cancel --}}
                        <a
                            href="{{ route('infants.show', $infant) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 hover:bg-gray-50 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            Cancel
                        </a>

                        {{-- Save Growth Record --}}
                        <button
                            type="submit"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6.75-2.25a9 9 0 11-18 0 9 9 0 0118 0"/>
                            </svg>
                            Save Growth Record
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>