{{--
    Infant details, birth measurements and clinical remarks, shared by
    Infant Registration and Infant Edit. Expects $infant (null when
    registering). Field names are unchanged. On edit, the remarks box holds
    only the clinical remarks; a registration exception is kept by the server.
--}}
@php
    $infValue = fn (string $field) => old($field, $infant?->{$field});
    $infDate = function (string $field) use ($infant) {
        $value = old($field, $infant?->{$field});
        return filled($value) ? \Carbon\Carbon::parse($value)->format('Y-m-d') : '';
    };
    $infHas = fn (string $field) => $errors->has($field) ? ' has-error' : '';

    // Calendar limit for the birth date: today. An older record whose stored
    // birth date is already in the future keeps that date selectable (the
    // server accepts it only while unchanged; any changed date must be today
    // or earlier), so its unrelated edits are not blocked by the browser.
    $infToday = today()->toDateString();
    $infStoredBirth = $infant?->birth_date ? \Carbon\Carbon::parse($infant->birth_date)->toDateString() : null;
    $infLegacyFutureBirth = $infStoredBirth !== null && $infStoredBirth > $infToday;
    $infBirthMax = $infLegacyFutureBirth ? $infStoredBirth : $infToday;
@endphp

<section class="inf-card" aria-labelledby="inf-details-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="inf-details-title">Infant Details</h2>
                <p class="inf-card-sub">Name, sex, and birth information.</p>
            </div>
        </div>
    </div>

    <div class="inf-grid inf-grid-3">
        <div class="inf-field{{ $infHas('first_name') }}">
            <label for="first_name" class="inf-label">First Name <span class="inf-req">*</span></label>
            <input id="first_name" type="text" name="first_name" value="{{ $infValue('first_name') }}" class="inf-input" maxlength="255" autocomplete="off" required>
            @error('first_name') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('middle_name') }}">
            <label for="middle_name" class="inf-label">Middle Name <span class="inf-optional">Optional</span></label>
            <input id="middle_name" type="text" name="middle_name" value="{{ $infValue('middle_name') }}" class="inf-input" maxlength="255" autocomplete="off">
            @error('middle_name') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('last_name') }}">
            <label for="last_name" class="inf-label">Last Name <span class="inf-req">*</span></label>
            <input id="last_name" type="text" name="last_name" value="{{ $infValue('last_name') }}" class="inf-input" maxlength="255" autocomplete="off" required>
            @error('last_name') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field{{ $infHas('sex') }}">
            <label for="sex" class="inf-label">Sex <span class="inf-req">*</span></label>
            <select id="sex" name="sex" class="inf-input" required>
                <option value="">Select sex</option>
                <option value="Male" @selected($infValue('sex') === 'Male')>Male</option>
                <option value="Female" @selected($infValue('sex') === 'Female')>Female</option>
            </select>
            @error('sex') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('birth_date') }}">
            <label for="birth_date" class="inf-label">Date of Birth <span class="inf-req">*</span></label>
            <input id="birth_date" type="date" name="birth_date" value="{{ $infDate('birth_date') }}" class="inf-input"
                   max="{{ $infBirthMax }}" aria-describedby="birth_date_hint" required>
            <p class="inf-hint" id="birth_date_hint">
                @if ($infLegacyFutureBirth)
                    The recorded date is in the future. It can be kept for other corrections, but a new date must be today or earlier.
                @else
                    Today or earlier.
                @endif
            </p>
            @error('birth_date') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('birth_status') }}">
            <label for="birth_status" class="inf-label">Birth Status <span class="inf-req">*</span></label>
            <select id="birth_status" name="birth_status" class="inf-input" required>
                <option value="">Select status</option>
                <option value="Alive" @selected($infValue('birth_status') === 'Alive')>Alive</option>
                <option value="Stillbirth" @selected($infValue('birth_status') === 'Stillbirth')>Stillbirth</option>
            </select>
            @error('birth_status') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<section class="inf-card" aria-labelledby="inf-measure-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="inf-measure-title">Birth Measurements</h2>
                <p class="inf-card-sub">Recorded at birth.</p>
            </div>
        </div>
    </div>

    <div class="inf-grid inf-grid-3">
        <div class="inf-field{{ $infHas('birth_weight') }}">
            <label for="birth_weight" class="inf-label">Birth Weight <span class="inf-req">*</span></label>
            <div class="inf-input-group">
                <input id="birth_weight" type="number" step="0.01" min="0" max="999.99" name="birth_weight" value="{{ $infValue('birth_weight') }}" class="inf-input" placeholder="e.g. 3.2" inputmode="decimal" required>
                <span class="inf-suffix">kg</span>
            </div>
            @error('birth_weight') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('birth_length') }}">
            <label for="birth_length" class="inf-label">Birth Length <span class="inf-req">*</span></label>
            <div class="inf-input-group">
                <input id="birth_length" type="number" step="0.01" min="0" max="999.99" name="birth_length" value="{{ $infValue('birth_length') }}" class="inf-input" placeholder="e.g. 49" inputmode="decimal" required>
                <span class="inf-suffix">cm</span>
            </div>
            @error('birth_length') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
        <div class="inf-field{{ $infHas('head_circumference') }}">
            <label for="head_circumference" class="inf-label">Head Circumference <span class="inf-optional">Optional</span></label>
            <div class="inf-input-group">
                <input id="head_circumference" type="number" step="0.01" min="0" max="999.99" name="head_circumference" value="{{ $infValue('head_circumference') }}" class="inf-input" placeholder="e.g. 34" inputmode="decimal">
                <span class="inf-suffix">cm</span>
            </div>
            @error('head_circumference') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<section class="inf-card" aria-labelledby="inf-remarks-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="inf-remarks-title">Clinical Remarks</h2>
                <p class="inf-card-sub">Observations at birth or follow-up notes.</p>
            </div>
        </div>
    </div>

    <div class="inf-field{{ $infHas('remarks') }}">
        <label for="remarks" class="inf-label">Remarks <span class="inf-optional">Optional</span></label>
        <textarea id="remarks" name="remarks" rows="4" class="inf-input" placeholder="Any observations about the infant">{{ old('remarks', $infant?->clinicalRemarks()) }}</textarea>
        @error('remarks') <p class="inf-error">{{ $message }}</p> @enderror
    </div>
</section>
