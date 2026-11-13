<x-app-layout>
    @include('infants._styles')

    @php
        $infant = $growthMonitoring->infant;

        $heightInMeters = $growthMonitoring->height ? $growthMonitoring->height / 100 : null;
        $bmi = ($growthMonitoring->weight && $heightInMeters) ? $growthMonitoring->weight / ($heightInMeters ** 2) : null;

        $ageMonths = (int) $growthMonitoring->age_in_months;
        $ageLabel = $ageMonths < 24
            ? $ageMonths . ' ' . Str::plural('month', $ageMonths)
            : intdiv($ageMonths, 12) . ' ' . Str::plural('year', intdiv($ageMonths, 12))
                . ($ageMonths % 12 ? ', ' . ($ageMonths % 12) . ' ' . Str::plural('month', $ageMonths % 12) : '');

        // Previous measurement (records are ordered newest first).
        $allGrowthRecords = $infant->growthMonitorings->values();
        $currentIndex = $allGrowthRecords->search(fn ($record) => $record->id === $growthMonitoring->id);
        $previousGrowth = $currentIndex !== false ? $allGrowthRecords->get($currentIndex + 1) : null;
        $weightDelta = $previousGrowth ? $growthMonitoring->weight - $previousGrowth->weight : null;
        $heightDelta = $previousGrowth ? $growthMonitoring->height - $previousGrowth->height : null;
        $signed = fn ($value) => ($value >= 0 ? '+' : '−') . number_format(abs($value), 2);

        $chartGrowth = $infant->growthMonitorings->sortBy('date_measured')->values();
        $currentPoint = $chartGrowth->search(fn ($record) => $record->id === $growthMonitoring->id);

        // This view is shared by the Midwife and Mother portals. Staff-only
        // links and actions (Midwife routes) are shown to Midwives only.
        $gmIsMidwife = (bool) auth()->user()?->isMidwife();
    @endphp

    <div class="inf">
        <div class="inf-container inf-container-narrow">

            <a href="{{ $gmIsMidwife ? route('infants.show', $infant) : route('mother.infant-records', ['infant' => $infant->id]) }}" class="inf-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                {{ $gmIsMidwife ? 'Back to Infant Profile' : 'Back to Infant Records' }}
            </a>

            <header class="inf-head">
                <div>
                    <p class="inf-kicker">Growth Monitoring</p>
                    <h1 class="inf-title">Growth Record</h1>
                    <p class="inf-subtitle">Measured {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('M d, Y') }} · age {{ $ageLabel }}</p>
                </div>
                @if ($gmIsMidwife)
                <div class="inf-head-actions">
                    <a href="{{ route('growth-monitorings.edit', $growthMonitoring) }}" class="inf-btn inf-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('growth-monitorings.destroy', $growthMonitoring) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inf-btn inf-btn-danger" onclick="return confirm('Delete this growth record?')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
                @endif
            </header>

            @if (session('success'))
                <div class="inf-alert inf-alert-success" role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @include('infants._infant-banner', [
                'infant' => $infant,
                'infBannerLink' => $gmIsMidwife,
                'infPhotoRoute' => $gmIsMidwife ? 'midwife.infant-photo.show' : 'mother.infant-photo.show',
            ])

            <section class="inf-card" aria-labelledby="gm-metrics-title">
                <div class="inf-card-head">
                    <div class="inf-card-head-main">
                        <span class="inf-card-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="inf-card-title" id="gm-metrics-title">Measurements</h2>
                            <p class="inf-card-sub">
                                {{ $previousGrowth ? 'Change compared with the previous measurement (' . \Carbon\Carbon::parse($previousGrowth->date_measured)->format('M d, Y') . ').' : 'First recorded measurement for this infant.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="inf-metrics">
                    <div class="inf-metric">
                        <p class="inf-metric-label">Weight</p>
                        <p class="inf-metric-value">{{ number_format($growthMonitoring->weight, 2) }}<span class="inf-unit">kg</span></p>
                        @if ($weightDelta !== null)
                            <p class="inf-metric-note">{{ $signed($weightDelta) }} kg</p>
                        @endif
                    </div>
                    <div class="inf-metric">
                        <p class="inf-metric-label">Length / Height</p>
                        <p class="inf-metric-value">{{ number_format($growthMonitoring->height, 2) }}<span class="inf-unit">cm</span></p>
                        @if ($heightDelta !== null)
                            <p class="inf-metric-note">{{ $signed($heightDelta) }} cm</p>
                        @endif
                    </div>
                    <div class="inf-metric">
                        <p class="inf-metric-label">Head Circumference</p>
                        <p class="inf-metric-value">
                            @if ($growthMonitoring->head_circumference)
                                {{ number_format($growthMonitoring->head_circumference, 2) }}<span class="inf-unit">cm</span>
                            @else
                                <span class="inf-empty-value" style="font-size: 0.9375rem;">Not recorded</span>
                            @endif
                        </p>
                    </div>
                    <div class="inf-metric">
                        <p class="inf-metric-label">BMI (reference)</p>
                        <p class="inf-metric-value">{{ $bmi ? number_format($bmi, 1) : '—' }}</p>
                    </div>
                </div>
                <p class="inf-hint">BMI is shown for reference only. Infant growth is assessed with WHO weight-for-age and length-for-age charts, not BMI alone.</p>
            </section>

            <div class="inf-alert inf-alert-info" role="note">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                </svg>
                <div>
                    <p class="inf-alert-title">Growth status not recorded</p>
                    <p style="margin: 0.125rem 0 0;">
                        CareCradle does not classify growth status. An assessment (for example underweight, normal,
                        or stunted) needs comparison with WHO weight-for-age and length-for-age reference charts.
                    </p>
                </div>
            </div>

            <section class="inf-card" aria-labelledby="gm-remarks-title">
                <div class="inf-card-head" style="margin-bottom: 0.75rem;">
                    <div class="inf-card-head-main">
                        <div><h2 class="inf-card-title" id="gm-remarks-title">Remarks</h2></div>
                    </div>
                </div>
                @if (filled($growthMonitoring->remarks))
                    <p class="inf-note inf-note-plain">{{ $growthMonitoring->remarks }}</p>
                @else
                    <p class="inf-hint" style="margin: 0;">No remarks recorded for this visit.</p>
                @endif
            </section>

            <section class="inf-card" aria-labelledby="gm-chart-title">
                <div class="inf-card-head">
                    <div class="inf-card-head-main">
                        <div>
                            <h2 class="inf-card-title" id="gm-chart-title">Growth Trend</h2>
                            <p class="inf-card-sub">All measurements recorded for this infant. This visit is highlighted.</p>
                        </div>
                    </div>
                </div>
                @if ($chartGrowth->count() > 1)
                    <div class="inf-chart">
                        <canvas id="growthChart" role="img" aria-label="Line chart of weight in kilograms and length in centimetres by measurement date"></canvas>
                    </div>
                    <p class="inf-chart-note">Weight (left axis, kg) and length / height (right axis, cm).</p>
                @else
                    <div class="inf-empty">
                        <strong>Not enough data yet</strong>
                        <p>The trend chart appears once at least two measurements are recorded.</p>
                    </div>
                @endif
            </section>

        </div>
    </div>

    @if ($chartGrowth->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('growthChart');
                if (!ctx || typeof Chart === 'undefined') return;

                var isMobile = window.matchMedia('(max-width: 639px)').matches;
                var current = {{ $currentPoint === false ? -1 : $currentPoint }};
                var radius = function (base) {
                    return function (c) { return c.dataIndex === current ? base + 3 : base; };
                };

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
                                pointRadius: radius(isMobile ? 2.5 : 3.5),
                                tension: 0.3
                            },
                            {
                                label: 'Length / height (cm)',
                                data: @json($chartGrowth->map(fn ($g) => (float) $g->height)),
                                yAxisID: 'y1',
                                borderColor: '#0f766e',
                                backgroundColor: '#0f766e',
                                borderWidth: 2.5,
                                pointRadius: radius(isMobile ? 2.5 : 3.5),
                                pointStyle: 'rectRot',
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12, usePointStyle: true, font: { size: isMobile ? 11 : 12 } } }
                        },
                        scales: {
                            y: { position: 'left', ticks: { font: { size: isMobile ? 10 : 11 } }, title: { display: true, text: 'Weight (kg)', font: { size: isMobile ? 10 : 11 } } },
                            y1: { position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { size: isMobile ? 10 : 11 } }, title: { display: true, text: 'Length (cm)', font: { size: isMobile ? 10 : 11 } } },
                            x: { ticks: { font: { size: isMobile ? 10 : 11 }, maxRotation: 0, autoSkip: true, maxTicksLimit: isMobile ? 3 : 8 } }
                        }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
