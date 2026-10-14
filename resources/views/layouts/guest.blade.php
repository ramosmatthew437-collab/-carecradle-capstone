<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareCradle') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ── Base ─────────────────────────────────────── */
            *, *::before, *::after { box-sizing: border-box; }

            body {
                margin: 0;
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                background: #fdf2f8;
            }

            /* ── Layout shell ─────────────────────────────── */
            .cc-shell {
                min-height: 100dvh;
                display: grid;
                grid-template-columns: 1fr;
            }

            @media (min-width: 1024px) {
                .cc-shell {
                    grid-template-columns: 1fr 1fr;
                }
            }

            /* ══════════════════════════════════════════════
               LEFT PANEL
            ══════════════════════════════════════════════ */
            .cc-left {
                display: none;
                position: relative;
                overflow: hidden;
                flex-direction: column;
                justify-content: space-between;
                padding: 3rem 3.5rem;
                background: linear-gradient(145deg, #831843 0%, #be185d 45%, #ec4899 100%);
                color: #fff;
            }

            @media (min-width: 1024px) {
                .cc-left { display: flex; }
            }

            @media (min-width: 1280px) {
                .cc-left { padding: 3.5rem 4rem; }
            }

            /* Decorative blobs */
            .cc-blob {
                position: absolute;
                border-radius: 50%;
                pointer-events: none;
            }
            .cc-blob-1 {
                width: 400px; height: 400px;
                top: -120px; right: -120px;
                background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            }
            .cc-blob-2 {
                width: 280px; height: 280px;
                bottom: -60px; left: -60px;
                background: radial-gradient(circle, rgba(251,207,232,0.15) 0%, transparent 70%);
            }
            .cc-blob-3 {
                width: 180px; height: 180px;
                top: 42%; left: 55%;
                transform: translate(-50%, -50%);
                background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            }

            /* Brand lockup */
            .cc-brand {
                position: relative;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                z-index: 1;
            }
            .cc-brand-logo {
                width: 44px; height: 44px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 0 0 2px rgba(255,255,255,0.25), 0 2px 8px rgba(0,0,0,0.15);
                flex-shrink: 0;
            }
            .cc-brand-logo-placeholder {
                width: 44px; height: 44px;
                border-radius: 50%;
                background: rgba(255,255,255,0.15);
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .cc-brand-name {
                font-size: 1.25rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                color: #fff;
            }

            /* Hero copy */
            .cc-hero {
                position: relative;
                z-index: 1;
                margin-top: 2.5rem;
            }
            .cc-headline {
                font-family: 'DM Serif Display', Georgia, serif;
                font-size: clamp(1.75rem, 2.5vw, 2.5rem);
                line-height: 1.2;
                letter-spacing: -0.01em;
                color: #fff;
                margin: 0 0 1rem;
            }
            .cc-headline em {
                font-style: italic;
                color: #fbcfe8;
            }
            .cc-tagline {
                font-size: 0.9375rem;
                line-height: 1.7;
                color: rgba(253, 242, 248, 0.9);
                max-width: 26rem;
                margin: 0;
            }

            /* SVG illustration */
            .cc-illustration {
                margin-top: 2.5rem;
                position: relative;
                z-index: 1;
            }

            /* Feature grid */
            .cc-features {
                position: relative;
                z-index: 1;
                margin-top: 2rem;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.625rem;
                max-width: 26rem;
                list-style: none;
                padding: 0;
            }
            .cc-feature {
                display: flex;
                align-items: center;
                gap: 0.625rem;
                padding: 0.75rem 1rem;
                border-radius: 0.875rem;
                background: rgba(255,255,255,0.1);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(255,255,255,0.15);
                transition: background 0.2s;
            }
            .cc-feature:hover { background: rgba(255,255,255,0.16); }
            .cc-feature svg {
                width: 18px; height: 18px;
                flex-shrink: 0;
                color: #fbcfe8;
            }
            .cc-feature span {
                font-size: 0.8125rem;
                font-weight: 600;
                color: rgba(255,255,255,0.95);
                line-height: 1.3;
            }

            /* Left panel footer */
            .cc-left-footer {
                position: relative;
                z-index: 1;
                margin-top: 2.5rem;
                font-size: 0.75rem;
                color: rgba(251,207,232,0.7);
                letter-spacing: 0.01em;
            }

            /* ══════════════════════════════════════════════
               RIGHT PANEL
            ══════════════════════════════════════════════ */
            .cc-right {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2.5rem 1rem;
                background: #fdf2f8;
                min-height: 100dvh;
            }

            @media (min-width: 640px) {
                .cc-right { padding: 3.5rem 1.5rem; }
            }

            @media (min-width: 1024px) {
                .cc-right {
                    background: #fff;
                    padding: 3rem 2rem;
                }
            }

            /* Mobile brand (hidden on desktop) */
            .cc-mobile-brand {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1.75rem;
            }

            @media (min-width: 1024px) {
                .cc-mobile-brand { display: none; }
            }

            .cc-mobile-brand-mark {
                width: 56px; height: 56px;
                border-radius: 50%;
                background: linear-gradient(135deg, #be185d, #ec4899);
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 4px 20px rgba(236,72,153,0.28);
            }
            .cc-mobile-brand-name {
                font-size: 1.125rem;
                font-weight: 700;
                color: #831843;
                letter-spacing: -0.02em;
            }
            .cc-mobile-tagline {
                font-size: 0.8125rem;
                color: #9d174d;
                text-align: center;
                line-height: 1.5;
            }

            /* Login card */
            .cc-card {
                width: 100%;
                max-width: 26rem;
                background: #fff;
                border-radius: 1.5rem;
                border: 1px solid rgba(236,72,153,0.15);
                box-shadow:
                    0 1px 3px rgba(131,24,67,0.03),
                    0 8px 32px rgba(236,72,153,0.08),
                    0 24px 48px rgba(131,24,67,0.03);
                padding: 2.25rem 2rem;
                overflow: hidden;
            }

            @media (min-width: 640px) {
                .cc-card {
                    padding: 2.5rem 2.25rem;
                    border-radius: 1.75rem;
                }
            }

            @media (min-width: 1024px) {
                .cc-card {
                    border: 1px solid #fbcfe8;
                }
            }

            /* Right panel footer */
            .cc-right-footer {
                margin-top: 1.5rem;
                font-size: 0.75rem;
                color: #9d174d;
                opacity: 0.75;
                text-align: center;
                line-height: 1.6;
            }

            /* ── Scrollbar ────────────────────────────────── */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(236,72,153,0.25); border-radius: 9999px; }
            ::-webkit-scrollbar-thumb:hover { background: rgba(236,72,153,0.45); }
        </style>
    </head>
    <body>

        <div class="cc-shell">

            {{-- ====================================== --}}
            {{-- LEFT PANEL — Brand & Info --}}
            {{-- ====================================== --}}

            <div class="cc-left">

                {{-- Decorative blobs --}}
                <div class="cc-blob cc-blob-1" aria-hidden="true"></div>
                <div class="cc-blob cc-blob-2" aria-hidden="true"></div>
                <div class="cc-blob cc-blob-3" aria-hidden="true"></div>

                {{-- Brand lockup --}}
                <div class="cc-brand">
                    <img src="{{ asset('images/system.logo.png') }}"
                         alt="CareCradle logo"
                         class="cc-brand-logo"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="cc-brand-logo-placeholder" style="display:none;" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.95)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <span class="cc-brand-name">CareCradle</span>
                </div>

                {{-- Hero copy --}}
                <div class="cc-hero">
                    <h1 class="cc-headline">
                        Caring for <em>Mothers.</em><br>
                        Nurturing Every Child.
                    </h1>
                    <p class="cc-tagline">
                        A web-based maternal and infant health monitoring system for rural health units — tracking prenatal visits, growth milestones, vaccinations, and delivering timely SMS reminders to keep every mother informed.
                    </p>

                    {{-- Illustration --}}
                    <div class="cc-illustration" aria-hidden="true">
                        <svg viewBox="0 0 340 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:22rem;height:auto;">
                            <!-- Ground shadow -->
                            <ellipse cx="170" cy="186" rx="130" ry="10" fill="rgba(255,255,255,0.08)"/>

                            <!-- Background arc / horizon line -->
                            <path d="M30 160 Q170 100 310 160" stroke="rgba(251,207,232,0.25)" stroke-width="1.5" fill="none"/>

                            <!-- Mother figure -->
                            <ellipse cx="118" cy="136" rx="22" ry="30" fill="rgba(255,255,255,0.14)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                            <circle cx="118" cy="88" r="20" fill="rgba(255,255,255,0.22)" stroke="rgba(255,255,255,0.35)" stroke-width="1"/>
                            <path d="M100 84 Q108 72 118 70 Q128 72 136 84" stroke="rgba(251,207,232,0.6)" stroke-width="2" fill="none" stroke-linecap="round"/>
                            <path d="M96 130 Q80 118 78 108" stroke="rgba(255,255,255,0.45)" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M140 130 Q156 122 162 134" stroke="rgba(255,255,255,0.45)" stroke-width="2.5" stroke-linecap="round"/>

                            <!-- Infant figure -->
                            <circle cx="164" cy="124" r="13" fill="rgba(255,255,255,0.28)" stroke="rgba(255,255,255,0.45)" stroke-width="1"/>
                            <ellipse cx="164" cy="150" rx="11" ry="16" fill="rgba(255,255,255,0.18)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                            <path d="M153 128 Q148 134 152 140" stroke="rgba(251,207,232,0.7)" stroke-width="1.5" stroke-linecap="round"/>

                            <!-- Heart icon -->
                            <path d="M195 70 C195 66.7 197.5 64 200.5 64 C202.2 64 203.8 64.9 205 66.2 C206.2 64.9 207.8 64 209.5 64 C212.5 64 215 66.7 215 70 C215 75 205 82 205 82 C205 82 195 75 195 70Z" fill="rgba(251,207,232,0.85)"/>

                            <!-- Pulse line -->
                            <path d="M220 100 L230 100 L235 88 L242 114 L248 94 L254 100 L270 100" stroke="rgba(251,207,232,0.75)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>

                            <!-- Decorative dots -->
                            <circle cx="56" cy="72" r="4" fill="rgba(255,255,255,0.35)"/>
                            <circle cx="280" cy="68" r="5.5" fill="rgba(251,207,232,0.3)"/>
                            <circle cx="268" cy="145" r="3.5" fill="rgba(255,255,255,0.25)"/>
                            <circle cx="48" cy="145" r="3" fill="rgba(251,207,232,0.35)"/>

                            <!-- Sparkles -->
                            <path d="M72 108 L74 104 L76 108 L80 110 L76 112 L74 116 L72 112 L68 110 Z" fill="rgba(255,255,255,0.2)"/>
                            <path d="M295 110 L296.5 107 L298 110 L301 111.5 L298 113 L296.5 116 L295 113 L292 111.5 Z" fill="rgba(251,207,232,0.3)"/>
                        </svg>
                    </div>

                    {{-- Features --}}
                    <ul class="cc-features" role="list">
                        <li class="cc-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                            </svg>
                            <span>Prenatal Monitoring</span>
                        </li>
                        <li class="cc-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            <span>Growth Tracking</span>
                        </li>
                        <li class="cc-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Vaccination Records</span>
                        </li>
                        <li class="cc-feature">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                            </svg>
                            <span>SMS Reminders</span>
                        </li>
                    </ul>
                </div>

                {{-- Footer note --}}
                <p class="cc-left-footer">
                    Built for the Irosin Rural Health Unit &nbsp;·&nbsp; CareCradle {{ date('Y') }}
                </p>

            </div>

            {{-- ====================================== --}}
            {{-- RIGHT PANEL — Login Form --}}
            {{-- ====================================== --}}

            <div class="cc-right">

                {{-- Mobile brand (hidden on desktop) --}}
                <div class="cc-mobile-brand">
                    <div class="cc-mobile-brand-mark">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.95)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <span class="cc-mobile-brand-name">CareCradle</span>
                    <span class="cc-mobile-tagline">Caring for Mothers. Nurturing Every Child.</span>
                </div>

                {{-- Card wrapping the Blade slot --}}
                <div class="cc-card">
                    {{ $slot }}
                </div>

                {{-- Footer --}}
                <p class="cc-right-footer">
                    &copy; {{ date('Y') }} CareCradle &mdash; Irosin Rural Health Unit<br>
                    Secure access for authorized health workers only.
                </p>

            </div>

        </div>

    </body>
</html>