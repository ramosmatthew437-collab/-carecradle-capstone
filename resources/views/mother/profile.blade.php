<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-3">
                <button
    type="button"
    onclick="window.history.back()"
    class="h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 hover:bg-pink-50 transition"
>
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
</button>
                <div>
                    <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">My profile</h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">Personal & maternal health information</p>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- PROFILE HERO --}}
            {{-- Mother Code, Age, Status shown here only --}}
            {{-- ====================================== --}}

            <div class="mt-5 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-6 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/10"></div>
                <div class="absolute -right-2 bottom-3 h-16 w-16 rounded-full bg-white/10"></div>

                <div class="relative flex items-start gap-4">

                    <div class="h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="h-8 w-8 sm:h-9 sm:w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">

                        <h2 class="text-xl sm:text-2xl font-bold">
                            {{ $mother->first_name }} {{ $mother->last_name }}
                        </h2>

                        <p class="mt-0.5 text-[13px] sm:text-sm text-pink-50">
                            {{ $mother->mother_code }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-2">

                            <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                                {{ \Carbon\Carbon::parse($mother->birth_date)->age }} years old
                            </span>

                            <span class="inline-flex items-center rounded-full bg-white text-pink-600 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                                {{ $mother->status }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- MATERNAL HEALTH --}}
            {{-- Blood Type, Height, Weight shown here only. --}}
            {{-- Due Date gets stronger visual emphasis per request. --}}
            {{-- ====================================== --}}

            <div class="mt-6">

                <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-3">
                    Maternal health
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                        <div class="h-9 w-9 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 mb-2">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"/>
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-400">Blood type</p>
                        <p class="text-[16px] sm:text-lg font-bold text-slate-900">{{ $mother->blood_type ?? 'N/A' }}</p>
                    </div>

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                        <div class="h-9 w-9 rounded-lg bg-fuchsia-50 flex items-center justify-center text-fuchsia-500 mb-2">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"/>
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-400">Height</p>
                        <p class="text-[16px] sm:text-lg font-bold text-slate-900">
                            {{ $mother->height }} <span class="text-[11px] sm:text-xs font-medium text-slate-400">cm</span>
                        </p>
                    </div>

                    <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                        <div class="h-9 w-9 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600 mb-2">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-400">Weight</p>
                        <p class="text-[16px] sm:text-lg font-bold text-slate-900">
                            {{ $mother->weight }} <span class="text-[11px] sm:text-xs font-medium text-slate-400">kg</span>
                        </p>
                    </div>

                    {{-- Due Date — emphasized: pink-tinted background, thicker border --}}
                    <div class="rounded-2xl bg-pink-50 border-2 border-pink-300 p-4 shadow-sm">
                        <div class="h-9 w-9 rounded-lg bg-pink-500 flex items-center justify-center text-white mb-2">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                            </svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold text-pink-600">Due date</p>
                        <p class="text-[14px] sm:text-lg font-bold text-pink-700">
                            {{ \Carbon\Carbon::parse($mother->expected_delivery_date)->format('M d, Y') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- PERSONAL & PREGNANCY INFO --}}
            {{-- Every remaining field shown here only --}}
            {{-- ====================================== --}}

            <div class="mt-6">

                <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-3">
                    Personal & pregnancy info
                </h3>

                <div class="rounded-2xl bg-white border border-slate-100 shadow-sm divide-y divide-slate-100">

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Contact number</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->contact_number }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Civil status</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->civil_status }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Occupation</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->occupation }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">PhilHealth no.</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->philhealth_number }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Pregnancy no.</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->pregnancy_number ?? 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Last menstrual period</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse($mother->last_menstrual_period)->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400 block mb-1">Address</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->address }}</span>
                    </div>

                    <div class="flex items-center justify-between px-4 py-3">
                        <span class="text-[12px] sm:text-sm text-slate-400">Barangay</span>
                        <span class="text-[13px] sm:text-sm font-semibold text-slate-900">{{ $mother->barangay }}</span>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- YOUR RECORDS — clickable nav cards --}}
            {{-- Same relationship queries as the original file, --}}
            {{-- just re-labeled/restyled and made into links --}}
            {{-- ====================================== --}}

            <div class="mt-6">

                <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-3">
                    Your records
                </h3>

                <div class="grid grid-cols-2 gap-3">

                    <a href="{{ route('mother.prenatal-records') }}"
                       class="block text-left rounded-2xl bg-white border border-slate-100 p-4 shadow-sm transition hover:border-pink-200">
                        <div class="h-10 w-10 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600 mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"/>
                            </svg>
                        </div>
                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">Prenatal records</p>
                        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                            {{ $mother->prenatalCheckups()->count() }} {{ Str::plural('visit', $mother->prenatalCheckups()->count()) }}
                        </p>
                    </a>

                    <a href="{{ route('mother.infant-records') }}"
                       class="block text-left rounded-2xl bg-white border border-slate-100 p-4 shadow-sm transition hover:border-pink-200">
                        <div class="h-10 w-10 rounded-lg bg-fuchsia-50 flex items-center justify-center text-fuchsia-500 mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75c-2.5 0-4.5 2-4.5 4.5v1.5H6.75A2.25 2.25 0 004.5 12v3.75A4.5 4.5 0 009 20.25h6A4.5 4.5 0 0019.5 15.75V12a2.25 2.25 0 00-2.25-2.25H16.5v-1.5c0-2.5-2-4.5-4.5-4.5Z"/>
                            </svg>
                        </div>
                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">Infant records</p>
                        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                            {{ $mother->infants()->count() }} {{ Str::plural('record', $mother->infants()->count()) }}
                        </p>
                    </a>

                    <a href="{{ route('mother.sms-history') }}"
                       class="col-span-2 block text-left rounded-2xl bg-white border border-slate-100 p-4 shadow-sm transition hover:border-pink-200">
                        <div class="h-10 w-10 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5H4.5A2.25 2.25 0 012.25 17.25V6.75A2.25 2.25 0 014.5 4.5h15A2.25 2.25 0 0121.75 6.75Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 7.5 8.291 5.527a1.25 1.25 0 001.418 0L21 7.5"/>
                            </svg>
                        </div>
                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">SMS history</p>
                        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                            {{ $mother->smsNotifications()->count() }} sent
                        </p>
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>