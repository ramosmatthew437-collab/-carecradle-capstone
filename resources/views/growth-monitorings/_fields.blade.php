{{--
    Growth measurement fields, shared by growth-monitorings/create and
    growth-monitorings/edit. Expects $infant and $growthMonitoring (null
    when adding). Field names are unchanged, except that age_in_months is no
    longer submitted: the server calculates it from the birth date and the
    measurement date (GrowthMonitoring::completedMonths). The age shown here
    is a preview of that calculation.
--}}
@php
    $gmBirth = $infant->birth_date ? \Carbon\Carbon::parse($infant->birth_date)->toDateString() : null;
    $gmDateValue = old('date_measured', $growthMonitoring?->date_measured);
    $gmDate = filled($gmDateValue) ? \Carbon\Carbon::parse($gmDateValue)->format('Y-m-d') : '';
    $gmAge = \App\Models\GrowthMonitoring::completedMonths($gmBirth, $gmDate ?: null);
    $gmAgeText = $gmAge === null
        ? ($growthMonitoring && $gmDate ? 'Kept as recorded: ' . $growthMonitoring->age_in_months . ' months' : 'Choose the measurement date')
        : $gmAge . ' ' . \Illuminate\Support\Str::plural('month', $gmAge);
    $gmValue = fn (string $field) => old($field, $growthMonitoring?->{$field});
    $gmHas = fn (string $field) => $errors->has($field) ? ' has-error' : '';
@endphp

<section class="inf-card" aria-labelledby="gm-measure-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="gm-measure-title">Measurements</h2>
                <p class="inf-card-sub">Enter the values taken at this visit.</p>
            </div>
        </div>
    </div>

    <div class="inf-grid">
        <div class="inf-field{{ $gmHas('date_measured') }}">
            <label for="date_measured" class="inf-label">Measurement Date <span class="inf-req">*</span></label>
            <input id="date_measured" type="date" name="date_measured" value="{{ $gmDate }}" class="inf-input"
                   data-gm-date data-birth="{{ $gmBirth }}"
                   @unless ($growthMonitoring)
                       max="{{ today()->toDateString() }}" @if ($gmBirth) min="{{ $gmBirth }}" @endif
                   @endunless
                   required>
            <p class="inf-hint">Not in the future, and not before the birth date{{ $gmBirth ? ' (' . \Carbon\Carbon::parse($gmBirth)->format('M d, Y') . ')' : '' }}.</p>
            @error('date_measured') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field">
            <span class="inf-label" id="gm-age-label">Age at Measurement</span>
            <output class="inf-output" data-gm-age aria-labelledby="gm-age-label" aria-live="polite">{{ $gmAgeText }}</output>
            <p class="inf-hint">Calculated automatically in completed months from the date of birth.</p>
        </div>

        <div class="inf-field{{ $gmHas('weight') }}">
            <label for="weight" class="inf-label">Weight <span class="inf-req">*</span></label>
            <div class="inf-input-group">
                <input id="weight" type="number" step="0.01" min="0" max="999.99" name="weight" value="{{ $gmValue('weight') }}" class="inf-input" placeholder="e.g. 4.5" inputmode="decimal" required>
                <span class="inf-suffix">kg</span>
            </div>
            @error('weight') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field{{ $gmHas('height') }}">
            <label for="height" class="inf-label">Length / Height <span class="inf-req">*</span></label>
            <div class="inf-input-group">
                <input id="height" type="number" step="0.01" min="0" max="999.99" name="height" value="{{ $gmValue('height') }}" class="inf-input" placeholder="e.g. 58" inputmode="decimal" required>
                <span class="inf-suffix">cm</span>
            </div>
            @error('height') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field{{ $gmHas('head_circumference') }}">
            <label for="head_circumference" class="inf-label">Head Circumference <span class="inf-optional">Optional</span></label>
            <div class="inf-input-group">
                <input id="head_circumference" type="number" step="0.01" min="0" max="999.99" name="head_circumference" value="{{ $gmValue('head_circumference') }}" class="inf-input" placeholder="e.g. 40" inputmode="decimal">
                <span class="inf-suffix">cm</span>
            </div>
            @error('head_circumference') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<section class="inf-card" aria-labelledby="gm-remarks-title">
    <div class="inf-card-head" style="margin-bottom: 0.75rem;">
        <div class="inf-card-head-main">
            <div><h2 class="inf-card-title" id="gm-remarks-title">Remarks</h2></div>
        </div>
    </div>
    <div class="inf-field{{ $gmHas('remarks') }}">
        <label for="remarks" class="inf-label">Remarks <span class="inf-optional">Optional</span></label>
        <textarea id="remarks" name="remarks" rows="4" class="inf-input"
                  @unless ($growthMonitoring) maxlength="5000" @endunless
                  placeholder="Observations from this visit">{{ old('remarks', $growthMonitoring?->remarks) }}</textarea>
        @error('remarks') <p class="inf-error">{{ $message }}</p> @enderror
    </div>
</section>

<script>
    (function () {
        // Preview of GrowthMonitoring::completedMonths (the server value is authoritative).
        var input = document.querySelector('[data-gm-date]');
        var output = document.querySelector('[data-gm-age]');
        if (!input || !output) return;
        var kept = output.textContent;
        var parse = function (value) {
            var p = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value || '');
            return p ? new Date(Date.UTC(+p[1], +p[2] - 1, +p[3])) : null;
        };
        var addMonthsNoOverflow = function (date, months) {
            var y = date.getUTCFullYear(), m = date.getUTCMonth() + months;
            var target = new Date(Date.UTC(y, m, 1));
            var lastDay = new Date(Date.UTC(target.getUTCFullYear(), target.getUTCMonth() + 1, 0)).getUTCDate();
            target.setUTCDate(Math.min(date.getUTCDate(), lastDay));
            return target;
        };
        var update = function () {
            var birth = parse(input.getAttribute('data-birth'));
            var measured = parse(input.value);
            if (!birth || !measured) {
                output.textContent = input.value ? kept : 'Choose the measurement date';
                return;
            }
            if (measured < birth) {
                output.textContent = 'The date is before the birth date';
                return;
            }
            var months = (measured.getUTCFullYear() - birth.getUTCFullYear()) * 12 + (measured.getUTCMonth() - birth.getUTCMonth());
            if (addMonthsNoOverflow(birth, months) > measured) months--;
            months = Math.max(0, months);
            output.textContent = months + (months === 1 ? ' month' : ' months');
        };
        input.addEventListener('change', update);
        input.addEventListener('input', update);
    })();
</script>
