<x-app-layout>

    {{-- Shared Administrator styles (admin-only, scoped to .adm-page; no rebuild needed) --}}
    @include('admin.partials.ui-styles')

    @php
        // Read-only list for the barangay filter (same source as the patient search page).
        $barangayOptions = \App\Models\Mother::query()
            ->whereNotNull('barangay')
            ->where('barangay', '!=', '')
            ->distinct()
            ->orderBy('barangay')
            ->pluck('barangay');
    @endphp

    <div class="adm-page">
        <div class="adm-container">

            {{-- ====================================== --}}
            {{-- HEADER --}}
            {{-- ====================================== --}}

            <header class="adm-page-header" aria-labelledby="rp-page-title">

                <div class="adm-page-header-main">
                    <div class="adm-page-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12h6M9 16h4M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/>
                            <circle cx="17.5" cy="17.5" r="3"/>
                            <path d="m21.5 21.5-1.8-1.8"/>
                        </svg>
                    </div>

                    <div>
                        <p class="adm-eyebrow">CareCradle Reports</p>
                        <h1 class="adm-page-title" id="rp-page-title">RHU Mother Records Center</h1>
                        <p class="adm-page-desc">Search for a mother to review her complete maternal and infant health records in one place, then print or export them as an official RHU document.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag" title="Administrators can view, print, and export records but cannot change them">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="10.5" width="16" height="10" rx="2"/>
                            <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>
                        </svg>
                        <span>View-only access</span>
                    </span>

                    <a href="{{ route('dashboard') }}" class="adm-btn adm-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                </div>

            </header>

            {{-- ====================================== --}}
            {{-- PATIENT RECORD SEARCH (main feature) --}}
            {{-- ====================================== --}}

            <section class="adm-records-hero" aria-labelledby="rp-patient-title">

                <div class="adm-records-hero-copy">
                    <span class="adm-report-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    </span>
                    <div>
                        <h2 class="adm-records-hero-title" id="rp-patient-title">Find a Mother</h2>
                        <p class="adm-report-desc">Search by the mother's name, Mother Code, contact number, or her infant's name.</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('reports.patients.index') }}" role="search">
                    <div class="adm-filter-grid adm-filter-grid-wide">

                        <div class="adm-field">
                            <label for="rp-patient-search">Search mother</label>
                            <div class="adm-input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                <input
                                    id="rp-patient-search"
                                    type="text"
                                    name="search"
                                    maxlength="100"
                                    autocomplete="off"
                                    placeholder="Name, Mother Code, contact number, or infant's name"
                                    class="adm-input">
                            </div>
                        </div>

                        <div class="adm-field">
                            <label for="rp-patient-status">Maternal Status</label>
                            <select id="rp-patient-status" name="status" class="adm-input">
                                <option value="">All Status</option>
                                <option value="Pregnant">Pregnant</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Referred">Referred</option>
                            </select>
                        </div>

                        <div class="adm-field">
                            <label for="rp-patient-barangay">Barangay</label>
                            <select id="rp-patient-barangay" name="barangay" class="adm-input">
                                <option value="">All Barangays</option>
                                @foreach($barangayOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="adm-filter-actions">
                            <button type="submit" class="adm-btn adm-btn-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                Search Records
                            </button>
                        </div>

                    </div>
                </form>

            </section>

            {{-- ====================================== --}}
            {{-- HOW THE RECORDS CENTER WORKS --}}
            {{-- ====================================== --}}

            <section aria-labelledby="rp-how-title">
                <div class="adm-section-head" style="margin-bottom: 1rem;">
                    <h2 class="adm-card-title" id="rp-how-title" style="font-size: 1.45rem;">What You Can Do</h2>
                    <p class="adm-card-sub">Everything about a mother and her infants, in one consolidated record.</p>
                </div>

                <div class="adm-records-steps">

                    <div class="adm-records-step">
                        <span class="adm-report-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        </span>
                        <h3 class="adm-report-title">Search</h3>
                        <p class="adm-report-desc">Find a mother by name, Mother Code, contact number, or infant's name, and narrow results by maternal status or barangay.</p>
                    </div>

                    <div class="adm-records-step">
                        <span class="adm-report-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </span>
                        <h3 class="adm-report-title">Review the Complete Record</h3>
                        <p class="adm-report-desc">Mother's information, prenatal visits, maternal vaccinations, appointments, postpartum and delivery details, and every related infant's growth and vaccination history.</p>
                    </div>

                    <div class="adm-records-step">
                        <span class="adm-report-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                        </span>
                        <h3 class="adm-report-title">Print or Export PDF</h3>
                        <p class="adm-report-desc">Produce an official Irosin Rural Health Unit document — the complete record or only the sections you need — with signature fields.</p>
                    </div>

                </div>
            </section>

            <p class="adm-report-footer">
                <strong>Mother records are view-only for Administrators.</strong><br>
                Searches, record views, print requests, and PDF exports are recorded in the Activity Logs.
            </p>

        </div>
    </div>

</x-app-layout>
