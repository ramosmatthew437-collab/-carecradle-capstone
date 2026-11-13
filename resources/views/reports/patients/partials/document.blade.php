{{--
    Official patient record document — shared by the browser print view
    (reports/patients/print) and the PDF export (reports/patients/pdf).

    Built only from tables and block elements so it renders the same in
    browsers and in DomPDF (which does not support flexbox or grid).
    Read-only: displays existing data; no links, forms, or file paths.

    Expects: $mother (record loaded), $selected (section keys),
    $sectionNames, $isComplete, $preparedByName, $preparedByRole,
    $printedAt, $logoSrc (CareCradle logo src or null) and, optionally,
    $rhuLogoSrc (official Irosin RHU logo src or null).
--}}
@php
    $date = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('M d, Y') : '—';
    $time = fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('g:i A') : '—';
    $text = fn ($value) => ($value === null || $value === '') ? '—' : $value;
    $num = fn ($value, $decimals = 2) => ($value === null || $value === '') ? '—' : number_format((float) $value, $decimals);
    $has = fn ($key) => in_array($key, $selected, true);

    $fullName = trim(implode(' ', array_filter([$mother->first_name, $mother->middle_name, $mother->last_name])));
    $age = $mother->birth_date ? \Carbon\Carbon::parse($mother->birth_date)->age : null;
    $fatherName = trim(implode(' ', array_filter([$mother->father_first_name, $mother->father_middle_name, $mother->father_last_name])));
    $postpartumAppointments = $mother->appointments->where('appointment_type', 'Postpartum');
    $infantAppointmentsCount = $mother->appointments->whereIn('appointment_type', ['Infant Checkup', 'Vaccination'])->count();

    // Pregnancy status for display ("Unknown" for an older Referred record),
    // plus "(Referred)" while the mother is currently referred.
    $pregnancyStatus = $mother->pregnancyStatusLabel() . ($mother->isReferred() ? ' (Referred)' : '');
    // Referral history, newest first (ordered by the referrals relationship).
    $referrals = $mother->referrals;
@endphp

{{-- Official Irosin RHU watermark: very faint, centred behind the content and
     repeated on every printed/PDF page (positioned by print.blade.php and
     pdf.blade.php). Decorative only, so hidden from screen readers. --}}
@if(! empty($rhuLogoSrc))
    <div class="doc-watermark" aria-hidden="true"><img src="{{ $rhuLogoSrc }}" alt=""></div>
@endif

{{-- ================= Letterhead ================= --}}
<table class="doc-letterhead">
    <tr>
        <td class="doc-letterhead-logo">
            @if($logoSrc)
                <img src="{{ $logoSrc }}" alt="CareCradle logo">
            @endif
        </td>
        <td class="doc-letterhead-text">
            <div class="doc-municipality">Municipality of Irosin</div>
            <div class="doc-office">Rural Health Unit</div>
            <div class="doc-system">CareCradle Maternal and Infant Health Monitoring System</div>
        </td>
        {{-- Official Irosin RHU logo (original file, proportions preserved). --}}
        <td class="doc-letterhead-logo doc-letterhead-logo-rhu">
            @if(! empty($rhuLogoSrc))
                <img src="{{ $rhuLogoSrc }}" alt="Irosin Rural Health Unit logo" class="doc-rhu-logo">
            @endif
        </td>
    </tr>
</table>

<h1 class="doc-title">Mother and Infant Health Record</h1>
<p class="doc-subtitle">
    @if($isComplete)
        Complete record
    @else
        Selected sections: {{ implode(', ', array_map(fn ($key) => $sectionNames[$key], $selected)) }}
    @endif
</p>

{{-- ================= Patient identification ================= --}}
<table class="doc-id">
    <tr>
        <th>Mother Code</th>
        <td>{{ $mother->mother_code }}</td>
        <th>Mother's Name</th>
        <td>{{ $fullName }}</td>
    </tr>
    <tr>
        <th>Pregnancy Status</th>
        <td>{{ $pregnancyStatus }}</td>
        <th>Date Printed</th>
        <td>{{ $printedAt->format('F d, Y h:i A') }}</td>
    </tr>
</table>

