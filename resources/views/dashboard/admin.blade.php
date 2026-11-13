<x-app-layout>

    {{-- =============================================================
         ADMINISTRATOR DASHBOARD — scoped presentation styles
         Inline (pushed after the compiled CSS) so no Vite rebuild is
         needed. All rules are scoped to .adm-wrap and affect only this
         page. Palette: CareCradle pink / blush / white / deep rose.
         ============================================================= --}}
    @push('styles')
    <style>
        .adm-wrap {
            --adm-pink: #db2777;
            --adm-rose: #be185d;
            --adm-deep: #9d174d;
            --adm-plum: #4a0d2a;
            --adm-blush: #fdf2f8;
            --adm-blush-2: #fce7f3;
            --adm-line: #f6d9e7;
            --adm-ink: #1e293b;
            --adm-muted: #64748b;
            --adm-radius: 18px;
            --adm-shadow: 0 2px 6px rgba(131, 24, 67, 0.04), 0 10px 28px rgba(131, 24, 67, 0.06);
            --adm-shadow-hover: 0 4px 10px rgba(131, 24, 67, 0.06), 0 16px 36px rgba(131, 24, 67, 0.10);
            --adm-serif: "DM Serif Display", Georgia, serif;
            --adm-sans: "Inter", ui-sans-serif, system-ui, sans-serif;

            min-height: 100%;
            color: var(--adm-ink);
            font-family: var(--adm-sans);
            background:
                radial-gradient(1200px 520px at 100% -10%, rgba(252, 231, 243, 0.85), transparent 60%),
                radial-gradient(900px 480px at -10% 30%, rgba(253, 242, 248, 0.9), transparent 60%),
                linear-gradient(180deg, #fffafc 0%, #fff7fb 100%);
        }

        .adm-wrap *,
        .adm-wrap *::before,
        .adm-wrap *::after {
            box-sizing: border-box;
        }

        .adm-container {
            display: flex;
            flex-direction: column;
            gap: clamp(1.75rem, 3vw, 2.5rem);
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 2.2vw, 2rem);
        }

        /* ---------- Welcome banner ---------- */
        .adm-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            min-height: 168px;
            padding: clamp(1.4rem, 3vw, 2.25rem) clamp(1.25rem, 3vw, 2.25rem);
            overflow: hidden;
            border: 1px solid var(--adm-line);
            border-radius: calc(var(--adm-radius) + 6px);
            background:
                linear-gradient(90deg,
                    #ffffff 0%,
                    rgba(255, 255, 255, 0.97) 42%,
                    rgba(253, 242, 248, 0.74) 64%,
                    rgba(252, 231, 243, 0.28) 100%),
                /* Official RHU building photo: upper floor and entrance band. */
                var(--cc-rhu-image) center 38% / cover no-repeat,
                #ffffff;
            box-shadow: var(--adm-shadow);
        }

        .adm-hero::after {
            content: "";
            position: absolute;
            right: -60px;
            bottom: -90px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(244, 114, 182, 0.18), transparent 70%);
            pointer-events: none;
        }

        .adm-hero-main {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 1.1rem;
            min-width: 0;
        }

        .adm-hero-logo {
            flex: 0 0 64px;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
            border: 1px solid var(--adm-line);
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.14);
        }

        /* Official Irosin RHU badge: the Mother Portal badge itself
           (.mdb-hero-institution / .mdb-hero-logo in mother-dashboard-polish.css),
           placed bottom-right as on the Mother dashboard. Only its two colour
           tokens are supplied here (Mother values) and its position. */
        .adm-hero .mdb-hero-institution {
            --mdb-muted: #6b6470;
            --mdb-line: #f0e4e8;
            position: absolute;
            right: clamp(1.25rem, 3vw, 2.25rem);
            bottom: clamp(0.9rem, 1.6vw, 1.25rem);
            z-index: 1;
            margin: 0;
        }

        .adm-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            margin: 0 0 0.45rem;
            color: var(--adm-rose);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .adm-eyebrow::before {
            content: "";
            width: 22px;
            height: 2px;
            border-radius: 2px;
            background: #f472b6;
        }

        .adm-hero-title {
            margin: 0;
            color: var(--adm-plum);
            font-family: var(--adm-serif);
            font-size: clamp(1.6rem, 2.8vw, 2.35rem);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.02em;
            overflow-wrap: anywhere;
        }

        .adm-hero-title em {
            color: var(--adm-rose);
        }

        .adm-hero-sub {
            margin: 0.5rem 0 0;
            max-width: 46ch;
            color: var(--adm-muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .adm-date {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            flex: 0 0 auto;
            align-self: flex-start;
            padding: 0.6rem 0.95rem;
            color: var(--adm-deep);
            font-size: 0.78rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--adm-line);
            border-radius: 999px;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.06);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .adm-date svg {
            width: 16px;
            height: 16px;
            color: var(--adm-pink);
        }

        /* ---------- Section headings ---------- */
        .adm-section-head {
            margin-bottom: 1rem;
        }

        .adm-section-title {
            margin: 0;
            color: var(--adm-plum);
            font-family: var(--adm-serif);
            font-size: clamp(1.3rem, 1.9vw, 1.55rem);
            font-weight: 400;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .adm-section-sub {
            margin: 0.25rem 0 0;
            color: var(--adm-muted);
            font-size: 0.84rem;
            line-height: 1.55;
        }

        /* ---------- Statistics: five consistent cards ---------- */
        .adm-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .adm-stat {
            --tone: var(--adm-pink);
            --tone-soft: var(--adm-blush);
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            min-width: 0;
            padding: 1.2rem 1.2rem 1.15rem;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--adm-line);
            border-radius: var(--adm-radius);
            box-shadow: var(--adm-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .adm-stat::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 3px;
            background: linear-gradient(90deg, var(--tone), rgba(244, 114, 182, 0.35));
        }

        .adm-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: var(--tone);
            background: var(--tone-soft);
            border-radius: 14px;
        }

        .adm-stat-icon svg {
            width: 22px;
            height: 22px;
        }

        .adm-stat-value {
            margin: 0;
            color: var(--adm-plum);
            font-family: var(--adm-serif);
            font-size: clamp(2rem, 2.6vw, 2.5rem);
            font-weight: 400;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .adm-stat-label {
            margin: 0.35rem 0 0;
            color: var(--adm-muted);
            font-size: 0.8rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .adm-tone-1 { --tone: #db2777; --tone-soft: #fdf2f8; }
        .adm-tone-2 { --tone: #e11d48; --tone-soft: #fff1f2; }
        .adm-tone-3 { --tone: #be185d; --tone-soft: #fce7f3; }
        .adm-tone-4 { --tone: #9d174d; --tone-soft: #fdf2f8; }
        .adm-tone-5 { --tone: #c2185b; --tone-soft: #fff0f6; }

        /* ---------- Quick actions ---------- */
        .adm-actions {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 0.9rem;
        }

        @media (min-width: 768px) {
            .adm-actions {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .adm-action {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            min-width: 0;
            padding: 1.4rem 1.35rem 1.25rem;
            color: inherit;
            text-decoration: none;
            background: linear-gradient(160deg, #ffffff 0%, #fffafd 100%);
            border: 1px solid var(--adm-line);
            border-radius: var(--adm-radius);
            box-shadow: var(--adm-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .adm-action-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 0.35rem;
            color: #ffffff;
            background: linear-gradient(135deg, var(--adm-rose) 0%, var(--adm-pink) 100%);
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(219, 39, 119, 0.22);
        }

        .adm-action-icon svg {
            width: 23px;
            height: 23px;
        }

        .adm-action-name {
            margin: 0;
            color: var(--adm-plum);
            font-family: var(--adm-serif);
            font-size: 1.22rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .adm-action-desc {
            flex: 1 1 auto;
            margin: 0;
            color: var(--adm-muted);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .adm-action-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-top: 0.4rem;
            color: var(--adm-rose);
            font-size: 0.82rem;
            font-weight: 700;
            transition: gap 0.2s ease;
        }

        .adm-action-cta svg {
            width: 16px;
            height: 16px;
        }

        .adm-action:focus-visible {
            outline: 3px solid rgba(219, 39, 119, 0.35);
            outline-offset: 3px;
        }

        @media (hover: hover) and (pointer: fine) {
            .adm-stat:hover,
            .adm-action:hover {
                transform: translateY(-2px);
                border-color: #f9a8d4;
                box-shadow: var(--adm-shadow-hover);
            }

            .adm-action:hover .adm-action-cta {
                gap: 0.7rem;
            }
        }

        /* ---------- System insights ---------- */
        .adm-insights {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.5rem;
        }

        .adm-panel {
            min-width: 0;
        }

        .adm-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.7rem;
        }

        .adm-panel-head h3 {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 0;
            color: var(--adm-plum);
            font-family: var(--adm-serif);
            font-size: 1.15rem;
            font-weight: 400;
            line-height: 1.3;
        }

        .adm-panel-head h3 svg {
            width: 18px;
            height: 18px;
            color: var(--adm-pink);
        }

        .adm-count {
            flex: 0 0 auto;
            padding: 0.25rem 0.65rem;
            color: var(--adm-deep);
            font-size: 0.7rem;
            font-weight: 700;
            background: var(--adm-blush-2);
            border-radius: 999px;
        }

        .adm-table-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--adm-line);
            border-radius: var(--adm-radius);
            box-shadow: var(--adm-shadow);
        }

        .adm-table-scroll {
            width: 100%;
            overflow-x: auto;
        }

        table.adm-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.86rem;
        }

        table.adm-table thead th {
            padding: 0.8rem 1.15rem;
            color: var(--adm-deep);
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
            background: #fff7fb;
            border-bottom: 1px solid var(--adm-line);
        }

        table.adm-table tbody td {
            padding: 0.9rem 1.15rem;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #fbeef4;
        }

        table.adm-table tbody tr:last-child td {
            border-bottom: 0;
        }

        table.adm-table tbody tr {
            transition: background 0.15s ease;
        }

        table.adm-table tbody tr:hover {
            background: #fffafd;
        }

        .adm-strong {
            color: var(--adm-ink);
            font-weight: 600;
        }

        .adm-muted {
            color: var(--adm-muted);
        }

        .adm-time {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--adm-rose);
            font-weight: 700;
            white-space: nowrap;
        }

        .adm-time svg {
            width: 14px;
            height: 14px;
        }

        .adm-chip {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            color: #475569;
            font-size: 0.76rem;
            font-weight: 600;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            white-space: nowrap;
        }

        .adm-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.65rem;
            font-size: 0.74rem;
            font-weight: 700;
            border-radius: 999px;
            white-space: nowrap;
        }

        .adm-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Status colours keep their meaning (scheduled / completed / cancelled / missed) */
        .ad-pill-blue    { color: #1d4ed8; background: #eff6ff; }
        .ad-pill-emerald { color: #047857; background: #ecfdf5; }
        .ad-pill-rose    { color: #be123c; background: #fff1f2; }
        .ad-pill-amber   { color: #b45309; background: #fffbeb; }
        .ad-pill-slate   { color: #475569; background: #f1f5f9; }
        .adm-pill-date   { color: var(--adm-deep); background: var(--adm-blush); border: 1px solid var(--adm-line); }

        /* Empty states (unchanged wording) */
        .adm-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.25rem;
            text-align: center;
        }

        .adm-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin-bottom: 0.8rem;
            color: var(--adm-pink);
            background: var(--adm-blush);
            border-radius: 16px;
        }

        .adm-empty-icon svg {
            width: 24px;
            height: 24px;
        }

        .adm-empty-title {
            margin: 0;
            color: var(--adm-plum);
            font-weight: 700;
            font-size: 0.95rem;
        }

        .adm-empty-sub {
            max-width: 42ch;
            margin: 0.3rem 0 0;
            color: var(--adm-muted);
            font-size: 0.82rem;
            line-height: 1.55;
        }

        /* ---------- System footer ---------- */
        .adm-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.15rem 1.35rem;
            background: #ffffff;
            border: 1px solid var(--adm-line);
            border-radius: var(--adm-radius);
            box-shadow: var(--adm-shadow);
        }

        .adm-footer-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-width: 0;
        }

        .adm-footer-brand img {
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--adm-line);
        }

        .adm-footer-name {
            margin: 0;
            color: var(--adm-plum);
            font-size: 0.86rem;
            font-weight: 700;
        }

        .adm-footer-sub {
            margin: 0.15rem 0 0;
            color: var(--adm-muted);
            font-size: 0.76rem;
        }

        .adm-footer-version {
            color: var(--adm-muted);
            font-size: 0.76rem;
            line-height: 1.6;
        }

        .adm-footer-version strong {
            display: block;
            color: var(--adm-rose);
            font-size: 0.8rem;
        }

        /* ---------- Responsive ---------- */
        @media (min-width: 640px) {
            .adm-footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .adm-footer-version {
                text-align: right;
            }
        }

        /* Tablet / small laptop: 3 + 2 statistics */
        @media (min-width: 768px) {
            .adm-stats {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .adm-stats > .adm-stat {
                grid-column: span 2;
            }

            .adm-stats > .adm-stat:nth-child(4),
            .adm-stats > .adm-stat:nth-child(5) {
                grid-column: span 3;
            }
        }

        /* Wide desktop: all five statistics in one row,
           and the two smaller insight tables side by side */
        @media (min-width: 1280px) {
            .adm-stats {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }

            .adm-stats > .adm-stat,
            .adm-stats > .adm-stat:nth-child(4),
            .adm-stats > .adm-stat:nth-child(5) {
                grid-column: auto;
            }

            .adm-insights {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .adm-insights > .adm-panel-wide {
                grid-column: 1 / -1;
            }
        }

        /* Phones */
        @media (max-width: 767px) {
            .adm-hero {
                flex-direction: column;
                align-items: flex-start;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, rgba(253, 242, 248, 0.90) 100%),
                    var(--cc-rhu-image) center 38% / cover no-repeat,
                    #ffffff;
            }

            .adm-hero-main {
                align-items: flex-start;
            }

            .adm-hero-logo {
                flex-basis: 52px;
                width: 52px;
                height: 52px;
            }

            .adm-date {
                align-self: flex-start;
            }

            /* Phones: below the date, left-aligned (as on the Mother dashboard). */
            .adm-hero .mdb-hero-institution {
                position: static;
                align-self: flex-start;
            }

            .adm-stats > .adm-stat:last-child {
                grid-column: 1 / -1;
            }
        }

        /* Phones: tables become stacked cards so every field stays visible */
        @media (max-width: 639px) {
            .adm-table-scroll {
                overflow-x: visible;
            }

            table.adm-table thead {
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                clip: rect(0 0 0 0);
                white-space: nowrap;
            }

            table.adm-table,
            table.adm-table tbody,
            table.adm-table tr,
            table.adm-table td {
                display: block;
                width: 100%;
            }

            table.adm-table tbody tr {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #fbeef4;
            }

            table.adm-table tbody tr:last-child {
                border-bottom: 0;
            }

            table.adm-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.35rem 0;
                border-bottom: 0;
                text-align: right;
            }

            table.adm-table tbody td::before {
                content: attr(data-label);
                flex: 0 0 auto;
                color: var(--adm-muted);
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-align: left;
                text-transform: uppercase;
            }

            .adm-stat {
                padding: 1rem;
            }

            .adm-stat-icon {
                width: 40px;
                height: 40px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .adm-stat,
            .adm-action,
            .adm-action-cta,
            table.adm-table tbody tr {
                transition: none;
            }
        }
    </style>
    @endpush

    <div class="adm-wrap py-6 sm:py-8"
         style="--cc-rhu-image: url('{{ asset('images/irosin-rhu-building.png') }}');">

        <div class="adm-container">

            {{-- ====================================== --}}
            {{-- 1. Welcome banner                      --}}
            {{-- ====================================== --}}
            <header class="adm-hero">
                <div class="adm-hero-main">
                    <div>
                        <p class="adm-eyebrow">Administrator Portal</p>
                        <h1 class="adm-hero-title">Welcome back, <em>{{ Auth::user()->name }}</em></h1>
                        <p class="adm-hero-sub">Centralized management of maternal and infant healthcare services.</p>
                    </div>
                </div>

                <div class="adm-date" aria-label="Current date">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>
                    </svg>
                    <span>{{ now()->format('l, F d, Y') }}</span>
                </div>

                {{-- Secondary institutional identity (same badge as the Mother dashboard). --}}
                <p class="mdb-hero-institution">
                    <img class="mdb-hero-logo" src="{{ asset('images/irosin-rhu-logo.jpg') }}" alt="Irosin Rural Health Unit logo" width="26" height="26">
                    <span>Irosin Rural Health Unit</span>
                </p>
            </header>

            {{-- ====================================== --}}
            {{-- 2. System Overview (five statistics)   --}}
            {{-- ====================================== --}}
            <section aria-labelledby="adm-overview-title">
                <div class="adm-section-head">
                    <h2 class="adm-section-title" id="adm-overview-title">System Overview</h2>
                    <p class="adm-section-sub">Real-time summary of CareCradle records and healthcare services.</p>
                </div>

                <div class="adm-stats">
                    {{-- Mothers --}}
                    <div class="adm-stat adm-tone-1">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $mothers }}</p>
                            <p class="adm-stat-label">Registered Mothers</p>
                        </div>
                    </div>

                    {{-- Infants --}}
                    <div class="adm-stat adm-tone-2">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="8.5"/>
                                <path d="M9.2 11h.01M14.8 11h.01M9.5 14.5c1.4 1.2 3.6 1.2 5 0"/>
                                <path d="M12 3.5c-1.4 0-2 1.2-1.2 2.2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $infants }}</p>
                            <p class="adm-stat-label">Registered Infants</p>
                        </div>
                    </div>

                    {{-- Midwives (same icon as the sidebar) --}}
                    <div class="adm-stat adm-tone-3">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $midwives }}</p>
                            <p class="adm-stat-label">Registered Midwives</p>
                        </div>
                    </div>

                    {{-- Upcoming appointments --}}
                    <div class="adm-stat adm-tone-4">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $appointments }}</p>
                            <p class="adm-stat-label">Upcoming Appointments</p>
                        </div>
                    </div>

                    {{-- Vaccinations administered --}}
                    <div class="adm-stat adm-tone-5">
                        <div class="adm-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/>
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="adm-stat-value">{{ $vaccinations }}</p>
                            <p class="adm-stat-label">Vaccinations Administered</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 3. Quick Actions                       --}}
            {{-- ====================================== --}}
            <section aria-labelledby="adm-actions-title">
                <div class="adm-section-head">
                    <h2 class="adm-section-title" id="adm-actions-title">Quick Actions</h2>
                    <p class="adm-section-sub">Manage users and administrative reports for the CareCradle EMR.</p>
                </div>

                <div class="adm-actions">
                    <a href="{{ route('midwives.index') }}" class="adm-action" aria-label="Open Midwife Management">
                        <span class="adm-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </span>
                        <p class="adm-action-name">Midwife Management</p>
                        <p class="adm-action-desc">Manage registered midwives and their access to the CareCradle system.</p>
                        <span class="adm-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="adm-action" aria-label="Open Reports">
                        <span class="adm-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V5m0 14h16M8 15v-4m4 4V7m4 8V9"/>
                            </svg>
                        </span>
                        <p class="adm-action-name">Reports</p>
                        <p class="adm-action-desc">View and generate maternal, infant, appointment, and vaccination reports.</p>
                        <span class="adm-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}" class="adm-action" aria-label="Open Activity Logs">
                        <span class="adm-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 5h16M4 12h16M4 19h10"/>
                            </svg>
                        </span>
                        <p class="adm-action-name">Activity Logs</p>
                        <p class="adm-action-desc">Review recorded system activity for accountability and auditing.</p>
                        <span class="adm-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </a>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 4. System Insights                     --}}
            {{-- ====================================== --}}
            <section aria-labelledby="adm-insights-title">
                <div class="adm-section-head">
                    <h2 class="adm-section-title" id="adm-insights-title">System Insights</h2>
                    <p class="adm-section-sub">Live operational detail behind the summary statistics above.</p>
                </div>

                <div class="adm-insights">

                    {{-- Today's Appointments --}}
                    <div class="adm-panel adm-panel-wide">
                        <div class="adm-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Today's Appointments
                            </h3>
                            <span class="adm-count">{{ $todayAppointments->count() }} today</span>
                        </div>

                        <div class="adm-table-card">
                            @if($todayAppointments->count())
                                @php
                                    $statusPill = fn($s) => match($s) {
                                        'Scheduled' => 'ad-pill-blue',
                                        'Completed' => 'ad-pill-emerald',
                                        'Cancelled' => 'ad-pill-rose',
                                        'Missed'    => 'ad-pill-amber',
                                        default     => 'ad-pill-slate',
                                    };
                                @endphp

                                <div class="adm-table-scroll">
                                    <table class="adm-table">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Mother</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($todayAppointments as $appointment)
                                                <tr>
                                                    <td data-label="Time">
                                                        <span class="adm-time">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                        </span>
                                                    </td>
                                                    <td data-label="Mother" class="adm-strong">
                                                        {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}
                                                    </td>
                                                    <td data-label="Type">
                                                        <span class="adm-chip">{{ $appointment->appointment_type }}</span>
                                                    </td>
                                                    <td data-label="Status">
                                                        <span class="adm-pill {{ $statusPill($appointment->status) }}">
                                                            <span class="adm-pill-dot"></span>
                                                            {{ $appointment->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="adm-empty">
                                    <div class="adm-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    </div>
                                    <p class="adm-empty-title">No Appointments Today</p>
                                    <p class="adm-empty-sub">There are no scheduled maternal appointments for today.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Upcoming Vaccinations --}}
                    <div class="adm-panel">
                        <div class="adm-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                                Upcoming Vaccinations
                            </h3>
                            <span class="adm-count">{{ $upcomingVaccinations->count() }} upcoming</span>
                        </div>

                        <div class="adm-table-card">
                            @if($upcomingVaccinations->count())
                                <div class="adm-table-scroll">
                                    <table class="adm-table">
                                        <thead>
                                            <tr>
                                                <th>Infant</th>
                                                <th>Vaccine</th>
                                                <th>Next Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($upcomingVaccinations as $vaccination)
                                                <tr>
                                                    <td data-label="Infant" class="adm-strong">
                                                        {{ $vaccination->infant->first_name }} {{ $vaccination->infant->last_name }}
                                                    </td>
                                                    <td data-label="Vaccine" class="adm-muted">{{ $vaccination->vaccine_name }}</td>
                                                    <td data-label="Next Due Date">
                                                        <span class="adm-pill adm-pill-date">
                                                            {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="adm-empty">
                                    <div class="adm-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="adm-empty-title">No Upcoming Vaccinations</p>
                                    <p class="adm-empty-sub">Upcoming infant immunization schedules will appear here once vaccination records are available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Recent Infant Registrations --}}
                    <div class="adm-panel">
                        <div class="adm-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M9.2 11h.01M14.8 11h.01M9.5 14.5c1.4 1.2 3.6 1.2 5 0"/></svg>
                                Recent Infant Registrations
                            </h3>
                            <span class="adm-count">{{ $recentInfants->count() }} recent</span>
                        </div>

                        <div class="adm-table-card">
                            @if($recentInfants->count())
                                <div class="adm-table-scroll">
                                    <table class="adm-table">
                                        <thead>
                                            <tr>
                                                <th>Infant</th>
                                                <th>Mother</th>
                                                <th>Registration Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentInfants as $infant)
                                                <tr>
                                                    <td data-label="Infant" class="adm-strong">
                                                        {{ $infant->first_name }} {{ $infant->last_name }}
                                                    </td>
                                                    <td data-label="Mother" class="adm-muted">
                                                        {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
                                                    </td>
                                                    <td data-label="Registration Date">
                                                        <span class="adm-pill adm-pill-date">
                                                            {{ $infant->created_at->format('M d, Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="adm-empty">
                                    <div class="adm-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M9.2 11h.01M14.8 11h.01M9.5 14.5c1.4 1.2 3.6 1.2 5 0"/></svg>
                                    </div>
                                    <p class="adm-empty-title">No Infant Records Yet</p>
                                    <p class="adm-empty-sub">Newly registered infant records will appear here once patients are enrolled in the CareCradle system.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 5. System Information                  --}}
            {{-- ====================================== --}}
            <footer class="adm-footer">
                <div class="adm-footer-brand">
                    <img src="{{ asset('images/system.logo.png') }}" alt="" aria-hidden="true">
                    <div>
                        <p class="adm-footer-name">CareCradle Maternal &amp; Infant Health Monitoring System</p>
                        <p class="adm-footer-sub">Rural Health Unit Electronic Maternal and Infant Records Management</p>
                    </div>
                </div>

                <div class="adm-footer-version">
                    <strong>Version 1.0 &middot; Administrator Dashboard</strong>
                    &copy; {{ date('Y') }} Irosin Rural Health Unit. All Rights Reserved.
                </div>
            </footer>

        </div>
    </div>

</x-app-layout>
