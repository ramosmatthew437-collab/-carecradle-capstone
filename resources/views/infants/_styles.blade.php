{{--
    Infant Management styles: Infant Registration / Edit / Profile,
    Infant Vaccination and Growth Monitoring pages.
    Scoped to .inf and modelled on the redesigned Mother Profile and Prenatal
    Visit pages (DM Serif Display headings, Inter body, pink-and-white cards).
    Inline so the pages need no Vite rebuild.
--}}
@once
    <style>
        .inf {
            --inf-pink-50: #fdf2f7;
            --inf-pink-100: #fce4ee;
            --inf-pink-200: #f8d3e2;
            --inf-pink-600: #db2777;
            --inf-pink-700: #be185d;
            --inf-pink-800: #9d174d;
            --inf-line: #f1e3ea;
            --inf-line-soft: #f6edf1;
            --inf-ink: #0f172a;
            --inf-text: #334155;
            --inf-muted: #64748b;
            --inf-faint: #94a3b8;

            padding: 1rem 0 2.5rem;
            color: #1e293b;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at 8% 5%, rgba(249, 168, 212, 0.12), transparent 30%),
                linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%);
        }

        .inf *,
        .inf *::before,
        .inf *::after {
            box-sizing: border-box;
        }

        .inf-container {
            width: min(100% - 2rem, 72rem);
            margin: 0 auto;
        }

        .inf-container-narrow {
            width: min(100% - 2rem, 60rem);
        }

        .inf-sr {
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

        /* ---------- Top bar ---------- */

        .inf-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.5rem 0.875rem;
            color: var(--inf-pink-700);
            background: #ffffff;
            border: 1px solid var(--inf-pink-200);
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .inf-back:hover {
            background: var(--inf-pink-50);
        }

        .inf-back svg {
            width: 1rem;
            height: 1rem;
        }

        .inf-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .inf-head > div:first-child {
            min-width: 0;
        }

        .inf-kicker {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            margin: 0 0 0.3rem;
            color: var(--inf-pink-700);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .inf-kicker::before {
            content: "";
            width: 6px;
            height: 6px;
            background: currentColor;
            border-radius: 50%;
        }

        .inf-title {
            margin: 0;
            color: var(--inf-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(1.625rem, 2.6vw, 2.125rem);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.015em;
            overflow-wrap: anywhere;
        }

        .inf-subtitle {
            margin: 0.375rem 0 0;
            color: var(--inf-muted);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .inf-head-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .inf-head-actions form {
            margin: 0;
        }

        /* ---------- Buttons ---------- */

        .inf-btn {
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

        .inf-btn svg {
            flex: 0 0 auto;
            width: 1rem;
            height: 1rem;
        }

        .inf-btn:focus-visible,
        .inf-back:focus-visible,
        .inf-link:focus-visible,
        .inf-stat-link:focus-visible {
            outline: 3px solid #fbcfe8;
            outline-offset: 2px;
        }

        .inf-btn-primary {
            color: #ffffff;
            background: var(--inf-pink-700);
            border-color: var(--inf-pink-700);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(190, 24, 93, 0.18);
        }

        .inf-btn-primary:hover {
            background: var(--inf-pink-800);
            border-color: var(--inf-pink-800);
        }

        .inf-btn-secondary {
            color: var(--inf-pink-700);
            background: #ffffff;
            border-color: var(--inf-pink-200);
        }

        .inf-btn-secondary:hover {
            background: var(--inf-pink-50);
        }

        .inf-btn-quiet {
            color: #374151;
            background: #ffffff;
            border-color: #e5e7eb;
        }

        .inf-btn-quiet:hover {
            background: #f9fafb;
        }

        .inf-btn-danger {
            color: #b91c1c;
            background: #ffffff;
            border-color: #fecaca;
        }

        .inf-btn-danger:hover {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .inf-btn-sm {
            min-height: 2rem;
            padding: 0.3125rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
        }

        .inf-link {
            color: var(--inf-pink-700);
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        /* ---------- Identity banner (infant or mother) ---------- */

        .inf-banner {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem 1.25rem;
            padding: 1rem 1.25rem;
            background: #ffffff;
            border: 1px solid var(--inf-line);
            border-radius: 1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px -12px rgba(190, 24, 93, 0.12);
        }

        .inf-banner-identity {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            min-width: 0;
        }

        .inf-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 3.25rem;
            width: 3.25rem;
            height: 3.25rem;
            overflow: hidden;
            color: var(--inf-pink-700);
            background: linear-gradient(145deg, #fff5f9 0%, #fde3ee 100%);
            border: 2px solid #ffffff;
            border-radius: 999px;
            box-shadow: 0 0 0 1px #f6cfe0;
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
        }

        .inf-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .inf-avatar-lg {
            flex-basis: 4rem;
            width: 4rem;
            height: 4rem;
            font-size: 1.5rem;
        }

        .inf-banner-copy {
            min-width: 0;
        }

        .inf-banner-label {
            margin: 0 0 0.125rem;
            color: var(--inf-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .inf-banner-name {
            margin: 0;
            color: var(--inf-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.375rem;
            font-weight: 400;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .inf-banner-ids {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.375rem 0.75rem;
            margin-top: 0.375rem;
            color: #475569;
            font-size: 0.8125rem;
        }

        .inf-code {
            padding: 0.0625rem 0.5rem;
            color: var(--inf-pink-800);
            background: var(--inf-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.6;
            letter-spacing: 0.03em;
            font-variant-numeric: tabular-nums;
        }

        .inf-banner-facts {
            display: flex;
            flex-wrap: wrap;
            margin: 0;
            background: #fdf8fa;
            border: 1px solid #f5e6ed;
            border-radius: 0.875rem;
        }

        .inf-banner-facts dd {
            margin: 0;
        }

        .inf-fact {
            display: flex;
            flex-direction: column;
            gap: 0.3125rem;
            padding: 0.625rem 1rem;
        }

        .inf-fact + .inf-fact {
            border-left: 1px solid #f1e0e8;
        }

        .inf-fact-label {
            color: var(--inf-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .inf-fact-value {
            color: #1e293b;
            font-size: 0.875rem;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }

        /* ---------- Badges ---------- */

        .inf-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            width: fit-content;
            padding: 0.1875rem 0.625rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
        }

        .inf-badge-pink { color: var(--inf-pink-800); background: var(--inf-pink-100); }
        .inf-badge-green { color: #166534; background: #dcfce7; }
        .inf-badge-amber { color: #92400e; background: #fef3c7; }
        .inf-badge-red { color: #991b1b; background: #fee2e2; }
        .inf-badge-gray { color: #475569; background: #f1f5f9; }
        .inf-badge-blue { color: #1e40af; background: #dbeafe; }

        /* ---------- Alerts ---------- */

        .inf-alert {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0.875rem 1rem;
            border: 1px solid;
            border-radius: 0.875rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .inf-alert svg {
            flex: 0 0 auto;
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.0625rem;
        }

        .inf-alert-title {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .inf-alert ul {
            margin: 0.375rem 0 0;
            padding-left: 1.125rem;
        }

        .inf-alert-error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .inf-alert-success {
            align-items: center;
            color: #065f46;
            background: #ecfdf5;
            border-color: #a7f3d0;
            font-weight: 500;
        }

        .inf-alert-info {
            color: #475569;
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        /* ---------- Cards ---------- */

        .inf-card {
            margin-top: 1rem;
            padding: 1.25rem;
            background: #ffffff;
            border: 1px solid var(--inf-line);
            border-radius: 1.125rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 4px 18px rgba(190, 24, 93, 0.03);
        }

        .inf-card-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            margin-bottom: 1.125rem;
        }

        .inf-card-head-main {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            min-width: 0;
        }

        .inf-card-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            color: var(--inf-pink-700);
            background: var(--inf-pink-50);
            border: 1px solid #f8dde9;
            border-radius: 0.75rem;
        }

        .inf-card-icon svg {
            width: 1.125rem;
            height: 1.125rem;
        }

        .inf-card-title {
            margin: 0;
            color: var(--inf-pink-800);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .inf-card-sub {
            margin: 0.125rem 0 0;
            color: var(--inf-muted);
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .inf-card-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .inf-subhead {
            margin: 1.25rem 0 0.75rem;
            color: var(--inf-muted);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        /* ---------- Forms ---------- */

        .inf-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 1.125rem;
        }

        .inf-grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .inf-span-all {
            grid-column: 1 / -1;
        }

        .inf-field {
            min-width: 0;
        }

        .inf-label {
            display: block;
            margin-bottom: 0.375rem;
            color: #374151;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .inf-req {
            margin-left: 0.125rem;
            color: var(--inf-pink-600);
        }

        .inf-optional {
            margin-left: 0.25rem;
            color: var(--inf-faint);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .inf-input-group {
            position: relative;
        }

        .inf .inf-input {
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

        .inf textarea.inf-input {
            min-height: 6.5rem;
            resize: vertical;
        }

        .inf .inf-input:hover {
            border-color: #d1d5db;
        }

        .inf .inf-input:focus {
            border-color: #ec4899;
            outline: none;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.14);
        }

        .inf-input-group .inf-input {
            padding-right: 3.25rem;
        }

        .inf-suffix {
            position: absolute;
            top: 50%;
            right: 0.875rem;
            color: var(--inf-faint);
            font-size: 0.75rem;
            font-weight: 600;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .inf-field.has-error .inf-input {
            background-color: #fffafa;
            border-color: #f87171;
        }

        .inf-error {
            margin: 0.375rem 0 0;
            color: #b91c1c;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.45;
        }

        .inf-hint {
            margin: 0.375rem 0 0;
            color: var(--inf-muted);
            font-size: 0.75rem;
            line-height: 1.45;
        }

        .inf-output {
            display: flex;
            align-items: center;
            min-height: 2.75rem;
            padding: 0.625rem 0.875rem;
            color: var(--inf-pink-800);
            background: var(--inf-pink-50);
            border: 1px dashed #f3cfe0;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .inf-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 0.875rem 1.25rem;
            background: #ffffff;
            border: 1px solid var(--inf-line);
            border-radius: 1rem;
        }

        .inf-actions-note {
            margin: 0;
            color: var(--inf-muted);
            font-size: 0.8125rem;
        }

        .inf-actions-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .inf-actions-buttons form {
            margin: 0;
        }

        /* ---------- Read-only facts ---------- */

        .inf-dl {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
            margin: 0;
        }

        .inf-dl-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .inf-dl > div {
            min-width: 0;
            padding: 0.75rem 0.875rem;
            background: #fdfafc;
            border: 1px solid var(--inf-line-soft);
            border-radius: 0.75rem;
        }

        .inf-dl dt {
            color: var(--inf-faint);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .inf-dl dd {
            margin: 0.25rem 0 0;
            color: #1e293b;
            font-size: 0.9375rem;
            font-weight: 600;
            overflow-wrap: anywhere;
            font-variant-numeric: tabular-nums;
        }

        .inf-unit {
            margin-left: 0.125rem;
            color: var(--inf-muted);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .inf-empty-value {
            color: var(--inf-faint);
            font-weight: 500;
        }

        /* ---------- Stat tiles ---------- */

        .inf-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .inf-stat {
            display: block;
            min-width: 0;
            padding: 0.875rem 1rem;
            color: inherit;
            background: #ffffff;
            border: 1px solid var(--inf-line);
            border-radius: 1rem;
            text-decoration: none;
        }

        a.inf-stat:hover {
            border-color: var(--inf-pink-200);
            background: #fffafc;
        }

        .inf-stat-label {
            margin: 0;
            color: var(--inf-muted);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .inf-stat-value {
            margin: 0.25rem 0 0;
            color: var(--inf-ink);
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 1.75rem;
            line-height: 1.1;
        }

        .inf-stat-note {
            margin: 0.25rem 0 0;
            color: var(--inf-faint);
            font-size: 0.75rem;
        }

        .inf-stat-alert .inf-stat-value,
        .inf-stat-alert .inf-stat-note { color: #b91c1c; }
        .inf-stat-warn .inf-stat-value,
        .inf-stat-warn .inf-stat-note { color: #b45309; }

        /* ---------- Measurement tiles ---------- */

        .inf-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .inf-metric {
            min-width: 0;
            padding: 0.875rem 1rem;
            background: #fdfafc;
            border: 1px solid var(--inf-line-soft);
            border-radius: 0.875rem;
        }

        .inf-metric-label {
            margin: 0;
            color: var(--inf-muted);
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .inf-metric-value {
            margin: 0.25rem 0 0;
            color: var(--inf-ink);
            font-size: 1.375rem;
            font-weight: 700;
            line-height: 1.2;
            font-variant-numeric: tabular-nums;
        }

        .inf-metric-note {
            margin: 0.25rem 0 0;
            color: var(--inf-muted);
            font-size: 0.75rem;
        }

        .inf-metric-up { color: #047857; }

        /* ---------- Notes / remarks ---------- */

        .inf-note {
            margin: 0;
            padding: 0.875rem 1rem;
            color: #1e293b;
            background: #fffdf5;
            border: 1px solid #fde7c2;
            border-radius: 0.875rem;
            font-size: 0.875rem;
            line-height: 1.6;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .inf-note-plain {
            background: #fdfafc;
            border-color: var(--inf-line-soft);
        }

        .inf-empty {
            padding: 1.5rem 1rem;
            text-align: center;
            background: #fffafc;
            border: 1px dashed #f3cfe0;
            border-radius: 0.875rem;
        }

        .inf-empty strong {
            display: block;
            color: var(--inf-ink);
            font-size: 0.9375rem;
        }

        .inf-empty p {
            margin: 0.25rem 0 0;
            color: var(--inf-muted);
            font-size: 0.8125rem;
        }

        .inf-empty .inf-btn {
            margin-top: 0.875rem;
        }

        /* ---------- Responsive record table (cards on phones) ---------- */

        .inf-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
        }

        .inf-table th {
            padding: 0.625rem 0.875rem;
            color: var(--inf-muted);
            background: #fdf8fa;
            border-bottom: 1px solid var(--inf-line);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .inf-table th:first-child { border-top-left-radius: 0.75rem; }
        .inf-table th:last-child { border-top-right-radius: 0.75rem; }

        .inf-table td {
            padding: 0.75rem 0.875rem;
            color: #1e293b;
            border-bottom: 1px solid var(--inf-line-soft);
            font-variant-numeric: tabular-nums;
            vertical-align: middle;
        }

        .inf-table tr:last-child td {
            border-bottom: 0;
        }

        .inf-table .inf-cell-action {
            text-align: right;
        }

        .inf-table-wrap {
            border: 1px solid var(--inf-line);
            border-radius: 0.875rem;
            overflow: hidden;
        }

        /* ---------- Vaccination timeline ---------- */

        .inf-timeline {
            display: grid;
            gap: 0.625rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .inf-dose {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            background: #ffffff;
            border: 1px solid var(--inf-line);
            border-left-width: 4px;
            border-radius: 0.875rem;
        }

        .inf-dose-overdue { border-left-color: #ef4444; background: #fffafa; }
        .inf-dose-upcoming { border-left-color: #f59e0b; background: #fffdf7; }
        .inf-dose-done { border-left-color: #f0abc9; }

        .inf-dose-main {
            min-width: 0;
        }

        .inf-dose-name {
            margin: 0;
            color: var(--inf-ink);
            font-size: 0.9375rem;
            font-weight: 600;
        }

        .inf-dose-name span {
            color: var(--inf-muted);
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .inf-dose-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.375rem 0.75rem;
            margin-top: 0.375rem;
            color: var(--inf-muted);
            font-size: 0.8125rem;
        }

        /* ---------- Chart ---------- */

        .inf-chart {
            position: relative;
            height: 18rem;
            margin-top: 0.25rem;
        }

        .inf-chart-note {
            margin: 0.5rem 0 0;
            color: var(--inf-muted);
            font-size: 0.75rem;
        }

        /* ---------- Two-column layout ---------- */

        .inf-split {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .inf-split > .inf-card {
            margin-top: 0;
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 900px) {
            .inf-split {
                grid-template-columns: minmax(0, 1fr);
            }

            .inf-stats,
            .inf-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .inf-grid-3,
            .inf-dl {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .inf-container {
                width: min(100% - 1.5rem, 72rem);
            }

            .inf-card {
                padding: 1rem;
            }

            .inf-banner {
                padding: 0.875rem 1rem;
            }

            .inf-banner-facts {
                width: 100%;
            }

            .inf-fact {
                flex: 1 1 8rem;
            }

            .inf-grid,
            .inf-grid-3 {
                grid-template-columns: minmax(0, 1fr);
            }

            .inf-dl,
            .inf-dl-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.5rem;
            }

            .inf-head-actions,
            .inf-actions-buttons {
                width: 100%;
            }

            .inf-head-actions .inf-btn,
            .inf-head-actions form,
            .inf-actions-buttons .inf-btn,
            .inf-actions-buttons form {
                flex: 1 1 100%;
            }

            .inf-head-actions form .inf-btn,
            .inf-actions-buttons form .inf-btn {
                width: 100%;
            }

            .inf-card-actions,
            .inf-card-actions .inf-btn {
                width: 100%;
            }

            .inf-chart {
                height: 15rem;
            }

            /* History tables become stacked cards: no sideways scrolling. */
            .inf-table-wrap {
                border: 0;
                border-radius: 0;
                overflow: visible;
            }

            .inf-table,
            .inf-table tbody,
            .inf-table tr,
            .inf-table td {
                display: block;
                width: 100%;
            }

            .inf-table thead {
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
            }

            .inf-table tr {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.5rem 0.75rem;
                margin-bottom: 0.625rem;
                padding: 0.875rem 1rem;
                background: #ffffff;
                border: 1px solid var(--inf-line);
                border-radius: 0.875rem;
            }

            .inf-table td {
                padding: 0;
                border: 0;
            }

            .inf-table td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 0.125rem;
                color: var(--inf-faint);
                font-size: 0.625rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .inf-table td.inf-cell-title {
                grid-column: 1 / -1;
                font-weight: 600;
            }

            .inf-table td.inf-cell-action {
                grid-column: 1 / -1;
                text-align: left;
            }

            .inf-table td.inf-cell-action::before {
                display: none;
            }

            .inf-table td.inf-cell-action .inf-btn {
                width: 100%;
            }
        }

        @media (max-width: 359px) {
            .inf-dl,
            .inf-dl-2,
            .inf-stats,
            .inf-metrics {
                grid-template-columns: minmax(0, 1fr);
            }
        }
    </style>
@endonce
