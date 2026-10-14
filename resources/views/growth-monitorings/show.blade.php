<x-app-layout>

    @php
        $heightInMeters = $growthMonitoring->height
            ? $growthMonitoring->height / 100
            : null;

        $bmi = ($growthMonitoring->weight && $heightInMeters)
            ? $growthMonitoring->weight / ($heightInMeters ** 2)
            : null;

        $genderKey = strtolower($growthMonitoring->infant->sex ?? '');

        $genderTheme = match($genderKey) {
            'female' => [
                'theme' => 'grd-theme-female',
                'icon'  => 'grd-icon-female',
                'badge' => 'grd-badge-female',
            ],

            'male' => [
                'theme' => 'grd-theme-male',
                'icon'  => 'grd-icon-male',
                'badge' => 'grd-badge-male',
            ],

            default => [
                'theme' => 'grd-theme-default',
                'icon'  => 'grd-icon-default',
                'badge' => 'grd-badge-default',
            ],
        };

        $ageMonthsRaw = (float) $growthMonitoring->age_in_months;

        if ($ageMonthsRaw < 1) {
            $ageDays = (int) round($ageMonthsRaw * 30);

            $ageLabel = $ageDays . ' ' .
                Str::plural('day', $ageDays) .
                ' old';

        } elseif ($ageMonthsRaw < 24) {

            $ageWholeMonths = (int) round($ageMonthsRaw);

            $ageLabel = $ageWholeMonths . ' ' .
                Str::plural('month', $ageWholeMonths) .
                ' old';

        } else {

            $ageYears = (int) floor($ageMonthsRaw / 12);

            $ageRemainderMonths = (int) round(
                $ageMonthsRaw - ($ageYears * 12)
            );

            $ageLabel =
                $ageYears . ' ' .
                Str::plural('year', $ageYears) .
                ($ageRemainderMonths > 0
                    ? ' ' . $ageRemainderMonths . ' ' .
                      Str::plural('month', $ageRemainderMonths)
                    : ''
                ) .
                ' old';
        }

        /*
         * Previous growth record
         */
        $allGrowthRecords =
            $growthMonitoring->infant->growthMonitorings->values();

        $currentIndex = $allGrowthRecords->search(
            function ($record) use ($growthMonitoring) {
                return $record->id === $growthMonitoring->id;
            }
        );

        $previousGrowth =
            ($currentIndex !== false)
                ? $allGrowthRecords->get($currentIndex + 1)
                : null;

        $weightDelta = $previousGrowth
            ? $growthMonitoring->weight - $previousGrowth->weight
            : null;

        $heightDelta = $previousGrowth
            ? $growthMonitoring->height - $previousGrowth->height
            : null;
    @endphp


    <div class="grd-wrap">

        <div class="grd-container">


            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}

            <div class="grd-page-head">

                <button
                    type="button"
                    onclick="window.history.back()"
                    aria-label="Go back"
                    class="grd-back-btn"
                >
                    <svg
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

                <div class="grd-page-copy">

                    <span>Growth Monitoring</span>

                    <h1>Growth Record Details</h1>

                    <p>
                        Review the infant's growth measurements and health record
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 HERO
                 ===================================================== --}}

            <section class="grd-hero {{ $genderTheme['theme'] }}">

                <div class="grd-hero-glow grd-hero-glow-a"></div>
                <div class="grd-hero-glow grd-hero-glow-b"></div>

                <div class="grd-hero-inner">

                    <div class="grd-hero-main">

                        {{-- Growth Icon --}}

                        <div class="grd-hero-icon {{ $genderTheme['icon'] }}">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"
                                />
                            </svg>

                        </div>


                        {{-- Hero Content --}}

                        <div class="grd-hero-copy">

                            <p class="grd-eyebrow">
                                Growth Monitoring
                            </p>

                            <h2 class="grd-hero-title">
                                {{ $growthMonitoring->infant->first_name }}
                                {{ $growthMonitoring->infant->last_name }}
                            </h2>

                            <div class="grd-meta">

                                <span class="grd-chip grd-chip-date">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"
                                        />
                                    </svg>

                                    {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}

                                </span>


                                <span class="grd-chip grd-chip-age">
                                    {{ $ageLabel }}
                                </span>


                                @if($growthMonitoring->infant->sex)

                                    <span class="grd-chip {{ $genderTheme['badge'] }}">
                                        {{ $growthMonitoring->infant->sex }}
                                    </span>

                                @endif

                            </div>


                            <p class="grd-hero-description">
                                Review infant growth measurements, anthropometric
                                records, and developmental monitoring information
                                documented during this health assessment.
                            </p>

                        </div>

                    </div>


                    {{-- Mother Card --}}

                    <div class="grd-mother-card">

                        <div class="grd-mother-heading">

                            <div class="grd-mother-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p>Mother</p>

                                <strong>
                                    {{ $growthMonitoring->infant->mother->first_name }}
                                    {{ $growthMonitoring->infant->mother->last_name }}
                                </strong>

                            </div>

                        </div>


                        <div class="grd-mother-details">

                            <span>Mother Code</span>

                            <strong>
                                {{ $growthMonitoring->infant->mother->mother_code }}
                            </strong>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                 MEDICAL NOTES
                 ===================================================== --}}

            @if($growthMonitoring->remarks)

                <section class="grd-notes">

                    <div class="grd-notes-head">

                        <div class="grd-notes-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p>Medical Notes</p>

                            <span>
                                Provider observations recorded during this visit.
                            </span>

                        </div>

                    </div>


                    <div class="grd-notes-body">

                        <p>
                            {{ $growthMonitoring->remarks }}
                        </p>

                    </div>

                </section>

            @else

                <p class="grd-empty-note">
                    No medical notes recorded for this visit.
                </p>

            @endif


            {{-- =====================================================
                 GROWTH METRICS
                 ===================================================== --}}

            <section class="grd-section">

                <div class="grd-section-heading">

                    <div>

                        <span>Measurements</span>

                        <h2>Growth Metrics Overview</h2>

                    </div>

                    <p>
                        Recorded measurements for this visit
                    </p>

                </div>


                <div class="grd-metrics">


                    {{-- Weight --}}

                    <div class="grd-metric-card">

                        <div class="grd-metric-content">

                            <p>Weight</p>

                            <strong>
                                {{ number_format($growthMonitoring->weight, 2) }}
                                <small>kg</small>
                            </strong>

                            @if(!is_null($weightDelta))

                                <span class="{{ $weightDelta >= 0 ? 'grd-positive' : 'grd-negative' }}">

                                    {{ $weightDelta >= 0 ? '+' : '' }}
                                    {{ number_format($weightDelta, 2) }} kg

                                    <em>vs. last visit</em>

                                </span>

                            @else

                                <span class="grd-first">
                                    First recorded visit
                                </span>

                            @endif

                        </div>

                        <div class="grd-metric-icon grd-icon-cyan">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v18m9-9H3"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- Height --}}

                    <div class="grd-metric-card">

                        <div class="grd-metric-content">

                            <p>Height</p>

                            <strong>
                                {{ number_format($growthMonitoring->height, 2) }}
                                <small>cm</small>
                            </strong>

                            @if(!is_null($heightDelta))

                                <span class="{{ $heightDelta >= 0 ? 'grd-positive' : 'grd-negative' }}">

                                    {{ $heightDelta >= 0 ? '+' : '' }}
                                    {{ number_format($heightDelta, 2) }} cm

                                    <em>vs. last visit</em>

                                </span>

                            @else

                                <span class="grd-first">
                                    First recorded visit
                                </span>

                            @endif

                        </div>

                        <div class="grd-metric-icon grd-icon-green">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 19.5L8.25 12l7.5-7.5M12 3v18"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- Head Circumference --}}

                    <div class="grd-metric-card">

                        <div class="grd-metric-content">

                            <p>Head Circ.</p>

                            <strong>
                                {{ $growthMonitoring->head_circumference
                                    ? number_format($growthMonitoring->head_circumference, 2)
                                    : '-' }}

                                <small>cm</small>
                            </strong>

                        </div>

                        <div class="grd-metric-icon grd-icon-blue">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 016 14.25v1.5A2.25 2.25 0 008.25 18h7.5A2.25 2.25 0 0018 15.75v-1.5A2.25 2.25 0 0115.75 12v-.75Z"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- BMI --}}

                    <div class="grd-metric-card">

                        <div class="grd-metric-content">

                            <p>BMI</p>

                            <strong>
                                {{ $bmi ? number_format($bmi, 1) : '-' }}
                            </strong>

                        </div>

                        <div class="grd-metric-icon grd-icon-violet">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- Measurement Date --}}

                    <div class="grd-metric-card grd-date-metric">

                        <div class="grd-metric-content">

                            <p>Measurement Date</p>

                            <strong>
                                {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('M d, Y') }}
                            </strong>

                        </div>

                        <div class="grd-metric-icon grd-icon-pink">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                <p class="grd-bmi-note">
                    BMI shown for reference only. Infant growth is best assessed
                    using WHO weight-for-age and length-for-age charts, not BMI alone.
                </p>

            </section>


            {{-- =====================================================
                 ASSESSMENT
                 ===================================================== --}}

            <section class="grd-assessment">

                <div class="grd-assessment-head">

                    <div class="grd-assessment-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2>Assessment</h2>

                        <p>
                            Growth status summary for this visit.
                        </p>

                    </div>

                </div>


                <div class="grd-assessment-body">

                    <div class="grd-assessment-message">

                        <div class="grd-assessment-info">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"
                                />
                            </svg>

                        </div>

                        <div>

                            <strong>
                                Growth status not recorded
                            </strong>

                            <p>
                                This system doesn't currently classify growth status.
                                A proper assessment (underweight, normal, overweight,
                                stunted) requires comparing this measurement against
                                WHO weight-for-age and length-for-age reference charts.
                            </p>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                 GROWTH TREND CHART
                 ===================================================== --}}

            <section class="grd-section">

                <div class="grd-section-heading">

                    <div>

                        <span>Progress</span>

                        <h2>Growth Trend Chart</h2>

                    </div>

                    <p>
                        Weight and height progression
                    </p>

                </div>


                @if($growthMonitoring->infant->growthMonitorings->count() > 1)

                    <div class="grd-chart-card">

                        <div class="grd-chart-description">
                            Weight and height progression across all recorded
                            measurements for this infant.
                        </div>

                        <div class="grd-chart-wrap">
                            <canvas id="growthChart"></canvas>
                        </div>

                    </div>

                @else

                    <div class="grd-no-chart">

                        <div class="grd-no-chart-icon {{ $genderTheme['icon'] }}">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"
                                />
                            </svg>

                        </div>

                        <h3>Not enough data yet</h3>

                        <p>
                            At least two growth measurements are needed to show a
                            trend chart. Once another visit is recorded, weight and
                            height progression will appear here.
                        </p>

                    </div>

                @endif

            </section>


            {{-- =====================================================
                 RECORD MANAGEMENT
                 ===================================================== --}}

            @if(!request()->routeIs('mother.growth-monitoring.show'))

                <section class="grd-management">

                    <div class="grd-management-copy">

                        <h2>Record Management</h2>

                        <p>
                            Manage this growth monitoring record and return
                            to the linked infant profile.
                        </p>

                    </div>


                    <div class="grd-actions">

                        {{-- Back --}}

                        <a
                            href="{{ route('infants.show', $growthMonitoring->infant) }}"
                            class="grd-action grd-action-back"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>

                            Back to Infant

                        </a>


                        {{-- Edit --}}

                        <a
                            href="{{ route('growth-monitorings.edit', $growthMonitoring) }}"
                            class="grd-action grd-action-edit"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"
                                />
                            </svg>

                            Edit Record

                        </a>


                        {{-- Delete --}}

                        <form
                            action="{{ route('growth-monitorings.destroy', $growthMonitoring) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Delete this growth record?')"
                                class="grd-action grd-action-delete"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 7.5h12M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25A1.125 1.125 0 0114.25 6.375V7.5m-7.5 0h9l-.75 11.25A1.125 1.125 0 0113.878 19.5h-3.756A1.125 1.125 0 019 18.75L8.25 7.5"
                                    />
                                </svg>

                                Delete

                            </button>

                        </form>

                    </div>

                </section>

            @endif


        </div>

    </div>


    {{-- =====================================================
         CHART.JS
         ===================================================== --}}

    @if($growthMonitoring->infant->growthMonitorings->count() > 1)

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const ctx = document.getElementById('growthChart');

                if (!ctx) return;

                const isMobile =
                    window.matchMedia('(max-width: 639px)').matches;

                new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: [
                            @foreach($growthMonitoring->infant->growthMonitorings->sortBy('date_measured') as $record)
                                "{{ \Carbon\Carbon::parse($record->date_measured)->format('M d, Y') }}",
                            @endforeach
                        ],

                        datasets: [

                            {
                                label: 'Weight (kg)',

                                data: [
                                    @foreach($growthMonitoring->infant->growthMonitorings->sortBy('date_measured') as $record)
                                        {{ $record->weight }},
                                    @endforeach
                                ],

                                yAxisID: 'y',

                                borderColor: '#ec4899',
                                backgroundColor: '#ec4899',

                                borderWidth: 2.5,

                                pointRadius: isMobile ? 2 : 3,

                                tension: 0.4,

                                fill: false
                            },


                            {
                                label: 'Height (cm)',

                                data: [
                                    @foreach($growthMonitoring->infant->growthMonitorings->sortBy('date_measured') as $record)
                                        {{ $record->height }},
                                    @endforeach
                                ],

                                yAxisID: 'y1',

                                borderColor: '#10b981',
                                backgroundColor: '#10b981',

                                borderWidth: 2.5,

                                pointRadius: isMobile ? 2 : 3,

                                tension: 0.4,

                                fill: false
                            }

                        ]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {
                            mode: 'index',
                            intersect: false
                        },


                        plugins: {

                            legend: {

                                display: true,

                                position: 'bottom',

                                labels: {

                                    boxWidth: 12,

                                    padding: 12,

                                    font: {
                                        size: isMobile ? 11 : 13
                                    }

                                }

                            },


                            tooltip: {

                                titleFont: {
                                    size: isMobile ? 11 : 13
                                },

                                bodyFont: {
                                    size: isMobile ? 11 : 13
                                }

                            }

                        },


                        scales: {

                            y: {

                                type: 'linear',

                                position: 'left',

                                ticks: {
                                    font: {
                                        size: isMobile ? 10 : 12
                                    }
                                },

                                title: {

                                    display: !isMobile,

                                    text: 'Weight (kg)'

                                }

                            },


                            y1: {

                                type: 'linear',

                                position: 'right',

                                grid: {
                                    drawOnChartArea: false
                                },

                                ticks: {

                                    font: {
                                        size: isMobile ? 10 : 12
                                    }

                                },

                                title: {

                                    display: !isMobile,

                                    text: 'Height (cm)'

                                }

                            },


                            x: {

                                ticks: {

                                    font: {
                                        size: isMobile ? 9 : 11
                                    },

                                    maxRotation: isMobile ? 60 : 0,

                                    minRotation: isMobile ? 60 : 0,

                                    autoSkip: true,

                                    maxTicksLimit: isMobile ? 5 : 10

                                },

                                title: {

                                    display: !isMobile,

                                    text: 'Measurement Date'

                                }

                            }

                        }

                    }

                });

            });

        </script>

    @endif

</x-app-layout>