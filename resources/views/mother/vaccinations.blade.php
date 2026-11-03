<x-app-layout>

    {{-- Google Font: Inter — matches the CareCradle design system --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="mother-vaccinations-page py-6 sm:py-8">

    <div class="max-w-2xl lg:max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ====================================== --}}
        {{-- PAGE HEADER --}}
        {{-- ====================================== --}}

        <div class="mv-page-header">

            <button
                type="button"
                onclick="history.back()"
                aria-label="Go back"
                class="mv-back-button"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2.5"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </button>

            <div>
                <h1 class="mv-page-title">
                    Vaccination records
                </h1>

                <p class="mv-page-subtitle">
                    Immunization history & upcoming doses
                </p>
            </div>

        </div>

     
            @if($vaccinations->count() || $maternalVaccinations->count())

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

                    
/*
 * Summary includes maternal records and the infant records
 * currently displayed on this page.
 */
$allSummaryVaccinations = $vaccinations
    ->getCollection()
    ->concat($maternalVaccinations);

$totalCount = $allSummaryVaccinations->count();

$completedCount = $allSummaryVaccinations
    ->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Completed')
    ->count();

$dueSoonCount = $allSummaryVaccinations
    ->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Due Soon')
    ->count();

$overdueCount = $allSummaryVaccinations
    ->filter(fn($v) => $vaccinationStatus($v->next_due_date)['label'] === 'Overdue')
    ->count();

                    // Only show a per-card infant name tag if this page's records actually
                    // span more than one infant — keeps the single-infant case unchanged.
                    $distinctInfantIds = $vaccinations->pluck('infant_id')->unique();
                    $showInfantName = $distinctInfantIds->count() > 1;
                @endphp


{{-- ====================================== --}}
{{-- HERO --}}
{{-- ====================================== --}}

<div class="mv-hero">

    <div class="mv-hero-decoration mv-hero-decoration-one" aria-hidden="true"></div>
    <div class="mv-hero-decoration mv-hero-decoration-two" aria-hidden="true"></div>

    <div class="mv-hero-content">

        <div class="mv-hero-icon">
            <svg
                class="h-7 w-7 sm:h-8 sm:w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.6"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"
                />
            </svg>
        </div>

        <div class="mv-hero-text">
            <p class="mv-hero-label">
                Vaccination Records
            </p>

            <h2 class="mv-hero-title">
                Immunization history
            </h2>

            <p class="mv-hero-description">
                View your maternal and infant vaccination history and upcoming immunizations.
            </p>
        </div>

    </div>

    <div class="mv-stats">

        <div class="mv-stat">
            <p class="mv-stat-label">Completed</p>
            <p class="mv-stat-value">{{ $completedCount }}</p>
        </div>

        <div class="mv-stat">
            <p class="mv-stat-label">Due soon</p>
            <p class="mv-stat-value">{{ $dueSoonCount }}</p>
        </div>

        <div class="mv-stat">
            <p class="mv-stat-label">Overdue</p>
            <p class="mv-stat-value">{{ $overdueCount }}</p>
        </div>

    </div>

    <p class="mv-hero-footnote">
        {{ $totalCount }} {{ Str::plural('record', $totalCount) }} on this page
    </p>

</div>

{{-- ====================================== --}}
{{-- MATERNAL VACCINATION RECORDS --}}
{{-- ====================================== --}}

<div class="mv-card mt-6">

    {{-- SECTION HEADER --}}
    <div class="mv-card-header">

        <div class="mv-card-heading">

            <div class="mv-card-icon">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v14m-7-7h14"/>
                </svg>
            </div>

            <div>
                <h3 class="mv-card-title">
                    My Vaccinations
                </h3>

                <p class="mv-card-description">
                    Your personal maternal immunization history
                </p>
            </div>

        </div>

        <span class="mv-count">
            {{ $maternalVaccinations->count() }}
            {{ Str::plural('record', $maternalVaccinations->count()) }}
        </span>

    </div>

    {{-- VACCINATION RECORDS --}}
    @if($maternalVaccinations->isNotEmpty())

        <div class="space-y-3">

            @foreach($maternalVaccinations as $maternalVaccination)

                <div class="mv-record">

                    <div class="mv-record-top">

                        <div class="min-w-0">

                            <h4 class="mv-record-name">
                                {{ $maternalVaccination->vaccine_name }}
                            </h4>

                            <p class="mv-record-dose">
                                Dose: {{ $maternalVaccination->dose }}
                            </p>

                        </div>

                        <span class="mv-vaccine-badge">
                            Maternal vaccine
                        </span>

                    </div>

                    <div class="mv-record-details">

                        <div class="mv-detail">
                            <span class="mv-detail-label">Date given</span>
                            <span class="mv-detail-value">
                                {{ $maternalVaccination->date_given?->format('F d, Y') ?? 'Not specified' }}
                            </span>
                        </div>

                        <div class="mv-detail">
                            <span class="mv-detail-label">Next due</span>
                            <span class="mv-detail-value">
                                {{ $maternalVaccination->next_due_date?->format('F d, Y') ?? 'Not scheduled' }}
                            </span>
                        </div>

                        <div class="mv-detail">
                            <span class="mv-detail-label">Administered by</span>
                            <span class="mv-detail-value">
                                {{ $maternalVaccination->administered_by }}
                            </span>
                        </div>

                        @if($maternalVaccination->remarks)
                            <div class="mv-detail mv-detail-full">
                                <span class="mv-detail-label">Remarks</span>
                                <span class="mv-detail-value">
                                    {{ $maternalVaccination->remarks }}
                                </span>
                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- EMPTY STATE --}}
        <div class="mv-empty">

            <div class="mv-empty-icon">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 5v14m-7-7h14"/>
                </svg>
            </div>

            <p class="mv-empty-title">
                No maternal vaccination records yet
            </p>

            <p class="mv-empty-description">
                Your maternal vaccination records will appear here when recorded by your healthcare worker.
            </p>

        </div>

    @endif

