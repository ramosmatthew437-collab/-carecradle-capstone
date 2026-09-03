<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Vaccination Record
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ====================================== --}}
            {{-- SECTION: FORM CARD --}}
            {{-- Matches Appointment/Prenatal/Vaccination page structure --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 bg-gradient-to-r from-pink-50 via-white to-white px-5 py-5 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0018 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-bold text-gray-900">
                                Vaccination Details
                            </h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Update the vaccine, dose, and scheduling information for this record.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('vaccinations.update', $vaccination) }}" method="POST" class="p-5 sm:p-8">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        {{-- Vaccine --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Vaccine Name
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0018 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                    </svg>
                                </div>

                                <select name="vaccine_name"
                                        class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    @foreach([
                                        'BCG',
                                        'Hepatitis B',
                                        'Pentavalent',
                                        'OPV',
                                        'IPV',
                                        'PCV',
                                        'MMR',
                                        'Measles'
                                    ] as $vaccine)

                                        <option
                                            value="{{ $vaccine }}"
                                            {{ old('vaccine_name', $vaccination->vaccine_name) == $vaccine ? 'selected' : '' }}>

                                            {{ $vaccine }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>

                        </div>

                        {{-- Dose --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Dose
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <select name="dose"
                                        class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    @foreach([
                                        'Birth Dose',
                                        '1st Dose',
                                        '2nd Dose',
                                        '3rd Dose',
                                        'Booster'
                                    ] as $dose)

                                        <option
                                            value="{{ $dose }}"
                                            {{ old('dose', $vaccination->dose) == $dose ? 'selected' : '' }}>

                                            {{ $dose }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>

                        </div>

                        {{-- Date Given --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Date Given
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="date"
                                    name="date_given"
                                    value="{{ old('date_given', $vaccination->date_given) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                        </div>

                        {{-- Next Due --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Next Due Date
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="date"
                                    name="next_due_date"
                                    value="{{ old('next_due_date', $vaccination->next_due_date) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                        </div>

                        {{-- Administered By --}}
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Administered By
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    name="administered_by"
                                    value="{{ old('administered_by', $vaccination->administered_by) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                        </div>

                        {{-- Remarks --}}
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Remarks
                            </label>

                            <textarea
                                name="remarks"
                                rows="4"
                                placeholder="Optional notes about this vaccination..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('remarks', $vaccination->remarks) }}</textarea>

                        </div>

                    </div>

                    {{-- ====================================== --}}
                    {{-- ACTION BUTTONS --}}
                    {{-- ====================================== --}}

                    <div class="mt-8 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row">

                        <button
                            type="submit"
                            class="flex h-12 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98] sm:flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            Update Vaccination
                        </button>

                        <a
                            href="{{ route('vaccinations.show', $vaccination) }}"
                            class="flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 active:scale-[0.98] sm:flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>