<x-app-layout>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">
        <div class="max-w-2xl lg:max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 sm:space-y-6">

            {{-- ====================================== --}}
            {{-- 1. PROFILE HERO CARD --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-8 text-white shadow-md shadow-pink-200">

                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10"></div>
                <div class="pointer-events-none absolute -bottom-10 right-16 h-24 w-24 rounded-full bg-white/10"></div>

                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 items-center justify-center rounded-2xl bg-white/20 text-2xl sm:text-3xl font-bold text-white backdrop-blur-sm">
                            {{ strtoupper(substr($mother->first_name, 0, 1) . substr($mother->last_name, 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-widest text-pink-100">
                                My Profile
                            </p>
                            <h1 class="mt-1 text-xl sm:text-3xl font-bold tracking-tight truncate">
                                {{ $mother->first_name }} {{ $mother->last_name }}
                            </h1>

                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                @if(isset($mother->mother_code))
                                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 font-mono text-[11px] sm:text-xs font-semibold text-white backdrop-blur-sm">
                                        {{ $mother->mother_code }}
                                    </span>
                                @endif

                                @if(isset($mother->birth_date))
                                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-[11px] sm:text-xs font-semibold text-white backdrop-blur-sm">
                                        {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                                    </span>
                                @endif

                                @if(isset($mother->status))
                                    <span class="inline-flex items-center rounded-full bg-white px-3 py-1 text-[11px] sm:text-xs font-semibold text-pink-600">
                                        {{ $mother->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 2. PERSONAL INFORMATION --}}
            {{-- ====================================== --}}

            <div>
                <p class="mb-3 px-1 text-[12px] sm:text-sm font-semibold uppercase tracking-wide text-slate-400">
                    Personal Information
                </p>

                <div class="rounded-2xl bg-white border border-slate-100 shadow-sm divide-y divide-slate-100">

                    {{-- Full Name --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Full Name</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900 truncate">
                                {{ trim(($mother->first_name ?? '') . ' ' . ($mother->middle_name ?? '') . ' ' . ($mother->last_name ?? '')) ?: '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Date of Birth --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-fuchsia-50 text-fuchsia-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Date of Birth</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ isset($mother->birth_date) ? \Carbon\Carbon::parse($mother->birth_date)->format('F d, Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Age --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Age</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ isset($mother->birth_date) ? \Carbon\Carbon::parse($mother->birth_date)->age . ' years old' : '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Contact Number --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Contact Number</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ $mother->contact_number ?? '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-fuchsia-50 text-fuchsia-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Address</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900 break-words">
                                {{ trim(($mother->address ?? '') . (isset($mother->barangay) ? ', ' . $mother->barangay : '')) ?: '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Civil Status --}}
                    <div class="flex items-center gap-3 p-4 sm:p-5">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5V12a1.5 1.5 0 011.5-1.5z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] text-slate-400">Civil Status</p>
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ $mother->civil_status ?? '—' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- 3. MATERNAL INFORMATION --}}
            {{-- ====================================== --}}

            <div>
                <p class="mb-3 px-1 text-[12px] sm:text-sm font-semibold uppercase tracking-wide text-slate-400">
                    Maternal Information
                </p>

                <div class="rounded-2xl bg-white border border-slate-100 shadow-sm p-4 sm:p-5">

                    <div class="grid grid-cols-2 gap-3 sm:gap-4">

                        @if(isset($mother->pregnancy_week))
                            <div class="rounded-xl bg-pink-50 p-3 sm:p-4">
                                <p class="text-[11px] text-pink-600 font-medium">Pregnancy Week</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-slate-900">Week {{ $mother->pregnancy_week }}</p>
                            </div>
                        @endif

                        @if(isset($mother->trimester))
                            <div class="rounded-xl bg-fuchsia-50 p-3 sm:p-4">
                                <p class="text-[11px] text-fuchsia-600 font-medium">Trimester</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-slate-900">{{ $mother->trimester }}</p>
                            </div>
                        @endif

                        @if(isset($mother->expected_delivery_date))
                            <div class="rounded-xl bg-rose-50 p-3 sm:p-4">
                                <p class="text-[11px] text-rose-600 font-medium">Expected Delivery</p>
                                <p class="mt-1 text-[13px] sm:text-base font-bold text-slate-900">
                                    {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('M d, Y') }}
                                </p>
                            </div>
                        @endif

                        @if(isset($mother->blood_type))
                            <div class="rounded-xl bg-slate-50 p-3 sm:p-4">
                                <p class="text-[11px] text-slate-500 font-medium">Blood Type</p>
                                <p class="mt-1 text-lg sm:text-xl font-bold text-slate-900">{{ $mother->blood_type }}</p>
                            </div>
                        @endif

                        {{-- Risk Status — field not confirmed on the Mother model; guarded so it simply --}}
                        {{-- doesn't render if it doesn't exist, rather than assuming a field name. --}}
                        @if(isset($mother->risk_status))
                            @php
                                $riskClasses = match($mother->risk_status) {
                                    'High Risk' => 'bg-red-50 text-red-600',
                                    'Moderate Risk' => 'bg-amber-50 text-amber-600',
                                    default => 'bg-emerald-50 text-emerald-600',
                                };
                            @endphp
                            <div class="rounded-xl {{ $riskClasses }} p-3 sm:p-4 col-span-2">
                                <p class="text-[11px] font-medium opacity-80">Risk Status</p>
                                <p class="mt-1 text-[13px] sm:text-base font-bold">{{ $mother->risk_status }}</p>
                            </div>
                        @endif

                    </div>

                    @if(!isset($mother->pregnancy_week) && !isset($mother->trimester) && !isset($mother->expected_delivery_date) && !isset($mother->blood_type))
                        <p class="py-4 text-center text-[13px] text-slate-400">
                            No maternal information on file yet.
                        </p>
                    @endif

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- 4. EMERGENCY CONTACT --}}
            {{-- Field not confirmed on the Mother model — guarded so it doesn't --}}
            {{-- render (or breaks) if it doesn't exist. --}}
            {{-- ====================================== --}}

            @if(isset($mother->emergency_contact_name) || isset($mother->emergency_contact_number))
                <div>
                    <p class="mb-3 px-1 text-[12px] sm:text-sm font-semibold uppercase tracking-wide text-slate-400">
                        Emergency Contact
                    </p>

                    <div class="rounded-2xl bg-red-50 border border-red-100 p-4 sm:p-5 flex items-center gap-4">

                        <div class="flex h-11 w-11 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25A2.25 2.25 0 0021.75 19.5v-1.372a1.125 1.125 0 00-.853-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a13.5 13.5 0 01-6.24-6.24l1.293-.97a1.125 1.125 0 00.417-1.173L8.713 3.853A1.125 1.125 0 007.622 3H6.25A2.25 2.25 0 004 5.25v1.5Z"/>
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                {{ $mother->emergency_contact_name ?? '—' }}
                            </p>
                            <p class="text-[12px] sm:text-[13px] text-red-600">
                                {{ $mother->emergency_contact_number ?? '—' }}
                            </p>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>

</x-app-layout>