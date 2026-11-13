{{--
    Vaccine Name + Dose fields for the maternal vaccination create/edit forms.
    Expects $mother and $vaccination (null when creating).

    Options come from App\Models\MaternalVaccination. Each field is a real
    <select>, so only listed values can be submitted even without JavaScript;
    the script turns each select into a searchable combobox.

    Shared series (RHU-confirmed): Td and TT use ONE dose sequence. For Td/TT
    the Dose field offers only the mother's next eligible dose (plus, when
    editing, the record's own current dose). The server enforces the same rule.
    Legacy values are kept as selected "(no longer offered)" options.
--}}
@php
    $MV = \App\Models\MaternalVaccination::class;
    $mvExclude = $vaccination?->id;
    $mvEligible = $MV::nextEligibleDose($mother->id, $mvExclude);
    $mvSeriesCount = $MV::seriesRecords($mother->id, $mvExclude)->count();
    $mvOtherCount = $mother->maternalVaccinations()
        ->when($mvExclude, fn ($query) => $query->whereKeyNot($mvExclude))
        ->get(['id', 'vaccine_name', 'dose'])
        ->reject(fn ($record) => $record->isSeriesRecord())
        ->count();
    $mvWasSeries = $vaccination?->isSeriesRecord() ?? false;
    $mvStoredVaccine = $vaccination?->vaccine_name;
    $mvStoredDose = $vaccination?->dose;
    $mvLegacyVaccine = filled($mvStoredVaccine) && ! in_array($mvStoredVaccine, $MV::VACCINES, true) ? $mvStoredVaccine : null;
    $mvLegacyDose = filled($mvStoredDose) && ! in_array($mvStoredDose, $MV::DOSES, true) ? $mvStoredDose : null;

    $mvSelVaccine = (string) old('vaccine_name', $mvStoredVaccine);
    $mvSelDose = (string) old('dose', $mvStoredDose);

    // Dose options for a vaccine: [value => note]. Mirrors the server rule.
    $mvDoseOptions = function (string $vaccine) use ($MV, $mvEligible, $mvWasSeries, $mvStoredDose, $mvLegacyDose) {
        if ($vaccine === '' || in_array($vaccine, $MV::VACCINES, true)) {
            $options = $mvEligible ? [$mvEligible => 'Next in series'] : [];
            if ($mvWasSeries && ! isset($options[$mvStoredDose])) {
                $options[$mvStoredDose] = 'Current record';
            }
            return $options;
        }

        $options = array_fill_keys($MV::DOSES, '');
        if ($mvLegacyDose !== null) {
            $options[$mvLegacyDose] = 'No longer offered';
        }
        return $options;
    };

    $mvInitialDoses = $mvDoseOptions($mvSelVaccine);
    // A new Td/TT record starts with the single eligible dose selected.
    if ($mvSelDose === '' && count($mvInitialDoses) === 1 && $mvEligible && isset($mvInitialDoses[$mvEligible])) {
        $mvSelDose = $mvEligible;
    }

    $mvSeriesText = $mvEligible
        ? "Td and TT share one five-dose series that continues across pregnancies. Next dose for this mother: {$mvEligible} ({$mvSeriesCount} Td/TT " . \Illuminate\Support\Str::plural('dose', $mvSeriesCount) . ' recorded' . ($vaccination ? ' besides this one' : '') . ').'
        : 'The five-dose Td/TT series is complete. Dose 5 is already recorded, so no further Td or TT dose can be added.';
    $mvLegacyText = 'This record keeps its original vaccine name, so it is not counted in the Td/TT series.';
    $mvIsSeriesSelection = $mvSelVaccine === '' || in_array($mvSelVaccine, $MV::VACCINES, true);
@endphp

