<x-app-layout>

    <x-slot name="header">
        <div class="pv-edit-header">
            <span>Maternal Care</span>
            <h2>Edit Prenatal Visit</h2>
        </div>
    </x-slot>

    <div class="pv-edit-page">
        <div class="pv-edit-container">

            {{-- =========================================================
                 Hero
            ========================================================== --}}
            <section class="pv-edit-hero">
                <div class="pv-edit-hero-main">

                    <div class="pv-edit-hero-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />
                        </svg>
                    </div>

                    <div class="pv-edit-hero-content">
                        <p class="pv-edit-eyebrow">Prenatal Care Management</p>

                        <h1>Edit Prenatal Visit</h1>

                        <p class="pv-edit-hero-description">
                            Update consultation details, maternal assessment,
                            laboratory findings, clinical observations, and
                            follow-up information for this prenatal visit.
                        </p>
                    </div>
                </div>

                {{-- Mother Information --}}
                <div class="pv-edit-patient">
                    <div class="pv-edit-patient-label">
                        Mother Information
                    </div>

                    <div class="pv-edit-patient-row">
                        <div>
                            <h2>
                                {{ $prenatalCheckup->mother->first_name }}
                                {{ $prenatalCheckup->mother->last_name }}
                            </h2>

                            <p>
                                Existing prenatal health record
                            </p>
                        </div>

                        <span class="pv-edit-mother-code">
                            {{ $prenatalCheckup->mother->mother_code }}
                        </span>
                    </div>
                </div>
            </section>


            {{-- =========================================================
                 Validation Errors
            ========================================================== --}}
            @if ($errors->any())
                <section class="pv-edit-errors">

                    <div class="pv-edit-errors-header">

                        <div class="pv-edit-error-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm0-13.5a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Validation Errors</h2>
                            <p>
                                Please review the information below and correct
                                the highlighted fields before updating this visit.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-errors-list">
                        @foreach ($errors->all() as $error)
                            <div class="pv-edit-error-item">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm0-13.5a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5Z" />
                                </svg>

                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif


            {{-- =========================================================
                 Form
            ========================================================== --}}
            <form
                action="{{ route('prenatal-checkups.update', $prenatalCheckup->id) }}"
                method="POST"
                class="pv-edit-form">

                @csrf
                @method('PUT')


                {{-- =====================================================
                     Visit Information
                ====================================================== --}}
                <section class="pv-edit-card">

                    <div class="pv-edit-card-header">
                        <div class="pv-edit-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Visit Information</h2>
                            <p>
                                Update the consultation date and gestational age
                                for this prenatal visit.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-card-body">
                        <div class="pv-edit-grid">

                            <div class="pv-edit-field">
                                <label for="visit_date">Visit Date</label>

                                <input
                                    id="visit_date"
                                    type="date"
                                    name="visit_date"
                                    value="{{ old('visit_date', $prenatalCheckup->visit_date) }}"
                                    class="@error('visit_date') pv-edit-input-error @enderror">

                                @error('visit_date')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="pv-edit-field">
                                <label for="gestational_age_weeks">
                                    Gestational Age
                                </label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="gestational_age_weeks"
                                        type="number"
                                        name="gestational_age_weeks"
                                        value="{{ old('gestational_age_weeks', $prenatalCheckup->gestational_age_weeks) }}"
                                        class="@error('gestational_age_weeks') pv-edit-input-error @enderror">

                                    <span>weeks</span>
                                </div>

                                @error('gestational_age_weeks')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>


                {{-- =====================================================
                     Maternal Assessment
                ====================================================== --}}
                <section class="pv-edit-card">

                    <div class="pv-edit-card-header">
                        <div class="pv-edit-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Maternal Assessment</h2>
                            <p>
                                Record maternal vital signs and fetal assessment
                                during this prenatal consultation.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-card-body">
                        <div class="pv-edit-grid">

                            {{-- Weight --}}
                            <div class="pv-edit-field">
                                <label for="weight">Weight</label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="weight"
                                        type="number"
                                        step="0.01"
                                        name="weight"
                                        value="{{ old('weight', $prenatalCheckup->weight) }}"
                                        class="@error('weight') pv-edit-input-error @enderror">

                                    <span>kg</span>
                                </div>

                                @error('weight')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Fundal Height --}}
                            <div class="pv-edit-field">
                                <label for="fundal_height">Fundal Height</label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="fundal_height"
                                        type="number"
                                        step="0.01"
                                        name="fundal_height"
                                        value="{{ old('fundal_height', $prenatalCheckup->fundal_height) }}"
                                        class="@error('fundal_height') pv-edit-input-error @enderror">

                                    <span>cm</span>
                                </div>

                                @error('fundal_height')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Systolic --}}
                            <div class="pv-edit-field">
                                <label for="systolic_bp">
                                    Systolic Blood Pressure
                                </label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="systolic_bp"
                                        type="number"
                                        name="systolic_bp"
                                        value="{{ old('systolic_bp', $prenatalCheckup->systolic_bp) }}"
                                        class="@error('systolic_bp') pv-edit-input-error @enderror">

                                    <span>mmHg</span>
                                </div>

                                @error('systolic_bp')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Diastolic --}}
                            <div class="pv-edit-field">
                                <label for="diastolic_bp">
                                    Diastolic Blood Pressure
                                </label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="diastolic_bp"
                                        type="number"
                                        name="diastolic_bp"
                                        value="{{ old('diastolic_bp', $prenatalCheckup->diastolic_bp) }}"
                                        class="@error('diastolic_bp') pv-edit-input-error @enderror">

                                    <span>mmHg</span>
                                </div>

                                @error('diastolic_bp')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Fetal Heart Rate --}}
                            <div class="pv-edit-field">
                                <label for="fetal_heart_rate">
                                    Fetal Heart Rate
                                </label>

                                <div class="pv-edit-input-unit">
                                    <input
                                        id="fetal_heart_rate"
                                        type="number"
                                        name="fetal_heart_rate"
                                        value="{{ old('fetal_heart_rate', $prenatalCheckup->fetal_heart_rate) }}"
                                        class="@error('fetal_heart_rate') pv-edit-input-error @enderror">

                                    <span>bpm</span>
                                </div>

                                @error('fetal_heart_rate')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Fetal Movement --}}
                            <div class="pv-edit-field">
                                <label for="fetal_movement">
                                    Fetal Movement
                                </label>

                                <select
                                    id="fetal_movement"
                                    name="fetal_movement"
                                    class="@error('fetal_movement') pv-edit-input-error @enderror">

                                    <option value="">Select</option>

                                    @foreach (['Normal', 'Reduced', 'Not Yet Felt'] as $movement)
                                        <option
                                            value="{{ $movement }}"
                                            {{ old('fetal_movement', $prenatalCheckup->fetal_movement) == $movement ? 'selected' : '' }}>
                                            {{ $movement }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('fetal_movement')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>


                {{-- =====================================================
                     Laboratory Findings
                ====================================================== --}}
                <section class="pv-edit-card">

                    <div class="pv-edit-card-header">
                        <div class="pv-edit-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H15V6.75A2.25 2.25 0 0012.75 4.5h-1.5A2.25 2.25 0 009 6.75v1.5H7.875A3.375 3.375 0 004.5 11.625v2.625A6.75 6.75 0 0011.25 21h1.5a6.75 6.75 0 006.75-6.75Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Laboratory Findings</h2>
                            <p>
                                Record urine screening results obtained during
                                the prenatal consultation.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-card-body">
                        <div class="pv-edit-grid">

                            {{-- Urine Protein --}}
                            <div class="pv-edit-field">
                                <label for="urine_protein">
                                    Urine Protein
                                </label>

                                <select
                                    id="urine_protein"
                                    name="urine_protein"
                                    class="@error('urine_protein') pv-edit-input-error @enderror">

                                    <option value="">Select</option>

                                    @foreach (['Negative', 'Trace', '+1', '+2', '+3'] as $value)
                                        <option
                                            value="{{ $value }}"
                                            {{ old('urine_protein', $prenatalCheckup->urine_protein) == $value ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('urine_protein')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Urine Glucose --}}
                            <div class="pv-edit-field">
                                <label for="urine_glucose">
                                    Urine Glucose
                                </label>

                                <select
                                    id="urine_glucose"
                                    name="urine_glucose"
                                    class="@error('urine_glucose') pv-edit-input-error @enderror">

                                    <option value="">Select</option>

                                    @foreach (['Negative', 'Trace', '+1', '+2', '+3'] as $value)
                                        <option
                                            value="{{ $value }}"
                                            {{ old('urine_glucose', $prenatalCheckup->urine_glucose) == $value ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('urine_glucose')
                                    <span class="pv-edit-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>


                {{-- =====================================================
                     Assessment
                ====================================================== --}}
                <section class="pv-edit-card">

                    <div class="pv-edit-card-header">
                        <div class="pv-edit-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m9 12.75 2.25 2.25L15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Assessment</h2>
                            <p>
                                Update the mother's clinical condition,
                                assessment, and additional observations.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-card-body pv-edit-textarea-stack">

                        <div class="pv-edit-field">
                            <label for="maternal_condition">
                                Maternal Condition
                            </label>

                            <textarea
                                id="maternal_condition"
                                name="maternal_condition"
                                rows="4"
                                class="@error('maternal_condition') pv-edit-input-error @enderror">{{ old('maternal_condition', $prenatalCheckup->maternal_condition) }}</textarea>

                            @error('maternal_condition')
                                <span class="pv-edit-field-error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="pv-edit-field">
                            <label for="notes">
                                Notes
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="5"
                                class="@error('notes') pv-edit-input-error @enderror">{{ old('notes', $prenatalCheckup->notes) }}</textarea>

                            @error('notes')
                                <span class="pv-edit-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </section>


                {{-- =====================================================
                     Follow-up
                ====================================================== --}}
                <section class="pv-edit-card">

                    <div class="pv-edit-card-header">
                        <div class="pv-edit-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z" />
                            </svg>
                        </div>

                        <div>
                            <h2>Follow-up Schedule</h2>
                            <p>
                                Update the recommended return appointment for
                                continuous prenatal monitoring.
                            </p>
                        </div>
                    </div>

                    <div class="pv-edit-card-body">

                        <div class="pv-edit-field pv-edit-followup-field">
                            <label for="next_visit_date">
                                Next Visit Date
                            </label>

                            <input
                                id="next_visit_date"
                                type="date"
                                name="next_visit_date"
                                value="{{ old('next_visit_date', $prenatalCheckup->next_visit_date) }}"
                                class="@error('next_visit_date') pv-edit-input-error @enderror">

                            <p class="pv-edit-helper">
                                Select the recommended date for the mother's
                                next prenatal consultation.
                            </p>

                            @error('next_visit_date')
                                <span class="pv-edit-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </section>


                {{-- =====================================================
                     Actions
                ====================================================== --}}
                <section class="pv-edit-actions">

                    <div class="pv-edit-actions-content">
                        <div>
                            <span class="pv-edit-actions-label">
                                Record Update
                            </span>

                            <h3>Ready to update this prenatal visit?</h3>

                            <p>
                                Review the information carefully before saving.
                                The updated details will be reflected in the
                                mother's CareCradle medical record.
                            </p>
                        </div>

                        <div class="pv-edit-action-buttons">

                            <a
                                href="{{ route('mothers.show', $prenatalCheckup->mother->id) }}"
                                class="pv-edit-cancel-btn">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>

                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="pv-edit-submit-btn">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487a2.625 2.625 0 1 1 3.712 3.713L7.5 21H3v-4.5L16.862 4.487Z" />
                                </svg>

                                Update Prenatal Visit
                            </button>

                        </div>
                    </div>

                </section>

            </form>

        </div>
    </div>

</x-app-layout>