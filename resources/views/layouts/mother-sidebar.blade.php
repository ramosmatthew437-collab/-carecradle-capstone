
<aside class="cc-mother-sidebar">
   
<a href="{{ route('mother.dashboard') }}" class="cc-mother-brand">
    <x-application-logo size="sm" />
</a>


    <div class="cc-mother-sidebar-label">MATERNAL CARE</div>

    @php
        $motherLinks = [
            [
                'label' => 'Dashboard',
                'route' => 'mother.dashboard',
                'pattern' => 'mother.dashboard',
                'icon' => 'layout-dashboard',
            ],
            [
                'label' => 'Appointments',
                'route' => 'mother.appointments',
                'pattern' => 'mother.appointments',
                'icon' => 'calendar-days',
            ],
            [
                'label' => 'Prenatal Records',
                'route' => 'mother.prenatal-records',
                'pattern' => 'mother.prenatal-records',
                'icon' => 'clipboard-list',
            ],
            [
                'label' => 'Infant Records',
                'route' => 'mother.infant-records',
                'pattern' => 'mother.infant-records',
                'icon' => 'baby',
            ],
            
            [
                'label' => 'SMS History',
                'route' => 'mother.sms-history',
                'pattern' => 'mother.sms-history',
                'icon' => 'message-circle',
            ],
            [
                'label' => 'Health Tips',
                'route' => 'mother.health-tips',
                'pattern' => 'mother.health-tips*',
                'icon' => 'heart-pulse',
            ],
        ];
    @endphp

    <nav class="cc-mother-sidebar-nav" aria-label="Mother navigation">
        @foreach ($motherLinks as $link)
            <a
                href="{{ route($link['route']) }}"
                @class([
                    'cc-mother-sidebar-link',
                    'is-active' => request()->routeIs($link['pattern']),
                ])
                @if (request()->routeIs($link['pattern']))
                    aria-current="page"
                @endif
            >
                <span class="cc-mother-sidebar-link-icon" aria-hidden="true">
                    @switch($link['icon'])
                        @case('layout-dashboard')
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="8" height="8" rx="2"/>
                                <rect x="13" y="3" width="8" height="5" rx="2"/>
                                <rect x="13" y="10" width="8" height="11" rx="2"/>
                                <rect x="3" y="13" width="8" height="8" rx="2"/>
                            </svg>
                            @break

                        @case('calendar-days')
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="5" width="18" height="16" rx="2"/>
                                <path d="M16 3v4M8 3v4M3 10h18"/>
                            </svg>
                            @break

                        @case('clipboard-list')
                            <svg viewBox="0 0 24 24">
                                <rect x="5" y="4" width="14" height="17" rx="2"/>
                                <path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>
                            </svg>
                            @break

                        @case('baby')
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M9 10h.01M15 10h.01M9 15c2 2 4 2 6 0M8 4l2 2M16 4l-2 2"/>
                            </svg>
                            @break

                        @case('trending-up')
                            <svg viewBox="0 0 24 24">
                                <path d="M3 17l6-6 4 4 8-9M15 6h6v6"/>
                            </svg>
                            @break

                        @case('syringe')
                            <svg viewBox="0 0 24 24">
                                <path d="M4 20l9-9M7 17l-3-3M10 14l-3-3M14 10l-3-3M17 7l-3-3M14 4l6 6M3 21l3-3M15 9l-6 6"/>
                            </svg>
                            @break

                        @case('message-circle')
                            <svg viewBox="0 0 24 24">
                                <path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5 9 9 0 0 1-4-.9L3 21l1.9-5.5a9 9 0 0 1-.9-4A8.5 8.5 0 0 1 12.5 3H13a8.5 8.5 0 0 1 8 8.5z"/>
                            </svg>
                            @break

                        @case('heart-pulse')
                            <svg viewBox="0 0 24 24">
                                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8z"/>
                                <path d="M3 12h5l2-3 3 6 2-3h6"/>
                            </svg>
                            @break
                    @endswitch
                </span>

                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="cc-mother-sidebar-footer">
        <a
            href="{{ route('mother.profile') }}"
            @class([
                'cc-mother-sidebar-link',
                'is-active' => request()->routeIs('mother.profile'),
            ])
            @if (request()->routeIs('mother.profile'))
                aria-current="page"
            @endif
        >
            <span class="cc-mother-sidebar-link-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21a8 8 0 0 1 16 0"/>
                </svg>
            </span>
            <span>My Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="cc-mother-sidebar-link cc-mother-logout"
                onclick="return confirm('Are you sure you want to log out?')"
            >
                <span class="cc-mother-sidebar-link-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M10 17l5-5-5-5M15 12H3M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                    </svg>
                </span>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
