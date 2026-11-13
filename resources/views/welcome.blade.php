<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CareCradle — a maternal and infant health monitoring system with SMS alerts for the Irosin Rural Health Unit.">

    <title>CareCradle — Maternal &amp; Infant Care | Irosin Rural Health Unit</title>

    <link rel="icon" type="image/png" href="{{ asset('images/system.logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @php
        // Signed-in visitors go straight to their own portal. Mothers have a
        // separate dashboard; the staff dashboard returns 403 for them.
        $ccUser = auth()->user();
        $ccPortalUrl = $ccUser
            ? ($ccUser->isMother() ? route('mother.dashboard') : route('dashboard'))
            : route('login');
        $ccPortalLabel = $ccUser ? 'Go to my dashboard' : 'Sign in';
    @endphp

    <style>
        /* =============================================================
           CareCradle public landing page
           Palette and type follow the existing CareCradle identity:
           blush pink and white, DM Serif Display headings, Inter body.
           ============================================================= */

        :root {
            --lp-rose: #be185d;
            --lp-pink: #db2777;
            --lp-pink-soft: #f472b6;
            --lp-deep: #831843;
            --lp-plum: #4a0d2a;
            --lp-blush: #fdf2f8;
            --lp-blush-2: #fce7f3;
            --lp-line: #f6d9e7;
            --lp-ink: #1e293b;
            --lp-muted: #64748b;
            --lp-white: #ffffff;
            --lp-radius: 22px;
            --lp-shadow: 0 18px 50px rgba(131, 24, 67, 0.10);
            --lp-max: 1180px;
            --lp-serif: 'DM Serif Display', Georgia, 'Times New Roman', serif;
            --lp-sans: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 84px;
        }

        body {
            margin: 0;
            font-family: var(--lp-sans);
            font-size: 16px;
            line-height: 1.65;
            color: var(--lp-ink);
            background: var(--lp-white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            color: inherit;
        }

        :focus-visible {
            outline: 3px solid rgba(219, 39, 119, 0.45);
            outline-offset: 3px;
            border-radius: 6px;
        }

        .lp-container {
            width: 100%;
            max-width: var(--lp-max);
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 32px);
        }

        .lp-skip {
            position: absolute;
            left: 16px;
            top: -60px;
            z-index: 100;
            padding: 10px 16px;
            background: var(--lp-rose);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
        }

        .lp-skip:focus {
            top: 12px;
        }

        /* ---------- Buttons ---------- */
        .lp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            font-family: var(--lp-sans);
            font-size: 0.94rem;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            border-radius: 999px;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .lp-btn svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .lp-btn-primary {
            color: #fff;
            background: linear-gradient(135deg, var(--lp-rose) 0%, var(--lp-pink) 100%);
            box-shadow: 0 8px 22px rgba(219, 39, 119, 0.28);
        }

        .lp-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(219, 39, 119, 0.34);
        }

        .lp-btn-ghost {
            color: var(--lp-deep);
            background: rgba(255, 255, 255, 0.75);
            border-color: #f9a8d4;
        }

        .lp-btn-ghost:hover {
            background: #fff;
            border-color: var(--lp-pink-soft);
        }

        .lp-btn-small {
            padding: 10px 18px;
            font-size: 0.86rem;
        }

        /* ---------- Eyebrow + section headings ---------- */
        .lp-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 16px;
            color: var(--lp-rose);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .lp-eyebrow::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 2px;
            background: var(--lp-pink-soft);
        }

        .lp-section {
            padding: clamp(64px, 9vw, 112px) 0;
        }

        .lp-section-head {
            max-width: 680px;
            margin: 0 auto clamp(36px, 5vw, 56px);
            text-align: center;
        }

        .lp-section-head .lp-eyebrow {
            justify-content: center;
        }

        .lp-h2 {
            margin: 0 0 14px;
            font-family: var(--lp-serif);
            font-size: clamp(2rem, 3.6vw, 2.9rem);
            font-weight: 400;
            line-height: 1.12;
            letter-spacing: -0.02em;
            color: var(--lp-plum);
        }

        .lp-h2 em {
            color: var(--lp-rose);
        }

        .lp-lead {
            margin: 0;
            color: var(--lp-muted);
            font-size: 1.02rem;
        }

        /* ---------- Header ---------- */
        .lp-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .lp-header.is-scrolled {
            border-bottom-color: var(--lp-line);
            box-shadow: 0 6px 24px rgba(131, 24, 67, 0.06);
        }

        .lp-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            min-height: 74px;
        }

        .lp-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .lp-brand img {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1px solid var(--lp-line);
            object-fit: cover;
            box-shadow: 0 4px 14px rgba(131, 24, 67, 0.12);
        }

        .lp-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .lp-brand-name {
            font-family: var(--lp-serif);
            font-size: 1.4rem;
            color: var(--lp-plum);
            letter-spacing: -0.01em;
        }

        .lp-brand-sub {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--lp-rose);
        }

        /* Official Irosin RHU logo: a smaller institutional mark after the
           CareCradle brand. Whole logo shown (contain) on a white badge. */
        .lp-brand-divider {
            flex: 0 0 1px;
            width: 1px;
            height: 30px;
            background: var(--lp-line);
        }

        .lp-brand img.lp-rhu-mark {
            flex: 0 0 auto;
            width: 36px;
            height: 36px;
            padding: 2px;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--lp-line);
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(131, 24, 67, 0.10);
        }

        .lp-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lp-nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .lp-nav-links a {
            display: block;
            padding: 9px 14px;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 999px;
            transition: color 0.15s ease, background 0.15s ease;
        }

        .lp-nav-links a:hover {
            color: var(--lp-rose);
            background: var(--lp-blush);
        }

        .lp-nav-cta {
            margin-left: 10px;
        }

        .lp-menu-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
            color: var(--lp-deep);
            background: var(--lp-blush);
            border: 1px solid var(--lp-line);
            border-radius: 12px;
            cursor: pointer;
        }

        .lp-menu-btn svg {
            width: 22px;
            height: 22px;
        }

        /* ---------- Hero ---------- */
        .lp-hero {
            position: relative;
            isolation: isolate;
            display: flex;
            align-items: center;
            min-height: min(88vh, 760px);
            padding: clamp(56px, 8vw, 96px) 0;
            overflow: hidden;
            background: var(--lp-blush);
        }

        .lp-hero-photo {
            position: absolute;
            inset: 0;
            z-index: -2;
            /* Official RHU building photo (unedited, no built-in fade). */
            background-image: url('{{ asset('images/irosin-rhu-building.png') }}');
            background-size: cover;
            background-position: 66% 30%;
            background-repeat: no-repeat;
        }

        .lp-hero-veil {
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(
                    90deg,
                    rgba(255, 250, 252, 0.97) 0%,
                    rgba(255, 246, 250, 0.94) 40%,
                    rgba(255, 246, 250, 0.84) 50%,
                    rgba(255, 246, 250, 0.42) 64%,
                    rgba(255, 246, 250, 0.10) 84%,
                    rgba(255, 246, 250, 0.03) 100%
                ),
                linear-gradient(0deg, rgba(253, 242, 248, 0.94) 0%, rgba(253, 242, 248, 0.5) 16%, rgba(253, 242, 248, 0) 36%);
        }

        .lp-hero-copy {
            max-width: 600px;
        }

        .lp-hero h1 {
            margin: 0 0 22px;
            font-family: var(--lp-serif);
            font-size: clamp(2.6rem, 5.4vw, 4.6rem);
            font-weight: 400;
            line-height: 1.04;
            letter-spacing: -0.03em;
            color: var(--lp-plum);
        }

        .lp-hero h1 em {
            color: var(--lp-rose);
        }

        .lp-hero-text {
            max-width: 500px;
            margin: 0 0 32px;
            color: #475569;
            font-size: 1.06rem;
            line-height: 1.8;
        }

        .lp-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 36px;
        }

        .lp-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .lp-chips li {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            color: var(--lp-deep);
            font-size: 0.82rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid var(--lp-line);
            border-radius: 999px;
            box-shadow: 0 4px 14px rgba(131, 24, 67, 0.06);
        }

        .lp-chips svg {
            width: 16px;
            height: 16px;
            color: var(--lp-pink);
        }

        /* ---------- Highlights strip ---------- */
        .lp-strip {
            position: relative;
            z-index: 2;
            margin-top: -44px;
        }

        .lp-strip-card {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: #fff;
            border: 1px solid var(--lp-line);
            border-radius: var(--lp-radius);
            box-shadow: var(--lp-shadow);
        }

        .lp-strip-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px 28px;
        }

        .lp-strip-item + .lp-strip-item {
            border-left: 1px solid var(--lp-line);
        }

        .lp-strip-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--lp-rose);
            background: var(--lp-blush);
            border-radius: 14px;
        }

        .lp-strip-icon svg {
            width: 24px;
            height: 24px;
        }

        .lp-strip-item strong {
            display: block;
            font-family: var(--lp-serif);
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--lp-plum);
            line-height: 1.25;
        }

        .lp-strip-item span {
            display: block;
            color: var(--lp-muted);
            font-size: 0.86rem;
            line-height: 1.5;
        }

        /* ---------- Services ---------- */
        .lp-services {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .lp-service {
            position: relative;
            padding: 30px 28px;
            background: #fff;
            border: 1px solid var(--lp-line);
            border-radius: var(--lp-radius);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .lp-service:hover {
            transform: translateY(-3px);
            border-color: #f9a8d4;
            box-shadow: var(--lp-shadow);
        }

        .lp-service-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--lp-rose);
            background: linear-gradient(135deg, var(--lp-blush) 0%, var(--lp-blush-2) 100%);
            border-radius: 16px;
        }

        .lp-service-icon svg {
            width: 26px;
            height: 26px;
        }

        .lp-service h3 {
            margin: 0 0 8px;
            font-family: var(--lp-serif);
            font-size: 1.32rem;
            font-weight: 400;
            line-height: 1.25;
            color: var(--lp-plum);
        }

        .lp-service p {
            margin: 0;
            color: var(--lp-muted);
            font-size: 0.93rem;
        }

        /* ---------- About ---------- */
        .lp-about {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #fff 0%, var(--lp-blush) 100%);
        }

        .lp-about-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            align-items: center;
            gap: clamp(36px, 6vw, 80px);
        }

        .lp-about-visual {
            position: relative;
            aspect-ratio: 1 / 1;
            max-width: 460px;
            width: 100%;
            margin: 0 auto;
        }

        .lp-about-art {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            opacity: 0.9;
        }

        .lp-about-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px solid var(--lp-line);
            box-shadow: inset 0 0 0 14px rgba(255, 255, 255, 0.55), var(--lp-shadow);
        }

        .lp-about-logo {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 62%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 20px 50px rgba(131, 24, 67, 0.18);
        }

        .lp-about-copy p {
            margin: 0 0 16px;
            color: #475569;
        }

        .lp-checks {
            display: grid;
            gap: 12px;
            margin: 24px 0 0;
            padding: 0;
            list-style: none;
        }

        .lp-checks li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #334155;
            font-size: 0.95rem;
        }

        .lp-checks svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            margin-top: 1px;
            color: var(--lp-pink);
        }

        /* ---------- How it works ---------- */
        .lp-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            counter-reset: lp-step;
        }

        .lp-step {
            position: relative;
            padding: 34px 28px 30px;
            background: var(--lp-blush);
            border-radius: var(--lp-radius);
        }

        .lp-step-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            margin-bottom: 18px;
            font-family: var(--lp-serif);
            font-size: 1.3rem;
            color: #fff;
            background: linear-gradient(135deg, var(--lp-rose) 0%, var(--lp-pink) 100%);
            border-radius: 50%;
            box-shadow: 0 8px 20px rgba(219, 39, 119, 0.25);
        }

        .lp-step h3 {
            margin: 0 0 8px;
            font-family: var(--lp-serif);
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--lp-plum);
        }

        .lp-step p {
            margin: 0;
            color: var(--lp-muted);
            font-size: 0.93rem;
        }

        /* ---------- Portals ---------- */
        .lp-portals {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .lp-portal {
            display: flex;
            flex-direction: column;
            padding: 34px 32px;
            border-radius: var(--lp-radius);
            border: 1px solid var(--lp-line);
            background: #fff;
        }

        .lp-portal-feature {
            color: #fff;
            border-color: transparent;
            background:
                radial-gradient(circle at 85% 15%, rgba(244, 114, 182, 0.35), transparent 45%),
                linear-gradient(135deg, var(--lp-deep) 0%, var(--lp-rose) 100%);
        }

        .lp-portal h3 {
            margin: 0 0 10px;
            font-family: var(--lp-serif);
            font-size: 1.6rem;
            font-weight: 400;
            line-height: 1.2;
            color: var(--lp-plum);
        }

        .lp-portal-feature h3 {
            color: #fff;
        }

        .lp-portal p {
            margin: 0 0 22px;
            color: var(--lp-muted);
        }

        .lp-portal-feature p {
            color: rgba(255, 255, 255, 0.88);
        }

        .lp-portal ul {
            display: grid;
            gap: 8px;
            margin: 0 0 26px;
            padding: 0;
            list-style: none;
            font-size: 0.92rem;
        }

        .lp-portal li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .lp-portal li::before {
            content: "";
            width: 7px;
            height: 7px;
            margin-top: 9px;
            flex-shrink: 0;
            border-radius: 50%;
            background: var(--lp-pink-soft);
        }

        .lp-portal-feature li::before {
            background: #fbcfe8;
        }

        .lp-portal .lp-btn {
            margin-top: auto;
            align-self: flex-start;
        }

        .lp-portal-feature .lp-btn-ghost {
            color: var(--lp-deep);
            background: #fff;
            border-color: #fff;
        }

        /* ---------- Contact ---------- */
        .lp-contact-card {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--lp-line);
            border-radius: calc(var(--lp-radius) + 6px);
            box-shadow: var(--lp-shadow);
        }

        .lp-contact-copy {
            padding: clamp(32px, 5vw, 56px);
        }

        .lp-contact-list {
            display: grid;
            gap: 18px;
            margin: 26px 0 0;
            padding: 0;
            list-style: none;
        }

        .lp-contact-list li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .lp-contact-list .lp-strip-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
        }

        .lp-contact-list .lp-strip-icon svg {
            width: 20px;
            height: 20px;
        }

        .lp-contact-list strong {
            display: block;
            color: var(--lp-plum);
            font-size: 0.95rem;
        }

        .lp-contact-list span {
            color: var(--lp-muted);
            font-size: 0.9rem;
        }

        .lp-contact-photo {
            min-height: 320px;
            background-image:
                linear-gradient(180deg, rgba(131, 24, 67, 0) 55%, rgba(131, 24, 67, 0.35) 100%),
                url('{{ asset('images/irosin-rhu-building.png') }}');
            background-size: cover;
            background-position: 58% 30%;
        }

        /* ---------- Footer ---------- */
        .lp-footer {
            color: rgba(255, 255, 255, 0.82);
            background: linear-gradient(160deg, #3b0a22 0%, var(--lp-deep) 100%);
        }

        .lp-footer-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1.2fr;
            gap: 36px;
            padding: clamp(52px, 7vw, 76px) 0 40px;
        }

        .lp-footer .lp-brand-name {
            color: #fff;
        }

        .lp-footer .lp-brand-sub {
            color: #fbcfe8;
        }

        .lp-footer .lp-brand img {
            border-color: rgba(255, 255, 255, 0.4);
        }

        .lp-footer-about {
            max-width: 340px;
            margin: 18px 0 0;
            font-size: 0.9rem;
            line-height: 1.75;
        }

        .lp-footer h4 {
            margin: 4px 0 16px;
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .lp-footer ul {
            display: grid;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 0.9rem;
        }

        .lp-footer a {
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .lp-footer a:hover {
            color: #fbcfe8;
        }

        .lp-footer-bottom {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 12px;
            padding: 22px 0 28px;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.66);
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 1024px) {
            /* The hero copy covers more of the width here, so the veil
               stays strong further across before revealing the building. */
            .lp-hero-veil {
                background:
                    linear-gradient(
                        90deg,
                        rgba(255, 250, 252, 0.97) 0%,
                        rgba(255, 246, 250, 0.93) 52%,
                        rgba(255, 246, 250, 0.74) 64%,
                        rgba(255, 246, 250, 0.26) 84%,
                        rgba(255, 246, 250, 0.08) 100%
                    ),
                    linear-gradient(0deg, rgba(253, 242, 248, 0.94) 0%, rgba(253, 242, 248, 0.5) 16%, rgba(253, 242, 248, 0) 36%);
            }

            .lp-services {
                grid-template-columns: repeat(2, 1fr);
            }

            .lp-footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 900px) {
            .lp-menu-btn {
                display: inline-flex;
            }

            .lp-nav {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                display: none;
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                padding: 12px clamp(16px, 4vw, 32px) 20px;
                background: #fff;
                border-bottom: 1px solid var(--lp-line);
                box-shadow: 0 16px 30px rgba(131, 24, 67, 0.08);
            }

            .lp-nav.is-open {
                display: flex;
            }

            .lp-nav-links {
                flex-direction: column;
                align-items: stretch;
            }

            .lp-nav-links a {
                padding: 12px 14px;
                border-radius: 12px;
            }

            .lp-nav-cta {
                margin: 4px 0 0;
            }

            .lp-nav-cta .lp-btn {
                width: 100%;
            }

            .lp-about-grid,
            .lp-contact-card {
                grid-template-columns: 1fr;
            }

            .lp-about-visual {
                max-width: 340px;
            }

            .lp-steps,
            .lp-portals {
                grid-template-columns: 1fr;
            }

            .lp-strip-card {
                grid-template-columns: 1fr;
            }

            .lp-strip-item + .lp-strip-item {
                border-left: 0;
                border-top: 1px solid var(--lp-line);
            }

            .lp-contact-photo {
                min-height: 220px;
                order: -1;
            }
        }

        @media (max-width: 640px) {
            .lp-hero {
                min-height: auto;
                padding: 48px 0 88px;
            }

            .lp-hero-photo {
                background-position: 60% 30%;
            }

            .lp-hero-veil {
                background: linear-gradient(
                    180deg,
                    rgba(255, 250, 252, 0.95) 0%,
                    rgba(255, 246, 250, 0.90) 60%,
                    rgba(253, 242, 248, 0.80) 100%
                );
            }

            .lp-hero-actions .lp-btn {
                flex: 1 1 100%;
            }

            .lp-services,
            .lp-footer-grid {
                grid-template-columns: 1fr;
            }

            .lp-brand-sub {
                display: none;
            }

            .lp-strip-item {
                padding: 20px;
            }
        }

        @media (max-width: 380px) {
            .lp-brand {
                gap: 8px;
            }

            .lp-brand img.lp-rhu-mark {
                width: 30px;
                height: 30px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *, *::before, *::after {
                transition: none !important;
            }
        }
    </style>
</head>

<body>
    <a class="lp-skip" href="#main">Skip to content</a>

    {{-- ================= HEADER ================= --}}
    <header class="lp-header" id="lp-header">
        <div class="lp-container lp-header-inner">
            <a class="lp-brand" href="{{ url('/') }}" aria-label="CareCradle home">
                <img src="{{ asset('images/system.logo.png') }}" alt="" width="46" height="46">
                <span class="lp-brand-text">
                    <span class="lp-brand-name">CareCradle</span>
                    <span class="lp-brand-sub">Irosin Rural Health Unit</span>
                </span>
                <span class="lp-brand-divider" aria-hidden="true"></span>
                <img class="lp-rhu-mark" src="{{ asset('images/irosin-rhu-logo.jpg') }}" alt="Irosin Rural Health Unit logo" width="36" height="36">
            </a>

            <button class="lp-menu-btn" id="lp-menu-btn" type="button"
                    aria-controls="lp-nav" aria-expanded="false" aria-label="Open menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            <nav class="lp-nav" id="lp-nav" aria-label="Main">
                <ul class="lp-nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#how-it-works">How it works</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="lp-nav-cta">
                    <a class="lp-btn lp-btn-primary lp-btn-small" href="{{ $ccPortalUrl }}">
                        {{ $ccPortalLabel }}
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main id="main">

        {{-- ================= HERO ================= --}}
        <section class="lp-hero" id="home" aria-labelledby="lp-hero-title">
            <div class="lp-hero-photo" role="img" aria-label="The Irosin Rural Health Unit building"></div>
            <div class="lp-hero-veil" aria-hidden="true"></div>

            <div class="lp-container">
                <div class="lp-hero-copy">
                    <p class="lp-eyebrow">Maternal &amp; Infant Care</p>

                    <h1 id="lp-hero-title">
                        Caring for <em>Mothers.</em><br>
                        Nurturing Every Child.
                    </h1>

                    <p class="lp-hero-text">
                        CareCradle helps the Irosin Rural Health Unit follow every
                        pregnancy and every child&rsquo;s first years &mdash; prenatal
                        check-ups, vaccinations and growth, with SMS reminders so no
                        visit is missed.
                    </p>

                    <div class="lp-hero-actions">
                        <a class="lp-btn lp-btn-primary" href="{{ $ccPortalUrl }}">
                            {{ $ccUser ? 'Go to my dashboard' : 'Sign in to CareCradle' }}
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
                        </a>
                        <a class="lp-btn lp-btn-ghost" href="#services">Explore services</a>
                    </div>

                    <ul class="lp-chips" aria-label="Highlights">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="7" y="2.5" width="10" height="19" rx="2" /><path d="M11 18h2" /></svg>
                            SMS reminders
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-8-4.7-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.3-8 11-8 11z" /></svg>
                            Prenatal records
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z" /></svg>
                            Private &amp; secure
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ================= HIGHLIGHTS ================= --}}
        <div class="lp-strip">
            <div class="lp-container">
                <div class="lp-strip-card">
                    <div class="lp-strip-item">
                        <div class="lp-strip-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5" /><path d="M2.5 20a6.5 6.5 0 0 1 13 0" /><circle cx="17.5" cy="9.5" r="2.5" /><path d="M16 14.6a5 5 0 0 1 6 4.9" /></svg>
                        </div>
                        <div>
                            <strong>Three connected portals</strong>
                            <span>Administrators, midwives and mothers</span>
                        </div>
                    </div>
                    <div class="lp-strip-item">
                        <div class="lp-strip-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z" /><path d="M8 9h8M8 13h5" /></svg>
                        </div>
                        <div>
                            <strong>Timely SMS alerts</strong>
                            <span>Reminders before scheduled visits</span>
                        </div>
                    </div>
                    <div class="lp-strip-item">
                        <div class="lp-strip-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2" /><path d="M8 10V7a4 4 0 0 1 8 0v3" /></svg>
                        </div>
                        <div>
                            <strong>Confidential records</strong>
                            <span>Role-based access for authorized users</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SERVICES ================= --}}
        <section class="lp-section" id="services" aria-labelledby="lp-services-title">
            <div class="lp-container">
                <div class="lp-section-head">
                    <p class="lp-eyebrow">What CareCradle supports</p>
                    <h2 class="lp-h2" id="lp-services-title">Care for every stage, <em>from pregnancy to childhood</em></h2>
                    <p class="lp-lead">
                        One place for the records that matter most to mothers and
                        the health workers who look after them.
                    </p>
                </div>

                <div class="lp-services">
                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-8-4.7-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.3-8 11-8 11z" /><path d="M8 12h2.5l1.5-3 2 5 1.2-2H17" /></svg>
                        </div>
                        <h3>Prenatal check-ups</h3>
                        <p>Each visit&rsquo;s weight, blood pressure, fetal heart rate, findings and laboratory results, kept in one history.</p>
                    </article>

                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2l4 4M17 7l3-3M19 9l-8.5 8.5a2.1 2.1 0 0 1-3 0l-2-2a2.1 2.1 0 0 1 0-3L14 4M9 11l4 4M5 19l-3 3M14 4l6 6" /></svg>
                        </div>
                        <h3>Maternal immunization</h3>
                        <p>A clear record of the vaccines given to mothers during pregnancy, with dates and the health worker who gave them.</p>
                    </article>

                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7.5" r="3.5" /><path d="M6 21v-2a6 6 0 0 1 12 0v2" /><path d="M9.5 6.5c.8.6 1.6.9 2.5.9s1.7-.3 2.5-.9" /></svg>
                        </div>
                        <h3>Infant immunization</h3>
                        <p>Tracks childhood vaccines such as BCG, Hepatitis B, Pentavalent, OPV, IPV, PCV and MMR, dose by dose.</p>
                    </article>

                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18" /><path d="M7 15l4-4 3 3 5-6" /></svg>
                        </div>
                        <h3>Growth monitoring</h3>
                        <p>Weight, length and head circumference recorded over time, so growth can be followed at every visit.</p>
                    </article>

                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="2.5" width="12" height="19" rx="2.5" /><path d="M10 6h4M11 18h2" /></svg>
                        </div>
                        <h3>SMS appointment reminders</h3>
                        <p>Mothers receive a text message reminder ahead of their scheduled check-ups and vaccination visits.</p>
                    </article>

                    <article class="lp-service">
                        <div class="lp-service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V3h12v6" /><rect x="3" y="9" width="18" height="8" rx="2" /><path d="M6 14h12v7H6z" /></svg>
                        </div>
                        <h3>Printable health records</h3>
                        <p>Mothers can view and print a summary of their maternal and infant records whenever they need it.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ================= ABOUT ================= --}}
        <section class="lp-section lp-about" id="about" aria-labelledby="lp-about-title">
            <div class="lp-container lp-about-grid">
                <div class="lp-about-visual" aria-hidden="true">
                    <img class="lp-about-art" src="{{ asset('images/carecradle-dashboard-bg.png') }}" alt="" loading="lazy">
                    <div class="lp-about-ring"></div>
                    <img class="lp-about-logo" src="{{ asset('images/system.logo.png') }}" alt="" loading="lazy">
                </div>

                <div class="lp-about-copy">
                    <p class="lp-eyebrow">About CareCradle</p>
                    <h2 class="lp-h2" id="lp-about-title">Built for the <em>Irosin Rural Health Unit</em></h2>
                    <p>
                        CareCradle is a web-based maternal and infant health monitoring
                        system with SMS alerts. It replaces scattered paper records with
                        a single, organized history for each mother and child.
                    </p>
                    <p>
                        Midwives record check-ups, vaccinations and growth measurements.
                        Mothers can see their own records and upcoming appointments
                        from any device, and administrators can review reports for the
                        whole municipality.
                    </p>

                    <ul class="lp-checks">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M8.5 12l2.5 2.5 4.5-5" /></svg>
                            Mothers give data-privacy consent before using their portal.
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M8.5 12l2.5 2.5 4.5-5" /></svg>
                            Health workers acknowledge a confidentiality policy before accessing records.
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M8.5 12l2.5 2.5 4.5-5" /></svg>
                            Reports can be filtered by barangay for planning and follow-up.
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ================= HOW IT WORKS ================= --}}
        <section class="lp-section" id="how-it-works" aria-labelledby="lp-how-title">
            <div class="lp-container">
                <div class="lp-section-head">
                    <p class="lp-eyebrow">How it works</p>
                    <h2 class="lp-h2" id="lp-how-title">Simple for mothers, <em>reliable for health workers</em></h2>
                </div>

                <div class="lp-steps">
                    <article class="lp-step">
                        <span class="lp-step-num" aria-hidden="true">1</span>
                        <h3>Enroll at the RHU</h3>
                        <p>Your midwife registers you at the Rural Health Unit and gives you your CareCradle account.</p>
                    </article>
                    <article class="lp-step">
                        <span class="lp-step-num" aria-hidden="true">2</span>
                        <h3>Every visit is recorded</h3>
                        <p>Check-ups, vaccinations and your baby&rsquo;s growth are added to your record after each visit.</p>
                    </article>
                    <article class="lp-step">
                        <span class="lp-step-num" aria-hidden="true">3</span>
                        <h3>Stay informed</h3>
                        <p>Receive SMS reminders and view your records, appointments and health tips anytime.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ================= PORTALS ================= --}}
        <section class="lp-section" style="padding-top: 0;" aria-label="Sign-in options">
            <div class="lp-container lp-portals">
                <article class="lp-portal lp-portal-feature">
                    <h3>For mothers</h3>
                    <p>Follow your pregnancy and your child&rsquo;s health in one place.</p>
                    <ul>
                        <li>Upcoming appointments and SMS history</li>
                        <li>Prenatal, vaccination and growth records</li>
                        <li>Health tips and printable records</li>
                    </ul>
                </article>

                <article class="lp-portal">
                    <h3>For health workers</h3>
                    <p>Midwives and administrators of the Irosin Rural Health Unit.</p>
                    <ul>
                        <li>Mother enrollment and patient records</li>
                        <li>Appointments and SMS notifications</li>
                        <li>Reports, activity logs and staff management</li>
                    </ul>
                </article>
            </div>
        </section>

        {{-- ================= CONTACT ================= --}}
        <section class="lp-section" id="contact" style="padding-top: 0;" aria-labelledby="lp-contact-title">
            <div class="lp-container">
                <div class="lp-contact-card">
                    <div class="lp-contact-copy">
                        <p class="lp-eyebrow">Visit us</p>
                        <h2 class="lp-h2" id="lp-contact-title">We&rsquo;re here for <em>you and your baby</em></h2>
                        <p class="lp-lead">
                            For enrollment, check-ups and account concerns, please visit
                            the Rural Health Unit or speak with your assigned midwife.
                        </p>

                        <ul class="lp-contact-list">
                            <li>
                                <span class="lp-strip-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z" /><circle cx="12" cy="9.5" r="2.5" /></svg>
                                </span>
                                <div>
                                    <strong>Irosin Rural Health Unit</strong>
                                    <span>Irosin, Sorsogon</span>
                                </div>
                            </li>
                            <li>
                                <span class="lp-strip-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="2" /><path d="M8 10V7a4 4 0 0 1 8 0v3" /></svg>
                                </span>
                                <div>
                                    <strong>Forgot your password?</strong>
                                    <span>
                                        Use <a href="{{ route('password.request') }}" style="color: var(--lp-rose); font-weight: 600;">password recovery</a>
                                        or ask your midwife for help.
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="lp-contact-photo" role="img" aria-label="The Irosin Rural Health Unit building"></div>
                </div>
            </div>
        </section>

    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="lp-footer">
        <div class="lp-container">
            <div class="lp-footer-grid">
                <div>
                    <a class="lp-brand" href="{{ url('/') }}" aria-label="CareCradle home">
                        <img src="{{ asset('images/system.logo.png') }}" alt="" width="46" height="46" loading="lazy">
                        <span class="lp-brand-text">
                            <span class="lp-brand-name">CareCradle</span>
                            <span class="lp-brand-sub">Irosin Rural Health Unit</span>
                        </span>
                    </a>
                    <p class="lp-footer-about">
                        A maternal and infant health monitoring system with SMS alerts,
                        supporting healthier beginnings for every family in Irosin.
                    </p>
                </div>

                <div>
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#how-it-works">How it works</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Access</h4>
                    <ul>
                        <li><a href="{{ $ccPortalUrl }}">{{ $ccPortalLabel }}</a></li>
                        <li><a href="{{ route('password.request') }}">Forgot password</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Your privacy</h4>
                    <ul>
                        <li>Health records are visible only to authorized users.</li>
                        <li>Handled in line with the Data Privacy Act of 2012 (RA 10173).</li>
                    </ul>
                </div>
            </div>

            <div class="lp-footer-bottom">
                <span>&copy; {{ date('Y') }} CareCradle &mdash; Irosin Rural Health Unit</span>
                <span>Caring for Mothers. Nurturing Every Child.</span>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var header = document.getElementById('lp-header');
            var btn = document.getElementById('lp-menu-btn');
            var nav = document.getElementById('lp-nav');

            function setOpen(open) {
                if (!btn || !nav) return;
                nav.classList.toggle('is-open', open);
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                btn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
            }

            if (btn && nav) {
                btn.addEventListener('click', function () {
                    setOpen(!nav.classList.contains('is-open'));
                });

                nav.addEventListener('click', function (event) {
                    if (event.target.closest('a')) setOpen(false);
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') setOpen(false);
                });
            }

            function onScroll() {
                if (header) header.classList.toggle('is-scrolled', window.scrollY > 8);
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();
    </script>
</body>
</html>
