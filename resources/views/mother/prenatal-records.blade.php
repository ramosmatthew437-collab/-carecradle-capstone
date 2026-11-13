<x-app-layout>

    @php
        $today = today();
        $plural = fn (int $n, string $word) => $n . ' ' . $word . ($n === 1 ? '' : 's');

        // Recorded values only: nothing is calculated or interpreted.
        // A missing value returns null and is shown as "Not recorded".
        $recorded = fn ($value) => ($value === null || $value === '') ? null : $value;
        $number = fn ($value) => rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');

        $measurements = function ($visit) use ($recorded, $number) {
            return [
                'Gestational age at visit' => $recorded($visit->gestational_age_weeks) !== null ? $visit->gestational_age_weeks . ' weeks' : null,
                'Weight' => $recorded($visit->weight) !== null ? $number($visit->weight) . ' kg' : null,
                'Blood pressure' => ($recorded($visit->systolic_bp) !== null && $recorded($visit->diastolic_bp) !== null)
                    ? $visit->systolic_bp . '/' . $visit->diastolic_bp . ' mmHg' : null,
                'Fundal height' => $recorded($visit->fundal_height) !== null ? $number($visit->fundal_height) . ' cm' : null,
                'Fetal heart rate' => $recorded($visit->fetal_heart_rate) !== null ? $visit->fetal_heart_rate . ' bpm' : null,
            ];
        };

        // Structured findings exactly as recorded (no colour or judgement).
        $findings = fn ($visit) => [
            'Fetal movement' => $recorded($visit->fetal_movement),
            'Urine protein' => $recorded($visit->urine_protein),
            'Urine glucose' => $recorded($visit->urine_glucose),
        ];

        $fileType = fn ($name) => strtoupper(pathinfo((string) $name, PATHINFO_EXTENSION)) ?: 'File';
        $isImage = fn ($name) => in_array(strtolower(pathinfo((string) $name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'], true);
        $fileSize = function ($bytes) {
            if ($bytes === null || $bytes === '') {
                return null;
            }
            return $bytes >= 1048576
                ? number_format($bytes / 1048576, 1) . ' MB'
                : number_format($bytes / 1024, 1) . ' KB';
        };
    @endphp

    <div class="mdb apx pnx">

        <div class="mdb-container">

            {{-- ================= PAGE HEADER ================= --}}
            <header class="apx-head">
                <a href="{{ route('mother.dashboard') }}" class="apx-back" aria-label="Back to dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>

                <div class="apx-head-copy">
                    <p class="apx-eyebrow">Maternal care</p>
                    <h1 class="apx-title">Prenatal Records</h1>
                    <p class="apx-lead">
                        Your prenatal checkup history, as recorded by your midwife at the Irosin Rural Health Unit.
                        <span class="apx-lead-count">{{ $plural($totalVisits, 'checkup') }} recorded.</span>
                    </p>
                </div>
            </header>


            @if($latestVisit)

                {{-- ================= LATEST / LAST PRENATAL VISIT ================= --}}
                <section class="mdb-card" aria-labelledby="pnx-latest-title">
                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="pnx-latest-title">{{ $isDelivered ? 'Last prenatal visit' : 'Latest prenatal visit' }}</h2>
                        <span class="mdb-chip mdb-chip-rose mdb-card-chip">{{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('M d, Y') }}</span>
                    </header>

                    <p class="pnx-visit-date">{{ \Carbon\Carbon::parse($latestVisit->visit_date)->format('l, F d, Y') }}</p>

                    <dl class="pnx-measures">
                        @foreach($measurements($latestVisit) as $label => $value)
                            <div class="pnx-measure">
                                <dt>{{ $label }}</dt>
                                <dd class="{{ $value === null ? 'is-missing' : '' }}">{{ $value ?? 'Not recorded' }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div>
                        <h3 class="pnx-subhead">Recorded findings</h3>
                        <dl class="pnx-findings">
                            @foreach($findings($latestVisit) as $label => $value)
                                <div>
                                    <dt>{{ $label }}</dt>
                                    <dd class="{{ $value === null ? 'is-missing' : '' }}">{{ $value ?? 'Not recorded' }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    {{-- The recorded follow-up date, shown as history when it has
                         passed or when the pregnancy is recorded as delivered. --}}
                    @if(in_array($followUpState, ['passed', 'historical'], true))
                        <p class="pnx-history-note">
                            Recommended follow-up date:
                            <strong>{{ $recommendedFollowUp->format('F d, Y') }}</strong>
                            @if($followUpState === 'passed')
                                <span class="pnx-muted">· this date has passed</span>
                            @else
                                <span class="pnx-muted">· not a confirmed appointment</span>
                            @endif
                        </p>
                    @endif
                </section>

            @else

                {{-- ================= NO PRENATAL RECORDS ================= --}}
                <section class="mdb-card" aria-labelledby="pnx-empty-title">
                    <span class="mdb-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z"/></svg>
                    </span>
                    <h2 class="mdb-card-title" id="pnx-empty-title">No prenatal records yet</h2>
                    <p class="mdb-empty-text">Your prenatal checkups will appear here after your midwife records them at the Irosin Rural Health Unit.</p>
                </section>

            @endif


            {{-- ================= NEXT APPOINTMENT + RECOMMENDED FOLLOW-UP ================= --}}
            <div class="mdb-grid pnx-grid {{ $followUpState === 'upcoming' ? '' : 'pnx-grid-single' }}">

                @if($isDelivered)
                    <section class="mdb-card" aria-labelledby="pnx-care-title">
                        <header class="mdb-card-head">
                            <span class="mdb-card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            <h2 class="mdb-card-title" id="pnx-care-title">Prenatal care</h2>
                        </header>
                        <p class="mdb-empty-text">Your pregnancy is recorded as delivered. Your prenatal checkup history and laboratory documents remain available here for your reference.</p>
                    </section>
                @else
                    <section class="mdb-card" aria-labelledby="pnx-next-title">
                        <header class="mdb-card-head">
                            <span class="mdb-card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/></svg>
                            </span>
                            <h2 class="mdb-card-title" id="pnx-next-title">Next scheduled prenatal appointment</h2>
                        </header>

                        @if($nextPrenatalAppointment)
                            @php
                                $apptDate = \Carbon\Carbon::parse($nextPrenatalAppointment->appointment_date)->startOfDay();
                                $apptDays = (int) $today->diffInDays($apptDate, false);
                            @endphp
                            <div class="mdb-appt">
                                <div class="mdb-datetile" aria-hidden="true">
                                    <span class="mdb-datetile-month">{{ $apptDate->format('M') }}</span>
                                    <span class="mdb-datetile-day">{{ $apptDate->format('d') }}</span>
                                    <span class="mdb-datetile-dow">{{ $apptDate->format('D') }}</span>
                                </div>
                                <div class="mdb-appt-info">
                                    <p class="mdb-appt-type">{{ $nextPrenatalAppointment->appointment_type }}</p>
                                    <p class="mdb-appt-date">{{ $apptDate->format('l, F d, Y') }}</p>
                                    <p class="mdb-appt-meta">
                                        <span class="mdb-appt-time">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/></svg>
                                            {{ \Carbon\Carbon::parse($nextPrenatalAppointment->appointment_time)->format('g:i A') }}
                                        </span>
                                        <span class="mdb-chip">{{ $nextPrenatalAppointment->status }}</span>
                                        <span class="mdb-chip mdb-chip-rose">{{ $apptDays === 0 ? 'Today' : ($apptDays === 1 ? 'Tomorrow' : 'In ' . $apptDays . ' days') }}</span>
                                    </p>
                                </div>
                            </div>
                            @if($followUpState === 'matches')
                                <p class="pnx-muted">This is also the follow-up date your midwife recorded at your last checkup.</p>
                            @endif
                        @else
                            <div class="mdb-empty">
                                <p class="mdb-empty-title">No prenatal appointment scheduled</p>
                                <p class="mdb-empty-text">Confirmed prenatal checkups appear here and in My Appointments once your midwife schedules them.</p>
                            </div>
                        @endif

                        <a href="{{ route('mother.appointments') }}" class="mdb-btn mdb-btn-outline">
                            View my appointments
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </section>

                    @if($followUpState === 'upcoming')
                        <section class="mdb-card pnx-followup" aria-labelledby="pnx-followup-title">
                            <header class="mdb-card-head">
                                <span class="mdb-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931Z"/></svg>
                                </span>
                                <h2 class="mdb-card-title" id="pnx-followup-title">Recommended follow-up date recorded at last checkup</h2>
                            </header>
                            <p class="pnx-followup-date">
                                {{ $recommendedFollowUp->format('l, F d, Y') }}
                                <span class="pnx-followup-flag">Not a confirmed appointment</span>
                            </p>
                            <p class="mdb-empty-text">
                                This is the date your midwife recommended at your last checkup. It is not a confirmed appointment;
                                @if($nextPrenatalAppointment)
                                    your confirmed prenatal appointment is on {{ \Carbon\Carbon::parse($nextPrenatalAppointment->appointment_date)->format('F d, Y') }}.
                                @else
                                    confirmed visits appear under Next scheduled prenatal appointment once your midwife schedules them.
                                @endif
                            </p>
                        </section>
                    @endif
                @endif

            </div>


            {{-- ================= LABORATORY DOCUMENTS (grouped by visit) ================= --}}
            @if($totalVisits > 0)
                <section class="mdb-card" id="laboratory-documents" aria-labelledby="pnx-docs-title">
                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 002.112 2.13"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="pnx-docs-title">Laboratory documents</h2>
                        <span class="mdb-card-count">{{ $documents->count() }}</span>
                    </header>

                    @if($documents->isNotEmpty())
                        <div class="pnx-doc-groups">
                            @foreach($documents->groupBy('prenatal_checkup_id') as $visitDocuments)
                                <div class="pnx-doc-group">
                                    <h3 class="apx-month">Checkup on {{ \Carbon\Carbon::parse($visitDocuments->first()->visit_date)->format('F d, Y') }} · {{ $plural($visitDocuments->count(), 'document') }}</h3>
                                    <ul class="pnx-docs">
                                        @foreach($visitDocuments as $document)
                                            @php
                                                $image = $isImage($document->file_name);
                                                $size = $fileSize($document->file_size);
                                            @endphp
                                            <li class="pnx-doc">
                                                @if($image)
                                                    <img class="pnx-doc-thumb" src="{{ route('mother.prenatal-attachments.preview', $document->id) }}" alt="Laboratory document: {{ $document->file_name }}" loading="lazy" width="44" height="44">
                                                @else
                                                    <span class="pnx-doc-icon" aria-hidden="true">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9Z"/></svg>
                                                    </span>
                                                @endif
                                                <span class="pnx-doc-main">
                                                    <span class="pnx-doc-name">{{ $document->file_name }}</span>
                                                    <span class="pnx-doc-meta">{{ $fileType($document->file_name) }} · {{ $size ?? 'Size not recorded' }}</span>
                                                </span>
                                                <span class="pnx-doc-actions">
                                                    @if($image)
                                                        <a href="{{ route('mother.prenatal-attachments.preview', $document->id) }}" target="_blank" rel="noopener" class="mdb-btn mdb-btn-outline pnx-doc-btn">
                                                            Preview<span class="sr-only"> {{ $document->file_name }}</span>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('mother.prenatal-attachments.download', $document->id) }}" class="mdb-btn mdb-btn-outline pnx-doc-btn">
                                                        Download<span class="sr-only"> {{ $document->file_name }}</span>
                                                    </a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No laboratory documents</p>
                            <p class="mdb-empty-text">Laboratory results attached by your midwife to a checkup will be listed here.</p>
                        </div>
                    @endif
                </section>
            @endif


            {{-- ================= PREVIOUS CHECKUPS (newest first, expandable) ================= --}}
            @if($latestVisit)
                <section class="mdb-card" id="previous-checkups" aria-labelledby="pnx-previous-title">
                    <header class="mdb-card-head">
                        <h2 class="mdb-card-title" id="pnx-previous-title">Previous checkups</h2>
                        <span class="mdb-card-count">{{ $previousVisits->total() }}</span>
                    </header>

                    @if($previousVisits->isNotEmpty())
                        {{-- Grouped by month for easier scanning (newest first, order unchanged). --}}
                        @foreach($previousVisits->getCollection()->groupBy(fn ($v) => \Carbon\Carbon::parse($v->visit_date)->format('F Y')) as $month => $monthVisits)
                            <div class="apx-month-group">
                                <h3 class="apx-month">{{ $month }}</h3>
                                <ul class="apx-list">
                                    @foreach($monthVisits as $visit)
                                        @php
                                            $visitDate = \Carbon\Carbon::parse($visit->visit_date);
                                            $visitMeasures = $measurements($visit);
                                        @endphp
                                        <li class="apx-item">
                                            <details class="apx-details">
                                                <summary class="apx-row pnx-row">
                                                    <span class="apx-mini-date" aria-hidden="true">
                                                        <span>{{ $visitDate->format('M') }}</span>
                                                        <strong>{{ $visitDate->format('d') }}</strong>
                                                    </span>
                                                    <span class="apx-row-main">
                                                        <span class="apx-row-type">{{ $visitDate->format('F d, Y') }}</span>
                                                        <span class="apx-row-sub">
                                                            {{ $visitMeasures['Gestational age at visit'] ?? 'Gestational age not recorded' }}
                                                            · BP {{ $visitMeasures['Blood pressure'] ?? 'not recorded' }}
                                                        </span>
                                                    </span>
                                                    @if($visit->attachments_count > 0)
                                                        <span class="mdb-chip pnx-doc-chip">{{ $plural($visit->attachments_count, 'document') }}</span>
                                                    @else
                                                        <span aria-hidden="true"></span>
                                                    @endif
                                                    <svg class="apx-chevron" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                                </summary>

                                                <dl class="apx-facts pnx-facts">
                                                    @foreach($visitMeasures + $findings($visit) as $label => $value)
                                                        <div><dt>{{ $label }}</dt><dd class="{{ $value === null ? 'is-missing' : '' }}">{{ $value ?? 'Not recorded' }}</dd></div>
                                                    @endforeach
                                                    @if($recorded($visit->next_visit_date) !== null)
                                                        <div><dt>Follow-up date recorded</dt><dd>{{ \Carbon\Carbon::parse($visit->next_visit_date)->format('F d, Y') }}</dd></div>
                                                    @endif
                                                    @if($visit->attachments_count > 0)
                                                        <div><dt>Laboratory documents</dt><dd><a href="#laboratory-documents" class="pnx-link">{{ $plural($visit->attachments_count, 'document') }} · see Laboratory documents</a></dd></div>
                                                    @endif
                                                </dl>
                                            </details>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach

                        @if($previousVisits->hasPages())
                            <nav class="apx-pagination" aria-label="Previous checkup pages">
                                {{ $previousVisits->links() }}
                            </nav>
                        @endif
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No previous checkups</p>
                            <p class="mdb-empty-text">Earlier prenatal checkups will be listed here.</p>
                        </div>
                    @endif
                </section>
            @endif

        </div>

    </div>

</x-app-layout>
