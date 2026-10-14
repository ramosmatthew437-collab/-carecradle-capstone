
@php
    $adminNavLinks = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
            'icon' => 'M3 10.5 12 3l9 7.5M5.25 9v11.25h13.5V9M9 20.25v-6h6v6',
        ],
        [
            'label' => 'Midwife Management',
            'route' => 'midwives.index',
            'active' => request()->routeIs('midwives.*'),
            'icon' => 'M16 19h6v-2a4 4 0 0 0-6.5-3.1M16 19H8m8 0v-2a4 4 0 0 0-8 0v2m0 0H2v-2a4 4 0 0 1 6.5-3.1M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
        ],
        [
            'label' => 'Reports',
            'route' => 'reports.index',
            'active' => request()->routeIs('reports.*'),
            'icon' => 'M4 19V5m0 14h16M8 15v-4m4 4V7m4 8V9',
        ],
        [
            'label' => 'Activity Logs',
            'route' => 'admin.activity-logs.index',
            'active' => request()->routeIs('admin.activity-logs.*'),
            'icon' => 'M4 5h16M4 12h16M4 19h10',
        ],
    ];
@endphp

<aside class="cc-admin-sidebar hidden lg:flex">
    <a href="{{ route('dashboard') }}" class="cc-admin-brand">
        <img
            src="{{ asset('images/system.logo.png') }}"
            alt="CareCradle"
            class="cc-admin-logo"
        >
        <span>
            <strong>CareCradle</strong>
            <small>Admin Portal</small>
        </span>
    </a>

    <div class="cc-admin-menu-label">Main Menu</div>

    <nav class="cc-admin-links" aria-label="Administrator navigation">
        @foreach ($adminNavLinks as $link)
            <a
                href="{{ route($link['route']) }}"
                @if ($link['active']) aria-current="page" @endif
                class="cc-admin-link {{ $link['active'] ? 'is-active' : '' }}"
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

    <div class="cc-admin-sidebar-bottom">
        <a href="{{ route('profile.edit') }}" class="cc-admin-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>
            <span>Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="cc-admin-link cc-admin-logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M10 17l5-5-5-5M15 12H3"/>
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>