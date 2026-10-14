<x-app-layout>

    <x-slot name="header">
        <div class="pvd-header">
            <span>Maternal Health Records</span>
            <h2>Prenatal Visit Details</h2>
        </div>
    </x-slot>

    <div class="pvd-page">
        <div class="pvd-container">

            {{-- =========================================================
                 HERO HEADER
            ========================================================== --}}
            <section class="pvd-hero">

                <div class="pvd-hero-main">

                    <div class="pvd-hero-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                    </div>

                    <div class="pvd-hero-copy">
                        <span class="pvd-eyebrow">Prenatal Care Record</span>

                        <h1>Prenatal Visit Details</h1>

                        <p>
                            Review the complete prenatal consultation record including
                            maternal assessment, laboratory findings, clinical observations,
                            and scheduled follow-up care.
                        </p>
                    </div>

                </div>


                {{-- Mother Information --}}
                <div class="pvd-mother-card">

                    <div class="pvd-mother-heading">

                        <div class="pvd-mother-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                            </svg>
                        </div>

                        <div>
                            <span>Mother Information</span>

                            <strong>
                                {{ $prenatalCheckup->mother->first_name }}
                                {{ $prenatalCheckup->mother->last_name }}
                            </strong>
                        </div>

                    </div>


                    <div class="pvd-mother-meta">

                        <div>
                            <span>Mother Code</span>
                            <strong>
                                {{ $prenatalCheckup->mother->mother_code }}
                            </strong>
                        </div>

                        <div>
                            <span>Visit Date</span>
                            <strong>
                                {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                            </strong>
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 VISIT SUMMARY / ACTIONS
            ========================================================== --}}
            <section class="pvd-toolbar">

                <div class="pvd-summary-grid">

                    {{-- Visit Date --}}
                    <div class="pvd-summary-item">

                        <div class="pvd-summary-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                            </svg>
                        </div>

                        <div>
                            <span>Visit Date</span>

                            <strong>
                                {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                            </strong>
                        </div>

                    </div>


                    {{-- Gestational Age --}}
                    <div class="pvd-summary-item">

                        <div class="pvd-summary-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0Z"/>
                            </svg>
                        </div>

                        <div>
                            <span>Gestational Age</span>

                            <strong>
                                {{ $prenatalCheckup->gestational_age_weeks }} Weeks
                            </strong>
                        </div>

                    </div>


                    {{-- Blood Pressure --}}
                    <div class="pvd-summary-item">

                        <div class="pvd-summary-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M21.75 9v.906a2.25 2.25 0 01-.664 1.591l-7.5 7.5a2.25 2.25 0 01-3.182 0l-7.5-7.5A2.25 2.25 0 012.25 9V5.25A2.25 2.25 0 014.5 3h3.75a2.25 2.25 0 011.591.659l1.06 1.06a2.25 2.25 0 001.59.659H19.5a2.25 2.25 0 012.25 2.25V9Z"/>
                            </svg>
                        </div>

                        <div>
                            <span>Blood Pressure</span>

                            <strong>
                                {{ $prenatalCheckup->systolic_bp }}/{{ $prenatalCheckup->diastolic_bp }}
                            </strong>
                        </div>

                    </div>

                </div>


                {{-- Compact Actions --}}
                <div class="pvd-toolbar-actions">

                    <a href="{{ route('prenatal-checkups.edit', $prenatalCheckup->id) }}"
                       class="pvd-btn pvd-btn-edit">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>
                        </svg>

                        Edit
                    </a>


                    <form action="{{ route('prenatal-checkups.destroy', $prenatalCheckup->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this prenatal visit? This action cannot be undone.');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="pvd-btn pvd-btn-delete">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5"/>
                            </svg>

                            Delete
                        </button>

                    </form>


                    <a href="{{ route('mothers.show', $prenatalCheckup->mother_id) }}"
                       class="pvd-btn pvd-btn-back">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>

                        Back
                    </a>

                </div>

            </section>


            {{-- =========================================================
                 VISIT INFORMATION
            ========================================================== --}}
            <section class="pvd-card">

                <div class="pvd-card-header">

                    <div class="pvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Visit Information</h2>

                        <p>
                            Clinical measurements and observations recorded during
                            this prenatal consultation.
                        </p>
                    </div>

                </div>


                <div class="pvd-card-body">

                    <div class="pvd-detail-grid">

                        <div class="pvd-detail-item">
                            <span>Visit Date</span>

                            <strong>
                                {{ \Carbon\Carbon::parse($prenatalCheckup->visit_date)->format('F d, Y') }}
                            </strong>
                        </div>


                        <div class="pvd-detail-item">
                            <span>Gestational Age</span>

                            <strong>
                                {{ $prenatalCheckup->gestational_age_weeks }} Weeks
                            </strong>
                        </div>


                        <div class="pvd-detail-item">
                            <span>Blood Pressure</span>

                            <strong>
                                {{ $prenatalCheckup->systolic_bp }}/{{ $prenatalCheckup->diastolic_bp }}
                            </strong>
                        </div>


                        <div class="pvd-detail-item">
                            <span>Weight</span>

                            <strong>
                                {{ number_format($prenatalCheckup->weight, 2) }} kg
                            </strong>
                        </div>


                        <div class="pvd-detail-item">
                            <span>Fundal Height</span>

                            <strong>
                                {{ $prenatalCheckup->fundal_height ?? '-' }} cm
                            </strong>
                        </div>


                        <div class="pvd-detail-item">
                            <span>Fetal Heart Rate</span>

                            <strong>
                                {{ $prenatalCheckup->fetal_heart_rate ?? '-' }} bpm
                            </strong>
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 LABORATORY FINDINGS
            ========================================================== --}}
            <section class="pvd-card">

                <div class="pvd-card-header">

                    <div class="pvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H15V6.75A2.25 2.25 0 0012.75 4.5h-1.5A2.25 2.25 0 009 6.75v1.5H7.875A3.375 3.375 0 004.5 11.625v2.625A6.75 6.75 0 0011.25 21h1.5a6.75 6.75 0 006.75-6.75Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Laboratory Findings</h2>

                        <p>
                            Laboratory screening results collected during this
                            prenatal consultation.
                        </p>
                    </div>

                </div>


                <div class="pvd-card-body">

                    <div class="pvd-lab-grid">

                        <div class="pvd-lab-item">

                            <div>
                                <span>Urine Protein</span>

                                <strong>
                                    {{ $prenatalCheckup->urine_protein ?? '-' }}
                                </strong>
                            </div>

                            <div class="pvd-lab-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591l-4.87 4.87a2.25 2.25 0 000 3.182l1.318 1.318a2.25 2.25 0 003.182 0l4.87-4.87a2.25 2.25 0 011.591-.659h5.714"/>
                                </svg>
                            </div>

                        </div>


                        <div class="pvd-lab-item">

                            <div>
                                <span>Urine Glucose</span>

                                <strong>
                                    {{ $prenatalCheckup->urine_glucose ?? '-' }}
                                </strong>
                            </div>

                            <div class="pvd-lab-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 3v18m9-9H3"/>
                                </svg>
                            </div>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 ASSESSMENT
            ========================================================== --}}
            <section class="pvd-card">

                <div class="pvd-card-header">

                    <div class="pvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12.75L11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Assessment</h2>

                        <p>
                            Clinical assessment, maternal condition, and healthcare
                            provider observations documented during this prenatal visit.
                        </p>
                    </div>

                </div>


                <div class="pvd-assessment-body">

                    <div class="pvd-note-block">

                        <div class="pvd-note-heading">
                            Maternal Condition
                        </div>

                        <div class="pvd-note-content">
                            <p>
                                {{ $prenatalCheckup->maternal_condition ?: '-' }}
                            </p>
                        </div>

                    </div>


                    <div class="pvd-note-block">

                        <div class="pvd-note-heading">
                            Clinical Notes
                        </div>

                        <div class="pvd-note-content">
                            <p>
                                {{ $prenatalCheckup->notes ?: '-' }}
                            </p>
                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                 FOLLOW-UP CARE
            ========================================================== --}}
            <section class="pvd-card">

                <div class="pvd-card-header">

                    <div class="pvd-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Follow-up Care</h2>

                        <p>
                            Scheduled return appointment for continuing maternal
                            prenatal care.
                        </p>
                    </div>

                </div>


                <div class="pvd-followup-body">

                    <div class="pvd-next-visit">

                        <div>
                            <span>Next Prenatal Visit</span>

                            <strong>
                                {{ $prenatalCheckup->next_visit_date
                                    ? \Carbon\Carbon::parse($prenatalCheckup->next_visit_date)->format('F d, Y')
                                    : '-' }}
                            </strong>
                        </div>

                        <div class="pvd-next-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>
                            </svg>
                        </div>

                    </div>

                </div>

            </section>

        </div>
    </div>

</x-app-layout>