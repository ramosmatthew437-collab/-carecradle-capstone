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
    class="h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 hover:bg-pink-50 transition">
    
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>

</button>
                <div>
                    <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">Infant records</h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">View your baby's health information</p>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- INFANT SELECTOR --}}
            {{-- Same GET form / onchange submit as before --}}
            {{-- ====================================== --}}

            @if($infants->count())

                <div class="mt-5 rounded-2xl bg-white border border-pink-100 p-4 sm:p-5 shadow-sm">

                    <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-pink-500 mb-2">
                        Select infant
                    </p>

                    <form method="GET">

                        <div class="relative">

                            <select
                                name="infant"
                                onchange="this.form.submit()"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-white pl-4 pr-10 py-3 sm:py-3.5 text-[14px] sm:text-base font-semibold text-slate-900 focus:border-pink-300 focus:ring-pink-200">

                                @foreach($infants as $infant)

                                    <option
                                        value="{{ $infant->id }}"
                                        {{ $selectedInfant && $selectedInfant->id == $infant->id ? 'selected' : '' }}>

                                        {{ $infant->first_name }}
                                        {{ $infant->last_name }}

                                    </option>

                                @endforeach

                            </select>

                            <svg class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>

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
@endphp

                {{-- ====================================== --}}
                {{-- INFANT PROFILE + HEALTH SUMMARY --}}
                {{-- Stack on mobile, side-by-side from lg --}}
                {{-- ====================================== --}}

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-5 gap-4">

                    {{-- Infant Profile Card (most prominent) --}}
                    <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-6 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/10"></div>
                        <div class="absolute -right-2 bottom-3 h-16 w-16 rounded-full bg-white/10"></div>

                        <div class="relative flex items-start gap-4">

                            <div class="h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 rounded-2xl bg-white/20 flex items-center justify-center text-3xl sm:text-4xl">
                                {{ strtolower($selectedInfant->sex) === 'female' ? '👧' : '👦' }}
                            </div>

                            <div class="flex-1 min-w-0">

                                <h2 class="text-xl sm:text-2xl font-bold">
                                    {{ $selectedInfant->first_name }}
                                    {{ $selectedInfant->middle_name }}
                                    {{ $selectedInfant->last_name }}
                                </h2>

                                <p class="mt-1 text-[13px] sm:text-sm text-pink-50">
                                    {{ $selectedInfant->sex }} &middot; Born {{ $birthDate->format('F d, Y') }}
                                </p>

                                <div class="flex flex-wrap items-center gap-2 mt-2">

                                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                                        {{ $ageLabel }}
                                    </span>

                                    <span class="inline-flex items-center gap-1 rounded-full bg-white text-pink-600 px-3 py-1 text-[12px] sm:text-[13px] font-semibold">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                        {{ $selectedInfant->birth_status ?? 'Growth on track' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Health Summary Cards --}}
                    <div class="lg:col-span-3">

                        <h3 class="text-[14px] sm:text-base font-bold text-slate-900 mb-3">
                            Health summary
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                            {{-- Weight --}}
                            <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                                <div class="h-9 w-9 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 mb-2">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                    </svg>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-400">Weight</p>
                                @if($currentWeight)
                                    <p class="text-[18px] sm:text-xl font-bold text-slate-900">
                                        {{ $currentWeight }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">kg</span>
                                    </p>
                                @else
                                    <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">Not recorded</p>
                                @endif
                            </div>

                            {{-- Height --}}
                            <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                                <div class="h-9 w-9 rounded-lg bg-fuchsia-50 flex items-center justify-center text-fuchsia-500 mb-2">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-400">Height</p>
                                @if($currentHeight)
                                    <p class="text-[18px] sm:text-xl font-bold text-slate-900">
                                        {{ $currentHeight }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">cm</span>
                                    </p>
                                @else
                                    <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">Not recorded</p>
                                @endif
                            </div>

                            {{-- Head Circumference — no backing field yet --}}
                            <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                                <div class="h-9 w-9 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600 mb-2">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="8"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2"/>
                                    </svg>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-400">Head circumference</p>
                               @if($selectedInfant && $selectedInfant->head_circumference)
    <p class="text-[18px] sm:text-xl font-bold text-slate-900">
        {{ $selectedInfant->head_circumference }}
        <span class="text-[12px] sm:text-sm font-medium text-slate-400">
            cm
        </span>
    </p>
@else
    <p class="text-[13px] sm:text-sm font-semibold text-slate-400 mt-1">
        Not recorded
    </p>
@endif
                            </div>

                            {{-- Vaccinations --}}
                            <div class="rounded-2xl bg-white border border-slate-100 p-4 shadow-sm">
                                <div class="h-9 w-9 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 mb-2">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                    </svg>
                                </div>
                                <p class="text-[11px] sm:text-xs text-slate-400">Vaccinations</p>
                                <p class="text-[18px] sm:text-xl font-bold text-slate-900">
                                    {{ $vaccinations->count() }} <span class="text-[12px] sm:text-sm font-medium text-slate-400">recorded</span>
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- VACCINATION TIMELINE (most prominent) --}}
                {{-- Same $vaccinations loop as the original table --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border-2 border-pink-200 p-4 sm:p-6 shadow-sm">

                    <div class="flex items-center justify-between mb-4 sm:mb-5">
                        <h3 class="text-[15px] sm:text-lg font-bold text-slate-900">
                            Vaccination timeline
                        </h3>
                        <span class="rounded-full bg-pink-50 px-2 py-0.5 text-[11px] sm:text-xs font-semibold text-pink-600">
                            {{ $vaccinations->count() }} {{ Str::plural('dose', $vaccinations->count()) }}
                        </span>
                    </div>

                    @if($vaccinations->count())

                        <div class="space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-8 sm:space-y-0">

                            @foreach($vaccinations as $vaccine)

                                <div class="flex gap-3">

                                    <div class="flex flex-col items-center">
                                        <div class="h-3 w-3 rounded-full bg-pink-500 mt-1"></div>
                                        @unless($loop->last)
                                            <div class="w-px flex-1 bg-pink-100 sm:hidden"></div>
                                        @endunless
                                    </div>

                                    <div class="{{ $loop->last ? '' : 'pb-4 sm:pb-5' }}">
                                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                            {{ $vaccine->vaccine_name }} &middot; Dose {{ $vaccine->dose }}
                                        </p>
                                        <p class="text-[12px] sm:text-[13px] text-slate-500">
                                            Given {{ \Carbon\Carbon::parse($vaccine->date_given)->format('F d, Y') }}
                                        </p>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="text-[13px] sm:text-sm text-slate-500">
                            No vaccination records found.
                        </p>

                    @endif

                </div>

                {{-- ====================================== --}}
                {{-- GROWTH MONITORING --}}
                {{-- Same $growthRecords loop as the original table --}}
                {{-- "View growth chart" is a placeholder anchor for now --}}
                {{-- ====================================== --}}

                <div class="mt-6" id="growth-chart">

                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-[14px] sm:text-base font-bold text-slate-900">
                            Growth monitoring
                        </h3>

                        <a href="#growth-chart"
                           class="inline-flex items-center gap-1 rounded-full border border-pink-200 bg-white px-3 py-1.5 text-[12px] sm:text-[13px] font-semibold text-pink-600 transition hover:bg-pink-50">
                            View growth chart
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    @if($growthRecords->count())

                        <div class="rounded-2xl bg-white border border-slate-100 shadow-sm divide-y divide-slate-100">

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

                                <div class="p-4 flex items-center justify-between">

                                    <div>
                                        <p class="text-[13px] sm:text-sm font-semibold text-slate-900">
                                            {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                                        </p>
                                        <p class="text-[12px] sm:text-[13px] text-slate-400">
                                            {{ $ageDisplay }}
                                        </p>
                                    </div>

                                    <div class="text-right">
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

                        <div class="rounded-2xl bg-white border border-slate-100 p-6 text-center shadow-sm">
                            <p class="text-[13px] sm:text-sm text-slate-500">
                                No growth monitoring records found.
                            </p>
                        </div>

                    @endif

                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO INFANT RECORDS — same empty state as original --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border border-pink-100 p-10 sm:p-12 text-center shadow-sm">

                    <div class="text-5xl sm:text-6xl">
                        👶
                    </div>

                    <h3 class="mt-4 text-lg sm:text-xl font-bold text-slate-900">
                        No infant records
                    </h3>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500">
                        No infant information found.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>