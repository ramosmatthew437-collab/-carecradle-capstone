
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

    // Midwife identity (existing user properties only: name and profile photo).
    $midwife = auth()->user();

    $profilePhotoUrl = $midwife->profile_photo_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($midwife->profile_photo_path)
        : null;

    $midwifeInitial = strtoupper(substr($midwife->name ?? 'M', 0, 1));

    $profileActive = request()->routeIs('profile.edit');
@endphp

{{-- Midwife sidebar refinements (scoped to .cc-midwife-sidebar; no rebuild needed).
     Matches the Administrator sidebar's brand, active state, and identity card. --}}
<style>
    .cc-midwife-sidebar .cc-midwife-brand {
        gap: 0.9rem;
        padding-bottom: 1.35rem;
        border-bottom-color: #f6e1ea;
    }

    .cc-midwife-sidebar .cc-midwife-logo {
        flex: 0 0 52px;
        width: 52px;
        height: 52px;
        max-width: 52px;
        padding: 0;
        border: 1px solid #fbcfe8;
        border-radius: 50%;
        box-shadow: 0 6px 16px rgba(190, 24, 93, 0.14);
    }

    .cc-midwife-sidebar .cc-midwife-brand strong {
        color: #4a0d2a;
        font-family: "DM Serif Display", Georgia, serif;
        font-size: 1.4rem;
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: -0.01em;
    }

    .cc-midwife-sidebar .cc-midwife-brand small {
        margin-top: 0.3rem;
        color: #be185d;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
    }

    .cc-midwife-sidebar .cc-midwife-menu-label {
        color: #be185d;
        letter-spacing: 0.13em;
    }

    .cc-midwife-sidebar .cc-midwife-link {
        border-radius: 0.9rem;
    }

    .cc-midwife-sidebar .cc-midwife-link.is-active {
        color: #9d174d;
        background: linear-gradient(90deg, #fce7f3 0%, #fdf2f8 100%);
        border-color: #fbcfe8;
        box-shadow:
            inset 3px 0 0 #db2777,
            0 4px 12px rgba(190, 24, 93, 0.08);
    }

    .cc-midwife-sidebar .cc-midwife-link.is-active svg {
        color: #db2777;
    }

    .cc-midwife-sidebar .cc-midwife-identity {
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

    .cc-midwife-sidebar .cc-midwife-identity-avatar {
        display: flex;
        flex: 0 0 40px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        overflow: hidden;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 700;
        background: linear-gradient(135deg, #be185d 0%, #db2777 100%);
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(219, 39, 119, 0.25);
    }

    .cc-midwife-sidebar .cc-midwife-identity-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cc-midwife-sidebar .cc-midwife-identity-text {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        min-width: 0;
    }

    .cc-midwife-sidebar .cc-midwife-identity-text strong {
        overflow: hidden;
        color: #1e293b;
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .cc-midwife-sidebar .cc-midwife-role {
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
        {{-- Signed-in midwife (profile photo when available, otherwise the initial). --}}
        <div class="cc-midwife-identity" aria-label="Signed in as {{ $midwife->name }}">
            <span class="cc-midwife-identity-avatar" @if (! $profilePhotoUrl) aria-hidden="true" @endif>
                @if ($profilePhotoUrl)
                    <img
                        src="{{ $profilePhotoUrl }}"
                        alt="{{ $midwife->name }} profile photo"
                    >
                @else
                    {{ $midwifeInitial }}
                @endif
            </span>
            <span class="cc-midwife-identity-text">
                <strong title="{{ $midwife->name }}">{{ $midwife->name }}</strong>
                <span class="cc-midwife-role">Midwife</span>
            </span>
        </div>

        <a
            href="{{ route('profile.edit') }}"
            @if ($profileActive) aria-current="page" @endif
            class="cc-midwife-link {{ $profileActive ? 'is-active' : '' }}"
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
