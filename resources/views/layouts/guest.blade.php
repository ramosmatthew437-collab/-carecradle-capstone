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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 bg-gradient-to-b from-pink-50 via-[#FFF8FA] to-[#FFF8FA]">

            <div class="mt-4 sm:mt-0">
                <a href="/" class="inline-flex">
                    <x-application-logo size="lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-6 py-7 sm:px-8 sm:py-8 bg-white shadow-lg shadow-pink-100/50 border border-pink-50 overflow-hidden rounded-2xl sm:rounded-3xl">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>