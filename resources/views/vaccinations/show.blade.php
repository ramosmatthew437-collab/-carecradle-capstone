<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Vaccination Record Details
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ====================================== --}}
            {{-- SECTION 1: VACCINE HERO CARD --}}
            {{-- Matches Appointment/Prenatal page hero exactly --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-500 to-pink-600 px-5 py-6 sm:px-8 sm:py-8 shadow-sm">

                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-10 right-20 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative flex items-center gap-4">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 sm:h-16 sm:w-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0018 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-100">
                            Vaccination Record
                        </p>
                        <h1 class="mt-1 truncate text-xl font-bold text-white sm:text-2xl">
                            {{ $vaccination->vaccine_name }}
                        </h1>
                        <p class="mt-1 text-xs text-pink-100/90">
                            {{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }} &middot; Dose {{ $vaccination->dose }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- SECTION 2: VACCINATION DETAILS --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 bg-gradient-to-r from-pink-50 via-white to-white px-5 py-5 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-bold text-gray-900">
                                Vaccination Information
                            </h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Details recorded for this immunization dose.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">

                    <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Infant</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ $vaccination->infant->first_name }}
                                {{ $vaccination->infant->last_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Vaccine</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ $vaccination->vaccine_name }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Dose</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ $vaccination->dose }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Date Given</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($vaccination->date_given)->format('F d, Y') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Next Due Date</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ $vaccination->next_due_date
                                    ? \Carbon\Carbon::parse($vaccination->next_due_date)->format('F d, Y')
                                    : '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Administered By</p>
                            <p class="mt-2 text-sm sm:text-base font-semibold text-gray-900">
                                {{ $vaccination->administered_by }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 3: REMARKS --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 bg-gradient-to-r from-pink-50 via-white to-white px-5 py-5 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-bold text-gray-900">
                                Remarks
                            </h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Provider notes recorded for this vaccination.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 sm:p-5">
                        <p class="text-sm sm:text-base leading-7 text-gray-700 whitespace-pre-line">
                            {{ $vaccination->remarks ?: '-' }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- ACTION BUTTONS --}}
            {{-- Matches Appointment/Prenatal page button style --}}
            {{-- ====================================== --}}

            <div class="flex flex-col gap-3 sm:flex-row">

                <a
                    href="{{ route('infants.show', $vaccination->infant) }}"
                    class="flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 active:scale-[0.98] sm:flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Infant
                </a>

                <a
                    href="{{ route('vaccinations.edit', $vaccination) }}"
                    class="flex h-12 items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 active:scale-[0.98] sm:flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 1 1 3.182 3.182L7.5 20.25 3 21l.75-4.5L16.862 4.487Z"/>
                    </svg>
                    Edit
                </a>

                <form
                    action="{{ route('vaccinations.destroy', $vaccination) }}"
                    method="POST"
                    class="sm:flex-1">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Delete this vaccination record?')"
                        class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12M9.75 7.5V6a2.25 2.25 0 012.25-2.25h0A2.25 2.25 0 0114.25 6v1.5m2.25 0v10.125A2.625 2.625 0 0113.875 20.25h-3.75A2.625 2.625 0 017.5 17.625V7.5m3 3v5.25m3-5.25v5.25"/>
                        </svg>
                        Delete
                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>