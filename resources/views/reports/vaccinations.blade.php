<x-app-layout>

    {{-- Shared Administrator styles + official print layout (admin-only, scoped to .adm-page) --}}
    @include('admin.partials.ui-styles')

    @php
        // Display-only summary of the filters behind this report (for the printed copy).
        $appliedFilters = array_filter([
            request('search') ? 'Search: "' . request('search') . '"' : null,
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
                <h1 class="adm-print-title">Vaccination Report</h1>
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
                            <path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-eyebrow">Immunization Reporting Center</p>
                        <h1 class="adm-page-title">Vaccination Report</h1>
                        <p class="adm-page-desc">Review vaccination records and infant immunization coverage.</p>
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
                    <h2 class="adm-card-title" id="rp-summary-title">Immunization Overview</h2>
                    <p class="adm-card-sub adm-section-sub">Summary of vaccination records within the current report.</p>
                </div>

                <div class="adm-stats">
                    <div class="adm-stat adm-tone-1">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $totalVaccinations }}</p>
                            <p class="adm-stat-label">Total Vaccinations</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-3">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M9.2 11h.01M14.8 11h.01M9.5 14.5c1.4 1.2 3.6 1.2 5 0"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $totalInfants }}</p>
                            <p class="adm-stat-label">Vaccinated Infants</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-4">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2l4 4M17 7l3-3M19 9l-8.5 8.5a2.1 2.1 0 0 1-3 0l-2-2a2.1 2.1 0 0 1 0-3L14 4M9 11l4 4M5 19l-3 3"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $vaccineTypes }}</p>
                            <p class="adm-stat-label">Vaccine Types</p>
                        </div>
                    </div>
                </div>

            </section>

            {{-- ====================================== --}}
            {{-- Search Toolbar --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-no-print">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Search Vaccination Records</h2>
                            <p class="adm-card-sub">Search vaccination records by vaccine name, infant, or related healthcare information.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">
                    <form method="GET" action="{{ route('reports.vaccinations') }}">
                        <div class="adm-filter-grid">

                            {{-- Search Vaccination Records --}}
                            <div class="adm-field">
                                <label for="rp-search">Search Vaccination Records</label>
                                <div class="adm-input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    <input
                                        id="rp-search"
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search vaccine, dose, or infant..."
                                        class="adm-input">
                                </div>
                            </div>

                            {{-- Barangay Filter --}}
                            <div class="adm-field">
                                <label for="rp-barangay">Barangay</label>
                                <select id="rp-barangay" name="barangay" class="adm-input">
                                    <option value="">All Barangays</option>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay }}" @selected(request('barangay') == $barangay)>
                                            {{ $barangay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Search and Reset Buttons --}}
                            <div class="adm-filter-actions">
                                <button type="submit" class="adm-btn adm-btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    Search
                                </button>

                                <a href="{{ route('reports.vaccinations') }}" aria-label="Reset search" title="Reset search" class="adm-btn adm-btn-secondary adm-btn-icon">
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
                            Showing <strong>{{ $vaccinations->count() }}</strong> vaccination record(s) based on the current search results.
                        </p>
                    </div>

                    <div class="adm-actionbar-buttons">
                        <button type="button" onclick="window.print()" class="adm-btn adm-btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                            Print Report
                        </button>

                        <a href="{{ route('reports.vaccinations.pdf', request()->query()) }}" class="adm-btn adm-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                            Generate PDF
                        </a>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- Vaccination Report Table --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-card-clip">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h6M9 16h6M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Vaccination Report</h2>
                            <p class="adm-card-sub">Immunization records from the CareCradle Electronic Medical Record System.</p>
                        </div>
                    </div>
                    <span class="adm-count">Total Records: {{ $vaccinations->count() }}</span>
                </div>

                @if($vaccinations->count())

                    <div class="adm-table-scroll">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th class="adm-center">#</th>
                                    <th>Infant</th>
                                    <th>Mother</th>
                                    <th>Vaccine</th>
                                    <th>Dose</th>
                                    <th>Date Given</th>
                                    <th>Next Due</th>
                                    <th>Administered By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vaccinations as $vaccination)
                                    <tr>
                                        <td data-label="#" class="adm-center">{{ $loop->iteration }}</td>
                                        <td data-label="Infant">
                                            <p class="adm-strong">{{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }}</p>
                                            <p class="adm-subtext">Infant Patient</p>
                                        </td>
                                        <td data-label="Mother">
                                            <p class="adm-strong">{{ $vaccination->infant->mother->first_name }} {{ $vaccination->infant->mother->last_name }}</p>
                                            <p class="adm-subtext">Mother</p>
                                        </td>
                                        <td data-label="Vaccine">
                                            <span class="adm-pill adm-pill-pink">{{ $vaccination->vaccine_name }}</span>
                                        </td>
                                        <td data-label="Dose">
                                            <span class="adm-chip">{{ $vaccination->dose }}</span>
                                        </td>
                                        <td data-label="Date Given">{{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}</td>
                                        <td data-label="Next Due">
                                            @if($vaccination->next_due_date)
                                                <span class="adm-pill adm-pill-neutral">{{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}</span>
                                            @else
                                                <span class="adm-muted">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Administered By">
                                            <p class="adm-strong">{{ $vaccination->administered_by }}</p>
                                            <p class="adm-subtext">Healthcare Provider</p>
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
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                        </div>
                        <p class="adm-empty-title">No Vaccination Records Found</p>
                        <p class="adm-empty-desc">
                            No vaccination records match the current search criteria. Try modifying the search
                            keyword or resetting the search to display all available immunization records.
                        </p>
                        <a href="{{ route('reports.vaccinations') }}" class="adm-btn adm-btn-secondary adm-no-print">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                            Reset Search
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
