{{--
    Edit Mother page refinements, scoped to this page (.me-wrap / .me-form).
    Inline so the page needs no Vite rebuild. Builds on resources/css/mother-edit.css.
--}}
@once
<style>
    /* ---------- Mother Account Information ---------- */
    .me-wrap .me-identity { align-items: flex-start; }
    .me-wrap .me-identity-main { flex: 1 1 auto; min-width: 0; align-items: flex-start; }
    .me-wrap .me-identity-copy { flex: 1 1 auto; min-width: 0; }
    .me-wrap .me-account {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, max-content));
        gap: 0.5rem 2.25rem;
        margin: 0.375rem 0 0;
    }
    .me-wrap .me-account-item { min-width: 0; }
    .me-wrap .me-account dt {
        margin: 0;
        color: #94a3b8;
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .me-wrap .me-account dd { margin: 0.125rem 0 0; overflow-wrap: anywhere; }
    .me-wrap .me-account .me-identity-code { display: block; }
    .me-wrap .me-account-username {
        color: #0f172a;
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-size: 0.875rem;
        font-weight: 600;
    }
    .me-wrap .me-account-muted { color: #64748b; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; font-weight: 500; font-style: italic; }
    .me-wrap .me-account-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3125rem;
        padding: 0.125rem 0.5625rem;
        border: 1px solid;
        border-radius: 999px;
        font-size: 0.6875rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .me-wrap .me-account-status::before { content: ""; width: 0.375rem; height: 0.375rem; border-radius: 999px; background: currentColor; }
    .me-wrap .me-account-status-active { color: #047857; background: #ecfdf5; border-color: #a7f3d0; }
    .me-wrap .me-account-status-inactive { color: #be123c; background: #fff1f2; border-color: #fecdd3; }
    .me-wrap .me-account-status-none { color: #475569; background: #f8fafc; border-color: #e2e8f0; }

    /* ---------- Vertical rhythm between sections ---------- */
    /* The thin dividers between cards added a large gap on top of the
       form's own spacing; the cards already separate the sections. */
    .me-wrap .me-form { gap: 1.75rem; }
    .me-wrap .me-form > div.border-t { display: none; }
    .me-wrap .me-form > section .grid { row-gap: 1.25rem; }

    @media (max-width: 860px) {
        .me-wrap .me-account { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.625rem 1.25rem; }
    }
    @media (max-width: 480px) {
        .me-wrap .me-identity { flex-wrap: wrap; }
        .me-wrap .me-account { grid-template-columns: minmax(0, 1fr); }
        .me-wrap .me-form { gap: 1.25rem; }
    }
</style>
@endonce
