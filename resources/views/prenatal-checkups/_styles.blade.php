{{--
    Prenatal Visit module styles (Add, Edit, and Detail pages).
    Scoped to .pv and modelled on the redesigned Mother Profile
    (DM Serif Display titles, Inter body, pink-and-white cards).
    Inline so the pages need no Vite rebuild; the older
    prenatal-create / prenatal-visit-edit / prenatal-visit-show
    stylesheets are no longer used by these pages and are left untouched.
--}}
@once
    <style>
        .pv {
            --pv-pink-50: #fdf2f7;
            --pv-pink-100: #fce4ee;
            --pv-pink-200: #f8d3e2;
            --pv-pink-600: #db2777;
            --pv-pink-700: #be185d;
            --pv-pink-800: #9d174d;
            --pv-line: #f1e3ea;
            --pv-line-soft: #f6edf1;
            --pv-ink: #0f172a;
            --pv-text: #334155;
            --pv-muted: #64748b;
            --pv-faint: #94a3b8;

            padding: 1rem 0 2.5rem;
            color: #1e293b;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at 8% 5%, rgba(249, 168, 212, 0.12), transparent 30%),
                linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%);
        }

        .pv *,
        .pv *::before,
        .pv *::after {
            box-sizing: border-box;
        }

        .pv-container {
            width: min(100% - 2rem, 72rem);
            margin: 0 auto;
        }

        /* ---------- Top bar: back link + page heading ---------- */

        .pv-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0.875rem;
            color: var(--pv-pink-700);
            background: #ffffff;
            border: 1px solid var(--pv-pink-200);
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .pv-back:hover {
            background: var(--pv-pink-50);
        }

        .pv-back svg {
            width: 1rem;
            height: 1rem;
        }

        .pv-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .pv-kicker {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            margin: 0 0 0.3rem;
            color: var(--pv-pink-700);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .pv-kicker::before {
            content: "";
            width: 6px;
            height: 6px;
            background: currentColor;
            border-radius: 50%;
        }

        .pv-title {
            margin: 0;
            color: var(--pv-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(1.625rem, 2.6vw, 2.125rem);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.015em;
        }

        .pv-subtitle {
            margin: 0.375rem 0 0;
            color: var(--pv-muted);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .pv-head-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .pv-head-actions form {
            margin: 0;
        }

        /* ---------- Buttons ---------- */

        .pv-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4375rem;
            min-height: 2.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            border-radius: 0.75rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .pv-btn svg {
            flex: 0 0 auto;
            width: 1rem;
            height: 1rem;
        }

        .pv-btn-primary {
            color: #ffffff;
            background: var(--pv-pink-700);
            border-color: var(--pv-pink-700);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(190, 24, 93, 0.18);
        }

        .pv-btn-primary:hover {
            background: var(--pv-pink-800);
            border-color: var(--pv-pink-800);
        }

        .pv-btn-secondary {
            color: var(--pv-pink-700);
            background: #ffffff;
            border-color: var(--pv-pink-200);
        }

        .pv-btn-secondary:hover {
            background: var(--pv-pink-50);
        }

        .pv-btn-quiet {
            color: #374151;
            background: #ffffff;
            border-color: #e5e7eb;
        }

        .pv-btn-quiet:hover {
            background: #f9fafb;
        }

        .pv-btn-danger {
            color: #b91c1c;
            background: #ffffff;
            border-color: #fecaca;
        }

        .pv-btn-danger:hover {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .pv-btn-sm {
            min-height: 2rem;
            padding: 0.3125rem 0.6875rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
        }

        .pv-btn-sm svg {
            width: 0.875rem;
            height: 0.875rem;
        }

        .pv-btn:focus-visible,
        .pv-back:focus-visible,
        .pv-doc-thumb:focus-visible {
            outline: 3px solid rgba(236, 72, 153, 0.3);
            outline-offset: 2px;
        }

        /* ---------- Mother banner ---------- */

        .pv-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            padding: 1rem 1.25rem;
            background: #ffffff;
            border: 1px solid var(--pv-line);
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px -12px rgba(190, 24, 93, 0.12);
        }

        .pv-banner-identity {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            min-width: 0;
        }

        .pv-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 3.25rem;
            width: 3.25rem;
            height: 3.25rem;
            overflow: hidden;
            color: var(--pv-pink-700);
            background: linear-gradient(145deg, #fff5f9 0%, #fde3ee 100%);
            border: 2px solid #ffffff;
            border-radius: 999px;
            box-shadow: 0 0 0 1px #f6cfe0;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
        }

        .pv-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pv-banner-copy {
            min-width: 0;
        }

        .pv-banner-facts dd {
            margin: 0;
        }

        .pv-sr {
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

        .pv-banner-label {
            margin: 0 0 0.125rem;
            color: var(--pv-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .pv-banner-name {
            margin: 0;
            color: var(--pv-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.375rem;
            font-weight: 400;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .pv-banner-ids {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.375rem 0.75rem;
            margin-top: 0.375rem;
            color: #475569;
            font-size: 0.8125rem;
        }

        .pv-code {
            padding: 0.0625rem 0.5rem;
            color: var(--pv-pink-800);
            background: var(--pv-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.6;
            letter-spacing: 0.03em;
            font-variant-numeric: tabular-nums;
        }

        .pv-banner-facts {
            display: grid;
            grid-auto-flow: column;
            flex: 0 0 auto;
            background: #fdf8fa;
            border: 1px solid #f5e6ed;
            border-radius: 0.875rem;
        }

        .pv-fact {
            display: flex;
            flex-direction: column;
            gap: 0.3125rem;
            padding: 0.625rem 1rem;
        }

        .pv-fact + .pv-fact {
            border-left: 1px solid #f1e0e8;
        }

        .pv-fact-label {
            color: var(--pv-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .pv-fact-value {
            color: #1e293b;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .pv-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            width: fit-content;
            padding: 0.1875rem 0.625rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .pv-status::before {
            content: "";
            width: 0.4375rem;
            height: 0.4375rem;
            background: currentColor;
            border-radius: 50%;
        }

        .pv-status-pregnant { color: #166534; background: #dcfce7; }
        .pv-status-delivered { color: #475569; background: #f1f5f9; }
        .pv-status-referred { color: #92400e; background: #fef3c7; }
        .pv-status-default { color: var(--pv-pink-800); background: var(--pv-pink-100); }

        /* ---------- Alerts ---------- */

        .pv-alert {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0.875rem 1rem;
            border: 1px solid;
            border-radius: 0.875rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .pv-alert svg {
            flex: 0 0 auto;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.0625rem;
        }

        .pv-alert-title {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .pv-alert ul {
            margin: 0.375rem 0 0;
            padding-left: 1.125rem;
        }

        .pv-alert-error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .pv-alert-success {
            align-items: center;
            color: #065f46;
            background: #ecfdf5;
            border-color: #a7f3d0;
            font-weight: 500;
        }

        /* ---------- Cards and sections ---------- */

        .pv-card {
            margin-top: 1rem;
            padding: 1.25rem;
            background: #ffffff;
            border: 1px solid var(--pv-line);
            border-radius: 1.125rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 4px 18px rgba(190, 24, 93, 0.03);
        }

        .pv-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.125rem;
        }

        .pv-card-head-main {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            min-width: 0;
        }

        .pv-step {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 2rem;
            width: 2rem;
            height: 2rem;
            color: var(--pv-pink-700);
            background: var(--pv-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.625rem;
            font-size: 0.75rem;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .pv-step svg {
            width: 1rem;
            height: 1rem;
        }

        .pv-card-title {
            margin: 0;
            color: var(--pv-pink-800);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .pv-card-sub {
            margin: 0.125rem 0 0;
            color: var(--pv-muted);
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .pv-subhead {
            margin: 1.25rem 0 0.625rem;
            color: #374151;
            font-size: 0.8125rem;
            font-weight: 700;
        }

        /* ---------- Form fields ---------- */

        .pv-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.125rem;
        }

        .pv-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .pv-span-all {
            grid-column: 1 / -1;
        }

        .pv-field {
            min-width: 0;
        }

        .pv-field > label,
        .pv-label {
            display: block;
            margin-bottom: 0.375rem;
            color: #374151;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .pv-req {
            margin-left: 0.125rem;
            color: var(--pv-pink-600);
        }

        .pv-optional {
            margin-left: 0.25rem;
            color: var(--pv-faint);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .pv-input-group {
            position: relative;
        }

        .pv-input,
        .pv .pv-field select,
        .pv .pv-field textarea {
            display: block;
            width: 100%;
            min-height: 2.75rem;
            padding: 0.625rem 0.875rem;
            color: #111827;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-family: inherit;
            font-size: 0.875rem;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .pv .pv-field textarea {
            min-height: 6.5rem;
            resize: vertical;
        }

        .pv-input:hover,
        .pv .pv-field select:hover,
        .pv .pv-field textarea:hover {
            border-color: #d1d5db;
        }

        .pv-input:focus,
        .pv .pv-field select:focus,
        .pv .pv-field textarea:focus {
            border-color: #ec4899;
            outline: none;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.14);
        }

        .pv-input-group .pv-input {
            padding-right: 3.75rem;
        }

        .pv-suffix {
            position: absolute;
            top: 50%;
            right: 0.875rem;
            color: var(--pv-faint);
            font-size: 0.75rem;
            font-weight: 600;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .pv-field.has-error .pv-input,
        .pv .pv-field.has-error select,
        .pv .pv-field.has-error textarea {
            background-color: #fffafa;
            border-color: #f87171;
        }

        .pv-error {
            margin: 0.375rem 0 0;
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.45;
        }

        .pv-hint {
            margin: 0.375rem 0 0;
            color: var(--pv-muted);
            font-size: 0.75rem;
            line-height: 1.45;
        }

        /* ---------- Form actions ---------- */

        .pv-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0.875rem 1.25rem;
            background: #ffffff;
            border: 1px solid var(--pv-line);
            border-radius: 1rem;
        }

        .pv-actions-note {
            margin: 0;
            color: var(--pv-muted);
            font-size: 0.8125rem;
        }

        .pv-actions-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* ---------- Detail page: vitals panel ---------- */

        .pv-vitals {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1px;
            overflow: hidden;
            background: #f3e6ec;
            border: 1px solid #f3e6ec;
            border-radius: 0.875rem;
        }

        .pv-vital {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            min-width: 0;
            padding: 0.875rem 1rem;
            background: #ffffff;
        }

        .pv-vital-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 2.125rem;
            width: 2.125rem;
            height: 2.125rem;
            color: var(--pv-pink-700);
            background: var(--pv-pink-50);
            border-radius: 0.625rem;
        }

        .pv-vital-icon svg {
            width: 1.0625rem;
            height: 1.0625rem;
        }

        .pv-vital-label {
            margin: 0 0 0.1875rem;
            color: var(--pv-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .pv-vital-value {
            margin: 0;
            color: var(--pv-ink);
            font-size: 1.0625rem;
            font-weight: 600;
            line-height: 1.3;
            font-variant-numeric: tabular-nums;
        }

        .pv-vital-value small {
            margin-left: 0.1875rem;
            color: var(--pv-muted);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .pv-empty-value {
            color: var(--pv-faint);
            font-weight: 500;
        }

        /* ---------- Detail page: labs + documents ---------- */

        .pv-labs {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .pv-lab {
            padding: 0.75rem 1rem;
            background: #fdf8fa;
            border: 1px solid #f5e6ed;
            border-radius: 0.75rem;
        }

        .pv-docs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
            gap: 0.75rem;
        }

        .pv-doc {
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--pv-line);
            border-radius: 0.875rem;
        }

        .pv-doc-thumb {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 8.5rem;
            overflow: hidden;
            color: var(--pv-pink-700);
            background: #fdf8fa;
            border-bottom: 1px solid var(--pv-line-soft);
            text-decoration: none;
        }

        .pv-doc-thumb img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pv-doc-pdf {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .pv-doc-pdf svg {
            width: 2.25rem;
            height: 2.25rem;
        }

        .pv-doc-body {
            flex: 1 1 auto;
            padding: 0.75rem 0.875rem 0.5rem;
        }

        .pv-doc-name {
            margin: 0;
            color: #1f2937;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .pv-doc-meta {
            margin: 0.125rem 0 0;
            color: var(--pv-muted);
            font-size: 0.75rem;
            font-variant-numeric: tabular-nums;
        }

        .pv-doc-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
            padding: 0 0.875rem 0.875rem;
        }

        .pv-doc-actions form {
            margin: 0;
        }

        .pv-doc-list {
            display: grid;
            gap: 0.375rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pv-doc-row {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            min-width: 0;
            padding: 0.5rem 0.625rem;
            background: #fdf8fa;
            border: 1px solid #f5e6ed;
            border-radius: 0.75rem;
        }

        .pv-doc-row .pv-doc-body {
            flex: 1 1 auto;
            min-width: 0;
            padding: 0;
        }

        .pv-doc-type {
            flex: 0 0 auto;
            min-width: 2.5rem;
            padding: 0.125rem 0.375rem;
            color: var(--pv-pink-800);
            background: var(--pv-pink-100);
            border-radius: 0.375rem;
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-align: center;
            text-transform: uppercase;
        }

        .pv-empty {
            padding: 1.5rem 1rem;
            text-align: center;
            background: #fffafc;
            border: 1px dashed #f3cfe0;
            border-radius: 0.875rem;
        }

        .pv-empty p {
            margin: 0;
            color: var(--pv-muted);
            font-size: 0.8125rem;
        }

        .pv-empty strong {
            display: block;
            margin-bottom: 0.125rem;
            color: #1e293b;
            font-size: 0.875rem;
        }

        .pv-notes {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .pv-note {
            padding: 0.875rem 1rem;
            background: #ffffff;
            border: 1px solid var(--pv-line);
            border-radius: 0.75rem;
        }

        .pv-note-text {
            margin: 0;
            color: var(--pv-text);
            font-size: 0.875rem;
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .pv-next {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.75rem;
            padding: 0.75rem 1rem;
            background: var(--pv-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.75rem;
        }

        /* ---------- Responsive ---------- */

        @media (min-width: 640px) {
            .pv {
                padding: 1.5rem 0 3.5rem;
            }

            .pv-container {
                width: min(100% - 3rem, 72rem);
            }

            .pv-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 900px) {
            .pv-grid-3,
            .pv-vitals {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .pv-banner {
                flex-direction: column;
                align-items: stretch;
            }

            .pv-banner-facts {
                grid-auto-flow: row;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .pv-grid,
            .pv-grid-3,
            .pv-labs,
            .pv-notes {
                grid-template-columns: minmax(0, 1fr);
            }

            .pv-head {
                align-items: stretch;
            }

            .pv-head-actions,
            .pv-head-actions form,
            .pv-head-actions .pv-btn {
                width: 100%;
            }

            .pv-head-actions {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .pv-banner {
                padding: 0.875rem;
            }

            .pv-actions {
                position: sticky;
                bottom: max(0.5rem, env(safe-area-inset-bottom, 0px));
                z-index: 20;
                padding: 0.75rem;
                box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.06);
            }

            .pv-actions-note {
                display: none;
            }

            .pv-actions-buttons {
                display: grid;
                grid-template-columns: 1fr 1.4fr;
                width: 100%;
            }
        }

        @media (max-width: 420px) {
            .pv-vitals {
                grid-template-columns: minmax(0, 1fr);
            }

            .pv-banner-facts {
                grid-template-columns: minmax(0, 1fr);
            }

            .pv-fact + .pv-fact {
                border-top: 1px solid #f1e0e8;
                border-left: 0;
            }

            .pv-fact {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .pv-btn,
            .pv-back,
            .pv-input {
                transition: none;
            }
        }
    </style>
@endonce
