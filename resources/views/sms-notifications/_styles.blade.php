{{--
    SMS Notifications (Communication Center) styles, scoped to .smx.
    Same design language as the redesigned Mother Profile and Schedule
    Appointment pages: DM Serif Display headings, Inter body, pink and white.
    Inline so the pages need no Vite rebuild.
--}}
@once
<style>
    .smx {
        --smx-pink-50: #fdf2f7;
        --smx-pink-100: #fce4ee;
        --smx-pink-200: #f8d3e2;
        --smx-pink-600: #db2777;
        --smx-pink-700: #be185d;
        --smx-pink-800: #9d174d;
        --smx-line: #f1e3ea;
        --smx-ink: #0f172a;
        --smx-text: #1e293b;
        --smx-muted: #64748b;
        --smx-faint: #94a3b8;
        --smx-green: #047857; --smx-green-bg: #ecfdf5; --smx-green-line: #a7f3d0;
        --smx-amber: #b45309; --smx-amber-bg: #fffbeb; --smx-amber-line: #fde68a;
        --smx-rose: #be123c;  --smx-rose-bg: #fff1f2;  --smx-rose-line: #fecdd3;
        --smx-blue: #1d4ed8;  --smx-blue-bg: #eff6ff;  --smx-blue-line: #bfdbfe;
        --smx-violet: #6d28d9; --smx-violet-bg: #f5f3ff; --smx-violet-line: #ddd6fe;
        --smx-slate: #475569; --smx-slate-bg: #f8fafc; --smx-slate-line: #e2e8f0;

        padding: 1rem 0 2.5rem;
        color: var(--smx-text);
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        background:
            radial-gradient(circle at 8% 5%, rgba(249, 168, 212, 0.12), transparent 30%),
            linear-gradient(180deg, #fff7fa 0%, #fffafd 45%, #ffffff 100%);
    }
    .smx *, .smx *::before, .smx *::after { box-sizing: border-box; }
    .smx-container { width: min(100% - 2rem, 76rem); margin: 0 auto; }
    .smx-sr { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    .smx a { color: inherit; }
    .smx :focus-visible { outline: 2px solid var(--smx-pink-600); outline-offset: 2px; border-radius: 0.375rem; }

    /* ---------- Heading ---------- */
    .smx-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem 1rem; margin-bottom: 1rem; }
    .smx-head-main { display: flex; align-items: center; gap: 0.875rem; min-width: 0; }
    .smx-head-icon { display: inline-flex; flex: 0 0 auto; align-items: center; justify-content: center; width: 2.75rem; height: 2.75rem; color: var(--smx-pink-700); background: var(--smx-pink-50); border: 1px solid #f8dde9; border-radius: 0.875rem; }
    .smx-head-icon svg { width: 1.375rem; height: 1.375rem; }
    .smx-kicker { margin: 0 0 0.125rem; color: var(--smx-pink-700); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; }
    .smx-title { margin: 0; color: var(--smx-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: clamp(1.5rem, 2.4vw, 2rem); font-weight: 400; line-height: 1.15; letter-spacing: -0.015em; overflow-wrap: anywhere; }
    .smx-subtitle { margin: 0.25rem 0 0; color: var(--smx-muted); font-size: 0.875rem; line-height: 1.5; max-width: 46rem; }

    .smx-back { display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding: 0.5rem 0.875rem; color: var(--smx-pink-700); background: #fff; border: 1px solid var(--smx-pink-200); border-radius: 0.75rem; font-size: 0.8125rem; font-weight: 600; text-decoration: none; }
    .smx-back:hover { background: var(--smx-pink-50); }
    .smx-back svg { width: 1rem; height: 1rem; }

    /* ---------- Alerts ---------- */
    .smx-alert { display: flex; gap: 0.75rem; align-items: flex-start; margin-bottom: 1rem; padding: 0.875rem 1rem; border: 1px solid; border-radius: 0.875rem; font-size: 0.875rem; line-height: 1.5; }
    .smx-alert svg { flex: 0 0 auto; width: 1.25rem; height: 1.25rem; margin-top: 0.0625rem; }
    .smx-alert strong { display: block; font-weight: 600; }
    .smx-alert p { margin: 0.125rem 0 0; }
    .smx-alert ul { margin: 0.25rem 0 0; padding-left: 1.125rem; }
    .smx-alert-success { color: #065f46; background: var(--smx-green-bg); border-color: var(--smx-green-line); }
    .smx-alert-warning { color: #92400e; background: var(--smx-amber-bg); border-color: var(--smx-amber-line); }
    .smx-alert-error { color: #9f1239; background: var(--smx-rose-bg); border-color: var(--smx-rose-line); }
    .smx-alert-info { color: #1e40af; background: var(--smx-blue-bg); border-color: var(--smx-blue-line); }

    /* ---------- Stat cards ---------- */
    .smx-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.75rem; margin-bottom: 1rem; }
    .smx-stat { display: flex; flex-direction: column; gap: 0.25rem; min-width: 0; padding: 0.875rem 1rem; color: inherit; background: #fff; border: 1px solid var(--smx-line); border-radius: 1rem; text-decoration: none; box-shadow: 0 1px 2px rgba(15,23,42,0.03); transition: border-color 0.15s ease, box-shadow 0.15s ease; }
    .smx-stat:hover { border-color: var(--smx-pink-200); box-shadow: 0 4px 14px rgba(190,24,93,0.07); }
    .smx-stat[aria-current="true"] { border-color: var(--smx-pink-600); box-shadow: 0 0 0 1px var(--smx-pink-600); }
    .smx-stat-label { display: flex; align-items: center; gap: 0.375rem; color: var(--smx-muted); font-size: 0.75rem; font-weight: 600; }
    .smx-stat-dot { width: 0.5rem; height: 0.5rem; border-radius: 999px; background: var(--smx-faint); }
    .smx-stat-value { color: var(--smx-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: 1.625rem; line-height: 1.1; }
    .smx-stats-note { margin: -0.375rem 0 1rem; color: var(--smx-muted); font-size: 0.75rem; }

    /* ---------- Filter bar ---------- */
    .smx-filters { display: grid; grid-template-columns: minmax(0, 2.4fr) minmax(0, 1fr) auto; gap: 0.625rem; align-items: end; margin-bottom: 1rem; padding: 0.875rem; background: #fff; border: 1px solid var(--smx-line); border-radius: 1rem; }
    .smx-field { display: flex; flex-direction: column; gap: 0.3125rem; min-width: 0; }
    .smx-label { color: var(--smx-muted); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; }
    .smx-input, .smx-select, .smx-textarea { width: 100%; min-height: 2.625rem; padding: 0.5rem 0.75rem; color: var(--smx-ink); background: #fff; border: 1px solid #e5d5dd; border-radius: 0.75rem; font: inherit; font-size: 0.875rem; }
    .smx-input:focus, .smx-select:focus, .smx-textarea:focus { outline: none; border-color: var(--smx-pink-600); box-shadow: 0 0 0 3px rgba(219,39,119,0.15); }
    .smx-search { position: relative; }
    .smx-search svg { position: absolute; left: 0.75rem; top: 50%; width: 1rem; height: 1rem; color: var(--smx-faint); transform: translateY(-50%); pointer-events: none; }
    .smx-search .smx-input { padding-left: 2.25rem; }
    .smx-filter-actions { display: flex; gap: 0.5rem; }

    /* ---------- Buttons ---------- */
    .smx-btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.375rem; min-height: 2.375rem; padding: 0.5rem 0.875rem; border: 1px solid transparent; border-radius: 0.75rem; font: inherit; font-size: 0.8125rem; font-weight: 600; line-height: 1.2; white-space: nowrap; text-decoration: none; cursor: pointer; transition: background 0.15s ease, border-color 0.15s ease, opacity 0.15s ease; }
    .smx-btn svg { width: 1rem; height: 1rem; flex: 0 0 auto; }
    .smx-btn-primary { color: #fff; background: var(--smx-pink-600); border-color: var(--smx-pink-600); }
    .smx-btn-primary:hover { background: var(--smx-pink-700); border-color: var(--smx-pink-700); }
    .smx-btn-secondary { color: var(--smx-pink-700); background: #fff; border-color: var(--smx-pink-200); }
    .smx-btn-secondary:hover { background: var(--smx-pink-50); }
    .smx-btn-quiet { color: var(--smx-slate); background: #fff; border-color: var(--smx-slate-line); }
    .smx-btn-quiet:hover { background: var(--smx-slate-bg); }
    .smx-btn-warn { color: #92400e; background: var(--smx-amber-bg); border-color: var(--smx-amber-line); }
    .smx-btn-warn:hover { background: #fef3c7; }
    .smx-btn[disabled], .smx-btn[aria-disabled="true"] { opacity: 0.6; cursor: not-allowed; }
    .smx-btn-sm { min-height: 2rem; padding: 0.375rem 0.625rem; font-size: 0.75rem; }
    .smx-spinner { width: 0.875rem; height: 0.875rem; border: 2px solid currentColor; border-right-color: transparent; border-radius: 999px; animation: smx-spin 0.7s linear infinite; }
    @keyframes smx-spin { to { transform: rotate(360deg); } }
    @media (prefers-reduced-motion: reduce) { .smx-spinner { animation-duration: 2.5s; } }

    /* ---------- Badges ---------- */
    .smx-badge { display: inline-flex; align-items: center; gap: 0.3125rem; padding: 0.1875rem 0.5625rem; border: 1px solid; border-radius: 999px; font-size: 0.6875rem; font-weight: 700; line-height: 1.4; white-space: nowrap; }
    .smx-badge::before { content: ""; width: 0.375rem; height: 0.375rem; border-radius: 999px; background: currentColor; }
    .smx-badge-plain::before { display: none; }
    .smx-badge { flex-shrink: 0; }
    .smx-card-title .smx-badge { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    .smx-deleted { color: var(--smx-slate); background: var(--smx-slate-bg); border-color: var(--smx-slate-line); letter-spacing: 0.01em; }
    .smx-s-pending   { color: var(--smx-amber);  background: var(--smx-amber-bg);  border-color: var(--smx-amber-line); }
    .smx-s-sending   { color: var(--smx-blue);   background: var(--smx-blue-bg);   border-color: var(--smx-blue-line); }
    .smx-s-sent      { color: var(--smx-green);  background: var(--smx-green-bg);  border-color: var(--smx-green-line); }
    /* Verified delivery (TextBee status lookup): shown beside "Sent", never instead of it. */
    .smx-delivered   { color: #ffffff; background: var(--smx-green); border-color: var(--smx-green); }
    .smx-s-failed    { color: var(--smx-rose);   background: var(--smx-rose-bg);   border-color: var(--smx-rose-line); }
    .smx-s-unknown   { color: var(--smx-violet); background: var(--smx-violet-bg); border-color: var(--smx-violet-line); }
    .smx-s-cancelled, .smx-s-expired { color: var(--smx-slate); background: var(--smx-slate-bg); border-color: var(--smx-slate-line); }
    .smx-s-review    { color: #9a3412; background: #fff7ed; border-color: #fed7aa; }
    .smx-dot-pending { background: #f59e0b; } .smx-dot-sent { background: #10b981; } .smx-dot-failed { background: #f43f5e; }
    .smx-dot-review { background: #f97316; } .smx-dot-overdue { background: #8b5cf6; } .smx-dot-total { background: var(--smx-pink-600); }

    /* ---------- List ---------- */
    .smx-panel { background: #fff; border: 1px solid var(--smx-line); border-radius: 1rem; box-shadow: 0 1px 2px rgba(15,23,42,0.03); }
    .smx-list-head, .smx-row { display: grid; grid-template-columns: minmax(0, 1.45fr) minmax(0, 1.35fr) minmax(0, 1fr) minmax(0, 1.1fr) 9.5rem; gap: 1rem; align-items: start; padding: 0.875rem 1.125rem; }
    .smx-list-head { padding-top: 0.75rem; padding-bottom: 0.75rem; color: var(--smx-faint); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; border-bottom: 1px solid var(--smx-line); }
    .smx-row { border-bottom: 1px solid #f6eef2; }
    .smx-row:last-child { border-bottom: 0; }
    .smx-row:hover { background: #fffbfd; }
    .smx-cell { min-width: 0; font-size: 0.8125rem; line-height: 1.45; }
    .smx-cell-label { display: none; }
    .smx-name { display: block; color: var(--smx-ink); font-weight: 600; font-size: 0.875rem; overflow-wrap: anywhere; text-decoration: none; }
    a.smx-name:hover { color: var(--smx-pink-700); text-decoration: underline; }
    .smx-meta { display: block; color: var(--smx-muted); font-size: 0.75rem; overflow-wrap: anywhere; }
    .smx-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 0.75rem; }
    .smx-flags { display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.375rem; }
    .smx-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 0.375rem; }
    .smx-actions form { margin: 0; }
    .smx-results { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 0.5rem; margin: 0 0 0.625rem; color: var(--smx-muted); font-size: 0.8125rem; }
    .smx-pagination { margin-top: 1rem; }

    .smx-empty { padding: 2.75rem 1.25rem; text-align: center; }
    .smx-empty-icon { display: inline-flex; align-items: center; justify-content: center; width: 3rem; height: 3rem; margin-bottom: 0.75rem; color: var(--smx-pink-700); background: var(--smx-pink-50); border-radius: 999px; }
    .smx-empty-icon svg { width: 1.5rem; height: 1.5rem; }
    .smx-empty h2 { margin: 0; color: var(--smx-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: 1.25rem; font-weight: 400; }
    .smx-empty p { margin: 0.375rem auto 1rem; max-width: 30rem; color: var(--smx-muted); font-size: 0.875rem; }

    /* ---------- Show page ---------- */
    .smx-grid { display: grid; grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr); gap: 1rem; align-items: start; }
    .smx-stack { display: flex; flex-direction: column; gap: 1rem; min-width: 0; }
    .smx-card { padding: 1.125rem 1.25rem; background: #fff; border: 1px solid var(--smx-line); border-radius: 1rem; box-shadow: 0 1px 2px rgba(15,23,42,0.03); min-width: 0; }
    .smx-card-title { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin: 0 0 0.875rem; color: var(--smx-ink); font-family: 'DM Serif Display', Georgia, serif; font-size: 1.125rem; font-weight: 400; }
    .smx-card-title .smx-count { color: var(--smx-muted); font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; font-size: 0.75rem; font-weight: 500; }
    .smx-dl { display: grid; grid-template-columns: minmax(0, 9rem) minmax(0, 1fr); gap: 0.5rem 0.875rem; margin: 0; font-size: 0.8125rem; }
    .smx-dl dt { color: var(--smx-muted); font-weight: 500; }
    .smx-dl dd { margin: 0; color: var(--smx-ink); font-weight: 500; overflow-wrap: anywhere; }
    .smx-message { margin: 0; padding: 1rem; color: var(--smx-ink); background: #fffafc; border: 1px solid var(--smx-pink-100); border-radius: 0.875rem; font: inherit; font-size: 0.875rem; line-height: 1.6; white-space: pre-wrap; overflow-wrap: anywhere; }
    .smx-hint { margin: 0.5rem 0 0; color: var(--smx-muted); font-size: 0.75rem; line-height: 1.5; }
    .smx-compare { display: grid; grid-template-columns: 1fr 1fr; gap: 0.625rem; margin-top: 0.75rem; }
    .smx-compare div { padding: 0.625rem 0.75rem; background: var(--smx-slate-bg); border: 1px solid var(--smx-slate-line); border-radius: 0.75rem; min-width: 0; }
    .smx-compare span { display: block; color: var(--smx-muted); font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    .smx-compare strong { display: block; margin-top: 0.125rem; color: var(--smx-ink); font-size: 0.875rem; overflow-wrap: anywhere; }
    .smx-compare .smx-diff { background: var(--smx-amber-bg); border-color: var(--smx-amber-line); }

    .smx-timeline { margin: 0; padding: 0; list-style: none; }
    .smx-timeline li { position: relative; padding: 0 0 1rem 1.5rem; border-left: 2px solid var(--smx-line); margin-left: 0.375rem; }
    .smx-timeline li:last-child { padding-bottom: 0; border-left-color: transparent; }
    .smx-timeline li::before { content: ""; position: absolute; left: -0.4375rem; top: 0.125rem; width: 0.75rem; height: 0.75rem; border-radius: 999px; background: #fff; border: 2px solid var(--smx-pink-600); }
    .smx-timeline-head { display: flex; flex-wrap: wrap; align-items: center; gap: 0.375rem 0.5rem; font-size: 0.8125rem; font-weight: 600; color: var(--smx-ink); }
    .smx-timeline p { margin: 0.25rem 0 0; color: var(--smx-muted); font-size: 0.75rem; line-height: 1.5; overflow-wrap: anywhere; }

    .smx-choice { display: flex; gap: 0.625rem; align-items: flex-start; padding: 0.625rem 0.75rem; border: 1px solid var(--smx-slate-line); border-radius: 0.75rem; cursor: pointer; font-size: 0.8125rem; }
    .smx-choice + .smx-choice { margin-top: 0.5rem; }
    .smx-choice:has(input:checked) { border-color: var(--smx-pink-600); background: var(--smx-pink-50); }
    .smx-choice input { margin-top: 0.1875rem; accent-color: var(--smx-pink-600); }
    .smx-choice strong { display: block; color: var(--smx-ink); }
    .smx-choice span { color: var(--smx-muted); font-size: 0.75rem; }
    .smx-textarea { min-height: 4.5rem; resize: vertical; }
    .smx-error { margin: 0.375rem 0 0; color: var(--smx-rose); font-size: 0.75rem; font-weight: 600; }
    .smx-action-stack { display: flex; flex-direction: column; gap: 0.5rem; }
    .smx-action-stack .smx-btn { width: 100%; }

    /* ---------- Automatic reminder monitor ---------- */
    .smx-monitor { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, 2fr) auto; gap: 0.75rem 1.25rem; align-items: center; margin-bottom: 1rem; padding: 0.875rem 1.125rem; background: #fff; border: 1px solid var(--smx-line); border-left-width: 4px; border-radius: 1rem; }
    .smx-monitor-active { border-left-color: #10b981; }
    .smx-monitor-delayed { border-left-color: #f59e0b; }
    .smx-monitor-not_reporting { border-left-color: #f43f5e; }
    .smx-monitor-main { display: flex; gap: 0.75rem; align-items: flex-start; min-width: 0; }
    .smx-monitor-icon { display: inline-flex; flex: 0 0 auto; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; color: var(--smx-pink-700); background: var(--smx-pink-50); border-radius: 0.75rem; }
    .smx-monitor-icon svg { width: 1.125rem; height: 1.125rem; }
    .smx-monitor-copy { min-width: 0; }
    .smx-monitor-title { display: flex; flex-wrap: wrap; align-items: center; gap: 0.375rem 0.5rem; margin: 0; color: var(--smx-ink); font-size: 0.875rem; font-weight: 700; }
    .smx-monitor-reason { margin: 0.25rem 0 0; color: var(--smx-muted); font-size: 0.75rem; line-height: 1.45; }
    .smx-m-active { color: var(--smx-green); background: var(--smx-green-bg); border-color: var(--smx-green-line); }
    .smx-m-delayed { color: var(--smx-amber); background: var(--smx-amber-bg); border-color: var(--smx-amber-line); }
    .smx-m-not_reporting { color: var(--smx-rose); background: var(--smx-rose-bg); border-color: var(--smx-rose-line); }
    .smx-monitor-facts { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.5rem 1rem; margin: 0; }
    .smx-monitor-facts dt { color: var(--smx-faint); font-size: 0.625rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; }
    .smx-monitor-facts dd { margin: 0.125rem 0 0; color: var(--smx-ink); font-size: 0.75rem; font-weight: 500; line-height: 1.4; overflow-wrap: anywhere; }
    .smx-result-failed { color: var(--smx-rose); font-weight: 700; }
    .smx-result-running { color: var(--smx-blue); font-weight: 700; }
    .smx-monitor-sub { display: block; margin-top: 0.125rem; color: var(--smx-muted); font-size: 0.6875rem; }
    .smx-monitor-facts .smx-monitor-sub-dt { margin-top: 0.375rem; }
    .smx-trigger { display: inline-flex; padding: 0.0625rem 0.5rem; border: 1px solid var(--smx-slate-line); border-radius: 999px; background: var(--smx-slate-bg); color: var(--smx-slate); font-size: 0.6875rem; font-weight: 600; white-space: nowrap; }
    .smx-trigger-scheduler { color: #0f766e; background: #f0fdfa; border-color: #99f6e4; }
    .smx-monitor-link { color: var(--smx-pink-700) !important; font-size: 0.8125rem; font-weight: 600; white-space: nowrap; text-decoration: none; }
    .smx-monitor-link:hover { text-decoration: underline; }

    /* ---------- Attention filters + source ---------- */
    .smx-attention { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin: -0.25rem 0 1rem; font-size: 0.75rem; color: var(--smx-muted); }
    .smx-attention-label { font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; font-size: 0.625rem; color: var(--smx-faint); }
    .smx-chip { display: inline-flex; align-items: center; gap: 0.375rem; min-height: 2rem; padding: 0.25rem 0.75rem; color: var(--smx-text); background: #fff; border: 1px solid var(--smx-slate-line); border-radius: 999px; font-weight: 600; text-decoration: none; }
    .smx-chip:hover { border-color: var(--smx-pink-200); background: var(--smx-pink-50); }
    .smx-chip[aria-current="true"] { color: var(--smx-pink-800); background: var(--smx-pink-50); border-color: var(--smx-pink-600); }
    .smx-chip-count { display: inline-flex; min-width: 1.25rem; justify-content: center; padding: 0 0.375rem; color: #fff; background: #f97316; border-radius: 999px; font-size: 0.6875rem; }
    .smx-chip-overdue .smx-chip-count { background: #8b5cf6; }
    .smx-chip-zero .smx-chip-count { color: var(--smx-muted); background: var(--smx-slate-line); }
    .smx-source { display: inline-flex; align-items: center; gap: 0.25rem; margin-top: 0.25rem; padding: 0.0625rem 0.5rem; color: var(--smx-slate); background: var(--smx-slate-bg); border: 1px solid var(--smx-slate-line); border-radius: 999px; font-size: 0.6875rem; font-weight: 600; }
    .smx-source-auto { color: #0f766e; background: #f0fdfa; border-color: #99f6e4; }
    .smx-runs { width: 100%; border-collapse: collapse; font-size: 0.8125rem; }
    .smx-runs th { padding: 0.75rem 1rem; color: var(--smx-faint); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; text-align: left; border-bottom: 1px solid var(--smx-line); }
    .smx-runs td { padding: 0.75rem 1rem; border-bottom: 1px solid #f6eef2; vertical-align: top; }
    .smx-runs tr:last-child td { border-bottom: 0; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1180px) {
        .smx-monitor { grid-template-columns: minmax(0, 1fr) auto; }
        .smx-monitor-facts { grid-column: 1 / -1; grid-row: 2; }
    }
    @media (max-width: 700px) {
        .smx-monitor-facts { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) {
        .smx-runs thead { display: none; }
        .smx-runs tr { display: block; padding: 0.75rem 1rem; border-bottom: 1px solid #f6eef2; }
        .smx-runs td { display: flex; justify-content: space-between; gap: 1rem; padding: 0.1875rem 0; border: 0; }
        .smx-runs td { flex-wrap: wrap; }
        .smx-runs td .smx-meta { flex: 1 0 100%; text-align: right; }
        .smx-runs td::before { content: attr(data-label); color: var(--smx-faint); font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
    }
    @media (max-width: 400px) {
        .smx-monitor { grid-template-columns: minmax(0, 1fr); }
        /* Compact on phones: short facts side by side, the longer "Last result" full width. */
        .smx-monitor-facts { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-row: auto; gap: 0.5rem 0.75rem; }
        .smx-monitor-facts > div:nth-child(3) { grid-column: 1 / -1; grid-row: 2; }
    }
    @media (max-width: 700px) {
        .smx-monitor { gap: 0.625rem 1rem; padding: 0.75rem 0.875rem; }
        .smx-monitor-link { display: inline-flex; align-items: center; min-height: 44px; }
    }
    @media (max-width: 960px) {
        .smx-filters { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); }
        .smx-filters .smx-search-field { grid-column: 1 / -1; }
        .smx-filter-actions { grid-column: 1 / -1; }
        .smx-filter-actions .smx-btn { flex: 1 1 0; }
        .smx-list-head { display: none; }
        .smx-row { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 0.75rem 1rem; padding: 1rem; }
        .smx-cell-label { display: block; margin-bottom: 0.125rem; color: var(--smx-faint); font-size: 0.625rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; }
        .smx-cell-recipient { grid-column: 1 / -1; }
        .smx-cell-actions { grid-column: 1 / -1; }
        .smx-actions { justify-content: flex-start; }
        .smx-grid { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 560px) {
        .smx-container { width: calc(100% - 1.5rem); }
        .smx-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.5rem; }
        .smx-stat { padding: 0.75rem; }
        .smx-stat-value { font-size: 1.375rem; }
        .smx-filters { grid-template-columns: minmax(0, 1fr); }
        .smx-row { grid-template-columns: minmax(0, 1fr); }
        .smx-actions .smx-btn, .smx-actions form { flex: 1 1 auto; }
        .smx-actions form .smx-btn { width: 100%; }
        .smx-dl { grid-template-columns: minmax(0, 1fr); gap: 0.125rem; }
        .smx-dl dd { margin-bottom: 0.5rem; }
        .smx-compare { grid-template-columns: minmax(0, 1fr); }
        .smx-card { padding: 1rem; }
    }
</style>
@endonce
