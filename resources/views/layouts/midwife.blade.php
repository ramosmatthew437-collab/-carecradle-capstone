<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - CareCradle' : 'CareCradle' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen">

        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
            aria-hidden="true"
        ></div>

        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 transform flex-col bg-white border-r border-pink-100 transition-transform duration-200 ease-in-out lg:translate-x-0"
            @click.outside="sidebarOpen = false"
        >
            <div class="flex h-16 shrink-0 items-center justify-between border-b border-pink-100 px-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-pink-600 text-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15.75 9.75M21 12A9 9 0 1112 3a9 9 0 019 9Z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-base font-bold text-slate-900">CareCradle</p>
                        <p class="text-[11px] font-medium uppercase tracking-wider text-pink-500">Midwife Portal</p>
                    </div>
                </a>

                <button
                    type="button"
                    @click="sidebarOpen = false"
                    class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 lg:hidden"
                    aria-label="Close sidebar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">

                
                    href="{{ route('dashboard') }}"
                    @if(request()->routeIs('dashboard')) aria-current="page" @endif
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-pink-50 text-pink-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-pink-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12 12 4.5l8.25 7.5M5.25 10.5V19.5A1.5 1.5 0 006.75 21H9.75V15.75A1.5 1.5 0 0111.25 14.25h1.5a1.5 1.5 0 011.5 1.5V21h3a1.5 1.5 0 001.5-1.5V10.5"/>
                    </svg>
                    Dashboard
                </a>

                
                    href="{{ route('mothers.index') }}"
                    @if(request()->routeIs('mothers.*')) aria-current="page" @endif
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('mothers.*') ? 'bg-pink-50 text-pink-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ request()->routeIs('mothers.*') ? 'text-pink-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                    </svg>
                    Mother Management
                </a>

                
                    href="{{ route('sms-notifications.index') }}"
                    @if(request()->routeIs('sms-notifications.*')) aria-current="page" @endif
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('sms-notifications.*') ? 'bg-pink-50 text-pink-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ request()->routeIs('sms-notifications.*') ? 'text-pink-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3.75h6m-8.25 6L12 15.75h5.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6v9.75c0 .655.26 1.164.673 1.5H4.5v2.25Z"/>
                    </svg>
                    SMS Notifications
                </a>

                <div class="!mt-6 !mb-2 border-t border-slate-100"></div>

                
                    href="{{ route('profile.edit') }}"
                    @if(request()->routeIs('profile.*')) aria-current="page" @endif
                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('profile.*') ? 'bg-pink-50 text-pink-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 {{ request()->routeIs('profile.*') ? 'text-pink-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                    </svg>
                    Profile
                </a>

            </nav>

            <div class="shrink-0 border-t border-pink-100 p-4">
                <div class="mb-3 flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-2.5">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-pink-100 text-sm font-semibold text-pink-700">
                        {{ Str::of(Auth::user()->name ?? 'M')->substr(0, 1)->upper() }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Midwife' }}</p>
                        <p class="truncate text-xs text-slate-500">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-red-50 hover:text-red-600"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        <div class="flex min-h-screen flex-col lg:pl-72">

            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-4 border-b border-pink-100 bg-white/80 px-4 backdrop-blur sm:px-6 lg:px-8">

                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="-ml-1 rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 lg:hidden"
                    aria-label="Open sidebar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    @isset($header)
                        {{ $header }}
                    @else
                        <h1 class="truncate text-lg font-semibold text-slate-800">CareCradle</h1>
                    @endisset
                </div>

            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>

        </div>

    </div>

</body>
</html>