{{--
    Prenatal visit form fields, shared by Add and Edit.
    Expects $visit (null when adding). Field names, option values, and
    old-input behaviour are unchanged; validation stays on the server
    (StorePrenatalCheckupRequest), so no browser-side required/min/max
    rules are added here.
--}}
@php
    $pvValue = fn (string $field) => old($field, $visit?->{$field});
    $pvHas = fn (string $field) => $errors->has($field);
    $pvMovements = ['Normal', 'Reduced', 'Not Yet Felt'];
    $pvUrineResults = ['Negative', 'Trace', '+1', '+2', '+3'];
@endphp

@if ($errors->any())
    <section class="pv-alert pv-alert-error" role="alert" aria-labelledby="pv-error-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0Zm-9 3.75h.008v.008H12v-.008Z"/>
        </svg>
        <div>
            <p class="pv-alert-title" id="pv-error-title">
                {{ $errors->count() }} {{ \Illuminate\Support\Str::plural('issue', $errors->count()) }}
                need{{ $errors->count() === 1 ? 's' : '' }} your attention
            </p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

{{-- ================= 01 Visit details ================= --}}
<section class="pv-card" aria-labelledby="pv-sec-visit">
    <div class="pv-card-head">
        <div class="pv-card-head-main">
            <span class="pv-step">01</span>
            <div>
                <h2 class="pv-card-title" id="pv-sec-visit">Visit Details</h2>
                <p class="pv-card-sub">When the visit took place and how far along the pregnancy is.</p>
            </div>
        </div>
    </div>

    <div class="pv-grid">
        <div class="pv-field {{ $pvHas('visit_date') ? 'has-error' : '' }}">
            <label for="visit_date">Visit Date <span class="pv-req" aria-hidden="true">*</span></label>
            <input id="visit_date" type="date" name="visit_date" value="{{ $pvValue('visit_date') }}"
                   class="pv-input" aria-required="true"
                   @if ($pvHas('visit_date')) aria-invalid="true" aria-describedby="visit_date_error" @endif>
            @error('visit_date')
                <p class="pv-error" id="visit_date_error">{{ $message }}</p>
            @enderror
        </div>

        <div class="pv-field {{ $pvHas('gestational_age_weeks') ? 'has-error' : '' }}">
            <label for="gestational_age_weeks">Gestational Age <span class="pv-req" aria-hidden="true">*</span></label>
            <div class="pv-input-group">
                <input id="gestational_age_weeks" type="number" name="gestational_age_weeks" value="{{ $pvValue('gestational_age_weeks') }}"
                       inputmode="numeric" class="pv-input" aria-required="true" placeholder="e.g. 20"
                       @if ($pvHas('gestational_age_weeks')) aria-invalid="true" aria-describedby="gestational_age_weeks_error" @endif>
                <span class="pv-suffix" aria-hidden="true">weeks</span>
            </div>
            @error('gestational_age_weeks')
                <p class="pv-error" id="gestational_age_weeks_error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- ================= 02 Maternal assessment ================= --}}
<section class="pv-card" aria-labelledby="pv-sec-assessment">
    <div class="pv-card-head">
        <div class="pv-card-head-main">
            <span class="pv-step">02</span>
            <div>
                <h2 class="pv-card-title" id="pv-sec-assessment">Maternal Assessment</h2>
                <p class="pv-card-sub">Vital signs and fetal assessment recorded during the visit.</p>
            </div>
        </div>
    </div>

    <div class="pv-grid pv-grid-3">
        @foreach ([
            ['weight', 'Weight', 'kg', true, '0.01', 'decimal', 'e.g. 55.5'],
            ['systolic_bp', 'Systolic BP', 'mmHg', true, null, 'numeric', 'e.g. 110'],
            ['diastolic_bp', 'Diastolic BP', 'mmHg', true, null, 'numeric', 'e.g. 70'],
            ['fundal_height', 'Fundal Height', 'cm', false, '0.01', 'decimal', 'e.g. 20'],
            ['fetal_heart_rate', 'Fetal Heart Rate', 'bpm', false, null, 'numeric', 'e.g. 140'],
        ] as [$name, $label, $unit, $required, $step, $mode, $placeholder])
            <div class="pv-field {{ $pvHas($name) ? 'has-error' : '' }}">
                <label for="{{ $name }}">
                    {{ $label }}
                    @if ($required)
                        <span class="pv-req" aria-hidden="true">*</span>
                    @else
                        <span class="pv-optional">Optional</span>
                    @endif
                </label>
                <div class="pv-input-group">
                    <input id="{{ $name }}" type="number" name="{{ $name }}" value="{{ $pvValue($name) }}"
                           @if ($step) step="{{ $step }}" @endif
                           inputmode="{{ $mode }}" class="pv-input" placeholder="{{ $placeholder }}"
                           @if ($required) aria-required="true" @endif
                           @if ($pvHas($name)) aria-invalid="true" aria-describedby="{{ $name }}_error" @endif>
                    <span class="pv-suffix" aria-hidden="true">{{ $unit }}</span>
                </div>
                @error($name)
                    <p class="pv-error" id="{{ $name }}_error">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div class="pv-field {{ $pvHas('fetal_movement') ? 'has-error' : '' }}">
            <label for="fetal_movement">Fetal Movement <span class="pv-optional">Optional</span></label>
            <select id="fetal_movement" name="fetal_movement"
                    @if ($pvHas('fetal_movement')) aria-invalid="true" aria-describedby="fetal_movement_error" @endif>
                <option value="">Select</option>
                @foreach ($pvMovements as $movement)
                    <option value="{{ $movement }}" @selected((string) $pvValue('fetal_movement') === $movement)>{{ $movement }}</option>
                @endforeach
            </select>
            @error('fetal_movement')
                <p class="pv-error" id="fetal_movement_error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

