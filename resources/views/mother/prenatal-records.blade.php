<x-app-layout>

    <div class="pnt-wrap">

        <div class="pnt-container">

            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
            <div class="pnt-page-head">

                <button
                    type="button"
                    onclick="history.back()"
                    aria-label="Go back"
                    class="pnt-back-btn"
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

                <div class="pnt-page-copy">

                    <span>Maternal Care</span>

                    <h1>Prenatal Records</h1>

                    <p>
                        Checkup history &amp; monitoring
                    </p>

                </div>

            </div>


            @if($prenatalRecords->count())

                @php

                    /*
                     * Presentation-only status styling.
                     * Existing record values are not changed.
                     */
                    $prenatalStatus = function (
                        $systolic,
                        $diastolic,
                        $fhr
                    ) {

                        $needsFollowUp =
                            $systolic >= 140 ||
                            $diastolic >= 90 ||
                            $fhr < 110 ||
                            $fhr > 170;

                        $monitor =
                            $systolic >= 130 ||
                            $diastolic >= 85 ||
                            $fhr < 120 ||
                            $fhr > 160;


                        if ($needsFollowUp) {

                            return [
                                'label' => 'Needs follow-up',
                                'dot'   => 'pnt-dot-rose',
                                'bg'    => 'pnt-status-rose',
                                'text'  => 'pnt-text-rose',
                            ];

                        }


                        if ($monitor) {

                            return [
                                'label' => 'Monitor',
                                'dot'   => 'pnt-dot-amber',
                                'bg'    => 'pnt-status-amber',
                                'text'  => 'pnt-text-amber',
                            ];

                        }


                        return [
                            'label' => 'Normal',
                            'dot'   => 'pnt-dot-green',
                            'bg'    => 'pnt-status-green',
                            'text'  => 'pnt-text-green',
                        ];

                    };


                    /*
                     * Latest visit is the first record on the current page.
                     * This preserves the original page behavior.
                     */
                    $latestVisit = $prenatalRecords->first();

                    $earlierVisits = $prenatalRecords->skip(1);

                    $latestStatus = $prenatalStatus(
                        $latestVisit->systolic_bp,
                        $latestVisit->diastolic_bp,
                        $latestVisit->fetal_heart_rate
                    );

                @endphp


                {{-- =====================================================
                     LATEST VISIT HERO
                     ===================================================== --}}
                <section class="pnt-hero">

                    <div class="pnt-hero-shape pnt-hero-shape-a"></div>
                    <div class="pnt-hero-shape pnt-hero-shape-b"></div>

                    <div class="pnt-hero-inner">

                        <div class="pnt-hero-top">

                            <div class="pnt-hero-label">

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
                                        d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"
                                    />
                                </svg>

                                Latest Visit

                            </div>


                            <span class="pnt-status-hero">

                                <span class="{{ $latestStatus['dot'] }}"></span>

                                {{ $latestStatus['label'] }}

                            </span>

                        </div>


                        <h2 class="pnt-hero-date">

                            {{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('F d, Y') }}

                        </h2>


                        <div class="pnt-metric-grid">

                            {{-- Gestational Age --}}
                            <div class="pnt-metric">

                                <span>Gestational age</span>

                                <strong>
                                    {{ $latestVisit->gestational_age_weeks }}
                                    <small>wks</small>
                                </strong>

                            </div>


                            {{-- Weight --}}
                            <div class="pnt-metric">

                                <span>Weight</span>

                                <strong>
                                    {{ $latestVisit->weight }}
                                    <small>kg</small>
                                </strong>

                            </div>


                            {{-- Blood Pressure --}}
                            <div class="pnt-metric">

                                <span>Blood pressure</span>

                                <strong>
                                    {{ $latestVisit->systolic_bp }}/{{ $latestVisit->diastolic_bp }}
                                </strong>

                            </div>


                            {{-- Fetal Heart Rate --}}
                            <div class="pnt-metric">

                                <span>Fetal heart rate</span>

                                <strong>
                                    {{ $latestVisit->fetal_heart_rate }}
                                    <small>bpm</small>
                                </strong>

                            </div>

                        </div>




                        {{-- Laboratory Documents --}}
                        @if($latestVisit->attachments->isNotEmpty())
                            <div style="margin-top: 22px; padding: 16px; background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.3); border-radius: 14px;">

                                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 12px;">
                                    Laboratory Documents
                                </h3>

                                <div style="display: grid; gap: 10px;">
                               @foreach($latestVisit->attachments as $attachment)
    @php
        $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
    @endphp

    <div style="
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        background: rgba(255,255,255,0.95);
        border: 1px solid rgba(255,255,255,0.55);
        border-radius: 12px;
        color: #374151;
    ">

        {{-- Document thumbnail --}}
        @if($isImage)
            <a
                href="{{ route('mother.prenatal-attachments.preview', $attachment->id) }}"
                target="_blank"
                rel="noopener noreferrer"
                style="
                    display: block;
                    flex-shrink: 0;
                    width: 92px;
                    height: 82px;
                    overflow: hidden;
                    border-radius: 9px;
                    background: #fce7f3;
                "
            >
                <img
                    src="{{ route('mother.prenatal-attachments.preview', $attachment->id) }}"
                    alt="Laboratory result"
                    loading="lazy"
                    style="width: 100%; height: 100%; object-fit: cover;"
                >
            </a>
        @else
            <div style="
                flex-shrink: 0;
                width: 92px;
                height: 82px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 9px;
                background: #fce7f3;
                color: #be185d;
                font-size: 13px;
                font-weight: 800;
            ">
                PDF
            </div>
        @endif

        {{-- Document information --}}
        <div style="flex: 1; min-width: 0;">

            <strong style="
                display: block;
                font-size: 13px;
                font-weight: 700;
                overflow-wrap: anywhere;
                color: #374151;
            ">
                {{ $attachment->file_name }}
            </strong>

            <span style="
                display: block;
                margin-top: 4px;
                font-size: 11px;
                color: #9ca3af;
            ">
                {{ strtoupper($extension) }}
                ·
                {{ number_format($attachment->file_size / 1024, 1) }} KB
            </span>

            <div style="
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 8px;
                margin-top: 10px;
            ">

                @if($isImage)
                    <a
                        href="{{ route('mother.prenatal-attachments.preview', $attachment->id) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="
                            padding: 6px 12px;
                            border-radius: 7px;
                            background: #fce7f3;
                            color: #be185d;
                            font-size: 11px;
                            font-weight: 700;
                            text-decoration: none;
                        "
                    >
                        View Image
                    </a>
                @endif

                <a
                    href="{{ route('mother.prenatal-attachments.download', $attachment->id) }}"
                    style="
                        padding: 6px 12px;
                        border-radius: 7px;
                        background: #be185d;
                        color: white;
                        font-size: 11px;
                        font-weight: 700;
                        text-decoration: none;
                    "
                >
                    Download
                </a>

            </div>
        </div>
    </div>
