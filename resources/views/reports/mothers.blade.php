<x-app-layout>

    {{-- Shared Administrator styles + official print layout (admin-only, scoped to .adm-page) --}}
    @include('admin.partials.ui-styles')

    @php
        // Display-only summary of the filters behind this report (for the printed copy).
        $appliedFilters = array_filter([
            request('search') ? 'Search: "' . request('search') . '"' : null,
            request('status') ? 'Status: ' . request('status') : null,
            request('barangay') ? 'Barangay: ' . request('barangay') : null,
        ]);
    @endphp

    <div class="adm-page">
        <div class="adm-container">

            {{-- ====================================== --}}
            {{-- Official print heading (print only) --}}
            {{-- ====================================== --}}

            <div class="adm-print-header adm-print-only">
                <img src="{{ asset('images/system.logo.png') }}" alt="CareCradle logo">
                <div class="adm-print-header-text">
                    <p class="adm-print-municipality">Municipality of Irosin</p>
                    <p class="adm-print-office">Rural Health Unit</p>
                    <p class="adm-print-system">CareCradle Maternal and Infant Health Monitoring System</p>
                </div>
                <span aria-hidden="true"></span>
            </div>

            <div class="adm-print-only">
                <h1 class="adm-print-title">Mother Report</h1>
                <div class="adm-print-meta">
                    <span>Filters: {{ $appliedFilters ? implode(' · ', $appliedFilters) : 'All records' }}</span>
                    <span>Generated: {{ now()->format('F d, Y h:i A') }}</span>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- Header --}}
            {{-- ====================================== --}}

            <header class="adm-page-header adm-no-print">

                <div class="adm-page-header-main">
                    <div class="adm-page-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-eyebrow">Healthcare Reporting Center</p>
                        <h1 class="adm-page-title">Mother Report</h1>
                        <p class="adm-page-desc">Review maternal healthcare records and registration status across the Rural Health Unit.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag" title="Report Generated">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>
                        </svg>
                        <span>{{ now()->format('F d, Y h:i A') }}</span>
                    </span>

                    {{-- Back to Reports --}}
                    <a href="{{ route('reports.index') }}" class="adm-btn adm-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>Back to Reports</span>
                    </a>
                </div>

            </header>

            {{-- ====================================== --}}
            {{-- Summary Statistics (screen and print) --}}
            {{-- ====================================== --}}

            <section aria-labelledby="rp-summary-title">

                <div class="adm-section-head" style="margin-bottom: 0.85rem;">
                    <h2 class="adm-card-title" id="rp-summary-title">Maternal Healthcare Overview</h2>
                    <p class="adm-card-sub adm-section-sub">Summary of registered mothers and maternal healthcare status within the current report.</p>
                </div>

                <div class="adm-stats">
                    <div class="adm-stat adm-tone-1">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $totalMothers }}</p>
                            <p class="adm-stat-label">Total Mothers</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-3">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="3.5"/><path d="M8.5 21v-5.5a3.5 3.5 0 0 1 7 0V21"/><path d="M12 13.5a2.5 2.5 0 0 1 2.5 2.5"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $pregnant }}</p>
                            <p class="adm-stat-label">Pregnant</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-4">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $delivered }}</p>
                            <p class="adm-stat-label">Delivered</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-2">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $referred }}</p>
                            <p class="adm-stat-label">Referred</p>
                        </div>
                    </div>
                </div>

            </section>

            {{-- ====================================== --}}
            {{-- Search & Filter Toolbar --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-no-print">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Search &amp; Filter Mothers</h2>
                            <p class="adm-card-sub">Search maternal records and narrow the report using healthcare status and barangay.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">
                    <form method="GET" action="{{ route('reports.mothers') }}">
                        <div class="adm-filter-grid">

                            <div class="adm-field">
                                <label for="rp-search">Search Mother</label>
                                <div class="adm-input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    <input
                                        id="rp-search"
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search Mother..."
                                        class="adm-input">
                                </div>
                            </div>

                            <div class="adm-field">
                                <label for="rp-status">Maternal Status</label>
                                <select id="rp-status" name="status" class="adm-input">
                                    <option value="">All Status</option>
                                    <option value="Pregnant" @selected(request('status')=='Pregnant')>Pregnant</option>
                                    <option value="Delivered" @selected(request('status')=='Delivered')>Delivered</option>
                                    <option value="Referred" @selected(request('status')=='Referred')>Referred</option>
                                </select>
                            </div>

                            <div class="adm-field">
                                <label for="rp-barangay">Barangay</label>
                                <select id="rp-barangay" name="barangay" class="adm-input">
                                    <option value="">All Barangays</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay }}" @selected(request('barangay')==$barangay)>
                                            {{ $barangay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="adm-filter-actions">
                                <button type="submit" class="adm-btn adm-btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    Search
                                </button>

                                <a href="{{ route('reports.mothers') }}" aria-label="Reset filters" title="Reset filters" class="adm-btn adm-btn-secondary adm-btn-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

            </section>

            {{-- ====================================== --}}
            {{-- Report Action Buttons --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-no-print">
                <div class="adm-actionbar">
                    <div>
                        <h2 class="adm-card-title" style="font-size: 1.05rem;">Report Actions</h2>
                        <p class="adm-actionbar-text">
                            Showing <strong>{{ $mothers->count() }}</strong> registered mother record(s) based on the current search and filters.
                        </p>
                    </div>

                    <div class="adm-actionbar-buttons">
                        <button type="button" onclick="window.print()" class="adm-btn adm-btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                            Print Report
                        </button>

                        <a href="{{ route('reports.mothers.pdf', request()->query()) }}" class="adm-btn adm-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                            Generate PDF
                        </a>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- Mother Report Table --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-card-clip">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h6M9 16h6M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Mother Report</h2>
                            <p class="adm-card-sub">Registered maternal healthcare records from the CareCradle Electronic Medical Record System.</p>
                        </div>
                    </div>
                    <span class="adm-count">Total Records: {{ $mothers->count() }}</span>
                </div>

                @if($mothers->count())

                    <div class="adm-table-scroll">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th class="adm-center">#</th>
                                    <th>Mother Code</th>
                                    <th>Full Name</th>
                                    <th>Barangay</th>
                                    <th>Contact Number</th>
                                    <th class="adm-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mothers as $mother)

                                    @php
                                        $statusClass = match($mother->status) {
                                            'Pregnant' => 'adm-pill-pink',
                                            'Delivered' => 'adm-pill-success',
                                            'Referred' => 'adm-pill-warn',
                                            default => 'adm-pill-neutral',
                                        };
                                    @endphp

                                    <tr>
                                        <td data-label="#" class="adm-center">{{ $loop->iteration }}</td>
                                        <td data-label="Mother Code"><span class="adm-code">{{ $mother->mother_code }}</span></td>
                                        <td data-label="Full Name">
                                            <p class="adm-strong">{{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}</p>
                                            <p class="adm-subtext">Maternal Patient</p>
                                        </td>
                                        <td data-label="Barangay">{{ $mother->barangay }}</td>
                                        <td data-label="Contact Number">{{ $mother->contact_number }}</td>
                                        <td data-label="Status" class="adm-center">
                                            <span class="adm-pill {{ $statusClass }}">{{ $mother->pregnancyStatusLabel() }}</span>@if ($mother->isReferred())<span class="adm-pill adm-pill-warn" style="margin-left:0.25rem">Referred</span>@endif
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                    {{-- Empty State --}}
                    <div class="adm-empty">
                        <div class="adm-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </div>
                        <p class="adm-empty-title">No Mother Records Found</p>
                        <p class="adm-empty-desc">
                            No maternal healthcare records match the current search criteria or selected filters.
                            Try modifying the search keyword, healthcare status, or barangay filter to display
                            available mother records.
                        </p>
                        <a href="{{ route('reports.mothers') }}" class="adm-btn adm-btn-secondary adm-no-print">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                            Reset Filters
                        </a>
                    </div>

                @endif

            </section>

            {{-- ====================================== --}}
            {{-- Signatures (print only) --}}
            {{-- ====================================== --}}

            <div class="adm-signatures adm-print-only">
                <div>
                    <p class="adm-sign-label">Prepared by:</p>
                    <div class="adm-sign-line">
                        <p class="adm-sign-name">{{ Auth::user()->name }}</p>
                        <p class="adm-sign-role">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <div>
                    <p class="adm-sign-label">Approved by:</p>
                    <div class="adm-sign-line">
                        <p class="adm-sign-name">&nbsp;</p>
                        <p class="adm-sign-role">Signature over Printed Name / Designation</p>
                    </div>
                </div>
            </div>

            <footer class="adm-report-footer">
                <strong>CareCradle Electronic Medical Record System</strong><br>
                Irosin Rural Health Unit<br>
                Generated on {{ now()->format('F d, Y') }}
            </footer>

        </div>
    </div>

</x-app-layout>
