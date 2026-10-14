<x-app-layout>

    <div class="ifr-wrap">

        <div class="ifr-container">

            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
            <div class="ifr-page-head">

                <button
                    onclick="history.back()"
                    type="button"
                    aria-label="Go back"
                    class="ifr-back-btn"
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

                <div class="ifr-page-copy">
                    <span>Child Health</span>

                    <h1>Infant Records</h1>

                    <p>
                        View your baby's health information
                    </p>
                </div>

            </div>


            {{-- =====================================================
                 INFANT SELECTOR
                 ===================================================== --}}
            @if($infants->count())

                <div class="ifr-selector">

                    <form method="GET">

                        <div class="ifr-selector-inner">

                            <div class="ifr-selector-icon">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                    />
                                </svg>
                            </div>

                            <div class="ifr-selector-content">

                                <p>
                                    {{ $infants->count() > 1
                                        ? 'Select infant'
                                        : 'Your infant' }}
                                </p>

                                <select
                                    name="infant"
                                    onchange="this.form.submit()"
                                    {{ $infants->count() <= 1 ? 'disabled' : '' }}
                                    aria-label="{{ $infants->count() > 1 ? 'Select infant' : 'Your infant' }}"
                                    class="ifr-select"
                                >

                                    @foreach($infants as $infant)

                                        <option
                                            value="{{ $infant->id }}"
                                            {{ $selectedInfant && $selectedInfant->id == $infant->id ? 'selected' : '' }}
                                        >
                                            {{ $infant->first_name }}
                                            {{ $infant->last_name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            @if($infants->count() > 1)

                                <svg
                                    class="ifr-select-arrow"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>

                            @endif

                        </div>

                    </form>

                </div>

            @endif


            {{-- =====================================================
                 SELECTED INFANT
                 ===================================================== --}}
            @if($selectedInfant)

                @php

                    $birthDate = \Carbon\Carbon::parse($selectedInfant->birth_date)->startOfDay();
                    $today = now()->startOfDay();

                    /*
                     * Prevent negative age display when a future birth date
                     * exists in the database.
                     */
                    if ($birthDate->greaterThan($today)) {

                        $ageLabel = 'Birth date unavailable';

                    } else {

                        $days = (int) $birthDate->diffInDays($today);
                        $months = (int) $birthDate->diffInMonths($today);
                        $years = (int) $birthDate->diffInYears($today);

                        if ($days < 7) {

                            $ageLabel =
                                $days .
                                ' day' .
                                ($days === 1 ? '' : 's') .
                                ' old';

                        } elseif ($days < 30) {

                            $weeks = (int) floor($days / 7);

                            $ageLabel =
                                $weeks .
                                ' week' .
                                ($weeks === 1 ? '' : 's') .
                                ' old';

                        } elseif ($months < 24) {

                            $ageLabel =
                                $months .
                                ' month' .
                                ($months === 1 ? '' : 's') .
                                ' old';

                        } else {

                            $ageLabel =
                                $years .
                                ' year' .
                                ($years === 1 ? '' : 's') .
                                ' old';

                        }

                    }

                    $latestGrowth = $growthRecords->count()
                        ? $growthRecords->sortByDesc('date_measured')->first()
                        : null;

                    $currentWeight =
                        $latestGrowth->weight ??
                        $selectedInfant->birth_weight;

                    $currentHeight =
                        $latestGrowth->height ??
                        $selectedInfant->birth_length;

                    $currentHeadCircumference =
                        $latestGrowth->head_circumference ??
                        $selectedInfant->head_circumference;

                    $genderKey = strtolower(
                        trim((string) ($selectedInfant->sex ?? ''))
                    );

                    $genderTheme = match($genderKey) {

                        'female' => [
                            'gradient' => 'ifr-gradient-female',
                            'soft'     => 'ifr-soft-female',
                            'text'     => 'ifr-text-female',
                            'border'   => 'ifr-border-female',
                        ],

                        'male' => [
                            'gradient' => 'ifr-gradient-male',
                            'soft'     => 'ifr-soft-male',
                            'text'     => 'ifr-text-male',
                            'border'   => 'ifr-border-male',
                        ],

                        default => [
                            'gradient' => 'ifr-gradient-neutral',
                            'soft'     => 'ifr-soft-neutral',
                            'text'     => 'ifr-text-neutral',
                            'border'   => 'ifr-border-neutral',
                        ],

                    };

                    $genderEmoji = match($genderKey) {

                        'female' => '👧',
                        'male'   => '👦',
                        default  => '🧒',

                    };

                @endphp


                {{-- =====================================================
                     INFANT HERO
                     ===================================================== --}}
                <section class="ifr-hero {{ $genderTheme['gradient'] }}">

                    <div class="ifr-hero-circle ifr-hero-circle-a"></div>
                    <div class="ifr-hero-circle ifr-hero-circle-b"></div>
                    <div class="ifr-hero-circle ifr-hero-circle-c"></div>

                    <div class="ifr-hero-inner">

                        <div
                            class="ifr-baby-avatar"
                            role="img"
                            aria-label="{{ $selectedInfant->sex ?? 'Infant' }}"
                        >
                            {{ $genderEmoji }}
                        </div>

                        <div class="ifr-hero-content">

                            <p class="ifr-hero-eyebrow">
                                Infant Profile
                            </p>

                            <h2 class="ifr-hero-name">
                                {{ $selectedInfant->first_name }}
                                {{ $selectedInfant->middle_name }}
                                {{ $selectedInfant->last_name }}
                            </h2>

                            <p class="ifr-hero-birth">
                                Born {{ $birthDate->format('F d, Y') }}
                            </p>

                            <div class="ifr-hero-tags">

                                <span class="ifr-hero-tag">
                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 6v6l4 2"
                                        />
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        />
                                    </svg>

                                    {{ $ageLabel }}
                                </span>

                                <span class="ifr-hero-tag ifr-hero-tag-solid {{ $genderTheme['text'] }}">
                                    {{ $selectedInfant->sex ?? 'Not set' }}
                                </span>

                                <span class="ifr-hero-tag">

                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5"
                                        />
                                    </svg>

                                    {{ $selectedInfant->birth_status ?? 'Growth on track' }}

                                </span>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =====================================================
                     GROWTH SUMMARY
                     ===================================================== --}}
                <section class="ifr-section">

                    <div class="ifr-section-heading">

                        <div>
                            <span>Current Measurements</span>

                            <h3>
                                Growth Summary
                            </h3>
                        </div>

                        <p>
                            Latest available measurements
                        </p>

                    </div>


                    <div class="ifr-summary-grid">

                        {{-- Weight --}}
                        <div class="ifr-stat-card">

                            <div class="ifr-stat-icon ifr-stat-rose">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"
                                    />
                                </svg>
                            </div>

                            <p class="ifr-stat-label">
                                Weight
                            </p>

                            @if($currentWeight)

                                <p class="ifr-stat-value">
                                    {{ $currentWeight }}
                                    <span>kg</span>
                                </p>

                            @else

                                <p class="ifr-stat-empty">
                                    Not recorded
                                </p>

                            @endif

                        </div>


                        {{-- Height --}}
                        <div class="ifr-stat-card">

                            <div class="ifr-stat-icon ifr-stat-fuchsia">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"
                                    />
                                </svg>
                            </div>

                            <p class="ifr-stat-label">
                                Height
                            </p>

                            @if($currentHeight)

                                <p class="ifr-stat-value">
                                    {{ $currentHeight }}
                                    <span>cm</span>
                                </p>

                            @else

                                <p class="ifr-stat-empty">
                                    Not recorded
                                </p>

                            @endif

                        </div>


                        {{-- Head Circumference --}}
                        <div class="ifr-stat-card">

                            <div class="ifr-stat-icon ifr-stat-pink">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 8v4l3 2"
                                    />
                                </svg>
                            </div>

                            <p class="ifr-stat-label">
                                Head circumference
                            </p>

                            @if($currentHeadCircumference)

                                <p class="ifr-stat-value">
                                    {{ $currentHeadCircumference }}
                                    <span>cm</span>
                                </p>

                            @else

                                <p class="ifr-stat-empty">
                                    Not recorded
                                </p>

                            @endif

                        </div>


                        {{-- Vaccinations --}}
                        <div class="ifr-stat-card">

                            <div class="ifr-stat-icon ifr-stat-blue">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                                    />
                                </svg>
                            </div>

                            <p class="ifr-stat-label">
                                Vaccinations
                            </p>

                            <p class="ifr-stat-value">
                                {{ $vaccinations->count() }}
                                <span>recorded</span>
                            </p>

                        </div>


                        {{-- Growth Status --}}
                        <div class="ifr-stat-card ifr-growth-status">

                            <div class="ifr-stat-icon ifr-stat-green">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 12.75l6 6 9-13.5"
                                    />
                                </svg>
                            </div>

                            <p class="ifr-stat-label">
                                Growth status
                            </p>

                            <p class="ifr-growth-value">
                                {{ $selectedInfant->birth_status ?? 'On track' }}
                            </p>

                        </div>

                    </div>

                </section>


                {{-- =====================================================
                     INFANT INFORMATION
                     ===================================================== --}}
                <section class="ifr-section">

                    <div class="ifr-section-heading">

                        <div>
                            <span>Basic Details</span>

                            <h3>
                                Infant Information
                            </h3>
                        </div>

                    </div>


                    <div class="ifr-info-card">

                        <div class="ifr-info-grid">

                            {{-- Full Name --}}
                            <div class="ifr-info-item">

                                <div class="ifr-info-icon">
                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p>Full name</p>

                                    <strong>
                                        {{ $selectedInfant->first_name }}
                                        {{ $selectedInfant->middle_name }}
                                        {{ $selectedInfant->last_name }}
                                    </strong>
                                </div>

                            </div>


                            {{-- Birth Date --}}
                            <div class="ifr-info-item">

                                <div class="ifr-info-icon ifr-info-amber">
                                    <svg
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p>Birth date</p>

                                    <strong>
                                        {{ $birthDate->format('F d, Y') }}
                                    </strong>
                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =====================================================
                     VACCINATION TIMELINE
                     ===================================================== --}}
                @php

                    $vaccinationStatus = function ($nextDueDate) {

                        if (!$nextDueDate) {

                            return [
                                'label' => 'Completed',
                                'dot'   => 'ifr-dot-completed',
                                'bg'    => 'ifr-status-completed',
                                'text'  => 'ifr-status-text-completed',
                            ];

                        }

                        $due = \Carbon\Carbon::parse($nextDueDate)->startOfDay();

                        $daysRemaining = now()
                            ->startOfDay()
                            ->diffInDays($due, false);

                        if ($daysRemaining < 0) {

                            return [
                                'label' => 'Overdue',
                                'dot'   => 'ifr-dot-overdue',
                                'bg'    => 'ifr-status-overdue',
                                'text'  => 'ifr-status-text-overdue',
                            ];

                        }

                        if ($daysRemaining <= 30) {

                            return [
                                'label' => 'Due Soon',
                                'dot'   => 'ifr-dot-soon',
                                'bg'    => 'ifr-status-soon',
                                'text'  => 'ifr-status-text-soon',
                            ];

                        }

                        return [
                            'label' => 'Completed',
                            'dot'   => 'ifr-dot-completed',
                            'bg'    => 'ifr-status-completed',
                            'text'  => 'ifr-status-text-completed',
                        ];

                    };

                @endphp


                <section class="ifr-section">

                    <div class="ifr-section-heading ifr-section-heading-row">

                        <div>
                            <span>Immunization</span>

                            <h3>
                                Vaccination Timeline
                            </h3>
                        </div>

                        <span class="ifr-count-badge">
                            {{ $vaccinations->count() }}
                            {{ Str::plural('dose', $vaccinations->count()) }}
                        </span>

                    </div>


                    <div class="ifr-vaccination-card">

                        @if($vaccinations->count())

                            <div class="ifr-vax-grid">

                                @foreach($vaccinations as $vaccine)

                                    @php
                                        $status = $vaccinationStatus(
                                            $vaccine->next_due_date
                                        );
                                    @endphp

                                    <div class="ifr-vax-item">

                                        <div class="ifr-vax-line">

                                            <div class="ifr-vax-dot {{ $status['dot'] }}"></div>

                                            @unless($loop->last)
                                                <div class="ifr-vax-connector"></div>
                                            @endunless

                                        </div>


                                        <div class="ifr-vax-body">

                                            <div class="ifr-vax-top">

                                                <p>
                                                    {{ $vaccine->vaccine_name }}
                                                    <span>·</span>
                                                    Dose {{ $vaccine->dose }}
                                                </p>

                                                <span class="ifr-status {{ $status['bg'] }} {{ $status['text'] }}">
                                                    <span class="ifr-status-dot {{ $status['dot'] }}"></span>
                                                    {{ $status['label'] }}
                                                </span>

                                            </div>

                                            <p class="ifr-vax-date">
                                                Given
                                                {{ \Carbon\Carbon::parse($vaccine->date_given)->format('F d, Y') }}
                                            </p>

                                            @if($vaccine->next_due_date)

                                                <p class="ifr-vax-due">
                                                    Next due
                                                    {{ \Carbon\Carbon::parse($vaccine->next_due_date)->format('F d, Y') }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="ifr-empty">

                                <div class="ifr-empty-icon">
                                    <svg
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

                                <p>
                                    No vaccination records found for
                                    {{ $selectedInfant->first_name }}.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- =====================================================
                     VACCINATION HISTORY
                     ===================================================== --}}
                <section class="ifr-section">

                    <div class="ifr-section-heading ifr-section-heading-row">

                        <div>
                            <span>Records</span>

                            <h3>
                                Vaccination History
                            </h3>
                        </div>

                        <span class="ifr-count-badge">
                            {{ $vaccinations->count() }}
                            {{ Str::plural('record', $vaccinations->count()) }}
                        </span>

                    </div>


                    @if($vaccinations->count())

                        <div class="ifr-list-card">

                            @foreach($vaccinations as $vaccine)

                                @php
                                    $historyStatus = $vaccinationStatus(
                                        $vaccine->next_due_date
                                    );
                                @endphp

                                <div class="ifr-history-row">

                                    <div class="ifr-history-icon">
                                        <svg
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"
                                            />
                                        </svg>
                                    </div>

                                    <div class="ifr-history-content">

                                        <div class="ifr-history-top">

                                            <p>
                                                {{ $vaccine->vaccine_name }}
                                                <span>·</span>
                                                Dose {{ $vaccine->dose }}
                                            </p>

                                            <span class="ifr-status {{ $historyStatus['bg'] }} {{ $historyStatus['text'] }}">
                                                <span class="ifr-status-dot {{ $historyStatus['dot'] }}"></span>
                                                {{ $historyStatus['label'] }}
                                            </span>

                                        </div>

                                        <p class="ifr-history-date">
                                            Given
                                            {{ \Carbon\Carbon::parse($vaccine->date_given)->format('F d, Y') }}
                                        </p>

                                        <p class="ifr-history-due">

                                            @if($vaccine->next_due_date)

                                                Next due
                                                {{ \Carbon\Carbon::parse($vaccine->next_due_date)->format('F d, Y') }}

                                            @else

                                                No further dose scheduled

                                            @endif

                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="ifr-empty-card">

                            <div class="ifr-empty-icon">
                                <svg
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

                            <p>
                                No vaccination records found for
                                {{ $selectedInfant->first_name }}.
                            </p>

                        </div>

                    @endif

                </section>


                {{-- =====================================================
                     GROWTH MONITORING
                     ===================================================== --}}
                <section class="ifr-section" id="growth-chart">

                    <div class="ifr-section-heading ifr-section-heading-row">

                        <div>
                            <span>Physical Development</span>

                            <h3>
                                Growth Monitoring
                            </h3>
                        </div>

                        @php
                            $latestGrowth = $growthRecords->first();
                        @endphp

                        @if($latestGrowth)

                            <a
                                href="{{ route('mother.growth-monitoring.show', $latestGrowth) }}"
                                class="ifr-outline-btn"
                            >
                                View growth chart

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
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>

                        @endif

                    </div>


                    @if($growthRecords->count())

                        <div class="ifr-list-card">

                            @foreach($growthRecords as $record)

                                @php

                                    $months = (float) $record->age_in_months;

                                    if ($months < 1) {

                                        $days = round($months * 30);

                                        $ageDisplay =
                                            $days . ' ' .
                                            Str::plural('day', $days) .
                                            ' old';

                                    } elseif ($months < 24) {

                                        $wholeMonths = round($months);

                                        $ageDisplay =
                                            $wholeMonths . ' ' .
                                            Str::plural('month', $wholeMonths) .
                                            ' old';

                                    } else {

                                        $years = (int) floor($months / 12);

                                        $ageDisplay =
                                            $years . ' ' .
                                            Str::plural('year', $years) .
                                            ' old';

                                    }

                                @endphp


                                <div class="ifr-growth-row">

                                    <div class="ifr-growth-icon">
                                        <svg
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 13.5l3-3m0 0l3 3m-3-3v9M21 10.5l-3 3m0 0l-3-3m3 3v-9"
                                            />
                                        </svg>
                                    </div>


                                    <div class="ifr-growth-main">

                                        <p>
                                            {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                                        </p>

                                        <span>
                                            {{ $ageDisplay }}
                                        </span>

                                    </div>


                                    <div class="ifr-growth-values">

                                        <strong>
                                            {{ $record->weight }} kg
                                        </strong>

                                        <span>
                                            {{ $record->height }} cm
                                        </span>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="ifr-empty-card">

                            <div class="ifr-empty-icon {{ $genderTheme['soft'] }} {{ $genderTheme['text'] }}">
                                <svg
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 13.5l3-3m0 0l3 3m-3-3v9M21 10.5l-3 3m0 0l-3-3m3 3v-9"
                                    />
                                </svg>
                            </div>

                            <p>
                                No growth monitoring records found.
                            </p>

                        </div>

                    @endif

                </section>


            @else

                {{-- =====================================================
                     NO INFANT RECORDS
                     ===================================================== --}}
                <section class="ifr-no-infant">

                    <div class="ifr-no-infant-icon">
                        👶
                    </div>

                    <h3>
                        No infant records yet
                    </h3>

                    <p>
                        Once your infant's information is added, their
                        growth, vaccinations, and health records will
                        appear here.
                    </p>

                </section>

            @endif

        </div>

    </div>

</x-app-layout>