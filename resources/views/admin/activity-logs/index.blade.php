<x-app-layout>

    {{-- Styles: resources/css/activity-logs.css, loaded through Vite in layouts/app.blade.php.
         Every rule in that file is scoped to .al-page, so it only affects this page. --}}

    @php
        // Display helpers only (no data changes).
        $actionBadgeClass = fn (?string $value) => match (strtolower((string) $value)) {
            'created', 'activated' => 'al-badge-success',
            'updated' => 'al-badge-info',
            'deleted', 'deactivated' => 'al-badge-danger',
            'viewed', 'searched' => 'al-badge-pink',
            'print_requested', 'pdf_export_requested' => 'al-badge-violet',
            'historical_import' => 'al-badge-historical',
            default => 'al-badge-neutral',
        };

        $initials = function (string $name): string {
            $words = preg_split('/[^\pL\pN]+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
            $letters = array_map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)), array_slice($words, 0, 2));

            return implode('', $letters) ?: '?';
        };
    @endphp

    <div class="al-page">
        <div class="al-container">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <header class="al-header" aria-labelledby="al-page-title">

                <div class="al-header-main">
                    <span class="al-header-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 6h13M8 12h13M8 18h13"/>
                            <path d="M3 6h.01M3 12h.01M3 18h.01"/>
                        </svg>
                    </span>

                    <div class="al-header-copy">
                        <p class="al-eyebrow">CareCradle Audit</p>
                        <h1 class="al-title" id="al-page-title">Activity Logs</h1>
                        <p class="al-subtitle">Track staff actions and system record changes.</p>
                    </div>
                </div>

                <div class="al-header-actions">
                    <span class="al-audit-badge">
                        <span class="al-audit-dot" aria-hidden="true"></span>
                        Audit Trail
                    </span>

                    <a href="{{ route('dashboard') }}" class="al-btn al-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                </div>

            </header>

            {{-- ====================================== --}}
            {{-- SUMMARY CARDS --}}
            {{-- ====================================== --}}

            <section class="al-stats" aria-label="Activity summary">

                <div class="al-stat">
                    <div class="al-stat-top">
                        <p class="al-stat-label">All Activities</p>
                        <span class="al-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 6h13M8 12h13M8 18h13"/>
                                <path d="M3 6h.01M3 12h.01M3 18h.01"/>
                            </svg>
                        </span>
                    </div>
                    <p class="al-stat-value">{{ number_format($totalLogs) }}</p>
                    <p class="al-stat-caption">Recorded since tracking began</p>
                </div>

                <div class="al-stat">
                    <div class="al-stat-top">
                        <p class="al-stat-label">Today</p>
                        <span class="al-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M16 3v4M8 3v4M3 11h18"/>
                            </svg>
                        </span>
                    </div>
                    <p class="al-stat-value">{{ number_format($todayLogs) }}</p>
                    <p class="al-stat-caption">{{ now()->format('F j, Y') }}</p>
                </div>

                <div class="al-stat">
                    <div class="al-stat-top">
                        <p class="al-stat-label">Yesterday</p>
                        <span class="al-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        </span>
                    </div>
                    <p class="al-stat-value">{{ number_format($yesterdayLogs) }}</p>
                    <p class="al-stat-caption">Activity from the previous day</p>
                </div>

                <div class="al-stat al-stat-highlight">
                    <div class="al-stat-top">
                        <p class="al-stat-label">Matching Results</p>
                        <span class="al-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-4-4"/>
                            </svg>
                        </span>
                    </div>
                    <p class="al-stat-value">{{ number_format($matchingLogs) }}</p>
                    <p class="al-stat-caption">Based on your current filters</p>
                </div>

            </section>

            {{-- ====================================== --}}
            {{-- FILTER PANEL --}}
            {{-- ====================================== --}}

            <section class="al-card" aria-labelledby="al-filter-title">

                <div class="al-card-head">
                    <div class="al-card-head-main">
                        <span class="al-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 5h18l-7 8v6l-4 2v-8L3 5z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="al-card-title" id="al-filter-title">Find an Activity</h2>
                            <p class="al-card-sub">Filter by date, staff member, module, or action.</p>
                        </div>
                    </div>
                </div>

                <form method="GET"
                      action="{{ route('admin.activity-logs.index') }}"
                      class="al-filter-form">

                    <div class="al-filter-grid">

                        {{-- DATE PRESET --}}
                        <div class="al-field">
                            <label for="date_preset">Date Range</label>
                            <select id="date_preset" name="date_preset" class="al-input">
                                <option value="today" @selected($datePreset === 'today')>Today</option>
                                <option value="yesterday" @selected($datePreset === 'yesterday')>Yesterday</option>
                                <option value="last_7_days" @selected($datePreset === 'last_7_days')>Last 7 Days</option>
                                <option value="last_30_days" @selected($datePreset === 'last_30_days')>Last 30 Days</option>
                                <option value="custom" @selected($datePreset === 'custom')>Custom Date Range</option>
                                <option value="all_time" @selected($datePreset === 'all_time')>All Time</option>
                            </select>
                        </div>

                        {{-- CUSTOM DATE RANGE (shown only for "Custom Date Range") --}}
                        <div id="custom-date-fields"
                             class="al-custom-dates {{ $datePreset === 'custom' ? '' : 'hidden' }}">

                            <div class="al-field">
                                <label for="from_date">From</label>
                                <input type="date" id="from_date" name="from_date"
                                       value="{{ $fromDate }}" class="al-input">
                            </div>

                            <div class="al-field">
                                <label for="to_date">To</label>
                                <input type="date" id="to_date" name="to_date"
                                       value="{{ $toDate }}" class="al-input">
                            </div>

                        </div>

                        {{-- SEARCH --}}
                        <div class="al-field al-field-search">
                            <label for="search">Search</label>
                            <div class="al-input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="11" cy="11" r="7"/>
                                    <path d="m20 20-4-4"/>
                                </svg>
                                <input type="search" id="search" name="search"
                                       value="{{ $search }}"
                                       placeholder="Name, username, description, record ID..."
                                       class="al-input">
                            </div>
                        </div>

                        {{-- STAFF MEMBER --}}
                        <div class="al-field">
                            <label for="actor">Staff Member</label>
                            <select id="actor" name="actor" class="al-input">
                                <option value="">All Staff</option>
                                @foreach ($actors as $staff)
                                    <option value="{{ $staff->actor_username }}"
                                        @selected($actor === $staff->actor_username)>
                                        {{ $staff->actor_name ?: $staff->actor_username }}
                                        ({{ '@' . $staff->actor_username }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- MODULE --}}
                        <div class="al-field">
                            <label for="module">Module</label>
                            <select id="module" name="module" class="al-input">
                                <option value="">All Modules</option>
                                @foreach ($modules as $moduleOption)
                                    <option value="{{ $moduleOption }}"
                                        @selected($module === $moduleOption)>
                                        {{ $moduleOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ACTION --}}
                        <div class="al-field">
                            <label for="action">Action</label>
                            <select id="action" name="action" class="al-input">
                                <option value="">All Actions</option>
                                @foreach ($actions as $actionOption)
                                    <option value="{{ $actionOption }}"
                                        @selected($action === $actionOption)>
                                        {{ \Illuminate\Support\Str::headline($actionOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- FILTER BUTTONS --}}
                    <div class="al-filter-actions">
                        <a href="{{ route('admin.activity-logs.index') }}" class="al-btn al-btn-secondary">
                            Reset Filters
                        </a>

                        <button type="submit" class="al-btn al-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-4-4"/>
                            </svg>
                            Apply Filters
                        </button>
                    </div>

                </form>

            </section>

            {{-- ====================================== --}}
            {{-- ACTIVITY HISTORY --}}
            {{-- ====================================== --}}

            <section class="al-card al-card-clip" aria-labelledby="al-history-title">

                <div class="al-card-head">
                    <div class="al-card-head-main">
                        <span class="al-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="al-card-title" id="al-history-title">Activity History</h2>
                            <p class="al-card-sub">
                                Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}
                                of {{ number_format($logs->total()) }} matching activities
                            </p>
                        </div>
                    </div>

                    <span class="al-pill">Newest First</span>
                </div>

                @if ($logs->isEmpty())

                    {{-- EMPTY STATE --}}
                    <div class="al-empty">
                        <span class="al-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="7"/>
                                <path d="m20 20-4-4"/>
                            </svg>
                        </span>
                        <h3 class="al-empty-title">No activities found</h3>
                        <p class="al-empty-desc">Try another date range or remove some filters.</p>
                        <a href="{{ route('admin.activity-logs.index') }}" class="al-btn al-btn-secondary">
                            Clear all filters
                        </a>
                    </div>

                @else

                    {{-- RESULTS TABLE (stacks into labelled cards on narrow screens) --}}
                    <div class="al-table-wrap">
                        <table class="al-table">
                            <thead>
                                <tr>
                                    <th scope="col">Date &amp; Time</th>
                                    <th scope="col">Performed By</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Module</th>
                                    <th scope="col">Activity Details</th>
                                    <th scope="col">Record ID</th>
                                    <th scope="col">IP Address</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($logs as $log)
                                    @php
                                        $displayName = $log->actor_name
                                            ?: ($log->user?->name ?: 'Deleted / system user');

                                        $displayUsername = $log->actor_username
                                            ?: $log->user?->username;
                                    @endphp

                                    <tr data-al-row>

                                        {{-- DATE AND TIME --}}
                                        <td class="al-col-date" data-label="Date &amp; Time">
                                            <p class="al-date">{{ $log->created_at->format('M d, Y') }}</p>
                                            <p class="al-time">{{ $log->created_at->format('h:i:s A') }}</p>
                                        </td>

                                        {{-- STAFF --}}
                                        <td class="al-col-actor" data-label="Performed By">
                                            <div class="al-actor">
                                                <span class="al-avatar {{ $displayUsername ? '' : 'al-avatar-muted' }}" aria-hidden="true">{{ $initials($displayName) }}</span>
                                                <div class="al-actor-text">
                                                    <p class="al-actor-name">{{ $displayName }}</p>
                                                    @if ($displayUsername)
                                                        <p class="al-actor-username">{{ '@' . $displayUsername }}</p>
                                                    @else
                                                        <p class="al-actor-unknown">Identity not recorded</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- ACTION --}}
                                        <td class="al-col-action" data-label="Action">
                                            <span class="al-badge {{ $actionBadgeClass($log->action) }}">
                                                {{ \Illuminate\Support\Str::headline($log->action) }}
                                            </span>
                                        </td>

                                        {{-- MODULE --}}
                                        <td class="al-col-module" data-label="Module">
                                            <span class="al-module">{{ $log->module }}</span>
                                        </td>

                                        {{-- DESCRIPTION --}}
                                        <td class="al-col-details" data-label="Activity Details">
                                            <p class="al-details">{{ $log->description }}</p>
                                        </td>

                                        {{-- RECORD ID --}}
                                        <td class="al-col-record" data-label="Record ID">
                                            @if ($log->record_id)
                                                <span class="al-code">#{{ $log->record_id }}</span>
                                            @else
                                                <span class="al-dash">—</span>
                                            @endif
                                        </td>

                                        {{-- IP ADDRESS --}}
                                        <td class="al-col-ip" data-label="IP Address">
                                            <span class="al-ip">{{ $log->ip_address ?: '—' }}</span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION (Laravel's links keep the current filters) --}}
                    @if ($logs->hasPages())
                        <div class="al-pagination">
                            {{ $logs->links() }}
                        </div>
                    @endif

                @endif

            </section>

            <p class="al-footnote">
                Activity history is intended for authorized administrative review.
                Historical records may not contain actor details if they were created before identity tracking was added.
            </p>

        </div>
    </div>

    {{-- DATE RANGE INTERACTION --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const preset = document.getElementById('date_preset');

            const customFields = document.getElementById('custom-date-fields');

            function toggleCustomDates() {

                if (!preset || !customFields) {

                    return;

                }

                customFields.classList.toggle(

                    'hidden',

                    preset.value !== 'custom'

                );

            }

            if (preset) {

                preset.addEventListener('change', toggleCustomDates);

                toggleCustomDates();

            }

        });

    </script>

</x-app-layout>
