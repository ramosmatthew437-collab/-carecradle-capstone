{{--
    Infant vaccination fields, shared by vaccinations/create and
    vaccinations/edit. Expects $infant and $vaccination (null when adding).

    Vaccine and Dose are searchable comboboxes built on plain text inputs:
    - suggestions come from App\Models\Vaccination::SCHEDULE (approved
      vaccines, their standard doses and recommended ages);
    - a Midwife may type a custom vaccine name or custom dose label (BCG:
      Birth Dose only); custom values are labelled as such and never get a
      schedule or dose meaning;
    - the stored text is submitted exactly (the server trims and validates).
    Without JavaScript the inputs still work, with browser suggestions.
    Age guidance is informational only: dates are not restricted by it and
    Next Due Date is never calculated.
--}}
@php
    $VX = \App\Models\Vaccination::class;
    $vxVaccine = (string) old('vaccine_name', $vaccination?->vaccine_name);
    $vxDose = (string) old('dose', $vaccination?->dose);
    $vxSchedule = collect($VX::SCHEDULE)->map(fn ($entry) => [
        'doses' => collect($entry['doses'])->map(fn ($age, $dose) => ['value' => $dose, 'note' => $age])->values(),
        'custom' => $entry['custom_doses'],
    ]);
    $vxStoredVaccine = $vaccination ? (string) $vaccination->vaccine_name : '';
    $vxStoredDose = $vaccination ? (string) $vaccination->dose : '';

    $vxDate = function (string $field) use ($vaccination) {
        $value = old($field, $vaccination?->{$field});
        return filled($value) ? \Carbon\Carbon::parse($value)->format('Y-m-d') : '';
    };
    $vxHas = fn (string $field) => $errors->has($field) ? ' has-error' : '';
    $vxBirth = $infant->birth_date ? \Carbon\Carbon::parse($infant->birth_date)->toDateString() : null;

    // Initial status text (the script keeps it up to date while typing).
    $vxApproved = $VX::isApprovedVaccine($vxVaccine);
    $vxStandardDose = $VX::isStandardDose($vxVaccine, $vxDose);
@endphp