@endforeach
                                </div>

                            </div>
                        @endif

                        @if($latestVisit->next_visit_date)

                            <div class="pnt-next-visit">

                                <div class="pnt-next-icon">

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

                                    <p>
                                        Next visit
                                    </p>

                                    <strong>
                                        {{ \Carbon\Carbon::parse($latestVisit->next_visit_date)->format('F d, Y') }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- =====================================================
                     VISIT HISTORY
                     ===================================================== --}}
                @if($earlierVisits->count())

                    <section class="pnt-section">

                        <div class="pnt-section-head">

                            <div>

                                <span>Previous Checkups</span>

                                <h2>
                                    Visit History
                                </h2>

                            </div>

                            <span class="pnt-count-badge">

                                {{ $earlierVisits->count() }}
                                {{ Str::plural('earlier visit', $earlierVisits->count()) }}

                            </span>

                        </div>


                        <div class="pnt-history-grid">

                            @foreach($earlierVisits as $record)

                                @php

                                    $status = $prenatalStatus(
                                        $record->systolic_bp,
                                        $record->diastolic_bp,
                                        $record->fetal_heart_rate
                                    );

                                    $visitDate = \Carbon\Carbon::parse(
                                        $record->visit_date
                                    );

                                @endphp


                                <article class="pnt-history-card">

                                    <div class="pnt-history-top">

                                        <div>

                                            <span class="pnt-history-label">
                                                Prenatal Visit
                                            </span>

                                            <h3>
                                                {{ $visitDate->format('F d, Y') }}
                                            </h3>

                                        </div>


                                        <span class="pnt-week-badge">
                                            Week {{ $record->gestational_age_weeks }}
                                        </span>

                                    </div>


                                    <div class="pnt-record-grid">

                                        {{-- Gestational Age --}}
                                        <div class="pnt-record">

                                            <span>Gest. age</span>

                                            <strong>
                                                {{ $record->gestational_age_weeks }}
                                                <small>wks</small>
                                            </strong>

                                        </div>


                                        {{-- Weight --}}
                                        <div class="pnt-record">

                                            <span>Weight</span>

                                            <strong>
                                                {{ $record->weight }}
                                                <small>kg</small>
                                            </strong>

                                        </div>


                                        {{-- Blood Pressure --}}
                                        <div class="pnt-record">

                                            <span>Blood pressure</span>

                                            <strong>
                                                {{ $record->systolic_bp }}/{{ $record->diastolic_bp }}
                                            </strong>

                                        </div>


                                        {{-- Fetal Heart Rate --}}
                                        <div class="pnt-record">

                                            <span>Fetal heart rate</span>

                                            <strong>
                                                {{ $record->fetal_heart_rate }}
                                                <small>bpm</small>
                                            </strong>

                                        </div>

                                    </div>
                                    {{-- Laboratory Documents --}}
                                    @if($record->attachments->isNotEmpty())
                                        <div style="margin-top: 16px; padding: 14px; background: #fff7fa; border: 1px solid #fce7f3; border-radius: 12px;">

                                            <h4 style="font-size: 13px; font-weight: 700; color: #9d174d; margin-bottom: 10px;">
                                                Laboratory Documents
                                            </h4>

                                            <div style="display: grid; gap: 8px;">
                                                @foreach($record->attachments as $attachment)
    @php
        $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
    @endphp

    <div style="display: flex; flex-direction: column; gap: 10px; padding: 10px 12px; background: #ffffff; border: 1px solid #fce7f3; border-radius: 9px;">

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">

            <div style="min-width: 0;">
                <strong style="display: block; font-size: 12px; color: #374151; overflow-wrap: anywhere;">
                    {{ $attachment->file_name }}
                </strong>

                <span style="font-size: 11px; color: #6b7280;">
                    {{ strtoupper($extension) }}
                    ·
                    {{ number_format($attachment->file_size / 1024, 1) }} KB
                </span>
            </div>

            <a
                href="{{ route('mother.prenatal-attachments.download', $attachment->id) }}"
                style="font-size: 12px; font-weight: 700; color: #be185d; text-decoration: none;"
            >
                Download
            </a>

        </div>

        @if($isImage)
            <a
                href="{{ route('mother.prenatal-attachments.preview', $attachment->id) }}"
                target="_blank"
                rel="noopener noreferrer"
                style="display: block; overflow: hidden; border-radius: 8px; background: #fff7fa;"
            >
                <img
                    src="{{ route('mother.prenatal-attachments.preview', $attachment->id) }}"
                    alt="Laboratory document: {{ $attachment->file_name }}"
                    loading="lazy"
                    style="display: block; width: 100%; max-height: 280px; object-fit: contain; border-radius: 8px;"
                >
            </a>
        @endif

    </div>
@endforeach
                                            </div>

                                        </div>
                                    @endif

                                    <div class="pnt-history-footer">

                                        <span class="pnt-status {{ $status['bg'] }} {{ $status['text'] }}">

                                            <span class="pnt-status-dot {{ $status['dot'] }}"></span>

                                            {{ $status['label'] }}

                                        </span>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </section>

                @endif


                {{-- =====================================================
                     PAGINATION
                     ===================================================== --}}
                <div class="pnt-pagination">

                    {{ $prenatalRecords->links() }}

                </div>


            @else

                {{-- =====================================================
                     EMPTY STATE
                     ===================================================== --}}
                <section class="pnt-empty">

                    <div class="pnt-empty-icon">

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
                                d="M9 12h6m-3-3v6m8.25-3a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0Z"
                            />
                        </svg>

                    </div>


                    <h2>
                        No prenatal records
                    </h2>


                    <p>
                        No prenatal checkup records found.
                    </p>

                </section>

            @endif

        </div>

    </div>

</x-app-layout>