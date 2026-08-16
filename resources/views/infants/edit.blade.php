<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Infant
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
                                            d="M3.75 18v-1.5A3.75 3.75 0 017.5 12.75h9A3.75 3.75 0 0120.25 16.5V18M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0Z"/>

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-100">
                                        CareCradle Infant Health Management
                                    </p>

                                    <h1 class="mt-1 truncate text-2xl sm:text-3xl font-bold tracking-tight text-white">
                                        {{ $infant->first_name }} {{ $infant->last_name }}
                                    </h1>

                                    <div class="mt-3 flex flex-wrap items-center gap-2">

                                        <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs sm:text-sm font-semibold text-white">
                                            {{ $infant->sex }}
                                        </span>

                                        <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs sm:text-sm font-semibold text-white">
                                            {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}
                                        </span>

                                    </div>

                                    <p class="mt-4 max-w-3xl text-sm leading-6 sm:leading-7 text-pink-100/90">
                                        Update the infant's demographic information, birth details, and
                                        clinical records to maintain accurate pediatric health information
                                        within the CareCradle Electronic Medical Record System.
                                    </p>

                                </div>

                            </div>

                            <div class="lg:w-80">

                                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

                                    <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                        Mother Information
                                    </p>

                                    <div class="mt-4">

                                        <h2 class="truncate text-xl sm:text-2xl font-bold text-white">
                                            {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                        </h2>

                                        <div class="mt-3">
                                            <span class="inline-flex items-center rounded-xl bg-white px-4 py-2 font-mono text-sm font-semibold text-pink-700 shadow-sm">
                                                {{ $infant->mother->mother_code }}
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z" />
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-red-700">
                                        Validation Errors
                                    </h2>
                                    <p class="mt-1 text-xs sm:text-sm text-red-600">
                                        Please correct the following information before updating the infant record.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="p-5 sm:p-6">

                            <ul class="space-y-3">

                                @foreach ($errors->all() as $error)

                                    <li class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008Zm8.25-3.75a8.25 8.25 0 11-16.5 0 8.25 8.25 0 0116.5 0Z" />
                                        </svg>
                                        <span class="text-sm text-red-700">{{ $error }}</span>
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- Section 2 : Edit Form --}}
                {{-- ====================================== --}}

                <form action="{{ route('infants.update', $infant) }}" method="POST" class="space-y-6 sm:space-y-8">

                    @csrf
                    @method('PUT')

                    {{-- -------- Card A : Basic Information -------- --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Basic Information</h2>
                                    <p class="mt-0.5 text-xs sm:text-sm text-gray-500">The infant's legal name, sex, and date of birth.</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8">

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
                                        value="{{ old('first_name', $infant->first_name) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
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
                                        value="{{ old('middle_name', $infant->middle_name) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
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
                                        value="{{ old('last_name', $infant->last_name) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                                {{-- Sex --}}
                                <div>
                                    <label for="sex" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Gender <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="sex"
                                        name="sex"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>

                                        <option value="">Select</option>

                                        <option value="Male" {{ old('sex', $infant->sex) == 'Male' ? 'selected' : '' }}>
                                            Male
                                        </option>

                                        <option value="Female" {{ old('sex', $infant->sex) == 'Female' ? 'selected' : '' }}>
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
                                        value="{{ old('birth_date', $infant->birth_date) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- -------- Card B : Birth Information -------- --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v1.5"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Birth Information</h2>
                                    <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Measurements and status recorded at birth.</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8">

                            <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2 xl:grid-cols-4">

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
                                        value="{{ old('birth_weight', $infant->birth_weight) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
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
                                        value="{{ old('birth_length', $infant->birth_length) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
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
                                        value="{{ old('head_circumference', $infant->head_circumference) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">
                                </div>

                                {{-- Birth Status --}}
                                <div>
                                    <label for="birth_status" class="mb-2 block text-sm font-semibold text-gray-700">
                                        Birth Status <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="birth_status"
                                        name="birth_status"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                        required>

                                        <option value="Alive" {{ old('birth_status', $infant->birth_status) == 'Alive' ? 'selected' : '' }}>
                                            Alive
                                        </option>

                                        <option value="Stillbirth" {{ old('birth_status', $infant->birth_status) == 'Stillbirth' ? 'selected' : '' }}>
                                            Stillbirth
                                        </option>

                                    </select>
                                </div>

                            </div>

                            {{-- Remarks --}}
                            <div class="mt-6 sm:mt-8">
                                <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Clinical Remarks
                                </label>
                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="5"
                                    placeholder="Enter any additional observations or remarks..."
                                    class="w-full rounded-2xl border border-gray-300 bg-white px-4 py-4 text-sm leading-7 text-gray-700 placeholder:text-gray-400 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">{{ old('remarks', $infant->remarks) }}</textarea>
                            </div>

                        </div>

                    </div>

                    {{-- -------- Card C : Family Information (read-only) -------- --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                        <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Zm9 0v.01M6 12v.01"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Family Information</h2>
                                    <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Linked maternal record for this infant.</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-8">

                            <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2">

                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Name</p>
                                    <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900 break-words">
                                        {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Mother Code</p>
                                    <p class="mt-2 font-mono text-sm sm:text-base font-semibold text-pink-700">
                                        {{ $infant->mother->mother_code }}
                                    </p>
                                </div>

                            </div>

                            <p class="mt-4 text-xs text-gray-400">
                                This infant's maternal record is set during registration and can't be changed from this form.
                            </p>

                        </div>

                    </div>

                    {{-- ====================================== --}}
                    {{-- Section 3 : Action Buttons --}}
                    {{-- ====================================== --}}

                    <div class="flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Information --}}
                        <div class="flex items-start gap-4 rounded-2xl border border-pink-200 bg-pink-50 px-5 py-4">

                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-gray-900">Infant Record Update</p>
                                <p class="mt-1 text-xs sm:text-sm leading-6 text-gray-600">
                                    Review all infant information carefully before saving. Updates will
                                    be reflected throughout the CareCradle Electronic Medical Record System.
                                </p>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="flex flex-col gap-3 sm:flex-row">

                            {{-- Cancel --}}
                            <a
                                href="{{ route('infants.show', $infant) }}"
                                class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                </svg>
                                Cancel
                            </a>

                            {{-- Update --}}
                            <button
                                type="submit"
                                class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75H6.75A2.25 2.25 0 004.5 6v12A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V6.75A3 3 0 0016.5 3.75Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75v4.5h6v-4.5"/>
                                </svg>
                                Save Changes
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>