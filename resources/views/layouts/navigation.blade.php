<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    @php
        $user = Auth::user();
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

                    {{-- Administrator & Midwife --}}
                    @if($user->isAdministrator() || $user->isMidwife())

                        <x-nav-link
                            :href="route('dashboard')"
                            :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                    @endif

                    {{-- Administrator --}}
                    @if($user->isAdministrator())

                        <x-nav-link
                            :href="route('midwives.index')"
                            :active="request()->routeIs('midwives.*')">
                            Midwife Management
                        </x-nav-link>

                        <x-nav-link
                            :href="route('reports.index')"
                            :active="request()->routeIs('reports.*')">
                            Reports
                        </x-nav-link>

                    @endif

                    {{-- Midwife --}}
                    @if($user->isMidwife())

                        <x-nav-link
                            :href="route('mothers.index')"
                            :active="request()->routeIs('mothers.*')">
                            Mother Management
                        </x-nav-link>

                        <x-nav-link
                            :href="route('sms-notifications.index')"
                            :active="request()->routeIs('sms-notifications.*')">
                            SMS Notifications
                        </x-nav-link>

                    @endif

                    {{-- Mother --}}
                    @if($user->isMother())

                        <x-nav-link
                            :href="route('mother.dashboard')"
                            :active="request()->routeIs('mother.dashboard')">
                            My Dashboard
                        </x-nav-link>

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
                    @click="open = ! open"
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

    <!-- Responsive Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            {{-- Administrator & Midwife --}}
            @if($user->isAdministrator() || $user->isMidwife())

                <x-responsive-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

            @endif

            {{-- Administrator --}}
            @if($user->isAdministrator())

                <x-responsive-nav-link
                    :href="route('midwives.index')"
                    :active="request()->routeIs('midwives.*')">
                    Midwife Management
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('reports.index')"
                    :active="request()->routeIs('reports.*')">
                    Reports
                </x-responsive-nav-link>

            @endif

            {{-- Midwife --}}
            @if($user->isMidwife())

                <x-responsive-nav-link
                    :href="route('mothers.index')"
                    :active="request()->routeIs('mothers.*')">
                    Mother Management
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('sms-notifications.index')"
                    :active="request()->routeIs('sms-notifications.*')">
                    SMS Notifications
                </x-responsive-nav-link>

            @endif

            {{-- Mother --}}
            @if($user->isMother())

                <x-responsive-nav-link
                    :href="route('mother.dashboard')"
                    :active="request()->routeIs('mother.dashboard')">
                    My Dashboard
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">

            <div class="px-4">

                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ $user->name }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ $user->email }}
                </div>

            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>

                </form>

            </div>

        </div>

    </div>

</nav>