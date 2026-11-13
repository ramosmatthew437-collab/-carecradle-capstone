
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CareCradle') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }

    :root {
        --cc-rose: #be185d;
        --cc-pink: #ec4899;
        --cc-deep: #831843;
        --cc-blush: #fdf2f8;
    }

    html {
        min-height: 100%;
    }

    body {
        margin: 0;
        min-height: 100vh;
        min-height: 100dvh;
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background: #fdf2f8;
    }

    /* Full-screen RHU photograph */
    .cc-shell {
        position: relative;
        isolation: isolate;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        min-height: 100vh;
        min-height: 100dvh;
        padding: 48px clamp(24px, 7vw, 110px);
        overflow: hidden;
        background: #831843;
    }

    .cc-background {
        position: absolute;
        inset: 0;
        z-index: -2;
        /* Actual Irosin RHU building (original file, no filters). Framed on the
           facade and roofline; the parked vehicles fall below the fold. */
        background-image: url('{{ asset('images/irosin-rhu-building.png') }}');
        background-size: cover;
        background-position: center 38%;
        background-repeat: no-repeat;
    }

    /* Neutral overlay for the RHU photograph: a deep slate shade (no pink
       cast) so the building keeps its real colours. Darker on the text side
       for white-text contrast, nearly clear towards the building; a soft
       bottom fade keeps the parked vehicles quiet. */
    .cc-overlay {
    position: absolute;
    inset: 0;
    z-index: -1;
    background:
        linear-gradient(
            90deg,
            rgba(15, 23, 42, 0.74) 0%,
            rgba(15, 23, 42, 0.62) 30%,
            rgba(15, 23, 42, 0.38) 52%,
            rgba(15, 23, 42, 0.12) 74%,
            rgba(15, 23, 42, 0.06) 100%
        ),
        linear-gradient(
            0deg,
            rgba(15, 23, 42, 0.56),
            rgba(15, 23, 42, 0.22) 22%,
            transparent 46%
        );
}

    /* Brand and introduction */
    .cc-left {
        position: absolute;
        inset: 0 auto 0 0;
        width: 58%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: clamp(28px, 4vw, 64px);
        color: #fff;
        pointer-events: none;
    }

    .cc-brand {
        display: inline-flex;
        align-items: center;
        gap: 13px;
        width: fit-content;
        pointer-events: auto;
    }

    .cc-brand-logo {
        display: block;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.18);
    }

    .cc-brand-name {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: -0.04em;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.15);
    }

    .cc-hero {
        max-width: 570px;
        margin: auto 0;
        padding: 48px 0;
    }

    .cc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 22px;
        color: #ffe4ef;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .cc-eyebrow::before {
        content: "";
        width: 26px;
        height: 2px;
        border-radius: 2px;
        background: #f9a8d4;
    }

    .cc-headline {
        max-width: 550px;
        margin: 0 0 22px;
        color: #fff;
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: clamp(2.8rem, 4.4vw, 4.8rem);
        font-weight: 400;
        line-height: 1.04;
        letter-spacing: -0.035em;
        text-shadow: 0 3px 28px rgba(36, 5, 21, 0.18);
    }

    .cc-headline em {
        color: #fbcfe8;
        font-weight: 400;
    }

    .cc-tagline {
        max-width: 430px;
        margin: 0;
        color: rgba(255, 255, 255, 0.91);
        font-size: 0.96rem;
        line-height: 1.9;
        text-shadow: 0 2px 12px rgba(36, 5, 21, 0.2);
    }

    .cc-left-footer {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        color: rgba(255, 255, 255, 0.86);
        font-size: 0.76rem;
        letter-spacing: 0.015em;
        text-shadow: 0 1px 8px rgba(36, 5, 21, 0.35);
    }

    /* Irosin RHU identity badge: the original logo on a white disc, scaled
       with object-fit: contain so its proportions are never stretched. */
    .cc-rhu-badge {
        display: block;
        flex: 0 0 auto;
        width: 40px;
        height: 40px;
        padding: 2px;
        object-fit: contain;
        background: #fff;
        border: 1px solid rgba(255, 255, 255, 0.85);
        border-radius: 50%;
        box-shadow: 0 4px 14px rgba(36, 5, 21, 0.28);
    }

    .cc-rhu-badge-sm {
        width: 28px;
        height: 28px;
        padding: 1px;
    }

    .cc-mobile-rhu {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.74rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        text-shadow: 0 1px 8px rgba(0, 0, 0, 0.35);
    }

    /* Floating login area */
    .cc-right {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: min(100%, 420px);
        margin-left: auto;
    }

    .cc-card {
        width: 100%;
        padding: 38px 34px 34px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.97);
        border: 1px solid rgba(251, 207, 232, 0.9);
        border-radius: 26px;
        box-shadow:
            0 30px 90px rgba(42, 7, 24, 0.25),
            0 8px 24px rgba(131, 24, 67, 0.09);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .cc-right-footer {
        margin: 20px 0 0;
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.72rem;
        line-height: 1.8;
        text-align: center;
        text-shadow: 0 1px 8px rgba(36, 5, 21, 0.45);
    }

    /* Mobile-only branding */
    .cc-mobile-brand {
        display: none;
    }

    /* Responsive layout */
    @media (max-width: 1023px) {
        .cc-shell {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: center;
            min-height: 100vh;
            min-height: 100dvh;
            padding: 28px 20px;
            overflow: hidden;
            background: #831843;
        }

        .cc-background {
            position: fixed;
            inset: 0;
            /* Portrait screens show a narrow slice: centre it on the arched
               entrance and balcony, the most recognisable part of the facade. */
            background-position: 48% 40%;
            background-size: cover;
        }

        /* Neutral mobile overlay: same slate shade, darker at the top (white
           brand text) and bottom (white footer text). */
        .cc-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    180deg,
                    rgba(15, 23, 42, 0.66) 0%,
                    rgba(15, 23, 42, 0.54) 34%,
                    rgba(15, 23, 42, 0.42) 56%,
                    rgba(15, 23, 42, 0.66) 100%
                );
        }

        .cc-left {
            position: relative;
            inset: auto;
            width: 100%;
            display: block;
            padding: 0;
            margin: 0 0 24px;
            flex: 0 0 auto;
        }

        /* Keep only the mobile logo visible */
        .cc-left > .cc-brand {
            display: none;
        }

        .cc-hero,
        .cc-left-footer {
            display: none;
        }

        .cc-right {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .cc-mobile-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            text-align: center;
        }

        .cc-mobile-brand .cc-brand {
            display: inline-flex;
            justify-content: center;
        }

        .cc-mobile-tagline {
            max-width: 290px;
            color: #fff;
            font-size: 0.84rem;
            line-height: 1.6;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        }

        .cc-card {
            width: 100%;
            padding: 30px 26px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 20px 60px rgba(35, 5, 22, 0.24);
        }

        .cc-right-footer {
            margin-top: 17px;
            padding: 0 8px;
            color: #fff;
            font-size: 0.7rem;
            line-height: 1.7;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }
    }

    @media (max-width: 480px) {
        .cc-shell {
            padding: 24px 16px;
        }

        .cc-right {
            max-width: 360px;
        }

        .cc-card {
            padding: 26px 20px;
            border-radius: 20px;
        }

        .cc-brand-logo {
            width: 42px;
            height: 42px;
        }

        .cc-brand-name {
            font-size: 1.1rem;
        }

        .cc-mobile-brand {
            margin-bottom: 18px;
        }

        .cc-right-footer {
            font-size: 0.67rem;
        }
    }

    @media (max-width: 360px) {
        .cc-shell {
            padding: 18px 12px;
        }

        .cc-card {
            padding: 24px 16px;
        }

        .lf-row {
            gap: 10px;
            flex-wrap: wrap;
        }

        .lf-remember span,
        .lf-forgot {
            font-size: 0.75rem !important;
        }
    }

    /* =============================================================
       Back-to-home link (below the card)
       ============================================================= */
    .cc-home-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 18px;
        padding: 7px 14px;
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 999px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: background 0.18s ease;
    }

    .cc-home-link:hover {
        background: rgba(255, 255, 255, 0.24);
    }

    .cc-home-link:focus-visible {
        outline: 2px solid #fbcfe8;
        outline-offset: 3px;
    }

    /* Login status banner parts (markup in login.blade.php) */
    .lf-status {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
    }

    .lf-status-icon {
        width: 1.3rem;
        height: 1.3rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e11d48;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .lf-status-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
        line-height: 1.45;
    }

    /* =============================================================
       Shared password-recovery styles
       Used by forgot-password, verify-otp and reset-password.
       (Previously defined only inside forgot-password.blade.php,
       so the verify and reset pages rendered partly unstyled.)
       ============================================================= */

    .cc-forgot-password {
        width: 100%;
    }

    /* Step indicator: 1 Request · 2 Verify · 3 New password */
    .cc-steps {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 4px;
        margin: 0 0 1.6rem;
        padding: 0;
        list-style: none;
    }

    .cc-step {
        position: relative;
        flex: 1 1 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        min-width: 0;
        text-align: center;
    }

    .cc-step + .cc-step::before {
        content: "";
        position: absolute;
        top: 13px;
        right: calc(50% + 18px);
        width: calc(100% - 36px);
        height: 2px;
        border-radius: 2px;
        background: #f1d5e3;
    }

    .cc-step.is-done + .cc-step::before,
    .cc-step.is-done + .cc-step.is-current::before {
        background: #f472b6;
    }

    .cc-step-dot {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff;
        border: 1.5px solid #f1d5e3;
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .cc-step-label {
        color: #94a3b8;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    .cc-step.is-current .cc-step-dot {
        background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(219, 39, 119, 0.28);
    }

    .cc-step.is-current .cc-step-label {
        color: #9d174d;
    }

    .cc-step.is-done .cc-step-dot {
        background: #fce7f3;
        border-color: #f9a8d4;
        color: #be185d;
    }

    .cc-step.is-done .cc-step-label {
        color: #be185d;
    }

    /* Header */
    .cc-forgot-header {
        text-align: center;
        margin-bottom: 1.75rem;
    }

    .cc-forgot-icon {
        width: 3.5rem;
        height: 3.5rem;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fdf2f8;
        border: 1px solid #fbcfe8;
        border-radius: 1rem;
        color: #be185d;
        box-shadow: 0 4px 12px rgba(236, 72, 153, 0.08);
    }

    .cc-forgot-icon svg {
        width: 1.65rem;
        height: 1.65rem;
    }

    .cc-forgot-header h2 {
        margin: 0 0 0.4rem;
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 1.7rem;
        font-weight: 400;
        line-height: 1.2;
        letter-spacing: -0.02em;
        color: #1e293b;
    }

    .cc-forgot-header p {
        margin: 0;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 0.875rem;
        line-height: 1.55;
        color: #64748b;
    }

    /* Status / Error */
    .cc-forgot-status,
    .cc-forgot-error {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
        margin-bottom: 1.25rem;
        padding: 0.8rem 1rem;
        border-radius: 0.8rem;
        font-size: 0.84rem;
        line-height: 1.45;
    }

    .cc-forgot-status {
        background: #fdf2f8;
        border: 1px solid #fbcfe8;
        color: #9d174d;
    }

    .cc-forgot-error {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #be123c;
    }

    .cc-forgot-status > span,
    .cc-forgot-error > span {
        width: 1.3rem;
        height: 1.3rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .cc-forgot-status > span {
        background: #ec4899;
    }

    .cc-forgot-error > span {
        background: #e11d48;
    }

    /* Field */
    .cc-forgot-field {
        margin-bottom: 1.25rem;
    }

    .cc-forgot-field label {
        display: block;
        margin-bottom: 0.45rem;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #334155;
    }

    .cc-forgot-input-wrap {
        position: relative;
    }

    .cc-forgot-input-icon {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.1rem;
        height: 1.1rem;
        color: #94a3b8;
        pointer-events: none;
        transition: color 0.18s ease;
    }

    .cc-forgot-input-wrap:focus-within .cc-forgot-input-icon {
        color: #ec4899;
    }

    .cc-forgot-input {
        display: block;
        width: 100%;
        padding: 0.72rem 1rem 0.72rem 2.7rem !important;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 0.9375rem;
        color: #0f172a;
        background: #f8fafc;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 0.75rem !important;
        outline: none !important;
        box-shadow: none !important;
        transition:
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }

    .cc-forgot-input:focus {
        background: #fff;
        border-color: #ec4899 !important;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.12) !important;
    }

    .cc-forgot-input::placeholder {
        color: #94a3b8;
    }

    /* Submit */
    .cc-forgot-submit {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        margin-top: 1.25rem;
        padding: 0.78rem 1.25rem;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
        border: none;
        border-radius: 0.8rem;
        box-shadow:
            0 2px 12px rgba(219, 39, 119, 0.28),
            0 1px 3px rgba(0, 0, 0, 0.06);
        cursor: pointer;
        transition:
            filter 0.18s ease,
            box-shadow 0.18s ease,
            transform 0.12s ease,
            opacity 0.18s ease;
    }

    .cc-forgot-submit:hover {
        filter: brightness(1.05);
        box-shadow:
            0 4px 18px rgba(219, 39, 119, 0.34),
            0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .cc-forgot-submit:active {
        transform: translateY(1px);
    }

    .cc-forgot-submit:focus-visible {
        outline: 3px solid rgba(236, 72, 153, 0.28);
        outline-offset: 2px;
    }

    .cc-forgot-submit.is-loading {
        cursor: wait;
        opacity: 0.82;
    }

    .cc-forgot-submit:disabled {
        cursor: wait;
    }

    /* Spinner */
    .cc-submit-spinner {
        width: 1rem;
        height: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.35);
        border-top-color: #fff;
        border-radius: 50%;
        animation: cc-forgot-spin 0.7s linear infinite;
    }

    @keyframes cc-forgot-spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Back link */
    .cc-forgot-back {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1.15rem;
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .cc-forgot-back:hover {
        color: #be185d;
    }

    .cc-forgot-back:focus-visible {
        outline: 2px solid #ec4899;
        outline-offset: 3px;
        border-radius: 0.35rem;
    }

    /* Password field with show/hide toggle (reset-password) */
    .cc-password-wrapper {
        position: relative;
        width: 100%;
    }

    .cc-password-wrapper input {
        padding-right: 48px;
    }

    .cc-password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #64748b;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .cc-password-toggle:hover {
        background: #fdf2f8;
        color: #be185d;
    }

    .cc-password-toggle:focus-visible {
        outline: 2px solid #ec4899;
        outline-offset: 1px;
    }

    /* Live password requirements (reset-password) */
    .cc-password-requirements {
        width: 100%;
        margin-top: 10px;
        padding: 12px 14px;
        background: #fff8fb;
        border: 1px solid #fbcfe8;
        border-radius: 10px;
    }

    .cc-password-requirements-title {
        margin: 0 0 7px;
        color: #831843;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    .cc-password-rule {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 5px;
        color: #94a3b8;
        font-size: 11.5px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .cc-password-rule-icon {
        width: 17px;
        height: 17px;
        flex: 0 0 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        color: transparent;
        font-size: 9px;
        font-weight: 800;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }

    .cc-password-rule.is-valid {
        color: #059669;
    }

    .cc-password-rule.is-valid .cc-password-rule-icon {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }

    @media (max-width: 380px) {
        .cc-step-label {
            font-size: 0.64rem;
        }

        .cc-forgot-header h2 {
            font-size: 1.5rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .cc-submit-spinner {
            animation-duration: 1.6s;
        }

        .cc-forgot-submit,
        .cc-home-link,
        .cc-password-rule,
        .cc-password-rule-icon {
            transition: none;
        }
    }
</style>

</head>

<body>
    <main class="cc-shell">
        <div class="cc-background" aria-hidden="true"></div>
        <div class="cc-overlay" aria-hidden="true"></div>

        <!-- Brand and hero copy -->
        <section class="cc-left" aria-label="CareCradle introduction">
            <a class="cc-brand" href="{{ url('/') }}" aria-label="CareCradle home">
                <img
                    src="{{ asset('images/system.logo.png') }}"
                    alt="CareCradle logo"
                    class="cc-brand-logo"
                >
                <span class="cc-brand-name">CareCradle</span>
            </a>

            <div class="cc-hero">
                <div class="cc-eyebrow">Maternal &amp; Infant Care</div>

                <h1 class="cc-headline">
                    Caring for <em>Mothers.</em><br>
                    Nurturing Every Child.
                </h1>

                <p class="cc-tagline">
                    Supporting healthier beginnings through maternal
                    monitoring, infant growth tracking, vaccination records,
                    and timely health reminders for every family.
                </p>
            </div>

            <p class="cc-left-footer">
                <img
                    src="{{ asset('images/irosin-rhu-logo.jpg') }}"
                    alt="Irosin Rural Health Unit logo"
                    class="cc-rhu-badge"
                    width="40"
                    height="40"
                >
                <span>
                    Built for the Irosin Rural Health Unit
                    &nbsp;·&nbsp; CareCradle {{ date('Y') }}
                </span>
            </p>
        </section>

        <!-- Login content remains supplied by login.blade.php -->
        <section class="cc-right" aria-label="Sign in">
            <div class="cc-mobile-brand">
                <a class="cc-brand" href="{{ url('/') }}" aria-label="CareCradle home">
                    <img
                        src="{{ asset('images/system.logo.png') }}"
                        alt="CareCradle logo"
                        class="cc-brand-logo"
                    >
                    <span class="cc-brand-name">CareCradle</span>
                </a>

                <span class="cc-mobile-tagline">
                    Caring for Mothers. Nurturing Every Child.
                </span>

                <span class="cc-mobile-rhu">
                    <img
                        src="{{ asset('images/irosin-rhu-logo.jpg') }}"
                        alt="Irosin Rural Health Unit logo"
                        class="cc-rhu-badge cc-rhu-badge-sm"
                        width="28"
                        height="28"
                    >
                    Irosin Rural Health Unit
                </span>
            </div>

            <div class="cc-card">
                {{ $slot }}
            </div>

            <a class="cc-home-link" href="{{ url('/') }}">
                <span aria-hidden="true">←</span> Back to CareCradle home
            </a>

            <p class="cc-right-footer">
                &copy; {{ date('Y') }} CareCradle — Irosin Rural Health Unit<br>
                Secure access for authorized users only.
            </p>
        </section>
    </main>
</body>
</html>
