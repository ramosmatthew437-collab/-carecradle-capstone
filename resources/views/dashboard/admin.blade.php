<x-app-layout>
<div class="ad-wrap py-6 sm:py-8">

        <div class="ad-content-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7 sm:space-y-8">

            {{-- ====================================== --}}

            {{-- 1. Compact Page Header --}}

            {{-- ====================================== --}}

            <header class="ad-page-header">

                <div class="ad-page-header-main">

                    <div class="ad-page-header-icon" aria-hidden="true">

                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                            <rect x="3" y="3" width="7" height="7" rx="1"/>

                            <rect x="14" y="3" width="7" height="7" rx="1"/>

                            <rect x="3" y="14" width="7" height="7" rx="1"/>

                            <rect x="14" y="14" width="7" height="7" rx="1"/>

                        </svg>

                    </div>

                    <div class="ad-page-header-copy">

                        <p class="ad-page-header-eyebrow">Administrator Control Center</p>

                        <h1 class="ad-page-header-title">Welcome back, {{ Auth::user()->name }}</h1>

                        <p class="ad-page-header-sub">Centralized management of maternal and infant healthcare services.</p>

                    </div>

                </div>

                <div class="ad-page-header-date" aria-label="Current date">

                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">

                        <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>

                    </svg>

                    <span>{{ now()->format('l, F d, Y') }}</span>

                </div>

            </header>

            {{-- 2. System Overview --}}

            {{-- ====================================== --}}

            <div>

                <div class="ad-section-head">

                    <p class="ad-section-title">System Overview</p>

                    <p class="ad-section-sub">Real-time summary of CareCradle records and healthcare services.</p>

                </div>

                <div class="ad-stats-primary">

                    <div class="ad-stat ad-stat-pink">

                        <div class="ad-stat-top">

                            <div class="ad-stat-icon">

                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>

                                </svg>

                            </div>

                            <span class="ad-stat-badge">Mothers</span>

                        </div>

                        <p class="ad-stat-value">{{ $mothers }}</p>

                        <p class="ad-stat-label">Registered Mothers</p>

                    </div>

                    <div class="ad-stat ad-stat-cyan">

                        <div class="ad-stat-top">

                            <div class="ad-stat-icon">

                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                                    <circle cx="9" cy="7" r="4"/>

                                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>

                                </svg>

                            </div>

                            <span class="ad-stat-badge">Infants</span>

                        </div>

                        <p class="ad-stat-value">{{ $infants }}</p>

                        <p class="ad-stat-label">Registered Infants</p>

                    </div>

                    <div class="ad-stat ad-stat-blue">

                        <div class="ad-stat-top">

                            <div class="ad-stat-icon">

                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>

                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>

                                </svg>

                            </div>

                            <span class="ad-stat-badge">Midwives</span>

                        </div>

                        <p class="ad-stat-value">{{ $midwives }}</p>

                        <p class="ad-stat-label">Registered Midwives</p>

                    </div>

                    <div class="ad-stat ad-stat-amber">

                        <div class="ad-stat-top">

                            <div class="ad-stat-icon">

                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>

                                </svg>

                            </div>

                            <span class="ad-stat-badge">Appointments</span>

                        </div>

                        <p class="ad-stat-value">{{ $appointments }}</p>

                        <p class="ad-stat-label">Upcoming Appointments</p>

                    </div>

                </div>

                <div class="ad-stat-secondary">

                    <div class="ad-stat-secondary-icon">

                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                            <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                        </svg>

                    </div>

                    <div>

                        <p class="ad-stat-secondary-value">{{ $vaccinations }}</p>

                        <p class="ad-stat-secondary-label">Vaccinations Administered</p>

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}

            {{-- 3. Quick Actions --}}

            {{-- ====================================== --}}

            <div>

                <div class="ad-section-head">

                    <p class="ad-section-title">Quick Actions</p>

                    <p class="ad-section-sub">Manage users and administrative reports for the CareCradle EMR.</p>

                </div>

                <div class="ad-actions">

                    <a href="{{ route('midwives.index') }}" class="ad-action ad-action-pink" aria-label="Open Midwife Management">

                        <div class="ad-action-blob" aria-hidden="true"></div>

                        <div class="ad-action-body">

                            <div class="ad-action-icon">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>

                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>

                                </svg>

                            </div>

                            <p class="ad-action-name">Midwife Management</p>

                            <p class="ad-action-desc">Manage registered midwives and their access to the CareCradle system.</p>

                            <span class="ad-action-cta">

                                Open module

                                <svg class="ad-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>

                                </svg>

                            </span>

                        </div>

                    </a>

                    <a href="{{ route('reports.index') }}" class="ad-action ad-action-emerald" aria-label="Open Reports">

                        <div class="ad-action-blob" aria-hidden="true"></div>

                        <div class="ad-action-body">

                            <div class="ad-action-icon">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M9 17v-2m3 2v-4m3 4V7m5 12H4.5A2.25 2.25 0 012.25 16.75V4.5A2.25 2.25 0 014.5 2.25h15A2.25 2.25 0 0121.75 4.5v12.25A2.25 2.25 0 0119.5 19Z"/>

                                </svg>

                            </div>

                            <p class="ad-action-name">Reports</p>

                            <p class="ad-action-desc">View and generate maternal, infant, appointment, and vaccination reports.</p>

                            <span class="ad-action-cta">

                                Open module

                                <svg class="ad-action-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>

                                </svg>

                            </span>

                        </div>

                    </a>

                </div>

            </div>

            {{-- ====================================== --}}

            {{-- 4. System Insights --}}

            {{-- ====================================== --}}

            <div class="space-y-8">

                <div class="ad-section-head">

                    <p class="ad-section-title">System Insights</p>

                    <p class="ad-section-sub">Live operational detail behind the summary statistics above.</p>

                </div>

                {{-- Today's Appointments --}}

                <div>

                    <div class="ad-insight-head">

                        <h3>Today's Appointments</h3>

                        <span class="ad-insight-count">{{ $todayAppointments->count() }} today</span>

                    </div>

                    <div class="ad-table-shell">

                        @if($todayAppointments->count())

                            @php

                                $statusPill = fn($s) => match($s) {

                                    'Scheduled' => 'ad-pill-blue',

                                    'Completed' => 'ad-pill-emerald',

                                    'Cancelled' => 'ad-pill-rose',

                                    'Missed'    => 'ad-pill-amber',

                                    default     => 'ad-pill-slate',

                                };

                            @endphp

                            <div class="ad-table-scroll">

                                <table class="ad-table">

                                    <thead>

                                        <tr>

                                            <th>Time</th>

                                            <th>Mother</th>

                                            <th>Type</th>

                                            <th>Status</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($todayAppointments as $appointment)

                                            <tr>

                                                <td>

                                                    <span class="ad-td-time">

                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                                                            <circle cx="12" cy="12" r="10"/>

                                                            <polyline points="12 6 12 12 16 14"/>

                                                        </svg>

                                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}

                                                    </span>

                                                </td>

                                                <td style="font-weight:600;">

                                                    {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}

                                                </td>

                                                <td>

                                                    <span class="ad-chip">{{ $appointment->appointment_type }}</span>

                                                </td>

                                                <td>

                                                    <span class="ad-pill {{ $statusPill($appointment->status) }}">

                                                        <span class="ad-pill-dot"></span>

                                                        {{ $appointment->status }}

                                                    </span>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="ad-empty">

                                <div class="ad-empty-icon">

                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">

                                        <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>

                                    </svg>

                                </div>

                                <p class="ad-empty-title">No Appointments Today</p>

                                <p class="ad-empty-sub">There are no scheduled maternal appointments for today.</p>

                            </div>

                        @endif

                    </div>

                </div>

                {{-- Upcoming Vaccinations --}}

                <div>

                    <div class="ad-insight-head">

                        <h3>Upcoming Vaccinations</h3>

                        <span class="ad-insight-count">{{ $upcomingVaccinations->count() }} upcoming</span>

                    </div>

                    <div class="ad-table-shell">

                        @if($upcomingVaccinations->count())

                            <div class="ad-table-scroll">

                                <table class="ad-table">

                                    <thead>

                                        <tr>

                                            <th>Infant</th>

                                            <th>Vaccine</th>

                                            <th>Next Due Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($upcomingVaccinations as $vaccination)

                                            <tr>

                                                <td style="font-weight:600;">

                                                    {{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }}

                                                </td>

                                                <td class="ad-td-muted">{{ $vaccination->vaccine_name }}</td>

                                                <td>

                                                    <span class="ad-pill ad-pill-due">

                                                        {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}

                                                    </span>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="ad-empty">

                                <div class="ad-empty-icon ad-empty-icon-emerald">

                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">

                                        <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                    </svg>

                                </div>

                                <p class="ad-empty-title">No Upcoming Vaccinations</p>

                                <p class="ad-empty-sub">Upcoming infant immunization schedules will appear here once vaccination records are available.</p>

                            </div>

                        @endif

                    </div>

                </div>

                {{-- Recent Infant Registrations --}}

                <div>

                    <div class="ad-insight-head">

                        <h3>Recent Infant Registrations</h3>

                        <span class="ad-insight-count">{{ $recentInfants->count() }} recent</span>

                    </div>

                    <div class="ad-table-shell">

                        @if($recentInfants->count())

                            <div class="ad-table-scroll">

                                <table class="ad-table">

                                    <thead>

                                        <tr>

                                            <th>Infant</th>

                                            <th>Mother</th>

                                            <th>Registration Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($recentInfants as $infant)

                                            <tr>

                                                <td style="font-weight:600;">

                                                    {{ $infant->first_name }} {{ $infant->last_name }}

                                                </td>

                                                <td class="ad-td-muted">

                                                    {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}

                                                </td>

                                                <td>

                                                    <span class="ad-pill ad-pill-blue">

                                                        <span class="ad-pill-dot"></span>

                                                        {{ $infant->created_at->format('M d, Y') }}

                                                    </span>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @else

                            <div class="ad-empty">

                                <div class="ad-empty-icon">

                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">

                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                                        <circle cx="9" cy="7" r="4"/>

                                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>

                                    </svg>

                                </div>

                                <p class="ad-empty-title">No Infant Records Yet</p>

                                <p class="ad-empty-sub">Newly registered infant records will appear here once patients are enrolled in the CareCradle system.</p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- ====================================== --}}

            {{-- 5. System Information --}}

            {{-- ====================================== --}}

            <div class="ad-sys-footer">

                <div class="ad-sys-footer-brand">

                    <div class="ad-sys-footer-icon">

                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">

                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>

                        </svg>

                    </div>

                    <div>

                        <p class="ad-sys-footer-name">CareCradle Maternal &amp; Infant Health Monitoring System</p>

                        <p class="ad-sys-footer-sub">Rural Health Unit Electronic Maternal and Infant Records Management</p>

                    </div>

                </div>

                <div class="ad-sys-footer-version">

                    <strong>Version 1.0 &middot; Administrator Dashboard</strong>

                    &copy; {{ date('Y') }} Irosin Rural Health Unit. All Rights Reserved.

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
