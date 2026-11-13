{{--
    ================================================================
    CareCradle — Administrator Portal shared UI styles
    ----------------------------------------------------------------
    Admin-only. Include at the top of an Administrator page:

        @include('admin.partials.ui-styles')

    The styles are pushed once into the layout's existing
    @stack('styles') (after the compiled Vite CSS), so no rebuild is
    needed. Every selector is scoped to `.adm-page`, so nothing here
    can affect the Midwife or Mother portals or any page that does
    not opt in by using the `.adm-page` wrapper.

    Palette and type match the approved Administrator Dashboard:
    pink / blush / white / deep rose, DM Serif Display + Inter.
    ================================================================
--}}
@once
@push('styles')
<style>
    /* ---------- Tokens and page shell ---------- */
    .adm-page {
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
        padding-block: clamp(1.5rem, 3vw, 2rem);
        color: var(--adm-ink);
        font-family: var(--adm-sans);
        background:
            radial-gradient(1200px 520px at 100% -10%, rgba(252, 231, 243, 0.85), transparent 60%),
            radial-gradient(900px 480px at -10% 30%, rgba(253, 242, 248, 0.9), transparent 60%),
            linear-gradient(180deg, #fffafc 0%, #fff7fb 100%);
    }

    .adm-page *,
    .adm-page *::before,
    .adm-page *::after {
        box-sizing: border-box;
    }

    .adm-page .adm-container {
        display: flex;
        flex-direction: column;
        gap: clamp(1.25rem, 2.4vw, 1.75rem);
        width: 100%;
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 clamp(1rem, 2.2vw, 2rem);
    }

    .adm-page .adm-container-narrow {
        max-width: 1040px;
    }

    .adm-page :focus-visible {
        outline: 3px solid rgba(219, 39, 119, 0.35);
        outline-offset: 2px;
    }

    /* ---------- Page header card ---------- */
    .adm-page .adm-page-header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
        padding: clamp(1.15rem, 2.5vw, 1.6rem) clamp(1.15rem, 2.5vw, 1.75rem);
        overflow: hidden;
        background: linear-gradient(110deg, #ffffff 0%, #ffffff 55%, #fff4f9 100%);
        border: 1px solid var(--adm-line);
        border-radius: calc(var(--adm-radius) + 4px);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-page-header::after {
        content: "";
        position: absolute;
        right: -70px;
        top: -90px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(244, 114, 182, 0.16), transparent 70%);
        pointer-events: none;
    }

    .adm-page .adm-page-header-main {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .adm-page .adm-page-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 52px;
        width: 52px;
        height: 52px;
        color: #ffffff;
        background: linear-gradient(135deg, var(--adm-rose) 0%, var(--adm-pink) 100%);
        border-radius: 16px;
        box-shadow: 0 8px 18px rgba(219, 39, 119, 0.24);
    }

    .adm-page .adm-page-icon svg {
        width: 24px;
        height: 24px;
    }

    .adm-page .adm-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0 0 0.3rem;
        color: var(--adm-rose);
        font-size: 0.66rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .adm-page .adm-eyebrow::before {
        content: "";
        width: 20px;
        height: 2px;
        border-radius: 2px;
        background: #f472b6;
    }

    .adm-page .adm-page-title {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: clamp(1.55rem, 2.6vw, 2.1rem);
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .adm-page .adm-page-desc {
        margin: 0.35rem 0 0;
        max-width: 60ch;
        color: var(--adm-muted);
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .adm-page .adm-page-actions {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 0.6rem;
        flex: 0 0 auto;
    }

    .adm-page .adm-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 0.85rem;
        color: var(--adm-deep);
        font-size: 0.76rem;
        font-weight: 600;
        background: var(--adm-blush);
        border: 1px solid var(--adm-line);
        border-radius: 999px;
    }

    .adm-page .adm-tag svg {
        width: 15px;
        height: 15px;
        color: var(--adm-pink);
    }

    /* ---------- Buttons ---------- */
    .adm-page .adm-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        min-height: 42px;
        padding: 0.6rem 1.05rem;
        font-family: var(--adm-sans);
        font-size: 0.84rem;
        font-weight: 600;
        line-height: 1.2;
        white-space: nowrap;
        text-decoration: none;
        border: 1px solid transparent;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.18s ease, border-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease, transform 0.12s ease;
    }

    .adm-page .adm-btn svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .adm-page .adm-btn-primary {
        color: #ffffff;
        background: linear-gradient(135deg, var(--adm-rose) 0%, var(--adm-pink) 100%);
        box-shadow: 0 6px 16px rgba(219, 39, 119, 0.24);
    }

    .adm-page .adm-btn-secondary {
        color: #475569;
        background: #ffffff;
        border-color: #e8dbe2;
    }

    .adm-page .adm-btn-sm {
        min-height: 34px;
        padding: 0.4rem 0.75rem;
        font-size: 0.78rem;
        border-radius: 10px;
    }

    .adm-page .adm-btn-edit {
        color: var(--adm-deep);
        background: var(--adm-blush);
        border-color: var(--adm-line);
    }

    .adm-page .adm-btn-danger {
        color: #be123c;
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .adm-page .adm-btn-success {
        color: #047857;
        background: #ecfdf5;
        border-color: #a7f3d0;
    }

    @media (hover: hover) and (pointer: fine) {
        .adm-page .adm-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(219, 39, 119, 0.3);
        }

        .adm-page .adm-btn-secondary:hover {
            color: var(--adm-deep);
            border-color: #f9a8d4;
            background: #fffafd;
        }

        .adm-page .adm-btn-edit:hover {
            border-color: #f9a8d4;
            background: var(--adm-blush-2);
        }

        .adm-page .adm-btn-danger:hover {
            border-color: #fda4af;
            background: #ffe4e6;
        }

        .adm-page .adm-btn-success:hover {
            border-color: #6ee7b7;
            background: #d1fae5;
        }
    }

    /* ---------- Statistic cards (same look as the dashboard) ---------- */
    .adm-page .adm-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 0.9rem;
    }

    .adm-page .adm-stat {
        --tone: var(--adm-pink);
        --tone-soft: var(--adm-blush);
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
        padding: 1.15rem 1.2rem;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--adm-line);
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-stat::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, var(--tone), rgba(244, 114, 182, 0.35));
    }

    .adm-page .adm-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 46px;
        width: 46px;
        height: 46px;
        color: var(--tone);
        background: var(--tone-soft);
        border-radius: 14px;
    }

    .adm-page .adm-stat-icon svg {
        width: 22px;
        height: 22px;
    }

    .adm-page .adm-stat-value {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: clamp(1.9rem, 2.4vw, 2.3rem);
        font-weight: 400;
        line-height: 1;
    }

    .adm-page .adm-stat-label {
        margin: 0.3rem 0 0;
        color: var(--adm-muted);
        font-size: 0.8rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .adm-page .adm-tone-1 { --tone: #db2777; --tone-soft: #fdf2f8; }
    .adm-page .adm-tone-2 { --tone: #e11d48; --tone-soft: #fff1f2; }
    .adm-page .adm-tone-3 { --tone: #be185d; --tone-soft: #fce7f3; }
    .adm-page .adm-tone-4 { --tone: #9d174d; --tone-soft: #fdf2f8; }

    /* Compact pair of statistic cards (Patient Records search page) */
    .adm-page .adm-stats-compact {
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 140px), 1fr));
        max-width: 560px;
        gap: 0.75rem;
    }

    .adm-page .adm-stats-compact .adm-stat {
        padding: 0.85rem 1rem;
        gap: 0.8rem;
    }

    .adm-page .adm-stats-compact .adm-stat-icon {
        flex-basis: 40px;
        width: 40px;
        height: 40px;
        border-radius: 12px;
    }

    .adm-page .adm-stats-compact .adm-stat-value {
        font-size: 1.75rem;
    }

    /* ---------- Cards ---------- */
    .adm-page .adm-card {
        min-width: 0;
        background: #ffffff;
        border: 1px solid var(--adm-line);
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-card-clip {
        overflow: hidden;
    }

    .adm-page .adm-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.35rem;
        background: linear-gradient(180deg, #fffafd 0%, #ffffff 100%);
        border-bottom: 1px solid var(--adm-line);
        border-radius: var(--adm-radius) var(--adm-radius) 0 0;
    }

    .adm-page .adm-card-head-main {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        min-width: 0;
    }

    .adm-page .adm-card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        color: var(--adm-pink);
        background: var(--adm-blush);
        border-radius: 12px;
    }

    .adm-page .adm-card-icon svg {
        width: 20px;
        height: 20px;
    }

    .adm-page .adm-card-title {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.2rem;
        font-weight: 400;
        line-height: 1.25;
    }

    .adm-page .adm-card-sub {
        margin: 0.2rem 0 0;
        color: var(--adm-muted);
        font-size: 0.82rem;
        line-height: 1.5;
    }

    .adm-page .adm-card-body {
        padding: clamp(1.1rem, 2.4vw, 1.5rem) clamp(1.1rem, 2.4vw, 1.5rem);
    }

    .adm-page .adm-count {
        flex: 0 0 auto;
        padding: 0.3rem 0.75rem;
        color: var(--adm-deep);
        font-size: 0.74rem;
        font-weight: 700;
        white-space: nowrap;
        background: var(--adm-blush-2);
        border-radius: 999px;
    }

    /* ---------- Search + segmented filter toolbar ---------- */
    .adm-page .adm-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.9rem;
        padding: 0.9rem;
    }

    .adm-page .adm-search {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1 1 360px;
        min-width: 0;
        padding: 0.3rem 0.3rem 0.3rem 2.6rem;
        background: #fffafd;
        border: 1px solid var(--adm-line);
        border-radius: 14px;
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .adm-page .adm-search:focus-within {
        border-color: #f472b6;
        box-shadow: 0 0 0 4px rgba(244, 114, 182, 0.15);
    }

    .adm-page .adm-search > svg {
        position: absolute;
        left: 0.9rem;
        width: 18px;
        height: 18px;
        color: #c084a5;
        pointer-events: none;
    }

    .adm-page .adm-search input {
        /* flex-basis 0 + width 0: the input never forces the search bar
           wider than its card on very small phones */
        flex: 1 1 0;
        width: 0;
        min-width: 0;
        padding: 0.55rem 0.25rem;
        color: var(--adm-ink);
        font-family: var(--adm-sans);
        font-size: 0.88rem;
        background: transparent;
        border: 0;
        box-shadow: none;
        outline: none;
    }

    .adm-page .adm-search input:focus {
        border: 0;
        box-shadow: none;
        outline: none;
    }

    .adm-page .adm-search input::placeholder {
        color: #a3a3b5;
    }

    .adm-page .adm-segment {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        padding: 0.3rem;
        background: #fff7fb;
        border: 1px solid var(--adm-line);
        border-radius: 14px;
    }

    .adm-page .adm-segment a {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        min-height: 36px;
        padding: 0.4rem 0.85rem;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 10px;
        transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
    }

    .adm-page .adm-segment a:hover {
        color: var(--adm-deep);
    }

    .adm-page .adm-segment a.is-selected {
        color: var(--adm-deep);
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(131, 24, 67, 0.10);
    }

    .adm-page .adm-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .adm-page .adm-dot-all { color: #c084a5; }
    .adm-page .adm-dot-active { color: #10b981; }
    .adm-page .adm-dot-inactive { color: #94a3b8; }

    .adm-page .adm-toolbar-foot {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    .adm-page .adm-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--adm-rose);
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
    }

    .adm-page .adm-link:hover {
        text-decoration: underline;
    }

    .adm-page .adm-link svg {
        width: 14px;
        height: 14px;
    }

    /* ---------- Tables ----------
       The table reacts to the width of its own card (container query),
       not the screen: with the sidebar open, or on tablets, a wide table
       turns into labelled rows instead of hiding columns off to the side.
       Each <td> needs a data-label attribute. */
    .adm-page .adm-table-scroll {
        width: 100%;
        overflow-x: auto;
        container-type: inline-size;
        container-name: admtable;
    }

    .adm-page table.adm-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.86rem;
    }

    .adm-page table.adm-table thead th {
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

    .adm-page table.adm-table tbody td {
        padding: 0.85rem 1.15rem;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #fbeef4;
    }

    .adm-page table.adm-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .adm-page table.adm-table tbody tr:hover {
        background: #fffafd;
    }

    .adm-page .adm-center {
        text-align: center;
    }

    .adm-page .adm-strong {
        margin: 0;
        color: var(--adm-ink);
        font-weight: 600;
    }

    .adm-page .adm-subtext {
        margin: 0.1rem 0 0;
        color: #94a3b8;
        font-size: 0.74rem;
    }

    .adm-page .adm-muted {
        color: var(--adm-muted);
    }

    .adm-page .adm-person {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
    }

    .adm-page .adm-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 38px;
        width: 38px;
        height: 38px;
        color: var(--adm-deep);
        font-size: 0.76rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fce7f3 0%, #fdf2f8 100%);
        border: 1px solid var(--adm-line);
        border-radius: 50%;
    }

    .adm-page .adm-row-actions {
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
    }

    .adm-page .adm-row-actions form {
        margin: 0;
    }

    /* Pills keep their meaning: active = green, inactive = grey */
    .adm-page .adm-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.25rem 0.7rem;
        font-size: 0.74rem;
        font-weight: 700;
        white-space: nowrap;
        border-radius: 999px;
    }

    .adm-page .adm-pill-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .adm-page .adm-pill-success { color: #047857; background: #ecfdf5; }
    .adm-page .adm-pill-muted   { color: #475569; background: #f1f5f9; }

    /* ---------- Empty state ---------- */
    .adm-page .adm-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2.5rem 1.25rem;
        text-align: center;
    }

    .adm-page .adm-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        margin-bottom: 0.9rem;
        color: var(--adm-pink);
        background: var(--adm-blush);
        border-radius: 18px;
    }

    .adm-page .adm-empty-icon svg {
        width: 26px;
        height: 26px;
    }

    .adm-page .adm-empty-title {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.25rem;
        font-weight: 400;
    }

    .adm-page .adm-empty-desc {
        max-width: 48ch;
        margin: 0.4rem 0 1.1rem;
        color: var(--adm-muted);
        font-size: 0.85rem;
        line-height: 1.6;
    }

    /* ---------- Forms ---------- */
    .adm-page .adm-form-section + .adm-form-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed var(--adm-line);
    }

    .adm-page .adm-form-section-head {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1.1rem;
    }

    .adm-page .adm-form-section-title {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.12rem;
        font-weight: 400;
    }

    .adm-page .adm-form-section-sub {
        margin: 0.15rem 0 0;
        color: var(--adm-muted);
        font-size: 0.8rem;
    }

    .adm-page .adm-form-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1.1rem 1.25rem;
    }

    .adm-page .adm-field label {
        display: block;
        margin-bottom: 0.45rem;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 600;
    }

    .adm-page .adm-required {
        color: #e11d48;
    }

    .adm-page .adm-input-wrap {
        position: relative;
    }

    .adm-page .adm-input {
        display: block;
        width: 100%;
        min-height: 46px;
        padding: 0.7rem 0.95rem;
        color: var(--adm-ink);
        font-family: var(--adm-sans);
        font-size: 0.9rem;
        background-color: #ffffff;
        border: 1px solid #e5d5de;
        border-radius: 12px;
        box-shadow: none;
        transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    /* Selects keep a pink chevron */
    .adm-page select.adm-input {
        padding-right: 2.5rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23be185d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-position: right 0.85rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
        -webkit-appearance: none;
        appearance: none;
    }

    /* Input with a leading icon (report search fields) */
    .adm-page .adm-input-icon {
        position: relative;
    }

    .adm-page .adm-input-icon > svg {
        position: absolute;
        top: 50%;
        left: 0.9rem;
        width: 18px;
        height: 18px;
        color: #c084a5;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .adm-page .adm-input-icon .adm-input {
        padding-left: 2.6rem;
    }

    .adm-page .adm-input::placeholder {
        color: #a3a3b5;
    }

    .adm-page .adm-input:focus {
        border-color: #f472b6;
        outline: none;
        box-shadow: 0 0 0 4px rgba(244, 114, 182, 0.15);
    }

    .adm-page .adm-input-wrap .adm-input {
        padding-right: 3rem;
    }

    .adm-page .adm-input-toggle {
        position: absolute;
        top: 50%;
        right: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        padding: 0;
        color: #94a3b8;
        background: transparent;
        border: 0;
        border-radius: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .adm-page .adm-input-toggle:hover {
        color: var(--adm-pink);
        background: var(--adm-blush);
    }

    /* Read-only fields (e.g. the username on Edit Midwife) */
    .adm-page .adm-input[readonly] {
        color: #475569;
        background: #f8f5f7;
        border-style: dashed;
        cursor: not-allowed;
    }

    .adm-page .adm-input[readonly]:focus {
        border-color: #e5d5de;
        box-shadow: none;
    }

    .adm-page .adm-field-help {
        margin: 0.4rem 0 0;
        color: var(--adm-muted);
        font-size: 0.78rem;
        line-height: 1.5;
    }

    /* Informational note (e.g. password handled separately) */
    .adm-page .adm-note {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 0.9rem 1rem;
        background: #fffafd;
        border: 1px solid var(--adm-line);
        border-radius: 14px;
    }

    .adm-page .adm-note-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        color: var(--adm-pink);
        background: var(--adm-blush);
        border-radius: 10px;
    }

    .adm-page .adm-note-icon svg {
        width: 18px;
        height: 18px;
    }

    .adm-page .adm-note-title {
        margin: 0;
        color: var(--adm-plum);
        font-size: 0.86rem;
        font-weight: 700;
    }

    .adm-page .adm-note-text {
        margin: 0.2rem 0 0;
        color: var(--adm-muted);
        font-size: 0.8rem;
        line-height: 1.55;
    }

    .adm-page .adm-field-error {
        margin: 0.4rem 0 0;
        color: #be123c;
        font-size: 0.8rem;
    }

    .adm-page .adm-form-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
        gap: 0.6rem;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--adm-line);
    }

    /* Validation summary */
    .adm-page .adm-errors {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #fecdd3;
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-errors-head {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 1rem 1.25rem;
        background: #fff1f2;
        border-bottom: 1px solid #fecdd3;
    }

    .adm-page .adm-errors-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        color: #e11d48;
        background: #ffffff;
        border-radius: 10px;
    }

    .adm-page .adm-errors-icon svg {
        width: 20px;
        height: 20px;
    }

    .adm-page .adm-errors-title {
        margin: 0;
        color: #9f1239;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .adm-page .adm-errors-sub {
        margin: 0.2rem 0 0;
        color: #be123c;
        font-size: 0.8rem;
        line-height: 1.5;
    }

    .adm-page .adm-errors-list {
        display: grid;
        gap: 0.45rem;
        margin: 0;
        padding: 1rem 1.25rem;
        list-style: none;
    }

    .adm-page .adm-errors-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        color: #9f1239;
        font-size: 0.84rem;
    }

    .adm-page .adm-errors-list svg {
        flex: 0 0 16px;
        width: 16px;
        height: 16px;
        margin-top: 2px;
    }

    /* ---------- Responsive ---------- */
    @media (min-width: 768px) {
        .adm-page .adm-form-grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .adm-page .adm-span-2 {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 767px) {
        .adm-page .adm-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .adm-page .adm-page-header-main {
            align-items: flex-start;
        }

        .adm-page .adm-page-icon {
            flex-basis: 46px;
            width: 46px;
            height: 46px;
        }

        .adm-page .adm-page-actions {
            justify-content: flex-start;
            width: 100%;
        }

        .adm-page .adm-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .adm-page .adm-search {
            flex-basis: auto;
        }

        .adm-page .adm-segment {
            justify-content: space-between;
        }

        .adm-page .adm-segment a {
            flex: 1 1 auto;
            justify-content: center;
        }

        .adm-page .adm-form-actions .adm-btn {
            flex: 1 1 auto;
        }
    }

    /* Narrow card (tablet, or laptop with sidebar): rows become a
       two-column grid of labelled fields. */
    @container admtable (max-width: 900px) {
        .adm-page table.adm-table thead {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        .adm-page table.adm-table,
        .adm-page table.adm-table tbody,
        .adm-page table.adm-table tr,
        .adm-page table.adm-table td {
            display: block;
            width: 100%;
        }

        .adm-page table.adm-table tbody tr {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem 1.5rem;
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #fbeef4;
        }

        .adm-page table.adm-table tbody tr:last-child {
            border-bottom: 0;
        }

        .adm-page table.adm-table tbody td {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.3rem;
            min-width: 0;
            padding: 0;
            border-bottom: 0;
            text-align: left;
            overflow-wrap: anywhere;
        }

        .adm-page table.adm-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .adm-page table.adm-table tbody td::before {
            content: attr(data-label);
            color: var(--adm-muted);
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .adm-page table.adm-table tbody td .adm-row-actions {
            justify-content: flex-start;
        }
    }

    /* Very narrow card (phones): one column, label beside value. */
    @container admtable (max-width: 520px) {
        .adm-page table.adm-table tbody tr {
            grid-template-columns: minmax(0, 1fr);
            gap: 0.55rem;
            padding: 0.9rem 1rem;
        }

        /* Label on the left; the cell's content (one or more lines)
           stacks on the right. */
        .adm-page table.adm-table tbody td {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            align-items: center;
            column-gap: 1rem;
            row-gap: 0.1rem;
            text-align: right;
        }

        .adm-page table.adm-table tbody td::before {
            grid-row: 1 / span 4;
            align-self: center;
            text-align: left;
        }

        .adm-page table.adm-table tbody td > * {
            grid-column: 2;
            justify-self: end;
        }

        .adm-page table.adm-table tbody td .adm-person {
            justify-content: flex-end;
            min-width: 0;
        }

        .adm-page table.adm-table tbody td .adm-row-actions {
            justify-content: flex-end;
        }
    }

    @media (max-width: 639px) {
        .adm-page .adm-card-head {
            flex-wrap: wrap;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .adm-page .adm-btn,
        .adm-page .adm-search,
        .adm-page .adm-segment a,
        .adm-page .adm-input,
        .adm-page .adm-report-card {
            transition: none;
        }
    }

    /* =============================================================
       REPORTS
       ============================================================= */

    /* Report category cards (Reports landing page) */
    .adm-page .adm-report-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1rem;
    }

    .adm-page .adm-report-card {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
        min-width: 0;
        padding: 1.4rem 1.4rem 1.2rem;
        overflow: hidden;
        color: inherit;
        text-decoration: none;
        background: linear-gradient(160deg, #ffffff 0%, #fffafd 100%);
        border: 1px solid var(--adm-line);
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .adm-page .adm-report-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, var(--adm-pink), rgba(244, 114, 182, 0.35));
    }

    .adm-page .adm-report-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.3rem;
    }

    .adm-page .adm-report-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        color: #ffffff;
        background: linear-gradient(135deg, var(--adm-rose) 0%, var(--adm-pink) 100%);
        border-radius: 15px;
        box-shadow: 0 8px 18px rgba(219, 39, 119, 0.22);
    }

    .adm-page .adm-report-icon svg {
        width: 24px;
        height: 24px;
    }

    .adm-page .adm-report-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        color: var(--adm-rose);
        background: var(--adm-blush);
        border-radius: 50%;
        transition: transform 0.2s ease;
    }

    .adm-page .adm-report-arrow svg {
        width: 16px;
        height: 16px;
    }

    .adm-page .adm-report-title {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.3rem;
        font-weight: 400;
        line-height: 1.25;
    }

    .adm-page .adm-report-desc {
        flex: 1 1 auto;
        margin: 0;
        color: var(--adm-muted);
        font-size: 0.86rem;
        line-height: 1.6;
    }

    .adm-page .adm-report-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.6rem;
        padding-top: 0.85rem;
        border-top: 1px solid var(--adm-line);
    }

    .adm-page .adm-report-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--adm-rose);
        font-size: 0.82rem;
        font-weight: 700;
    }

    .adm-page .adm-report-cta svg {
        width: 14px;
        height: 14px;
    }

    .adm-page .adm-report-meta {
        color: #94a3b8;
        font-size: 0.72rem;
        font-weight: 600;
    }

    @media (hover: hover) and (pointer: fine) {
        .adm-page .adm-report-card:hover {
            transform: translateY(-2px);
            border-color: #f9a8d4;
            box-shadow: var(--adm-shadow-hover);
        }

        .adm-page .adm-report-card:hover .adm-report-arrow {
            transform: translateX(3px);
        }
    }

    /* Filter form */
    .adm-page .adm-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .adm-page .adm-filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .adm-page .adm-filter-actions .adm-btn-primary {
        flex: 1 1 auto;
        min-height: 46px;
    }

    .adm-page .adm-btn-icon {
        flex: 0 0 46px;
        width: 46px;
        min-height: 46px;
        padding: 0;
    }

    /* Action bar (record count + Print / PDF) */
    .adm-page .adm-actionbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.25rem;
    }

    .adm-page .adm-actionbar-text {
        margin: 0;
        color: var(--adm-muted);
        font-size: 0.86rem;
    }

    .adm-page .adm-actionbar-text strong {
        color: var(--adm-rose);
    }

    .adm-page .adm-actionbar-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    /* Small code chip (mother code, infant ID) */
    .adm-page .adm-code {
        display: inline-block;
        padding: 0.2rem 0.55rem;
        color: #475569;
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-size: 0.76rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* More pill tones (status keeps its meaning; neutral for plain facts) */
    .adm-page .adm-pill-info    { color: #1d4ed8; background: #eff6ff; }
    .adm-page .adm-pill-warn    { color: #b45309; background: #fffbeb; }
    .adm-page .adm-pill-danger  { color: #be123c; background: #fff1f2; }
    .adm-page .adm-pill-pink    { color: var(--adm-deep); background: var(--adm-blush); }
    .adm-page .adm-pill-neutral { color: #475569; background: #f1f5f9; }

    .adm-page .adm-chip {
        display: inline-block;
        padding: 0.22rem 0.6rem;
        color: #475569;
        font-size: 0.76rem;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* Print-only pieces (official heading, signatures) never show on screen */
    @media screen {
        .adm-page .adm-print-only {
            display: none !important;
        }
    }

    /* Screen footer line under a report */
    .adm-page .adm-report-footer {
        color: #94a3b8;
        font-size: 0.76rem;
        line-height: 1.6;
        text-align: center;
    }

    .adm-page .adm-report-footer strong {
        color: var(--adm-muted);
    }

    /* Official print header */
    .adm-page .adm-print-header {
        display: grid;
        grid-template-columns: 64px 1fr 64px;
        align-items: center;
        gap: 12pt;
        padding-bottom: 8pt;
        border-bottom: 2px solid #9d174d;
    }

    .adm-page .adm-print-header img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

    .adm-page .adm-print-header-text {
        text-align: center;
    }

    .adm-page .adm-print-header-text p {
        margin: 0;
        line-height: 1.35;
    }

    .adm-page .adm-print-municipality {
        font-size: 10pt;
        letter-spacing: 0.04em;
    }

    .adm-page .adm-print-office {
        font-size: 13pt;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .adm-page .adm-print-system {
        font-size: 9pt;
        color: #555555;
    }

    .adm-page .adm-print-title {
        margin: 10pt 0 2pt;
        font-family: var(--adm-serif);
        font-size: 17pt;
        font-weight: 400;
        text-align: center;
    }

    .adm-page .adm-print-meta {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 4pt 16pt;
        margin: 6pt 0 0;
        font-size: 8.5pt;
        color: #444444;
    }

    /* Signature block */
    .adm-page .adm-signatures {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28pt;
        margin-top: 28pt;
    }

    .adm-page .adm-sign-label {
        margin: 0 0 28pt;
        font-size: 9pt;
        font-weight: 700;
    }

    .adm-page .adm-sign-line {
        padding-top: 4pt;
        border-top: 1px solid #222222;
        text-align: center;
    }

    .adm-page .adm-sign-name {
        margin: 0;
        min-height: 12pt;
        font-size: 10pt;
        font-weight: 700;
    }

    .adm-page .adm-sign-role {
        margin: 1pt 0 0;
        font-size: 8.5pt;
        color: #444444;
    }

    @media (min-width: 768px) {
        .adm-page .adm-report-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767px) {
        .adm-page .adm-actionbar {
            flex-direction: column;
            align-items: stretch;
        }

        .adm-page .adm-actionbar-buttons .adm-btn {
            flex: 1 1 auto;
        }
    }

    /* =============================================================
       PATIENT RECORDS (search)
       ============================================================= */

    /* Wider first column for the main search field */
    @media (min-width: 900px) {
        .adm-page .adm-filter-grid-wide {
            grid-template-columns: minmax(0, 2.2fr) repeat(2, minmax(0, 1fr)) auto;
        }
    }

    .adm-page .adm-match {
        margin: 0.2rem 0 0;
        color: var(--adm-rose);
        font-size: 0.76rem;
        font-weight: 600;
    }

    .adm-page .adm-record-counts {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        color: var(--adm-muted);
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .adm-page .adm-btn-disabled {
        color: #94a3b8;
        background: #f8fafc;
        border-color: #e2e8f0;
        cursor: not-allowed;
        box-shadow: none;
    }

    .adm-page .adm-pagination {
        padding: 0.9rem 1.15rem;
        border-top: 1px solid var(--adm-line);
    }

    /* RHU Patient Records Center landing: main search card */
    .adm-page .adm-records-hero {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
        padding: clamp(1.25rem, 3vw, 1.85rem);
        overflow: hidden;
        background:
            radial-gradient(520px 260px at 100% 0%, rgba(244, 114, 182, 0.18), transparent 70%),
            linear-gradient(120deg, #ffffff 0%, #fff7fb 100%);
        border: 1px solid var(--adm-line);
        border-radius: calc(var(--adm-radius) + 6px);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-records-hero::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, var(--adm-rose), var(--adm-pink), rgba(244, 114, 182, 0.4));
    }

    .adm-page .adm-records-hero-copy {
        display: flex;
        align-items: center;
        gap: 0.95rem;
        min-width: 0;
    }

    .adm-page .adm-records-hero-copy .adm-report-icon {
        flex: 0 0 50px;
    }

    .adm-page .adm-records-hero-title {
        margin: 0 0 0.2rem;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: clamp(1.45rem, 2.4vw, 1.85rem);
        font-weight: 400;
        line-height: 1.2;
    }

    /* "What you can do" cards */
    .adm-page .adm-records-steps {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1rem;
    }

    .adm-page .adm-records-step {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
        padding: 1.35rem;
        overflow: hidden;
        background: linear-gradient(160deg, #ffffff 0%, #fffafd 100%);
        border: 1px solid var(--adm-line);
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow);
    }

    .adm-page .adm-records-step::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, var(--adm-pink), rgba(244, 114, 182, 0.35));
    }

    .adm-page .adm-records-step .adm-report-icon {
        margin-bottom: 0.25rem;
    }

    @media (min-width: 900px) {
        .adm-page .adm-records-steps {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* =============================================================
       PATIENT RECORD (consolidated, read-only)
       ============================================================= */

    .adm-page .adm-record-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 60px;
        width: 60px;
        height: 60px;
        color: #ffffff;
        font-family: var(--adm-serif);
        font-size: 1.4rem;
        background: linear-gradient(135deg, var(--adm-rose) 0%, var(--adm-pink) 100%);
        border-radius: 50%;
        box-shadow: 0 8px 18px rgba(219, 39, 119, 0.24);
    }

    .adm-page .adm-record-avatar-sm {
        flex-basis: 46px;
        width: 46px;
        height: 46px;
        font-size: 1.05rem;
    }

    .adm-page .adm-record-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.4rem 0.9rem;
        margin-top: 0.45rem;
        color: var(--adm-muted);
        font-size: 0.82rem;
    }

    /* Section navigation: sticky on desktop, scrolls sideways on phones */
    .adm-page .adm-record-nav {
        position: sticky;
        top: 0;
        z-index: 5;
        display: flex;
        gap: 0.35rem;
        padding: 0.4rem;
        overflow-x: auto;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid var(--adm-line);
        border-radius: 14px;
        box-shadow: var(--adm-shadow);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        scrollbar-width: thin;
    }

    .adm-page .adm-record-nav a {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        flex: 0 0 auto;
        padding: 0.5rem 0.85rem;
        color: #475569;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        text-decoration: none;
        border-radius: 10px;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .adm-page .adm-record-nav a:hover {
        color: var(--adm-deep);
        background: var(--adm-blush);
    }

    .adm-page .adm-record-nav a span {
        min-width: 1.4rem;
        padding: 0.05rem 0.4rem;
        color: var(--adm-deep);
        font-size: 0.7rem;
        text-align: center;
        background: var(--adm-blush-2);
        border-radius: 999px;
    }

    .adm-page .adm-record-section {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        scroll-margin-top: 4.5rem;
    }

    .adm-page .adm-record-heading {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin: 0.4rem 0 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: clamp(1.3rem, 2vw, 1.55rem);
        font-weight: 400;
    }

    .adm-page .adm-record-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 0.9rem;
    }

    @media (min-width: 1100px) {
        .adm-page .adm-record-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* Label / value lists */
    .adm-page .adm-dl {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 0.9rem 1.25rem;
        margin: 0;
        padding: 1.1rem 1.35rem 1.25rem;
    }

    .adm-page .adm-dl > div {
        min-width: 0;
    }

    .adm-page .adm-dl .adm-dl-wide {
        grid-column: 1 / -1;
    }

    .adm-page .adm-dl dt {
        margin: 0 0 0.2rem;
        color: var(--adm-muted);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .adm-page .adm-dl dd {
        margin: 0;
        color: var(--adm-ink);
        font-size: 0.9rem;
        font-weight: 500;
        overflow-wrap: anywhere;
    }

    .adm-page .adm-dl-compact {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        padding-top: 0.9rem;
    }

    /* Prenatal visit cards */
    .adm-page .adm-visit-head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 1rem 1.35rem;
        background: linear-gradient(180deg, #fffafd 0%, #ffffff 100%);
        border-bottom: 1px solid var(--adm-line);
        border-radius: var(--adm-radius) var(--adm-radius) 0 0;
    }

    .adm-page .adm-visit-date {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.15rem;
    }

    .adm-page .adm-visit-sub {
        margin: 0.1rem 0 0;
        color: var(--adm-muted);
        font-size: 0.76rem;
    }

    .adm-page .adm-visit-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .adm-page .adm-visit-files {
        padding: 0 1.35rem 1.2rem;
    }

    .adm-page .adm-visit-files-title {
        margin: 0 0 0.5rem;
        color: var(--adm-muted);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .adm-page .adm-visit-files-title span {
        font-weight: 500;
        letter-spacing: normal;
        text-transform: none;
    }

    .adm-page .adm-file-list {
        display: grid;
        gap: 0.4rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .adm-page .adm-file-list li {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        min-width: 0;
        padding: 0.5rem 0.7rem;
        background: #fffafd;
        border: 1px solid var(--adm-line);
        border-radius: 10px;
    }

    .adm-page .adm-file-type {
        flex: 0 0 auto;
        padding: 0.12rem 0.45rem;
        color: var(--adm-deep);
        font-size: 0.66rem;
        font-weight: 700;
        background: var(--adm-blush-2);
        border-radius: 6px;
    }

    .adm-page .adm-file-name {
        flex: 1 1 auto;
        min-width: 0;
        color: var(--adm-ink);
        font-size: 0.84rem;
        overflow-wrap: anywhere;
    }

    .adm-page .adm-file-size {
        flex: 0 0 auto;
        color: #94a3b8;
        font-size: 0.74rem;
    }

    /* Infant cards */
    .adm-page .adm-infant {
        padding-bottom: 0.6rem;
    }

    .adm-page .adm-infant-head {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        padding: 1.1rem 1.35rem;
        background: linear-gradient(180deg, #fffafd 0%, #ffffff 100%);
        border-bottom: 1px solid var(--adm-line);
        border-radius: var(--adm-radius) var(--adm-radius) 0 0;
    }

    .adm-page .adm-infant-name {
        margin: 0;
        color: var(--adm-plum);
        font-family: var(--adm-serif);
        font-size: 1.25rem;
        font-weight: 400;
    }

    .adm-page .adm-subhead {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.4rem 1.35rem 0.6rem;
        color: var(--adm-deep);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .adm-page .adm-table-inset {
        width: auto;
        margin: 0 1.35rem 0.9rem;
        border: 1px solid var(--adm-line);
        border-radius: 12px;
        overflow: hidden;
    }

    .adm-page .adm-inset {
        margin: 0 1.35rem 0.9rem;
    }

    .adm-page .adm-small {
        font-size: 0.82rem;
    }

    .adm-page .adm-record-hint {
        margin: 0;
        color: var(--adm-muted);
        font-size: 0.8rem;
    }

    .adm-page .adm-birth-line {
        display: block;
    }

    /* Print / export section picker */
    .adm-page .adm-export {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 1rem;
        padding: 1.1rem 1.35rem;
    }

    .adm-page .adm-export-copy {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .adm-page .adm-export-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        border: 0;
    }

    .adm-page .adm-check {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0.75rem;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 600;
        background: #fffafd;
        border: 1px solid var(--adm-line);
        border-radius: 999px;
        cursor: pointer;
    }

    .adm-page .adm-check input {
        width: 16px;
        height: 16px;
        margin: 0;
        accent-color: var(--adm-pink);
        cursor: pointer;
    }

    .adm-page .adm-check:has(input:checked) {
        color: var(--adm-deep);
        background: var(--adm-blush-2);
        border-color: #f9a8d4;
    }

    .adm-page .adm-export-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    @media (min-width: 1100px) {
        .adm-page .adm-export {
            grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.6fr) auto;
            align-items: center;
        }
    }

    @media (max-width: 767px) {
        .adm-page .adm-export-actions .adm-btn {
            flex: 1 1 auto;
        }
    }

    @media (max-width: 639px) {
        .adm-page .adm-table-inset,
        .adm-page .adm-inset,
        .adm-page .adm-subhead {
            margin-left: 0.9rem;
            margin-right: 0.9rem;
        }

        .adm-page .adm-dl {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .adm-page .adm-visit-files {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* =============================================================
       PRINT — official report output
       Hides the web interface (sidebar, navigation, filters, action
       buttons, empty-state buttons) and prints a clean, paginated
       document with the RHU heading and signature lines.
       ============================================================= */
    @page {
        margin: 14mm 12mm 16mm;

        @bottom-right {
            content: "Page " counter(page) " of " counter(pages);
            font-family: "Inter", Arial, sans-serif;
            font-size: 8pt;
            color: #666666;
        }
    }

    @media print {
        .cc-admin-sidebar,
        .cc-admin-mobile-nav,
        .adm-page .adm-no-print {
            display: none !important;
        }

        .cc-admin-layout,
        .cc-admin-main,
        body {
            background: #ffffff !important;
        }

        .cc-admin-main {
            width: 100% !important;
            margin-left: 0 !important;
        }

        .adm-page {
            padding: 0;
            color: #111111;
            background: #ffffff;
        }

        .adm-page .adm-container {
            max-width: none;
            gap: 10pt;
            padding: 0;
        }

        .adm-page .adm-print-only {
            display: block;
        }

        .adm-page .adm-print-header.adm-print-only {
            display: grid;
        }

        .adm-page .adm-signatures.adm-print-only {
            display: grid;
        }

        .adm-page a {
            color: inherit;
            text-decoration: none;
        }

        /* Cards become plain bordered sections */
        .adm-page .adm-card,
        .adm-page .adm-stat {
            box-shadow: none;
            border-color: #cfcfcf;
            border-radius: 6px;
        }

        .adm-page .adm-card-head {
            padding: 6pt 8pt;
            background: none;
            border-bottom-color: #cfcfcf;
        }

        .adm-page .adm-card-icon,
        .adm-page .adm-stat-icon,
        .adm-page .adm-avatar,
        .adm-page .adm-stat::before {
            display: none;
        }

        .adm-page .adm-card-title {
            font-size: 12pt;
        }

        .adm-page .adm-card-sub {
            font-size: 8.5pt;
        }

        /* Summary: compact row of figures */
        .adm-page .adm-section-head {
            margin-bottom: 4pt;
        }

        .adm-page .adm-section-title {
            font-size: 12pt;
        }

        .adm-page .adm-section-sub {
            display: none;
        }

        .adm-page .adm-stats {
            grid-template-columns: repeat(auto-fit, minmax(90pt, 1fr));
            gap: 6pt;
        }

        .adm-page .adm-stat {
            padding: 5pt 8pt;
            break-inside: avoid;
        }

        .adm-page .adm-stat-value {
            font-size: 15pt;
        }

        .adm-page .adm-stat-label {
            font-size: 8pt;
            margin-top: 1pt;
        }

        /* Tables print as real tables (no stacked phone layout) */
        .adm-page .adm-table-scroll {
            overflow: visible;
            container-type: normal;
        }

        .adm-page table.adm-table {
            font-size: 8.5pt;
        }

        .adm-page table.adm-table thead {
            display: table-header-group;
        }

        .adm-page table.adm-table thead th {
            padding: 5pt 6pt;
            color: #111111;
            font-size: 7.5pt;
            background: #f3e8ee;
            border: 1px solid #cfcfcf;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .adm-page table.adm-table tbody td {
            padding: 4pt 6pt;
            color: #111111;
            border: 1px solid #dddddd;
        }

        .adm-page table.adm-table tbody tr {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .adm-page table.adm-table tbody tr:hover {
            background: none;
        }

        .adm-page .adm-subtext {
            display: none;
        }

        .adm-page .adm-pill,
        .adm-page .adm-chip,
        .adm-page .adm-code {
            padding: 0;
            color: #111111;
            font-size: inherit;
            font-weight: 600;
            background: none;
            border: 0;
        }

        .adm-page .adm-pill-dot {
            display: none;
        }

        .adm-page .adm-empty {
            padding: 12pt;
        }

        .adm-page .adm-empty-icon {
            display: none;
        }

        .adm-page .adm-signatures {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .adm-page .adm-report-footer {
            margin-top: 10pt;
            font-size: 7.5pt;
            color: #666666;
        }
    }
</style>
@endpush
@endonce
