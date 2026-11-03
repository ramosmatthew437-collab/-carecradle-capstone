
<x-app-layout>
    <style>
        .cc-print-page {
            --print-pink: #d94682;
            --print-dark: #3f2433;
            --print-muted: #776675;
            --print-border: #f0d9e4;
            max-width: 1120px;
            margin: 0 auto;
            padding: 30px 24px 56px;
            color: var(--print-dark);
        }

        .cc-print-page * {
            box-sizing: border-box;
        }

        .cc-print-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 26px;
        }

        .cc-print-eyebrow {
            margin: 0 0 7px;
            color: var(--print-pink);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .cc-print-heading h1 {
            margin: 0;
            color: var(--print-dark);
            font-family: "DM Serif Display", Georgia, serif;
            font-size: clamp(29px, 4vw, 40px);
            line-height: 1.15;
        }

        .cc-print-heading p {
            margin: 9px 0 0;
            color: var(--print-muted);
            font-size: 14px;
            line-height: 1.65;
        }

        .cc-print-heading-icon {
            display: grid;
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid #f4c6da;
            border-radius: 18px;
            background: #fff0f6;
            color: var(--print-pink);
        }

        .cc-print-heading-icon svg {
            width: 28px;
            height: 28px;
        }

        .cc-print-card {
            margin-bottom: 22px;
            padding: 24px;
            border: 1px solid var(--print-border);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 8px 25px rgba(111, 44, 78, .045);
        }

        .cc-print-card h2 {
            margin: 0;
            color: var(--print-dark);
            font-size: 17px;
            font-weight: 800;
        }

        .cc-print-card-intro {
            margin: 7px 0 20px;
            color: var(--print-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .cc-print-category-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .cc-print-category {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 15px;
            border: 1px solid var(--print-border);
            border-radius: 13px;
            background: #fffafd;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .cc-print-category:hover {
            border-color: #e9a3c2;
            background: #fff3f8;
        }

        .cc-print-category input {
            width: 17px;
            height: 17px;
            margin-top: 2px;
            accent-color: var(--print-pink);
            flex-shrink: 0;
        }

        .cc-print-category strong {
            display: block;
            color: var(--print-dark);
            font-size: 13px;
        }

        .cc-print-category small {
            display: block;
            margin-top: 4px;
            color: var(--print-muted);
            font-size: 12px;
            line-height: 1.45;
        }

        .cc-print-field-label {
            display: block;
            margin: 20px 0 8px;
            color: var(--print-dark);
            font-size: 12px;
            font-weight: 800;
        }

        .cc-print-select {
            width: 100%;
            max-width: 500px;
            min-height: 46px;
            padding: 10px 13px;
            border: 1px solid var(--print-border);
            border-radius: 11px;
            background: #fff;
            color: var(--print-dark);
            font-size: 14px;
        }

        .cc-print-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .cc-print-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 44px;
            padding: 11px 17px;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
        }

        .cc-print-button svg {
            width: 17px;
            height: 17px;
        }
        .cc-print-selection-tools {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 10px;
}

.cc-print-selection-tools > span {
    color: var(--print-dark);
    font-size: 13px;
    font-weight: 700;
}

.cc-print-selection-tools > div {
    display: flex;
    align-items: center;
    gap: 8px;
}

.cc-print-selection-tools button {
    padding: 7px 12px;
    border: 1px solid var(--print-border);
    border-radius: 8px;
    background: #fff;
    color: var(--print-pink);
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s ease;
}

.cc-print-selection-tools button:hover {
    border-color: var(--print-pink);
    background: #fff0f6;
}

        .cc-print-button-primary {
            background: var(--print-pink);
            color: #fff;
        }

        .cc-print-button-primary:hover {
            background: #be326d;
        }

        .cc-print-button-secondary {
            border-color: var(--print-border);
            background: #fff;
            color: var(--print-dark);
        }

        .cc-print-preview-note {
            margin: 14px 0 0;
            color: var(--print-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        /* The document shown below the controls is the printable output. */
        .cc-print-document {
            padding: 34px;
            border: 1px solid var(--print-border);
            border-radius: 18px;
            background: #fff;
        }

        .cc-print-document-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9a0bf;
        }

        .cc-print-logo-mark {
            display: grid;
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 15px;
            background: #fff0f6;
            color: var(--print-pink);
        }

        .cc-print-logo-mark svg {
            width: 30px;
            height: 30px;
        }

        .cc-print-brand-name {
            margin: 0;
            color: #bd326f;
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 25px;
            line-height: 1.2;
        }

        .cc-print-rhu-name {
            margin: 5px 0 0;
            color: #493440;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .09em;
        }

        .cc-print-document-subtitle {
            margin: 4px 0 0;
            color: var(--print-muted);
            font-size: 11px;
        }

        .cc-print-document-title {
            margin: 23px 0 6px;
            color: var(--print-dark);
            font-family: "DM Serif Display", Georgia, serif;
            font-size: 24px;
        }

        .cc-print-generated {
            margin: 0 0 22px;
            color: var(--print-muted);
            font-size: 11px;
        }

        .cc-print-record-section {
            margin-top: 24px;
            break-inside: auto;
        }

        .cc-print-record-section h3 {
            margin: 0 0 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--print-border);
            color: #bd326f;
            font-size: 15px;
            font-weight: 800;
        }

        .cc-print-data-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 22px;
        }

        .cc-print-data-item {
            min-width: 0;
            padding: 10px 0;
            border-bottom: 1px solid #f4e8ee;
            overflow-wrap: anywhere;
        }

        .cc-print-data-label {
            display: block;
            margin-bottom: 4px;
            color: var(--print-muted);
            font-size: 10px;
            font-weight: 700;
        }

        .cc-print-data-value {
            display: block;
            color: var(--print-dark);
            font-size: 12px;
            line-height: 1.55;
        }

        .cc-print-empty {
            padding: 12px 14px;
            border: 1px dashed var(--print-border);
            border-radius: 9px;
            color: var(--print-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .cc-print-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .cc-print-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .cc-print-table th {
            padding: 10px 8px;
            border-bottom: 1px solid #e9a0bf;
            background: #fff3f8;
            color: #66334c;
            text-align: left;
            font-weight: 800;
        }

        .cc-print-table td {
            padding: 9px 8px;
            border-bottom: 1px solid #f1e3ea;
            color: var(--print-dark);
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .cc-print-document-footer {
            margin-top: 32px;
            padding-top: 13px;
            border-top: 1px solid var(--print-border);
            color: var(--print-muted);
            font-size: 10px;
            line-height: 1.6;
            text-align: center;
        }

        .cc-print-screen-only {
            display: block;
        }

        @media (max-width: 640px) {
            .cc-print-page {
                padding: 22px 14px 40px;
            }

            .cc-print-card,
            .cc-print-document {
                padding: 18px;
            }

            .cc-print-category-grid,
            .cc-print-data-grid {
                grid-template-columns: 1fr;
            }

            .cc-print-heading {
                gap: 12px;
            }

            .cc-print-heading-icon {
                width: 46px;
                height: 46px;
                border-radius: 14px;
            }
        }

        @page {
            size: A4;
            margin: 14mm;
        }

        @media print {
            body {
                background: #fff !important;
                color: #222 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body * {
                visibility: hidden !important;
            }

            .cc-print-document,
            .cc-print-document * {
                visibility: visible !important;
            }

            .cc-print-page {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .cc-print-screen-only,
            .cc-print-card,
            .cc-print-heading,
            .cc-print-no-data {
                display: none !important;
            }

            .cc-print-document {
                display: block !important;
                position: absolute !important;
                inset: 0 auto auto 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                background: #fff !important;
            }

            .cc-print-document-header {
                break-inside: avoid;
            }
            .cc-print-prenatal-detail {
    break-inside: avoid;
    page-break-inside: avoid;
    margin-top: 14px;
    padding-top: 2px;
}

            .cc-print-record-section h3 {
                break-after: avoid;
            }

            .cc-print-data-item,
            .cc-print-table tr {
                break-inside: avoid;
            }

            .cc-print-table-wrap {
                overflow: visible !important;
            }

            .cc-print-table {
                font-size: 10px;
            }

            .cc-print-document-footer {
                margin-top: 25px;
            }
        }
    </style>

    @php
        $categoryLabels = [
            'personal' => 'Personal Information',
            'maternal' => 'Maternal Information',
            'emergency' => 'Emergency Contact',
            'infant' => 'Infant Health Record',
            'vaccinations' => 'Vaccination Records',
        ];

        $motherFullName = trim(
            ($mother->first_name ?? '') . ' ' .
            ($mother->middle_name ?? '') . ' ' .
            ($mother->last_name ?? '')
        );

        $motherFullName = $motherFullName ?: 'Not provided';

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

        $displayValue = function ($value) {
            if ($value === null || $value === '') {
                return 'Not provided';
            }

            if (is_bool($value)) {
                return $value ? 'Yes' : 'No';
            }

            return (string) $value;
        };

        $hasEmergencyInformation =
            filled($mother->emergency_contact_name ?? null) ||
            filled($mother->emergency_contact_number ?? null);
    @endphp

    <div class="cc-print-page">

        {{-- SCREEN-ONLY PAGE HEADER --}}
        <div class="cc-print-heading cc-print-screen-only">
            <div>
                <p class="cc-print-eyebrow">Mother Portal / Records</p>
                <h1>Print My Records</h1>
                <p>
                    Choose the information you want to include in your
                    CareCradle record summary.
                </p>
            </div>

            <div class="cc-print-heading-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7">
                    <path d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <path d="M7 14h10v7H7zM17 11h.01"/>
                </svg>
            </div>
        </div>

        {{-- SELECTION CONTROLS: NOT INCLUDED IN PRINT --}}
        <section class="cc-print-card cc-print-screen-only">
            <h2>Select your record categories</h2>
            <p class="cc-print-card-intro">
                Only checked categories will appear in the printed document.
                You can change your selection before printing.
            </p>

            <form
                id="cc-print-selection-form"
                method="GET"
                action="{{ route('mother.print-records') }}"
            >
            <div class="cc-print-selection-tools">
    <span>Select record categories</span>

    <div>
        <button type="button" id="cc-select-all">
            Select All
        </button>

        <button type="button" id="cc-deselect-all">
            Deselect All
        </button>
    </div>
</div>
                <div class="cc-print-category-grid">
                    <label class="cc-print-category">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="personal"
                            @checked(in_array('personal', $selectedCategories, true))
                        >
                        <span>
                            <strong>Personal Information</strong>
                            <small>Name, date of birth, contact details and address.</small>
                        </span>
                    </label>

                    <label class="cc-print-category">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="maternal"
                            @checked(in_array('maternal', $selectedCategories, true))
                        >
                        <span>
                            <strong>Maternal Information</strong>
                            <small>Pregnancy details and available maternal health information.</small>
                        </span>
                    </label>

                    <label class="cc-print-category">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="emergency"
                            @checked(in_array('emergency', $selectedCategories, true))
                        >
                        <span>
                            <strong>Emergency Contact</strong>
                            <small>Recorded emergency contact name and phone number.</small>
                        </span>
                    </label>


                    <label class="cc-print-category">
    <input
        type="checkbox"
        name="categories[]"
        value="prenatal"
        @checked(in_array('prenatal', $selectedCategories, true))
    >
    <span>
        <strong>Prenatal Visit Records</strong>
        <small>Visit dates, blood pressure, weight, fetal monitoring and clinical notes.</small>
    </span>
</label>

                    <label class="cc-print-category">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="infant"
                            @checked(in_array('infant', $selectedCategories, true))
                        >
                        <span>
                            <strong>Infant Health Record</strong>
                            <small>Infant details, birth measurements and growth history.</small>
                        </span>
                    </label>

                    <label class="cc-print-category">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="vaccinations"
                            @checked(in_array('vaccinations', $selectedCategories, true))
                        >
                        <span>
                            <strong>Vaccination Records</strong>
                            <small>Vaccine names, doses, dates and next scheduled dates.</small>
                        </span>
                    </label>
                </div>

                <label class="cc-print-field-label" for="cc-print-infant">
                    Infant whose records you want to print
                </label>

                <select
                    id="cc-print-infant"
                    name="infant"
                    class="cc-print-select"
                >
                    @forelse ($infants as $infantOption)
                        <option
                            value="{{ $infantOption->id }}"
                            @selected(
                                $selectedInfant &&
                                (int) $selectedInfant->id === (int) $infantOption->id
                            )
                        >
                            {{ trim(($infantOption->first_name ?? '') . ' ' . ($infantOption->last_name ?? '')) }}
                            @if ($infantOption->birth_date)
                                — {{ $dateValue($infantOption->birth_date) }}
                            @endif
                        </option>
                    @empty
                        <option value="">No infant records available</option>
                    @endforelse
                </select>

                <div class="cc-print-actions">
                    <button
                        type="submit"
                        class="cc-print-button cc-print-button-secondary"
                    >
                        Update Selection
                    </button>

                    <button
                        type="button"
                        id="cc-print-submit"
                        class="cc-print-button cc-print-button-primary"
                    >
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             aria-hidden="true">
                            <path d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <path d="M7 14h10v7H7z"/>
                        </svg>
                        Print Selected Records
                    </button>
                </div>

                <p class="cc-print-preview-note">
                    Printing opens your browser's print dialog. You can print
                    on paper or choose “Save as PDF” as the destination.
                </p>
            </form>
        </section>

        {{-- PRINTABLE DOCUMENT --}}
        <article class="cc-print-document" id="cc-print-document">

            <header class="cc-print-document-header">
                <div class="cc-print-logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.6">
                        <path d="M12 21s-8-4.7-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.3-8 11-8 11Z"/>
                        <path d="M8 12h2.5l1.5-3 2 5 1.2-2H17"/>
                    </svg>
                </div>

                <div>
                    <p class="cc-print-brand-name">CareCradle</p>
                    <p class="cc-print-rhu-name">IROSIN RURAL HEALTH UNIT</p>
                    <p class="cc-print-document-subtitle">
                        Maternal and Infant Health Records
                    </p>
                </div>
            </header>

            <h2 class="cc-print-document-title">
                Mother's Health Record Summary
            </h2>

            <p class="cc-print-generated">
                Patient: {{ $motherFullName }}
                &nbsp; | &nbsp;
                Generated: {{ now()->format('F d, Y h:i A') }}
            </p>

            @if (in_array('personal', $selectedCategories, true))
                <section class="cc-print-record-section">
                    <h3>1. Personal Information</h3>

                    <div class="cc-print-data-grid">
                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Full Name</span>
                            <span class="cc-print-data-value">{{ $motherFullName }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Mother Code</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->mother_code) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Date of Birth</span>
                            <span class="cc-print-data-value">{{ $dateValue($mother->birth_date) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Age</span>
                            <span class="cc-print-data-value">
                                @if ($mother->birth_date)
                                    {{ \Illuminate\Support\Carbon::parse($mother->birth_date)->age }} years old
                                @else
                                    Not provided
                                @endif
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Contact Number</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->contact_number) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Address</span>
                            <span class="cc-print-data-value">
                                {{ trim(($mother->address ?? '') . (filled($mother->barangay ?? null) ? ', ' . $mother->barangay : '')) ?: 'Not provided' }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Civil Status</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->civil_status) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Occupation</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->occupation) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">PhilHealth Number</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->philhealth_number) }}</span>
                        </div>

                        
                        {{-- Father's Information --}}
                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Father's Full Name</span>
                            <span class="cc-print-data-value">
                                {{ trim(
                                    ($mother->father_first_name ?? '') . ' ' .
                                    ($mother->father_middle_name ?? '') . ' ' .
                                    ($mother->father_last_name ?? '')
                                ) ?: 'Not provided' }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Father's Birth Date</span>
                            <span class="cc-print-data-value">
                                {{ $dateValue($mother->father_birth_date ?? null) }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Father's Contact Number</span>
                            <span class="cc-print-data-value">
                                {{ $displayValue($mother->father_contact_number ?? null) }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Father's Occupation</span>
                            <span class="cc-print-data-value">
                                {{ $displayValue($mother->father_occupation ?? null) }}
                            </span>
                        </div>

                    </div>
                </section>
            @endif

            @if (in_array('maternal', $selectedCategories, true))
                <section class="cc-print-record-section">
                    <h3>2. Maternal Information</h3>

                    <div class="cc-print-data-grid">
                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Blood Type</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->blood_type) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Expected Delivery Date</span>
                            <span class="cc-print-data-value">{{ $dateValue($mother->expected_delivery_date) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Last Menstrual Period</span>
                            <span class="cc-print-data-value">{{ $dateValue($mother->last_menstrual_period) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Pregnancy Number</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->pregnancy_number) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Height</span>
                            <span class="cc-print-data-value">
                                {{ $mother->height !== null && $mother->height !== '' ? $mother->height . ' cm' : 'Not provided' }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Weight</span>
                            <span class="cc-print-data-value">
                                {{ $mother->weight !== null && $mother->weight !== '' ? $mother->weight . ' kg' : 'Not provided' }}
                            </span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Pregnancy Week</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->pregnancy_week ?? null) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Trimester</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->trimester ?? null) }}</span>
                        </div>

                        <div class="cc-print-data-item">
                            <span class="cc-print-data-label">Risk Status</span>
                            <span class="cc-print-data-value">{{ $displayValue($mother->risk_status ?? null) }}</span>
                        </div>
                    </div>
                </section>
            @endif

            @if (in_array('emergency', $selectedCategories, true))
                <section class="cc-print-record-section">
                    <h3>3. Emergency Contact</h3>

                    @if ($hasEmergencyInformation)
                        <div class="cc-print-data-grid">
                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Contact Name</span>
                                <span class="cc-print-data-value">
                                    {{ $displayValue($mother->emergency_contact_name ?? null) }}
                                </span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Contact Number</span>
                                <span class="cc-print-data-value">
                                    {{ $displayValue($mother->emergency_contact_number ?? null) }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="cc-print-empty">
                            No emergency contact information is available in the
                            current mother record.
                        </div>
                    @endif
                </section>
            @endif


            
            {{-- PRENATAL VISIT RECORDS --}}
            @if (in_array('prenatal', $selectedCategories, true))
                <section class="cc-print-record-section">
                    <h3>4. Prenatal Visit Records</h3>

                    @if ($prenatalCheckups->isNotEmpty())
                        <div class="cc-print-table-wrap">
                            <table class="cc-print-table">
                                <thead>
                                    <tr>
                                        <th>Visit Date</th>
                                        <th>Gestational Age</th>
                                        <th>Weight</th>
                                        <th>Blood Pressure</th>
                                        <th>Fundal Height</th>
                                        <th>Fetal Heart Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prenatalCheckups as $checkup)
                                        <tr>
                                            <td>{{ $dateValue($checkup->visit_date) }}</td>
                                            <td>{{ $displayValue($checkup->gestational_age_weeks) }} weeks</td>
                                            <td>{{ $displayValue($checkup->weight) }}</td>
                                            <td>
                                                {{ $displayValue($checkup->systolic_bp) }}/{{ $displayValue($checkup->diastolic_bp) }}
                                            </td>
                                            <td>{{ $displayValue($checkup->fundal_height) }}</td>
                                            <td>{{ $displayValue($checkup->fetal_heart_rate) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @foreach ($prenatalCheckups as $checkup)
                            <div class="cc-print-prenatal-detail" style="margin-top: 14px;">
                                <strong style="color: #be185d; font-size: 12px;">
                                    Additional Visit Details — {{ $dateValue($checkup->visit_date) }}
                                </strong>

                                <table class="cc-print-table" style="margin-top: 6px;">
                                    <tbody>
                                        <tr>
                                            <th>Fetal Movement</th>
                                            <td>{{ $displayValue($checkup->fetal_movement) }}</td>
                                            <th>Urine Protein</th>
                                            <td>{{ $displayValue($checkup->urine_protein) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Urine Glucose</th>
                                            <td>{{ $displayValue($checkup->urine_glucose) }}</td>
                                            <th>Maternal Condition</th>
                                            <td>{{ $displayValue($checkup->maternal_condition) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Next Visit</th>
                                            <td colspan="3">{{ $dateValue($checkup->next_visit_date) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Notes</th>
                                            <td colspan="3">{{ $displayValue($checkup->notes) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="cc-print-empty">
                            No prenatal visit records are available.
                        </div>
                    @endif
                </section>
            @endif


            @if (in_array('infant', $selectedCategories, true))
                <section class="cc-print-record-section">
                  <h3>5. Infant Health Record</h3>

                    @if ($selectedInfant)
                        <div class="cc-print-data-grid">
                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Infant Name</span>
                                <span class="cc-print-data-value">
                                    {{ trim(($selectedInfant->first_name ?? '') . ' ' . ($selectedInfant->middle_name ?? '') . ' ' . ($selectedInfant->last_name ?? '')) ?: 'Not provided' }}
                                </span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Sex</span>
                                <span class="cc-print-data-value">{{ $displayValue($selectedInfant->sex) }}</span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Date of Birth</span>
                                <span class="cc-print-data-value">{{ $dateValue($selectedInfant->birth_date) }}</span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Birth Weight</span>
                                <span class="cc-print-data-value">
                                    {{ $selectedInfant->birth_weight !== null && $selectedInfant->birth_weight !== '' ? $selectedInfant->birth_weight . ' kg' : 'Not provided' }}
                                </span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Birth Length</span>
                                <span class="cc-print-data-value">
                                    {{ $selectedInfant->birth_length !== null && $selectedInfant->birth_length !== '' ? $selectedInfant->birth_length . ' cm' : 'Not provided' }}
                                </span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Head Circumference at Birth</span>
                                <span class="cc-print-data-value">
                                    {{ $selectedInfant->head_circumference !== null && $selectedInfant->head_circumference !== '' ? $selectedInfant->head_circumference . ' cm' : 'Not provided' }}
                                </span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Birth Status</span>
                                <span class="cc-print-data-value">{{ $displayValue($selectedInfant->birth_status) }}</span>
                            </div>

                            <div class="cc-print-data-item">
                                <span class="cc-print-data-label">Remarks</span>
                                <span class="cc-print-data-value">{{ $displayValue($selectedInfant->remarks) }}</span>
                            </div>
                        </div>

                        <h4 style="margin: 22px 0 10px; font-size: 12px; font-weight: 800;">
                            Growth Monitoring History
                        </h4>

                        @if ($growthRecords->isNotEmpty())
                            <div class="cc-print-table-wrap">
                                <table class="cc-print-table">
                                    <thead>
                                        <tr>
                                            <th>Date Measured</th>
                                            <th>Age (Months)</th>
                                            <th>Weight (kg)</th>
                                            <th>Height (cm)</th>
                                            <th>Head Circumference (cm)</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($growthRecords as $growth)
                                            <tr>
                                                <td>{{ $dateValue($growth->date_measured) }}</td>
                                                <td>{{ $displayValue($growth->age_in_months) }}</td>
                                                <td>{{ $displayValue($growth->weight) }}</td>
                                                <td>{{ $displayValue($growth->height) }}</td>
                                                <td>{{ $displayValue($growth->head_circumference) }}</td>
                                                <td>{{ $displayValue($growth->remarks) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="cc-print-empty">
                                No growth monitoring records are available for this infant.
                            </div>
                        @endif
                    @else
                        <div class="cc-print-empty">
                            No infant is linked to this mother record yet.
                        </div>
                    @endif
                </section>
            @endif

@if (in_array('vaccinations', $selectedCategories, true))
    <section class="cc-print-record-section">
       <h3>6. Vaccination Records</h3>

        {{-- MATERNAL VACCINATIONS --}}
        <h4 style="margin: 16px 0 10px; color: #be185d; font-size: 13px;">
            Maternal Vaccination History
        </h4>

        @if ($maternalVaccinations->isNotEmpty())
            <div class="cc-print-table-wrap">
                <table class="cc-print-table">
                    <thead>
                        <tr>
                            <th>Vaccine</th>
                            <th>Dose</th>
                            <th>Date Given</th>
                            <th>Next Due Date</th>
                            <th>Administered By</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maternalVaccinations as $maternalVaccination)
                            <tr>
                                <td>{{ $displayValue($maternalVaccination->vaccine_name) }}</td>
                                <td>{{ $displayValue($maternalVaccination->dose) }}</td>
                                <td>{{ $dateValue($maternalVaccination->date_given) }}</td>
                                <td>{{ $dateValue($maternalVaccination->next_due_date) }}</td>
                                <td>{{ $displayValue($maternalVaccination->administered_by) }}</td>
                                <td>{{ $displayValue($maternalVaccination->remarks) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="cc-print-empty">
                No maternal vaccination records are available.
            </div>
        @endif

        {{-- INFANT VACCINATIONS --}}
        <h4 style="margin: 22px 0 10px; color: #be185d; font-size: 13px;">
            Infant Vaccination History
        </h4>

        @if ($selectedInfant)
            <p style="margin: 0 0 12px; color: #776675; font-size: 11px;">
                Infant:
                {{ trim(($selectedInfant->first_name ?? '') . ' ' . ($selectedInfant->last_name ?? '')) }}
            </p>

            @if ($vaccinations->isNotEmpty())
                <div class="cc-print-table-wrap">
                    <table class="cc-print-table">
                        <thead>
                            <tr>
                                <th>Vaccine</th>
                                <th>Dose</th>
                                <th>Date Given</th>
                                <th>Next Due Date</th>
                                <th>Administered By</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vaccinations as $vaccination)
                                <tr>
                                    <td>{{ $displayValue($vaccination->vaccine_name) }}</td>
                                    <td>{{ $displayValue($vaccination->dose) }}</td>
                                    <td>{{ $dateValue($vaccination->date_given) }}</td>
                                    <td>{{ $dateValue($vaccination->next_due_date) }}</td>
                                    <td>{{ $displayValue($vaccination->administered_by) }}</td>
                                    <td>{{ $displayValue($vaccination->remarks) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="cc-print-empty">
                    No vaccination records are available for this infant.
                </div>
            @endif
        @else
            <div class="cc-print-empty">
                No infant is linked to this mother record yet.
            </div>
        @endif
    </section>
@endif


            @if (count($selectedCategories) === 0)
                <div class="cc-print-empty cc-print-no-data">
                    No categories have been selected. Return to the selection panel
                    and choose at least one category.
                </div>
            @endif

            <footer class="cc-print-document-footer">
                CareCradle · Irosin Rural Health Unit<br>
                Generated from the CareCradle Mother Portal. This is a
                system-generated record summary, not a certification of medical records.
            </footer>
        </article>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('cc-print-selection-form');
            const printButton = document.getElementById('cc-print-submit');

            const selectAllButton = document.getElementById('cc-select-all');
const deselectAllButton = document.getElementById('cc-deselect-all');

const categoryCheckboxes = form
    ? form.querySelectorAll('input[name="categories[]"]')
    : [];

            if (!form || !printButton) {
                return;
            }
            if (selectAllButton) {
    selectAllButton.addEventListener('click', function () {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
    });
}

if (deselectAllButton) {
    deselectAllButton.addEventListener('click', function () {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
    });
}

            printButton.addEventListener('click', function () {
                const selected = form.querySelectorAll(
                    'input[name="categories[]"]:checked'
                );

                if (selected.length === 0) {
                    alert('Please select at least one record category before printing.');
                    return;
                }

                const currentCategories = Array.from(selected).map(
                    checkbox => checkbox.value
                );

                const currentUrl = new URL(window.location.href);
                const params = new URLSearchParams();

                currentCategories.forEach(category => {
                    params.append('categories[]', category);
                });

                const infantSelect = document.getElementById('cc-print-infant');

                if (infantSelect && infantSelect.value) {
                    params.set('infant', infantSelect.value);
                }

                const desiredUrl =
                    currentUrl.pathname + '?' + params.toString();

                if (
                    currentUrl.pathname + currentUrl.search !== desiredUrl
                ) {
                    window.location.href = desiredUrl;
                    return;
                }

                window.print();
            });
        });
    </script>
</x-app-layout>
