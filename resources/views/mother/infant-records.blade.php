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
                <button
                    onclick="history.back()"
                    type="button"
                    aria-label="Go back"
                    class="h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 shadow-sm transition hover:bg-pink-50 hover:text-pink-600 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-300">

                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>

                </button>
                <div>
                    <h1 class="text-[20px] sm:text-2xl font-bold text-slate-900 leading-tight">Infant records</h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">View your baby's health information</p>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- INFANT SELECTOR --}}
            {{-- Same GET form / onchange submit as before --}}
            {{-- ====================================== --}}

            @if($infants->count())

                <div class="mt-5 rounded-2xl bg-white border border-pink-100 shadow-sm shadow-pink-100/50 overflow-hidden">

                    <form method="GET">

                        <div class="relative flex items-center gap-3 px-4 py-3.5">

                            <div class="h-9 w-9 flex-shrink-0 rounded-full bg-pink-50 flex items-center justify-center text-pink-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-pink-500 leading-none mb-1">
                                    {{ $infants->count() > 1 ? 'Select infant' : 'Your infant' }}
                                </p>

                               <select
    name="infant"
    onchange="this.form.submit()"
    {{ $infants->count() <= 1 ? 'disabled' : '' }}
    aria-label="{{ $infants->count() > 1 ? 'Select infant' : 'Your infant' }}"
    style="-webkit-appearance: none !important; -moz-appearance: none !important; appearance: none !important; background-image: none !important;"
    class="w-full appearance-none bg-transparent border-0 outline-none ring-0 pr-6 text-[15px] font-bold text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-300 rounded-lg disabled:opacity-100 [&::-ms-expand]:hidden">

    @foreach($infants as $infant)

        <option
            value="{{ $infant->id }}"
            {{ $selectedInfant && $selectedInfant->id == $infant->id ? 'selected' : '' }}>

            {{ $infant->first_name }}
            {{ $infant->last_name }}

        </option>

    @endforeach

</select>
                            </div>

                            @if($infants->count() > 1)
                                <svg class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            @endif

                        </div>

                    </form>

                </div>

            @endif

            @if($selectedInfant)
@php
    $birthDate = \Carbon\Carbon::parse($selectedInfant->birth_date);

    $days = (int) $birthDate->diffInDays(now());
$months = (int) $birthDate->diffInMonths(now());
$years = (int) $birthDate->diffInYears(now());

    if ($days < 30) {
        $ageLabel = $days . ' days old';
    } elseif ($months < 24) {
        $ageLabel = $months . ' month' . ($months == 1 ? '' : 's') . ' old';
    } else {
        $ageLabel = $years . ' year' . ($years == 1 ? '' : 's') . ' old';
    }

    $latestGrowth = $growthRecords->count()
        ? $growthRecords->sortByDesc('date_measured')->first()
        : null;

    $currentWeight = $latestGrowth->weight ?? $selectedInfant->birth_weight;
    $currentHeight = $latestGrowth->height ?? $selectedInfant->birth_length;
    $currentHeadCircumference =
    $latestGrowth->head_circumference
    ?? $selectedInfant->head_circumference;

    $genderKey = strtolower($selectedInfant->sex ?? '');

    $genderTheme = match($genderKey) {
        'female' => [
            'gradient' => 'from-pink-500 via-pink-500 to-rose-600',
            'soft'     => 'bg-pink-50',
            'text'     => 'text-pink-600',
            'border'   => 'border-pink-100',
        ],
        'male' => [
            'gradient' => 'from-sky-500 via-sky-500 to-blue-600',
            'soft'     => 'bg-sky-50',
            'text'     => 'text-sky-600',
            'border'   => 'border-sky-100',
        ],
        default => [
            'gradient' => 'from-slate-400 via-slate-400 to-slate-500',
            'soft'     => 'bg-slate-50',
            'text'     => 'text-slate-600',
            'border'   => 'border-slate-200',
        ],
    };

    $genderEmoji = match($genderKey) {
        'female' => '👧',
        'male'   => '👦',
        default  => '🧒',
    };
