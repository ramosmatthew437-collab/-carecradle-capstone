{{--
    Infant registration eligibility (panel requirement, approved Rule A).
    Included by infants/create when the mother has no prenatal checkup dated
    today or earlier.

    - Notice mode ($exceptionMode false): explains why registration is not
      available and offers Add Prenatal Visit or the authorized exception.
    - Exception mode ($exceptionMode true): exception fields inside the
      registration form. Nothing clinical is invented: the exception is saved
      as a structured block at the start of the infant's remarks and in the
      activity log (InfantController::store).

    Styles are inline and scoped to .irx so no Vite rebuild is needed.
--}}
@php
    $irxReasons = \App\Models\Infant::EXCEPTION_REASONS;
    $irxReason = (string) old('exception_reason');
@endphp

@once
    <style>
        .irx {
            border: 1px solid #fcd9a8;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            overflow: hidden;
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: #334155;
        }

        .irx-head {
            display: flex;
            gap: 0.875rem;
            align-items: flex-start;
            padding: 1.25rem 1.25rem 1rem;
            background: #fffbeb;
            border-bottom: 1px solid #fde7c2;
        }

        .irx-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            background: #fef3c7;
            color: #b45309;
        }

        .irx-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .irx-kicker {
            margin: 0;
            color: #b45309;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .irx-title {
            margin: 0.25rem 0 0;
            color: #0f172a;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.375rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .irx-text {
            margin: 0.375rem 0 0;
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .irx-body {
            display: grid;
            gap: 1.25rem;
            padding: 1.25rem;
        }

        .irx-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .irx-btn {
            display: inline-flex;
            gap: 0.5rem;
            align-items: center;
            justify-content: center;
            min-height: 2.75rem;
            padding: 0 1.125rem;
            border: 1px solid transparent;
            border-radius: 0.875rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.15s, border-color 0.15s;
        }

        .irx-btn svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .irx-btn-primary {
            background: #db2777;
            color: #fff;
        }

        .irx-btn-primary:hover {
            background: #be185d;
        }

        .irx-btn-secondary {
            border-color: #f8d3e2;
            background: #fff;
            color: #be185d;
        }

        .irx-btn-secondary:hover {
            border-color: #f0abc9;
            background: #fdf2f7;
        }

        .irx-btn:focus-visible,
        .irx-link:focus-visible,
        .irx-option input:focus-visible,
        .irx-check input:focus-visible {
            outline: 3px solid #fbcfe8;
            outline-offset: 2px;
        }

        .irx-link {
            color: #be185d;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .irx-foot,
        .irx-help {
            margin: 0;
            color: #64748b;
            font-size: 0.8125rem;
            line-height: 1.55;
        }

        .irx-fieldset {
            margin: 0;
            padding: 0;
            border: 0;
            min-width: 0;
        }

        .irx-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .irx-req {
            color: #db2777;
        }

        .irx-options {
            display: grid;
            gap: 0.625rem;
        }

        @media (min-width: 768px) {
            .irx-options {
                grid-template-columns: 1fr 1fr;
            }
        }

        .irx-option {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            padding: 0.875rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.875rem;
            background: #fff;
            cursor: pointer;
            font-size: 0.875rem;
            line-height: 1.45;
        }

        .irx-option:has(input:checked) {
            border-color: #f0abc9;
            background: #fdf2f7;
        }

        .irx-option input,
        .irx-check input {
            flex: 0 0 auto;
            width: 1.125rem;
            height: 1.125rem;
            margin-top: 0.125rem;
            accent-color: #db2777;
        }

        .irx-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.875rem;
            background: #fff;
            color: #1f2937;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .irx-input:focus {
            border-color: #ec4899;
            outline: none;
            box-shadow: 0 0 0 4px #fce7f3;
        }

        .irx-check {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            padding: 0.875rem 1rem;
            border: 1px solid #f8d3e2;
            border-radius: 0.875rem;
            background: #fdf2f7;
            font-size: 0.875rem;
            line-height: 1.5;
            cursor: pointer;
        }

        .irx-error {
            margin: 0.375rem 0 0;
            color: #dc2626;
            font-size: 0.8125rem;
        }

        .irx-alert {
            margin: 0;
            padding: 0.75rem 1rem;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 0.875rem;
        }

        .irx [hidden] {
            display: none !important;
        }

        @media (max-width: 639px) {
            .irx-actions .irx-btn {
                width: 100%;
            }
        }
    </style>
@endonce

<section class="irx" aria-labelledby="irx-title">
    <div class="irx-head">
        <span class="irx-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
            </svg>
        </span>
        <div>
            <p class="irx-kicker">Prenatal history required</p>
            <h2 id="irx-title" class="irx-title">
                {{ $exceptionMode ? 'Authorized Registration Exception' : 'Infant Registration Is Not Yet Available' }}
            </h2>
            <p class="irx-text">
                This mother has no prenatal checkup recorded in CareCradle with a visit date of today or earlier.
                Infant registration requires recorded prenatal history. Scheduled or completed appointments do not count.
            </p>
        </div>
    </div>

    <div class="irx-body">
        @if (! $exceptionMode)
            @error('exception_reason')
                <p class="irx-alert" role="alert">The infant was not registered. {{ $message }}</p>
            @enderror

            <div class="irx-actions">
                <a href="{{ route('prenatal-checkups.create', $mother) }}" class="irx-btn irx-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Add Prenatal Visit
                </a>
                <a href="{{ route('infants.create', ['mother' => $mother, 'exception' => 1]) }}" class="irx-btn irx-btn-secondary">
                    Register with an Authorized Exception
                </a>
                <a href="{{ route('mothers.show', $mother) }}" class="irx-link">Back to Mother Profile</a>
            </div>

            <p class="irx-foot">
                Use an exception only when the mother received prenatal care at another healthcare facility,
                or for a walk-in or emergency delivery.
            </p>
        @else
            <input type="hidden" name="exception_mode" value="1">

            <fieldset class="irx-fieldset">
                <legend class="irx-label">Reason for the exception <span class="irx-req">*</span></legend>
                <div class="irx-options">
                    @foreach ($irxReasons as $irxKey => $irxLabel)
                        <label class="irx-option">
                            <input type="radio" name="exception_reason" value="{{ $irxKey }}" required
                                   data-irx-reason @checked($irxReason === $irxKey)>
                            <span>{{ $irxLabel }}</span>
                        </label>
                    @endforeach
                </div>
                @error('exception_reason')
                    <p class="irx-error">{{ $message }}</p>
                @enderror
            </fieldset>

            <div data-irx-facility @if ($irxReason !== 'other_facility') hidden @endif>
                <label for="exception_facility" class="irx-label">
                    Healthcare facility <span class="irx-req">*</span>
                </label>
                <input type="text" id="exception_facility" name="exception_facility" maxlength="255"
                       value="{{ old('exception_facility') }}" class="irx-input"
                       placeholder="e.g. name of the hospital or clinic"
                       @if ($irxReason === 'other_facility') required @endif>
                <p class="irx-help">Where the mother received her prenatal care.</p>
                @error('exception_facility')
                    <p class="irx-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="exception_notes" class="irx-label">
                    Supporting notes <span class="irx-req">*</span>
                </label>
                <textarea id="exception_notes" name="exception_notes" rows="3" required minlength="10" maxlength="1000"
                          class="irx-input"
                          placeholder="e.g. documents seen, circumstances of the delivery">{{ old('exception_notes') }}</textarea>
                <p class="irx-help">
                    Do not enter prenatal measurements here. Record prenatal visits in Add Prenatal Visit.
                </p>
                @error('exception_notes')
                    <p class="irx-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="irx-check">
                    <input type="checkbox" name="exception_confirm" value="1" required @checked(old('exception_confirm'))>
                    <span>
                        I am authorizing this registration exception. It will be recorded with my name in the
                        infant's record and in the activity log.
                    </span>
                </label>
                @error('exception_confirm')
                    <p class="irx-error">{{ $message }}</p>
                @enderror
            </div>

            <p class="irx-foot">
                Prefer to record the prenatal visit instead?
                <a href="{{ route('prenatal-checkups.create', $mother) }}" class="irx-link">Add Prenatal Visit</a>
            </p>

            <script>
                (function () {
                    var box = document.querySelector('[data-irx-facility]');
                    if (!box) return;
                    var input = box.querySelector('input');
                    var sync = function () {
                        var picked = document.querySelector('[data-irx-reason]:checked');
                        var needed = !!picked && picked.value === 'other_facility';
                        box.hidden = !needed;
                        input.required = needed;
                    };
                    document.querySelectorAll('[data-irx-reason]').forEach(function (radio) {
                        radio.addEventListener('change', sync);
                    });
                    sync();
                })();
            </script>
        @endif
    </div>
</section>
