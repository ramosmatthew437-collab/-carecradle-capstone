<x-app-layout>

    {{-- Shared Administrator styles + official print layout (admin-only, scoped to .adm-page) --}}
    @include('admin.partials.ui-styles')

    @php
        // Display-only summary of the filters behind this report (for the printed copy).
        $appliedFilters = array_filter([
            request('search') ? 'Search: "' . request('search') . '"' : null,
            request('status') ? 'Status: ' . request('status') : null,
            (request('from') || request('to'))
                ? 'Date: ' . (request('from') ?: 'start') . ' to ' . (request('to') ?: 'present')
                : null,
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
                <h1 class="adm-print-title">Appointment Report</h1>
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
                            <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-eyebrow">Healthcare Reporting Center</p>
                        <h1 class="adm-page-title">Appointment Report</h1>
                        <p class="adm-page-desc">Review and monitor scheduled maternal appointments and consultation records.</p>
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
            {{-- Appointment Summary (screen and print) --}}
            {{-- ====================================== --}}

            <section aria-labelledby="rp-summary-title">

                <div class="adm-section-head" style="margin-bottom: 0.85rem;">
                    <h2 class="adm-card-title" id="rp-summary-title">Appointment Summary</h2>
                    <p class="adm-card-sub adm-section-sub">Summary of appointment records based on the current report.</p>
                </div>

                <div class="adm-stats">
                    <div class="adm-stat adm-tone-1">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $totalAppointments }}</p>
                            <p class="adm-stat-label">Total Appointments</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-3">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $scheduled }}</p>
                            <p class="adm-stat-label">Scheduled</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-4">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 4.5-5"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $completed }}</p>
                            <p class="adm-stat-label">Completed</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-2">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $cancelled }}</p>
                            <p class="adm-stat-label">Cancelled</p>
                        </div>
                    </div>

                    <div class="adm-stat adm-tone-1">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $missed }}</p>
                            <p class="adm-stat-label">Missed</p>
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
                            <h2 class="adm-card-title">Search &amp; Filter Appointments</h2>
                            <p class="adm-card-sub">Refine the report using patient name, appointment status, and date range.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">
                    <form method="GET" action="{{ route('reports.appointments') }}">
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
                                <label for="rp-status">Appointment Status</label>
                                <select id="rp-status" name="status" class="adm-input">
                                    <option value="">All Status</option>
                                    <option value="Scheduled" @selected(request('status')=='Scheduled')>Scheduled</option>
                                    <option value="Completed" @selected(request('status')=='Completed')>Completed</option>
                                    <option value="Cancelled" @selected(request('status')=='Cancelled')>Cancelled</option>
                                    <option value="Missed" @selected(request('status')=='Missed')>Missed</option>
                                </select>
                            </div>

                            <div class="adm-field">
                                <label for="rp-from">From Date</label>
                                <input
                                    id="rp-from"
                                    type="date"
                                    name="from"
                                    value="{{ request('from') }}"
                                    class="adm-input">
                            </div>

                            <div class="adm-field">
                                <label for="rp-to">To Date</label>
                                <input
                                    id="rp-to"
                                    type="date"
                                    name="to"
                                    value="{{ request('to') }}"
                                    class="adm-input">
                            </div>

                            <div class="adm-field">
                                <label for="rp-barangay">Barangay</label>
                                <select id="rp-barangay" name="barangay" class="adm-input">
                                    <option value="">All Barangays</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay }}" @selected(request('barangay') == $barangay)>
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

                                <a href="{{ route('reports.appointments') }}" aria-label="Reset filters" title="Reset filters" class="adm-btn adm-btn-secondary adm-btn-icon">
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
                            Showing <strong>{{ $appointments->count() }}</strong> appointment record(s) based on the current filters.
                        </p>
                    </div>

                    <div class="adm-actionbar-buttons">
                        <button type="button" onclick="window.print()" class="adm-btn adm-btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                            Print Report
                        </button>

                        <a href="{{ route('reports.appointments.pdf', request()->query()) }}" class="adm-btn adm-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                            Generate PDF
                        </a>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- Appointment Report Table --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-card-clip">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h6M9 16h6M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Appointment Report</h2>
                            <p class="adm-card-sub">Maternal healthcare appointment records generated from the CareCradle Electronic Medical Record System.</p>
                        </div>
                    </div>
                    <span class="adm-count">Total Records: {{ $appointments->count() }}</span>
                </div>

                @if($appointments->count())

                    <div class="adm-table-scroll">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th class="adm-center">#</th>
                                    <th>Mother</th>
                                    <th>Appointment Type</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th class="adm-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)

                                    @php
                                        $statusClass = match($appointment->status) {
                                            'Scheduled' => 'adm-pill-info',
                                            'Completed' => 'adm-pill-success',
                                            'Cancelled' => 'adm-pill-danger',
                                            'Missed' => 'adm-pill-warn',
                                            default => 'adm-pill-neutral',
                                        };
                                    @endphp

                                    <tr>
                                        <td data-label="#" class="adm-center">{{ $loop->iteration }}</td>
                                        <td data-label="Mother">
                                            <p class="adm-strong">{{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}</p>
                                            <p class="adm-subtext">Maternal Patient</p>
                                        </td>
                                        <td data-label="Appointment Type">
                                            <span class="adm-chip">{{ $appointment->appointment_type }}</span>
                                        </td>
                                        <td data-label="Appointment Date">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                        <td data-label="Appointment Time">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                                        <td data-label="Status" class="adm-center">
                                            <span class="adm-pill {{ $statusClass }}">{{ $appointment->status }}</span>
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
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <p class="adm-empty-title">No Appointment Records Found</p>
                        <p class="adm-empty-desc">
                            There are currently no appointment records matching the selected search criteria or
                            reporting filters. Try adjusting the filters or search terms to display available
                            healthcare appointment records.
                        </p>
                        <a href="{{ route('reports.appointments') }}" class="adm-btn adm-btn-secondary adm-no-print">
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
