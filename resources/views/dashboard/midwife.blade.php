<x-app-layout>

    {{-- =============================================================
         MIDWIFE DASHBOARD — scoped presentation styles
         Inline (pushed after the compiled CSS) so no Vite rebuild is
         needed, following the Administrator Dashboard. Every rule is
         scoped to .mwd-wrap and affects only this page.
         Palette: CareCradle pink / blush / white / deep rose.
         Attention accents: amber (status review), rose (overdue),
         teal (due soon) — used only on small badges and text.
         ============================================================= --}}
    @push('styles')
    <style>
        .mwd-wrap {
            --mwd-pink: #db2777;
            --mwd-rose: #be185d;
            --mwd-deep: #9d174d;
            --mwd-plum: #4a0d2a;
            --mwd-blush: #fdf2f8;
            --mwd-blush-2: #fce7f3;
            --mwd-line: #f6d9e7;
            --mwd-ink: #1e293b;
            --mwd-muted: #64748b;
            --mwd-radius: 18px;
            --mwd-radius-sm: 12px;
            --mwd-shadow: 0 2px 6px rgba(131, 24, 67, 0.04), 0 10px 28px rgba(131, 24, 67, 0.06);
            --mwd-shadow-hover: 0 4px 10px rgba(131, 24, 67, 0.06), 0 16px 36px rgba(131, 24, 67, 0.10);
            --mwd-serif: "DM Serif Display", Georgia, serif;
            --mwd-sans: "Inter", ui-sans-serif, system-ui, sans-serif;

            min-height: 100%;
            color: var(--mwd-ink);
            font-family: var(--mwd-sans);
            background:
                radial-gradient(1200px 520px at 100% -10%, rgba(252, 231, 243, 0.85), transparent 60%),
                radial-gradient(900px 480px at -10% 30%, rgba(253, 242, 248, 0.9), transparent 60%),
                linear-gradient(180deg, #fffafc 0%, #fff7fb 100%);
        }

        .mwd-wrap *,
        .mwd-wrap *::before,
        .mwd-wrap *::after {
            box-sizing: border-box;
        }

        .mwd-wrap p,
        .mwd-wrap h1,
        .mwd-wrap h2,
        .mwd-wrap h3 {
            margin: 0;
        }

        .mwd-wrap svg {
            flex-shrink: 0;
        }

        .mwd-container {
            display: flex;
            flex-direction: column;
            gap: clamp(1.75rem, 3vw, 2.5rem);
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 2.2vw, 2rem);
        }

        /* ---------- Welcome hero ---------- */
        .mwd-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            min-height: 168px;
            padding: clamp(1.4rem, 3vw, 2.25rem) clamp(1.25rem, 3vw, 2.25rem);
            overflow: hidden;
            border: 1px solid var(--mwd-line);
            border-radius: calc(var(--mwd-radius) + 6px);
            background:
                linear-gradient(90deg,
                    #ffffff 0%,
                    rgba(255, 255, 255, 0.97) 42%,
                    rgba(253, 242, 248, 0.74) 64%,
                    rgba(252, 231, 243, 0.28) 100%),
                /* Official RHU building photo: upper floor and entrance band. */
                var(--cc-rhu-image) center 38% / cover no-repeat,
                #ffffff;
            box-shadow: var(--mwd-shadow);
        }

        .mwd-hero::after {
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

        .mwd-hero-main {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 1.1rem;
            min-width: 0;
        }

        .mwd-hero-logo {
            flex: 0 0 64px;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            background: #ffffff;
            border: 1px solid var(--mwd-line);
            box-shadow: 0 6px 18px rgba(190, 24, 93, 0.14);
        }

        /* Official Irosin RHU badge: the Mother Portal badge itself
           (.mdb-hero-institution / .mdb-hero-logo in mother-dashboard-polish.css),
           placed bottom-right as on the Mother dashboard. Only its two colour
           tokens are supplied here (Mother values) and its position. */
        .mwd-hero .mdb-hero-institution {
            --mdb-muted: #6b6470;
            --mdb-line: #f0e4e8;
            position: absolute;
            right: clamp(1.25rem, 3vw, 2.25rem);
            bottom: clamp(0.9rem, 1.6vw, 1.25rem);
            z-index: 1;
            margin: 0;
        }

        .mwd-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            margin: 0 0 0.45rem !important;
            color: var(--mwd-rose);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .mwd-eyebrow::before {
            content: "";
            width: 22px;
            height: 2px;
            border-radius: 2px;
            background: #f472b6;
        }

        .mwd-hero-title {
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: clamp(1.6rem, 2.8vw, 2.35rem);
            font-weight: 400;
            line-height: 1.15;
            letter-spacing: -0.02em;
            overflow-wrap: anywhere;
        }

        .mwd-hero-title em {
            color: var(--mwd-rose);
        }

        .mwd-hero-sub {
            margin-top: 0.5rem !important;
            max-width: 52ch;
            color: var(--mwd-muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .mwd-date {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            flex: 0 0 auto;
            align-self: flex-start;
            padding: 0.6rem 0.95rem;
            color: var(--mwd-deep);
            font-size: 0.78rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--mwd-line);
            border-radius: 999px;
            box-shadow: 0 4px 12px rgba(190, 24, 93, 0.06);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .mwd-date svg {
            width: 16px;
            height: 16px;
            color: var(--mwd-pink);
        }

        /* ---------- Section headings ---------- */
        .mwd-section-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .mwd-section-title {
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: clamp(1.3rem, 1.9vw, 1.55rem);
            font-weight: 400;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .mwd-section-sub {
            margin-top: 0.25rem !important;
            color: var(--mwd-muted);
            font-size: 0.84rem;
            line-height: 1.55;
        }

        /* ---------- Statistics ---------- */
        .mwd-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .mwd-stat {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            min-width: 0;
            padding: 1.2rem 1.2rem 1.15rem;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--mwd-line);
            border-radius: var(--mwd-radius);
            box-shadow: var(--mwd-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .mwd-stat::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 3px;
            background: linear-gradient(90deg, var(--mwd-pink), rgba(244, 114, 182, 0.35));
        }

        .mwd-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            color: var(--mwd-pink);
            background: var(--mwd-blush);
            border-radius: 14px;
        }

        .mwd-stat-icon svg {
            width: 22px;
            height: 22px;
        }

        .mwd-stat-value {
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: clamp(2rem, 2.6vw, 2.5rem);
            font-weight: 400;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .mwd-stat-label {
            margin-top: 0.35rem !important;
            color: var(--mwd-muted);
            font-size: 0.8rem;
            font-weight: 600;
            line-height: 1.4;
        }

        /* ---------- Attention required ---------- */
        .mwd-attn {
            container: mwdattn / inline-size;
            padding: 1.25rem 1.35rem 1.35rem;
            background: #ffffff;
            border: 1px solid var(--mwd-line);
            border-radius: var(--mwd-radius);
            box-shadow: var(--mwd-shadow);
        }

        .mwd-attn .mwd-section-head {
            align-items: flex-start;
        }

        .mwd-total {
            flex: 0 0 auto;
            padding: 0.3rem 0.75rem;
            color: var(--mwd-deep);
            font-size: 0.72rem;
            font-weight: 700;
            background: var(--mwd-blush-2);
            border-radius: 999px;
            white-space: nowrap;
        }

        .mwd-total.is-clear {
            color: #047857;
            background: #ecfdf5;
        }

        .mwd-attn-clear {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.9rem 1rem;
            background: #f6fcf9;
            border: 1px solid #d5efe3;
            border-radius: var(--mwd-radius-sm);
        }

        .mwd-attn-clear-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            color: #047857;
            background: #ffffff;
            border: 1px solid #d5efe3;
            border-radius: 11px;
        }

        .mwd-attn-clear-icon svg {
            width: 19px;
            height: 19px;
        }

        .mwd-attn-clear-title {
            color: #14533f;
            font-family: var(--mwd-serif);
            font-size: 1.05rem;
            font-weight: 400;
        }

        .mwd-attn-clear-sub {
            margin-top: 0.1rem !important;
            color: #4b6b5f;
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .mwd-attn-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
            align-items: start;
        }

        @container mwdattn (min-width: 860px) {
            .mwd-attn-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .mwd-attn-group {
            --accent: #b45309;
            --accent-soft: #fffbeb;
            --accent-line: #fde7c2;

            min-width: 0;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #f3e6ec;
            border-radius: 14px;
        }

        .mwd-attn-overdue {
            --accent: #be123c;
            --accent-soft: #fff1f2;
            --accent-line: #fecdd6;
        }

        .mwd-attn-soon {
            --accent: #0f766e;
            --accent-soft: #f0fdfa;
            --accent-line: #c5ece5;
        }

        .mwd-attn-group-head {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 0.65rem;
            padding: 0.8rem 0.9rem;
            background: #fffafc;
            border-bottom: 1px solid #f6e9ef;
        }

        .mwd-attn-group-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: var(--accent);
            background: var(--accent-soft);
            border-radius: 10px;
        }

        .mwd-attn-group-icon svg {
            width: 17px;
            height: 17px;
        }

        .mwd-attn-group-text {
            min-width: 0;
        }

        .mwd-attn-group-title {
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: 1.02rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .mwd-attn-group-sub {
            margin-top: 0.1rem !important;
            color: var(--mwd-muted);
            font-size: 0.72rem;
            line-height: 1.4;
        }

        .mwd-attn-count {
            min-width: 1.9rem;
            padding: 0.2rem 0.55rem;
            color: var(--accent);
            font-size: 0.74rem;
            font-weight: 800;
            text-align: center;
            background: var(--accent-soft);
            border: 1px solid var(--accent-line);
            border-radius: 999px;
        }

        .mwd-attn-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .mwd-attn-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            min-width: 0;
            padding: 0.7rem 0.9rem;
            border-bottom: 1px solid #f6edf1;
        }

        .mwd-attn-row:last-child {
            border-bottom: 0;
        }

        .mwd-attn-row-main {
            min-width: 0;
        }

        .mwd-attn-row-title {
            color: var(--mwd-ink);
            font-size: 0.83rem;
            font-weight: 700;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .mwd-tag {
            display: inline-block;
            margin-left: 0.3rem;
            padding: 0.05rem 0.45rem;
            color: #7b5a6a;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            vertical-align: 1px;
            background: #f8f1f4;
            border: 1px solid #efe1e8;
            border-radius: 999px;
            white-space: nowrap;
        }

        .mwd-attn-row-meta {
            margin-top: 0.15rem !important;
            color: var(--mwd-muted);
            font-size: 0.74rem;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        .mwd-attn-row-flag {
            margin-top: 0.2rem !important;
            color: var(--accent);
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 1.35;
        }

        .mwd-attn-row-link {
            flex: 0 0 auto;
            padding: 0.32rem 0.75rem;
            color: var(--accent);
            font-size: 0.72rem;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            background: #ffffff;
            border: 1px solid var(--accent-line);
            border-radius: 999px;
            transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        }

        .mwd-attn-row-link:hover {
            color: #ffffff;
            background: var(--accent);
            border-color: var(--accent);
        }

        .mwd-attn-empty {
            padding: 0.85rem 0.9rem;
            color: var(--mwd-muted);
            font-size: 0.78rem;
            line-height: 1.5;
        }

        .mwd-attn-group .mwd-more {
            display: block;
            padding: 0.65rem 0.9rem;
            color: var(--accent);
            border-top: 1px solid #f6edf1;
        }

        /* ---------- "+ N more" links ---------- */
        .mwd-more {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            max-width: 100%;
            color: var(--mwd-rose);
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
        }

        .mwd-more svg {
            width: 14px;
            height: 14px;
        }

        .mwd-more:hover {
            text-decoration: underline;
        }

        .mwd-card-foot {
            padding: 0.75rem 1.15rem;
            background: #fffafd;
            border-top: 1px solid #fbeef4;
        }

        .mwd-wrap a:focus-visible {
            outline: 3px solid rgba(219, 39, 119, 0.35);
            outline-offset: 2px;
        }

        /* ---------- Quick actions ---------- */
        .mwd-actions {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 0.9rem;
        }

        .mwd-action {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            min-width: 0;
            padding: 1.4rem 1.35rem 1.25rem;
            color: inherit;
            text-decoration: none;
            background: linear-gradient(160deg, #ffffff 0%, #fffafd 100%);
            border: 1px solid var(--mwd-line);
            border-radius: var(--mwd-radius);
            box-shadow: var(--mwd-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .mwd-action-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 0.35rem;
            color: #ffffff;
            background: linear-gradient(135deg, var(--mwd-rose) 0%, var(--mwd-pink) 100%);
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(219, 39, 119, 0.22);
        }

        .mwd-action-icon svg {
            width: 23px;
            height: 23px;
        }

        .mwd-action-name {
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: 1.22rem;
            font-weight: 400;
            line-height: 1.25;
        }

        .mwd-action-desc {
            flex: 1 1 auto;
            color: var(--mwd-muted);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .mwd-action-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-top: 0.4rem;
            color: var(--mwd-rose);
            font-size: 0.82rem;
            font-weight: 700;
            transition: gap 0.2s ease;
        }

        .mwd-action-cta svg {
            width: 16px;
            height: 16px;
        }

        .mwd-action:focus-visible {
            outline: 3px solid rgba(219, 39, 119, 0.35);
            outline-offset: 3px;
        }

        @media (hover: hover) and (pointer: fine) {
            .mwd-stat:hover,
            .mwd-action:hover {
                transform: translateY(-2px);
                border-color: #f9a8d4;
                box-shadow: var(--mwd-shadow-hover);
            }

            .mwd-action:hover .mwd-action-cta {
                gap: 0.7rem;
            }
        }

        /* ---------- Records: tables ---------- */
        .mwd-records {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.5rem;
        }

        .mwd-panel {
            min-width: 0;
        }

        .mwd-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.7rem;
        }

        .mwd-panel-head h3 {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--mwd-plum);
            font-family: var(--mwd-serif);
            font-size: 1.15rem;
            font-weight: 400;
            line-height: 1.3;
        }

        .mwd-panel-head h3 svg {
            width: 18px;
            height: 18px;
            color: var(--mwd-pink);
        }

        .mwd-count {
            flex: 0 0 auto;
            padding: 0.25rem 0.65rem;
            color: var(--mwd-deep);
            font-size: 0.7rem;
            font-weight: 700;
            background: var(--mwd-blush-2);
            border-radius: 999px;
            white-space: nowrap;
        }

        .mwd-table-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--mwd-line);
            border-radius: var(--mwd-radius);
            box-shadow: var(--mwd-shadow);
        }

        .mwd-card-summary {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.4rem;
            padding: 0.75rem 1.15rem;
            color: var(--mwd-muted);
            font-size: 0.78rem;
            font-weight: 600;
            background: #fffafd;
            border-bottom: 1px solid #fbeef4;
        }

        .mwd-table-scroll {
            width: 100%;
            overflow-x: auto;
        }

        table.mwd-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.86rem;
        }

        table.mwd-table thead th {
            padding: 0.8rem 1.15rem;
            color: var(--mwd-deep);
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
            background: #fff7fb;
            border-bottom: 1px solid var(--mwd-line);
        }

        table.mwd-table tbody td {
            padding: 0.85rem 1.15rem;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #fbeef4;
        }

        table.mwd-table tbody tr:last-child td {
            border-bottom: 0;
        }

        table.mwd-table tbody tr {
            transition: background 0.15s ease;
        }

        table.mwd-table tbody tr:hover {
            background: #fffafd;
        }

        .mwd-strong {
            color: var(--mwd-ink);
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .mwd-time {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--mwd-rose);
            font-weight: 700;
            white-space: nowrap;
        }

        .mwd-time svg {
            width: 14px;
            height: 14px;
        }

        .mwd-chip {
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

        .mwd-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.25rem 0.65rem;
            font-size: 0.74rem;
            font-weight: 700;
            border-radius: 999px;
            white-space: nowrap;
        }

        .mwd-pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Status colours keep their meaning (scheduled / completed / cancelled / missed). */
        .mwd-pill-blue    { color: #1d4ed8; background: #eff6ff; }
        .mwd-pill-emerald { color: #047857; background: #ecfdf5; }
        .mwd-pill-rose    { color: #be123c; background: #fff1f2; }
        .mwd-pill-amber   { color: #b45309; background: #fffbeb; }
        .mwd-pill-slate   { color: #475569; background: #f1f5f9; }
        .mwd-pill-date    { color: var(--mwd-deep); background: var(--mwd-blush); border: 1px solid var(--mwd-line); }

        /* Empty states (unchanged wording) */
        .mwd-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.25rem;
            text-align: center;
        }

        .mwd-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin-bottom: 0.8rem;
            color: var(--mwd-pink);
            background: var(--mwd-blush);
            border-radius: 16px;
        }

        .mwd-empty-icon svg {
            width: 24px;
            height: 24px;
        }

        .mwd-empty-title {
            color: var(--mwd-plum);
            font-size: 0.95rem;
            font-weight: 700;
        }

        .mwd-empty-sub {
            max-width: 42ch;
            margin-top: 0.3rem !important;
            color: var(--mwd-muted);
            font-size: 0.82rem;
            line-height: 1.55;
        }

        /* ---------- Footer ---------- */
        .mwd-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.15rem 1.35rem;
            background: #ffffff;
            border: 1px solid var(--mwd-line);
            border-radius: var(--mwd-radius);
            box-shadow: var(--mwd-shadow);
        }

        .mwd-footer-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-width: 0;
        }

        .mwd-footer-brand img {
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--mwd-line);
        }

        .mwd-footer-name {
            color: var(--mwd-plum);
            font-size: 0.86rem;
            font-weight: 700;
        }

        .mwd-footer-sub {
            margin-top: 0.15rem !important;
            color: var(--mwd-muted);
            font-size: 0.76rem;
        }

        .mwd-footer-version {
            color: var(--mwd-muted);
            font-size: 0.76rem;
            line-height: 1.6;
        }

        .mwd-footer-version strong {
            display: block;
            color: var(--mwd-rose);
            font-size: 0.8rem;
        }

        /* ---------- Responsive ---------- */
        @media (min-width: 640px) {
            .mwd-footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .mwd-footer-version {
                text-align: right;
            }
        }

        @media (min-width: 768px) {
            .mwd-actions {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .mwd-stats {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        /* Wide desktop: the two record tables side by side. */
        @media (min-width: 1280px) {
            .mwd-records {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mwd-records > .mwd-panel-wide {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 767px) {
            .mwd-hero {
                flex-direction: column;
                align-items: flex-start;
                background:
                    linear-gradient(180deg, rgba(255, 255, 255, 0.96) 0%, rgba(253, 242, 248, 0.90) 100%),
                    var(--cc-rhu-image) center 38% / cover no-repeat,
                    #ffffff;
            }

            .mwd-hero-main {
                align-items: flex-start;
            }

            .mwd-hero-logo {
                flex-basis: 52px;
                width: 52px;
                height: 52px;
            }

            /* Phones: below the date, left-aligned (as on the Mother dashboard). */
            .mwd-hero .mdb-hero-institution {
                position: static;
                align-self: flex-start;
            }
        }

        /* Phones: tables become labelled rows so every field stays visible. */
        @media (max-width: 639px) {
            .mwd-table-scroll {
                overflow-x: visible;
            }

            table.mwd-table thead {
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                clip: rect(0 0 0 0);
                white-space: nowrap;
            }

            table.mwd-table,
            table.mwd-table tbody,
            table.mwd-table tr,
            table.mwd-table td {
                display: block;
                width: 100%;
            }

            table.mwd-table tbody tr {
                padding: 0.7rem 1rem;
                border-bottom: 1px solid #fbeef4;
            }

            table.mwd-table tbody tr:last-child {
                border-bottom: 0;
            }

            table.mwd-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.3rem 0;
                border-bottom: 0;
                text-align: right;
            }

            table.mwd-table tbody td::before {
                content: attr(data-label);
                flex: 0 0 auto;
                color: var(--mwd-muted);
                font-size: 0.68rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-align: left;
                text-transform: uppercase;
            }

            .mwd-stat {
                padding: 1rem;
            }

            .mwd-stat-icon {
                width: 40px;
                height: 40px;
            }

            .mwd-attn {
                padding: 1rem;
            }

            .mwd-attn .mwd-section-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .mwd-card-summary,
            .mwd-card-foot {
                padding-inline: 1rem;
            }
        }

        @media (max-width: 340px) {
            .mwd-stats {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .mwd-stat,
            .mwd-action,
            .mwd-action-cta,
            .mwd-attn-row-link,
            table.mwd-table tbody tr {
                transition: none;
            }
        }
    </style>
    @endpush

    @php
        $mwdPlural = fn (int $n, string $one, string $many) => $n === 1 ? $one : $many;

        $appointmentPillClass = fn ($status) => match ($status) {
            'Scheduled' => 'mwd-pill-blue',
            'Completed' => 'mwd-pill-emerald',
            'Cancelled' => 'mwd-pill-rose',
            'Missed'    => 'mwd-pill-amber',
            default     => 'mwd-pill-slate',
        };
    @endphp

    <div class="mwd-wrap py-6 sm:py-8"
         style="--cc-rhu-image: url('{{ asset('images/irosin-rhu-building.png') }}');">

        <div class="mwd-container">

            {{-- ====================================== --}}
            {{-- 1. Welcome hero                         --}}
            {{-- ====================================== --}}
            <header class="mwd-hero">
                <div class="mwd-hero-main">
                    <div>
                        <p class="mwd-eyebrow">Midwife Portal</p>
                        <h1 class="mwd-hero-title">Welcome back, <em>{{ Auth::user()->name }}</em></h1>
                        <p class="mwd-hero-sub">Manage Mother's Records, prenatal care, appointments, and infant monitoring at Irosin Rural Health Unit.</p>
                    </div>
                </div>

                <div class="mwd-date" aria-label="Current date">
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
            {{-- 2. System Overview                      --}}
            {{-- ====================================== --}}
            <section aria-labelledby="mwd-overview-title">
                <div class="mwd-section-head">
                    <div>
                        <h2 class="mwd-section-title" id="mwd-overview-title">System Overview</h2>
                        <p class="mwd-section-sub">Real-time summary of maternal and infant healthcare records.</p>
                    </div>
                </div>

                <div class="mwd-stats">
                    <div class="mwd-stat">
                        <div class="mwd-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </div>
                        <div>
                            <p class="mwd-stat-value">{{ $mothers }}</p>
                            <p class="mwd-stat-label">Registered Mothers</p>
                        </div>
                    </div>

                    <div class="mwd-stat">
                        <div class="mwd-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 10h.01M15 10h.01M9.5 15a3.5 3.5 0 0 0 5 0"/></svg>
                        </div>
                        <div>
                            <p class="mwd-stat-value">{{ $infants }}</p>
                            <p class="mwd-stat-label">Registered Infants</p>
                        </div>
                    </div>

                    <div class="mwd-stat">
                        <div class="mwd-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <div>
                            <p class="mwd-stat-value">{{ $appointments }}</p>
                            <p class="mwd-stat-label">Upcoming Appointments</p>
                        </div>
                    </div>

                    <div class="mwd-stat">
                        <div class="mwd-stat-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                        </div>
                        <div>
                            {{-- Infant + maternal doses already given (date given today or earlier) --}}
                            <p class="mwd-stat-value">{{ $midwifeVaccinationsGiven }}</p>
                            <p class="mwd-stat-label">Vaccinations Given</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 3. Attention Required (read-only: nothing is changed automatically) --}}
            {{-- ====================================== --}}
            <section class="mwd-attn" aria-labelledby="mwd-attn-title">
                <div class="mwd-section-head">
                    <div>
                        <h2 class="mwd-section-title" id="mwd-attn-title">Attention Required</h2>
                        <p class="mwd-section-sub">Items that may need follow-up. Nothing is changed automatically &mdash; open each record to review it.</p>
                    </div>
                    <span class="mwd-total {{ $attentionTotal === 0 ? 'is-clear' : '' }}">
                        {{ $attentionTotal }} {{ $mwdPlural($attentionTotal, 'item', 'items') }}
                    </span>
                </div>

                @if($attentionTotal === 0)
                    <div class="mwd-attn-clear">
                        <span class="mwd-attn-clear-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <div>
                            <p class="mwd-attn-clear-title">All clear</p>
                            <p class="mwd-attn-clear-sub">No appointments need a status review, no vaccinations are past due, and none are due in the next 7 days.</p>
                        </div>
                    </div>
                @else
                    <div class="mwd-attn-grid">

                        {{-- Appointments needing status review --}}
                        <article class="mwd-attn-group mwd-attn-review" aria-labelledby="mwd-attn-review-title">
                            <header class="mwd-attn-group-head">
                                <span class="mwd-attn-group-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/><path d="M12 13v3M12 19h.01"/></svg>
                                </span>
                                <div class="mwd-attn-group-text">
                                    <h3 class="mwd-attn-group-title" id="mwd-attn-review-title">Needs status review</h3>
                                    <p class="mwd-attn-group-sub">Past appointments still marked Scheduled</p>
                                </div>
                                <span class="mwd-attn-count">{{ $attentionReviewTotal }}</span>
                            </header>

                            @if($attentionReview->count())
                                <ul class="mwd-attn-list">
                                    @foreach($attentionReview as $item)
                                        <li class="mwd-attn-row">
                                            <div class="mwd-attn-row-main">
                                                <p class="mwd-attn-row-title">{{ $item['name'] }}</p>
                                                <p class="mwd-attn-row-meta">{{ $item['type'] }} &middot; {{ $item['date']->format('M d, Y') }}</p>
                                                <p class="mwd-attn-row-flag">
                                                    Needs status review &middot; {{ $item['days'] }} {{ $mwdPlural($item['days'], 'day', 'days') }} ago
                                                </p>
                                            </div>
                                            <a href="{{ $item['url'] }}" class="mwd-attn-row-link"
                                               aria-label="Review the {{ $item['type'] }} appointment of {{ $item['name'] }} on {{ $item['date']->format('M d, Y') }}">
                                                Review
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($attentionReviewMore > 0)
                                    <a href="{{ route('mothers.index') }}" class="mwd-more"
                                       title="{{ $attentionReviewMore }} more {{ $mwdPlural($attentionReviewMore, 'appointment needs', 'appointments need') }} a status review. Open Mother Management to find them in each mother's record."
                                       aria-label="{{ $attentionReviewMore }} more {{ $mwdPlural($attentionReviewMore, 'appointment needs', 'appointments need') }} a status review. Open Mother Management to find them in each mother's record.">
                                        + {{ $attentionReviewMore }} more &middot; Open Mother Management
                                    </a>
                                @endif
                            @else
                                <p class="mwd-attn-empty">No past appointments are waiting for a status update.</p>
                            @endif
                        </article>

                        {{-- Overdue vaccinations (infant and maternal) --}}
                        <article class="mwd-attn-group mwd-attn-overdue" aria-labelledby="mwd-attn-overdue-title">
                            <header class="mwd-attn-group-head">
                                <span class="mwd-attn-group-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4M12 17h.01"/><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                </span>
                                <div class="mwd-attn-group-text">
                                    <h3 class="mwd-attn-group-title" id="mwd-attn-overdue-title">Overdue vaccinations</h3>
                                    <p class="mwd-attn-group-sub">Next dose date has passed</p>
                                </div>
                                <span class="mwd-attn-count">{{ $attentionOverdueTotal }}</span>
                            </header>

                            @if($attentionOverdue->count())
                                <ul class="mwd-attn-list">
                                    @foreach($attentionOverdue as $item)
                                        <li class="mwd-attn-row">
                                            <div class="mwd-attn-row-main">
                                                <p class="mwd-attn-row-title">
                                                    {{ $item['name'] }}
                                                    <span class="mwd-tag">{{ $item['recipient'] === 'Mother' ? 'Maternal' : 'Infant' }}</span>
                                                </p>
                                                <p class="mwd-attn-row-meta">{{ $item['vaccine'] }} &middot; due {{ $item['due']->format('M d, Y') }}</p>
                                                <p class="mwd-attn-row-flag">
                                                    Past due &mdash; verify in record &middot; {{ abs($item['days']) }} {{ $mwdPlural(abs($item['days']), 'day', 'days') }}
                                                </p>
                                            </div>
                                            <a href="{{ $item['url'] }}" class="mwd-attn-row-link"
                                               aria-label="Open the {{ $item['recipient'] === 'Mother' ? 'maternal' : 'infant' }} record of {{ $item['name'] }} to verify {{ $item['vaccine'] }}">
                                                Open
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($attentionOverdueMore > 0)
                                    <a href="{{ route('mothers.index') }}" class="mwd-more"
                                       title="{{ $attentionOverdueMore }} more past-due {{ $mwdPlural($attentionOverdueMore, 'dose', 'doses') }}. Open Mother Management to find them in each mother's or infant's record."
                                       aria-label="{{ $attentionOverdueMore }} more past-due {{ $mwdPlural($attentionOverdueMore, 'dose', 'doses') }}. Open Mother Management to find them in each mother's or infant's record.">
                                        + {{ $attentionOverdueMore }} more &middot; Open Mother Management
                                    </a>
                                @endif
                            @else
                                <p class="mwd-attn-empty">No infant or maternal doses are past due.</p>
                            @endif
                        </article>

                        {{-- Vaccinations due in the next 7 days (infant and maternal) --}}
                        <article class="mwd-attn-group mwd-attn-soon" aria-labelledby="mwd-attn-soon-title">
                            <header class="mwd-attn-group-head">
                                <span class="mwd-attn-group-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                </span>
                                <div class="mwd-attn-group-text">
                                    <h3 class="mwd-attn-group-title" id="mwd-attn-soon-title">Due in the next 7 days</h3>
                                    <p class="mwd-attn-group-sub">Infant and maternal doses</p>
                                </div>
                                <span class="mwd-attn-count">{{ $attentionSoonTotal }}</span>
                            </header>

                            @if($attentionSoon->count())
                                <ul class="mwd-attn-list">
                                    @foreach($attentionSoon as $item)
                                        <li class="mwd-attn-row">
                                            <div class="mwd-attn-row-main">
                                                <p class="mwd-attn-row-title">
                                                    {{ $item['name'] }}
                                                    <span class="mwd-tag">{{ $item['recipient'] === 'Mother' ? 'Maternal' : 'Infant' }}</span>
                                                </p>
                                                <p class="mwd-attn-row-meta">{{ $item['vaccine'] }} &middot; {{ $item['due']->format('M d, Y') }}</p>
                                                <p class="mwd-attn-row-flag">
                                                    @if($item['days'] === 0)
                                                        Due today
                                                    @elseif($item['days'] === 1)
                                                        Due tomorrow
                                                    @else
                                                        Due in {{ $item['days'] }} days
                                                    @endif
                                                </p>
                                            </div>
                                            <a href="{{ $item['url'] }}" class="mwd-attn-row-link"
                                               aria-label="Open the {{ $item['recipient'] === 'Mother' ? 'maternal' : 'infant' }} record of {{ $item['name'] }} for {{ $item['vaccine'] }}">
                                                Open
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($attentionSoonMore > 0)
                                    <a href="{{ route('mothers.index') }}" class="mwd-more"
                                       title="{{ $attentionSoonMore }} more {{ $mwdPlural($attentionSoonMore, 'dose', 'doses') }} due in the next 7 days. Open Mother Management to find them in each mother's or infant's record."
                                       aria-label="{{ $attentionSoonMore }} more {{ $mwdPlural($attentionSoonMore, 'dose', 'doses') }} due in the next 7 days. Open Mother Management to find them in each mother's or infant's record.">
                                        + {{ $attentionSoonMore }} more &middot; Open Mother Management
                                    </a>
                                @endif
                            @else
                                <p class="mwd-attn-empty">No doses are due in the next 7 days.</p>
                            @endif
                        </article>

                    </div>
                @endif
            </section>

            {{-- ====================================== --}}
            {{-- 4. Quick Actions                         --}}
            {{-- ====================================== --}}
            <section aria-labelledby="mwd-actions-title">
                <div class="mwd-section-head">
                    <div>
                        <h2 class="mwd-section-title" id="mwd-actions-title">Quick Actions</h2>
                        <p class="mwd-section-sub">Direct access to Mother's Records, SMS reminders, and health education.</p>
                    </div>
                </div>

                <div class="mwd-actions">
                    <a href="{{ route('mothers.index') }}" class="mwd-action" aria-label="Open Mother Management">
                        <span class="mwd-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </span>
                        <p class="mwd-action-name">Mother Management</p>
                        <p class="mwd-action-desc">Manage Mother's Records, prenatal visits, appointments, infant registration, and growth monitoring in one centralized module.</p>
                        <span class="mwd-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </a>

                    <a href="{{ route('sms-notifications.index') }}" class="mwd-action" aria-label="Open SMS Notifications">
                        <span class="mwd-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5h18v14H3z"/><path d="M3 6l9 7 9-7"/></svg>
                        </span>
                        <p class="mwd-action-name">SMS Notifications</p>
                        <p class="mwd-action-desc">View appointment reminder SMS, check whether each was sent or delivered, and review reminders that need attention.</p>
                        <span class="mwd-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </a>

                    <a href="{{ route('midwife.health-tips.index') }}" class="mwd-action" aria-label="Open Health Tips Library">
                        <span class="mwd-action-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z"/></svg>
                        </span>
                        <p class="mwd-action-name">Health Tips Library</p>
                        <p class="mwd-action-desc">Publish and manage maternal and infant health tips that mothers can read in their portal.</p>
                        <span class="mwd-action-cta">
                            Open module
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </span>
                    </a>
                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 5–7. Today's work and recent records    --}}
            {{-- ====================================== --}}
            <section aria-labelledby="mwd-records-title">
                <div class="mwd-section-head">
                    <div>
                        <h2 class="mwd-section-title" id="mwd-records-title">Today &amp; Upcoming</h2>
                        <p class="mwd-section-sub">Today's appointments, upcoming infant and maternal vaccinations, and newly registered infants.</p>
                    </div>
                </div>

                <div class="mwd-records">

                    {{-- Today's Appointments --}}
                    <div class="mwd-panel mwd-panel-wide">
                        <div class="mwd-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Today's Appointments
                            </h3>
                            {{-- True number of today's appointments (not limited to the five shown). --}}
                            <span class="mwd-count">{{ $todayAppointmentsTotal }} today</span>
                        </div>

                        <div class="mwd-table-card">
                            @if($todayAppointments->count())
                                {{-- Breakdown of today's appointments by their recorded status. --}}
                                <div class="mwd-card-summary" aria-label="Today's appointments by status">
                                    @foreach($todayAppointmentStatusCounts as $status => $statusTotal)
                                        <span class="mwd-pill {{ $appointmentPillClass($status) }}">
                                            <span class="mwd-pill-dot"></span>
                                            {{ $statusTotal }} {{ $status }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mwd-table-scroll">
                                    <table class="mwd-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Time</th>
                                                <th scope="col">Mother</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($todayAppointments as $appointment)
                                                <tr>
                                                    <td data-label="Time">
                                                        <span class="mwd-time">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                                        </span>
                                                    </td>
                                                    <td data-label="Mother" class="mwd-strong">
                                                        {{ $appointment->mother->first_name }} {{ $appointment->mother->last_name }}
                                                    </td>
                                                    <td data-label="Type">
                                                        <span class="mwd-chip">{{ $appointment->appointment_type }}</span>
                                                    </td>
                                                    <td data-label="Status">
                                                        <span class="mwd-pill {{ $appointmentPillClass($appointment->status) }}">
                                                            <span class="mwd-pill-dot"></span>
                                                            {{ $appointment->status }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($todayAppointmentsMore > 0)
                                    <div class="mwd-card-foot">
                                        <a href="{{ route('mothers.index') }}"
                                           class="mwd-more"
                                           title="{{ $todayAppointmentsMore }} more {{ $todayAppointmentsMore === 1 ? 'appointment' : 'appointments' }} today. Open Mother Management to find them in each mother's record."
                                           aria-label="{{ $todayAppointmentsMore }} more {{ $todayAppointmentsMore === 1 ? 'appointment' : 'appointments' }} today. Open Mother Management to find them in each mother's record.">
                                            + {{ $todayAppointmentsMore }} more &middot; Open Mother Management
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="mwd-empty">
                                    <div class="mwd-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V19a2 2 0 01-2 2H5a2 2 0 01-2-2V8.5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    </div>
                                    <p class="mwd-empty-title">No appointments today</p>
                                    <p class="mwd-empty-sub">There are no scheduled appointments for today.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Upcoming Vaccinations (infant and maternal) --}}
                    <div class="mwd-panel">
                        <div class="mwd-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                                Upcoming Vaccinations
                            </h3>
                            {{-- True number of upcoming infant and maternal doses (not limited to the five shown). --}}
                            <span class="mwd-count">{{ $upcomingVaccinationsTotal }} upcoming</span>
                        </div>

                        <div class="mwd-table-card">
                            @if($midwifeUpcomingVaccinations->count())
                                <div class="mwd-card-summary">
                                    {{ $upcomingInfantVaccinationsTotal }} infant
                                    &middot;
                                    {{ $upcomingMaternalVaccinationsTotal }} maternal
                                </div>

                                <div class="mwd-table-scroll">
                                    <table class="mwd-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Record</th>
                                                <th scope="col">Vaccine</th>
                                                <th scope="col">Next Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($midwifeUpcomingVaccinations as $dose)
                                                <tr>
                                                    <td data-label="Name" class="mwd-strong">{{ $dose['name'] }}</td>
                                                    <td data-label="Record">
                                                        <span class="mwd-chip">{{ $dose['recipient'] }}</span>
                                                    </td>
                                                    <td data-label="Vaccine">{{ $dose['vaccine'] }}</td>
                                                    <td data-label="Next Due">
                                                        <span class="mwd-pill mwd-pill-date">
                                                            {{ \Carbon\Carbon::parse($dose['due'])->format('M d, Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($upcomingVaccinationsMore > 0)
                                    <div class="mwd-card-foot">
                                        <a href="{{ route('mothers.index') }}"
                                           class="mwd-more"
                                           title="{{ $upcomingVaccinationsMore }} more upcoming {{ $upcomingVaccinationsMore === 1 ? 'dose' : 'doses' }}. Open Mother Management to find them in each mother's or infant's record."
                                           aria-label="{{ $upcomingVaccinationsMore }} more upcoming {{ $upcomingVaccinationsMore === 1 ? 'dose' : 'doses' }}. Open Mother Management to find them in each mother's or infant's record.">
                                            + {{ $upcomingVaccinationsMore }} more &middot; Open Mother Management
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="mwd-empty">
                                    <div class="mwd-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="mwd-empty-title">No upcoming vaccinations</p>
                                    <p class="mwd-empty-sub">Upcoming vaccination schedules will appear here once available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Recent Infant Registrations --}}
                    <div class="mwd-panel">
                        <div class="mwd-panel-head">
                            <h3>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9 10h.01M15 10h.01M9.5 15a3.5 3.5 0 0 0 5 0"/></svg>
                                Recent Infant Registrations
                            </h3>
                            <span class="mwd-count">{{ $recentInfants->count() }} recent</span>
                        </div>

                        <div class="mwd-table-card">
                            @if($recentInfants->count())
                                <div class="mwd-table-scroll">
                                    <table class="mwd-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Infant</th>
                                                <th scope="col">Mother</th>
                                                <th scope="col">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentInfants as $infant)
                                                <tr>
                                                    <td data-label="Infant" class="mwd-strong">{{ $infant->first_name }} {{ $infant->last_name }}</td>
                                                    <td data-label="Mother">{{ $infant->mother->first_name }} {{ $infant->mother->last_name }}</td>
                                                    <td data-label="Registered">
                                                        <span class="mwd-pill mwd-pill-date">{{ $infant->created_at->format('M d, Y') }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($recentInfantsMore > 0)
                                    <div class="mwd-card-foot">
                                        <a href="{{ route('mothers.index') }}"
                                           class="mwd-more"
                                           title="{{ $recentInfantsMore }} more registered {{ $recentInfantsMore === 1 ? 'infant' : 'infants' }}. Open Mother Management to find them in each mother's record."
                                           aria-label="{{ $recentInfantsMore }} more registered {{ $recentInfantsMore === 1 ? 'infant' : 'infants' }}. Open Mother Management to find them in each mother's record.">
                                            + {{ $recentInfantsMore }} more &middot; Open Mother Management
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="mwd-empty">
                                    <div class="mwd-empty-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/></svg>
                                    </div>
                                    <p class="mwd-empty-title">No infant records yet</p>
                                    <p class="mwd-empty-sub">Newly registered infant records will appear here once available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- ====================================== --}}
            {{-- 8. Footer                                --}}
            {{-- ====================================== --}}
            <footer class="mwd-footer">
                <div class="mwd-footer-brand">
                    <img src="{{ asset('images/system.logo.png') }}" alt="" aria-hidden="true">
                    <div>
                        <p class="mwd-footer-name">CareCradle Maternal &amp; Infant Health Monitoring System</p>
                        <p class="mwd-footer-sub">Rural Health Unit Electronic Maternal and Infant Records Management</p>
                    </div>
                </div>

                <div class="mwd-footer-version">
                    <strong>Version 1.0 &middot; Midwife Dashboard</strong>
                    &copy; {{ date('Y') }} Irosin Rural Health Unit. All Rights Reserved.
                </div>
            </footer>

        </div>
    </div>

</x-app-layout>