{{-- ================= 03 Laboratory findings ================= --}}
<section class="pv-card" aria-labelledby="pv-sec-labs">
    <div class="pv-card-head">
        <div class="pv-card-head-main">
            <span class="pv-step">03</span>
            <div>
                <h2 class="pv-card-title" id="pv-sec-labs">Laboratory Findings</h2>
                <p class="pv-card-sub">Enter urine results manually and, optionally, attach laboratory reports. Attachments never change the values entered here.</p>
            </div>
        </div>
    </div>

    <div class="pv-grid">
        @foreach (['urine_protein' => 'Urine Protein', 'urine_glucose' => 'Urine Glucose'] as $name => $label)
            <div class="pv-field {{ $pvHas($name) ? 'has-error' : '' }}">
                <label for="{{ $name }}">{{ $label }} <span class="pv-optional">Optional</span></label>
                <select id="{{ $name }}" name="{{ $name }}"
                        @if ($pvHas($name)) aria-invalid="true" aria-describedby="{{ $name }}_error" @endif>
                    <option value="">Select result</option>
                    @foreach ($pvUrineResults as $result)
                        <option value="{{ $result }}" @selected((string) $pvValue($name) === $result)>{{ $result }}</option>
                    @endforeach
                </select>
                @error($name)
                    <p class="pv-error" id="{{ $name }}_error">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
    </div>

    @if ($visit && $visit->attachments->isNotEmpty())
        <h3 class="pv-subhead">Documents already attached</h3>
        <ul class="pv-doc-list" aria-label="Documents already attached">
            @foreach ($visit->attachments as $attachment)
                @php
                    $pvExt = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                    $pvIsImage = in_array($pvExt, ['jpg', 'jpeg', 'png'], true);
                @endphp
                <li class="pv-doc-row">
                    <span class="pv-doc-type">{{ $pvExt ?: 'file' }}</span>
                    <div class="pv-doc-body">
                        <p class="pv-doc-name">{{ $attachment->file_name }}</p>
                        <p class="pv-doc-meta">{{ number_format($attachment->file_size / 1024, 1) }} KB</p>
                    </div>
                    @if ($pvIsImage)
                        <a href="{{ route('midwife.prenatal-attachments.preview', $attachment->id) }}" target="_blank" rel="noopener"
                           class="pv-btn pv-btn-quiet pv-btn-sm" aria-label="View {{ $attachment->file_name }}">View</a>
                    @endif
                    <a href="{{ route('midwife.prenatal-attachments.download', $attachment->id) }}"
                       class="pv-btn pv-btn-secondary pv-btn-sm" aria-label="Download {{ $attachment->file_name }}">Download</a>
                </li>
            @endforeach
        </ul>
        <p class="pv-hint">These stay with the visit when you save. To remove one, use Delete on the visit details page.</p>
    @endif

    <div style="margin-top: 1.25rem;">
        @include('prenatal-checkups._lab-upload', [
            'labUploadLabel' => $visit ? 'Add Laboratory Documents' : 'Laboratory Documents',
            'labUploadFieldClass' => 'pv-field',
            'labUploadInputClass' => 'pv-input',
            'labUploadErrorClass' => 'pv-error',
            'labUploadExisting' => $visit ? $visit->attachments->count() : 0,
        ])
    </div>
</section>

{{-- ================= 04 Notes & follow-up ================= --}}
<section class="pv-card" aria-labelledby="pv-sec-notes">
    <div class="pv-card-head">
        <div class="pv-card-head-main">
            <span class="pv-step">04</span>
            <div>
                <h2 class="pv-card-title" id="pv-sec-notes">Notes &amp; Follow-up</h2>
                <p class="pv-card-sub">Clinical observations and the next scheduled visit.</p>
            </div>
        </div>
    </div>

    <div class="pv-grid">
        <div class="pv-field {{ $pvHas('maternal_condition') ? 'has-error' : '' }}">
            <label for="maternal_condition">Maternal Condition <span class="pv-optional">Optional</span></label>
            <textarea id="maternal_condition" name="maternal_condition" rows="4" placeholder="Describe the mother's current condition..."
                      @if ($pvHas('maternal_condition')) aria-invalid="true" aria-describedby="maternal_condition_error" @endif>{{ $pvValue('maternal_condition') }}</textarea>
            @error('maternal_condition')
                <p class="pv-error" id="maternal_condition_error">{{ $message }}</p>
            @enderror
        </div>

        <div class="pv-field {{ $pvHas('notes') ? 'has-error' : '' }}">
            <label for="notes">Clinical Notes <span class="pv-optional">Optional</span></label>
            <textarea id="notes" name="notes" rows="4" placeholder="Optional notes for this visit..."
                      @if ($pvHas('notes')) aria-invalid="true" aria-describedby="notes_error" @endif>{{ $pvValue('notes') }}</textarea>
            @error('notes')
                <p class="pv-error" id="notes_error">{{ $message }}</p>
            @enderror
        </div>

        <div class="pv-field {{ $pvHas('next_visit_date') ? 'has-error' : '' }}">
            <label for="next_visit_date">Next Visit Date <span class="pv-optional">Optional</span></label>
            <input id="next_visit_date" type="date" name="next_visit_date" value="{{ $pvValue('next_visit_date') }}" class="pv-input"
                   @if ($pvHas('next_visit_date')) aria-invalid="true" aria-describedby="next_visit_date_error" @endif>
            @error('next_visit_date')
                <p class="pv-error" id="next_visit_date_error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>
