<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Add Prenatal Visit
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ====================================== --}}
            {{-- SECTION 1: PATIENT HEADER CARD --}}
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
                                Prenatal Visit For
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
            {{-- SECTION 2: PRENATAL VISIT FORM --}}
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
                                Prenatal Visit Information
                            </h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Record maternal assessment, vital signs, and laboratory findings for this visit.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('prenatal-checkups.store', $mother->id) }}" method="POST" class="p-5 sm:p-8">

                    @csrf

                    {{-- Visit Information --}}
                    <h3 class="text-sm font-bold uppercase tracking-wide text-pink-600 mb-4">
                        Visit Information
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Visit Date
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="date"
                                    name="visit_date"
                                    value="{{ old('visit_date') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('visit_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Gestational Age (Weeks)
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    name="gestational_age_weeks"
                                    value="{{ old('gestational_age_weeks') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('gestational_age_weeks')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="my-8 border-t border-gray-100"></div>

                    {{-- Maternal Assessment --}}
                    <h3 class="text-sm font-bold uppercase tracking-wide text-pink-600 mb-4">
                        Maternal Assessment
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Weight (kg)
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="weight"
                                    value="{{ old('weight') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('weight')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Fundal Height (cm)
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="fundal_height"
                                    value="{{ old('fundal_height') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('fundal_height')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Systolic Blood Pressure
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    name="systolic_bp"
                                    value="{{ old('systolic_bp') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('systolic_bp')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Diastolic Blood Pressure
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    name="diastolic_bp"
                                    value="{{ old('diastolic_bp') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('diastolic_bp')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Fetal Heart Rate (bpm)
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="number"
                                    name="fetal_heart_rate"
                                    value="{{ old('fetal_heart_rate') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('fetal_heart_rate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Fetal Movement
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                    </svg>
                                </div>

                                <select
                                    name="fetal_movement"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    <option value="" {{ old('fetal_movement') == '' ? 'selected' : '' }}>Select</option>
                                    <option value="Normal" {{ old('fetal_movement') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="Reduced" {{ old('fetal_movement') == 'Reduced' ? 'selected' : '' }}>Reduced</option>
                                    <option value="Not Yet Felt" {{ old('fetal_movement') == 'Not Yet Felt' ? 'selected' : '' }}>Not Yet Felt</option>

                                </select>
                            </div>

                            @error('fetal_movement')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="my-8 border-t border-gray-100"></div>

                    {{-- Laboratory Findings --}}
                    <h3 class="text-sm font-bold uppercase tracking-wide text-pink-600 mb-4">
                        Laboratory Findings
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Urine Protein
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                                    </svg>
                                </div>

                                <select
                                    name="urine_protein"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    <option value="" {{ old('urine_protein') == '' ? 'selected' : '' }}>Select</option>
                                    <option value="Negative" {{ old('urine_protein') == 'Negative' ? 'selected' : '' }}>Negative</option>
                                    <option value="Trace" {{ old('urine_protein') == 'Trace' ? 'selected' : '' }}>Trace</option>
                                    <option value="+1" {{ old('urine_protein') == '+1' ? 'selected' : '' }}>+1</option>
                                    <option value="+2" {{ old('urine_protein') == '+2' ? 'selected' : '' }}>+2</option>
                                    <option value="+3" {{ old('urine_protein') == '+3' ? 'selected' : '' }}>+3</option>

                                </select>
                            </div>

                            @error('urine_protein')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Urine Glucose
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                                    </svg>
                                </div>

                                <select
                                    name="urine_glucose"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                                    <option value="" {{ old('urine_glucose') == '' ? 'selected' : '' }}>Select</option>
                                    <option value="Negative" {{ old('urine_glucose') == 'Negative' ? 'selected' : '' }}>Negative</option>
                                    <option value="Trace" {{ old('urine_glucose') == 'Trace' ? 'selected' : '' }}>Trace</option>
                                    <option value="+1" {{ old('urine_glucose') == '+1' ? 'selected' : '' }}>+1</option>
                                    <option value="+2" {{ old('urine_glucose') == '+2' ? 'selected' : '' }}>+2</option>
                                    <option value="+3" {{ old('urine_glucose') == '+3' ? 'selected' : '' }}>+3</option>

                                </select>
                            </div>

                            @error('urine_glucose')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="my-8 border-t border-gray-100"></div>

                    {{-- Notes & Follow-up --}}
                    <h3 class="text-sm font-bold uppercase tracking-wide text-pink-600 mb-4">
                        Notes & Follow-up
                    </h3>

                    <div class="grid grid-cols-1 gap-5 sm:gap-6">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Maternal Condition
                            </label>

                            <textarea
                                name="maternal_condition"
                                rows="4"
                                placeholder="Describe the mother's current condition..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('maternal_condition') }}</textarea>

                            @error('maternal_condition')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                rows="4"
                                placeholder="Optional notes for this visit..."
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:w-1/2">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Next Visit Date
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="date"
                                    name="next_visit_date"
                                    value="{{ old('next_visit_date') }}"
                                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            </div>

                            @error('next_visit_date')
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            Save Prenatal Visit
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