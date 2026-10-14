<x-app-layout>

    <div class="gmn-wrap">

        <div class="gmn-container">

            {{-- =====================================================
                 PAGE HEADER
                 ===================================================== --}}
            <div class="gmn-page-head">

                <button
                    type="button"
                    onclick="window.history.back()"
                    aria-label="Go back"
                    class="gmn-back-btn"
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

                <div class="gmn-page-copy">

                    <span>Child Health</span>

                    <h1>Growth Monitoring</h1>

                    <p>
                        Track your baby's growth measurements and development records
                    </p>

                </div>

            </div>


            {{-- =====================================================
                 HERO
                 ===================================================== --}}
            <section class="gmn-hero">

                <div class="gmn-hero-shape gmn-hero-shape-a"></div>
                <div class="gmn-hero-shape gmn-hero-shape-b"></div>

                <div class="gmn-hero-inner">

                    <div class="gmn-hero-icon">

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
                                d="M3 17.25V21h3.75L18.81 9.94l-3.75-3.75L3 17.25Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.06 6.19l3.75 3.75"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5.25 17.25h3m-3-3h1.5m-1.5-3h3"
                            />
                        </svg>

                    </div>


                    <div class="gmn-hero-content">

                        <p class="gmn-hero-eyebrow">
                            Baby Development
                        </p>

                        <h2>
                            Growth Monitoring
                        </h2>

                        <p>
                            Keep track of your baby's recorded weight,
                            height, and head circumference measurements.
                        </p>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                 RECORDS
                 ===================================================== --}}
            <section class="gmn-section">

                <div class="gmn-section-head">

                    <div>

                        <span>Recorded Measurements</span>

                        <h2>
                            Growth Records
                        </h2>

                    </div>

                    <span class="gmn-count-badge">
                        {{ $growthRecords->total() }}
                        {{ Str::plural('record', $growthRecords->total()) }}
                    </span>

                </div>


                @if($growthRecords->count())

                    <div class="gmn-record-card">

                        {{-- Desktop / tablet table --}}
                        <div class="gmn-table-wrap">

                            <table class="gmn-table">

                                <thead>

                                    <tr>

                                        <th>
                                            Date Measured
                                        </th>

                                        <th>
                                            Age
                                        </th>

                                        <th>
                                            Weight
                                        </th>

                                        <th>
                                            Height
                                        </th>

                                        <th>
                                            Head Circumference
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($growthRecords as $record)

                                        <tr>

                                            <td>

                                                <div class="gmn-date-cell">

                                                    <div class="gmn-date-icon">

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

                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                                                        </strong>

                                                        <span>
                                                            Measurement date
                                                        </span>

                                                    </div>

                                                </div>

                                            </td>


                                            <td>

                                                <span class="gmn-age-badge">
                                                    {{ $record->age_in_months }}
                                                    {{ Str::plural('month', (float) $record->age_in_months) }}
                                                </span>

                                            </td>


                                            <td>

                                                <div class="gmn-measurement">

                                                    <strong>
                                                        {{ $record->weight }}
                                                    </strong>

                                                    <span>
                                                        kg
                                                    </span>

                                                </div>

                                            </td>


                                            <td>

                                                <div class="gmn-measurement">

                                                    <strong>
                                                        {{ $record->height }}
                                                    </strong>

                                                    <span>
                                                        cm
                                                    </span>

                                                </div>

                                            </td>


                                            <td>

                                                <div class="gmn-measurement">

                                                    <strong>
                                                        {{ $record->head_circumference }}
                                                    </strong>

                                                    <span>
                                                        cm
                                                    </span>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>


                        {{-- Mobile cards --}}
                        <div class="gmn-mobile-list">

                            @foreach($growthRecords as $record)

                                <article class="gmn-mobile-card">

                                    <div class="gmn-mobile-top">

                                        <div class="gmn-date-cell">

                                            <div class="gmn-date-icon">

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

                                                <strong>
                                                    {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                                                </strong>

                                                <span>
                                                    Measurement date
                                                </span>

                                            </div>

                                        </div>


                                        <span class="gmn-age-badge">
                                            {{ $record->age_in_months }}
                                            {{ Str::plural('month', (float) $record->age_in_months) }}
                                        </span>

                                    </div>


                                    <div class="gmn-mobile-measurements">

                                        <div class="gmn-mobile-measurement">

                                            <span>Weight</span>

                                            <strong>
                                                {{ $record->weight }}
                                                <small>kg</small>
                                            </strong>

                                        </div>


                                        <div class="gmn-mobile-measurement">

                                            <span>Height</span>

                                            <strong>
                                                {{ $record->height }}
                                                <small>cm</small>
                                            </strong>

                                        </div>


                                        <div class="gmn-mobile-measurement">

                                            <span>Head circumference</span>

                                            <strong>
                                                {{ $record->head_circumference }}
                                                <small>cm</small>
                                            </strong>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>


                        {{-- Pagination --}}
                        <div class="gmn-pagination">

                            {{ $growthRecords->links() }}

                        </div>

                    </div>

                @else

                    {{-- =================================================
                         EMPTY STATE
                         ================================================= --}}
                    <section class="gmn-empty">

                        <div class="gmn-empty-icon">

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
                                    d="M3 17.25V21h3.75L18.81 9.94l-3.75-3.75L3 17.25Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M14.06 6.19l3.75 3.75"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5.25 17.25h3m-3-3h1.5m-1.5-3h3"
                                />
                            </svg>

                        </div>


                        <h3>
                            No Growth Records
                        </h3>


                        <p>
                            No growth monitoring records found.
                        </p>

                    </section>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>