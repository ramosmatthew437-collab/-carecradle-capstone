{{--
    Referral styles, scoped to .mrf. Same design language as the redesigned
    Mother Profile / Schedule Appointment pages (DM Serif Display headings,
    Inter body, pink and white). Inline so no Vite rebuild is needed.
--}}
@once
<style>
    .mrf { --mrf-pink-50: #fdf2f7; --mrf-pink-200: #f8d3e2; --mrf-pink-600: #db2777; --mrf-pink-700: #be185d; --mrf-line: #f1e3ea; --mrf-ink: #0f172a; --mrf-muted: #64748b; --mrf-faint: #94a3b8;
        color: #1e293b; font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif; }
    .mrf *, .mrf *::before, .mrf *::after { box-sizing: border-box; }
    .mrf-page { padding: 1rem 0 2.5rem; background: radial-gradient(circle at 8% 5%, rgba(249,168,212,0.12), transparent 30%), linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%); }
    .mrf-container { width: min(100% - 2rem, 48rem); margin: 0 auto; }
    .mrf-back { display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding: 0.5rem 0.875rem; color: var(--mrf-pink-700); background: #fff; border: 1px solid var(--mrf-pink-200); border-radius: 0.75rem; font-size: 0.8125rem; font-weight: 600; text-decoration: none; }
    .mrf-back:hover { background: var(--mrf-pink-50); }
    .mrf-kicker { margin: 0 0 0.125rem; color: var(--mrf-pink-700); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; }
    .mrf-title { margin: 0; color: var(--mrf-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: clamp(1.5rem, 2.4vw, 2rem); font-weight: 400; line-height: 1.15; }
    .mrf-sub { margin: 0.25rem 0 1rem; color: var(--mrf-muted); font-size: 0.875rem; line-height: 1.5; }
    .mrf-card { margin-bottom: 1rem; padding: 1.125rem 1.25rem; background: #fff; border: 1px solid var(--mrf-line); border-radius: 1rem; box-shadow: 0 1px 2px rgba(15,23,42,0.03); }
    .mrf-card-title { margin: 0 0 0.75rem; color: var(--mrf-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: 1.125rem; font-weight: 400; }
    .mrf-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
    .mrf-full { grid-column: 1 / -1; }
    .mrf-field { display: flex; flex-direction: column; gap: 0.375rem; min-width: 0; }
    .mrf-label { color: #334155; font-size: 0.8125rem; font-weight: 600; }
    .mrf-label .mrf-req { color: #e11d48; }
    .mrf-input, .mrf-textarea { width: 100%; min-height: 2.75rem; padding: 0.625rem 0.875rem; color: var(--mrf-ink); background: #fff; border: 1px solid #e5d5dd; border-radius: 0.875rem; font: inherit; font-size: 0.875rem; }
    .mrf-textarea { min-height: 5.5rem; resize: vertical; }
    .mrf-input:focus, .mrf-textarea:focus { outline: none; border-color: var(--mrf-pink-600); box-shadow: 0 0 0 3px rgba(219,39,119,0.15); }
    .mrf-hint { margin: 0; color: var(--mrf-muted); font-size: 0.75rem; line-height: 1.5; }
    .mrf-error { margin: 0; color: #be123c; font-size: 0.75rem; font-weight: 600; }
    .mrf-actions { display: flex; flex-wrap: wrap; gap: 0.625rem; margin-top: 1rem; }
    .mrf-btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.375rem; min-height: 2.5rem; padding: 0.5rem 1rem; border: 1px solid transparent; border-radius: 0.75rem; font: inherit; font-size: 0.8125rem; font-weight: 700; text-decoration: none; cursor: pointer; }
    .mrf-btn-primary { color: #fff; background: linear-gradient(135deg, #be185d, #db2777); border-color: #be185d; }
    .mrf-btn-secondary { color: var(--mrf-pink-700); background: #fff; border-color: var(--mrf-pink-200); }
    .mrf-btn-secondary:hover { background: var(--mrf-pink-50); }
    .mrf-btn-quiet { color: #475569; background: #fff; border-color: #e2e8f0; }
    .mrf-btn-danger { color: #9f1239; background: #fff1f2; border-color: #fecdd3; }
    .mrf-alert { display: flex; gap: 0.625rem; align-items: flex-start; margin-bottom: 1rem; padding: 0.75rem 0.875rem; border: 1px solid; border-radius: 0.875rem; font-size: 0.8125rem; line-height: 1.5; }
    .mrf-alert strong { display: block; font-weight: 600; }
    .mrf-alert-success { color: #065f46; background: #ecfdf5; border-color: #a7f3d0; }
    .mrf-alert-error { color: #9f1239; background: #fff1f2; border-color: #fecdd3; }
    .mrf-alert-info { color: #92400e; background: #fffbeb; border-color: #fde68a; }
    .mrf-alert ul { margin: 0.25rem 0 0; padding-left: 1.125rem; }
    .mrf-dl { display: grid; grid-template-columns: minmax(0, 10rem) minmax(0, 1fr); gap: 0.5rem 1rem; margin: 0; font-size: 0.8125rem; }
    .mrf-dl dt { color: var(--mrf-muted); font-weight: 500; }
    .mrf-dl dd { margin: 0; color: var(--mrf-ink); font-weight: 500; white-space: pre-line; overflow-wrap: anywhere; }
    .mrf-badge { display: inline-flex; align-items: center; gap: 0.3125rem; padding: 0.125rem 0.5625rem; border: 1px solid; border-radius: 999px; font-size: 0.6875rem; font-weight: 700; white-space: nowrap; }
    .mrf-badge::before { content: ""; width: 0.375rem; height: 0.375rem; border-radius: 999px; background: currentColor; }
    .mrf-b-active { color: #92400e; background: #fffbeb; border-color: #fde68a; }
    .mrf-b-closed { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
    .mrf-b-error { color: #475569; background: #f8fafc; border-color: #e2e8f0; }
    .mrf-history { margin: 0; padding: 0; list-style: none; }
    .mrf-history li { padding: 0.75rem 0; border-top: 1px solid #f6eef2; font-size: 0.8125rem; }
    .mrf-history li:first-child { border-top: 0; }
    .mrf-history-head { display: flex; flex-wrap: wrap; align-items: center; gap: 0.375rem 0.625rem; color: var(--mrf-ink); font-weight: 600; }
    .mrf-history p { margin: 0.25rem 0 0; color: var(--mrf-muted); line-height: 1.5; white-space: pre-line; overflow-wrap: anywhere; }
    .mrf details { margin-top: 1rem; }
    .mrf summary { cursor: pointer; color: #9f1239; font-size: 0.8125rem; font-weight: 600; }
    /* Receiving-facility combo box (enhanced by the script in _fields.blade.php) */
    .mrf-combo { position: relative; }
    .mrf-combo.has-toggle .mrf-input { padding-right: 2.75rem; }
    .mrf-combo-toggle { position: absolute; top: 0.375rem; right: 0.375rem; display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; padding: 0; color: var(--mrf-pink-700); background: transparent; border: 0; border-radius: 0.625rem; cursor: pointer; }
    .mrf-combo-toggle:hover { background: var(--mrf-pink-50); }
    .mrf-combo-toggle svg { width: 1rem; height: 1rem; transition: transform 0.15s ease; }
    .mrf-combo.is-open .mrf-combo-toggle svg { transform: rotate(180deg); }
    .mrf-combo-list { position: absolute; z-index: 30; top: calc(100% + 0.375rem); left: 0; right: 0; max-height: 15rem; margin: 0; padding: 0.375rem; overflow-y: auto; overscroll-behavior: contain; list-style: none; background: #fff; border: 1px solid var(--mrf-pink-200); border-radius: 0.875rem; box-shadow: 0 12px 28px -12px rgba(190,24,93,0.28), 0 2px 6px rgba(15,23,42,0.06); }
    .mrf-combo-list[hidden], .mrf-combo-option[hidden], .mrf-combo-empty[hidden] { display: none; }
    .mrf-combo-option { display: flex; align-items: center; min-height: 2.75rem; padding: 0.5rem 0.75rem; color: var(--mrf-ink); border-radius: 0.625rem; font-size: 0.875rem; line-height: 1.35; overflow-wrap: anywhere; cursor: pointer; }
    .mrf-combo-option:hover { background: var(--mrf-pink-50); }
    .mrf-combo-option.is-active { color: var(--mrf-pink-700); background: var(--mrf-pink-50); box-shadow: inset 0 0 0 1px var(--mrf-pink-200); }
    .mrf-combo-option.is-current { font-weight: 600; }
    .mrf-combo-empty { padding: 0.625rem 0.75rem; color: var(--mrf-muted); font-size: 0.8125rem; line-height: 1.5; }
    .mrf-sr-only { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
    @media (max-width: 640px) {
        .mrf-combo .mrf-input { font-size: 1rem; } /* 16px: stops iOS zooming into the field */
        .mrf-combo-list { max-height: 50vh; }
        .mrf-grid { grid-template-columns: minmax(0, 1fr); }
        .mrf-dl { grid-template-columns: minmax(0, 1fr); gap: 0.125rem; }
        .mrf-dl dd { margin-bottom: 0.5rem; }
        .mrf-actions .mrf-btn { flex: 1 1 auto; }
        .mrf-container { width: calc(100% - 1.5rem); }
    }
</style>
@endonce
