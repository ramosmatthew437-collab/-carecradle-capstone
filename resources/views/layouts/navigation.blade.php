<nav x-data="{ open: false, motherDrawerOpen: false, midwifeDrawerOpen: false, adminDrawerOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    @php
        $user = Auth::user();

        $hamburgerClick = $user->isMother()
            ? 'motherDrawerOpen = true'
            : ($user->isMidwife()
                ? 'midwifeDrawerOpen = true'
                : ($user->isAdministrator()
                    ? 'adminDrawerOpen = true'
                    : 'open = ! open'));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $user->isMother() ? route('mother.dashboard') : route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-8">

                    {{-- Administrator — opens the left slide-out drawer instead of showing links here --}}
                    @if($user->isAdministrator())

                        <button
                            @click="adminDrawerOpen = true"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700 focus:outline-none transition dark:border-gray-600 dark:text-gray-300">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>

                            Menu

                        </button>

                    @endif

                    {{-- Midwife — opens the left slide-out drawer instead of showing links here --}}
                    @if($user->isMidwife())

                        <button
                            @click="midwifeDrawerOpen = true"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700 focus:outline-none transition dark:border-gray-600 dark:text-gray-300">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>

                            Menu

                        </button>

                    @endif

                    {{-- Mother — opens the left slide-out drawer instead of showing links here --}}
                    @if($user->isMother())

                        <button
                            @click="motherDrawerOpen = true"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:border-pink-200 hover:bg-pink-50 hover:text-pink-700 focus:outline-none transition dark:border-gray-600 dark:text-gray-300">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>

                            Menu

                        </button>

                    @endif

                </div>

            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">

                            <div>{{ $user->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    @click="{{ $hamburgerClick }}"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">

                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>

        </div>

    </div>

    {{-- ====================================== --}}
    {{-- Every role now uses its own slide-out drawer (Administrator, --}}
    {{-- Midwife, Mother), so the old bottom accordion panel had no --}}
    {{-- remaining content and has been removed. --}}
    {{-- ====================================== --}}

    {{-- ====================================== --}}
    {{-- ADMINISTRATOR PORTAL — LEFT SLIDE-OUT DRAWER --}}
    {{-- Works identically on mobile and desktop; triggered by the --}}
    {{-- "Menu" button above or the mobile hamburger. --}}
    {{-- ====================================== --}}

    @if($user->isAdministrator())

        @php
            $adminNavLinks = [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => request()->routeIs('dashboard'),
                    'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
                ],
                [
                    'label' => 'Midwife Management',
                    'route' => 'midwives.index',
                    'active' => request()->routeIs('midwives.*'),
                    'icon' => 'M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5',
                ],
                [
                    'label' => 'Reports',
                    'route' => 'reports.index',
                    'active' => request()->routeIs('reports.*'),
                    'icon' => 'M9 17v-2m3 2v-4m3 4V7m5 12H4.5A2.25 2.25 0 012.25 16.75V4.5A2.25 2.25 0 014.5 2.25h15A2.25 2.25 0 0121.75 4.5v12.25A2.25 2.25 0 0119.5 19Z',
                ],
            ];
        @endphp

        <!-- Overlay -->
        <div
            x-show="adminDrawerOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="adminDrawerOpen = false"
            class="fixed inset-0 z-40 bg-gray-900/50"
            style="display: none;">
        </div>

        <!-- Drawer -->
        <div
            x-show="adminDrawerOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @keydown.escape.window="adminDrawerOpen = false"
            class="fixed inset-y-0 left-0 z-50 flex w-[280px] sm:w-[320px] flex-col bg-white shadow-xl"
            style="display: none;">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between bg-gradient-to-r from-pink-600 to-pink-700 px-5 py-5 text-white">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">
                        <x-application-logo class="block h-6 w-6 fill-current text-white" />
                    </div>
                    <div>
                        <p class="text-base font-bold leading-tight">CareCradle</p>
                        <p class="text-xs font-medium text-pink-100">Administrator Portal</p>
                    </div>
                </div>

                <button
                    @click="adminDrawerOpen = false"
                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white focus:outline-none"
                    aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- Drawer Navigation -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">

                @foreach($adminNavLinks as $link)

                    <a href="{{ route($link['route']) }}"
                       @click="adminDrawerOpen = false"
                       class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                              {{ $link['active']
                                    ? 'border-l-4 border-pink-600 bg-pink-50 pl-2 text-pink-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 flex-shrink-0 {{ $link['active'] ? 'text-pink-600' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>

                        {{ $link['label'] }}

                    </a>

                @endforeach

            </nav>

            <!-- Divider -->
            <div class="border-t border-gray-100"></div>

            <!-- Account Actions -->
            <div class="space-y-1 px-3 py-4">

                <a href="{{ route('profile.edit') }}"
                   @click="adminDrawerOpen = false"
                   class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                        </svg>
                        Log Out
                    </button>

                </form>

            </div>

        </div>

    @endif

    {{-- ====================================== --}}
    {{-- MIDWIFE PORTAL — LEFT SLIDE-OUT DRAWER --}}
    {{-- Unchanged from the existing working implementation. --}}
    {{-- ====================================== --}}

    @if($user->isMidwife())

        @php
            $midwifeNavLinks = [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => request()->routeIs('dashboard'),
                    'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
                ],
                [
                    'label' => 'Mother Management',
                    'route' => 'mothers.index',
                    'active' => request()->routeIs('mothers.*'),
                    'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                ],
                [
                    'label' => 'SMS Notifications',
                    'route' => 'sms-notifications.index',
                    'active' => request()->routeIs('sms-notifications.*'),
                    'icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z',
                ],
                [
                    'label' => 'Health Tips Library',
                    'route' => 'midwife.health-tips.index',
                    'active' => request()->routeIs('midwife.health-tips.*'),
                    'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                ],
            ];
        @endphp

        <!-- Overlay -->
        <div
            x-show="midwifeDrawerOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="midwifeDrawerOpen = false"
            class="fixed inset-0 z-40 bg-gray-900/50"
            style="display: none;">
        </div>

        <!-- Drawer -->
        <div
            x-show="midwifeDrawerOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @keydown.escape.window="midwifeDrawerOpen = false"
            class="fixed inset-y-0 left-0 z-50 flex w-[280px] sm:w-[320px] flex-col bg-white shadow-xl"
            style="display: none;">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between bg-gradient-to-r from-pink-600 to-pink-700 px-5 py-5 text-white">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">
                        <x-application-logo class="block h-6 w-6 fill-current text-white" />
                    </div>
                    <div>
                        <p class="text-base font-bold leading-tight">CareCradle</p>
                        <p class="text-xs font-medium text-pink-100">Midwife Portal</p>
                    </div>
                </div>

                <button
                    @click="midwifeDrawerOpen = false"
                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white focus:outline-none"
                    aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- Drawer Navigation -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">

                @foreach($midwifeNavLinks as $link)

                    <a href="{{ route($link['route']) }}"
                       @click="midwifeDrawerOpen = false"
                       class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                              {{ $link['active']
                                    ? 'border-l-4 border-pink-600 bg-pink-50 pl-2 text-pink-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 flex-shrink-0 {{ $link['active'] ? 'text-pink-600' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                        </svg>

                        {{ $link['label'] }}

                    </a>

                @endforeach

            </nav>

            <!-- Divider -->
            <div class="border-t border-gray-100"></div>

            <!-- Account Actions -->
            <div class="space-y-1 px-3 py-4">

                <a href="{{ route('profile.edit') }}"
                   @click="midwifeDrawerOpen = false"
                   class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                        </svg>
                        Log Out
                    </button>

                </form>

            </div>

        </div>

    @endif

    {{-- ====================================== --}}
    {{-- MOTHER PORTAL — LEFT SLIDE-OUT DRAWER --}}
    {{-- Unchanged from the existing working implementation. --}}
    {{-- ====================================== --}}

    @if($user->isMother())

        @php
            $motherNavLinks = [
                [
                    'label' => 'Dashboard',
                    'route' => 'mother.dashboard',
                    'active' => request()->routeIs('mother.dashboard'),
                    'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
                ],
                [
                    'label' => 'Appointments',
                    'route' => 'mother.appointments',
                    'active' => request()->routeIs('mother.appointments'),
                    'icon' => 'M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0120.25 6v12A1.5 1.5 0 0118.75 19.5H5.25A1.5 1.5 0 013.75 18V6A1.5 1.5 0 015.25 4.5Z',
                ],
                [
                    'label' => 'Prenatal Records',
                    'route' => 'mother.prenatal-records',
                    'active' => request()->routeIs('mother.prenatal-records'),
                    'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z',
                ],
                [
                    'label' => 'Infant Records',
                    'route' => 'mother.infant-records',
                    'active' => request()->routeIs('mother.infant-records'),
                    'icon' => 'M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z',
                    'icon2' => 'M12 3.75v1.5',
                ],
                [
                    'label' => 'SMS History',
                    'route' => 'mother.sms-history',
                    'active' => request()->routeIs('mother.sms-history'),
                    'icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z',
                ],
                [
                    'label' => 'Health Tips Library',
                    'route' => 'mother.health-tips',
                    'active' => request()->routeIs('mother.health-tips'),
                    'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                ],
            ];
        @endphp

        <!-- Overlay -->
        <div
            x-show="motherDrawerOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="motherDrawerOpen = false"
            class="fixed inset-0 z-40 bg-gray-900/50"
            style="display: none;">
        </div>

        <!-- Drawer -->
        <div
            x-show="motherDrawerOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @keydown.escape.window="motherDrawerOpen = false"
            class="fixed inset-y-0 left-0 z-50 flex w-[280px] sm:w-[320px] flex-col bg-white shadow-xl"
            style="display: none;">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between bg-gradient-to-r from-pink-600 to-pink-700 px-5 py-5 text-white">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">
                        <x-application-logo class="block h-6 w-6 fill-current text-white" />
                    </div>
                    <div>
                        <p class="text-base font-bold leading-tight">CareCradle</p>
                        <p class="text-xs font-medium text-pink-100">Mother Portal</p>
                    </div>
                </div>

                <button
                    @click="motherDrawerOpen = false"
                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white focus:outline-none"
                    aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- Drawer Navigation -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">

                @foreach($motherNavLinks as $link)

                    <a href="{{ route($link['route']) }}"
                       @click="motherDrawerOpen = false"
                       class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                              {{ $link['active']
                                    ? 'border-l-4 border-pink-600 bg-pink-50 pl-2 text-pink-700'
                                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 flex-shrink-0 {{ $link['active'] ? 'text-pink-600' : 'text-gray-400' }}"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                            @isset($link['icon2'])
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon2'] }}" />
                            @endisset
                        </svg>

                        {{ $link['label'] }}

                    </a>

                @endforeach

            </nav>

            <!-- Divider -->
            <div class="border-t border-gray-100"></div>

            <!-- Account Actions -->
            <div class="space-y-1 px-3 py-4">

                <a href="{{ route('profile.edit') }}"
                   @click="motherDrawerOpen = false"
                   class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-medium text-gray-600 transition hover:bg-red-50 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                        </svg>
                        Log Out
                    </button>

                </form>

            </div>

        </div>

    @endif

</nav>