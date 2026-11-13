{{--
    Schedule Appointment page styles. Scoped to .apc and modelled on the
    redesigned Mother Profile, Prenatal Visit and Infant Management pages
    (DM Serif Display headings, Inter body, pink-and-white cards).
    Inline so the page needs no Vite rebuild.
--}}
@once
    <style>
        .apc {
            --apc-pink-50: #fdf2f7;
            --apc-pink-100: #fce4ee;
            --apc-pink-200: #f8d3e2;
            --apc-pink-600: #db2777;
            --apc-pink-700: #be185d;
            --apc-pink-800: #9d174d;
            --apc-line: #f1e3ea;
            --apc-ink: #0f172a;
            --apc-muted: #64748b;
            --apc-faint: #94a3b8;

            padding: 1rem 0 2.5rem;
            color: #1e293b;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at 8% 5%, rgba(249, 168, 212, 0.12), transparent 30%),
                linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%);
        }

        .apc *,
        .apc *::before,
        .apc *::after {
            box-sizing: border-box;
        }

        .apc-container {
            width: min(100% - 2rem, 52rem);
            margin: 0 auto;
        }

        .apc-sr {
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

        /* ---------- Back link + heading ---------- */

        .apc-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0.875rem;
            color: var(--apc-pink-700);
            background: #ffffff;
            border: 1px solid var(--apc-pink-200);
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .apc-back:hover {
            background: var(--apc-pink-50);
        }

        .apc-back svg {
            width: 1rem;
            height: 1rem;
        }

        .apc-head {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 1rem;
        }

        .apc-head-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            color: var(--apc-pink-700);
            background: var(--apc-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.875rem;
        }

        .apc-head-icon svg {
            width: 1.375rem;
            height: 1.375rem;
        }

        .apc-kicker {
            margin: 0 0 0.125rem;
            color: var(--apc-pink-700);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .apc-title {
            margin: 0;
            color: var(--apc-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(1.5rem, 2.4vw, 2rem);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.015em;
        }

        .apc-subtitle {
            margin: 0.25rem 0 0;
            color: var(--apc-muted);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* ---------- Mother card ---------- */

        .apc-mother {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            padding: 0.875rem 1.125rem;
            background: #fffafc;
            border: 1px solid var(--apc-pink-200);
            border-radius: 1rem;
        }

        .apc-mother-identity {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .apc-avatar {
            display: flex;
            flex: 0 0 2.75rem;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            overflow: hidden;
            color: var(--apc-pink-700);
            background: linear-gradient(145deg, #fff5f9 0%, #fde3ee 100%);
            border: 2px solid #ffffff;
            border-radius: 999px;
            box-shadow: 0 0 0 1px #f6cfe0;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.0625rem;
        }

        .apc-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .apc-mother-copy {
            min-width: 0;
        }

        .apc-mother-label {
            margin: 0;
            color: var(--apc-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .apc-mother-name {
            margin: 0.0625rem 0 0;
            color: var(--apc-ink);
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .apc-mother-ids {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.25rem 0.625rem;
            margin-top: 0.25rem;
            color: #475569;
            font-size: 0.8125rem;
        }

        .apc-code {
            padding: 0.0625rem 0.5rem;
            color: var(--apc-pink-800);
            background: var(--apc-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.6;
            letter-spacing: 0.03em;
            font-variant-numeric: tabular-nums;
        }

        .apc-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .apc-status::before {
            content: "";
            width: 0.375rem;
            height: 0.375rem;
            background: currentColor;
            border-radius: 50%;
        }

        .apc-status-pregnant { color: #166534; background: #dcfce7; }
        .apc-status-delivered { color: #475569; background: #f1f5f9; }
        .apc-status-referred { color: #92400e; background: #fef3c7; }
        .apc-status-default { color: var(--apc-pink-800); background: var(--apc-pink-100); }

        /* ---------- Alerts ---------- */

        .apc-alert {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0.875rem 1rem;
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.875rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .apc-alert svg {
            flex: 0 0 auto;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.0625rem;
        }

        .apc-alert-title {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .apc-alert ul {
            margin: 0.375rem 0 0;
            padding-left: 1.125rem;
        }

        /* ---------- Form card ---------- */

        .apc-card {
            margin-top: 1rem;
            padding: 1.25rem;
            background: #ffffff;
            border: 1px solid var(--apc-line);
            border-radius: 1.125rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 4px 18px rgba(190, 24, 93, 0.03);
        }

        .apc-card-head {
            margin-bottom: 1.125rem;
        }

        .apc-card-title {
            margin: 0;
            color: var(--apc-pink-800);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .apc-card-sub {
            margin: 0.125rem 0 0;
            color: var(--apc-muted);
            font-size: 0.8125rem;
        }

        .apc-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.125rem;
        }

        .apc-span-all {
            grid-column: 1 / -1;
        }

        .apc-field {
            min-width: 0;
        }

        .apc-label {
            display: block;
            margin-bottom: 0.375rem;
            color: #374151;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .apc-req {
            margin-left: 0.125rem;
            color: var(--apc-pink-600);
        }

        .apc-optional {
            margin-left: 0.25rem;
            color: var(--apc-faint);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .apc-control {
            position: relative;
        }

        .apc-control-icon {
            position: absolute;
            top: 50%;
            left: 0.875rem;
            width: 1.125rem;
            height: 1.125rem;
            color: var(--apc-faint);
            pointer-events: none;
            transform: translateY(-50%);
        }

        .apc .apc-input {
            display: block;
            width: 100%;
            min-height: 2.875rem;
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

        .apc .apc-control .apc-input {
            padding-left: 2.5rem;
        }

        .apc textarea.apc-input {
            min-height: 6.5rem;
            resize: vertical;
        }

        .apc .apc-input::placeholder {
            color: #9ca3af;
        }

        .apc .apc-input:hover {
            border-color: #d1d5db;
        }

        .apc .apc-input:focus {
            border-color: #ec4899;
            outline: none;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.14);
        }

        .apc-field.has-error .apc-input {
            background-color: #fffafa;
            border-color: #f87171;
        }

        .apc-error {
            margin: 0.375rem 0 0;
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.45;
        }

        .apc-hint {
            margin: 0.375rem 0 0;
            color: var(--apc-muted);
            font-size: 0.75rem;
            line-height: 1.45;
        }

        /* ---------- Action footer ---------- */

        .apc-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--apc-line);
        }

        .apc-actions-note {
            flex: 1 1 16rem;
            margin: 0;
            color: var(--apc-muted);
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .apc-actions-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .apc-btn {
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

        .apc-btn svg {
            flex: 0 0 auto;
            width: 1rem;
            height: 1rem;
        }

        .apc-btn:focus-visible,
        .apc-back:focus-visible {
            outline: 3px solid #fbcfe8;
            outline-offset: 2px;
        }

        .apc-btn-primary {
            color: #ffffff;
            background: var(--apc-pink-700);
            border-color: var(--apc-pink-700);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(190, 24, 93, 0.18);
        }

        .apc-btn-primary:hover {
            background: var(--apc-pink-800);
            border-color: var(--apc-pink-800);
        }

        .apc-btn-secondary {
            color: var(--apc-pink-700);
            background: #ffffff;
            border-color: var(--apc-pink-200);
        }

        .apc-btn-secondary:hover {
            background: var(--apc-pink-50);
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 639px) {
            .apc-container {
                width: min(100% - 1.5rem, 52rem);
            }

            .apc-card {
                padding: 1rem;
            }

            .apc-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .apc-actions-buttons {
                flex-direction: column;
                width: 100%;
            }

            .apc-actions-buttons .apc-btn {
                width: 100%;
            }
        }
    </style>
@endonce
