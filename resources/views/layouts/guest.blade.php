
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
        background-image: url('/images/irosin-rhu.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: scale(1.01);
    }

    /* Clean, neutral overlay for the RHU photograph */
    .cc-overlay {
    position: absolute;
    inset: 0;
    z-index: -1;
    background:
        linear-gradient(
            90deg,
            rgba(15, 23, 42, 0.58) 0%,
            rgba(15, 23, 42, 0.36) 38%,
            rgba(15, 23, 42, 0.10) 72%,
            rgba(15, 23, 42, 0.14) 100%
        ),
        linear-gradient(
            0deg,
            rgba(15, 23, 42, 0.16),
            transparent 45%
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
        margin: 0;
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.76rem;
        letter-spacing: 0.015em;
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
        border: 1px solid rgba(255, 255, 255, 0.82);
        border-radius: 24px;
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
            background-position: center center;
            background-size: cover;
        }

        /* Neutral mobile overlay */
        .cc-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    180deg,
                    rgba(15, 23, 42, 0.48) 0%,
                    rgba(15, 23, 42, 0.28) 48%,
                    rgba(15, 23, 42, 0.62) 100%
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
                Built for the Irosin Rural Health Unit
                &nbsp;·&nbsp; CareCradle {{ date('Y') }}
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
            </div>

            <div class="cc-card">
                {{ $slot }}
            </div>

            <p class="cc-right-footer">
                &copy; {{ date('Y') }} CareCradle — Irosin Rural Health Unit<br>
                Secure access for authorized health workers only.
            </p>
        </section>
    </main>
</body>
</html>