@once
    <style>
        .vxc-control {
            position: relative;
        }

        .vxc .inf-input {
            padding-right: 2.75rem;
        }

        .vxc-toggle {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            padding: 0;
            color: #64748b;
            background: transparent;
            border: 0;
            border-radius: 0.625rem;
            cursor: pointer;
        }

        .vxc-toggle:hover {
            color: #be185d;
            background: #fdf2f7;
        }

        .vxc-toggle svg {
            width: 1.125rem;
            height: 1.125rem;
            transition: transform 0.15s ease;
        }

        .vxc-toggle[aria-expanded="true"] svg {
            transform: rotate(180deg);
        }

        .vxc-list {
            position: absolute;
            z-index: 30;
            top: calc(100% + 0.375rem);
            left: 0;
            right: 0;
            max-height: 16rem;
            margin: 0;
            padding: 0.375rem;
            overflow-y: auto;
            list-style: none;
            background: #ffffff;
            border: 1px solid #f8d3e2;
            border-radius: 0.875rem;
            box-shadow: 0 12px 32px -12px rgba(15, 23, 42, 0.25);
        }

        .vxc-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            min-height: 44px;
            padding: 0.5rem 0.75rem;
            color: #1e293b;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .vxc-option.is-active {
            background: #fdf2f7;
            color: #9d174d;
        }

        .vxc-option[aria-selected="true"] {
            font-weight: 600;
        }

        .vxc-note {
            flex: 0 0 auto;
            color: #64748b;
            font-size: 0.75rem;
            white-space: nowrap;
        }

        .vxc-option-custom {
            color: #92400e;
        }

        .vxc-option + .vxc-option-custom {
            margin-top: 0.25rem;
            border-top: 1px dashed #f3cfe0;
            border-radius: 0 0 0.625rem 0.625rem;
        }

        .vxc-option-custom.is-active {
            background: #fffbeb;
            color: #92400e;
        }

        .vxc-empty {
            padding: 0.625rem 0.75rem;
            color: #64748b;
            font-size: 0.8125rem;
        }

        .vxc-status {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.375rem;
            min-height: 1.5rem;
            margin: 0.375rem 0 0;
            color: #64748b;
            font-size: 0.75rem;
            line-height: 1.45;
        }

        .vxc-schedule {
            margin: 0.75rem 0 0;
            padding: 0.75rem 0.875rem;
            background: #fdfafc;
            border: 1px solid #f6edf1;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
        }

        .vxc-schedule-title {
            margin: 0 0 0.375rem;
            color: #9d174d;
            font-weight: 600;
        }

        .vxc-schedule ol {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem 1rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .vxc-schedule li strong {
            color: #1e293b;
        }

        .vxc-schedule-note {
            margin: 0.5rem 0 0;
            color: #64748b;
            font-size: 0.75rem;
        }

        .vxc [hidden] {
            display: none !important;
        }
    </style>
@endonce

<section class="inf-card" aria-labelledby="vx-dose-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="vx-dose-title">Vaccine and Dose</h2>
                <p class="inf-card-sub">Search the approved list, or type a custom vaccine or dose when none matches.</p>
            </div>
        </div>
    </div>

    <div class="inf-grid vxc" data-vxc
         data-schedule='@json($vxSchedule)'
         data-stored-vaccine="{{ $vxStoredVaccine }}"
         data-stored-dose="{{ $vxStoredDose }}"
         data-schedule-note="{{ $VX::SCHEDULE_NOTE }}">

        {{-- Vaccine --}}
        <div class="inf-field{{ $vxHas('vaccine_name') }}">
            <label for="vaccine_name" class="inf-label">Vaccine <span class="inf-req">*</span></label>
            <div class="vxc-control">
                <input id="vaccine_name" name="vaccine_name" type="text" class="inf-input"
                       value="{{ $vxVaccine }}" list="vaccine_name_suggestions" autocomplete="off" spellcheck="false"
                       placeholder="Search or type a vaccine"
                       @unless ($vaccination && $vxVaccine === $vxStoredVaccine) maxlength="{{ $VX::VACCINE_MAX }}" @endunless
                       aria-describedby="vaccine_name_status" data-vxc-vaccine required>
                <button type="button" class="vxc-toggle" tabindex="-1" aria-label="Show vaccine options" hidden data-vxc-toggle>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <ul class="vxc-list" id="vaccine_name_listbox" role="listbox" aria-label="Vaccines" hidden></ul>
            </div>
            <datalist id="vaccine_name_suggestions">
                @foreach ($VX::vaccineNames() as $vxName)
                    <option value="{{ $vxName }}"></option>
                @endforeach
            </datalist>
            <p class="vxc-status" id="vaccine_name_status" aria-live="polite" data-vxc-vaccine-status>
                @if ($vxVaccine === '')
                    Approved: {{ implode(', ', $VX::vaccineNames()) }}.
                @elseif ($vxApproved)
                    <span class="inf-badge inf-badge-green">Approved vaccine</span>
                @else
                    <span class="inf-badge inf-badge-amber">Custom vaccine</span> Not in the approved schedule; no dose guidance applies.
                @endif
            </p>
            @error('vaccine_name') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        {{-- Dose --}}
        <div class="inf-field{{ $vxHas('dose') }}">
            <label for="dose" class="inf-label">Dose <span class="inf-req">*</span></label>
            <div class="vxc-control">
                <input id="dose" name="dose" type="text" class="inf-input"
                       value="{{ $vxDose }}" list="dose_suggestions" autocomplete="off" spellcheck="false"
                       placeholder="Search or type a dose"
                       @unless ($vaccination && $vxDose === $vxStoredDose) maxlength="{{ $VX::DOSE_MAX }}" @endunless
                       aria-describedby="dose_status dose_schedule" data-vxc-dose required>
                <button type="button" class="vxc-toggle" tabindex="-1" aria-label="Show dose options" hidden data-vxc-toggle>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <ul class="vxc-list" id="dose_listbox" role="listbox" aria-label="Doses" hidden></ul>
            </div>
            <datalist id="dose_suggestions">
                @foreach ($VX::dosesFor($vxVaccine) as $vxOption)
                    <option value="{{ $vxOption }}"></option>
                @endforeach
            </datalist>
            <p class="vxc-status" id="dose_status" aria-live="polite" data-vxc-dose-status>
                @if ($vxDose === '')
                    {{ $vxApproved ? 'Choose a standard dose, or type a custom label.' : 'Type the dose label.' }}
                @elseif ($vxStandardDose)
                    <span class="inf-badge inf-badge-green">Standard dose</span> Recommended {{ $VX::doseGuidance($vxVaccine)[$vxDose] }}.
                @else
                    <span class="inf-badge inf-badge-amber">Custom dose</span> Not part of the approved schedule.
                @endif
            </p>
            @error('dose') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        {{-- Recommended schedule for the selected vaccine (guidance only) --}}
        <div class="inf-span-all" id="dose_schedule" data-vxc-schedule>
            @if ($vxApproved)
                <div class="vxc-schedule">
                    <p class="vxc-schedule-title">Recommended schedule: {{ $vxVaccine }}</p>
                    <ol>
                        @foreach ($VX::doseGuidance($vxVaccine) as $vxScheduleDose => $vxAge)
                            <li><strong>{{ $vxScheduleDose }}</strong> {{ $vxAge }}</li>
                        @endforeach
                    </ol>
                    <p class="vxc-schedule-note">
                        {{ $VX::SCHEDULE_NOTE }} Guidance only: record the actual date given, including late or catch-up doses.
                        @unless ($VX::allowsCustomDose($vxVaccine)) {{ $vxVaccine }} is recorded as a Birth Dose only. @endunless
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="inf-card" aria-labelledby="vx-admin-title">
    <div class="inf-card-head">
        <div class="inf-card-head-main">
            <span class="inf-card-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
            </span>
            <div>
                <h2 class="inf-card-title" id="vx-admin-title">Administration</h2>
                <p class="inf-card-sub">When the dose was given and when the next one is due.</p>
            </div>
        </div>
    </div>

    <div class="inf-grid">
        <div class="inf-field{{ $vxHas('date_given') }}">
            <label for="date_given" class="inf-label">Date Given <span class="inf-req">*</span></label>
            <input id="date_given" type="date" name="date_given" value="{{ $vxDate('date_given') }}" class="inf-input"
                   @unless ($vaccination)
                       max="{{ today()->toDateString() }}" @if ($vxBirth) min="{{ $vxBirth }}" @endif
                   @endunless
                   required>
            <p class="inf-hint">Not in the future, and not before the birth date{{ $vxBirth ? ' (' . \Carbon\Carbon::parse($vxBirth)->format('M d, Y') . ')' : '' }}. Late doses can be recorded.</p>
            @error('date_given') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field{{ $vxHas('next_due_date') }}">
            <label for="next_due_date" class="inf-label">Next Due Date <span class="inf-optional">Optional</span></label>
            <input id="next_due_date" type="date" name="next_due_date" value="{{ $vxDate('next_due_date') }}" class="inf-input">
            <p class="inf-hint">Entered by the midwife; it is not calculated automatically. Leave blank if no further dose is scheduled.</p>
            @error('next_due_date') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field inf-span-all{{ $vxHas('administered_by') }}">
            <label for="administered_by" class="inf-label">Administered By <span class="inf-req">*</span></label>
            <input id="administered_by" type="text" name="administered_by" maxlength="255"
                   value="{{ old('administered_by', $vaccination?->administered_by) }}" class="inf-input"
                   placeholder="e.g. Midwife Maria Santos" required>
            @error('administered_by') <p class="inf-error">{{ $message }}</p> @enderror
        </div>

        <div class="inf-field inf-span-all{{ $vxHas('remarks') }}">
            <label for="remarks" class="inf-label">Remarks <span class="inf-optional">Optional</span></label>
            <textarea id="remarks" name="remarks" rows="3" class="inf-input"
                      @unless ($vaccination) maxlength="5000" @endunless
                      placeholder="e.g. reactions observed, catch-up dose, batch notes">{{ old('remarks', $vaccination?->remarks) }}</textarea>
            @error('remarks') <p class="inf-error">{{ $message }}</p> @enderror
        </div>
    </div>
</section>

<script>
    (function () {
        var root = document.querySelector('[data-vxc]');
        if (!root) return;

        var schedule = JSON.parse(root.getAttribute('data-schedule') || '{}');
        var scheduleNote = root.getAttribute('data-schedule-note') || '';
        var vaccineInput = root.querySelector('[data-vxc-vaccine]');
        var doseInput = root.querySelector('[data-vxc-dose]');
        var vaccineStatus = root.querySelector('[data-vxc-vaccine-status]');
        var doseStatus = root.querySelector('[data-vxc-dose-status]');
        var schedulePanel = root.querySelector('[data-vxc-schedule]');
        var doseList = document.getElementById('dose_suggestions');
        var norm = function (s) { return String(s || '').toLowerCase().replace(/\s+/g, ''); };
        var esc = function (s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; };
        var badge = function (cls, text) { return '<span class="inf-badge ' + cls + '">' + esc(text) + '</span> '; };
        var vaccineNames = Object.keys(schedule);

        var approvedVaccine = function (text) {
            return Object.prototype.hasOwnProperty.call(schedule, text) ? text : null;
        };
        var dosesOf = function (vaccine) {
            var entry = schedule[vaccine];
            return entry ? entry.doses : [];
        };
        var customDoseAllowed = function (vaccine) {
            var entry = schedule[vaccine];
            return !entry || !!entry.custom;
        };
        var standardDose = function (vaccine, dose) {
            return dosesOf(vaccine).filter(function (d) { return d.value === dose; })[0] || null;
        };

        // ---- Generic searchable combobox on a text input (custom text allowed) ----
        function Combo(input, options) {
            var control = input.parentNode;
            var list = control.querySelector('[role="listbox"]');
            var toggle = control.querySelector('[data-vxc-toggle]');
            var activeIndex = -1;
            var items = [];
            var self = this;

            input.removeAttribute('list');
            input.setAttribute('role', 'combobox');
            input.setAttribute('aria-autocomplete', 'list');
            input.setAttribute('aria-expanded', 'false');
            input.setAttribute('aria-controls', list.id);
            toggle.hidden = false;
            toggle.setAttribute('aria-controls', list.id);
            toggle.setAttribute('aria-expanded', 'false');

            function setExpanded(open) {
                list.hidden = !open;
                input.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (!open) {
                    activeIndex = -1;
                    input.removeAttribute('aria-activedescendant');
                }
            }

            function setActive(index) {
                items.forEach(function (li, i) { li.classList.toggle('is-active', i === index); });
                activeIndex = index;
                if (index >= 0 && items[index]) {
                    input.setAttribute('aria-activedescendant', items[index].id);
                    items[index].scrollIntoView({ block: 'nearest' });
                } else {
                    input.removeAttribute('aria-activedescendant');
                }
            }

            function build(showAll) {
                var text = input.value.trim();
                var all = options.choices();
                var shown = showAll || text === '' ? all : all.filter(function (c) { return norm(c.value).indexOf(norm(text)) !== -1; });
                var exact = all.some(function (c) { return norm(c.value) === norm(text); });
                list.innerHTML = '';
                items = [];

                shown.forEach(function (choice, i) {
                    var li = document.createElement('li');
                    li.id = list.id + '_opt_' + i;
                    li.className = 'vxc-option';
                    li.setAttribute('role', 'option');
                    li.setAttribute('aria-selected', choice.value === input.value ? 'true' : 'false');
                    li.dataset.value = choice.value;
                    li.innerHTML = '<span>' + esc(choice.value) + '</span>' + (choice.note ? '<span class="vxc-note">' + esc(choice.note) + '</span>' : '');
                    list.appendChild(li);
                    items.push(li);
                });

                if (text !== '' && !exact && options.allowCustom()) {
                    var custom = document.createElement('li');
                    custom.id = list.id + '_opt_custom';
                    custom.className = 'vxc-option vxc-option-custom';
                    custom.setAttribute('role', 'option');
                    custom.setAttribute('aria-selected', 'false');
                    custom.dataset.value = text;
                    custom.dataset.custom = '1';
                    custom.innerHTML = '<span>Use “' + esc(text) + '” as a custom ' + esc(options.noun) + '</span><span class="vxc-note">Custom</span>';
                    list.appendChild(custom);
                    items.push(custom);
                }

                if (!items.length) {
                    var empty = document.createElement('li');
                    empty.className = 'vxc-empty';
                    empty.setAttribute('role', 'presentation');
                    empty.textContent = options.emptyText();
                    list.appendChild(empty);
                }
            }

            this.open = function (showAll) { build(showAll); setExpanded(true); setActive(-1); };
            this.close = function () { setExpanded(false); };
            this.refresh = function () { if (!list.hidden) build(false); };

            function choose(value) {
                input.value = value;
                self.close();
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // On leaving the field, text that matches a suggestion except for
            // letter case or spacing becomes that suggestion; other text stays custom.
            function commit() {
                var text = input.value.trim();
                var match = options.choices().filter(function (c) { return norm(c.value) === norm(text); })[0];
                input.value = match ? match.value : text;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }

            input.addEventListener('focus', function () { self.open(true); });
            input.addEventListener('input', function () { self.open(false); options.onInput && options.onInput(); });
            input.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (list.hidden) { self.open(false); }
                    if (!items.length) return;
                    var next = e.key === 'ArrowDown' ? activeIndex + 1 : activeIndex - 1;
                    setActive((next + items.length) % items.length);
                } else if (e.key === 'Enter') {
                    if (!list.hidden && activeIndex >= 0) {
                        e.preventDefault();
                        choose(items[activeIndex].dataset.value);
                    } else if (!list.hidden) {
                        e.preventDefault();
                        self.close();
                        commit();
                    }
                } else if (e.key === 'Escape') {
                    if (!list.hidden) { e.preventDefault(); self.close(); }
                } else if (e.key === 'Tab') {
                    self.close();
                }
            });
            input.addEventListener('blur', function () {
                setTimeout(function () {
                    if (document.activeElement !== input) { self.close(); commit(); }
                }, 120);
            });
            list.addEventListener('mousedown', function (e) { e.preventDefault(); });
            list.addEventListener('click', function (e) {
                var li = e.target.closest('[role="option"]');
                if (li) choose(li.dataset.value);
            });
            toggle.addEventListener('mousedown', function (e) { e.preventDefault(); });
            toggle.addEventListener('click', function () {
                if (list.hidden) { input.focus(); self.open(true); } else { self.close(); }
            });
        }

        var vaccineCombo = new Combo(vaccineInput, {
            noun: 'vaccine',
            choices: function () { return vaccineNames.map(function (n) { return { value: n, note: '' }; }); },
            allowCustom: function () { return true; },
            emptyText: function () { return 'Type a vaccine name.'; }
        });

        var doseCombo = new Combo(doseInput, {
            noun: 'dose',
            choices: function () { return dosesOf(vaccineInput.value.trim()); },
            allowCustom: function () { return customDoseAllowed(vaccineInput.value.trim()); },
            emptyText: function () {
                var v = vaccineInput.value.trim();
                if (!v) return 'Choose the vaccine first, or type a dose label.';
                return approvedVaccine(v) ? 'Only ' + dosesOf(v).map(function (d) { return d.value; }).join(', ') + ' can be recorded for ' + v + '.' : 'Type the dose label for this custom vaccine.';
            }
        });

        function renderStatus() {
            var v = vaccineInput.value.trim();
            var d = doseInput.value.trim();
            var approved = approvedVaccine(v);

            if (!v) {
                vaccineStatus.innerHTML = 'Approved: ' + esc(vaccineNames.join(', ')) + '.';
            } else if (approved) {
                vaccineStatus.innerHTML = badge('inf-badge-green', 'Approved vaccine');
            } else {
                vaccineStatus.innerHTML = badge('inf-badge-amber', 'Custom vaccine') + 'Not in the approved schedule; no dose guidance applies.';
            }

            var std = approved ? standardDose(v, d) : null;
            if (!d) {
                doseStatus.textContent = approved
                    ? (customDoseAllowed(v) ? 'Choose a standard dose, or type a custom label.' : v + ' is recorded as a Birth Dose only.')
                    : 'Type the dose label.';
            } else if (std) {
                doseStatus.innerHTML = badge('inf-badge-green', 'Standard dose') + 'Recommended ' + esc(std.note) + '.';
            } else if (approved && !customDoseAllowed(v)) {
                doseStatus.innerHTML = badge('inf-badge-red', 'Not allowed') + esc(v + ' can only be recorded as: ' + dosesOf(v).map(function (x) { return x.value; }).join(', ') + '.');
            } else {
                doseStatus.innerHTML = badge('inf-badge-amber', 'Custom dose') + 'Not part of the approved schedule.';
            }

            if (approved) {
                schedulePanel.innerHTML = '<div class="vxc-schedule"><p class="vxc-schedule-title">Recommended schedule: ' + esc(v) + '</p><ol>'
                    + dosesOf(v).map(function (x) { return '<li><strong>' + esc(x.value) + '</strong> ' + esc(x.note) + '</li>'; }).join('')
                    + '</ol><p class="vxc-schedule-note">' + esc(scheduleNote) + ' Guidance only: record the actual date given, including late or catch-up doses.'
                    + (customDoseAllowed(v) ? '' : ' ' + esc(v) + ' is recorded as a Birth Dose only.') + '</p></div>';
            } else {
                schedulePanel.innerHTML = '';
            }

            doseList.innerHTML = dosesOf(v).map(function (x) { return '<option value="' + esc(x.value) + '"></option>'; }).join('');
        }

        // When the vaccine changes, keep a dose that still fits; a standard
        // dose of the previous vaccine that the new one does not have is cleared.
        var lastVaccine = vaccineInput.value.trim();
        vaccineInput.addEventListener('change', function () {
            var v = vaccineInput.value.trim();
            if (v !== lastVaccine) {
                var d = doseInput.value.trim();
                var wasStandard = !!standardDose(lastVaccine, d);
                if (approvedVaccine(v) && !customDoseAllowed(v)) {
                    doseInput.value = dosesOf(v).length === 1 ? dosesOf(v)[0].value : '';
                } else if (wasStandard && !standardDose(v, d)) {
                    doseInput.value = '';
                }
                lastVaccine = v;
            }
            renderStatus();
            doseCombo.refresh();
        });
        vaccineInput.addEventListener('input', renderStatus);
        doseInput.addEventListener('input', renderStatus);
        doseInput.addEventListener('change', renderStatus);
        renderStatus();
    })();
</script>
