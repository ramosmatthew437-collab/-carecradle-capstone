<x-app-layout>



    {{-- CareCradle Fonts --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">



    {{-- Midwife Management Styles --}}

    <link rel="stylesheet" href="{{ asset('css/midwife-management.css') }}">



    <div class="mm-page">

        <div class="mm-container">



            {{-- ========================================= --}}

            {{-- SUCCESS ALERT --}}

            {{-- ========================================= --}}



            @if(session('success'))

                <div class="mm-alert mm-alert-success" role="status" aria-live="polite">



                    <div class="mm-alert-icon">

                        <svg width="20" height="20" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M20 6L9 17l-5-5"/>

                        </svg>

                    </div>



                    <div class="mm-alert-content">

                        <p class="mm-alert-title">Success</p>

                        <p class="mm-alert-msg">{{ session('success') }}</p>

                    </div>



                    <button

                        type="button"

                        class="mm-alert-close"

                        aria-label="Dismiss success notification"

                    >

                        <svg width="16" height="16" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M18 6L6 18M6 6l12 12"/>

                        </svg>

                    </button>



                </div>

            @endif





            {{-- ========================================= --}}

            {{-- VALIDATION / ERROR ALERT --}}

            {{-- ========================================= --}}



            @if($errors->any())

                <div class="mm-alert mm-alert-error" role="alert" aria-live="assertive">



                    <div class="mm-alert-icon">

                        <svg width="20" height="20" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <circle cx="12" cy="12" r="9"/>

                            <path d="M12 8v4"/>

                            <path d="M12 16h.01"/>

                        </svg>

                    </div>



                    <div class="mm-alert-content">

                        <p class="mm-alert-title">Please Check Your Information</p>



                        @if($errors->count() === 1)

                            <p class="mm-alert-msg">

                                {{ $errors->first() }}

                            </p>

                        @else

                            <ul class="mm-alert-errors">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        @endif

                    </div>



                    <button

                        type="button"

                        class="mm-alert-close"

                        aria-label="Dismiss error notification"

                    >

                        <svg width="16" height="16" viewBox="0 0 24 24"

                             fill="none" stroke="currentColor" stroke-width="2"

                             stroke-linecap="round" stroke-linejoin="round"

                             aria-hidden="true">

                            <path d="M18 6L6 18M6 6l12 12"/>

                        </svg>

                    </button>



                </div>

            @endif





            {{-- ========================================= --}}

            {{-- PAGE HERO --}}

            {{-- ========================================= --}}



            <section class="mm-page-header" aria-labelledby="mm-page-title">
                <div class="mm-page-header-main">
                    <div class="mm-page-header-icon" aria-hidden="true">
                        <svg width="21" height="21" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6"/>
                            <path d="M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>

                    <div class="mm-page-header-copy">
                        <h1 class="mm-page-header-title" id="mm-page-title">
                            Midwife Management
                        </h1>
                        <p class="mm-page-header-description">
                            Manage registered midwives and their access to the CareCradle system.
                        </p>
                    </div>
                </div>

                <a href="{{ route('midwives.create') }}" class="mm-page-header-button">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    <span>Register Midwife</span>
                </a>
            </section>





            {{-- ========================================= --}}

            {{-- STATISTICS --}}

            {{-- ========================================= --}}



            <section class="mm-stats">



                {{-- Total --}}

                <div class="mm-stat mm-stat-total">



                    <div class="mm-stat-top">

                        <div class="mm-stat-icon">

                            <svg width="20" height="20" viewBox="0 0 24 24"

                                 fill="none" stroke="currentColor" stroke-width="1.8"

                                 stroke-linecap="round" stroke-linejoin="round"

                                 aria-hidden="true">

                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                                <circle cx="9" cy="7" r="4"/>

                                <path d="M23 21v-2a4 4 0 00-3-3.87"/>

                                <path d="M16 3.13a4 4 0 010 7.75"/>

                            </svg>

                        </div>



                        <span class="mm-stat-badge">Total</span>

                    </div>



                    <p class="mm-stat-value">

                        {{ $totalMidwives }}

                    </p>



                    <p class="mm-stat-label">

                        Registered healthcare staff

                    </p>



                </div>





                {{-- Active --}}

                <div class="mm-stat mm-stat-active">



                    <div class="mm-stat-top">

                        <div class="mm-stat-icon">

                            <svg width="20" height="20" viewBox="0 0 24 24"

                                 fill="none" stroke="currentColor" stroke-width="1.8"

                                 stroke-linecap="round" stroke-linejoin="round"

                                 aria-hidden="true">

                                <path d="M9 12.75L11.25 15 15 9.75"/>

                                <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                            </svg>

                        </div>



                        <span class="mm-stat-badge">Active</span>

                    </div>



                    <p class="mm-stat-value">

                        {{ $activeMidwives }}

                    </p>



                    <p class="mm-stat-label">

                        Currently providing services

                    </p>



                </div>





                {{-- Inactive --}}

                <div class="mm-stat mm-stat-inactive">



                    <div class="mm-stat-top">

                        <div class="mm-stat-icon">

                            <svg width="20" height="20" viewBox="0 0 24 24"

                                 fill="none" stroke="currentColor" stroke-width="1.8"

                                 stroke-linecap="round" stroke-linejoin="round"

                                 aria-hidden="true">

                                <path d="M18.364 18.364A9 9 0 005.636 5.636"/>

                                <path d="M5.636 18.364A9 9 0 0018.364 5.636"/>

                                <path d="M18.364 18.364L5.636 5.636"/>

                            </svg>

                        </div>



                        <span class="mm-stat-badge">Inactive</span>

                    </div>



                    <p class="mm-stat-value">

                        {{ $inactiveMidwives }}

                    </p>



                    <p class="mm-stat-label">

                        Accounts currently disabled

                    </p>



                </div>



            </section>





            {{-- ========================================= --}}

            {{-- SEARCH --}}

            {{-- ========================================= --}}



            <section class="mm-search-card">



                <form method="GET" action="{{ route('midwives.index') }}">



                    <div class="mm-search-row">



                        <div class="mm-search-wrap">



                            <div class="mm-search-icon">

                                <svg width="18" height="18" viewBox="0 0 24 24"

                                     fill="none" stroke="currentColor" stroke-width="1.8"

                                     stroke-linecap="round" stroke-linejoin="round"

                                     aria-hidden="true">

                                    <circle cx="11" cy="11" r="8"/>

                                    <path d="M21 21l-4.35-4.35"/>

                                </svg>

                            </div>



                            <input

                                type="text"

                                name="search"

                                value="{{ request('search') }}"

                                placeholder="Search username, name, contact number, email..."

                                class="mm-search-input"

                                aria-label="Search midwives"

                            >



                            <button type="submit" class="mm-search-button">

                                Search

                            </button>



                        </div>





@php

    $currentStatus = request('status', 'all');

    $currentSearch = request('search', '');

@endphp



<div class="mm-legend">

    <a

        href="{{ route('midwives.index', ['status' => 'all', 'search' => $currentSearch]) }}"

        class="mm-legend-pill mm-legend-all {{ $currentStatus === 'all' ? 'is-selected' : '' }}"

        aria-current="{{ $currentStatus === 'all' ? 'page' : 'false' }}"

    >

        <span class="mm-legend-dot"></span>

        All Midwives

    </a>



    <a

        href="{{ route('midwives.index', ['status' => 'active', 'search' => $currentSearch]) }}"

        class="mm-legend-pill mm-legend-active {{ $currentStatus === 'active' ? 'is-selected' : '' }}"

        aria-current="{{ $currentStatus === 'active' ? 'page' : 'false' }}"

    >

        <span class="mm-legend-dot"></span>

        Active

    </a>



    <a

        href="{{ route('midwives.index', ['status' => 'inactive', 'search' => $currentSearch]) }}"

        class="mm-legend-pill mm-legend-inactive {{ $currentStatus === 'inactive' ? 'is-selected' : '' }}"

        aria-current="{{ $currentStatus === 'inactive' ? 'page' : 'false' }}"

    >

        <span class="mm-legend-dot"></span>

        Inactive

    </a>

</div>







                    @if(request('search'))



                        <div class="mm-reset-wrapper">



                            <a href="{{ route('midwives.index') }}" class="mm-reset-button">



                                <svg width="14" height="14" viewBox="0 0 24 24"

                                     fill="none" stroke="currentColor" stroke-width="2"

                                     stroke-linecap="round" stroke-linejoin="round"

                                     aria-hidden="true">

                                    <path d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8"/>

                                    <path d="M3 3v5h5"/>

                                </svg>



                                Reset Search



                            </a>



                        </div>



                    @endif



                </form>



            </section>





            {{-- ========================================= --}}

            {{-- MIDWIFE LIST --}}

            {{-- ========================================= --}}



            <section class="mm-table-shell">



                <div class="mm-table-header">



                    <div>

                        <h2 class="mm-table-title">

                            Registered Midwives

                        </h2>



                        <p class="mm-table-subtitle">

                            Manage healthcare professionals assigned to the Rural Health Unit.

                        </p>

                    </div>



                    <span class="mm-count-badge">



                        @if(request('search'))

                            {{ $midwives->count() }} of {{ $totalMidwives }} Records

                        @else

                            {{ $totalMidwives }} Records

                        @endif



                    </span>



                </div>





                {{-- ========================================= --}}

                {{-- RECORDS --}}

                {{-- ========================================= --}}



                @if($midwives->count())



                    {{-- DESKTOP TABLE --}}

                    <div class="mm-desktop-table">



                        <div class="mm-table-scroll">



                            <table class="mm-table">



                                <thead>

                                    <tr>

                                        <th>Username</th>

                                        <th>Full Name</th>

                                        <th>Contact Number</th>

                                        <th>Email Address</th>

                                        <th class="mm-center">Status</th>

                                        <th class="mm-center">Actions</th>

                                    </tr>

                                </thead>



                                <tbody>



                                    @foreach($midwives as $midwife)



                                        <tr>



                                            <td>

                                                <p class="mm-primary-text">

                                                    {{ $midwife->username }}

                                                </p>



                                                <p class="mm-secondary-text">

                                                    System Account

                                                </p>

                                            </td>





                                            <td>



                                                <div class="mm-person">



                                                    <div class="mm-avatar">

                                                        {{ strtoupper(

                                                            substr($midwife->first_name, 0, 1) .

                                                            substr($midwife->last_name, 0, 1)

                                                        ) }}

                                                    </div>



                                                    <div class="mm-person-info">



                                                        <p class="mm-primary-text mm-name-text">

                                                            {{ trim(

                                                                $midwife->first_name . ' ' .

                                                                $midwife->middle_name . ' ' .

                                                                $midwife->last_name

                                                            ) }}

                                                        </p>



                                                        <p class="mm-secondary-text">

                                                            Registered Midwife

                                                        </p>



                                                    </div>



                                                </div>



                                            </td>





                                            <td class="mm-muted-text">

                                                {{ $midwife->contact_number ?: '—' }}

                                            </td>





                                            <td class="mm-muted-text">

                                                {{ $midwife->email ?: '—' }}

                                            </td>





                                            <td class="mm-center">



                                                @if($midwife->is_active)



                                                    <span class="mm-status mm-status-active">

                                                        <span class="mm-status-dot"></span>

                                                        Active

                                                    </span>



                                                @else



                                                    <span class="mm-status mm-status-inactive">

                                                        <span class="mm-status-dot"></span>

                                                        Inactive

                                                    </span>



                                                @endif



                                            </td>





                                            <td class="mm-center">



                                                <div class="mm-actions">



                                                    {{-- Edit --}}

                                                    <a

                                                        href="{{ route('midwives.edit', $midwife->id) }}"

                                                        aria-label="Edit {{ $midwife->username }}"

                                                        class="mm-action-button mm-action-edit"

                                                    >

                                                        <svg width="14" height="14"

                                                             viewBox="0 0 24 24"

                                                             fill="none"

                                                             stroke="currentColor"

                                                             stroke-width="2"

                                                             stroke-linecap="round"

                                                             stroke-linejoin="round"

                                                             aria-hidden="true">

                                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>

                                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                                                        </svg>



                                                        Edit

                                                    </a>





                                                    {{-- Deactivate / Activate --}}

                                                    @if($midwife->is_active)



                                                        <form

                                                            action="{{ route('midwives.destroy', $midwife->id) }}"

                                                            method="POST"

                                                            class="mm-status-form"

                                                            data-confirm-action="deactivate"

                                                            data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"

                                                        >

                                                            @csrf

                                                            @method('DELETE')



                                                            <button

                                                                type="submit"

                                                                aria-label="Deactivate {{ $midwife->username }}"

                                                                class="mm-action-button mm-action-deactivate"

                                                            >

                                                                <svg width="14" height="14"

                                                                     viewBox="0 0 24 24"

                                                                     fill="none"

                                                                     stroke="currentColor"

                                                                     stroke-width="2"

                                                                     stroke-linecap="round"

                                                                     stroke-linejoin="round"

                                                                     aria-hidden="true">

                                                                    <path d="M18.364 18.364A9 9 0 005.636 5.636"/>

                                                                    <path d="M5.636 18.364A9 9 0 0018.364 5.636"/>

                                                                    <path d="M18.364 18.364L5.636 5.636"/>

                                                                </svg>



                                                                <span class="mm-action-label">Deactivate</span>

                                                            </button>



                                                        </form>



                                                    @else



                                                        <form

                                                            action="{{ route('midwives.activate', $midwife->id) }}"

                                                            method="POST"

                                                            class="mm-status-form"

                                                            data-confirm-action="activate"

                                                            data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"

                                                        >

                                                            @csrf



                                                            <button

                                                                type="submit"

                                                                aria-label="Activate {{ $midwife->username }}"

                                                                class="mm-action-button mm-action-activate"

                                                            >

                                                                <svg width="14" height="14"

                                                                     viewBox="0 0 24 24"

                                                                     fill="none"

                                                                     stroke="currentColor"

                                                                     stroke-width="2"

                                                                     stroke-linecap="round"

                                                                     stroke-linejoin="round"

                                                                     aria-hidden="true">

                                                                    <path d="M20 6L9 17l-5-5"/>

                                                                </svg>



                                                                <span class="mm-action-label">Activate</span>

                                                            </button>



                                                        </form>



                                                    @endif



                                                </div>



                                            </td>



                                        </tr>



                                    @endforeach



                                </tbody>



                            </table>



                        </div>



                    </div>





                    {{-- ========================================= --}}

                    {{-- MOBILE CARDS --}}

                    {{-- ========================================= --}}



                    <div class="mm-mobile-cards">



                        @foreach($midwives as $midwife)



                            <article class="mm-mobile-card">



                                <div class="mm-mobile-top">



                                    <div class="mm-mobile-identity">



                                        <div class="mm-mobile-avatar">

                                            {{ strtoupper(

                                                substr($midwife->first_name, 0, 1) .

                                                substr($midwife->last_name, 0, 1)

                                            ) }}

                                        </div>



                                        <div class="mm-mobile-person-info">



                                            <p class="mm-primary-text mm-mobile-name">

                                                {{ trim(

                                                    $midwife->first_name . ' ' .

                                                    $midwife->middle_name . ' ' .

                                                    $midwife->last_name

                                                ) }}

                                            </p>



                                            <p class="mm-secondary-text">

                                                {{ $midwife->username }}

                                            </p>



                                        </div>



                                    </div>





                                    @if($midwife->is_active)



                                        <span class="mm-status mm-status-active">

                                            <span class="mm-status-dot"></span>

                                            Active

                                        </span>



                                    @else



                                        <span class="mm-status mm-status-inactive">

                                            <span class="mm-status-dot"></span>

                                            Inactive

                                        </span>



                                    @endif



                                </div>





                                <div class="mm-mobile-details">



                                    <div>

                                        <p class="mm-mobile-label">Contact Number</p>

                                        <p class="mm-mobile-value">

                                            {{ $midwife->contact_number ?: '—' }}

                                        </p>

                                    </div>



                                    <div>

                                        <p class="mm-mobile-label">Email</p>

                                        <p class="mm-mobile-value">

                                            {{ $midwife->email ?: '—' }}

                                        </p>

                                    </div>



                                </div>





                                <div class="mm-mobile-actions">



                                    {{-- Edit --}}

                                    <a

                                        href="{{ route('midwives.edit', $midwife->id) }}"

                                        class="mm-mobile-action mm-action-edit"

                                    >

                                        <svg width="14" height="14"

                                             viewBox="0 0 24 24"

                                             fill="none"

                                             stroke="currentColor"

                                             stroke-width="2"

                                             stroke-linecap="round"

                                             stroke-linejoin="round"

                                             aria-hidden="true">

                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>

                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                                        </svg>



                                        Edit

                                    </a>





                                    @if($midwife->is_active)



                                        <form

                                            action="{{ route('midwives.destroy', $midwife->id) }}"

                                            method="POST"

                                            class="mm-status-form"

                                            data-confirm-action="deactivate"

                                            data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"

                                        >

                                            @csrf

                                            @method('DELETE')



                                            <button

                                                type="submit"

                                                class="mm-mobile-action mm-action-deactivate"

                                            >

                                                <svg width="14" height="14"

                                                     viewBox="0 0 24 24"

                                                     fill="none"

                                                     stroke="currentColor"

                                                     stroke-width="2"

                                                     stroke-linecap="round"

                                                     stroke-linejoin="round"

                                                     aria-hidden="true">

                                                    <path d="M18.364 18.364A9 9 0 005.636 5.636"/>

                                                    <path d="M5.636 18.364A9 9 0 0018.364 5.636"/>

                                                    <path d="M18.364 18.364L5.636 5.636"/>

                                                </svg>



                                                <span class="mm-action-label">Deactivate</span>

                                            </button>



                                        </form>



                                    @else



                                        <form

                                            action="{{ route('midwives.activate', $midwife->id) }}"

                                            method="POST"

                                            class="mm-status-form"

                                            data-confirm-action="activate"

                                            data-midwife-name="{{ trim($midwife->first_name . ' ' . $midwife->last_name) }}"

                                        >

                                            @csrf



                                            <button

                                                type="submit"

                                                class="mm-mobile-action mm-action-activate"

                                            >

                                                <svg width="14" height="14"

                                                     viewBox="0 0 24 24"

                                                     fill="none"

                                                     stroke="currentColor"

                                                     stroke-width="2"

                                                     stroke-linecap="round"

                                                     stroke-linejoin="round"

                                                     aria-hidden="true">

                                                    <path d="M20 6L9 17l-5-5"/>

                                                </svg>



                                                <span class="mm-action-label">Activate</span>

                                            </button>



                                        </form>



                                    @endif



                                </div>



                            </article>



                        @endforeach



                    </div>





                @else



                    {{-- ========================================= --}}

                    {{-- EMPTY STATE --}}

                    {{-- ========================================= --}}



                    <div class="mm-empty">



                        <div class="mm-empty-icon">



                            <svg width="34" height="34"

                                 viewBox="0 0 24 24"

                                 fill="none"

                                 stroke="currentColor"

                                 stroke-width="1.5"

                                 stroke-linecap="round"

                                 stroke-linejoin="round"

                                 aria-hidden="true">

                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>

                                <circle cx="9" cy="7" r="4"/>

                                <path d="M23 21v-2a4 4 0 00-3-3.87"/>

                                <path d="M16 3.13a4 4 0 010 7.75"/>

                            </svg>



                        </div>



                        <p class="mm-empty-title">

                            @if(request('search'))

                                No Midwives Found

                            @else

                                No Registered Midwives

                            @endif

                        </p>



                        <p class="mm-empty-description">



                            @if(request('search'))

                                No midwife accounts match your search.

                                Try using a different name, username, contact number, or email.

                            @else

                                There are currently no registered midwives in the CareCradle system.

                                Add a healthcare provider to begin managing midwife accounts for the Rural Health Unit.

                            @endif



                        </p>





                        @if(request('search'))



                            <a href="{{ route('midwives.index') }}" class="mm-empty-button">

                                Clear Search

                            </a>



                        @else



                            <a href="{{ route('midwives.create') }}" class="mm-empty-button">



                                <svg width="16" height="16"

                                     viewBox="0 0 24 24"

                                     fill="none"

                                     stroke="currentColor"

                                     stroke-width="2.5"

                                     stroke-linecap="round"

                                     stroke-linejoin="round"

                                     aria-hidden="true">

                                    <path d="M12 5v14M5 12h14"/>

                                </svg>



                                Register Midwife



                            </a>



                        @endif



                    </div>



                @endif



            </section>



        </div>

    </div>





    {{-- ========================================= --}}

    {{-- CONFIRMATION MODAL --}}

    {{-- ========================================= --}}



    <div

        id="mm-confirm-modal"

        class="mm-modal"

        aria-hidden="true"

        role="dialog"

        aria-modal="true"

        aria-labelledby="mm-modal-title"

        aria-describedby="mm-modal-description"

    >

        <div class="mm-modal-backdrop" data-modal-close></div>



        <div class="mm-modal-dialog" role="document">



            <div class="mm-modal-icon mm-modal-icon-deactivate" id="mm-modal-icon">

                <svg

                    id="mm-modal-icon-deactivate"

                    width="24"

                    height="24"

                    viewBox="0 0 24 24"

                    fill="none"

                    stroke="currentColor"

                    stroke-width="1.8"

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    aria-hidden="true"

                >

                    <path d="M18.364 18.364A9 9 0 005.636 5.636"/>

                    <path d="M5.636 18.364A9 9 0 0018.364 5.636"/>

                    <path d="M18.364 18.364L5.636 5.636"/>

                </svg>



                <svg

                    id="mm-modal-icon-activate"

                    width="24"

                    height="24"

                    viewBox="0 0 24 24"

                    fill="none"

                    stroke="currentColor"

                    stroke-width="2"

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    aria-hidden="true"

                >

                    <path d="M20 6L9 17l-5-5"/>

                </svg>

            </div>





            <div class="mm-modal-content">



                <h2 id="mm-modal-title" class="mm-modal-title">

                    Confirm Action

                </h2>



                <p id="mm-modal-description" class="mm-modal-description">

                    Are you sure you want to continue?

                </p>



                <div class="mm-modal-account" id="mm-modal-account">

                    <span class="mm-modal-account-label">Midwife Account</span>

                    <strong id="mm-modal-midwife-name"></strong>

                </div>



            </div>





            <div class="mm-modal-actions">



                <button

                    type="button"

                    class="mm-modal-button mm-modal-cancel"

                    id="mm-modal-cancel"

                >

                    Cancel

                </button>



                <button

                    type="button"

                    class="mm-modal-button mm-modal-confirm"

                    id="mm-modal-confirm"

                >

                    <span class="mm-modal-confirm-spinner" aria-hidden="true"></span>

                    <span id="mm-modal-confirm-text">Confirm</span>

                </button>



            </div>



        </div>

    </div>





    {{-- ========================================= --}}

    {{-- INTERACTION JAVASCRIPT --}}

    {{-- ========================================= --}}



    <script>

        document.addEventListener('DOMContentLoaded', function () {



            const modal = document.getElementById('mm-confirm-modal');

            const modalTitle = document.getElementById('mm-modal-title');

            const modalDescription = document.getElementById('mm-modal-description');

            const modalName = document.getElementById('mm-modal-midwife-name');

            const modalIcon = document.getElementById('mm-modal-icon');



            const deactivateIcon = document.getElementById('mm-modal-icon-deactivate');

            const activateIcon = document.getElementById('mm-modal-icon-activate');



            const cancelButton = document.getElementById('mm-modal-cancel');

            const confirmButton = document.getElementById('mm-modal-confirm');

            const confirmText = document.getElementById('mm-modal-confirm-text');



            let activeForm = null;

            let activeAction = null;

            let lastFocusedElement = null;



            function openModal(form) {



                activeForm = form;

                activeAction = form.dataset.confirmAction || 'deactivate';



                lastFocusedElement = document.activeElement;



                const midwifeName = form.dataset.midwifeName || 'this midwife';



                if (activeAction === 'activate') {



                    modalTitle.textContent = 'Activate Midwife Account?';



                    modalDescription.textContent =

                        'Are you sure you want to activate this midwife account? The midwife will regain access to the CareCradle system.';



                    confirmText.textContent = 'Activate Account';



                    modalIcon.classList.remove('mm-modal-icon-deactivate');

                    modalIcon.classList.add('mm-modal-icon-activate');



                    deactivateIcon.style.display = 'none';

                    activateIcon.style.display = 'block';



                    confirmButton.classList.remove('mm-modal-confirm-deactivate');

                    confirmButton.classList.add('mm-modal-confirm-activate');



                } else {



                    modalTitle.textContent = 'Deactivate Midwife Account?';



                    modalDescription.textContent =

                        'Are you sure you want to deactivate this midwife account? The account will no longer be able to access the CareCradle system until it is activated again.';



                    confirmText.textContent = 'Deactivate Account';



                    modalIcon.classList.remove('mm-modal-icon-activate');

                    modalIcon.classList.add('mm-modal-icon-deactivate');



                    deactivateIcon.style.display = 'block';

                    activateIcon.style.display = 'none';



                    confirmButton.classList.remove('mm-modal-confirm-activate');

                    confirmButton.classList.add('mm-modal-confirm-deactivate');



                }



                modalName.textContent = midwifeName;



                modal.classList.add('is-open');

                modal.setAttribute('aria-hidden', 'false');



                document.body.classList.add('mm-modal-open');



                window.setTimeout(function () {

                    cancelButton.focus();

                }, 50);

            }





            function closeModal() {



                if (!modal.classList.contains('is-open')) {

                    return;

                }



                modal.classList.remove('is-open');

                modal.setAttribute('aria-hidden', 'true');



                document.body.classList.remove('mm-modal-open');



                activeForm = null;

                activeAction = null;



                if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {

                    lastFocusedElement.focus();

                }



                lastFocusedElement = null;

            }





            document.querySelectorAll('.mm-status-form').forEach(function (form) {



                form.addEventListener('submit', function (event) {



                    if (form.dataset.confirmed === 'true') {

                        return;

                    }



                    event.preventDefault();



                    openModal(form);

                });



            });





            confirmButton.addEventListener('click', function () {



                if (!activeForm || confirmButton.disabled) {

                    return;

                }



                activeForm.dataset.confirmed = 'true';



                confirmButton.disabled = true;

                cancelButton.disabled = true;



                confirmButton.classList.add('is-loading');



                if (activeAction === 'activate') {

                    confirmText.textContent = 'Activating...';

                } else {

                    confirmText.textContent = 'Deactivating...';

                }



                activeForm.submit();

            });





            cancelButton.addEventListener('click', function () {

                closeModal();

            });





            modal.querySelectorAll('[data-modal-close]').forEach(function (element) {



                element.addEventListener('click', function () {

                    closeModal();

                });



            });





            document.addEventListener('keydown', function (event) {



                if (!modal.classList.contains('is-open')) {

                    return;

                }



                if (event.key === 'Escape') {

                    event.preventDefault();

                    closeModal();

                    return;

                }



                if (event.key === 'Tab') {



                    const focusableElements = modal.querySelectorAll(

                        'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled])'

                    );



                    if (!focusableElements.length) {

                        return;

                    }



                    const firstElement = focusableElements[0];

                    const lastElement = focusableElements[focusableElements.length - 1];



                    if (event.shiftKey && document.activeElement === firstElement) {

                        event.preventDefault();

                        lastElement.focus();

                    } else if (!event.shiftKey && document.activeElement === lastElement) {

                        event.preventDefault();

                        firstElement.focus();

                    }

                }



            });





            document.querySelectorAll('.mm-alert-close').forEach(function (button) {



                button.addEventListener('click', function () {



                    const alert = button.closest('.mm-alert');



                    if (alert) {

                        alert.classList.add('mm-alert-dismissed');



                        window.setTimeout(function () {

                            alert.remove();

                        }, 180);

                    }



                });



            });





            const successAlert = document.querySelector('.mm-alert-success');



            if (successAlert) {



                window.setTimeout(function () {



                    if (!successAlert.classList.contains('mm-alert-dismissed')) {



                        successAlert.classList.add('mm-alert-dismissed');



                        window.setTimeout(function () {

                            successAlert.remove();

                        }, 180);



                    }



                }, 6000);



            }



        });

    </script>



</x-app-layout>