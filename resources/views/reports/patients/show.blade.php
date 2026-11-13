<x-app-layout>

    {{-- Shared Administrator styles (admin-only, scoped to .adm-page; no rebuild needed) --}}
    @include('admin.partials.ui-styles')

    @php
        /*
         * Display helpers only — no data is changed on this page.
         */
        $date = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('M d, Y') : '—';
        $time = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('g:i A') : '—';
        $text = fn ($value) => ($value === null || $value === '') ? '—' : $value;
        $num = fn ($value, $decimals = 2) => ($value === null || $value === '') ? '—' : number_format((float) $value, $decimals);

        $fullName = trim(implode(' ', array_filter([$mother->first_name, $mother->middle_name, $mother->last_name])));
        $initials = strtoupper(substr((string) $mother->first_name, 0, 1) . substr((string) $mother->last_name, 0, 1));
        $age = $mother->birth_date ? \Carbon\Carbon::parse($mother->birth_date)->age : null;

        $fatherName = trim(implode(' ', array_filter([$mother->father_first_name, $mother->father_middle_name, $mother->father_last_name])));

        $motherStatusClass = match ($mother->status) {
            'Pregnant' => 'adm-pill-pink',
            'Delivered' => 'adm-pill-success',
            'Referred' => 'adm-pill-warn',
            default => 'adm-pill-neutral',
        };

        $appointmentStatusClass = fn ($status) => match ($status) {
            'Scheduled' => 'adm-pill-info',
            'Completed' => 'adm-pill-success',
            'Cancelled' => 'adm-pill-danger',
            'Missed' => 'adm-pill-warn',
            default => 'adm-pill-neutral',
        };

        $postpartumAppointments = $mother->appointments->where('appointment_type', 'Postpartum');
        $infantAppointmentsCount = $mother->appointments->whereIn('appointment_type', ['Infant Checkup', 'Vaccination'])->count();

        $fileType = function ($attachment) {
            $extension = strtoupper(pathinfo((string) $attachment->file_name, PATHINFO_EXTENSION));
            return $extension !== '' ? $extension : 'File';
        };
        $fileSize = fn ($bytes) => $bytes >= 1048576
            ? number_format($bytes / 1048576, 1) . ' MB'
            : max(1, (int) round($bytes / 1024)) . ' KB';
    @endphp

    <div class="adm-page">
        <div class="adm-container">

            {{-- ====================================== --}}
            {{-- PATIENT HEADER --}}
            {{-- ====================================== --}}

            <header class="adm-page-header adm-record-header">

                <div class="adm-page-header-main">
                    <div class="adm-record-avatar" aria-hidden="true">{{ $initials }}</div>
                    <div>
                        <p class="adm-eyebrow">Mother Record</p>
                        <h1 class="adm-page-title">{{ $fullName }}</h1>
                        <div class="adm-record-meta">
                            <span class="adm-code" title="Mother Code">{{ $mother->mother_code }}</span>
                            <span class="adm-pill {{ $motherStatusClass }}">{{ $mother->pregnancyStatusLabel() }}</span>@if ($mother->isReferred())<span class="adm-pill adm-pill-warn" style="margin-left:0.25rem">Referred</span>@endif
                            @if($age !== null)
                                <span>{{ $age }} years old</span>
                            @endif
                            <span>{{ $text($mother->barangay) }}</span>
                            <span>{{ $text($mother->contact_number) }}</span>
                        </div>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag" title="Administrators can view this record but cannot change it">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="4" y="10.5" width="16" height="10" rx="2"/>
                            <path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/>
                        </svg>
                        <span>View-only record</span>
                    </span>

                    <a href="{{ $backUrl }}" class="adm-btn adm-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        <span>Back to Mother Search</span>
                    </a>

                    <a href="{{ route('reports.patients.print', $mother) }}" target="_blank" rel="noopener" class="adm-btn adm-btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                        <span>Print Record</span>
                    </a>

                    <a href="{{ route('reports.patients.pdf', $mother) }}" class="adm-btn adm-btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                        <span>Export PDF</span>
                    </a>
                </div>

            </header>

            {{-- Quick figures --}}
            <section class="adm-stats" aria-label="Record summary">
                <div class="adm-stat adm-tone-1">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h6M9 16h6M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $mother->prenatalCheckups->count() }}</p>
                        <p class="adm-stat-label">Prenatal Visits</p>
                    </div>
                </div>
                <div class="adm-stat adm-tone-3">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $mother->maternalVaccinations->count() }}</p>
                        <p class="adm-stat-label">Maternal Vaccinations</p>
                    </div>
                </div>
                <div class="adm-stat adm-tone-4">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $mother->appointments->count() }}</p>
                        <p class="adm-stat-label">Appointments</p>
                    </div>
                </div>
                <div class="adm-stat adm-tone-2">
                    <div class="adm-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M9.2 11h.01M14.8 11h.01M9.5 14.5c1.4 1.2 3.6 1.2 5 0"/></svg>
                    </div>
                    <div>
                        <p class="adm-stat-value">{{ $mother->infants->count() }}</p>
                        <p class="adm-stat-label">Registered Infants</p>
                    </div>
                </div>
            </section>

            {{-- Print / export selected sections (GET only — chooses what to include, changes nothing) --}}
            <section class="adm-card" aria-labelledby="pr-export-title">
                <form method="GET" action="{{ route('reports.patients.print', $mother) }}" target="_blank" class="adm-export">
                    <div class="adm-export-copy">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                        </div>
                        <div>
                            <h2 class="adm-card-title" id="pr-export-title">Print or Export Sections</h2>
                            <p class="adm-card-sub">Choose the sections to include. Leave all selected for the complete record.</p>
                        </div>
                    </div>

                    <fieldset class="adm-export-options">
                        <legend class="sr-only">Sections to include</legend>
                        @foreach($sections as $key => $label)
                            <label class="adm-check">
                                <input type="checkbox" name="sections[]" value="{{ $key }}" checked>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </fieldset>

                    <div class="adm-export-actions">
                        <button type="submit" class="adm-btn adm-btn-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V3h12v6"/><rect x="3" y="9" width="18" height="8" rx="2"/><path d="M6 14h12v7H6z"/></svg>
                            Print Selected
                        </button>
                        <button type="submit" formaction="{{ route('reports.patients.pdf', $mother) }}" formtarget="_self" class="adm-btn adm-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12m0 0-4-4m4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                            Export Selected as PDF
                        </button>
                    </div>
                </form>
            </section>

            {{-- Section navigation --}}
            <nav class="adm-record-nav" aria-label="Record sections">
                <a href="#overview">Overview</a>
                <a href="#prenatal">Prenatal Visits <span>{{ $mother->prenatalCheckups->count() }}</span></a>
                <a href="#maternal-vaccinations">Maternal Vaccinations <span>{{ $mother->maternalVaccinations->count() }}</span></a>
                <a href="#appointments">Appointments <span>{{ $mother->appointments->count() }}</span></a>
                <a href="#postpartum">Postpartum &amp; Delivery</a>
                <a href="#infants">Infants <span>{{ $mother->infants->count() }}</span></a>
            </nav>

            {{-- ====================================== --}}
            {{-- 1. OVERVIEW --}}
            {{-- ====================================== --}}

            <section id="overview" class="adm-record-section" aria-labelledby="sec-overview">
                <h2 class="adm-record-heading" id="sec-overview">Overview</h2>

                <div class="adm-record-grid">

                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <div class="adm-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                                </div>
                                <h3 class="adm-card-title">Personal Information</h3>
                            </div>
                        </div>
                        <dl class="adm-dl">
                            <div><dt>Full Name</dt><dd>{{ $fullName }}</dd></div>
                            <div><dt>Mother Code</dt><dd>{{ $mother->mother_code }}</dd></div>
                            <div><dt>Birth Date</dt><dd>{{ $date($mother->birth_date) }}{{ $age !== null ? ' (' . $age . ' yrs)' : '' }}</dd></div>
                            <div><dt>Civil Status</dt><dd>{{ $text($mother->civil_status) }}</dd></div>
                            <div><dt>Occupation</dt><dd>{{ $text($mother->occupation) }}</dd></div>
                            <div><dt>Blood Type</dt><dd>{{ $text($mother->blood_type) }}</dd></div>
                            <div><dt>PhilHealth No.</dt><dd>{{ $text($mother->philhealth_number) }}</dd></div>
                            <div><dt>Contact Number</dt><dd>{{ $text($mother->contact_number) }}</dd></div>
                            <div><dt>Barangay</dt><dd>{{ $text($mother->barangay) }}</dd></div>
                            <div class="adm-dl-wide"><dt>Address</dt><dd>{{ $text($mother->address) }}</dd></div>
                        </dl>
                    </div>

                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <div class="adm-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </div>
                                <h3 class="adm-card-title">Maternal &amp; Pregnancy Information</h3>
                            </div>
                        </div>
                        <dl class="adm-dl">
                            <div><dt>Pregnancy Status</dt><dd><span class="adm-pill {{ $motherStatusClass }}">{{ $mother->pregnancyStatusLabel() }}</span>@if ($mother->isReferred())<span class="adm-pill adm-pill-warn" style="margin-left:0.25rem">Referred</span>@endif</dd></div>
                            <div><dt>Pregnancy Number</dt><dd>{{ $text($mother->pregnancy_number) }}</dd></div>
                            <div><dt>Last Menstrual Period</dt><dd>{{ $date($mother->last_menstrual_period) }}</dd></div>
                            <div><dt>Expected Delivery Date</dt><dd>{{ $date($mother->expected_delivery_date) }}</dd></div>
                            <div><dt>Height</dt><dd>{{ $num($mother->height) }}{{ $mother->height ? ' cm' : '' }}</dd></div>
                            <div><dt>Weight</dt><dd>{{ $num($mother->weight) }}{{ $mother->weight ? ' kg' : '' }}</dd></div>
                        </dl>
                    </div>

                    {{-- Referral history: read-only for Administrators (recorded by Midwives). --}}
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <h3 class="adm-card-title">Referral</h3>
                            </div>
                        </div>
                        @include('mothers.referrals._styles')
                        <div class="mrf" style="padding:0 1.25rem 1.25rem">
                            @if ($mother->isLegacyReferred())
                                <p class="mrf-hint" style="margin:0 0 0.5rem">Marked Referred before referral details were tracked; date, facility and reason were not recorded, and the pregnancy status is unknown.</p>
                            @endif
                            @include('mothers.referrals._history', ['referrals' => $mother->referrals])
                        </div>
                    </div>

                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <div class="adm-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M17 8h5M19.5 5.5v5"/></svg>
                                </div>
                                <h3 class="adm-card-title">Father's Information</h3>
                            </div>
                        </div>
                        <dl class="adm-dl">
                            <div><dt>Name</dt><dd>{{ $fatherName !== '' ? $fatherName : '—' }}</dd></div>
                            <div><dt>Birth Date</dt><dd>{{ $date($mother->father_birth_date) }}</dd></div>
                            <div><dt>Contact Number</dt><dd>{{ $text($mother->father_contact_number) }}</dd></div>
                            <div><dt>Occupation</dt><dd>{{ $text($mother->father_occupation) }}</dd></div>
                        </dl>
                    </div>

                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <div class="adm-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10.5" width="16" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/></svg>
                                </div>
                                <h3 class="adm-card-title">Portal Account &amp; Consent</h3>
                            </div>
                        </div>
                        <dl class="adm-dl">
                            <div><dt>Portal Username</dt><dd>{{ $mother->user?->username ? '@' . $mother->user->username : '—' }}</dd></div>
                            <div>
                                <dt>Data Privacy Consent</dt>
                                <dd>
                                    @if($mother->privacy_consent_at)
                                        Given on {{ $date($mother->privacy_consent_at) }}
                                    @else
                                        Not yet recorded
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 2. PRENATAL VISITS --}}
            {{-- ====================================== --}}

            <section id="prenatal" class="adm-record-section" aria-labelledby="sec-prenatal">
                <h2 class="adm-record-heading" id="sec-prenatal">
                    Prenatal Visits
                    <span class="adm-count">{{ $mother->prenatalCheckups->count() }}</span>
                </h2>

                @forelse($mother->prenatalCheckups as $visit)
                    <article class="adm-card adm-visit">
                        <div class="adm-visit-head">
                            <div>
                                <p class="adm-visit-date">{{ $date($visit->visit_date) }}</p>
                                <p class="adm-visit-sub">Visit {{ $mother->prenatalCheckups->count() - $loop->index }} of {{ $mother->prenatalCheckups->count() }}</p>
                            </div>
                            <div class="adm-visit-tags">
                                <span class="adm-pill adm-pill-pink">{{ $text($visit->gestational_age_weeks) }} weeks AOG</span>
                                <span class="adm-pill adm-pill-neutral">Next visit: {{ $date($visit->next_visit_date) }}</span>
                            </div>
                        </div>

                        <dl class="adm-dl adm-dl-compact">
                            <div><dt>Weight</dt><dd>{{ $num($visit->weight) }} kg</dd></div>
                            <div><dt>Blood Pressure</dt><dd>{{ $text($visit->systolic_bp) }}/{{ $text($visit->diastolic_bp) }} mmHg</dd></div>
                            <div><dt>Fundal Height</dt><dd>{{ $visit->fundal_height !== null ? $num($visit->fundal_height) . ' cm' : '—' }}</dd></div>
                            <div><dt>Fetal Heart Rate</dt><dd>{{ $visit->fetal_heart_rate !== null ? $visit->fetal_heart_rate . ' bpm' : '—' }}</dd></div>
                            <div><dt>Fetal Movement</dt><dd>{{ $text($visit->fetal_movement) }}</dd></div>
                            <div><dt>Urine Protein</dt><dd>{{ $text($visit->urine_protein) }}</dd></div>
                            <div><dt>Urine Glucose</dt><dd>{{ $text($visit->urine_glucose) }}</dd></div>
                            <div class="adm-dl-wide"><dt>Maternal Condition</dt><dd>{{ $text($visit->maternal_condition) }}</dd></div>
                            <div class="adm-dl-wide"><dt>Notes</dt><dd>{{ $text($visit->notes) }}</dd></div>
                        </dl>

                        <div class="adm-visit-files">
                            <p class="adm-visit-files-title">
                                Laboratory Attachments
                                <span>(file names only)</span>
                            </p>
                            @if($visit->attachments->isNotEmpty())
                                <ul class="adm-file-list">
                                    @foreach($visit->attachments as $attachment)
                                        <li>
                                            <span class="adm-file-type">{{ $fileType($attachment) }}</span>
                                            <span class="adm-file-name">{{ $attachment->file_name }}</span>
                                            <span class="adm-file-size">{{ $fileSize((int) $attachment->file_size) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="adm-muted adm-small">No laboratory documents uploaded for this visit.</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="adm-card">
                        <div class="adm-empty">
                            <p class="adm-empty-title">No prenatal visits recorded</p>
                            <p class="adm-empty-desc">Prenatal visits added by the midwife will appear here.</p>
                        </div>
                    </div>
                @endforelse
            </section>

            {{-- ====================================== --}}
            {{-- 3. MATERNAL VACCINATIONS --}}
            {{-- ====================================== --}}

            <section id="maternal-vaccinations" class="adm-record-section" aria-labelledby="sec-mvax">
                <h2 class="adm-record-heading" id="sec-mvax">
                    Maternal Vaccinations
                    <span class="adm-count">{{ $mother->maternalVaccinations->count() }}</span>
                </h2>

                <div class="adm-card adm-card-clip">
                    @if($mother->maternalVaccinations->isNotEmpty())
                        <div class="adm-table-scroll">
                            <table class="adm-table">
                                <thead>
                                    <tr>
                                        <th>Vaccine</th>
                                        <th>Dose</th>
                                        <th>Date Given</th>
                                        <th>Next Due</th>
                                        <th>Administered By</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mother->maternalVaccinations as $vaccination)
                                        <tr>
                                            <td data-label="Vaccine"><span class="adm-pill adm-pill-pink">{{ $vaccination->vaccine_name }}</span></td>
                                            <td data-label="Dose">{{ $text($vaccination->dose) }}</td>
                                            <td data-label="Date Given">{{ $date($vaccination->date_given) }}</td>
                                            <td data-label="Next Due">{{ $date($vaccination->next_due_date) }}</td>
                                            <td data-label="Administered By">{{ $text($vaccination->administered_by) }}</td>
                                            <td data-label="Remarks">{{ $text($vaccination->remarks) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="adm-empty">
                            <p class="adm-empty-title">No maternal vaccinations recorded</p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 4. APPOINTMENTS --}}
            {{-- ====================================== --}}

            <section id="appointments" class="adm-record-section" aria-labelledby="sec-appointments">
                <h2 class="adm-record-heading" id="sec-appointments">
                    Appointment History
                    <span class="adm-count">{{ $mother->appointments->count() }}</span>
                </h2>

                <div class="adm-card adm-card-clip">
                    @if($mother->appointments->isNotEmpty())
                        <div class="adm-table-scroll">
                            <table class="adm-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th class="adm-center">Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mother->appointments as $appointment)
                                        <tr>
                                            <td data-label="Date">{{ $date($appointment->appointment_date) }}</td>
                                            <td data-label="Time">{{ $time($appointment->appointment_time) }}</td>
                                            <td data-label="Type"><span class="adm-chip">{{ $appointment->appointment_type }}</span></td>
                                            <td data-label="Status" class="adm-center"><span class="adm-pill {{ $appointmentStatusClass($appointment->status) }}">{{ $appointment->status }}</span></td>
                                            <td data-label="Notes">{{ $text($appointment->notes) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="adm-empty">
                            <p class="adm-empty-title">No appointments recorded</p>
                        </div>
                    @endif
                </div>

                @if($infantAppointmentsCount > 0)
                    <p class="adm-record-hint">
                        Infant Checkup and Vaccination appointments are recorded under the mother in CareCradle;
                        they are not linked to a specific infant.
                    </p>
                @endif
            </section>

            {{-- ====================================== --}}
            {{-- 5. POSTPARTUM & DELIVERY --}}
            {{-- ====================================== --}}

            <section id="postpartum" class="adm-record-section" aria-labelledby="sec-postpartum">
                <h2 class="adm-record-heading" id="sec-postpartum">Postpartum &amp; Delivery</h2>

                <div class="adm-note" role="note">
                    <span class="adm-note-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
                    </span>
                    <div>
                        <p class="adm-note-title">Summary from existing records</p>
                        <p class="adm-note-text">
                            This section brings together the maternal status, infant birth records, and Postpartum
                            appointments already stored in CareCradle. These are not clinical postnatal examination
                            records — CareCradle does not currently record postnatal check-up findings.
                        </p>
                    </div>
                </div>

                <div class="adm-record-grid">
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <h3 class="adm-card-title">Delivery Status</h3>
                            </div>
                        </div>
                        <dl class="adm-dl">
                            <div><dt>Pregnancy Status</dt><dd><span class="adm-pill {{ $motherStatusClass }}">{{ $mother->pregnancyStatusLabel() }}</span>@if ($mother->isReferred())<span class="adm-pill adm-pill-warn" style="margin-left:0.25rem">Referred</span>@endif</dd></div>
                            <div><dt>Expected Delivery Date</dt><dd>{{ $date($mother->expected_delivery_date) }}</dd></div>
                            <div><dt>Registered Infants</dt><dd>{{ $mother->infants->count() }}</dd></div>
                            <div class="adm-dl-wide">
                                <dt>Infant Birth Records</dt>
                                <dd>
                                    @forelse($mother->infants as $infant)
                                        <span class="adm-birth-line">
                                            {{ trim($infant->first_name . ' ' . $infant->last_name) }} —
                                            born {{ $date($infant->birth_date) }}
                                            ({{ $text($infant->birth_status) }})
                                        </span>
                                    @empty
                                        No infant birth recorded
                                    @endforelse
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="adm-card adm-card-clip">
                        <div class="adm-card-head">
                            <div class="adm-card-head-main">
                                <h3 class="adm-card-title">Postpartum Appointments</h3>
                            </div>
                            <span class="adm-count">{{ $postpartumAppointments->count() }}</span>
                        </div>
                        @if($postpartumAppointments->isNotEmpty())
                            <div class="adm-table-scroll">
                                <table class="adm-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th class="adm-center">Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($postpartumAppointments as $appointment)
                                            <tr>
                                                <td data-label="Date">{{ $date($appointment->appointment_date) }}</td>
                                                <td data-label="Time">{{ $time($appointment->appointment_time) }}</td>
                                                <td data-label="Status" class="adm-center"><span class="adm-pill {{ $appointmentStatusClass($appointment->status) }}">{{ $appointment->status }}</span></td>
                                                <td data-label="Notes">{{ $text($appointment->notes) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="adm-empty">
                                <p class="adm-empty-title">No Postpartum appointments recorded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 6. INFANTS --}}
            {{-- ====================================== --}}

            <section id="infants" class="adm-record-section" aria-labelledby="sec-infants">
                <h2 class="adm-record-heading" id="sec-infants">
                    Related Infant Records
                    <span class="adm-count">{{ $mother->infants->count() }}</span>
                </h2>

                @forelse($mother->infants as $infant)
                    @php
                        $infantName = trim(implode(' ', array_filter([$infant->first_name, $infant->middle_name, $infant->last_name])));
                        $infantAge = $infant->birth_date ? \Carbon\Carbon::parse($infant->birth_date)->diffForHumans(now(), \Carbon\CarbonInterface::DIFF_ABSOLUTE) : null;
                        $birthStatusClass = match ($infant->birth_status) {
                            'Alive' => 'adm-pill-success',
                            'Stillbirth' => 'adm-pill-danger',
                            default => 'adm-pill-neutral',
                        };
                    @endphp

                    <article class="adm-card adm-infant" aria-label="Infant record: {{ $infantName }}">
                        <div class="adm-infant-head">
                            <div class="adm-record-avatar adm-record-avatar-sm" aria-hidden="true">
                                {{ strtoupper(substr((string) $infant->first_name, 0, 1) . substr((string) $infant->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="adm-infant-name">{{ $infantName }}</h3>
                                <div class="adm-record-meta">
                                    <span class="adm-code" title="Infant ID">Infant ID {{ $infant->id }}</span>
                                    <span class="adm-pill adm-pill-neutral">{{ $infant->sex }}</span>
                                    <span class="adm-pill {{ $birthStatusClass }}">{{ $infant->birth_status }}</span>
                                    @if($infantAge)
                                        <span>{{ $infantAge }} old</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <dl class="adm-dl adm-dl-compact">
                            <div><dt>Birth Date</dt><dd>{{ $date($infant->birth_date) }}</dd></div>
                            <div><dt>Birth Weight</dt><dd>{{ $num($infant->birth_weight) }} kg</dd></div>
                            <div><dt>Birth Length</dt><dd>{{ $num($infant->birth_length) }} cm</dd></div>
                            <div><dt>Head Circumference</dt><dd>{{ $infant->head_circumference !== null ? $num($infant->head_circumference) . ' cm' : '—' }}</dd></div>
                            <div class="adm-dl-wide"><dt>Remarks</dt><dd>{{ $text($infant->remarks) }}</dd></div>
                        </dl>

                        <h4 class="adm-subhead">
                            Growth Monitoring
                            <span class="adm-count">{{ $infant->growthMonitorings->count() }}</span>
                        </h4>
                        @if($infant->growthMonitorings->isNotEmpty())
                            <div class="adm-table-scroll adm-table-inset">
                                <table class="adm-table">
                                    <thead>
                                        <tr>
                                            <th>Date Measured</th>
                                            <th>Age (months)</th>
                                            <th>Weight (kg)</th>
                                            <th>Height / Length (cm)</th>
                                            <th>Head Circ. (cm)</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($infant->growthMonitorings as $growth)
                                            <tr>
                                                <td data-label="Date Measured">{{ $date($growth->date_measured) }}</td>
                                                <td data-label="Age (months)">{{ $text($growth->age_in_months) }}</td>
                                                <td data-label="Weight (kg)">{{ $num($growth->weight) }}</td>
                                                <td data-label="Height / Length (cm)">{{ $num($growth->height) }}</td>
                                                <td data-label="Head Circ. (cm)">{{ $num($growth->head_circumference) }}</td>
                                                <td data-label="Remarks">{{ $text($growth->remarks) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="adm-muted adm-small adm-inset">No growth measurements recorded.</p>
                        @endif

                        <h4 class="adm-subhead">
                            Vaccination History
                            <span class="adm-count">{{ $infant->vaccinations->count() }}</span>
                        </h4>
                        @if($infant->vaccinations->isNotEmpty())
                            <div class="adm-table-scroll adm-table-inset">
                                <table class="adm-table">
                                    <thead>
                                        <tr>
                                            <th>Vaccine</th>
                                            <th>Dose</th>
                                            <th>Date Given</th>
                                            <th>Next Due</th>
                                            <th>Administered By</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($infant->vaccinations as $vaccination)
                                            <tr>
                                                <td data-label="Vaccine"><span class="adm-pill adm-pill-pink">{{ $vaccination->vaccine_name }}</span></td>
                                                <td data-label="Dose">{{ $text($vaccination->dose) }}</td>
                                                <td data-label="Date Given">{{ $date($vaccination->date_given) }}</td>
                                                <td data-label="Next Due">{{ $date($vaccination->next_due_date) }}</td>
                                                <td data-label="Administered By">{{ $text($vaccination->administered_by) }}</td>
                                                <td data-label="Remarks">{{ $text($vaccination->remarks) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="adm-muted adm-small adm-inset">No vaccinations recorded.</p>
                        @endif
                    </article>
                @empty
                    <div class="adm-card">
                        <div class="adm-empty">
                            <p class="adm-empty-title">No infants registered</p>
                            <p class="adm-empty-desc">Infants registered by the midwife under this mother will appear here.</p>
                        </div>
                    </div>
                @endforelse
            </section>

            <p class="adm-report-footer">
                <strong>This record is view-only for Administrators.</strong><br>
                Viewing, printing, and PDF exports of this record are recorded in the Activity Logs.
            </p>

        </div>
    </div>

</x-app-layout>
