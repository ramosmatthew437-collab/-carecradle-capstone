{{--
    Laboratory document upload (prenatal visit create + edit).

    Expects:
      $labUploadLabel       field label
      $labUploadFieldClass  wrapper class used by the page's other fields
      $labUploadInputClass  input class used by the page's other inputs
      $labUploadErrorClass  error text class used by the page
      $labUploadExisting    (optional) number of documents already attached

    Limits come from StorePrenatalCheckupRequest (server-side, authoritative).
    The browser check uses the stricter of the approved limits and the running
    PHP limits, because PHP rejects larger uploads before Laravel runs (which
    would discard everything typed into the form).
--}}
@php
    $labLimits = \App\Http\Requests\StorePrenatalCheckupRequest::labUploadLimits();
    $labFmt = function (int $bytes): string {
        return $bytes >= 1024 * 1024
            ? rtrim(rtrim(number_format($bytes / 1048576, 1), '0'), '.') . ' MB'
            : max(1, (int) round($bytes / 1024)) . ' KB';
    };
    $labServerLower = $labLimits['effective'] !== $labLimits['approved'];
    $labErrors = array_merge(
        $errors->get('laboratory_attachments'),
        collect($errors->get('laboratory_attachments.*'))->flatten()->all()
    );
    $labExisting = (int) ($labUploadExisting ?? 0);
@endphp

<div class="{{ $labUploadFieldClass }} cc-lab" data-cc-lab
     data-max-files="{{ $labLimits['effective']['files'] }}"
     data-max-file-bytes="{{ $labLimits['effective']['file_bytes'] }}"
     data-max-total-bytes="{{ $labLimits['effective']['total_bytes'] }}"
     data-extensions="{{ implode(',', $labLimits['extensions']) }}">

    <label for="laboratory_attachments">{{ $labUploadLabel }}</label>

    <input
        id="laboratory_attachments"
        type="file"
        name="laboratory_attachments[]"
        multiple
        accept=".pdf,.jpg,.jpeg,.png"
        aria-describedby="laboratory_attachments_help laboratory_attachments_status"
        @if ($labErrors) aria-invalid="true" @endif
        class="{{ $labUploadInputClass }}">

    <div id="laboratory_attachments_help" class="cc-lab-help">
        <p>
            Optional. Attach laboratory results such as CBC, urinalysis, or blood
            chemistry reports. PDF, JPG, JPEG, or PNG &middot;
            up to <strong>{{ $labLimits['approved']['files'] }} files</strong>,
            <strong>{{ $labFmt($labLimits['approved']['file_bytes']) }} each</strong>,
            {{ $labFmt($labLimits['approved']['total_bytes']) }} in total.
        </p>
        @if ($labExisting > 0)
            <p>
                {{ $labExisting }} {{ \Illuminate\Support\Str::plural('document', $labExisting) }} already attached
                {{ $labExisting === 1 ? 'stays' : 'stay' }} with this visit. New files are added to them.
            </p>
        @endif
        @if ($labServerLower)
            <p class="cc-lab-server-note">
                This server currently accepts at most
                {{ $labFmt($labLimits['effective']['file_bytes']) }} per file and
                {{ $labFmt($labLimits['effective']['total_bytes']) }} per save
                (PHP upload settings). Larger selections are blocked before saving so
                nothing you typed is lost.
            </p>
        @endif
    </div>

    {{-- Selected files (filled in by the script below). --}}
    <div class="cc-lab-selection" data-cc-lab-selection hidden>
        <ul class="cc-lab-list" data-cc-lab-list aria-label="Selected laboratory documents"></ul>
        <p class="cc-lab-summary" data-cc-lab-summary></p>
    </div>

    {{-- Browser-side problems (blocking submission). --}}
    <div class="cc-lab-problems" data-cc-lab-problems role="alert" hidden></div>

    <p id="laboratory_attachments_status" class="cc-lab-sr" aria-live="polite" data-cc-lab-status></p>

    {{-- Server-side validation messages, next to the control. --}}
    @if ($labErrors)
        <ul class="cc-lab-server-errors">
            @foreach ($labErrors as $labError)
                <li class="{{ $labUploadErrorClass }}">{{ $labError }}</li>
            @endforeach
        </ul>
    @endif

    @if ($errors->any())
        <p class="cc-lab-reselect">
            For your security, browsers do not keep selected files after a
            validation error. Please choose the laboratory documents again
            (the rest of the form has been kept).
        </p>
    @endif
</div>

