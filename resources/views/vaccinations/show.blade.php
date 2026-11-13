<x-app-layout>
    @include('infants._styles')

    @php
        $infant = $vaccination->infant;
        // Same rule as the Infant Profile and Midwife Dashboard (Vaccination::dueStatus).
        $dueStatus = $vaccination->dueStatus($infant ? $infant->vaccinations : [$vaccination]);
        $nextDue = $vaccination->next_due_date ? \Carbon\Carbon::parse($vaccination->next_due_date) : null;
        [$statusClass, $statusText] = match ($dueStatus) {
            'overdue' => ['inf-badge-red', 'Overdue · was due ' . $nextDue->format('M d, Y')],
            'upcoming' => ['inf-badge-amber', $nextDue->isToday() ? 'Due today' : 'Upcoming · due ' . $nextDue->format('M d, Y')],
            'superseded' => ['inf-badge-gray', 'Later dose recorded · was due ' . $nextDue->format('M d, Y')],
            default => ['inf-badge-gray', 'No next dose scheduled'],
        };
    @endphp

    <div class="inf">
        <div class="inf-container inf-container-narrow">

            @if ($infant)
                <a href="{{ route('infants.show', $infant) }}" class="inf-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Infant Profile
                </a>
            @endif

            <header class="inf-head">
                <div>
                    <p class="inf-kicker">Infant Vaccination</p>
                    <h1 class="inf-title">{{ $vaccination->vaccine_name }}</h1>
                    <p class="inf-subtitle">
                        {{ $vaccination->dose }} · given {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}
                        &nbsp;<span class="inf-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </p>
                </div>
                <div class="inf-head-actions">
                    <a href="{{ route('vaccinations.edit', $vaccination) }}" class="inf-btn inf-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('vaccinations.destroy', $vaccination) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inf-btn inf-btn-danger" onclick="return confirm('Delete this vaccination record?')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </header>

            @if (session('success'))
                <div class="inf-alert inf-alert-success" role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($infant)
                @include('infants._infant-banner', ['infant' => $infant])
            @endif

            <section class="inf-card" aria-labelledby="vx-details-title">
                <div class="inf-card-head">
                    <div class="inf-card-head-main">
                        <span class="inf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="inf-card-title" id="vx-details-title">Vaccination Details</h2>
                            <p class="inf-card-sub">Recorded for this dose.</p>
                        </div>
                    </div>
                </div>
                <dl class="inf-dl">
                    <div>
                        <dt>Vaccine</dt>
                        <dd>
                            {{ $vaccination->vaccine_name }}
                            @if ($vaccination->isCustomVaccine())
                                <span class="inf-badge inf-badge-amber">Custom</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt>Dose</dt>
                        <dd>
                            {{ $vaccination->dose }}
                            @if ($vaccination->isCustomDose())
                                <span class="inf-badge inf-badge-amber">Custom</span>
                            @endif
                        </dd>
                    </div>
                    <div><dt>Date Given</dt><dd>{{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}</dd></div>
                    <div>
                        <dt>Next Due Date</dt>
                        <dd>{!! $nextDue ? e($nextDue->format('M d, Y')) : '<span class="inf-empty-value">Not scheduled</span>' !!}</dd>
                    </div>
                    <div><dt>Due Status</dt><dd><span class="inf-badge {{ $statusClass }}">{{ $statusText }}</span></dd></div>
                    <div><dt>Administered By</dt><dd>{{ $vaccination->administered_by }}</dd></div>
                </dl>
                @if ($vaccination->isCustomVaccine())
                    <p class="inf-hint">“{{ $vaccination->vaccine_name }}” is a custom vaccine name. It is not part of the approved schedule, so no standard dose or age guidance applies.</p>
                @elseif ($vaccination->isCustomDose())
                    <p class="inf-hint">“{{ $vaccination->dose }}” is a custom dose label, not one of the standard {{ $vaccination->vaccine_name }} doses.</p>
                @else
                    <p class="inf-hint">Standard dose · recommended {{ \App\Models\Vaccination::doseGuidance($vaccination->vaccine_name)[$vaccination->dose] }} ({{ \App\Models\Vaccination::SCHEDULE_NOTE }})</p>
                @endif
                @if ($dueStatus === 'superseded')
                    <p class="inf-hint">A later dose of {{ $vaccination->vaccine_name }} has been recorded, so this due date is not counted as overdue.</p>
                @endif
            </section>

            <section class="inf-card" aria-labelledby="vx-remarks-title">
                <div class="inf-card-head" style="margin-bottom: 0.75rem;">
                    <div class="inf-card-head-main">
                        <div><h2 class="inf-card-title" id="vx-remarks-title">Remarks</h2></div>
                    </div>
                </div>
                @if (filled($vaccination->remarks))
                    <p class="inf-note inf-note-plain">{{ $vaccination->remarks }}</p>
                @else
                    <p class="inf-hint" style="margin: 0;">No remarks recorded for this dose.</p>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>
