<x-app-layout>

    <div class="rp-wrap py-6 sm:py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-10">



            {{-- ====================================== --}}

            {{-- 1. REPORT HEADER --}}

            {{-- ====================================== --}}



            <header class="rp-page-header" aria-labelledby="rp-page-title">
                <div class="rp-page-header-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18M7.5 15l3-3 2.25 2.25L17.25 9"/>
                    </svg>
                </div>
                <div class="rp-page-header-copy">
                    <p class="rp-page-eyebrow">Reports &amp; Analytics</p>
                    <h1 class="rp-page-title" id="rp-page-title">CareCradle Reports</h1>
                    <p class="rp-page-sub">
                        Generate and review maternal and infant healthcare reports for the Rural Health Unit.
                    </p>
                </div>
                <div class="rp-page-tag">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 19V5M4 19h16"/>
                        <path d="M8 15l3-3 2 2 4-5"/>
                    </svg>
                    <span>Healthcare Reporting Center</span>
                </div>
            </header>


            {{-- 2. REPORT CATEGORIES --}}

            {{-- ====================================== --}}



            <div>



                <div class="rp-section-head">

                    <p class="rp-section-title">

                        Choose a Report

                    </p>



                    <p class="rp-section-sub">

                        Select a category to view its detailed report.

                    </p>

                </div>





                <div class="rp-grid">



                    {{-- ====================================== --}}

                    {{-- APPOINTMENT REPORT --}}

                    {{-- ====================================== --}}



                    <a

                        href="{{ route('reports.appointments') }}"

                        class="rp-card rp-card-amber"

                        aria-label="Open Appointment Report"

                    >



                        <div class="rp-card-top-line" aria-hidden="true"></div>



                        <div class="rp-card-inner">



                            <div class="rp-card-header">



                                <div class="rp-card-icon">

                                    <svg

                                        width="25"

                                        height="25"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18"/>

                                        <path d="M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>

                                    </svg>

                                </div>



                                <div class="rp-card-arrow" aria-hidden="true">

                                    <svg

                                        width="16"

                                        height="16"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                    >

                                        <path d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3"/>

                                    </svg>

                                </div>



                            </div>



                            <div class="rp-card-body">



                                <h3 class="rp-card-title">

                                    Appointment Report

                                </h3>



                                <p class="rp-card-desc">

                                    Generate detailed reports of scheduled prenatal, postnatal, and maternal healthcare appointments.

                                </p>



                            </div>



                            <div class="rp-card-footer">



                                <span class="rp-card-cta">

                                    View Report



                                    <svg

                                        width="14"

                                        height="14"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2.5"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M9 5l7 7-7 7"/>

                                    </svg>

                                </span>



                                <span class="rp-card-meta">

                                    Appointment Records

                                </span>



                            </div>



                        </div>

                    </a>





                    {{-- ====================================== --}}

                    {{-- MOTHER REPORT --}}

                    {{-- ====================================== --}}



                    <a

                        href="{{ route('reports.mothers') }}"

                        class="rp-card rp-card-pink"

                        aria-label="Open Mother Report"

                    >



                        <div class="rp-card-top-line" aria-hidden="true"></div>



                        <div class="rp-card-inner">



                            <div class="rp-card-header">



                                <div class="rp-card-icon">

                                    <svg

                                        width="25"

                                        height="25"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>

                                    </svg>

                                </div>



                                <div class="rp-card-arrow" aria-hidden="true">

                                    <svg

                                        width="16"

                                        height="16"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                    >

                                        <path d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3"/>

                                    </svg>

                                </div>



                            </div>



                            <div class="rp-card-body">



                                <h3 class="rp-card-title">

                                    Mother Report

                                </h3>



                                <p class="rp-card-desc">

                                    View and export comprehensive maternal health records and registered mother information.

                                </p>



                            </div>



                            <div class="rp-card-footer">



                                <span class="rp-card-cta">

                                    View Report



                                    <svg

                                        width="14"

                                        height="14"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2.5"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M9 5l7 7-7 7"/>

                                    </svg>

                                </span>



                                <span class="rp-card-meta">

                                    Maternal Records

                                </span>



                            </div>



                        </div>

                    </a>





                    {{-- ====================================== --}}

                    {{-- INFANT REPORT --}}

                    {{-- ====================================== --}}



                    <a

                        href="{{ route('reports.infants') }}"

                        class="rp-card rp-card-blue"

                        aria-label="Open Infant Report"

                    >



                        <div class="rp-card-top-line" aria-hidden="true"></div>



                        <div class="rp-card-inner">



                            <div class="rp-card-header">



                                <div class="rp-card-icon">

                                    <svg

                                        width="25"

                                        height="25"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                                        <circle cx="9" cy="7" r="4"/>

                                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>

                                    </svg>

                                </div>



                                <div class="rp-card-arrow" aria-hidden="true">

                                    <svg

                                        width="16"

                                        height="16"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                    >

                                        <path d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3"/>

                                    </svg>

                                </div>



                            </div>



                            <div class="rp-card-body">



                                <h3 class="rp-card-title">

                                    Infant Report

                                </h3>



                                <p class="rp-card-desc">

                                    Access infant registration records, growth monitoring information, and healthcare data.

                                </p>



                            </div>



                            <div class="rp-card-footer">



                                <span class="rp-card-cta">

                                    View Report



                                    <svg

                                        width="14"

                                        height="14"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2.5"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M9 5l7 7-7 7"/>

                                    </svg>

                                </span>



                                <span class="rp-card-meta">

                                    Infant Records

                                </span>



                            </div>



                        </div>

                    </a>





                    {{-- ====================================== --}}

                    {{-- VACCINATION REPORT --}}

                    {{-- ====================================== --}}



                    <a

                        href="{{ route('reports.vaccinations') }}"

                        class="rp-card rp-card-emerald"

                        aria-label="Open Vaccination Report"

                    >



                        <div class="rp-card-top-line" aria-hidden="true"></div>



                        <div class="rp-card-inner">



                            <div class="rp-card-header">



                                <div class="rp-card-icon">

                                    <svg

                                        width="25"

                                        height="25"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M19.5 10.5L12 18l-3.75-3.75"/>

                                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                                    </svg>

                                </div>



                                <div class="rp-card-arrow" aria-hidden="true">

                                    <svg

                                        width="16"

                                        height="16"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                    >

                                        <path d="M13.5 4.5L21 12m0 0-7.5 7.5M21 12H3"/>

                                    </svg>

                                </div>



                            </div>



                            <div class="rp-card-body">



                                <h3 class="rp-card-title">

                                    Vaccination Report

                                </h3>



                                <p class="rp-card-desc">

                                    Review vaccination history, immunization schedules, and administered vaccine records.

                                </p>



                            </div>



                            <div class="rp-card-footer">



                                <span class="rp-card-cta">

                                    View Report



                                    <svg

                                        width="14"

                                        height="14"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="2.5"

                                        stroke-linecap="round"

                                        stroke-linejoin="round"

                                        aria-hidden="true"

                                    >

                                        <path d="M9 5l7 7-7 7"/>

                                    </svg>

                                </span>



                                <span class="rp-card-meta">

                                    Immunization Records

                                </span>



                            </div>



                        </div>

                    </a>



                </div>

            </div>



        </div>

    </div>



</x-app-layout>