{{-- Referral detail fields. Expects $referral (or null). --}}
@php
    /*
     * Receiving-facility suggestions shown while typing.
     * Intentionally EMPTY until the Irosin RHU confirms its official referral
     * facilities. Add one exact facility name per entry, e.g. 'Facility name'.
     * Suggestions only help with typing: any facility name can still be entered
     * and is saved exactly as typed (validation: required, text, max 255).
     */
    $mrfFacilities = [];

    $mrfFacilities = collect($mrfFacilities)
        ->map(fn ($name) => trim((string) $name))
        ->filter()
        ->unique(fn ($name) => mb_strtolower($name))
        ->sort(fn ($a, $b) => strnatcasecmp($a, $b)) // natural, case-insensitive (A2 before A10)
        ->values()
        ->all();
@endphp
<div class="mrf-grid">
    <div class="mrf-field">
        <label class="mrf-label" for="mrf-referred-at">Referral date <span class="mrf-req">*</span></label>
        <input id="mrf-referred-at" type="date" name="referred_at" class="mrf-input" max="{{ today()->toDateString() }}" required
            value="{{ old('referred_at', $referral?->referred_at?->toDateString()) }}">
        @error('referred_at')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field">
        <label class="mrf-label" for="mrf-facility">Receiving facility <span class="mrf-req">*</span></label>
        {{-- Works as a normal text field without JavaScript; the script below
             turns it into a searchable combo box (suggestions + free typing). --}}
        <div class="mrf-combo" data-mrf-combo data-facilities="{{ json_encode($mrfFacilities) }}">
            <input id="mrf-facility" type="text" name="receiving_facility" class="mrf-input" maxlength="255" required
                value="{{ old('receiving_facility', $referral?->receiving_facility) }}" placeholder="e.g. Provincial hospital"
                aria-describedby="mrf-facility-help">
        </div>
        <p id="mrf-facility-help" class="mrf-hint">Type the full name of the receiving hospital or health facility.</p>
        @error('receiving_facility')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field mrf-full">
        <label class="mrf-label" for="mrf-reason">Reason for referral <span class="mrf-req">*</span></label>
        <textarea id="mrf-reason" name="reason" class="mrf-textarea" maxlength="1000" required>{{ old('reason', $referral?->reason) }}</textarea>
        @error('reason')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
    <div class="mrf-field mrf-full">
        <label class="mrf-label" for="mrf-notes">Notes</label>
        <textarea id="mrf-notes" name="notes" class="mrf-textarea" maxlength="2000">{{ old('notes', $referral?->notes) }}</textarea>
        @error('notes')<p class="mrf-error">{{ $message }}</p>@enderror
    </div>
</div>
<p class="mrf-hint" style="margin-top:0.75rem">The referring health worker is recorded automatically as the signed-in staff member.</p>

