{{--
    Account profile styles (Administrator, Midwife and Mother portals).
    Scoped to .prf and modelled on the redesigned Mother Profile, Prenatal
    Visit and Infant Management pages. Inline so no Vite rebuild is needed.
--}}
@once
    <style>
        .prf {
            --prf-pink-50: #fdf2f7;
            --prf-pink-100: #fce4ee;
            --prf-pink-200: #f8d3e2;
            --prf-pink-600: #db2777;
            --prf-pink-700: #be185d;
            --prf-pink-800: #9d174d;
            --prf-line: #f1e3ea;
            --prf-line-soft: #f6edf1;
            --prf-ink: #0f172a;
            --prf-muted: #64748b;
            --prf-faint: #94a3b8;

            padding: 1rem 0 2.5rem;
            color: #1e293b;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at 8% 5%, rgba(249, 168, 212, 0.12), transparent 30%),
                linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%);
        }

        .prf *,
        .prf *::before,
        .prf *::after {
            box-sizing: border-box;
        }

        .prf-container {
            width: min(100% - 2rem, 56rem);
            margin: 0 auto;
        }

        .prf-sr {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* ---------- Header ---------- */

        .prf-head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.125rem 1.25rem;
            background: #ffffff;
            border: 1px solid var(--prf-line);
            border-radius: 1.125rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px -12px rgba(190, 24, 93, 0.12);
        }

        .prf-identity {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            min-width: 0;
        }

        .prf-avatar {
            display: flex;
            flex: 0 0 3.5rem;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            overflow: hidden;
            color: var(--prf-pink-700);
            background: linear-gradient(145deg, #fff5f9 0%, #fde3ee 100%);
            border: 2px solid #ffffff;
            border-radius: 999px;
            box-shadow: 0 0 0 1px #f6cfe0;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.375rem;
        }

        .prf-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prf-avatar-lg {
            flex-basis: 5.5rem;
            width: 5.5rem;
            height: 5.5rem;
            font-size: 2rem;
        }

        .prf-kicker {
            margin: 0 0 0.125rem;
            color: var(--prf-pink-700);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .prf-title {
            margin: 0;
            color: var(--prf-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(1.5rem, 2.4vw, 2rem);
            font-weight: 400;
            line-height: 1.15;
        }

        .prf-subtitle {
            margin: 0.25rem 0 0;
            color: var(--prf-muted);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .prf-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem;
        }

        .prf-nav a {
            display: inline-flex;
            align-items: center;
            min-height: 2rem;
            padding: 0.25rem 0.75rem;
            color: var(--prf-pink-700);
            background: var(--prf-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .prf-nav a:hover {
            background: var(--prf-pink-100);
        }

        /* ---------- Alerts ---------- */

        .prf-alert {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            margin-top: 1rem;
            padding: 0.875rem 1rem;
            border: 1px solid;
            border-radius: 0.875rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .prf-alert svg {
            flex: 0 0 auto;
            width: 1.25rem;
            height: 1.25rem;
        }

        .prf-alert-success {
            color: #065f46;
            background: #ecfdf5;
            border-color: #a7f3d0;
            font-weight: 500;
        }

        .prf-alert-error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        /* ---------- Cards ---------- */

        .prf-card {
            margin-top: 1rem;
            padding: 1.25rem;
            background: #ffffff;
            border: 1px solid var(--prf-line);
            border-radius: 1.125rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 4px 18px rgba(190, 24, 93, 0.03);
            scroll-margin-top: 1rem;
        }

        .prf-card-danger {
            border-color: #fecdd3;
        }

        .prf-card-head {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.125rem;
        }

        .prf-card-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            color: var(--prf-pink-700);
            background: var(--prf-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.75rem;
        }

        .prf-card-danger .prf-card-icon {
            color: #be123c;
            background: #fff1f2;
            border-color: #fecdd3;
        }

        .prf-card-icon svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .prf-card-title {
            margin: 0;
            color: var(--prf-pink-800);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .prf-card-danger .prf-card-title {
            color: #9f1239;
        }

        .prf-card-sub {
            margin: 0.125rem 0 0;
            color: var(--prf-muted);
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        /* ---------- Forms ---------- */

        .prf-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.125rem;
        }

        .prf-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .prf-span-all {
            grid-column: 1 / -1;
        }

        .prf-field {
            min-width: 0;
        }

        .prf-label {
            display: block;
            margin-bottom: 0.375rem;
            color: #374151;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .prf-req {
            margin-left: 0.125rem;
            color: var(--prf-pink-600);
        }

        .prf-optional {
            margin-left: 0.25rem;
            color: var(--prf-faint);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .prf .prf-input {
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

        .prf .prf-input::placeholder {
            color: #9ca3af;
        }

        .prf .prf-input:hover {
            border-color: #d1d5db;
        }

        .prf .prf-input:focus {
            border-color: #ec4899;
            outline: none;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.14);
        }

        .prf-field.has-error .prf-input {
            background-color: #fffafa;
            border-color: #f87171;
        }

        .prf-readonly {
            display: flex;
            align-items: center;
            min-height: 2.75rem;
            padding: 0.625rem 0.875rem;
            color: #334155;
            background: #fdfafc;
            border: 1px dashed #f0dbe5;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            overflow-wrap: anywhere;
        }

        .prf-error {
            margin: 0.375rem 0 0;
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.45;
        }

        .prf-hint {
            margin: 0.375rem 0 0;
            color: var(--prf-muted);
            font-size: 0.75rem;
            line-height: 1.45;
        }

        .prf-subhead {
            margin: 1.25rem 0 0.75rem;
            padding-top: 1rem;
            color: var(--prf-muted);
            border-top: 1px solid var(--prf-line-soft);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .prf-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--prf-line-soft);
        }

        .prf-actions-note {
            flex: 1 1 14rem;
            margin: 0;
            color: var(--prf-muted);
            font-size: 0.8125rem;
        }

        .prf-actions-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .prf-actions-buttons form {
            margin: 0;
        }

        /* ---------- Buttons ---------- */

        .prf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4375rem;
            min-height: 2.75rem;
            padding: 0.5rem 1.125rem;
            border: 1px solid transparent;
            border-radius: 0.75rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .prf-btn svg {
            flex: 0 0 auto;
            width: 1rem;
            height: 1rem;
        }

        .prf-btn:focus-visible,
        .prf-nav a:focus-visible,
        .prf-file-button:focus-within {
            outline: 3px solid #fbcfe8;
            outline-offset: 2px;
        }

        .prf-btn-primary {
            color: #ffffff;
            background: var(--prf-pink-700);
            border-color: var(--prf-pink-700);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(190, 24, 93, 0.18);
        }

        .prf-btn-primary:hover {
            background: var(--prf-pink-800);
            border-color: var(--prf-pink-800);
        }

        .prf-btn-secondary {
            color: var(--prf-pink-700);
            background: #ffffff;
            border-color: var(--prf-pink-200);
        }

        .prf-btn-secondary:hover {
            background: var(--prf-pink-50);
        }

        .prf-btn-danger {
            color: #b91c1c;
            background: #ffffff;
            border-color: #fecaca;
        }

        .prf-btn-danger:hover {
            background: #fef2f2;
        }

        /* ---------- Photo ---------- */

        .prf-photo {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1.25rem;
        }

        .prf-photo-body {
            flex: 1 1 16rem;
            min-width: 0;
        }

        .prf-file {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem 0.75rem;
        }

        .prf-file-button {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.4375rem;
            min-height: 2.75rem;
            padding: 0.5rem 1rem;
            color: var(--prf-pink-700);
            background: var(--prf-pink-50);
            border: 1px dashed #f0abc9;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
        }

        .prf-file-button input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .prf-file-button svg {
            width: 1rem;
            height: 1rem;
        }

        .prf-file-name {
            min-width: 0;
            color: var(--prf-muted);
            font-size: 0.8125rem;
            overflow-wrap: anywhere;
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 767px) {
            .prf-grid-3 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .prf-container {
                width: min(100% - 1.5rem, 56rem);
            }

            .prf-card,
            .prf-head {
                padding: 1rem;
            }

            .prf-grid,
            .prf-grid-3 {
                grid-template-columns: minmax(0, 1fr);
            }

            .prf-actions-buttons,
            .prf-actions-buttons form,
            .prf-actions-buttons .prf-btn {
                width: 100%;
            }
        }
    </style>
@endonce