@once
    <style>
        .cc-lab-help {
            margin-top: 0.5rem;
            color: #6b7280;
            font-size: 0.75rem;
            line-height: 1.5;
        }

        .cc-lab-help p {
            margin: 0 0 0.25rem;
        }

        .cc-lab-help strong {
            color: #374151;
            font-weight: 600;
        }

        .cc-lab-server-note {
            margin-top: 0.375rem !important;
            padding: 0.5rem 0.625rem;
            color: #92400e;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.625rem;
        }

        .cc-lab-selection {
            margin-top: 0.75rem;
        }

        .cc-lab-list {
            display: grid;
            gap: 0.375rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .cc-lab-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            min-width: 0;
            padding: 0.5rem 0.5rem 0.5rem 0.75rem;
            background: #ffffff;
            border: 1px solid #f3e4ea;
            border-radius: 0.75rem;
        }

        .cc-lab-item.is-invalid {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .cc-lab-type {
            flex: 0 0 auto;
            min-width: 2.5rem;
            padding: 0.125rem 0.375rem;
            color: #9d174d;
            background: #fdf2f8;
            border-radius: 0.375rem;
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-align: center;
            text-transform: uppercase;
        }

        .cc-lab-item.is-invalid .cc-lab-type {
            color: #b91c1c;
            background: #fee2e2;
        }

        .cc-lab-name {
            flex: 1 1 auto;
            min-width: 0;
            margin: 0;
            color: #1f2937;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .cc-lab-meta {
            display: block;
            color: #6b7280;
            font-size: 0.75rem;
            font-weight: 400;
        }

        .cc-lab-item.is-invalid .cc-lab-meta {
            color: #b91c1c;
            font-weight: 600;
        }

        .cc-lab-remove {
            flex: 0 0 auto;
            min-height: 2rem;
            padding: 0.25rem 0.625rem;
            color: #be185d;
            background: #ffffff;
            border: 1px solid #f8d3e2;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
        }

        .cc-lab-remove:hover {
            background: #fdf2f8;
        }

        .cc-lab-remove:focus-visible {
            outline: 3px solid rgba(236, 72, 153, 0.3);
            outline-offset: 2px;
        }

        .cc-lab-summary {
            margin: 0.5rem 0 0;
            color: #4b5563;
            font-size: 0.75rem;
            font-variant-numeric: tabular-nums;
        }

        .cc-lab-problems {
            margin-top: 0.625rem;
            padding: 0.625rem 0.75rem;
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .cc-lab-problems ul {
            margin: 0.25rem 0 0;
            padding-left: 1.125rem;
        }

        .cc-lab-server-errors {
            margin: 0.5rem 0 0;
            padding: 0;
            list-style: none;
        }

        .cc-lab-reselect {
            margin: 0.5rem 0 0;
            color: #92400e;
            font-size: 0.75rem;
            line-height: 1.5;
        }

        .cc-lab-sr {
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

        .cc-lab-selection[hidden],
        .cc-lab-problems[hidden] {
            display: none;
        }
    </style>

    <script>
        (() => {
            document.querySelectorAll('[data-cc-lab]').forEach((field) => {
                const input = field.querySelector('input[type="file"]');
                const form = input ? input.form : null;
                if (!input || !form) return;

                const selection = field.querySelector('[data-cc-lab-selection]');
                const list = field.querySelector('[data-cc-lab-list]');
                const summary = field.querySelector('[data-cc-lab-summary]');
                const problemsBox = field.querySelector('[data-cc-lab-problems]');
                const status = field.querySelector('[data-cc-lab-status]');

                const maxFiles = Number(field.dataset.maxFiles);
                const maxFileBytes = Number(field.dataset.maxFileBytes);
                const maxTotalBytes = Number(field.dataset.maxTotalBytes);
                const extensions = (field.dataset.extensions || '').split(',');

                // Selected files can be added in several picks and removed one by
                // one when the browser supports DataTransfer (all current browsers).
                let canEdit = false;
                try { canEdit = typeof DataTransfer === 'function' && !!new DataTransfer(); } catch (e) { canEdit = false; }

                let files = [];

                const formatBytes = (bytes, decimals = 1) => {
                    if (bytes >= 1024 * 1024) {
                        return (bytes / 1048576).toFixed(decimals).replace(/\.?0+$/, '') + ' MB';
                    }
                    return Math.max(1, Math.round(bytes / 1024)) + ' KB';
                };

                const extensionOf = (name) => {
                    const dot = name.lastIndexOf('.');
                    return dot === -1 ? '' : name.slice(dot + 1).toLowerCase();
                };

                const keyOf = (file) => [file.name, file.size, file.lastModified].join('|');

                const syncInput = () => {
                    if (!canEdit) return;
                    const transfer = new DataTransfer();
                    files.forEach((file) => transfer.items.add(file));
                    input.files = transfer.files;
                };

                const problems = () => {
                    const found = [];
                    const total = files.reduce((sum, file) => sum + file.size, 0);

                    if (files.length > maxFiles) {
                        found.push('You selected ' + files.length + ' files. You can upload up to ' + maxFiles + ' at a time.');
                    }
                    files.forEach((file) => {
                        if (!extensions.includes(extensionOf(file.name))) {
                            found.push('"' + file.name + '" is not a PDF, JPG, JPEG, or PNG file.');
                        } else if (file.size > maxFileBytes) {
                            // Show KB when the rounded MB value would equal the limit.
                            const sizeText = formatBytes(file.size, 2) === formatBytes(maxFileBytes, 2)
                                ? Math.ceil(file.size / 1024).toLocaleString() + ' KB'
                                : formatBytes(file.size, 2);
                            found.push('"' + file.name + '" (' + sizeText + ') is larger than the ' + formatBytes(maxFileBytes, 2) + ' per-file limit.');
                        }
                    });
                    if (total > maxTotalBytes) {
                        found.push('The selected files total ' + formatBytes(total, 2) + ', over the ' + formatBytes(maxTotalBytes, 2) + ' limit per save.');
                    }
                    return found;
                };

                const showProblems = (found) => {
                    problemsBox.innerHTML = '';
                    if (!found.length) {
                        problemsBox.hidden = true;
                        input.removeAttribute('aria-invalid');
                        return;
                    }
                    const intro = document.createElement('strong');
                    intro.textContent = 'These files cannot be saved yet:';
                    const ul = document.createElement('ul');
                    found.forEach((text) => {
                        const li = document.createElement('li');
                        li.textContent = text;
                        ul.appendChild(li);
                    });
                    problemsBox.append(intro, ul);
                    problemsBox.hidden = false;
                    input.setAttribute('aria-invalid', 'true');
                };

                const render = () => {
                    list.innerHTML = '';
                    files.forEach((file, index) => {
                        const tooLarge = file.size > maxFileBytes;
                        const badType = !extensions.includes(extensionOf(file.name));

                        const li = document.createElement('li');
                        li.className = 'cc-lab-item' + (tooLarge || badType ? ' is-invalid' : '');

                        const type = document.createElement('span');
                        type.className = 'cc-lab-type';
                        type.textContent = extensionOf(file.name) || 'file';

                        const name = document.createElement('p');
                        name.className = 'cc-lab-name';
                        name.textContent = file.name;
                        const meta = document.createElement('span');
                        meta.className = 'cc-lab-meta';
                        meta.textContent = formatBytes(file.size)
                            + (badType ? ' · not an allowed format' : tooLarge ? ' · over the ' + formatBytes(maxFileBytes, 2) + ' limit' : '');
                        name.appendChild(meta);

                        li.append(type, name);

                        if (canEdit) {
                            const remove = document.createElement('button');
                            remove.type = 'button';
                            remove.className = 'cc-lab-remove';
                            remove.textContent = 'Remove';
                            remove.setAttribute('aria-label', 'Remove ' + file.name);
                            remove.addEventListener('click', () => {
                                files.splice(index, 1);
                                syncInput();
                                render();
                                status.textContent = file.name + ' removed. ' + files.length + ' selected.';
                                (list.querySelector('.cc-lab-remove') || input).focus();
                            });
                            li.appendChild(remove);
                        }

                        list.appendChild(li);
                    });

                    const total = files.reduce((sum, file) => sum + file.size, 0);
                    selection.hidden = files.length === 0;
                    summary.textContent = files.length + ' of ' + maxFiles + ' files selected · '
                        + formatBytes(total) + ' of ' + formatBytes(maxTotalBytes) + ' total';

                    showProblems(problems());
                };

                input.addEventListener('change', () => {
                    const picked = Array.from(input.files || []);
                    if (canEdit) {
                        const known = new Set(files.map(keyOf));
                        picked.forEach((file) => { if (!known.has(keyOf(file))) files.push(file); });
                    } else {
                        files = picked;
                    }
                    syncInput();
                    render();
                    status.textContent = files.length + ' laboratory ' + (files.length === 1 ? 'document' : 'documents') + ' selected.';
                });

                form.addEventListener('submit', (event) => {
                    const found = problems();
                    if (!found.length) return;
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    showProblems(found);
                    field.scrollIntoView({ block: 'center', behavior: 'smooth' });
                    input.focus({ preventScroll: true });
                });
            });
        })();
    </script>
@endonce