@endphp

                {{-- ====================================== --}}
                {{-- HERO: INFANT PROFILE CARD --}}
                {{-- ====================================== --}}

                <div class="mt-5 rounded-3xl bg-gradient-to-br {{ $genderTheme['gradient'] }} p-5 sm:p-7 text-white shadow-lg shadow-pink-200 relative overflow-hidden">

                    <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-white/10" aria-hidden="true"></div>
                    <div class="absolute -right-4 bottom-4 h-20 w-20 rounded-full bg-white/10" aria-hidden="true"></div>
                    <div class="absolute left-1/3 -bottom-10 h-24 w-24 rounded-full bg-white/5" aria-hidden="true"></div>

                    <div class="relative flex items-start gap-4">

                        <div class="h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 rounded-2xl bg-white/20 ring-1 ring-white/30 flex items-center justify-center text-3xl sm:text-4xl"
                             role="img"
                             aria-label="{{ $selectedInfant->sex ?? 'Infant' }}">
                            {{ $genderEmoji }}
                        </div>

                        <div class="flex-1 min-w-0">

                            <h2 class="text-xl sm:text-2xl font-bold truncate">
                                {{ $selectedInfant->first_name }}
                                {{ $selectedInfant->middle_name }}
                                {{ $selectedInfant->last_name }}
                            </h2>

                            <p class="mt-1 text-[13px] sm:text-sm text-pink-50">
                                Born {{ $birthDate->format('F d, Y') }}
                            </p>

                            <div class="flex flex-wrap items-center gap-2 mt-3">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1.5 text-[12px] sm:text-[13px] font-semibold">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                                        <circle cx="12" cy="12" r="9"/>
                                    </svg>
                                    {{ $ageLabel }}
                                </span>

                                <span class="inline-flex items-center gap-1 rounded-full bg-white {{ $genderTheme['text'] }} px-3 py-1.5 text-[12px] sm:text-[13px] font-bold shadow-sm">
                                    {{ $selectedInfant->sex ?? 'Not set' }}
                                </span>

                                <span class="inline-flex items-center gap-1 rounded-full bg-white/20 px-3 py-1.5 text-[12px] sm:text-[13px] font-semibold">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                    {{ $selectedInfant->birth_status ?? 'Growth on track' }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- GROWTH SUMMARY STAT CARDS --}}
                {{-- Age intentionally omitted here — shown once, in the hero pill above --}}
                {{-- ====================================== --}}

                <div class="mt-6">

                    <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-3 px-0.5">
                        Growth summary
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">

                        {{-- Weight --}}
                        <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-400 font-medium">Weight</p>
                            @if($currentWeight)
                                <p class="text-[19px] sm:text-2xl font-bold text-slate-900 mt-0.5">
                                    {{ $currentWeight }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">kg</span>
                                </p>
                            @else
                                <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">Not recorded</p>
                            @endif
                        </div>

                        {{-- Height --}}
                        <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-xl bg-fuchsia-50 flex items-center justify-center text-fuchsia-500 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-400 font-medium">Height</p>
                            @if($currentHeight)
                                <p class="text-[19px] sm:text-2xl font-bold text-slate-900 mt-0.5">
                                    {{ $currentHeight }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">cm</span>
                                </p>
                            @else
                                <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">Not recorded</p>
                            @endif
                        </div>

                        {{-- Head Circumference --}}
                        <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <circle cx="12" cy="12" r="8"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-400 font-medium">Head circumference</p>
                            @if($selectedInfant && $selectedInfant->head_circumference)
                                <p class="text-[19px] sm:text-2xl font-bold text-slate-900 mt-0.5">
                                    {{ $selectedInfant->head_circumference }}
                                    <span class="text-[12px] sm:text-sm font-medium text-slate-400">cm</span>
                                </p>
                            @else
                                <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">Not recorded</p>
                            @endif
                        </div>

                        {{-- Vaccinations --}}
                        <div class="rounded-2xl bg-white border border-slate-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-xl bg-sky-50 flex items-center justify-center text-sky-500 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-400 font-medium">Vaccinations</p>
                            <p class="text-[19px] sm:text-2xl font-bold text-slate-900 mt-0.5">
                                {{ $vaccinations->count() }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">recorded</span>
                            </p>
                        </div>

                        {{-- Growth Status --}}
                        <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                            <div class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 mb-3">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>
                            <p class="text-[11px] sm:text-xs text-emerald-700/70 font-medium">Growth status</p>
                            <p class="text-[15px] sm:text-lg font-bold text-emerald-700 mt-1">
                                {{ $selectedInfant->birth_status ?? 'On track' }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- INFANT INFORMATION CARD --}}
                {{-- Reduced to non-duplicate identity facts only. --}}
                {{-- Age, Gender, Weight, and Height already appear --}}
                {{-- above (hero pills / growth summary) and are not repeated here. --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border {{ $genderTheme['border'] }} p-5 sm:p-6 shadow-sm">

                    <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-4">
                        Infant information
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">

                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-pink-50 flex items-center justify-center text-pink-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-medium">Full name</p>
                                <p class="text-[13px] sm:text-sm font-semibold text-slate-900 truncate">
                                    {{ $selectedInfant->first_name }}
                                    {{ $selectedInfant->middle_name }}
                                    {{ $selectedInfant->last_name }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0V11.25A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-medium">Birth date</p>
                                <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                    {{ $birthDate->format('F d, Y') }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

                                {{-- ====================================== --}}
                {{-- VACCINATION TIMELINE --}}
                {{-- Same $vaccinations data — already scoped to $selectedInfant --}}
                {{-- via Infant::vaccinations(). See controller note if not yet scoped. --}}
                {{-- ====================================== --}}

                @php
                    // Non-diagnostic status cue, presentation-layer only — derived from the
                    // existing next_due_date column already present on each record.
                    // No new columns, no schema changes. "Due Soon" uses a 30-day window,
                    // a presentation assumption only (no such threshold exists in the schema).
                    $vaccinationStatus = function ($nextDueDate) {
                        if (!$nextDueDate) {
                            return ['label' => 'Completed', 'dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'];
                        }

                        $due = \Carbon\Carbon::parse($nextDueDate);
                        $daysRemaining = now()->startOfDay()->diffInDays($due->copy()->startOfDay(), false);

                        if ($daysRemaining < 0) {
                            return ['label' => 'Overdue', 'dot' => 'bg-rose-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'];
                        }

                        if ($daysRemaining <= 30) {
                            return ['label' => 'Due Soon', 'dot' => 'bg-amber-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700'];
                        }

                        return ['label' => 'Completed', 'dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'];
                    };
                @endphp

                <div class="mt-6 rounded-2xl bg-white border-2 border-pink-200 p-4 sm:p-6 shadow-sm">

                    <div class="flex items-center justify-between mb-4 sm:mb-5">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                </svg>
                            </div>
                            <h3 class="text-[15px] sm:text-lg font-bold text-slate-900">
                                Vaccination timeline
                            </h3>
                        </div>
                        <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-600">
                            {{ $vaccinations->count() }} {{ Str::plural('dose', $vaccinations->count()) }}
                        </span>
                    </div>

                    @if($vaccinations->count())

                        <div class="space-y-3 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-3">

                            @foreach($vaccinations as $vaccine)

                                @php
                                    $status = $vaccinationStatus($vaccine->next_due_date);
                                @endphp

                                <div class="flex gap-3">

                                    <div class="flex flex-col items-center">
                                        <div class="h-3 w-3 rounded-full {{ $status['dot'] }} mt-1.5 ring-4 {{ $status['bg'] }}" aria-hidden="true"></div>
                                        @unless($loop->last)
                                            <div class="w-px flex-1 bg-pink-100 sm:hidden" aria-hidden="true"></div>
                                        @endunless
                                    </div>

                                    <div class="flex-1 min-w-0 rounded-xl bg-slate-50/70 px-3 py-2.5">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900 truncate">
                                                {{ $vaccine->vaccine_name }} &middot; Dose {{ $vaccine->dose }}
                                            </p>
                                            <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full {{ $status['bg'] }} px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold {{ $status['text'] }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}" aria-hidden="true"></span>
                                                {{ $status['label'] }}
                                            </span>
                                        </div>
                                        <p class="text-[12px] sm:text-[13px] text-slate-500 mt-0.5">
                                            Given {{ \Carbon\Carbon::parse($vaccine->date_given)->format('F d, Y') }}
                                        </p>
                                        @if($vaccine->next_due_date)
                                            <p class="text-[12px] sm:text-[13px] text-slate-400 mt-0.5">
                                                Next due {{ \Carbon\Carbon::parse($vaccine->next_due_date)->format('F d, Y') }}
                                            </p>
                                        @endif
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="py-6 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full {{ $genderTheme['soft'] }} {{ $genderTheme['text'] }} mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                                </svg>
                            </div>
                            <p class="text-[13px] sm:text-sm text-slate-500">
                                No vaccination records found for {{ $selectedInfant->first_name }}.
                            </p>
                        </div>

                    @endif

                                    {{-- ====================================== --}}
                {{-- VACCINATION HISTORY --}}
                {{-- Same $vaccinations data as the Timeline above — --}}
                {{-- full record list instead of a compact overview. --}}
                {{-- ====================================== --}}

                <div class="mt-6">

                    <div class="flex items-center justify-between mb-3 px-0.5">
                        <h3 class="text-[14px] sm:text-base font-bold text-slate-900">
                            Vaccination history
                        </h3>
                        <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-600">
                            {{ $vaccinations->count() }} {{ Str::plural('record', $vaccinations->count()) }}
                        </span>
                    </div>

                    @if($vaccinations->count())

                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm divide-y divide-slate-100 overflow-hidden">

                            @foreach($vaccinations as $vaccine)

                                @php
                                    $historyStatus = $vaccinationStatus($vaccine->next_due_date);
                                @endphp

                                <div class="p-4 sm:p-5 flex items-start gap-3 hover:bg-slate-50/60 transition">

                                    <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-pink-50 flex items-center justify-center text-pink-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                                        </svg>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <p class="text-[13px] sm:text-sm font-semibold text-slate-900 truncate">
                                                {{ $vaccine->vaccine_name }} &middot; Dose {{ $vaccine->dose }}
                                            </p>
                                            <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full {{ $historyStatus['bg'] }} px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold {{ $historyStatus['text'] }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $historyStatus['dot'] }}" aria-hidden="true"></span>
                                                {{ $historyStatus['label'] }}
                                            </span>
                                        </div>

                                        <p class="text-[12px] sm:text-[13px] text-slate-400 mt-0.5">
                                            Given {{ \Carbon\Carbon::parse($vaccine->date_given)->format('F d, Y') }}
                                        </p>

                                        <p class="text-[12px] sm:text-[13px] text-slate-400">
                                            @if($vaccine->next_due_date)
                                                Next due {{ \Carbon\Carbon::parse($vaccine->next_due_date)->format('F d, Y') }}
                                            @else
                                                No further dose scheduled
                                            @endif
                                        </p>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl bg-white border {{ $genderTheme['border'] }} p-8 sm:p-10 text-center shadow-sm">
                            <div class="h-12 w-12 mx-auto rounded-full {{ $genderTheme['soft'] }} flex items-center justify-center {{ $genderTheme['text'] }} mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                                </svg>
                            </div>
                            <p class="text-[13px] sm:text-sm text-slate-500">
                                No vaccination records found for {{ $selectedInfant->first_name }}.
                            </p>
                        </div>

                    @endif

                </div>

                </div>

                {{-- ====================================== --}}
                {{-- GROWTH MONITORING --}}
                {{-- Same $growthRecords loop as the original table --}}
                {{-- "View growth chart" links to the most recent growth record --}}
                {{-- ====================================== --}}

                <div class="mt-6" id="growth-chart">

                    <div class="flex items-center justify-between mb-3 px-0.5">
                        <h3 class="text-[14px] sm:text-base font-bold text-slate-900">
                            Growth monitoring
                        </h3>

                        @php
                            $latestGrowth = $growthRecords->first();
                        @endphp

                        @if($latestGrowth)
                            <a href="{{ route('mother.growth-monitoring.show', $latestGrowth) }}"
                               class="inline-flex items-center gap-1 rounded-full border border-pink-200 bg-white px-3 py-1.5 text-[12px] sm:text-[13px] font-semibold text-pink-600 transition hover:bg-pink-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-300">
                                View growth chart
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif

                    </div>

                    @if($growthRecords->count())

                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm divide-y divide-slate-100 overflow-hidden">

                            @foreach($growthRecords as $record)

                                @php
                                    $months = (float) $record->age_in_months;

                                    if ($months < 1) {
                                        $days = round($months * 30);
                                        $ageDisplay = $days . ' ' . Str::plural('day', $days) . ' old';
                                    } elseif ($months < 24) {
                                        $wholeMonths = round($months);
                                        $ageDisplay = $wholeMonths . ' ' . Str::plural('month', $wholeMonths) . ' old';
                                    } else {
                                        $years = (int) floor($months / 12);
                                        $ageDisplay = $years . ' ' . Str::plural('year', $years) . ' old';
                                    }
                                @endphp

                                <div class="p-4 sm:p-5 flex items-center gap-3 hover:bg-slate-50/60 transition">

                                    <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-pink-50 flex items-center justify-center text-pink-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l3-3m0 0l3 3m-3-3v9M21 10.5l-3 3m0 0l-3-3m3 3v-9"/>
                                        </svg>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                                        </p>
                                        <p class="text-[12px] sm:text-[13px] text-slate-400">
                                            {{ $ageDisplay }}
                                        </p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                            {{ $record->weight }} kg
                                        </p>
                                        <p class="text-[12px] sm:text-[13px] text-slate-400">
                                            {{ $record->height }} cm
                                        </p>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl bg-white border {{ $genderTheme['border'] }} p-8 sm:p-10 text-center shadow-sm">
                            <div class="h-12 w-12 mx-auto rounded-full {{ $genderTheme['soft'] }} flex items-center justify-center {{ $genderTheme['text'] }} mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l3-3m0 0l3 3m-3-3v9M21 10.5l-3 3m0 0l-3-3m3 3v-9"/>
                                </svg>
                            </div>
                            <p class="text-[13px] sm:text-sm text-slate-500">
                                No growth monitoring records found.
                            </p>
                        </div>

                    @endif

                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO INFANT RECORDS — same empty state as original --}}
                {{-- Neutral styling: no infant/sex is selected yet, --}}
                {{-- so there is nothing to theme by gender. --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-3xl bg-white border border-pink-100 p-10 sm:p-14 text-center shadow-sm">

                    <div class="h-20 w-20 sm:h-24 sm:w-24 mx-auto rounded-full bg-pink-50 flex items-center justify-center text-5xl sm:text-6xl" aria-hidden="true">
                        👶
                    </div>

                    <h3 class="mt-5 text-lg sm:text-xl font-bold text-slate-900">
                        No infant records yet
                    </h3>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500 max-w-xs mx-auto">
                        Once your infant's information is added, their growth, vaccinations, and health records will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>