{{-- ================= 1. Patient information ================= --}}
@if($has('overview'))
    <h2 class="doc-h2">Mother's Information</h2>

    <table class="doc-kv">
        <tr><th colspan="4" class="doc-kv-group">Personal Information</th></tr>
        <tr>
            <th>Full Name</th><td>{{ $fullName }}</td>
            <th>Birth Date</th><td>{{ $date($mother->birth_date) }}{{ $age !== null ? ' (' . $age . ' yrs)' : '' }}</td>
        </tr>
        <tr>
            <th>Civil Status</th><td>{{ $text($mother->civil_status) }}</td>
            <th>Occupation</th><td>{{ $text($mother->occupation) }}</td>
        </tr>
        <tr>
            <th>Blood Type</th><td>{{ $text($mother->blood_type) }}</td>
            <th>PhilHealth No.</th><td>{{ $text($mother->philhealth_number) }}</td>
        </tr>
        <tr>
            <th>Contact Number</th><td>{{ $text($mother->contact_number) }}</td>
            <th>Barangay</th><td>{{ $text($mother->barangay) }}</td>
        </tr>
        <tr>
            <th>Address</th><td colspan="3">{{ $text($mother->address) }}</td>
        </tr>
    </table>

    <table class="doc-kv">
        <tr><th colspan="4" class="doc-kv-group">Maternal &amp; Pregnancy Information</th></tr>
        <tr>
            <th>Pregnancy Status</th><td>{{ $pregnancyStatus }}</td>
            <th>Pregnancy Number</th><td>{{ $text($mother->pregnancy_number) }}</td>
        </tr>
        <tr>
            <th>Last Menstrual Period</th><td>{{ $date($mother->last_menstrual_period) }}</td>
            <th>Expected Delivery Date</th><td>{{ $date($mother->expected_delivery_date) }}</td>
        </tr>
        <tr>
            <th>Height</th><td>{{ $mother->height !== null ? $num($mother->height) . ' cm' : '—' }}</td>
            <th>Weight</th><td>{{ $mother->weight !== null ? $num($mother->weight) . ' kg' : '—' }}</td>
        </tr>
    </table>

    {{-- Referral history (read-only; recorded by Midwives). Newest first. --}}
    <h3 class="doc-h3">Referral History ({{ $referrals->count() }})</h3>

    @if($mother->isLegacyReferred())
        <p class="doc-note">
            This record was marked Referred before referral details were tracked in CareCradle.
            The referral date, receiving facility and reason were not recorded, and the pregnancy
            status has not been confirmed.
        </p>
    @endif

    @if($referrals->isNotEmpty())
        <table class="doc-table">
            <thead>
                <tr>
                    <th>Referral Date</th>
                    <th>Receiving Facility</th>
                    <th>Status</th>
                    <th>Referred By</th>
                    <th>Follow-up Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referrals as $referral)
                    <tr class="doc-keep">
                        <td>{{ $date($referral->referred_at) }}</td>
                        <td>{{ $text($referral->receiving_facility) }}</td>
                        <td>{{ $referral->status }}</td>
                        <td>{{ $text($referral->referred_by_name) }}</td>
                        <td>{{ $date($referral->outcome_at) }}</td>
                    </tr>
                    <tr class="doc-keep doc-detail-row">
                        <td colspan="5">
                            <strong>Reason:</strong> {{ $text($referral->reason) }}
                            &nbsp;&nbsp;<strong>Notes:</strong> {{ $text($referral->notes) }}
                            <br>
                            <strong>Follow-up notes:</strong> {{ $text($referral->outcome_notes) }}
                            &nbsp;&nbsp;<strong>Information source:</strong> {{ $text($referral->outcome_source) }}
                            @if($referral->closed_by_name || $referral->closed_at)
                                <br>
                                <strong>Closed by:</strong> {{ $text($referral->closed_by_name) }}
                                &nbsp;&nbsp;<strong>Closed on:</strong> {{ $date($referral->closed_at) }}
                            @endif
                            @if($referral->status === 'Entered in error')
                                <br>
                                <strong>Entered in error:</strong> {{ $text($referral->voided_reason) }}
                                (marked by {{ $text($referral->voided_by_name) }} on {{ $date($referral->voided_at) }})
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(! $mother->isLegacyReferred())
        <p class="doc-empty">No referrals recorded.</p>
    @endif

    <table class="doc-kv">
        <tr><th colspan="4" class="doc-kv-group">Father's Information</th></tr>
        <tr>
            <th>Name</th><td>{{ $fatherName !== '' ? $fatherName : '—' }}</td>
            <th>Birth Date</th><td>{{ $date($mother->father_birth_date) }}</td>
        </tr>
        <tr>
            <th>Contact Number</th><td>{{ $text($mother->father_contact_number) }}</td>
            <th>Occupation</th><td>{{ $text($mother->father_occupation) }}</td>
        </tr>
    </table>
@endif

