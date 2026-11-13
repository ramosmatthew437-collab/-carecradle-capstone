<x-app-layout>
    {{--
        Mother Portal: Print My Records.
        A self-printed summary of the signed-in mother's own records (browser
        print / Save as PDF). Data from MotherPrintRecordsController; staff-only
        fields (administered by, vaccination remarks, infant remarks, maternal
        condition, prenatal notes) are not loaded or shown. The document uses
        the approved letterhead (CareCradle primary, Irosin RHU secondary) and
        the 4% RHU watermark; no signature lines (not a certified document).
        Screen styles: resources/css/mother-dashboard-polish.css
        ("Print My Records" section). The page information line is set here.
    --}}

    @php
        $categoryInfo = [
            'personal' => ['Personal Information', 'Name, date of birth, contact details, address, and father\'s information.'],
            'maternal' => ['Maternal Information', 'Pregnancy status, blood type, and pregnancy details.'],
            'prenatal' => ['Prenatal Visit Records', 'Visit dates, measurements, and recommended follow-up dates.'],
            'infant' => ['Infant Health Record', 'Your child\'s birth details and growth history.'],
            'vaccinations' => ['Vaccination Records', 'Vaccine names, doses, dates given, and next due dates.'],
        ];

        $motherFullName = trim(implode(' ', array_filter([$mother->first_name, $mother->middle_name, $mother->last_name]))) ?: 'Not provided';
        $infantFullName = fn ($child) => trim(implode(' ', array_filter([$child->first_name, $child->middle_name, $child->last_name])));

        $dateValue = function ($value, $format = 'F d, Y') {
            if (!$value) {
                return 'Not provided';
            }
            try {
                return \Illuminate\Support\Carbon::parse($value)->format($format);
            } catch (\Throwable $exception) {
                return (string) $value;
            }
        };
        $shortDate = fn ($value) => $value ? $dateValue($value, 'M d, Y') : 'Not recorded';
        $displayValue = fn ($value) => ($value === null || $value === '') ? 'Not provided' : (string) $value;
        $number = fn ($value) => rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
        $measure = fn ($value, $unit) => ($value === null || $value === '') ? 'Not recorded' : $number($value) . ' ' . $unit;
        $recorded = fn ($value) => ($value === null || $value === '') ? 'Not recorded' : (string) $value;
        $bloodPressure = function ($systolic, $diastolic) use ($number) {
            $hasSystolic = $systolic !== null && $systolic !== '';
            $hasDiastolic = $diastolic !== null && $diastolic !== '';
            if (!$hasSystolic && !$hasDiastolic) {
                return 'Not recorded';
            }
            return ($hasSystolic ? $number($systolic) : '—') . '/' . ($hasDiastolic ? $number($diastolic) : '—') . ' mmHg';
        };
        // Age at a growth check: the stored value is completed months (whole number).
        $growthAge = function ($months) {
            if ($months === null || $months === '') {
                return 'Not recorded';
            }
            $months = (int) $months;
            if ($months < 1) {
                return 'Under 1 month';
            }
            if ($months < 24) {
                return $months . ' ' . ($months === 1 ? 'month' : 'months');
            }
            $years = (int) floor($months / 12);
            return $years . ' ' . ($years === 1 ? 'year' : 'years');
        };

        $has = fn ($key) => in_array($key, $selectedCategories, true);
        $isPregnant = $mother->status === 'Pregnant';
        $pregnancyStatus = $mother->pregnancyStatusLabel() . ($mother->isReferred() ? ' (Referred)' : '');

        $logoSrc = is_file(public_path('images/system.logo.png')) ? asset('images/system.logo.png') : null;
        $rhuLogoSrc = is_file(public_path('images/irosin-rhu-logo.jpg')) ? asset('images/irosin-rhu-logo.jpg') : null;

        // Page information line for the printed pages (CSS string, escaped).
        $cssString = fn ($value) => '"' . str_replace(['\\', '"', "\r", "\n", '<'], ['\\\\', '\\"', ' ', ' ', '\\3C '], (string) $value) . '"';
        $pageInfo = $motherFullName . ' · Mother code ' . ($mother->mother_code ?: 'not recorded');

        $section = 0;
    @endphp

    {{-- Printed page information: mother's name and code, page numbers. --}}
    <style>
        @page {
            size: A4 portrait;
            margin: 16mm 14mm 18mm;

            @bottom-left {
                content: {!! $cssString($pageInfo) !!};
                font-family: "Inter", Arial, sans-serif;
                font-size: 7.5pt;
                color: #6b6470;
            }

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                font-family: "Inter", Arial, sans-serif;
                font-size: 7.5pt;
                color: #6b6470;
            }
        }
    </style>

    <div class="mdb apx prx">
        <div class="mdb-container">

            {{-- ================= PAGE HEADER (screen only) ================= --}}
            <div class="apx-head prx-screen">
                <a href="{{ route('mother.dashboard') }}" class="apx-back" aria-label="Back to dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="apx-head-copy">
                    <p class="apx-eyebrow">Records</p>
                    <h1 class="apx-title">Print My Records</h1>
                    <p class="apx-lead">Choose what to include in your CareCradle record summary, then print it or save it as a PDF.</p>
                </div>
            </div>


            {{-- ================= SELECTION (screen only) ================= --}}
            <section class="mdb-card prx-select prx-screen" aria-labelledby="prx-select-title">
                <header class="mdb-card-head">
                    <span class="mdb-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M7 14h10v7H7z"/></svg>
                    </span>
                    <h2 class="mdb-card-title" id="prx-select-title">What to print</h2>
                </header>

                <form id="prx-form" method="GET" action="{{ route('mother.print-records') }}"
                      data-rendered-categories="{{ implode(',', $selectedCategories) }}"
                      data-rendered-infant="{{ $selectedInfant?->id }}">

                    {{-- Keeps an empty selection distinct from the first visit (all categories). --}}
                    <input type="hidden" name="categories[]" value="">
                    <input type="hidden" name="print" value="1" id="prx-print-flag" disabled>

                    <fieldset class="prx-fieldset">
                        <div class="prx-fieldset-head">
                            <legend class="prx-legend">Record categories</legend>
                            <div class="prx-quick">
                                <button type="button" class="prx-link-btn" id="prx-all">Select all</button>
                                <button type="button" class="prx-link-btn" id="prx-none">Clear</button>
                            </div>
                        </div>

                        <div class="prx-categories">
                            @foreach($allowedCategories as $key)
                                <label class="prx-category">
                                    <input type="checkbox" name="categories[]" value="{{ $key }}" @checked($has($key))>
                                    <span>
                                        <strong>{{ $categoryInfo[$key][0] }}</strong>
                                        <small>{{ $categoryInfo[$key][1] }}</small>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="prx-field">
                        <label class="prx-legend" for="prx-infant">Child's records to include</label>
                        @if($infants->isNotEmpty())
                            <select id="prx-infant" name="infant" class="prx-selectbox">
                                @if(!$selectedInfant)
                                    <option value="" selected>Choose a child</option>
                                @endif
                                @foreach($infants as $infantOption)
                                    <option value="{{ $infantOption->id }}" @selected($selectedInfant && (int) $selectedInfant->id === (int) $infantOption->id)>
                                        {{ $infantFullName($infantOption) }}@if($infantOption->birth_date) — born {{ $dateValue($infantOption->birth_date, 'M d, Y') }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="prx-hint">Used for the Infant Health Record and the child's vaccinations.</p>
                        @else
                            <p class="prx-hint">No children are registered to your record yet.</p>
                        @endif
                    </div>

                    <p class="prx-error" id="prx-error" role="alert" tabindex="-1" hidden>Please choose at least one record category to print.</p>

                    <div class="prx-actions">
                        <button type="button" class="mdb-btn mdb-btn-primary prx-print-btn" id="prx-print">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M7 14h10v7H7z"/></svg>
                            Print selected records
                        </button>
                        <button type="submit" class="mdb-btn mdb-btn-outline">Update preview</button>
                    </div>

                    <p class="prx-hint">Printing opens your browser's print window. Choose your printer, or "Save as PDF" to keep a copy.</p>
                </form>
            </section>

            @if($infantNotice)
                <div class="prx-notice prx-screen" role="alert">
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                    <span>{{ $infantNotice }}</span>
                </div>
            @endif

            <p class="prx-preview-label prx-screen">Document preview</p>


            {{-- ================= PRINTABLE DOCUMENT ================= --}}
            <article class="prx-doc" id="prx-document" aria-label="Record summary">

                @if($rhuLogoSrc)
                    <div class="prx-watermark" aria-hidden="true"><img src="{{ $rhuLogoSrc }}" alt=""></div>
                @endif

                {{-- Letterhead (approved: CareCradle primary, Irosin RHU secondary). --}}
                <table class="prx-letterhead" role="presentation">
                    <tr>
                        <td class="prx-letterhead-logo">
                            @if($logoSrc)
                                <img src="{{ $logoSrc }}" alt="CareCradle logo">
                            @endif
                        </td>
                        <td class="prx-letterhead-text">
                            <div class="prx-municipality">Municipality of Irosin</div>
                            <div class="prx-office">Rural Health Unit</div>
                            <div class="prx-system">CareCradle Maternal and Infant Health Monitoring System</div>
                        </td>
                        <td class="prx-letterhead-logo prx-letterhead-logo-rhu">
                            @if($rhuLogoSrc)
                                <img src="{{ $rhuLogoSrc }}" alt="Irosin Rural Health Unit logo" class="prx-rhu-logo">
                            @endif
                        </td>
                    </tr>
                </table>

                <h2 class="prx-doc-title">Mother's Health Record Summary</h2>

                <table class="prx-id">
                    <tr>
                        <th scope="row">Mother</th>
                        <td>{{ $motherFullName }}</td>
                        <th scope="row">Mother code</th>
                        <td class="prx-nowrap">{{ $displayValue($mother->mother_code) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Generated</th>
                        <td colspan="3">{{ now()->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>

                @if(count($selectedCategories) === 0)
                    <div class="prx-empty prx-empty-strong">
                        No record categories are selected. Choose at least one category on the Print My Records page to create a summary.
                    </div>
                @endif

                {{-- ---------- Personal Information ---------- --}}
                @if($has('personal'))
                    <section class="prx-section">
                        <h3 class="prx-h3">{{ ++$section }}. Personal Information</h3>
                        <dl class="prx-data">
                            <div><dt>Full name</dt><dd>{{ $motherFullName }}</dd></div>
                            <div><dt>Mother code</dt><dd>{{ $displayValue($mother->mother_code) }}</dd></div>
                            <div><dt>Date of birth</dt><dd>{{ $dateValue($mother->birth_date) }}</dd></div>
                            <div><dt>Age</dt><dd>{{ $mother->birth_date ? \Illuminate\Support\Carbon::parse($mother->birth_date)->age . ' years old' : 'Not provided' }}</dd></div>
                            <div><dt>Contact number</dt><dd>{{ $displayValue($mother->contact_number) }}</dd></div>
                            <div><dt>Address</dt><dd>{{ trim(($mother->address ?? '') . (filled($mother->barangay ?? null) ? ', ' . $mother->barangay : '')) ?: 'Not provided' }}</dd></div>
                            <div><dt>Civil status</dt><dd>{{ $displayValue($mother->civil_status) }}</dd></div>
                            <div><dt>Occupation</dt><dd>{{ $displayValue($mother->occupation) }}</dd></div>
                            <div><dt>PhilHealth number</dt><dd>{{ $displayValue($mother->philhealth_number) }}</dd></div>
                            <div><dt>Father's full name</dt><dd>{{ trim(implode(' ', array_filter([$mother->father_first_name, $mother->father_middle_name, $mother->father_last_name]))) ?: 'Not provided' }}</dd></div>
                            <div><dt>Father's birth date</dt><dd>{{ $dateValue($mother->father_birth_date) }}</dd></div>
                            <div><dt>Father's contact number</dt><dd>{{ $displayValue($mother->father_contact_number) }}</dd></div>
                            <div><dt>Father's occupation</dt><dd>{{ $displayValue($mother->father_occupation) }}</dd></div>
                        </dl>
                    </section>
                @endif

                {{-- ---------- Maternal Information ---------- --}}
                @if($has('maternal'))
                    <section class="prx-section">
                        <h3 class="prx-h3">{{ ++$section }}. Maternal Information</h3>
                        <dl class="prx-data">
                            <div><dt>Pregnancy status</dt><dd>{{ $displayValue($pregnancyStatus) }}</dd></div>
                            <div><dt>Blood type</dt><dd>{{ $displayValue($mother->blood_type) }}</dd></div>
                            <div><dt>Pregnancy number</dt><dd>{{ $displayValue($mother->pregnancy_number) }}</dd></div>
                            <div><dt>Height (at registration)</dt><dd>{{ $measure($mother->height, 'cm') }}</dd></div>
                            <div><dt>Weight (at registration)</dt><dd>{{ $measure($mother->weight, 'kg') }}</dd></div>
                            @if($isPregnant)
                                <div><dt>Last menstrual period</dt><dd>{{ $dateValue($mother->last_menstrual_period) }}</dd></div>
                                <div><dt>Expected delivery date</dt><dd>{{ $dateValue($mother->expected_delivery_date) }}</dd></div>
                            @endif
                        </dl>
                        @unless($isPregnant)
                            <p class="prx-note">Last menstrual period and expected delivery date are included only while the pregnancy status is Pregnant.</p>
                        @endunless
                    </section>
                @endif

                {{-- ---------- Prenatal Visit Records ---------- --}}
                @if($has('prenatal'))
                    <section class="prx-section">
                        <h3 class="prx-h3">{{ ++$section }}. Prenatal Visit Records</h3>
                        @if($prenatalCheckups->isNotEmpty())
                            <div class="prx-table-wrap">
                                <table class="prx-table prx-table-prenatal">
                                    <thead>
                                        <tr>
                                            <th scope="col">Visit date</th>
                                            <th scope="col">Gestational age</th>
                                            <th scope="col">Weight</th>
                                            <th scope="col">Blood pressure</th>
                                            <th scope="col">Fundal height</th>
                                            <th scope="col">Fetal heart rate</th>
                                            <th scope="col">Fetal movement</th>
                                            <th scope="col">Urine protein / glucose</th>
                                            <th scope="col">Recommended follow-up date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prenatalCheckups as $checkup)
                                            <tr>
                                                <td>{{ $shortDate($checkup->visit_date) }}</td>
                                                <td>{{ $measure($checkup->gestational_age_weeks, 'weeks') }}</td>
                                                <td>{{ $measure($checkup->weight, 'kg') }}</td>
                                                <td>{{ $bloodPressure($checkup->systolic_bp, $checkup->diastolic_bp) }}</td>
                                                <td>{{ $measure($checkup->fundal_height, 'cm') }}</td>
                                                <td>{{ $measure($checkup->fetal_heart_rate, 'bpm') }}</td>
                                                <td>{{ $recorded($checkup->fetal_movement) }}</td>
                                                <td>{{ $recorded($checkup->urine_protein) }} / {{ $recorded($checkup->urine_glucose) }}</td>
                                                <td>{{ $shortDate($checkup->next_visit_date) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="prx-empty">No prenatal visit records are available.</div>
                        @endif
                    </section>
                @endif

                {{-- ---------- Infant Health Record ---------- --}}
                @if($has('infant'))
                    <section class="prx-section">
                        <h3 class="prx-h3">{{ ++$section }}. Infant Health Record</h3>
                        @if($selectedInfant)
                            <dl class="prx-data">
                                <div><dt>Infant name</dt><dd>{{ $infantFullName($selectedInfant) ?: 'Not provided' }}</dd></div>
                                <div><dt>Sex</dt><dd>{{ $displayValue($selectedInfant->sex) }}</dd></div>
                                <div><dt>Date of birth</dt><dd>{{ $dateValue($selectedInfant->birth_date) }}</dd></div>
                                <div><dt>Birth status</dt><dd>{{ $displayValue($selectedInfant->birth_status) }}</dd></div>
                                <div><dt>Birth weight</dt><dd>{{ $measure($selectedInfant->birth_weight, 'kg') }}</dd></div>
                                <div><dt>Birth length</dt><dd>{{ $measure($selectedInfant->birth_length, 'cm') }}</dd></div>
                                <div><dt>Head circumference at birth</dt><dd>{{ $measure($selectedInfant->head_circumference, 'cm') }}</dd></div>
                            </dl>

                            <h4 class="prx-h4">Growth monitoring history</h4>
                            @if($growthRecords->isNotEmpty())
                                <div class="prx-table-wrap">
                                    <table class="prx-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date measured</th>
                                                <th scope="col">Age</th>
                                                <th scope="col">Weight</th>
                                                <th scope="col">Height / length</th>
                                                <th scope="col">Head circumference</th>
                                                <th scope="col">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($growthRecords as $growth)
                                                <tr>
                                                    <td>{{ $shortDate($growth->date_measured) }}</td>
                                                    <td>{{ $growthAge($growth->age_in_months) }}</td>
                                                    <td>{{ $measure($growth->weight, 'kg') }}</td>
                                                    <td>{{ $measure($growth->height, 'cm') }}</td>
                                                    <td>{{ $measure($growth->head_circumference, 'cm') }}</td>
                                                    <td>{{ $growth->remarks ?: '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="prx-empty">No growth monitoring records are available for this child.</div>
                            @endif
                        @elseif($infantNotice)
                            <div class="prx-empty">{{ $infantNotice }}</div>
                        @else
                            <div class="prx-empty">No child is linked to this mother record yet.</div>
                        @endif
                    </section>
                @endif

                {{-- ---------- Vaccination Records (approved columns; no staff names or remarks) ---------- --}}
                @if($has('vaccinations'))
                    <section class="prx-section">
                        <h3 class="prx-h3">{{ ++$section }}. Vaccination Records</h3>

                        <h4 class="prx-h4">Maternal vaccination history</h4>
                        @if($maternalVaccinations->isNotEmpty())
                            <div class="prx-table-wrap">
                                <table class="prx-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Vaccine</th>
                                            <th scope="col">Dose</th>
                                            <th scope="col">Date given</th>
                                            <th scope="col">Next due date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maternalVaccinations as $maternalVaccination)
                                            <tr>
                                                <td>{{ $displayValue($maternalVaccination->vaccine_name) }}</td>
                                                <td>{{ $displayValue($maternalVaccination->dose) }}</td>
                                                <td>{{ $shortDate($maternalVaccination->date_given) }}</td>
                                                <td>{{ $shortDate($maternalVaccination->next_due_date) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="prx-empty">No maternal vaccination records are available.</div>
                        @endif

                        <h4 class="prx-h4">Infant vaccination history</h4>
                        @if($selectedInfant)
                            <p class="prx-note">Child: {{ $infantFullName($selectedInfant) }}</p>
                            @if($vaccinations->isNotEmpty())
                                <div class="prx-table-wrap">
                                    <table class="prx-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Vaccine</th>
                                                <th scope="col">Dose</th>
                                                <th scope="col">Date given</th>
                                                <th scope="col">Next due date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vaccinations as $vaccination)
                                                <tr>
                                                    <td>{{ $displayValue($vaccination->vaccine_name) }}</td>
                                                    <td>{{ $displayValue($vaccination->dose) }}</td>
                                                    <td>{{ $shortDate($vaccination->date_given) }}</td>
                                                    <td>{{ $shortDate($vaccination->next_due_date) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="prx-empty">No vaccination records are available for this child.</div>
                            @endif
                        @elseif($infantNotice)
                            <div class="prx-empty">{{ $infantNotice }}</div>
                        @else
                            <div class="prx-empty">No child is linked to this mother record yet.</div>
                        @endif
                    </section>
                @endif

                {{-- Disclaimer (existing text). --}}
                <div class="prx-doc-footer">
                    CareCradle · Irosin Rural Health Unit<br>
                    Generated from the CareCradle Mother Portal. This is a
                    system-generated record summary, not a certification of medical records.
                </div>
            </article>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('prx-form');
            if (!form) {
                return;
            }

            const boxes = Array.from(form.querySelectorAll('input[type="checkbox"][name="categories[]"]'));
            const infant = document.getElementById('prx-infant');
            const error = document.getElementById('prx-error');
            const printFlag = document.getElementById('prx-print-flag');

            const checked = () => boxes.filter((box) => box.checked).map((box) => box.value);
            const hideError = () => { error.hidden = true; };

            document.getElementById('prx-all').addEventListener('click', () => { boxes.forEach((box) => { box.checked = true; }); hideError(); });
            document.getElementById('prx-none').addEventListener('click', () => { boxes.forEach((box) => { box.checked = false; }); });
            boxes.forEach((box) => box.addEventListener('change', hideError));

            // One click: print the preview if it already matches the selection;
            // otherwise apply the selection and print once the page reloads.
            document.getElementById('prx-print').addEventListener('click', function () {
                const selected = checked();
                if (selected.length === 0) {
                    error.hidden = false;
                    error.focus?.();
                    return;
                }

                const sameCategories = selected.join(',') === form.dataset.renderedCategories;
                const sameInfant = !infant || infant.value === (form.dataset.renderedInfant || '');

                if (sameCategories && sameInfant) {
                    window.print();
                    return;
                }

                printFlag.disabled = false;
                form.submit();
            });

            // Requested print after applying a new selection.
            const url = new URL(window.location.href);
            if (url.searchParams.get('print') === '1') {
                url.searchParams.delete('print');
                window.history.replaceState(null, '', url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : ''));
                if (form.dataset.renderedCategories !== '') {
                    window.addEventListener('load', () => setTimeout(() => window.print(), 250));
                }
            }
        });
    </script>
</x-app-layout>