{{-- Vaccine --}}
<div>
    <label for="vaccine_name" class="mb-2 block text-sm font-semibold text-gray-700">
        Vaccine Name <span class="text-pink-600">*</span>
    </label>

    <div class="mv-combo" data-mv-combo data-search-placeholder="Search vaccines">
        <select id="vaccine_name" name="vaccine_name" required aria-describedby="vaccine_name_help"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
            <option value="">Select vaccine</option>
            @foreach ($MV::VACCINES as $mvOption)
                @php $mvNote = $MV::VACCINE_NOTES[$mvOption] ?? null; @endphp
                <option value="{{ $mvOption }}" @if ($mvNote) data-note="{{ $mvNote }}" @endif
                        @selected($mvSelVaccine === $mvOption)>{{ $mvOption }}@if ($mvNote) — {{ lcfirst($mvNote) }}@endif</option>
            @endforeach
            @if ($mvLegacyVaccine !== null)
                <option value="{{ $mvLegacyVaccine }}" data-note="No longer offered" @selected($mvSelVaccine === $mvLegacyVaccine)>{{ $mvLegacyVaccine }} (no longer offered)</option>
            @endif
        </select>
    </div>

    <p id="vaccine_name_help" class="mv-help">TT is available only when the vaccine is in stock.</p>

    @if ($mvLegacyVaccine !== null)
        <p class="mv-help mv-legacy-note">This record was saved as “{{ $mvLegacyVaccine }}”. It is kept unless you choose an approved option.</p>
    @endif

    @error('vaccine_name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- Dose (shared Td/TT series) --}}
<div>
    <label for="dose" class="mb-2 block text-sm font-semibold text-gray-700">
        Dose <span class="text-pink-600">*</span>
    </label>

    <div class="mv-combo" data-mv-combo data-search-placeholder="Search doses"
         data-mv-series
         data-series-vaccines='@json($MV::VACCINES)'
         data-doses='@json($MV::DOSES)'
         data-eligible="{{ $mvEligible ?? '' }}"
         data-was-series="{{ $mvWasSeries ? '1' : '0' }}"
         data-stored-dose="{{ $mvStoredDose ?? '' }}"
         data-legacy-dose="{{ $mvLegacyDose ?? '' }}">
        <select id="dose" name="dose" required aria-describedby="dose_series_status"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
            <option value="">Select dose</option>
            @foreach ($mvInitialDoses as $mvOption => $mvNote)
                <option value="{{ $mvOption }}" @if ($mvNote) data-note="{{ $mvNote }}" @endif
                        @selected($mvSelDose === $mvOption)>{{ $mvOption }}@if ($mvNote === 'Current record') (current)@elseif ($mvNote === 'No longer offered') (no longer offered)@endif</option>
            @endforeach
        </select>
    </div>

    <p id="dose_series_status" class="mv-help mv-series-status" aria-live="polite">
        <span data-mv-series-text @unless ($mvIsSeriesSelection) hidden @endunless>{{ $mvSeriesText }}</span>
        <span data-mv-legacy-text @if ($mvIsSeriesSelection) hidden @endif>{{ $mvLegacyText }}</span>
    </p>

    @if ($mvOtherCount > 0)
        <p class="mv-help">
            {{ $mvOtherCount }} earlier {{ \Illuminate\Support\Str::plural('record', $mvOtherCount) }} with another vaccine name or dose label
            {{ $mvOtherCount === 1 ? 'is' : 'are' }} not counted in the series.
        </p>
    @endif

    @error('dose')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@once
    <style>
        .mv-combo {
            position: relative;
        }

        .mv-combo-input {
            width: 100%;
            min-height: 2.875rem;
            padding: 0.75rem 2.75rem 0.75rem 1rem;
            color: #111827;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font: inherit;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .mv-combo-input::placeholder {
            color: #9ca3af;
        }

        .mv-combo-input:focus {
            border-color: #f472b6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.14);
        }

        .mv-combo-toggle {
            position: absolute;
            top: 1.4375rem;
            right: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            color: #9ca3af;
            background: transparent;
            border: 0;
            border-radius: 0.625rem;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .mv-combo-toggle:hover {
            color: #be185d;
            background: #fdf2f8;
        }

        .mv-combo-toggle svg {
            width: 1rem;
            height: 1rem;
            transition: transform 0.15s ease;
        }

        .mv-combo.is-open .mv-combo-toggle svg {
            transform: rotate(180deg);
        }

        .mv-combo-list {
            position: absolute;
            top: calc(100% + 0.375rem);
            left: 0;
            right: 0;
            z-index: 40;
            max-height: 15rem;
            margin: 0;
            padding: 0.375rem;
            overflow-y: auto;
            list-style: none;
            background: #ffffff;
            border: 1px solid #fbcfe8;
            border-radius: 1rem;
            box-shadow: 0 12px 32px -8px rgba(157, 23, 77, 0.18), 0 2px 6px rgba(15, 23, 42, 0.06);
        }

        .mv-combo-option {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            justify-content: space-between;
            gap: 0.125rem 0.75rem;
            padding: 0.5625rem 0.75rem;
            color: #1f2937;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .mv-combo-option:hover {
            background: #fdf2f8;
        }

        .mv-combo-option.is-active {
            color: #9d174d;
            background: #fce7f3;
        }

        .mv-combo-option[aria-selected="true"] {
            font-weight: 600;
        }

        .mv-combo-note {
            color: #92400e;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .mv-combo-option.is-muted .mv-combo-note {
            color: #6b7280;
        }

        .mv-combo-empty {
            padding: 0.625rem 0.75rem;
            color: #6b7280;
            font-size: 0.8125rem;
            line-height: 1.45;
        }

        .mv-help {
            margin: 0.375rem 0 0;
            color: #6b7280;
            font-size: 0.75rem;
            line-height: 1.45;
        }

        .mv-series-status {
            color: #374151;
        }

        .mv-legacy-note {
            color: #92400e;
        }

        .mv-sr {
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .mv-combo-list[hidden],
        .mv-combo-option[hidden],
        .mv-combo-empty[hidden],
        .mv-series-status [hidden] {
            display: none;
        }
    </style>

    <script>
        (() => {
            // ---- Shared Td/TT series: rebuild Dose options when the vaccine changes ----
            const seriesBox = document.querySelector('[data-mv-series]');
            const vaccineSelect = document.getElementById('vaccine_name');
            const doseSelect = document.getElementById('dose');

            if (seriesBox && vaccineSelect && doseSelect) {
                const seriesVaccines = JSON.parse(seriesBox.dataset.seriesVaccines || '[]');
                const allDoses = JSON.parse(seriesBox.dataset.doses || '[]');
                const eligible = seriesBox.dataset.eligible || '';
                const wasSeries = seriesBox.dataset.wasSeries === '1';
                const storedDose = seriesBox.dataset.storedDose || '';
                const legacyDose = seriesBox.dataset.legacyDose || '';
                const seriesText = document.querySelector('[data-mv-series-text]');
                const legacyText = document.querySelector('[data-mv-legacy-text]');

                const optionsFor = (vaccine) => {
                    if (vaccine === '' || seriesVaccines.includes(vaccine)) {
                        const options = eligible ? [[eligible, 'Next in series']] : [];
                        if (wasSeries && storedDose && storedDose !== eligible) options.push([storedDose, 'Current record']);
                        return options;
                    }
                    const options = allDoses.map((dose) => [dose, '']);
                    if (legacyDose) options.push([legacyDose, 'No longer offered']);
                    return options;
                };

                const rebuild = () => {
                    const vaccine = vaccineSelect.value;
                    const previous = doseSelect.value;
                    const options = optionsFor(vaccine);

                    Array.from(doseSelect.options).forEach((o) => { if (o.value !== '') o.remove(); });
                    options.forEach(([value, note]) => {
                        const option = new Option(value + (note === 'Current record' ? ' (current)' : note === 'No longer offered' ? ' (no longer offered)' : ''), value);
                        if (note) option.dataset.note = note;
                        doseSelect.add(option);
                    });

                    const values = options.map(([value]) => value);
                    if (values.includes(previous)) {
                        doseSelect.value = previous;
                    } else if (options.length === 1 && options[0][1] === 'Next in series') {
                        doseSelect.value = options[0][0]; // the only eligible dose
                    } else {
                        doseSelect.value = '';
                    }

                    const isSeries = vaccine === '' || seriesVaccines.includes(vaccine);
                    if (seriesText) seriesText.hidden = !isSeries;
                    if (legacyText) legacyText.hidden = isSeries;

                    doseSelect.dispatchEvent(new Event('mv:refresh'));
                };

                vaccineSelect.addEventListener('change', rebuild);
            }

            // ---- Select-only searchable combobox ----
            const norm = (v) => String(v || '').normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/\s+/g, ' ').trim().toLowerCase();

            document.querySelectorAll('[data-mv-combo]').forEach((combo) => {
                const select = combo.querySelector('select');
                if (!select) return;

                const fieldId = select.id;
                const label = document.querySelector('label[for="' + fieldId + '"]');

                const input = document.createElement('input');
                input.type = 'text';
                input.id = fieldId + '_combo';
                input.className = 'mv-combo-input';
                input.setAttribute('role', 'combobox');
                input.setAttribute('aria-autocomplete', 'list');
                input.setAttribute('aria-expanded', 'false');
                input.setAttribute('aria-controls', fieldId + '_listbox');
                input.setAttribute('aria-required', 'true');
                input.setAttribute('autocomplete', 'off');
                input.placeholder = combo.dataset.searchPlaceholder || 'Search';
                if (select.getAttribute('aria-describedby')) input.setAttribute('aria-describedby', select.getAttribute('aria-describedby'));

                const toggle = document.createElement('button');
                toggle.type = 'button';
                toggle.className = 'mv-combo-toggle';
                toggle.tabIndex = -1;
                toggle.setAttribute('aria-label', 'Show options');
                toggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>';

                const list = document.createElement('ul');
                list.id = fieldId + '_listbox';
                list.className = 'mv-combo-list';
                list.setAttribute('role', 'listbox');
                if (label) list.setAttribute('aria-label', label.textContent.replace('*', '').trim());
                list.hidden = true;

                const empty = document.createElement('li');
                empty.className = 'mv-combo-empty';
                empty.setAttribute('role', 'presentation');

                select.classList.add('mv-sr');
                select.tabIndex = -1;
                select.setAttribute('aria-hidden', 'true');
                select.required = false; // the server still requires a value
                combo.append(input, toggle, list);
                if (label) label.htmlFor = input.id;

                let choices = [];
                let optionEls = [];
                let active = -1;

                // (Re)build the list from the select's current options.
                const refresh = () => {
                    choices = Array.from(select.options).filter((o) => o.value !== '').map((o) => ({ value: o.value, note: o.dataset.note || '' }));
                    list.innerHTML = '';
                    optionEls = choices.map((choice, i) => {
                        const li = document.createElement('li');
                        li.id = fieldId + '_opt_' + i;
                        li.className = 'mv-combo-option' + (choice.note === 'No longer offered' || choice.note === 'Current record' ? ' is-muted' : '');
                        li.setAttribute('role', 'option');
                        li.setAttribute('aria-selected', 'false');
                        li.dataset.value = choice.value;
                        const text = document.createElement('span');
                        text.textContent = choice.value;
                        li.appendChild(text);
                        if (choice.note) {
                            const note = document.createElement('span');
                            note.className = 'mv-combo-note';
                            note.textContent = choice.note;
                            li.appendChild(note);
                        }
                        list.appendChild(li);
                        return li;
                    });
                    empty.textContent = choices.length
                        ? 'No matching option. Choose one from the list.'
                        : 'No dose is available: the five-dose Td/TT series is complete.';
                    empty.hidden = choices.length !== 0;
                    list.appendChild(empty);
                    input.value = select.value;
                };

                const visible = () => optionEls.filter((li) => !li.hidden);

                const setActive = (li) => {
                    optionEls.forEach((o) => o.classList.remove('is-active'));
                    if (li) {
                        li.classList.add('is-active');
                        input.setAttribute('aria-activedescendant', li.id);
                        li.scrollIntoView({ block: 'nearest' });
                    } else {
                        input.removeAttribute('aria-activedescendant');
                    }
                };

                const filter = (query) => {
                    const q = norm(query);
                    let shown = 0;
                    optionEls.forEach((li) => {
                        const match = q === '' || norm(li.textContent).includes(q);
                        li.hidden = !match;
                        li.setAttribute('aria-selected', String(li.dataset.value === select.value));
                        if (match) shown++;
                    });
                    empty.hidden = shown !== 0;
                    if (!choices.length) empty.hidden = false;
                };

                const open = () => {
                    list.hidden = false;
                    combo.classList.add('is-open');
                    input.setAttribute('aria-expanded', 'true');
                };

                const close = () => {
                    list.hidden = true;
                    combo.classList.remove('is-open');
                    input.setAttribute('aria-expanded', 'false');
                    active = -1;
                    setActive(null);
                };

                const choose = (value) => {
                    select.value = value;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    input.value = select.value;
                    close();
                };

                // Leaving the field: an exact match is selected, a cleared field
                // clears the selection, anything else reverts (no free text).
                const commit = () => {
                    const typed = norm(input.value);
                    const before = select.value;
                    if (typed === '') {
                        select.value = '';
                    } else {
                        const match = choices.find((c) => norm(c.value) === typed);
                        if (match) select.value = match.value;
                    }
                    if (select.value !== before) select.dispatchEvent(new Event('change', { bubbles: true }));
                    input.value = select.value;
                    close();
                };

                const move = (step) => {
                    const shown = visible();
                    if (!shown.length) return;
                    active = (active + step + shown.length) % shown.length;
                    setActive(shown[active]);
                };

                select.addEventListener('mv:refresh', refresh);
                refresh();

                input.addEventListener('focus', () => { filter(''); open(); input.select(); });
                input.addEventListener('click', () => { filter(''); open(); });
                input.addEventListener('input', () => { filter(input.value); active = -1; setActive(null); open(); });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') { e.preventDefault(); if (list.hidden) { filter(''); open(); } move(1); }
                    else if (e.key === 'ArrowUp') { e.preventDefault(); if (list.hidden) { filter(''); open(); } move(-1); }
                    else if (e.key === 'Enter') {
                        const shown = visible();
                        if (!list.hidden && active >= 0 && shown[active]) { e.preventDefault(); choose(shown[active].dataset.value); }
                        else if (!list.hidden && shown.length === 1) { e.preventDefault(); choose(shown[0].dataset.value); }
                        else if (!list.hidden) { e.preventDefault(); commit(); }
                    }
                    else if (e.key === 'Escape') { if (!list.hidden) { e.preventDefault(); input.value = select.value; close(); } }
                    else if (e.key === 'Tab') { commit(); }
                });
                input.addEventListener('blur', () => { setTimeout(() => { if (document.activeElement !== input) commit(); }, 120); });

                list.addEventListener('mousedown', (e) => e.preventDefault());
                list.addEventListener('click', (e) => {
                    const li = e.target.closest('[role="option"]');
                    if (li) choose(li.dataset.value);
                });
                toggle.addEventListener('mousedown', (e) => e.preventDefault());
                toggle.addEventListener('click', () => {
                    if (list.hidden) { filter(''); open(); input.focus(); } else { close(); }
                });
            });
        })();
    </script>
@endonce
