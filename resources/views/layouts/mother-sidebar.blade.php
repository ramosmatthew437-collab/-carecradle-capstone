
<aside class="cc-mother-sidebar">
   
<a href="{{ route('mother.dashboard') }}" class="cc-mother-brand cc-mother-brand-portal">
    <x-application-logo size="sm" />
    {{-- Portal subtitle, styled like ADMINISTRATOR PORTAL / MIDWIFE PORTAL. --}}
    <small class="cc-mother-portal-label">Mother Portal</small>
</a>

{{-- Mother sidebar brand subtitle (scoped; no rebuild needed). The logo
     component is unchanged; the subtitle sits under the CareCradle wordmark. --}}
@once
<style>
    .cc-mother-sidebar .cc-mother-brand.cc-mother-brand-portal {
        display: grid;
        grid-template-columns: auto;
        justify-content: start;
        row-gap: 0;
    }

    .cc-mother-sidebar .cc-mother-portal-label {
        /* Aligned with the wordmark: logo width (40px) + its gap (8px). */
        margin: -0.45rem 0 0 48px;
        color: #be185d;
        font-size: 0.62rem;
        font-weight: 700;
        line-height: 1.3;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        white-space: nowrap;
    }
</style>
@endonce


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
                'label' => 'My Referrals',
                'route' => 'mother.referrals',
                'pattern' => 'mother.referrals',
                'icon' => 'arrow-right-left',
            ],
            [
                'label' => 'Infant Records',
                'route' => 'mother.infant-records',
                'pattern' => 'mother.infant-records',
                'icon' => 'baby',
            ],
            [
    'label' => 'My Vaccinations',
    'route' => 'mother.vaccinations',
    'pattern' => 'mother.vaccinations',
    'icon' => 'syringe',
],

            [
    'label' => 'Print My Records',
    'route' => 'mother.print-records',
    'pattern' => 'mother.print-records',
    'icon' => 'printer',
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
                            @case('printer')
    <svg viewBox="0 0 24 24">
        <path d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
        <path d="M7 14h10v7H7zM17 11h.01"/>
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

                        @case('arrow-right-left')
                            <svg viewBox="0 0 24 24">
                                <path d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
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
    href="{{ route('profile.edit') }}"
    @class([
        'cc-mother-sidebar-link',
        'is-active' => request()->routeIs('profile.edit'),
    ])
    @if (request()->routeIs('profile.edit'))
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