{{-- ================= 2. Prenatal visits ================= --}}
@if($has('prenatal'))
    <h2 class="doc-h2">Prenatal Visits ({{ $mother->prenatalCheckups->count() }})</h2>

    @if($mother->prenatalCheckups->isNotEmpty())
        <table class="doc-table">
            <thead>
                <tr>
                    <th>Visit Date</th>
                    <th>AOG (wks)</th>
                    <th>Weight (kg)</th>
                    <th>BP (mmHg)</th>
                    <th>Fundal Ht. (cm)</th>
                    <th>FHR (bpm)</th>
                    <th>Fetal Movement</th>
                    <th>Urine Prot. / Gluc.</th>
                    <th>Next Visit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mother->prenatalCheckups as $visit)
                    <tr class="doc-keep">
                        <td>{{ $date($visit->visit_date) }}</td>
                        <td>{{ $text($visit->gestational_age_weeks) }}</td>
                        <td>{{ $num($visit->weight) }}</td>
                        <td>{{ $text($visit->systolic_bp) }}/{{ $text($visit->diastolic_bp) }}</td>
                        <td>{{ $visit->fundal_height !== null ? $num($visit->fundal_height) : '—' }}</td>
                        <td>{{ $text($visit->fetal_heart_rate) }}</td>
                        <td>{{ $text($visit->fetal_movement) }}</td>
                        <td>{{ $text($visit->urine_protein) }} / {{ $text($visit->urine_glucose) }}</td>
                        <td>{{ $date($visit->next_visit_date) }}</td>
                    </tr>
                    <tr class="doc-keep doc-detail-row">
                        <td colspan="9">
                            <strong>Maternal condition:</strong> {{ $text($visit->maternal_condition) }}
                            &nbsp;&nbsp;<strong>Notes:</strong> {{ $text($visit->notes) }}
                            <br>
                            <strong>Laboratory attachments (file names only):</strong>
                            {{ $visit->attachments->isNotEmpty() ? $visit->attachments->pluck('file_name')->implode(', ') : 'None' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="doc-empty">No prenatal visits recorded.</p>
    @endif
@endif

{{-- ================= 3. Maternal vaccinations ================= --}}
@if($has('maternal_vaccinations'))
    <h2 class="doc-h2">Maternal Vaccinations ({{ $mother->maternalVaccinations->count() }})</h2>

    @if($mother->maternalVaccinations->isNotEmpty())
        <table class="doc-table">
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
                    <tr class="doc-keep">
                        <td>{{ $vaccination->vaccine_name }}</td>
                        <td>{{ $text($vaccination->dose) }}</td>
                        <td>{{ $date($vaccination->date_given) }}</td>
                        <td>{{ $date($vaccination->next_due_date) }}</td>
                        <td>{{ $text($vaccination->administered_by) }}</td>
                        <td>{{ $text($vaccination->remarks) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="doc-empty">No maternal vaccinations recorded.</p>
    @endif
@endif

{{-- ================= 4. Appointments ================= --}}
@if($has('appointments'))
    <h2 class="doc-h2">Appointment History ({{ $mother->appointments->count() }})</h2>

    @if($mother->appointments->isNotEmpty())
        <table class="doc-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mother->appointments as $appointment)
                    <tr class="doc-keep">
                        <td>{{ $date($appointment->appointment_date) }}</td>
                        <td>{{ $time($appointment->appointment_time) }}</td>
                        <td>{{ $appointment->appointment_type }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>{{ $text($appointment->notes) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($infantAppointmentsCount > 0)
            <p class="doc-note">
                Note: Infant Checkup and Vaccination appointments are recorded under the mother in CareCradle;
                they are not linked to a specific infant.
            </p>
        @endif
    @else
        <p class="doc-empty">No appointments recorded.</p>
    @endif
@endif

{{-- ================= 5. Postpartum & Delivery ================= --}}
@if($has('postpartum'))
    <h2 class="doc-h2">Postpartum &amp; Delivery</h2>

    <p class="doc-note">
        Summary from existing CareCradle records (maternal status, infant birth records, and Postpartum
        appointments). These are not clinical postnatal examination records; CareCradle does not
        currently record postnatal check-up findings.
    </p>

    <table class="doc-kv">
        <tr>
            <th>Pregnancy Status</th><td>{{ $pregnancyStatus }}</td>
            <th>Expected Delivery Date</th><td>{{ $date($mother->expected_delivery_date) }}</td>
        </tr>
        <tr>
            <th>Registered Infants</th><td>{{ $mother->infants->count() }}</td>
            <th>Postpartum Appointments</th><td>{{ $postpartumAppointments->count() }}</td>
        </tr>
        <tr>
            <th>Infant Birth Records</th>
            <td colspan="3">
                @forelse($mother->infants as $infant)
                    {{ trim($infant->first_name . ' ' . $infant->last_name) }} — born {{ $date($infant->birth_date) }} ({{ $text($infant->birth_status) }})@if(! $loop->last)<br>@endif
                @empty
                    No infant birth recorded.
                @endforelse
            </td>
        </tr>
    </table>

    @if($postpartumAppointments->isNotEmpty())
        <table class="doc-table">
            <thead>
                <tr>
                    <th>Postpartum Appointment Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($postpartumAppointments as $appointment)
                    <tr class="doc-keep">
                        <td>{{ $date($appointment->appointment_date) }}</td>
                        <td>{{ $time($appointment->appointment_time) }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>{{ $text($appointment->notes) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="doc-empty">No Postpartum appointments recorded.</p>
    @endif
@endif

{{-- ================= 6. Infant records ================= --}}
@if($has('infants'))
    <h2 class="doc-h2">Infant Records ({{ $mother->infants->count() }})</h2>

    @forelse($mother->infants as $infant)
        @php
            $infantName = trim(implode(' ', array_filter([$infant->first_name, $infant->middle_name, $infant->last_name])));
        @endphp

        <div class="doc-infant">
            <h3 class="doc-h3">{{ $infantName }} <span class="doc-h3-meta">Infant ID {{ $infant->id }}</span></h3>

            <table class="doc-kv">
                <tr>
                    <th>Sex</th><td>{{ $text($infant->sex) }}</td>
                    <th>Birth Date</th><td>{{ $date($infant->birth_date) }}</td>
                </tr>
                <tr>
                    <th>Birth Status</th><td>{{ $text($infant->birth_status) }}</td>
                    <th>Birth Weight</th><td>{{ $num($infant->birth_weight) }} kg</td>
                </tr>
                <tr>
                    <th>Birth Length</th><td>{{ $num($infant->birth_length) }} cm</td>
                    <th>Head Circumference</th><td>{{ $infant->head_circumference !== null ? $num($infant->head_circumference) . ' cm' : '—' }}</td>
                </tr>
                <tr>
                    <th>Remarks</th><td colspan="3">{{ $text($infant->remarks) }}</td>
                </tr>
            </table>

            <h4 class="doc-h4">Growth Monitoring ({{ $infant->growthMonitorings->count() }})</h4>
            @if($infant->growthMonitorings->isNotEmpty())
                <table class="doc-table">
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
                            <tr class="doc-keep">
                                <td>{{ $date($growth->date_measured) }}</td>
                                <td>{{ $text($growth->age_in_months) }}</td>
                                <td>{{ $num($growth->weight) }}</td>
                                <td>{{ $num($growth->height) }}</td>
                                <td>{{ $num($growth->head_circumference) }}</td>
                                <td>{{ $text($growth->remarks) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="doc-empty">No growth measurements recorded.</p>
            @endif

            <h4 class="doc-h4">Vaccination History ({{ $infant->vaccinations->count() }})</h4>
            @if($infant->vaccinations->isNotEmpty())
                <table class="doc-table">
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
                            <tr class="doc-keep">
                                <td>{{ $vaccination->vaccine_name }}</td>
                                <td>{{ $text($vaccination->dose) }}</td>
                                <td>{{ $date($vaccination->date_given) }}</td>
                                <td>{{ $date($vaccination->next_due_date) }}</td>
                                <td>{{ $text($vaccination->administered_by) }}</td>
                                <td>{{ $text($vaccination->remarks) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="doc-empty">No vaccinations recorded.</p>
            @endif
        </div>
    @empty
        <p class="doc-empty">No infants registered under this mother.</p>
    @endforelse
@endif

{{-- ================= Signatures ================= --}}
<table class="doc-signatures">
    <tr>
        <td>
            <div class="doc-sign-label">Prepared by:</div>
            <div class="doc-sign-line">
                <div class="doc-sign-name">{{ $preparedByName ?: ' ' }}</div>
                <div class="doc-sign-role">{{ $preparedByRole ?: 'Signature over Printed Name' }}</div>
            </div>
        </td>
        <td class="doc-sign-gap"></td>
        <td>
            <div class="doc-sign-label">Reviewed and Approved by:</div>
            <div class="doc-sign-line">
                <div class="doc-sign-name">&nbsp;</div>
                <div class="doc-sign-role">Signature over Printed Name / Designation</div>
            </div>
        </td>
    </tr>
</table>

<p class="doc-confidential">
    CONFIDENTIAL — This document contains personal health information protected under the
    Data Privacy Act of 2012 (RA 10173). Generated from the CareCradle Electronic Medical Record
    System, Irosin Rural Health Unit, on {{ $printedAt->format('F d, Y h:i A') }}.
</p>
