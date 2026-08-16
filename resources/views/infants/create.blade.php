<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Register Infant
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('infants.store', $mother) }}" method="POST" class="space-y-6 sm:space-y-8">

                @csrf

                {{-- ====================================== --}}
                {{-- Section 1 : Infant Registration Hero Card --}}
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
                                            d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                        Infant Registration
                                    </h1>

                                    <p class="mt-2 text-sm sm:text-base text-pink-100">
                                        Newborn Electronic Medical Record
                                    </p>

                                    <p class="mt-3 sm:mt-4 max-w-3xl text-sm leading-6 sm:leading-7 text-pink-100/90">
                                        Register a newborn under
                                        <span class="font-semibold text-white">{{ $mother->first_name }} {{ $mother->last_name }}</span>'s
                                        maternal record. The information entered below will become part of the
                                        infant's permanent Electronic Medical Record and will support growth
                                        monitoring, immunization tracking, and child healthcare services.
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
                                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>

                                            </svg>

                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                                Registration Date
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
                {{-- Section 2 : Mother Information Card --}}
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
                                        d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                                    Mother Information
                                </h2>

                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    The infant will automatically be linked to this maternal Electronic Medical Record.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Card Body --}}
                    <div class="p-5 sm:p-6">

                        <div class="grid grid-cols-2 gap-4 sm:gap-6 xl:grid-cols-4">

                            {{-- Mother Code --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Mother Code
                                </p>
                                <div class="mt-2 inline-flex items-center rounded-xl bg-pink-100 px-3 sm:px-4 py-2 font-mono text-xs sm:text-sm font-semibold text-pink-700">
                                    {{ $mother->mother_code }}
                                </div>
                            </div>

                            {{-- Full Name --}}
                            <div class="col-span-2 xl:col-span-1">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Full Name
                                </p>
                                <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                    {{ $mother->first_name }}
                                    {{ $mother->middle_name }}
                                    {{ $mother->last_name }}
                                </p>
                            </div>

                            {{-- Patient Type --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Patient Type
                                </p>
                                <div class="mt-2 inline-flex items-center rounded-full bg-emerald-100 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-emerald-700">
                                    Maternal Patient
                                </div>
                            </div>

                            {{-- Status --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Registration Status
                                </p>
                                <div class="mt-2 inline-flex items-center rounded-full bg-blue-100 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-blue-700">
                                    Ready
                                </div>
                            </div>

                        </div>

                        {{-- Information Notice --}}
                        <div class="mt-6 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-4 sm:px-5">

                            <div class="flex items-start gap-3">

                                <div class="mt-0.5 flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v6h-1.5V9Zm0-3h1.5v1.5h-1.5V6Zm9.75 6a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold text-gray-900">
                                        Linked Maternal Record
                                    </h3>
                                    <p class="mt-1 text-xs sm:text-sm leading-6 text-gray-600">
                                        Once the infant is registered, the newborn record will automatically be
                                        associated with this mother's profile. Growth monitoring, vaccination
                                        history, and medical records will remain connected within the CareCradle
                                        Electronic Medical Record System.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 3 : Validation Error Card --}}
                {{-- ====================================== --}}

                @if ($errors->any())

                    <div class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

                        {{-- Header --}}
                        <div class="border-b border-red-200 bg-red-50 px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-red-700">
                                        Unable to Register Infant
                                    </h2>
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">
                                        Please correct the following validation errors before submitting the infant registration.
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- Body --}}
                        <div class="p-5 sm:p-6">

                            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 sm:p-5">

                                <ul class="space-y-3">

                                    @foreach ($errors->all() as $error)

                                        <li class="flex items-start gap-3">
                                            <div class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
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
                {{-- Section 4 : Infant Registration Form --}}
                {{-- ====================================== --}}

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                                    Infant Information
                                </h2>
                                <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                    Enter the newborn's personal and birth information for the Electronic Medical Record.
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Form Body --}}
                    <div class="p-5 sm:p-8 space-y-8 sm:space-y-10">

                        {{-- -------- Group: Infant Information -------- --}}
                        <div>

                            <div class="mb-5 flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-pink-500"></span>
                                <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Infant Information</p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                                {{-- First Name --}}
                                <div>
                                    <label for="first_name" class="mb-2 block text-sm font-semibold text-gray-700">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="first_name"
                                        type="text"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        placeholder="Enter first name"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                                {{-- Middle Name --}}
                                <div>
                                    <label for="middle_name" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Middle Name
                                    </label>
                                    <input
                                        id="middle_name"
                                        type="text"
                                        name="middle_name"
                                        value="{{ old('middle_name') }}"
                                        placeholder="Enter middle name"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                </div>

                                {{-- Last Name --}}
                                <div>
                                    <label for="last_name" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="last_name"
                                        type="text"
                                        name="last_name"
                                        value="{{ old('last_name') }}"
                                        placeholder="Enter last name"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                                {{-- Sex --}}
                                <div>
                                    <label for="sex" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Sex <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="sex"
                                        name="sex"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>

                                        <option value="">Select</option>

                                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>
                                            Male
                                        </option>

                                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>

                                    </select>
                                </div>

                                {{-- Birth Date --}}
                                <div class="md:col-span-2">
                                    <label for="birth_date" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Birth Date <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="birth_date"
                                        type="date"
                                        name="birth_date"
                                        value="{{ old('birth_date') }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                            </div>

                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- -------- Group: Birth & Medical Details -------- --}}
                        <div>

                            <div class="mb-5 flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Birth &amp; Medical Details</p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2 xl:grid-cols-4">

                                {{-- Birth Status --}}
                                <div class="md:col-span-2 xl:col-span-1">
                                    <label for="birth_status" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Birth Status <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="birth_status"
                                        name="birth_status"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>

                                        <option value="">Select</option>

                                        <option value="Alive" {{ old('birth_status') == 'Alive' ? 'selected' : '' }}>
                                            Alive
                                        </option>

                                        <option value="Stillbirth" {{ old('birth_status') == 'Stillbirth' ? 'selected' : '' }}>
                                            Stillbirth
                                        </option>

                                    </select>
                                </div>

                                {{-- Birth Weight --}}
                                <div>
                                    <label for="birth_weight" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Birth Weight (kg) <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="birth_weight"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="birth_weight"
                                        value="{{ old('birth_weight') }}"
                                        placeholder="e.g. 3.2"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                                {{-- Birth Length --}}
                                <div>
                                    <label for="birth_length" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Birth Length (cm) <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="birth_length"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="birth_length"
                                        value="{{ old('birth_length') }}"
                                        placeholder="e.g. 49"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                                {{-- Head Circumference --}}
                                <div>
                                    <label for="head_circumference" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Head Circumference (cm)
                                    </label>
                                    <input
                                        id="head_circumference"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="head_circumference"
                                        value="{{ old('head_circumference') }}"
                                        placeholder="e.g. 34"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                </div>

                            </div>

                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- -------- Group: Additional Details -------- --}}
                        <div>

                            <div class="mb-5 flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Additional Details</p>
                            </div>

                            {{-- Remarks --}}
                            <div>
                                <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Remarks
                                </label>
                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="5"
                                    placeholder="Enter any additional observations or remarks..."
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm placeholder:text-gray-400 transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('remarks') }}</textarea>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- Section 5 : Action Buttons --}}
                {{-- ====================================== --}}

                <div class="flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

                    {{-- Left Note --}}
                    <div class="flex items-start gap-3 rounded-xl border border-pink-200 bg-pink-50 px-4 py-3">

                        <div class="flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                Review Before Saving
                            </p>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">
                                Verify the newborn's information before creating the Electronic Medical Record.
                            </p>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row">

                        {{-- Cancel --}}
                        <a
                            href="{{ route('mothers.show', $mother) }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 hover:bg-gray-50 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                            Cancel
                        </a>

                        {{-- Register --}}
                        <button
                            type="submit"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Register Infant
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>