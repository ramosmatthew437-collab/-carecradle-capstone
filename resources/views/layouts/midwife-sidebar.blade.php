
@php
    $midwifeNavLinks = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
            'icon' => 'M3 10.5 12 3l9 7.5M5.25 9v11.25h13.5V9M9 20.25v-6h6v6',
        ],
        [
            'label' => 'Mother Management',
            'route' => 'mothers.index',
            'active' => request()->routeIs('mothers.*'),
            'icon' => 'M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
        ],
        [
            'label' => 'SMS Notifications',
            'route' => 'sms-notifications.index',
            'active' => request()->routeIs('sms-notifications.*'),
            'icon' => 'M3 5h18v14H3z M3 6l9 7 9-7',
        ],
        [
            'label' => 'Health Tips Library',
            'route' => 'midwife.health-tips.index',
            'active' => request()->routeIs('midwife.health-tips.*'),
            'icon' => 'M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z',
        ],
    ];
@endphp

<aside class="cc-midwife-sidebar hidden lg:flex">
    <a href="{{ route('dashboard') }}" class="cc-midwife-brand">
        <img
            src="{{ asset('images/system.logo.png') }}"
            alt="CareCradle"
            class="cc-midwife-logo"
        >

        <span>
            <strong>CareCradle</strong>
            <small>Midwife Portal</small>
        </span>
    </a>

    <div class="cc-midwife-menu-label">Main Menu</div>

    <nav class="cc-midwife-links" aria-label="Midwife navigation">
        @foreach ($midwifeNavLinks as $link)
            <a
                href="{{ route($link['route']) }}"
                @if ($link['active']) aria-current="page" @endif
                class="cc-midwife-link {{ $link['active'] ? 'is-active' : '' }}"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="{{ $link['icon'] }}"/>
                </svg>

                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="cc-midwife-sidebar-bottom">
        <a href="{{ route('profile.edit') }}" class="cc-midwife-link">
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>
            <span>Profile</span>
        </a>

        <form
            method="POST"
            action="{{ route('logout') }}"
            onsubmit="return confirm('Are you sure you want to log out?');"
        >
            @csrf

            <button
                type="submit"
                class="cc-midwife-link cc-midwife-logout"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M10 17l5-5-5-5M15 12H3"/>
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
