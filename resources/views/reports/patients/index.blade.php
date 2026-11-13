<x-app-layout>

    {{-- Shared Administrator styles (admin-only, scoped to .adm-page; no rebuild needed) --}}
    @include('admin.partials.ui-styles')

    <div class="adm-page">
        <div class="adm-container">

            {{-- ====================================== --}}
            {{-- Header --}}
            {{-- ====================================== --}}

            <header class="adm-page-header">

                <div class="adm-page-header-main">
                    <div class="adm-page-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12h6M9 16h4M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/>
                            <circle cx="17.5" cy="17.5" r="3"/>
                            <path d="m21.5 21.5-1.8-1.8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="adm-eyebrow">RHU Records Center</p>
                        <h1 class="adm-page-title">Mother Records</h1>
                        <p class="adm-page-desc">Find a mother by name, Mother Code, contact number, or her infant's name to view her complete maternal and infant records.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag" title="Administrators can view and print records but cannot change them">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="10.5" width="16" height="10" rx="2"/>
                            <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>
                        </svg>
                        <span>View-only access</span>
                    </span>

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
            {{-- Global patient totals (not affected by filters) --}}
            {{-- ====================================== --}}

            <section class="adm-stats adm-stats-compact" aria-label="Registered mothers">
                <div class="adm-stat adm-tone-1">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7.5" r="3.5"/><path d="M5 21a7 7 0 0 1 14 0"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ number_format($totalMothers) }}</p>
                        <p class="adm-stat-label">Registered Mothers</p>
                    </div>
                </div>
                <div class="adm-stat adm-tone-2">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 10h.01M15 10h.01"/><path d="M9.5 15a3.5 3.5 0 0 0 5 0"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ number_format($totalInfants) }}</p>
                        <p class="adm-stat-label">Registered Infants</p>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- Search --}}
            {{-- ====================================== --}}

            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title">Search Mothers</h2>
                            <p class="adm-card-sub">Searching an infant's name returns the mother's record.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">
                    <form method="GET" action="{{ route('reports.patients.index') }}" role="search">
                        <div class="adm-filter-grid adm-filter-grid-wide">

                            <div class="adm-field adm-field-grow">
                                <label for="pr-search">Search mother</label>
                                <div class="adm-input-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    <input
                                        id="pr-search"
                                        type="text"
                                        name="search"
                                        value="{{ $search }}"
                                        maxlength="100"
                                        autocomplete="off"
                                        placeholder="Name, Mother Code, contact number, or infant's name"
                                        class="adm-input">
                                </div>
                            </div>

                            <div class="adm-field">
                                <label for="pr-status">Maternal Status</label>
                                <select id="pr-status" name="status" class="adm-input">
                                    <option value="">All Status</option>
                                    @foreach($statuses as $option)
                                        <option value="{{ $option }}" @selected($status === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="adm-field">
                                <label for="pr-barangay">Barangay</label>
                                <select id="pr-barangay" name="barangay" class="adm-input">
                                    <option value="">All Barangays</option>
                                    @foreach($barangays as $option)
                                        <option value="{{ $option }}" @selected($barangay === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="adm-filter-actions">
                                <button type="submit" class="adm-btn adm-btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                                    Search
                                </button>

                                <a href="{{ route('reports.patients.index') }}" aria-label="Clear search" title="Clear search" class="adm-btn adm-btn-secondary adm-btn-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

            </section>

            {{-- ====================================== --}}
            {{-- Results --}}
            {{-- ====================================== --}}

            <section class="adm-card adm-card-clip" aria-live="polite">

                @if(! $hasCriteria)

                    <div class="adm-empty">
                        <div class="adm-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        </div>
                        <p class="adm-empty-title">Search for a mother</p>
                        <p class="adm-empty-desc">
                            Enter a mother's name, a Mother Code such as MTH-000012, a contact number,
                            or an infant's name. You can also narrow the results by maternal status or barangay.
                        </p>
                    </div>

                @elseif($mothers->total() === 0)

                    <div class="adm-empty">
                        <div class="adm-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/><path d="M8.5 11h5"/></svg>
                        </div>
                        <p class="adm-empty-title">No matching mothers</p>
                        <p class="adm-empty-desc">
                            No mother matches the current search. Check the spelling, try part of the name,
                            or search by Mother Code or contact number instead.
                        </p>
                        <a href="{{ route('reports.patients.index') }}" class="adm-btn adm-btn-secondary">Clear Search</a>
                    </div>

                @else

                    <div class="adm-card-head">
                        <div class="adm-card-head-main">
                            <div class="adm-card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            </div>
                            <div>
                                <h2 class="adm-card-title">Search Results</h2>
                                <p class="adm-card-sub">
                                    Showing {{ $mothers->firstItem() }}–{{ $mothers->lastItem() }} of {{ $mothers->total() }}
                                    {{ $mothers->total() === 1 ? 'mother' : 'mothers' }}.
                                </p>
                            </div>
                        </div>
                        <span class="adm-count">{{ $mothers->total() }} {{ $mothers->total() === 1 ? 'Mother' : 'Mothers' }}</span>
                    </div>

                    <div class="adm-table-scroll">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Mother Code</th>
                                    <th>Mother</th>
                                    <th>Barangay</th>
                                    <th>Contact Number</th>
                                    <th class="adm-center">Status</th>
                                    <th>Records</th>
                                    <th class="adm-center">Action</th>
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
                                        $matchedInfants = $mother->relationLoaded('infants') ? $mother->infants : collect();
                                    @endphp
                                    <tr>
                                        <td data-label="Mother Code"><span class="adm-code">{{ $mother->mother_code }}</span></td>
                                        <td data-label="Mother">
                                            <div>
                                                <p class="adm-strong">{{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}</p>
                                                @if($matchedInfants->isNotEmpty())
                                                    <p class="adm-match">
                                                        Matched infant:
                                                        {{ $matchedInfants->map(fn ($infant) => trim($infant->first_name . ' ' . $infant->last_name))->implode(', ') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="Barangay">{{ $mother->barangay ?: '—' }}</td>
                                        <td data-label="Contact Number">{{ $mother->contact_number ?: '—' }}</td>
                                        <td data-label="Status" class="adm-center">
                                            <span class="adm-pill {{ $statusClass }}">{{ $mother->pregnancyStatusLabel() }}</span>@if ($mother->isReferred())<span class="adm-pill adm-pill-warn" style="margin-left:0.25rem">Referred</span>@endif
                                        </td>
                                        <td data-label="Records">
                                            <div class="adm-record-counts">
                                                <span>{{ $mother->infants_count }} {{ $mother->infants_count === 1 ? 'infant' : 'infants' }}</span>
                                                <span>{{ $mother->prenatal_checkups_count }} prenatal {{ $mother->prenatal_checkups_count === 1 ? 'visit' : 'visits' }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Action" class="adm-center">
                                            @if(Route::has('reports.patients.show'))
                                                <a href="{{ route('reports.patients.show', $mother) }}" class="adm-btn adm-btn-sm adm-btn-edit">
                                                    View Record
                                                </a>
                                            @else
                                                {{-- The consolidated record page is built in the next step. --}}
                                                <span class="adm-btn adm-btn-sm adm-btn-secondary adm-btn-disabled" aria-disabled="true" title="The full record view is not available yet">
                                                    View Record
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($mothers->hasPages())
                        <div class="adm-pagination">
                            {{ $mothers->links() }}
                        </div>
                    @endif

                @endif

            </section>

            <p class="adm-report-footer">
                <strong>Mother records are view-only for Administrators.</strong><br>
                Searches and record access are recorded in the Activity Logs.
            </p>

        </div>
    </div>

</x-app-layout>