</div>
{{-- ====================================== --}}
{{-- VACCINATION TIMELINE --}}
{{-- ====================================== --}}

<div class="mv-card mt-6">

    {{-- SECTION HEADER --}}
    <div class="mv-card-header">

        <div class="mv-card-heading">

            <div class="mv-card-icon">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                </svg>
            </div>

            <div>
                <h3 class="mv-card-title">
                    Vaccination timeline
                </h3>

                <p class="mv-card-description">
                    Your infant's immunization history and upcoming doses
                </p>
            </div>

        </div>

        <span class="mv-count">
            {{ $vaccinations->total() }} {{ Str::plural('dose', $vaccinations->total()) }}
        </span>

    </div>

    {{-- VACCINATION TIMELINE --}}
    <div class="mv-timeline">

        @forelse($vaccinations as $vaccination)

            @php
                $status = $vaccinationStatus($vaccination->next_due_date);
            @endphp

            <div class="mv-timeline-item">

                <div class="mv-timeline-marker">

                    <div class="mv-timeline-dot {{ $status['dot'] }} {{ $status['bg'] }}"
                        aria-hidden="true">
                    </div>

                    @unless($loop->last)
                        <div class="mv-timeline-line" aria-hidden="true"></div>
                    @endunless

                </div>

                <div class="mv-timeline-content">

                    <div class="mv-timeline-top">

                        <div class="min-w-0">

                            <h4 class="mv-timeline-name">
                                {{ $vaccination->vaccine_name }}
                            </h4>

                            <p class="mv-record-dose">
                                Dose {{ $vaccination->dose }}
                            </p>

                        </div>

                        <span class="mv-status {{ $status['bg'] }} {{ $status['text'] }}">
                            <span class="mv-status-dot {{ $status['dot'] }}"
                                aria-hidden="true">
                            </span>

                            {{ $status['label'] }}
                        </span>

                    </div>

                    @if($showInfantName && $vaccination->infant)
                        <p class="mv-infant-name">
                            {{ $vaccination->infant->first_name }}
                        </p>
                    @endif

                    <div class="mv-timeline-dates">

                        <p class="mv-timeline-date">
                            <span>Given</span>
                            {{ \Carbon\Carbon::parse($vaccination->date_given)->format('F d, Y') }}
                        </p>

                        @if($vaccination->next_due_date)
                            <p class="mv-timeline-date">
                                <span>Next due</span>
                                {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('F d, Y') }}
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="mv-empty">
                <p class="mv-empty-title">
                    No infant vaccination records yet
                </p>

                <p class="mv-empty-description">
                    Your infant's immunization records will appear here when recorded by your healthcare worker.
                </p>
            </div>

        @endforelse

    </div>

</div>
{{-- ====================================== --}}
{{-- PAGINATION --}}
{{-- ====================================== --}}

<div class="mv-pagination mt-6">
    {{ $vaccinations->links() }}
</div>

@else

    {{-- ====================================== --}}
    {{-- NO VACCINATION RECORDS --}}
    {{-- ====================================== --}}

    <div class="mv-empty mt-6">

        <div class="mv-empty-icon">
            <svg
                class="h-8 w-8 sm:h-9 sm:w-9"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.6"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"
                />
            </svg>
        </div>

        <h3 class="mv-empty-title">
            No vaccination records
        </h3>

        <p class="mv-empty-description">
            No vaccination records found.
        </p>

    </div>

@endif
</x-app-layout>