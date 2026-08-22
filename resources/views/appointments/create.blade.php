<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Schedule Appointment
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ====================================== --}}
            {{-- SECTION 1: APPOINTMENT HEADER CARD --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-500 to-pink-600 px-5 py-6 sm:px-8 sm:py-8 shadow-sm">

                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-10 right-20 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 sm:h-16 sm:w-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-widest text-pink-100">
                                Scheduling For
                            </p>
                            <h1 class="mt-1 truncate text-xl font-bold text-white sm:text-2xl">
                                {{ $mother->first_name }} {{ $mother->last_name }}
                            </h1>
                            <p class="mt-1 font-mono text-xs text-pink-100/90">
                                {{ $mother->mother_code }}
                            </p>
                        </div>
                    </div>

                    @if(isset($mother->status))
                        @php
                            $statusClasses = match($mother->status) {
                                'Pregnant' => 'bg-blue-100 text-blue-700',
                                'Delivered' => 'bg-emerald-100 text-emerald-700',
                                'Referred' => 'bg-amber-100 text-amber-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <span class="inline-flex w-fit items-center rounded-full {{ $statusClasses }} px-4 py-1.5 text-sm font-semibold shadow-sm">
                            {{ $mother->status }}
                        </span>
                    @endif

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- VALIDATION ERRORS --}}
            {{-- ====================================== --}}

            @if ($errors->any())
                <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">
                    <div class="flex items-start gap-3 sm:gap-4 px-4 py-4 sm:px-6 sm:py-5">
                        <div class="flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-red-800">
                                {{ $errors->count() }} {{ Str::plural('issue', $errors->count()) }} need{{ $errors->count() === 1 ? 's' : '' }} your attention
                            </h3>
                            <ul class="mt-2 space-y-1 text-sm leading-6 text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-1.5">
                                        <span class="mt-1.5 h-1 w-1 flex-shrink-0 rounded-full bg-red-500"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ====================================== --}}
            {{-- SECTION 2: APPOINTMENT FORM --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 bg-gradient-to-r from-pink-50 via-white to-white px-5 py-5 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-bold text-gray-900">
                                Appointment Information
                            </h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Set the visit type, date, and time for this mother.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('appointments.store', $mother->id) }}" method="POST" class="p-5 sm:p-8">

                    @csrf

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Appointment Type
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <select
                                    name="appointment_type"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    <option value="">Select appointment type</option>

                                    <option value="Prenatal Checkup">
                                        Prenatal Checkup
                                    </option>

                                    <option value="Vaccination">
                                        Vaccination
                                    </option>

                                    <option value="Postpartum">
    Postpartum Checkup
</option>

                                </select>
                            </div>

                            @error('appointment_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Appointment Date
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="date"
                                    name="appointment_date"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('appointment_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Appointment Time
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="time"
                                    name="appointment_time"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('appointment_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                rows="4"
                                placeholder="Optional notes for this appointment..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100"></textarea>

                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                            Schedule Appointment
                        </button>

                        <a
                            href="{{ route('mothers.show', $mother->id) }}"
                            class="flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 active:scale-[0.98] sm:flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>
                            Back to Mother Profile
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>