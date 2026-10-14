
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CareCradle') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        >

        @vite([
            'resources/css/app.css',
            'resources/css/carecradle.css',
            'resources/css/mother-management.css',
            'resources/css/mother-profile.css',
            'resources/css/mother-edit.css',
            'resources/css/sms-notifications.css',
            'resources/css/sms-notification-show.css',
            'resources/css/prenatal-visit-show.css',
            'resources/css/prenatal-create.css',
            'resources/css/prenatal-visit-edit.css',
            'resources/css/appointment-details.css',
            'resources/css/appointment-edit.css',
            'resources/css/carecradle-background.css',
            'resources/css/midwife-management.css',
            'resources/css/admin-foundation.css',
            'resources/css/admin-dashboard.css',
            'resources/css/activity-logs.css',
            'resources/css/midwife-foundation.css',
            'resources/css/midwife-dashboard.css',
            'resources/css/health-tips-management.css',
            'resources/js/app.js'
        ])
    </head>

    <body
        class="font-sans antialiased"
        style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;"
    >
        @php
            $user = Auth::user();
            $isAdmin = $user && $user->isAdministrator();
            $isMidwife = $user && $user->isMidwife();
        @endphp

        <div class="{{ $isAdmin ? 'cc-admin-layout' : ($isMidwife ? 'cc-midwife-layout' : 'min-h-screen') }}">

            {{-- Desktop sidebar --}}
            @if ($isAdmin)
                @include('layouts.admin-sidebar')
            @elseif ($isMidwife)
                @include('layouts.midwife-sidebar')
            @else
                @include('layouts.navigation')
            @endif

            <div class="{{ $isAdmin ? 'cc-admin-main' : '' }} {{ $isMidwife ? 'cc-midwife-main' : '' }}">

                {{-- Administrator mobile navigation --}}
                @if ($isAdmin)
                    <div class="cc-admin-mobile-nav">
                        @include('layouts.navigation')
                    </div>
                @endif

                {{-- Midwife mobile navigation --}}
                @if ($isMidwife)
                    <div class="cc-midwife-mobile-nav">
                        @include('layouts.navigation')
                    </div>
                @endif

                {{-- Optional page header --}}
                @isset($header)
                    <header class="{{ $isAdmin ? 'cc-admin-page-header' : 'bg-white border-b border-pink-100/60 shadow-sm' }}">
                        <div class="{{ $isAdmin ? 'cc-admin-page-header-inner' : 'max-w-7xl mx-auto py-5 sm:py-6 px-4 sm:px-6 lg:px-8' }}">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- Page content --}}
                <main>
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>

