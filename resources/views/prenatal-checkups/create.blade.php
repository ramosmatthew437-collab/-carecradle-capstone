<x-app-layout>

    <x-slot name="header">
        <div class="pc-header">
            <span>Maternal Records</span>
            <h2>Add Prenatal Visit</h2>
        </div>
    </x-slot>

    <div class="pc-page">
        <div class="pc-container">

            {{-- ====================================== --}}
            {{-- PATIENT HEADER --}}
            {{-- ====================================== --}}
            <section class="pc-patient-hero">

                <div class="pc-hero-decoration pc-hero-decoration-one"></div>
                <div class="pc-hero-decoration pc-hero-decoration-two"></div>

                <div class="pc-patient-content">

                    <div class="pc-patient-main">

                        <div class="pc-patient-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                            </svg>
                        </div>

                        <div class="pc-patient-details">
                            <p class="pc-eyebrow">
                                Prenatal Visit For
                            </p>

                            <h1>
                                {{ $mother->first_name }} {{ $mother->last_name }}
                            </h1>

                            <p class="pc-mother-code">
                                {{ $mother->mother_code }}
                            </p>
                        </div>

                    </div>

                    @if(isset($mother->status))
                        @php
                            $statusClasses = match($mother->status) {
                                'Pregnant' => 'pc-status-pregnant',
                                'Delivered' => 'pc-status-delivered',
                                'Referred' => 'pc-status-referred',
                                default => 'pc-status-default',
                            };
                        @endphp

                        <span class="pc-status {{ $statusClasses }}">
                            {{ $mother->status }}
                        </span>
                    @endif

                </div>
            </section>


            {{-- ====================================== --}}
            {{-- VALIDATION ERRORS --}}
            {{-- ====================================== --}}
            @if ($errors->any())
                <section class="pc-error-card">

                    <div class="pc-error-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                    </div>

                    <div class="pc-error-content">
                        <h3>
                            {{ $errors->count() }}
                            {{ Str::plural('issue', $errors->count()) }}
                            need{{ $errors->count() === 1 ? 's' : '' }} your attention
                        </h3>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    <span></span>
                                    <p>{{ $error }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </section>
            @endif


            {{-- ====================================== --}}
            {{-- MAIN FORM --}}
            {{-- ====================================== --}}
            <section class="pc-form-card">

                <div class="pc-form-header">

                    <div class="pc-form-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                        </svg>
                    </div>

                    <div>
                        <h2>Prenatal Visit Information</h2>
                        <p>
                            Record maternal assessment, vital signs, and laboratory findings for this visit.
                        </p>
                    </div>

                </div>


                <form action="{{ route('prenatal-checkups.store', $mother->id) }}"
                      method="POST"
                      class="pc-form">

                    @csrf


                    {{-- ====================================== --}}
                    {{-- VISIT INFORMATION --}}
                    {{-- ====================================== --}}
                    <div class="pc-section">

                        <div class="pc-section-heading">
                            <span class="pc-section-number">01</span>

                            <div>
                                <h3>Visit Information</h3>
                                <p>Basic information about this prenatal visit.</p>
                            </div>
                        </div>

                        <div class="pc-fields pc-fields-two">

                            {{-- Visit Date --}}
                            <div class="pc-field">
                                <label for="visit_date">Visit Date</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="visit_date"
                                        type="date"
                                        name="visit_date"
                                        value="{{ old('visit_date') }}"
                                        class="pc-input">
                                </div>

                                @error('visit_date')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Gestational Age --}}
                            <div class="pc-field">
                                <label for="gestational_age_weeks">
                                    Gestational Age (Weeks)
                                </label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="gestational_age_weeks"
                                        type="number"
                                        name="gestational_age_weeks"
                                        value="{{ old('gestational_age_weeks') }}"
                                        class="pc-input">
                                </div>

                                @error('gestational_age_weeks')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>


                    {{-- ====================================== --}}
                    {{-- MATERNAL ASSESSMENT --}}
                    {{-- ====================================== --}}
                    <div class="pc-section">

                        <div class="pc-section-heading">
                            <span class="pc-section-number">02</span>

                            <div>
                                <h3>Maternal Assessment</h3>
                                <p>Record the mother's vital signs and physical assessment.</p>
                            </div>
                        </div>

                        <div class="pc-fields pc-fields-two">

                            {{-- Weight --}}
                            <div class="pc-field">
                                <label for="weight">Weight (kg)</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="weight"
                                        type="number"
                                        step="0.01"
                                        name="weight"
                                        value="{{ old('weight') }}"
                                        class="pc-input">
                                </div>

                                @error('weight')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Fundal Height --}}
                            <div class="pc-field">
                                <label for="fundal_height">Fundal Height (cm)</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M7 3v18M17 3v18M3 8h4m10 0h4M3 16h4m10 0h4"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="fundal_height"
                                        type="number"
                                        step="0.01"
                                        name="fundal_height"
                                        value="{{ old('fundal_height') }}"
                                        class="pc-input">
                                </div>

                                @error('fundal_height')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Systolic --}}
                            <div class="pc-field">
                                <label for="systolic_bp">Systolic Blood Pressure</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="systolic_bp"
                                        type="number"
                                        name="systolic_bp"
                                        value="{{ old('systolic_bp') }}"
                                        class="pc-input">
                                </div>

                                @error('systolic_bp')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Diastolic --}}
                            <div class="pc-field">
                                <label for="diastolic_bp">Diastolic Blood Pressure</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="diastolic_bp"
                                        type="number"
                                        name="diastolic_bp"
                                        value="{{ old('diastolic_bp') }}"
                                        class="pc-input">
                                </div>

                                @error('diastolic_bp')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Fetal Heart Rate --}}
                            <div class="pc-field">
                                <label for="fetal_heart_rate">
                                    Fetal Heart Rate (bpm)
                                </label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="fetal_heart_rate"
                                        type="number"
                                        name="fetal_heart_rate"
                                        value="{{ old('fetal_heart_rate') }}"
                                        class="pc-input">
                                </div>

                                @error('fetal_heart_rate')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Fetal Movement --}}
                            <div class="pc-field">
                                <label for="fetal_movement">Fetal Movement</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    </div>

                                    <select
                                        id="fetal_movement"
                                        name="fetal_movement"
                                        class="pc-input pc-select">

                                        <option value="" {{ old('fetal_movement') == '' ? 'selected' : '' }}>
                                            Select
                                        </option>

                                        <option value="Normal" {{ old('fetal_movement') == 'Normal' ? 'selected' : '' }}>
                                            Normal
                                        </option>

                                        <option value="Reduced" {{ old('fetal_movement') == 'Reduced' ? 'selected' : '' }}>
                                            Reduced
                                        </option>

                                        <option value="Not Yet Felt" {{ old('fetal_movement') == 'Not Yet Felt' ? 'selected' : '' }}>
                                            Not Yet Felt
                                        </option>

                                    </select>
                                </div>

                                @error('fetal_movement')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>


                    {{-- ====================================== --}}
                    {{-- LABORATORY FINDINGS --}}
                    {{-- ====================================== --}}
                    <div class="pc-section">

                        <div class="pc-section-heading">
                            <span class="pc-section-number">03</span>

                            <div>
                                <h3>Laboratory Findings</h3>
                                <p>Record available urine screening results.</p>
                            </div>
                        </div>

                        <div class="pc-fields pc-fields-two">

                            {{-- Urine Protein --}}
                            <div class="pc-field">
                                <label for="urine_protein">Urine Protein</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                                        </svg>
                                    </div>

                                    <select
                                        id="urine_protein"
                                        name="urine_protein"
                                        class="pc-input pc-select">

                                        <option value="" {{ old('urine_protein') == '' ? 'selected' : '' }}>
                                            Select
                                        </option>

                                        <option value="Negative" {{ old('urine_protein') == 'Negative' ? 'selected' : '' }}>
                                            Negative
                                        </option>

                                        <option value="Trace" {{ old('urine_protein') == 'Trace' ? 'selected' : '' }}>
                                            Trace
                                        </option>

                                        <option value="+1" {{ old('urine_protein') == '+1' ? 'selected' : '' }}>
                                            +1
                                        </option>

                                        <option value="+2" {{ old('urine_protein') == '+2' ? 'selected' : '' }}>
                                            +2
                                        </option>

                                        <option value="+3" {{ old('urine_protein') == '+3' ? 'selected' : '' }}>
                                            +3
                                        </option>

                                    </select>
                                </div>

                                @error('urine_protein')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Urine Glucose --}}
                            <div class="pc-field">
                                <label for="urine_glucose">Urine Glucose</label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                                        </svg>
                                    </div>

                                    <select
                                        id="urine_glucose"
                                        name="urine_glucose"
                                        class="pc-input pc-select">

                                        <option value="" {{ old('urine_glucose') == '' ? 'selected' : '' }}>
                                            Select
                                        </option>

                                        <option value="Negative" {{ old('urine_glucose') == 'Negative' ? 'selected' : '' }}>
                                            Negative
                                        </option>

                                        <option value="Trace" {{ old('urine_glucose') == 'Trace' ? 'selected' : '' }}>
                                            Trace
                                        </option>

                                        <option value="+1" {{ old('urine_glucose') == '+1' ? 'selected' : '' }}>
                                            +1
                                        </option>

                                        <option value="+2" {{ old('urine_glucose') == '+2' ? 'selected' : '' }}>
                                            +2
                                        </option>

                                        <option value="+3" {{ old('urine_glucose') == '+3' ? 'selected' : '' }}>
                                            +3
                                        </option>

                                    </select>
                                </div>

                                @error('urine_glucose')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>


                    {{-- ====================================== --}}
                    {{-- NOTES & FOLLOW-UP --}}
                    {{-- ====================================== --}}
                    <div class="pc-section pc-section-last">

                        <div class="pc-section-heading">
                            <span class="pc-section-number">04</span>

                            <div>
                                <h3>Notes & Follow-up</h3>
                                <p>Add clinical notes and schedule the next visit.</p>
                            </div>
                        </div>

                        <div class="pc-fields pc-fields-one">

                            {{-- Maternal Condition --}}
                            <div class="pc-field">
                                <label for="maternal_condition">
                                    Maternal Condition
                                </label>

                                <textarea
                                    id="maternal_condition"
                                    name="maternal_condition"
                                    rows="4"
                                    placeholder="Describe the mother's current condition..."
                                    class="pc-textarea">{{ old('maternal_condition') }}</textarea>

                                @error('maternal_condition')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Notes --}}
                            <div class="pc-field">
                                <label for="notes">Notes</label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="4"
                                    placeholder="Optional notes for this visit..."
                                    class="pc-textarea">{{ old('notes') }}</textarea>

                                @error('notes')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- Next Visit --}}
                            <div class="pc-field pc-next-visit">
                                <label for="next_visit_date">
                                    Next Visit Date
                                </label>

                                <div class="pc-input-wrap">
                                    <div class="pc-input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z"/>
                                        </svg>
                                    </div>

                                    <input
                                        id="next_visit_date"
                                        type="date"
                                        name="next_visit_date"
                                        value="{{ old('next_visit_date') }}"
                                        class="pc-input">
                                </div>

                                @error('next_visit_date')
                                    <p class="pc-field-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>


                    {{-- ====================================== --}}
                    {{-- ACTIONS --}}
                    {{-- ====================================== --}}
                    <div class="pc-actions">

                        <button type="submit" class="pc-save-btn">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>

                            <span>Save Prenatal Visit</span>
                        </button>

                        <a href="{{ route('mothers.show', $mother->id) }}"
                           class="pc-cancel-btn">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                            </svg>

                            <span>Back to Mother Profile</span>
                        </a>

                    </div>

                </form>

            </section>

        </div>
    </div>

</x-app-layout>