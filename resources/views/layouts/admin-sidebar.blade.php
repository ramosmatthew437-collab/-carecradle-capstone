
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

    // Administrator identity (existing user properties only: name, role).
    $ccAdminUser = auth()->user();
    $ccAdminName = $ccAdminUser?->name ?? 'Administrator';
    $ccAdminInitials = collect(preg_split('/\s+/', trim($ccAdminName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp

{{-- Admin-only sidebar refinements (scoped to .cc-admin-sidebar; no rebuild needed) --}}
<style>
    .cc-admin-sidebar .cc-admin-brand {
        gap: 0.9rem;
        padding-bottom: 1.35rem;
    }

    .cc-admin-sidebar .cc-admin-logo {
        flex: 0 0 52px;
        width: 52px;
        height: 52px;
        max-width: 52px;
        border: 1px solid #fbcfe8;
        box-shadow: 0 6px 16px rgba(190, 24, 93, 0.14);
    }

    .cc-admin-sidebar .cc-admin-brand strong {
        color: #4a0d2a;
        font-family: "DM Serif Display", Georgia, serif;
        font-size: 1.4rem;
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: -0.01em;
    }

    .cc-admin-sidebar .cc-admin-brand small {
        margin-top: 0.3rem;
        color: #be185d;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
    }

    .cc-admin-sidebar .cc-admin-link {
        border-radius: 0.9rem;
    }

    .cc-admin-sidebar .cc-admin-link.is-active {
        color: #9d174d;
        background: linear-gradient(90deg, #fce7f3 0%, #fdf2f8 100%);
        border-color: #fbcfe8;
        box-shadow:
            inset 3px 0 0 #db2777,
            0 4px 12px rgba(190, 24, 93, 0.08);
    }

    .cc-admin-sidebar .cc-admin-link.is-active svg {
        color: #db2777;
    }

    .cc-admin-sidebar .cc-admin-identity {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        margin-bottom: 0.4rem;
        padding: 0.75rem;
        background: #ffffff;
        border: 1px solid #fce7f3;
        border-radius: 1rem;
        box-shadow: 0 3px 10px rgba(190, 24, 93, 0.05);
    }

    .cc-admin-sidebar .cc-admin-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        color: #ffffff;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(219, 39, 119, 0.25);
    }

    .cc-admin-sidebar .cc-admin-identity-text {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        min-width: 0;
    }

    .cc-admin-sidebar .cc-admin-identity-text strong {
        overflow: hidden;
        color: #1e293b;
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .cc-admin-sidebar .cc-admin-role {
        align-self: flex-start;
        padding: 0.12rem 0.5rem;
        color: #9d174d;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: #fdf2f8;
        border: 1px solid #fbcfe8;
        border-radius: 999px;
    }
</style>

<aside class="cc-admin-sidebar hidden lg:flex">
    <a href="{{ route('dashboard') }}" class="cc-admin-brand">
        <img
            src="{{ asset('images/system.logo.png') }}"
            alt="CareCradle"
            class="cc-admin-logo"
        >
        <span>
            <strong>CareCradle</strong>
            <small>Administrator Portal</small>
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
        <div class="cc-admin-identity" aria-label="Signed in as {{ $ccAdminName }}">
            <span class="cc-admin-avatar" aria-hidden="true">{{ $ccAdminInitials ?: 'A' }}</span>
            <span class="cc-admin-identity-text">
                <strong title="{{ $ccAdminName }}">{{ $ccAdminName }}</strong>
                <span class="cc-admin-role">{{ $ccAdminUser?->role ?? 'Administrator' }}</span>
            </span>
        </div>

        <a
            href="{{ route('profile.edit') }}"
            @if (request()->routeIs('profile.edit')) aria-current="page" @endif
            class="cc-admin-link {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                 aria-hidden="true">
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