@once
<script>
    /*
     * Receiving-facility combo box (progressive enhancement).
     * - Never changes the field's name, value handling or validation: the typed
     *   text is what is submitted, unless a suggestion is explicitly chosen.
     * - ARIA combobox/listbox roles are added only here, so without JavaScript
     *   the field stays a plain, correctly announced text input.
     */
    (function () {
        var normalize = function (value) {
            return String(value || '')
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/\s+/g, ' ').trim().toLowerCase();
        };

        document.querySelectorAll('[data-mrf-combo]').forEach(function (combo) {
            var input = combo.querySelector('input');
            if (!input || combo.dataset.mrfReady) { return; }
            combo.dataset.mrfReady = '1';

            var facilities = [];
            try { facilities = JSON.parse(combo.dataset.facilities || '[]') || []; } catch (e) { facilities = []; }
            var hasSuggestions = facilities.length > 0;
            var listId = input.id + '-listbox';
            var activeIndex = -1;

            // --- Build the listbox, empty message and toggle ---------------------
            var list = document.createElement('ul');
            list.id = listId;
            list.className = 'mrf-combo-list';
            list.setAttribute('role', 'listbox');
            list.setAttribute('aria-label', 'Receiving facility suggestions');
            list.hidden = true;

            var options = facilities.map(function (name, index) {
                var li = document.createElement('li');
                li.id = input.id + '-option-' + index;
                li.className = 'mrf-combo-option';
                li.setAttribute('role', 'option');
                li.setAttribute('aria-selected', 'false');
                li.dataset.value = name;
                li.textContent = name;
                list.appendChild(li);
                return li;
            });

            var empty = document.createElement('li');
            empty.className = 'mrf-combo-empty';
            empty.setAttribute('role', 'presentation');
            empty.textContent = hasSuggestions
                ? 'No matching facility found. You can type the full facility name — it will be saved as entered.'
                : 'No facility suggestions yet. Type the full facility name — it will be saved as entered.';
            empty.hidden = true;
            list.appendChild(empty);

            // Polite live region so screen readers hear how many suggestions match.
            var status = document.createElement('p');
            status.className = 'mrf-sr-only';
            status.setAttribute('role', 'status');
            status.setAttribute('aria-live', 'polite');

            combo.appendChild(list);
            combo.appendChild(status);

            var toggle = null;
            if (hasSuggestions) {
                toggle = document.createElement('button');
                toggle.type = 'button';
                toggle.className = 'mrf-combo-toggle';
                toggle.tabIndex = -1;
                toggle.setAttribute('aria-label', 'Show facility suggestions');
                toggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>';
                combo.appendChild(toggle);
                combo.classList.add('has-toggle');
            }

            input.setAttribute('role', 'combobox');
            input.setAttribute('aria-autocomplete', 'list');
            input.setAttribute('aria-expanded', 'false');
            input.setAttribute('aria-controls', listId);
            input.setAttribute('autocomplete', 'off');
            combo.classList.add('is-enhanced');

            // --- Behaviour --------------------------------------------------------
            var visibleOptions = function () {
                return options.filter(function (option) { return !option.hidden; });
            };

            var setActive = function (option) {
                options.forEach(function (o) {
                    o.classList.remove('is-active');
                    o.setAttribute('aria-selected', 'false');
                });
                if (option) {
                    option.classList.add('is-active');
                    option.setAttribute('aria-selected', 'true');
                    input.setAttribute('aria-activedescendant', option.id);
                    option.scrollIntoView({ block: 'nearest' });
                } else {
                    input.removeAttribute('aria-activedescendant');
                }
            };

            var filter = function (query) {
                var q = normalize(query);
                var current = normalize(input.value);
                var shown = 0;
                options.forEach(function (option) {
                    var value = normalize(option.dataset.value);
                    var match = q === '' || value.indexOf(q) !== -1;
                    option.hidden = !match;
                    option.classList.toggle('is-current', value === current);
                    if (match) { shown++; }
                });
                empty.hidden = shown !== 0;
                status.textContent = shown === 0
                    ? 'No matching facility. Your entry will be saved as typed.'
                    : shown + (shown === 1 ? ' suggestion' : ' suggestions') + ' available.';
                return shown;
            };

            var open = function () {
                if (!list.hidden) { return; }
                list.hidden = false;
                combo.classList.add('is-open');
                input.setAttribute('aria-expanded', 'true');
            };

            var close = function () {
                if (list.hidden) { return; }
                list.hidden = true;
                combo.classList.remove('is-open');
                input.setAttribute('aria-expanded', 'false');
                activeIndex = -1;
                setActive(null);
            };

            var choose = function (option) {
                input.value = option.dataset.value;
                close();
                input.dispatchEvent(new Event('change', { bubbles: true }));
            };

            var move = function (step) {
                var shown = visibleOptions();
                if (!shown.length) { setActive(null); return; }
                activeIndex += step;
                if (activeIndex < 0) { activeIndex = shown.length - 1; }
                if (activeIndex >= shown.length) { activeIndex = 0; }
                setActive(shown[activeIndex]);
            };

            input.addEventListener('input', function () {
                activeIndex = -1;
                setActive(null);
                // With no suggestions configured, only show the friendly message
                // once something is typed (never an empty dropdown).
                if (!hasSuggestions && normalize(input.value) === '') { close(); return; }
                filter(input.value);
                open();
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                    if (!hasSuggestions) { return; }
                    event.preventDefault();
                    if (event.altKey) {            // Alt+Down opens, Alt+Up closes (ARIA combobox convention)
                        if (event.key === 'ArrowDown') { filter(input.value); open(); } else { close(); }
                        return;
                    }
                    if (list.hidden) { filter(input.value); open(); }
                    move(event.key === 'ArrowDown' ? 1 : -1);
                } else if (event.key === 'Enter') {
                    if (list.hidden) { return; } // normal form behaviour
                    var shown = visibleOptions();
                    event.preventDefault();       // first Enter only closes the list / picks the highlighted item
                    if (activeIndex >= 0 && shown[activeIndex]) { choose(shown[activeIndex]); } else { close(); }
                } else if (event.key === 'Escape') {
                    if (!list.hidden) { event.preventDefault(); close(); }
                } else if (event.key === 'Tab') {
                    close();
                }
            });

            input.addEventListener('blur', function () { window.setTimeout(close, 150); });

            // mousedown keeps focus in the input so the click can select the option
            list.addEventListener('mousedown', function (event) { event.preventDefault(); });
            list.addEventListener('click', function (event) {
                var option = event.target.closest('[role="option"]');
                if (option && !option.hidden) { choose(option); }
            });

            if (toggle) {
                toggle.addEventListener('mousedown', function (event) { event.preventDefault(); });
                toggle.addEventListener('click', function () {
                    if (list.hidden) { filter(''); open(); input.focus(); } else { close(); }
                });
            }

            document.addEventListener('click', function (event) {
                if (!combo.contains(event.target)) { close(); }
            });
        });
    })();
</script>
@endonce
