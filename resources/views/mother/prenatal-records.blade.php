<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="max-w-2xl lg:max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-3">

    <!-- Back Button -->
    <button
        type="button"
        onclick="history.back()"
        class="h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 hover:bg-pink-50 transition">

        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>

    </button>

    <div>
        <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">
            Prenatal records
        </h1>
        <p class="text-[12px] sm:text-sm text-slate-500">
            Checkup history & monitoring
        </p>
    </div>

</div>

            @if($prenatalRecords->count())

                @php
                    // Non-diagnostic status cue, presentation-layer only —
                    // derived from existing systolic_bp / diastolic_bp / fetal_heart_rate
                    // values already present on each record. No new columns, no schema changes.
                    $prenatalStatus = function ($systolic, $diastolic, $fhr) {
                        $needsFollowUp = $systolic >= 140 || $diastolic >= 90 || $fhr < 110 || $fhr > 170;
                        $monitor = $systolic >= 130 || $diastolic >= 85 || $fhr < 120 || $fhr > 160;

                        if ($needsFollowUp) {
                            return ['label' => 'Needs follow-up', 'dot' => 'bg-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'];
                        }

                        if ($monitor) {
                            return ['label' => 'Monitor', 'dot' => 'bg-amber-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700'];
                        }

                        return ['label' => 'Normal', 'dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'];
                    };

                    // "Latest visit" is the first record on the current page.
                    // Assumes the controller orders $prenatalRecords by visit_date descending
                    // (as the original table view implied). Not modifying the query/controller here.
                    $latestVisit = $prenatalRecords->first();
                    $earlierVisits = $prenatalRecords->skip(1);
                    $latestStatus = $prenatalStatus($latestVisit->systolic_bp, $latestVisit->diastolic_bp, $latestVisit->fetal_heart_rate);
                @endphp

                {{-- ====================================== --}}
                {{-- LATEST VISIT (hero) --}}
                {{-- ====================================== --}}

                <div class="mt-5 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-6 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/10"></div>
                    <div class="absolute -right-2 bottom-3 h-16 w-16 rounded-full bg-white/10"></div>

                    <div class="relative flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"/>
                        </svg>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-pink-50">Latest visit</p>
                    </div>

                    <h2 class="relative mt-2 text-lg sm:text-xl font-bold">
                        {{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('F d, Y') }}
                    </h2>

                    <p class="relative mt-0.5 text-[13px] sm:text-sm text-pink-50">
                        Week {{ $latestVisit->gestational_age_weeks }}
                    </p>

                    {{-- Key metrics: gestational age prioritized alongside weight & BP --}}
                    <div class="relative mt-4 grid grid-cols-2 sm:grid-cols-4 gap-2">

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Gestational age</p>
                            <p class="text-[14px] sm:text-base font-bold">{{ $latestVisit->gestational_age_weeks }} wks</p>
                        </div>

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Weight</p>
                            <p class="text-[14px] sm:text-base font-bold">{{ $latestVisit->weight }} kg</p>
                        </div>

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Blood pressure</p>
                            <p class="text-[14px] sm:text-base font-bold">{{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}</p>
                        </div>

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Fetal heart rate</p>
                            <p class="text-[14px] sm:text-base font-bold">{{ $latestVisit->fetal_heart_rate }} bpm</p>
                        </div>

                    </div>

                    <div class="relative mt-3 inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                        <span class="h-1.5 w-1.5 rounded-full {{ $latestStatus['dot'] }}"></span>
                        {{ $latestStatus['label'] }}
                    </div>

                    <div class="relative mt-4 flex items-center justify-between rounded-xl bg-white/10 px-3 py-2.5 sm:px-4 sm:py-3">
                        <div>
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Next visit</p>
                            <p class="text-[13px] sm:text-sm font-semibold">
                                {{ \Carbon\Carbon::parse($latestVisit->next_visit_date)->format('F d, Y') }}
                            </p>
                        </div>
                        {{-- Decorative for now — will open the full prenatal visit record later --}}
                        <button type="button" class="tap-scale inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 sm:px-4 sm:py-2 text-[12px] sm:text-[13px] font-semibold text-pink-600">
                            Details
                            <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- VISIT HISTORY --}}
                {{-- Same $prenatalRecords data, remaining records after the latest --}}
                {{-- ====================================== --}}

                @if($earlierVisits->count())

                    <div class="mt-6">

                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-[14px] sm:text-base font-bold text-slate-900">Visit history</h3>
                            <p class="text-[12px] sm:text-sm text-slate-400">
                                {{ $earlierVisits->count() }} {{ Str::plural('earlier visit', $earlierVisits->count()) }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">

                            @foreach($earlierVisits as $record)

                                @php
                                    $status = $prenatalStatus($record->systolic_bp, $record->diastolic_bp, $record->fetal_heart_rate);
                                @endphp

                                <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">

                                    <div class="flex items-baseline justify-between mb-2">
                                        <p class="text-[14px] sm:text-[15px] font-bold text-slate-900">
                                            {{ \Carbon\Carbon::parse($record->visit_date)->format('F d, Y') }}
                                        </p>
                                        <p class="text-[11px] sm:text-xs text-slate-400">
                                            Week {{ $record->gestational_age_weeks }}
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2 mb-2">

                                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                                            <p class="text-[9px] sm:text-[10px] text-slate-400">Gest. age</p>
                                            <p class="text-[12px] sm:text-[13px] font-semibold text-slate-900">{{ $record->gestational_age_weeks }} wks</p>
                                        </div>

                                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                                            <p class="text-[9px] sm:text-[10px] text-slate-400">Weight</p>
                                            <p class="text-[12px] sm:text-[13px] font-semibold text-slate-900">{{ $record->weight }} kg</p>
                                        </div>

                                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                                            <p class="text-[9px] sm:text-[10px] text-slate-400">BP</p>
                                            <p class="text-[12px] sm:text-[13px] font-semibold text-slate-900">{{ $record->systolic_bp }}/{{ $record->diastolic_bp }}</p>
                                        </div>

                                        <div class="rounded-lg bg-slate-50 px-2 py-2 text-center">
                                            <p class="text-[9px] sm:text-[10px] text-slate-400">FHR</p>
                                            <p class="text-[12px] sm:text-[13px] font-semibold text-slate-900">{{ $record->fetal_heart_rate }}</p>
                                        </div>

                                    </div>

                                    <div class="inline-flex items-center gap-1.5 rounded-full {{ $status['bg'] }} px-2.5 py-1 text-[11px] sm:text-xs font-semibold {{ $status['text'] }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $status['label'] }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

                {{-- ====================================== --}}
                {{-- PAGINATION --}}
                {{-- Same $prenatalRecords->links(), restyled --}}
                {{-- ====================================== --}}

                <div class="mt-6">
                    {{ $prenatalRecords->links() }}
                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO PRENATAL RECORDS — same empty state as original --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border border-pink-100 p-10 sm:p-12 text-center shadow-sm">

                    <div class="text-5xl sm:text-6xl">
                        🤰
                    </div>

                    <h3 class="mt-4 text-lg sm:text-xl font-bold text-slate-900">
                        No prenatal records
                    </h3>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500">
                        No prenatal checkup records found.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>