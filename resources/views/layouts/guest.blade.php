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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">

        <div class="min-h-screen flex flex-col lg:grid lg:grid-cols-2 bg-white">

            {{-- ====================================== --}}
            {{-- LEFT PANEL — Marketing / Info Panel --}}
            {{-- Hidden on mobile, shown from lg breakpoint up --}}
            {{-- ====================================== --}}

            <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-rose-500 via-pink-500 to-pink-600 text-white flex-col justify-between p-10 xl:p-14">

                <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-white/10" aria-hidden="true"></div>
                <div class="absolute -left-10 bottom-10 h-56 w-56 rounded-full bg-white/10" aria-hidden="true"></div>
                <div class="absolute left-1/2 top-1/3 h-40 w-40 -translate-x-1/2 rounded-full bg-white/5" aria-hidden="true"></div>

                {{-- Brand lockup --}}
                <div class="relative flex items-center gap-3">
                    <img src="{{ asset('images/system.logo.png') }}"
                         alt="CareCradle logo"
                         class="h-11 w-11 flex-shrink-0 rounded-full object-cover shadow-sm">
                    <p class="text-xl font-bold tracking-tight">CareCradle</p>
                </div>

                {{-- Main content --}}
                <div class="relative mt-10">

                    <h1 class="text-3xl xl:text-4xl font-bold leading-tight">
                        Maternal &amp; Infant Health,<br class="hidden xl:block"> monitored with care.
                    </h1>

                    <p class="mt-4 max-w-md text-[15px] leading-relaxed text-pink-50">
                        A web-based monitoring system built for rural health units to track prenatal visits, infant growth, and vaccinations — with automated SMS reminders that keep mothers informed every step of the way.
                    </p>

                    {{-- Illustration --}}
                    <div class="mt-8" aria-hidden="true">
                        <svg viewBox="0 0 320 180" class="w-full max-w-sm h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="160" cy="160" rx="120" ry="12" fill="white" fill-opacity="0.08"/>

                            <!-- Parent figure -->
                            <circle cx="115" cy="70" r="24" fill="white" fill-opacity="0.22"/>
                            <path d="M85 150c0-22 13-40 30-40s30 18 30 40" stroke="white" stroke-opacity="0.55" stroke-width="3" stroke-linecap="round"/>

                            <!-- Infant figure -->
                            <circle cx="168" cy="96" r="14" fill="white" fill-opacity="0.35"/>
                            <path d="M150 148c0-14 8-26 18-26s18 12 18 26" stroke="white" stroke-opacity="0.7" stroke-width="3" stroke-linecap="round"/>

                            <!-- Heart pulse -->
                            <path d="M195 100h16l8-16 10 32 8-16h18" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                            <!-- Small decorative dots -->
                            <circle cx="60" cy="50" r="4" fill="white" fill-opacity="0.4"/>
                            <circle cx="260" cy="60" r="5" fill="white" fill-opacity="0.3"/>
                            <circle cx="245" cy="130" r="3.5" fill="white" fill-opacity="0.4"/>
                        </svg>
                    </div>

                    {{-- Feature list --}}
                    <ul class="relative mt-8 grid grid-cols-2 gap-3 max-w-md">

                        <li class="flex items-center gap-2.5 rounded-xl bg-white/10 px-3.5 py-3 backdrop-blur-sm">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                            </svg>
                            <span class="text-[13px] font-semibold">Prenatal Monitoring</span>
                        </li>

                        <li class="flex items-center gap-2.5 rounded-xl bg-white/10 px-3.5 py-3 backdrop-blur-sm">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5l3-3m0 0l3 3m-3-3v9M21 10.5l-3 3m0 0l-3-3m3 3v-9"/>
                            </svg>
                            <span class="text-[13px] font-semibold">Growth Monitoring</span>
                        </li>

                        <li class="flex items-center gap-2.5 rounded-xl bg-white/10 px-3.5 py-3 backdrop-blur-sm">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 5.25l-9 9m9-9l1.5 1.5m-1.5-1.5l-1.5-1.5m-7.5 10.5l-3.75 3.75M9.75 14.25L7.5 12m2.25 2.25L12 16.5m-2.25-2.25l-2.25 2.25m9-11.25l-3 3"/>
                            </svg>
                            <span class="text-[13px] font-semibold">Vaccination Tracking</span>
                        </li>

                        <li class="flex items-center gap-2.5 rounded-xl bg-white/10 px-3.5 py-3 backdrop-blur-sm">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                            </svg>
                            <span class="text-[13px] font-semibold">SMS Alerts</span>
                        </li>

                    </ul>

                </div>

                {{-- Footer note --}}
                <p class="relative mt-10 text-[12px] text-pink-100">
                    Built for the Irosin Rural Health Unit
                </p>

            </div>

            {{-- ====================================== --}}
            {{-- RIGHT PANEL — Login Form --}}
            {{-- ====================================== --}}

            <div class="flex-1 flex flex-col justify-center items-center px-4 py-10 sm:py-16 bg-gradient-to-b from-pink-50 via-[#FFF8FA] to-[#FFF8FA] lg:bg-none lg:bg-white">

                {{-- Logo — shown here only on mobile/tablet, since the left panel already carries branding on desktop --}}
                <div class="lg:hidden">
                    <a href="/" class="inline-flex rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-300">
                        <x-application-logo size="lg" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 lg:mt-0 px-6 py-7 sm:px-8 sm:py-8 bg-white shadow-lg shadow-pink-100/50 border border-pink-50 overflow-hidden rounded-2xl sm:rounded-3xl">
                    {{ $slot }}
                </div>

            </div>

        </div>

    </body>
</html>