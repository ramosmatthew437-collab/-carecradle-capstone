<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/midwife-dashboard.css') }}">



    {{-- Midwife Dashboard styles are kept separate from the shared application styles. --}}













    <div class="db-wrap">







        <div class="db-container">







            {{-- ====================================== --}}



            {{-- WELCOME BANNER --}}



            {{-- ====================================== --}}







            <section class="db-banner">







                <div class="db-banner-blob db-banner-blob-a" aria-hidden="true"></div>



                <div class="db-banner-blob db-banner-blob-b" aria-hidden="true"></div>







                <div class="db-banner-inner">







                    <div class="db-banner-content">







                        <div class="db-banner-portal">







                            <div class="db-banner-portal-icon">



                                <svg width="20" height="20"



                                     viewBox="0 0 24 24"



                                     fill="none"



                                     stroke="currentColor"



                                     stroke-width="2"



                                     stroke-linecap="round"



                                     stroke-linejoin="round">



                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>



                                </svg>



                            </div>







                            <span class="db-banner-portal-label">



                                Midwife Portal



                            </span>







                        </div>







                        <h1 class="db-banner-title">



                            Welcome back, {{ Auth::user()->name }}



                        </h1>







                        <p class="db-banner-sub">



                            Manage maternal records, prenatal consultations,



                            appointments, infant monitoring, growth tracking,



                            and vaccination schedules.



                        </p>







                    </div>







                    <div class="db-banner-date">







                        <svg width="18" height="18"



                             viewBox="0 0 24 24"



                             fill="none"



                             stroke="currentColor"



                             stroke-width="2"



                             stroke-linecap="round"



                             stroke-linejoin="round">



                            <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>



                        </svg>







                        <div>



                            <p class="db-banner-date-label">Today</p>



                            <p class="db-banner-date-value">



                                {{ now()->format('l, F d, Y') }}



                            </p>



                        </div>







                    </div>







                </div>



            </section>











            {{-- ====================================== --}}



            {{-- SYSTEM OVERVIEW --}}



            {{-- ====================================== --}}







            <section class="db-section">







                <div class="db-section-heading">



                    <p class="db-section-eyebrow">



                        Dashboard



                    </p>







                    <h2 class="db-section-title">



                        System overview



                    </h2>







                    <p class="db-section-sub">



                        Real-time summary of maternal and infant healthcare records



                    </p>



                </div>







                <div class="db-stats">







                    <div class="db-stat">



                        <div class="db-stat-content">



                            <p class="db-stat-label">



                                Registered infants



                            </p>







                            <p class="db-stat-value">



                                {{ $infants }}



                            </p>



                        </div>







                        <div class="db-stat-icon db-stat-icon-rose">



                            <svg width="20" height="20"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>



                                <circle cx="9" cy="7" r="4"/>



                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>



                            </svg>



                        </div>



                    </div>











                    <div class="db-stat">



                        <div class="db-stat-content">



                            <p class="db-stat-label">



                                Registered mothers



                            </p>







                            <p class="db-stat-value">



                                {{ $mothers }}



                            </p>



                        </div>







                        <div class="db-stat-icon db-stat-icon-pink">



                            <svg width="20" height="20"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>



                            </svg>



                        </div>



                    </div>











                    <div class="db-stat">



                        <div class="db-stat-content">



                            <p class="db-stat-label">



                                Vaccinations given



                            </p>







                            <p class="db-stat-value">



                                {{ $vaccinations }}



                            </p>



                        </div>







                        <div class="db-stat-icon db-stat-icon-purple">



                            <svg width="20" height="20"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>



                            </svg>



                        </div>



                    </div>











                    <div class="db-stat">



                        <div class="db-stat-content">



                            <p class="db-stat-label">



                                Upcoming appointments



                            </p>







                            <p class="db-stat-value">



                                {{ $appointments }}



                            </p>



                        </div>







                        <div class="db-stat-icon db-stat-icon-amber">



                            <svg width="20" height="20"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>



                            </svg>



                        </div>



                    </div>







                </div>







            </section>











            {{-- ====================================== --}}



            {{-- QUICK ACTIONS --}}



            {{-- ====================================== --}}







            <section class="db-section">







                <div class="db-section-heading">



                    <p class="db-section-eyebrow">



                        Shortcuts



                    </p>







                    <h2 class="db-section-title">



                        Quick actions



                    </h2>







                    <p class="db-section-sub">



                        Direct access to core system management modules



                    </p>



                </div>







                <div class="db-actions-grid">







                    <a href="{{ route('mothers.index') }}"



                       class="db-action action-mother">







                        <div>







                            <div class="db-action-icon">



                                <svg width="24" height="24"



                                     viewBox="0 0 24 24"



                                     fill="none"



                                     stroke="currentColor"



                                     stroke-width="2"



                                     stroke-linecap="round"



                                     stroke-linejoin="round">



                                    <path d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Z"/>



                                </svg>



                            </div>







                            <p class="db-action-name">



                                Mother Management



                            </p>







                            <p class="db-action-desc">



                                Manage maternal records, prenatal visits,



                                appointments, infant registration, and growth



                                monitoring in one centralized module.



                            </p>







                        </div>







                        <span class="db-action-cta">



                            Open module







                            <svg width="16" height="16"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2.5"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M9 5l7 7-7 7"/>



                            </svg>



                        </span>







                    </a>











                    <a href="{{ route('sms-notifications.index') }}"



                       class="db-action action-sms">







                        <div>







                            <div class="db-action-icon">



                                <svg width="24" height="24"



                                     viewBox="0 0 24 24"



                                     fill="none"



                                     stroke="currentColor"



                                     stroke-width="2"



                                     stroke-linecap="round"



                                     stroke-linejoin="round">



                                    <path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>



                                </svg>



                            </div>







                            <p class="db-action-name">



                                SMS Notifications



                            </p>







                            <p class="db-action-desc">



                                View appointment reminders, monitor notification



                                status, and send healthcare SMS alerts to mothers.



                            </p>







                        </div>







                        <span class="db-action-cta">



                            Open module







                            <svg width="16" height="16"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="2.5"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M9 5l7 7-7 7"/>



                            </svg>



                        </span>







                    </a>







                </div>







            </section>











            {{-- ====================================== --}}



            {{-- TODAY'S APPOINTMENTS + VACCINATIONS --}}



            {{-- ====================================== --}}







            <div class="db-two-col">







                {{-- Today's appointments --}}



                <section class="db-section">







                    <div class="db-row-head">







                        <h2>



                            Today's appointments



                        </h2>







                        <span class="db-badge">



                            {{ $todayAppointments->count() }} scheduled



                        </span>







                    </div>







                    @if($todayAppointments->count())







                        @php



                            $appointmentPillClass = fn ($status) => match ($status) {



                                'Scheduled' => 'db-pill-blue',



                                'Completed' => 'db-pill-emerald',



                                'Cancelled' => 'db-pill-rose',



                                'Missed'    => 'db-pill-yellow',



                                default     => 'db-pill-slate',



                            };



                        @endphp







                        <div class="db-card-list">







                            @foreach($todayAppointments as $appointment)







                                <div class="db-card">







                                    <div class="db-card-time">







                                        <div class="db-card-icon db-card-icon-pink">



                                            <svg width="16" height="16"



                                                 viewBox="0 0 24 24"



                                                 fill="none"



                                                 stroke="currentColor"



                                                 stroke-width="2"



                                                 stroke-linecap="round"



                                                 stroke-linejoin="round">



                                                <circle cx="12" cy="12" r="10"/>



                                                <polyline points="12 6 12 12 16 14"/>



                                            </svg>



                                        </div>







                                        <span class="db-card-time-text">



                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}



                                        </span>







                                    </div>







                                    <p class="db-card-name">



                                        {{ $appointment->mother->first_name }}



                                        {{ $appointment->mother->last_name }}



                                    </p>







                                    <p class="db-card-meta">



                                        {{ $appointment->appointment_type }}



                                    </p>







                                    <span class="db-pill {{ $appointmentPillClass($appointment->status) }}">



                                        <span class="db-pill-dot"></span>



                                        {{ $appointment->status }}



                                    </span>







                                </div>







                            @endforeach







                        </div>







                    @else







                        <div class="db-empty">







                            <div class="db-empty-icon">



                                <svg width="26" height="26"



                                     viewBox="0 0 24 24"



                                     fill="none"



                                     stroke="currentColor"



                                     stroke-width="1.8"



                                     stroke-linecap="round"



                                     stroke-linejoin="round">



                                    <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>



                                </svg>



                            </div>







                            <p class="db-empty-title">



                                No appointments today



                            </p>







                            <p class="db-empty-sub">



                                There are no scheduled appointments for today.



                            </p>







                        </div>







                    @endif







                </section>











                {{-- Upcoming vaccinations --}}



                <section class="db-section">







                    <div class="db-row-head">







                        <h2>



                            Upcoming vaccinations



                        </h2>







                        <span class="db-badge">



                            {{ $upcomingVaccinations->count() }} upcoming



                        </span>







                    </div>







                    @if($upcomingVaccinations->count())







                        <div class="db-card-list">







                            @foreach($upcomingVaccinations as $vaccination)







                                <div class="db-card">







                                    <div class="db-card-person">







                                        <div class="db-card-icon db-card-icon-blue">



                                            <svg width="16" height="16"



                                                 viewBox="0 0 24 24"



                                                 fill="none"



                                                 stroke="currentColor"



                                                 stroke-width="2"



                                                 stroke-linecap="round"



                                                 stroke-linejoin="round">



                                                <path d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>



                                            </svg>



                                        </div>







                                        <p class="db-card-name">



                                            {{ $vaccination->infant->first_name }}



                                            {{ $vaccination->infant->last_name }}



                                        </p>







                                    </div>







                                    <p class="db-card-meta">



                                        {{ $vaccination->vaccine_name }}



                                    </p>







                                    <span class="db-pill db-pill-teal-due">



                                        Due {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}



                                    </span>







                                </div>







                            @endforeach







                        </div>







                    @else







                        <div class="db-empty">







                            <div class="db-empty-icon">



                                <svg width="26" height="26"



                                     viewBox="0 0 24 24"



                                     fill="none"



                                     stroke="currentColor"



                                     stroke-width="1.8"



                                     stroke-linecap="round"



                                     stroke-linejoin="round">



                                    <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>



                                </svg>



                            </div>







                            <p class="db-empty-title">



                                No upcoming vaccinations



                            </p>







                            <p class="db-empty-sub">



                                Upcoming vaccination schedules will appear here once available.



                            </p>







                        </div>







                    @endif







                </section>







            </div>











            {{-- ====================================== --}}



            {{-- RECENT INFANT REGISTRATIONS --}}



            {{-- ====================================== --}}







            <section class="db-section">







                <div class="db-row-head">







                    <h2>



                        Recent infant registrations



                    </h2>







                    <span class="db-badge">



                        {{ $recentInfants->count() }} recent



                    </span>







                </div>







                @if($recentInfants->count())







                    <div class="db-infants">







                        @foreach($recentInfants as $infant)







                            <div class="db-card">







                                <div class="db-card-person">







                                    <div class="db-card-icon db-card-icon-pink">



                                        <svg width="16" height="16"



                                             viewBox="0 0 24 24"



                                             fill="none"



                                             stroke="currentColor"



                                             stroke-width="2"



                                             stroke-linecap="round"



                                             stroke-linejoin="round">



                                            <path d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>



                                        </svg>



                                    </div>







                                    <p class="db-card-name">



                                        {{ $infant->first_name }}



                                        {{ $infant->last_name }}



                                    </p>







                                </div>







                                <p class="db-card-meta">



                                    Mother:



                                    {{ $infant->mother->first_name }}



                                    {{ $infant->mother->last_name }}



                                </p>







                                <span class="db-pill db-pill-emerald">



                                    <span class="db-pill-dot"></span>



                                    Registered {{ $infant->created_at->format('M d, Y') }}



                                </span>







                            </div>







                        @endforeach







                    </div>







                @else







                    <div class="db-empty">







                        <div class="db-empty-icon">



                            <svg width="26" height="26"



                                 viewBox="0 0 24 24"



                                 fill="none"



                                 stroke="currentColor"



                                 stroke-width="1.8"



                                 stroke-linecap="round"



                                 stroke-linejoin="round">



                                <path d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>



                            </svg>



                        </div>







                        <p class="db-empty-title">



                            No infant records yet



                        </p>







                        <p class="db-empty-sub">



                            Newly registered infant records will appear here once available.



                        </p>







                    </div>







                @endif







            </section>











            {{-- ====================================== --}}



            {{-- FOOTER --}}



            {{-- ====================================== --}}







            <footer class="db-footer">







                <div class="db-footer-brand">







                    <div class="db-footer-icon">



                        <svg width="20" height="20"



                             viewBox="0 0 24 24"



                             fill="none"



                             stroke="currentColor"



                             stroke-width="2"



                             stroke-linecap="round"



                             stroke-linejoin="round">



                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>



                        </svg>



                    </div>







                    <div>



                        <p class="db-footer-name">



                            CareCradle Maternal &amp; Infant Health Monitoring System



                        </p>







                        <p class="db-footer-sub">



                            Rural Health Unit Electronic Maternal and Infant Records Management



                        </p>



                    </div>







                </div>







                <div class="db-footer-version">



                    <strong>Version 1.0</strong>



                    &copy; 2026 Veritas College of Irosin



                </div>







            </footer>







        </div>







    </div>







</x-app-layout>