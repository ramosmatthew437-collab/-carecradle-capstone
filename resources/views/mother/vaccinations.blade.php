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
                    type="button"
                    onclick="history.back()"
                    aria-label="Go back"
                    class="h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 rounded-full bg-white border border-pink-100 flex items-center justify-center text-slate-500 shadow-sm transition hover:bg-pink-50 hover:text-pink-600 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <div>
                    <h1 class="text-[19px] sm:text-2xl font-bold text-slate-900 leading-tight">
                        Vaccination records
                    </h1>
                    <p class="text-[12px] sm:text-sm text-slate-500">
                        Immunization history & upcoming doses
                    </p>
                </div>

            </div>

            @if($vaccinations->count())

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

                    // Summary counts reflect only the current paginated page of $vaccinations,
                    // consistent with how $vaccinations->count() was already used in this file.
                    $totalCount = $vaccinations->count();
                    $completedCount = $vaccinations->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Completed')->count();
                    $dueSoonCount = $vaccinations->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Due Soon')->count();
                    $overdueCount = $vaccinations->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Overdue')->count();

                    // Only show a per-card infant name tag if this page's records actually
                    // span more than one infant — keeps the single-infant case unchanged.
                    $distinctInfantIds = $vaccinations->pluck('infant_id')->unique();
                    $showInfantName = $distinctInfantIds->count() > 1;
                @endphp

                {{-- ====================================== --}}
                {{-- HERO --}}
                {{-- ====================================== --}}

                <div class="mt-5 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-5 sm:p-7 text-white shadow-md shadow-pink-200 relative overflow-hidden">

                    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10" aria-hidden="true"></div>
                    <div class="absolute -right-2 bottom-2 h-16 w-16 rounded-full bg-white/10" aria-hidden="true"></div>

                    <div class="relative flex items-start gap-4">

                        <div class="h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 rounded-2xl bg-white/20 flex items-center justify-center text-white backdrop-blur-sm">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-pink-50">
                                Vaccination Records
                            </p>
                            <h2 class="mt-1 text-lg sm:text-xl font-bold">
                                Immunization history
                            </h2>
                            <p class="mt-1 text-[13px] sm:text-sm text-pink-50 leading-relaxed">
                                View your infant's vaccination history and upcoming immunizations.
                            </p>
                        </div>

                    </div>

                    <div class="relative mt-4 grid grid-cols-3 gap-2">

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Completed</p>
                            <p class="text-[16px] sm:text-lg font-bold">{{ $completedCount }}</p>
                        </div>

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Due soon</p>
                            <p class="text-[16px] sm:text-lg font-bold">{{ $dueSoonCount }}</p>
                        </div>

                        <div class="rounded-xl bg-white/15 px-2 py-2.5 text-center">
                            <p class="text-[10px] sm:text-[11px] text-pink-50">Overdue</p>
                            <p class="text-[16px] sm:text-lg font-bold">{{ $overdueCount }}</p>
                        </div>

                    </div>

                    <p class="relative mt-3 text-[11px] text-pink-50">
                        {{ $totalCount }} {{ Str::plural('record', $totalCount) }} on this page
                    </p>

                </div>

                {{-- ====================================== --}}
                {{-- VACCINATION TIMELINE --}}
                {{-- Same $vaccinations data, restyled from a table into --}}
                {{-- the card/timeline pattern used on Infant Records --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border-2 border-pink-200 p-4 sm:p-6 shadow-sm">

                    <div class="flex items-center justify-between mb-4 sm:mb-5">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                                </svg>
                            </div>
                            <h3 class="text-[15px] sm:text-lg font-bold text-slate-900">
                                Vaccination timeline
                            </h3>
                            <a href="{{ route('mother.vaccinations') }}">
    View all vaccinations
</a>
                        </div>
                        <span class="rounded-full bg-pink-50 px-2.5 py-1 text-[11px] sm:text-xs font-semibold text-pink-600">
                            {{ $totalCount }} {{ Str::plural('dose', $totalCount) }}
                        </span>
                    </div>

                    <div class="space-y-3 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-3">

                        @foreach($vaccinations as $vaccination)

                            @php
                                $status = $vaccinationStatus($vaccination->next_due_date);
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
                                            {{ $vaccination->vaccine_name }} &middot; Dose {{ $vaccination->dose }}
                                        </p>
                                        <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full {{ $status['bg'] }} px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold {{ $status['text'] }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}" aria-hidden="true"></span>
                                            {{ $status['label'] }}
                                        </span>
                                    </div>

                                    @if($showInfantName && $vaccination->infant)
                                        <p class="text-[11px] sm:text-[12px] font-medium text-pink-500 mt-0.5">
                                            {{ $vaccination->infant->first_name }}
                                        </p>
                                    @endif

                                    <p class="text-[12px] sm:text-[13px] text-slate-500 mt-0.5">
                                        Given {{ \Carbon\Carbon::parse($vaccination->date_given)->format('F d, Y') }}
                                    </p>

                                    @if($vaccination->next_due_date)
                                        <p class="text-[12px] sm:text-[13px] text-slate-400 mt-0.5">
                                            Next due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('F d, Y') }}
                                        </p>
                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- ====================================== --}}
                {{-- PAGINATION --}}
                {{-- Same $vaccinations->links(), restyled placement only --}}
                {{-- ====================================== --}}

                <div class="mt-6">
                    {{ $vaccinations->links() }}
                </div>

            @else

                {{-- ====================================== --}}
                {{-- NO VACCINATION RECORDS --}}
                {{-- ====================================== --}}

                <div class="mt-6 rounded-2xl bg-white border border-pink-100 p-10 sm:p-12 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-pink-50 text-pink-500">
                        <svg class="h-8 w-8 sm:h-9 sm:w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg sm:text-xl font-bold text-slate-900">
                        No vaccination records
                    </h3>

                    <p class="mt-2 text-[13px] sm:text-sm text-slate-500">
                        No vaccination records found.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>