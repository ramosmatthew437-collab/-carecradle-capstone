<x-app-layout>
    @include('infants._styles')

    @php
        $totalVaccinations = $infant->vaccinations->count();
        $totalGrowthRecords = $infant->growthMonitorings->count();

        // Next-due status per record, using the Midwife Dashboard's rules
        // (App\Models\Vaccination::dueStatus): due today counts as upcoming,
        // and a past due date is only "overdue" when no later dose of the same
        // vaccine has been recorded for this infant.
        $vaccinationDueStatus = $infant->vaccinations->mapWithKeys(
            fn ($v) => [$v->id => $v->dueStatus($infant->vaccinations)]
        );

        $upcomingVaccinations = $infant->vaccinations->filter(
            fn ($v) => $vaccinationDueStatus[$v->id] === 'upcoming'
        );

        $missedVaccinations = $infant->vaccinations->filter(
            fn ($v) => $vaccinationDueStatus[$v->id] === 'overdue'
        );

        $upcomingVaccinationsCount = $upcomingVaccinations->count();
        $missedVaccinationsCount = $missedVaccinations->count();

        // Earliest overdue first (most urgent), then soonest-upcoming first,
        // then everything else (no next_due_date, or followed by a later
        // dose) in its original most-recently-given-first order.
        // Presentation-layer only: the $infant->vaccinations relationship and
        // its default ordering are untouched.
        $sortedVaccinations = $infant->vaccinations->sort(function ($a, $b) use ($vaccinationDueStatus) {
            $rank = function ($v) use ($vaccinationDueStatus) {
                return match ($vaccinationDueStatus[$v->id]) {
                    'overdue' => 0,
                    'upcoming' => 1,
                    default => 2,
                };
            };

            $rankA = $rank($a);
            $rankB = $rank($b);

            if ($rankA !== $rankB) {
                return $rankA <=> $rankB;
            }

            if ($rankA === 2) {
                return 0; // preserve original date_given-desc order within this group
            }

            return \Carbon\Carbon::parse($a->next_due_date) <=> \Carbon\Carbon::parse($b->next_due_date);
        })->values();

        $firstMissedVaccination = $missedVaccinations->sortBy('next_due_date')->first();
        $firstUpcomingVaccination = $upcomingVaccinations->sortBy('next_due_date')->first();

        $latestGrowth = $infant->growthMonitorings->sortByDesc('date_measured')->first();

        // Birth-vs-latest comparison (already-loaded values, no new query).
        $weightSinceBirth = $latestGrowth ? $latestGrowth->weight - $infant->birth_weight : null;
        $heightSinceBirth = $latestGrowth ? $latestGrowth->height - $infant->birth_length : null;

        $ageDiff = \Carbon\Carbon::parse($infant->birth_date)->diff(now());
        $ageText = $ageDiff->y > 0
            ? $ageDiff->y . ' ' . Str::plural('year', $ageDiff->y) . ($ageDiff->m ? ', ' . $ageDiff->m . ' ' . Str::plural('month', $ageDiff->m) : '')
            : ($ageDiff->m > 0
                ? $ageDiff->m . ' ' . Str::plural('month', $ageDiff->m) . ($ageDiff->d ? ', ' . $ageDiff->d . ' ' . Str::plural('day', $ageDiff->d) : '')
                : $ageDiff->d . ' ' . Str::plural('day', $ageDiff->d));

        $chartGrowth = $infant->growthMonitorings->sortBy('date_measured')->values();
        $mother = $infant->mother;
        $signed = fn ($value) => ($value >= 0 ? '+' : '−') . number_format(abs($value), 2);
    @endphp

    <div class="inf">
        <div class="inf-container">

            @if ($mother)
                <a href="{{ route('mothers.show', $mother->id) }}" class="inf-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Mother Profile
                </a>
            @endif

            <header class="inf-head">
                <div style="display: flex; align-items: center; gap: 0.875rem;">
                    <div class="inf-avatar inf-avatar-lg">
                        @php
                            // Photo only when the stored file exists; otherwise, or if it fails
                            // to load, the initials avatar is shown instead of a broken image.
                            $infHasPhoto = $infant->photo_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($infant->photo_path);
                            $infInitials = strtoupper(substr($infant->first_name ?? '', 0, 1) . substr($infant->last_name ?? '', 0, 1));
                        @endphp
                        @if ($infHasPhoto)
                            <img src="{{ route('midwife.infant-photo.show', $infant->id) }}" alt="Photo of {{ $infant->first_name }} {{ $infant->last_name }}" onerror="this.style.display = 'none'; this.nextElementSibling.style.display = '';">
                            <span aria-hidden="true" style="display: none;">{{ $infInitials }}</span>
                        @else
                            <span aria-hidden="true">{{ $infInitials }}</span>
                        @endif
                    </div>
                    <div style="min-width: 0;">
                        <p class="inf-kicker">Infant Profile</p>
                        <h1 class="inf-title">{{ trim($infant->first_name . ' ' . $infant->middle_name . ' ' . $infant->last_name) }}</h1>
                        <p class="inf-subtitle">
                            <span class="inf-badge inf-badge-pink">{{ $infant->sex }}</span>
                            <span class="inf-badge {{ $infant->birth_status === 'Stillbirth' ? 'inf-badge-gray' : 'inf-badge-green' }}">{{ $infant->birth_status }}</span>
                            &nbsp;Born {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }} · {{ $ageText }} old
                        </p>
                    </div>
                </div>

                <div class="inf-head-actions">
                    <a href="{{ route('infants.edit', $infant->id) }}" class="inf-btn inf-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                        Edit Infant
                    </a>
                    <form action="{{ route('infants.destroy', $infant->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inf-btn inf-btn-danger"
                                onclick="return confirm('Delete this infant record?')">
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

            {{-- Counts and quick links --}}
            <div class="inf-stats">
                <a href="#inf-vaccinations" class="inf-stat">
                    <p class="inf-stat-label">Vaccinations</p>
                    <p class="inf-stat-value">{{ $totalVaccinations }}</p>
                    <p class="inf-stat-note">Doses recorded</p>
                </a>
                <a href="#inf-growth" class="inf-stat">
                    <p class="inf-stat-label">Growth Records</p>
                    <p class="inf-stat-value">{{ $totalGrowthRecords }}</p>
                    <p class="inf-stat-note">Measurements</p>
                </a>
                @if ($firstUpcomingVaccination)
                    <a href="#vaccination-item-{{ $firstUpcomingVaccination->id }}" class="inf-stat inf-stat-warn">
                        <p class="inf-stat-label">Upcoming</p>
                        <p class="inf-stat-value">{{ $upcomingVaccinationsCount }}</p>
                        <p class="inf-stat-note">Next due {{ \Carbon\Carbon::parse($firstUpcomingVaccination->next_due_date)->format('M d') }} →</p>
                    </a>
                @else
                    <div class="inf-stat">
                        <p class="inf-stat-label">Upcoming</p>
                        <p class="inf-stat-value">{{ $upcomingVaccinationsCount }}</p>
                        <p class="inf-stat-note">No dose due</p>
                    </div>
                @endif
                @if ($firstMissedVaccination)
                    <a href="#vaccination-item-{{ $firstMissedVaccination->id }}" class="inf-stat inf-stat-alert">
                        <p class="inf-stat-label">Overdue</p>
                        <p class="inf-stat-value">{{ $missedVaccinationsCount }}</p>
                        <p class="inf-stat-note">Past due date →</p>
                    </a>
                @else
                    <div class="inf-stat">
                        <p class="inf-stat-label">Overdue</p>
                        <p class="inf-stat-value">{{ $missedVaccinationsCount }}</p>
                        <p class="inf-stat-note">None overdue</p>
                    </div>
                @endif
            </div>

            <div class="inf-split">
                {{-- Infant information --}}
                <section class="inf-card" aria-labelledby="inf-info-title">
                    <div class="inf-card-head">
                        <div class="inf-card-head-main">
                            <span class="inf-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                            </span>
                            <div>
                                <h2 class="inf-card-title" id="inf-info-title">Infant Information</h2>
                                <p class="inf-card-sub">Recorded at registration.</p>
                            </div>
                        </div>
                    </div>
                    <dl class="inf-dl">
                        <div><dt>Date of Birth</dt><dd>{{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}</dd></div>
                        <div><dt>Age</dt><dd>{{ $ageText }}</dd></div>
                        <div><dt>Sex</dt><dd>{{ $infant->sex }}</dd></div>
                        <div><dt>Birth Weight</dt><dd>{{ number_format($infant->birth_weight, 2) }}<span class="inf-unit">kg</span></dd></div>
                        <div><dt>Birth Length</dt><dd>{{ number_format($infant->birth_length, 2) }}<span class="inf-unit">cm</span></dd></div>
                        <div>
                            <dt>Head Circumference</dt>
                            <dd>
                                @if ($infant->head_circumference)
                                    {{ number_format($infant->head_circumference, 2) }}<span class="inf-unit">cm</span>
                                @else
                                    <span class="inf-empty-value">Not recorded</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </section>

                {{-- Mother --}}
                <section class="inf-card" aria-labelledby="inf-mother-title">
                    <div class="inf-card-head">
                        <div class="inf-card-head-main">
                            <span class="inf-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                            </span>
                            <div>
                                <h2 class="inf-card-title" id="inf-mother-title">Mother</h2>
                                <p class="inf-card-sub">Linked maternal record.</p>
                            </div>
                        </div>
                    </div>
                    @if ($mother)
                        <dl class="inf-dl inf-dl-2">
                            <div class="inf-span-all"><dt>Name</dt><dd>{{ $mother->first_name }} {{ $mother->last_name }}</dd></div>
                            <div><dt>Mother Code</dt><dd><span class="inf-code">{{ $mother->mother_code }}</span></dd></div>
                            <div><dt>Barangay</dt><dd>{{ $mother->barangay ?: '—' }}</dd></div>
                            <div class="inf-span-all"><dt>Address</dt><dd>{{ $mother->address ?: '—' }}</dd></div>
                        </dl>
                        <a href="{{ route('mothers.show', $mother->id) }}" class="inf-btn inf-btn-secondary" style="margin-top: 0.875rem; width: 100%;">
                            View Mother Profile
                        </a>
                    @else
                        <p class="inf-hint">The linked mother record is unavailable.</p>
                    @endif
                </section>
            </div>

            {{-- Registration exception (Section 1) and clinical remarks --}}
            @if ($infant->registrationException())
                <div style="margin-top: 1rem;">
                    @include('infants._registration-exception-summary', ['infant' => $infant])
                </div>
            @endif

            <section class="inf-card" aria-labelledby="inf-remarks-title">
                <div class="inf-card-head" style="margin-bottom: 0.75rem;">
                    <div class="inf-card-head-main">
                        <div>
                            <h2 class="inf-card-title" id="inf-remarks-title">Clinical Remarks</h2>
                        </div>
                    </div>
                </div>
                @if ($infant->clinicalRemarks())
                    <p class="inf-note">{{ $infant->clinicalRemarks() }}</p>
                @else
                    <p class="inf-hint" style="margin: 0;">No clinical remarks on file for this infant.</p>
                @endif
            </section>

            {{-- Growth monitoring --}}
            <section class="inf-card" id="inf-growth" aria-labelledby="inf-growth-title">
                <div class="inf-card-head">
                    <div class="inf-card-head-main">
                        <span class="inf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="inf-card-title" id="inf-growth-title">Growth Monitoring</h2>
                            <p class="inf-card-sub">Weight, length, and head circumference over time.</p>
                        </div>
                    </div>
                    <div class="inf-card-actions">
                        <a href="{{ route('growth-monitorings.create', $infant) }}" class="inf-btn inf-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add Growth Record
                        </a>
                    </div>
                </div>

                @if ($infant->growthMonitorings->isEmpty())
                    <div class="inf-empty">
                        <strong>No growth records yet</strong>
                        <p>Add the first measurement to start tracking this infant's growth.</p>
                    </div>
                @else
                    <p class="inf-subhead" style="margin-top: 0;">Latest measurement · {{ \Carbon\Carbon::parse($latestGrowth->date_measured)->format('M d, Y') }}</p>
                    <div class="inf-metrics">
                        <div class="inf-metric">
                            <p class="inf-metric-label">Weight</p>
                            <p class="inf-metric-value">{{ number_format($latestGrowth->weight, 2) }}<span class="inf-unit">kg</span></p>
                            <p class="inf-metric-note">{{ $signed($weightSinceBirth) }} kg since birth</p>
                        </div>
                        <div class="inf-metric">
                            <p class="inf-metric-label">Length / Height</p>
                            <p class="inf-metric-value">{{ number_format($latestGrowth->height, 2) }}<span class="inf-unit">cm</span></p>
                            <p class="inf-metric-note">{{ $signed($heightSinceBirth) }} cm since birth</p>
                        </div>
                        <div class="inf-metric">
                            <p class="inf-metric-label">Head Circumference</p>
                            <p class="inf-metric-value">
                                @if ($latestGrowth->head_circumference)
                                    {{ number_format($latestGrowth->head_circumference, 2) }}<span class="inf-unit">cm</span>
                                @else
                                    <span class="inf-empty-value" style="font-size: 0.9375rem;">Not recorded</span>
                                @endif
                            </p>
                        </div>
                        <div class="inf-metric">
                            <p class="inf-metric-label">Age at Measurement</p>
                            <p class="inf-metric-value">{{ $latestGrowth->age_in_months }}<span class="inf-unit">{{ Str::plural('month', $latestGrowth->age_in_months) }}</span></p>
                        </div>
                    </div>

                    @if ($infant->growthMonitorings->count() > 1)
                        <p class="inf-subhead">Growth trend</p>
                        <div class="inf-chart">
                            <canvas id="growthChart" role="img" aria-label="Line chart of weight in kilograms and length in centimetres by measurement date"></canvas>
                        </div>
                        <p class="inf-chart-note">Weight (left axis, kg) and length / height (right axis, cm) for every recorded measurement.</p>
                    @endif

                    <p class="inf-subhead">Measurement history</p>
                    <div class="inf-table-wrap">
                        <table class="inf-table">
                            <thead>
                                <tr>
                                    <th scope="col">Date Measured</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Length / Height</th>
                                    <th scope="col">Head Circ.</th>
                                    <th scope="col" class="inf-cell-action"><span class="inf-sr">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($infant->growthMonitorings as $growth)
                                    <tr>
                                        <td class="inf-cell-title" data-label="Date measured">{{ \Carbon\Carbon::parse($growth->date_measured)->format('M d, Y') }}</td>
                                        <td data-label="Age">{{ $growth->age_in_months }} {{ Str::plural('month', $growth->age_in_months) }}</td>
                                        <td data-label="Weight">{{ number_format($growth->weight, 2) }} kg</td>
                                        <td data-label="Length / Height">{{ number_format($growth->height, 2) }} cm</td>
                                        <td data-label="Head circ.">{{ $growth->head_circumference ? number_format($growth->head_circumference, 2) . ' cm' : '—' }}</td>
                                        <td class="inf-cell-action">
                                            <a href="{{ route('growth-monitorings.show', $growth) }}" class="inf-btn inf-btn-quiet inf-btn-sm">
                                                View<span class="inf-sr"> growth record of {{ \Carbon\Carbon::parse($growth->date_measured)->format('M d, Y') }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Vaccinations --}}
            <section class="inf-card" id="inf-vaccinations" aria-labelledby="inf-vacc-title">
                <div class="inf-card-head">
                    <div class="inf-card-head-main">
                        <span class="inf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="inf-card-title" id="inf-vacc-title">Vaccinations</h2>
                            <p class="inf-card-sub">Overdue and upcoming doses first, then completed records.</p>
                        </div>
                    </div>
                    <div class="inf-card-actions">
                        <a href="{{ route('vaccinations.create', $infant) }}" class="inf-btn inf-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add Vaccination
                        </a>
                    </div>
                </div>

                @if ($infant->vaccinations->isEmpty())
                    <div class="inf-empty">
                        <strong>No vaccination records yet</strong>
                        <p>Record the first dose given to this infant.</p>
                    </div>
                @else
                    <ul class="inf-timeline">
                        @foreach ($sortedVaccinations as $vaccination)
                            @php
                                $dueStatus = $vaccinationDueStatus[$vaccination->id] ?? null;
                                $isPastDue = $dueStatus === 'overdue';
                                $isUpcoming = $dueStatus === 'upcoming';
                            @endphp
                            <li class="inf-dose {{ $isPastDue ? 'inf-dose-overdue' : ($isUpcoming ? 'inf-dose-upcoming' : 'inf-dose-done') }}" id="vaccination-item-{{ $vaccination->id }}">
                                <div class="inf-dose-main">
                                    <p class="inf-dose-name">
                                        {{ $vaccination->vaccine_name }} <span>· {{ $vaccination->dose }}</span>
                                        @if ($vaccination->isCustomVaccine() || $vaccination->isCustomDose())
                                            <span class="inf-badge inf-badge-amber" title="Not part of the approved schedule">Custom</span>
                                        @endif
                                    </p>
                                    <div class="inf-dose-meta">
                                        <span>Given {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}</span>
                                        @if ($vaccination->next_due_date)
                                            @if ($dueStatus === 'superseded')
                                                {{-- Past due date already followed by a later dose: history, not overdue --}}
                                                <span class="inf-badge inf-badge-gray">Was due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }} · later dose recorded</span>
                                            @elseif ($isPastDue)
                                                <span class="inf-badge inf-badge-red">Overdue · was due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}</span>
                                            @else
                                                <span class="inf-badge inf-badge-amber">Next due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('vaccinations.show', $vaccination) }}" class="inf-btn inf-btn-quiet inf-btn-sm">
                                    View<span class="inf-sr"> {{ $vaccination->vaccine_name }} {{ $vaccination->dose }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

        </div>
    </div>

    @if ($infant->growthMonitorings->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('growthChart');
                if (!ctx || typeof Chart === 'undefined') return;

                var isMobile = window.matchMedia('(max-width: 639px)').matches;

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartGrowth->map(fn ($g) => \Carbon\Carbon::parse($g->date_measured)->format('M d, Y'))),
                        datasets: [
                            {
                                label: 'Weight (kg)',
                                data: @json($chartGrowth->map(fn ($g) => (float) $g->weight)),
                                yAxisID: 'y',
                                borderColor: '#be185d',
                                backgroundColor: '#be185d',
                                borderWidth: 2.5,
                                pointRadius: isMobile ? 2.5 : 3.5,
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Length / height (cm)',
                                data: @json($chartGrowth->map(fn ($g) => (float) $g->height)),
                                yAxisID: 'y1',
                                borderColor: '#0f766e',
                                backgroundColor: '#0f766e',
                                borderWidth: 2.5,
                                pointRadius: isMobile ? 2.5 : 3.5,
                                pointStyle: 'rectRot',
                                tension: 0.3,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 12, usePointStyle: true, font: { size: isMobile ? 11 : 12 } }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                position: 'left',
                                ticks: { font: { size: isMobile ? 10 : 11 } },
                                title: { display: true, text: 'Weight (kg)', font: { size: isMobile ? 10 : 11 } }
                            },
                            y1: {
                                type: 'linear',
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: { font: { size: isMobile ? 10 : 11 } },
                                title: { display: true, text: 'Length (cm)', font: { size: isMobile ? 10 : 11 } }
                            },
                            x: {
                                ticks: {
                                    font: { size: isMobile ? 10 : 11 },
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: isMobile ? 3 : 8
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
