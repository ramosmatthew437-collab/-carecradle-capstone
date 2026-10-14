<x-app-layout>
<div class="mm-wrap">

        <div class="mm-container">

            {{-- =====================================================

                 SUCCESS ALERT

            ====================================================== --}}

            @if(session('success'))

                <div class="mm-alert">

                    <div class="mm-alert-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"

                             fill="none"

                             viewBox="0 0 24 24"

                             stroke="currentColor"

                             stroke-width="2">

                            <path stroke-linecap="round"

                                  stroke-linejoin="round"

                                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                        </svg>

                    </div>

                    <div class="mm-alert-content">

                        <h3 class="mm-alert-title">

                            Operation Successful

                        </h3>

                        <p class="mm-alert-message">

                            {{ session('success') }}

                        </p>

                    </div>

                </div>

            @endif

            {{-- =====================================================

                 PAGE HEADER

            ====================================================== --}}

            <div class="mm-page-head" aria-labelledby="mother-registry-title">

                <div class="mm-page-main">

                    <div class="mm-page-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"

                             fill="none"

                             viewBox="0 0 24 24"

                             stroke="currentColor"

                             stroke-width="1.8">

                            <path stroke-linecap="round"

                                  stroke-linejoin="round"

                                  d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Zm9 0v.01M6 12v.01"/>

                        </svg>

                    </div>

                    <div class="mm-page-copy">

                        <p class="mm-eyebrow">

                            Maternal Health Management

                        </p>

                        <h1 class="mm-title" id="mother-registry-title">

                            Mother Registry

                        </h1>

                        <p class="mm-description">

                            Manage registered mothers, maintain maternal records, update patient

                            information, and monitor pregnancy status through a centralized

                            electronic medical record system.

                        </p>

                    </div>

                </div>

                <a href="{{ route('mothers.create') }}"

                   class="mm-register-btn">

                    <svg xmlns="http://www.w3.org/2000/svg"

                         fill="none"

                         viewBox="0 0 24 24"

                         stroke="currentColor"

                         stroke-width="1.8">

                        <path stroke-linecap="round"

                              stroke-linejoin="round"

                              d="M12 4.5v15m7.5-7.5h-15"/>

                    </svg>

                    Register Mother

                </a>

            </div>

            {{-- =====================================================

                 DASHBOARD STATISTICS

            ====================================================== --}}

            <div class="mm-stats">

                {{-- Total Mothers --}}

                <div class="mm-stat">

                    <div class="mm-stat-top">

                        <div class="mm-stat-copy">

                            <p class="mm-stat-label">

                                Total Registered Mothers

                            </p>

                            <h2 class="mm-stat-value">

                                {{ $totalMothers }}

                            </h2>

                            <p class="mm-stat-description">

                                Registered maternal records

                            </p>

                        </div>

                        <div class="mm-stat-icon mm-stat-icon-pink">

                            <svg xmlns="http://www.w3.org/2000/svg"

                                 fill="none"

                                 viewBox="0 0 24 24"

                                 stroke="currentColor"

                                 stroke-width="1.8">

                                <path stroke-linecap="round"

                                      stroke-linejoin="round"

                                      d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Z"/>

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- Pregnant Mothers --}}

                <div class="mm-stat">

                    <div class="mm-stat-top">

                        <div class="mm-stat-copy">

                            <p class="mm-stat-label">

                                Pregnant Mothers

                            </p>

                            <h2 class="mm-stat-value">

                                {{ $pregnantMothers }}

                            </h2>

                            <p class="mm-stat-description">

                                Currently under prenatal monitoring

                            </p>

                        </div>

                        <div class="mm-stat-icon mm-stat-icon-green">

                            <svg xmlns="http://www.w3.org/2000/svg"

                                 fill="none"

                                 viewBox="0 0 24 24"

                                 stroke="currentColor"

                                 stroke-width="1.8">

                                <path stroke-linecap="round"

                                      stroke-linejoin="round"

                                      d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- Upcoming Appointments --}}

                <div class="mm-stat">

                    <div class="mm-stat-top">

                        <div class="mm-stat-copy">

                            <p class="mm-stat-label">

                                Upcoming Appointments

                            </p>

                            <h2 class="mm-stat-value">

                                {{ $upcomingAppointments }}

                            </h2>

                            <p class="mm-stat-description">

                                Scheduled maternal visits

                            </p>

                        </div>

                        <div class="mm-stat-icon mm-stat-icon-yellow">

                            <svg xmlns="http://www.w3.org/2000/svg"

                                 fill="none"

                                 viewBox="0 0 24 24"

                                 stroke="currentColor"

                                 stroke-width="1.8">

                                <path stroke-linecap="round"

                                      stroke-linejoin="round"

                                      d="M8.25 6.75V3m7.5 3.75V3M3.75 9.75h16.5m-15 10.5h13.5A1.5 1.5 0 0020.25 18V6A1.5 1.5 0 0018.75 4.5H5.25A1.5 1.5 0 003.75 6v12A1.5 1.5 0 005.25 20.25Z"/>

                            </svg>

                        </div>

                    </div>

                </div>

                {{-- Registered Infants --}}

                <div class="mm-stat">

                    <div class="mm-stat-top">

                        <div class="mm-stat-copy">

                            <p class="mm-stat-label">

                                Registered Infants

                            </p>

                            <h2 class="mm-stat-value mm-stat-value-pink">

                                {{ $totalInfants }}

                            </h2>

                            <p class="mm-stat-description">

                                Infant health records

                            </p>

                        </div>

                        <div class="mm-stat-icon mm-stat-icon-blue">

                            <svg xmlns="http://www.w3.org/2000/svg"

                                 fill="none"

                                 viewBox="0 0 24 24"

                                 stroke="currentColor"

                                 stroke-width="1.8">

                                <path stroke-linecap="round"

                                      stroke-linejoin="round"

                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>

                            </svg>

                        </div>

                    </div>

                </div>

            </div>

            {{-- =====================================================

                 SEARCH

            ====================================================== --}}

            <div class="mm-search-card">

                <div class="mm-search-head">

                    <div class="mm-search-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"

                             fill="none"

                             viewBox="0 0 24 24"

                             stroke="currentColor"

                             stroke-width="1.8">

                            <path stroke-linecap="round"

                                  stroke-linejoin="round"

                                  d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="mm-search-title">

                            Search Mother Records

                        </h2>

                        <p class="mm-search-description">

                            Search by mother's name, mother code, barangay, contact number,

                            or maternal status.

                        </p>

                    </div>

                </div>

                <div class="mm-search-body">

                    <form method="GET"

                          action="{{ route('mothers.index') }}">

                        <input type="hidden"

                               name="status"

                               value="{{ $status }}">

                        <div class="mm-search-form">

                            <div class="mm-search-field">

                                <div class="mm-search-field-icon">

                                    <svg xmlns="http://www.w3.org/2000/svg"

                                         fill="none"

                                         viewBox="0 0 24 24"

                                         stroke="currentColor"

                                         stroke-width="1.8">

                                        <path stroke-linecap="round"

                                              stroke-linejoin="round"

                                              d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                                    </svg>

                                </div>

                                <input

                                    type="text"

                                    name="search"

                                    value="{{ request('search') }}"

                                    placeholder="Search by mother name, mother code, barangay, contact number, or status..."

                                    class="mm-search-input">

                            </div>

                            <div class="mm-search-actions">

                                <button type="submit"

                                        class="mm-search-btn">

                                    <svg xmlns="http://www.w3.org/2000/svg"

                                         fill="none"

                                         viewBox="0 0 24 24"

                                         stroke="currentColor"

                                         stroke-width="1.8">

                                        <path stroke-linecap="round"

                                              stroke-linejoin="round"

                                              d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                                    </svg>

                                    Search

                                </button>

                                @if(request('search') || request('status'))

                                    <a href="{{ route('mothers.index', array_filter(['status' => $status])) }}"

                                       class="mm-reset-btn">

                                        <svg xmlns="http://www.w3.org/2000/svg"

                                             fill="none"

                                             viewBox="0 0 24 24"

                                             stroke="currentColor"

                                             stroke-width="1.8">

                                            <path stroke-linecap="round"

                                                  stroke-linejoin="round"

                                                  d="M4.5 12a7.5 7.5 0 0 1 12.89-5.303M19.5 4.5v6h-6"/>

                                        </svg>

                                        Reset Search

                                    </a>

                                @endif

                            </div>

                        </div>

                    </form>

                    <div class="mm-search-tags">

                        <span class="mm-search-tag mm-tag-pink">

                            Mother Name

                        </span>

                        <span class="mm-search-tag mm-tag-blue">

                            Mother Code

                        </span>

                        <span class="mm-search-tag mm-tag-green">

                            Barangay

                        </span>

                        <span class="mm-search-tag mm-tag-orange">

                            Contact Number

                        </span>

                        <span class="mm-search-tag mm-tag-purple">

                            Maternal Status

                        </span>

                    </div>

                </div>

            </div>

            {{-- =====================================================

                 REGISTERED MOTHERS

            ====================================================== --}}

            <div class="mm-registry">

                <div class="mm-registry-head">

                    <div>

                        <h2 class="mm-registry-title">

                            Registered Mothers

                        </h2>

                        <p class="mm-registry-description">

                            View and manage all maternal patient records.

                        </p>

                    </div>

                    <span class="mm-record-count">

                        @if(request('search'))

                            Showing {{ $mothers->count() }} of {{ $totalMothers }} Records

                        @else

                            {{ $totalMothers }} Records

                        @endif

                    </span>

                </div>

                {{-- =================================================

                     STATUS FILTERS

                ================================================== --}}

                <div class="mm-filter-bar">

                    <a href="{{ route('mothers.index', array_filter(['search' => $search])) }}"

                       class="mm-filter mm-filter-all {{ !$status || $status === 'All' ? 'mm-filter-active' : '' }}">

                        All

                        <span class="mm-filter-count">

                            {{ $totalMothers }}

                        </span>

                    </a>

                    <a href="{{ route('mothers.index', array_filter(['search' => $search, 'status' => 'Pregnant'])) }}"

                       class="mm-filter mm-filter-pregnant {{ $status === 'Pregnant' ? 'mm-filter-active' : '' }}">

                        Pregnant

                        <span class="mm-filter-count">

                            {{ $pregnantMothers }}

                        </span>

                    </a>

                    <a href="{{ route('mothers.index', array_filter(['search' => $search, 'status' => 'Delivered'])) }}"

                       class="mm-filter mm-filter-delivered {{ $status === 'Delivered' ? 'mm-filter-active' : '' }}">

                        Delivered

                        <span class="mm-filter-count">

                            {{ $deliveredMothers }}

                        </span>

                    </a>

                    <a href="{{ route('mothers.index', array_filter(['search' => $search, 'status' => 'Referred'])) }}"

                       class="mm-filter mm-filter-referred {{ $status === 'Referred' ? 'mm-filter-active' : '' }}">

                        Referred

                        <span class="mm-filter-count">

                            {{ $referredMothers }}

                        </span>

                    </a>

                </div>

                {{-- =================================================

                     MOTHERS DATA

                ================================================== --}}

                @if($mothers->count())

                    {{-- =================================================

                         DESKTOP TABLE

                    ================================================== --}}

                    <div class="mm-table-wrap">

                        <table class="mm-table">

                            <thead>

                                <tr>

                                    <th>

                                        Mother Code

                                    </th>

                                    <th>

                                        Full Name

                                    </th>

                                    <th>

                                        Barangay

                                    </th>

                                    <th>

                                        Contact Number

                                    </th>

                                    <th class="mm-center">

                                        Status

                                    </th>

                                    <th class="mm-center">

                                        Actions

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($mothers as $mother)

                                    @php

                                        $statusClass = match($mother->status) {

                                            'Pregnant' => 'mm-status-pregnant',

                                            'Delivered' => 'mm-status-delivered',

                                            'Referred' => 'mm-status-referred',

                                            default => 'mm-status-default',

                                        };

                                    @endphp

                                    <tr>

                                        <td>

                                            <span class="mm-code">

                                                {{ $mother->mother_code }}

                                            </span>

                                        </td>

                                        <td>

                                            <div class="mm-mother">

                                                <div class="mm-avatar">

                                                    <svg xmlns="http://www.w3.org/2000/svg"

                                                         fill="none"

                                                         viewBox="0 0 24 24"

                                                         stroke="currentColor"

                                                         stroke-width="1.8">

                                                        <path stroke-linecap="round"

                                                              stroke-linejoin="round"

                                                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                                    </svg>

                                                </div>

                                                <div>

                                                    <p class="mm-mother-name">

                                                        {{ $mother->first_name }}

                                                        {{ $mother->middle_name }}

                                                        {{ $mother->last_name }}

                                                    </p>

                                                </div>

                                            </div>

                                        </td>

                                        <td>

                                            {{ $mother->barangay }}

                                        </td>

                                        <td>

                                            {{ $mother->contact_number }}

                                        </td>

                                        <td class="mm-center">

                                            <span class="mm-status {{ $statusClass }}">

                                                {{ $mother->status }}

                                            </span>

                                        </td>

                                        <td>

                                            <div class="mm-actions">

                                                <a href="{{ route('mothers.show', $mother->id) }}"

                                                   class="mm-action mm-action-view">

                                                    <svg xmlns="http://www.w3.org/2000/svg"

                                                         fill="none"

                                                         viewBox="0 0 24 24"

                                                         stroke="currentColor"

                                                         stroke-width="2">

                                                        <path stroke-linecap="round"

                                                              stroke-linejoin="round"

                                                              d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.178a1.012 1.012 0 010 .644C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178Z"/>

                                                        <path stroke-linecap="round"

                                                              stroke-linejoin="round"

                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                                                    </svg>

                                                    View

                                                </a>

                                                <a href="{{ route('mothers.edit', $mother->id) }}"

                                                   class="mm-action mm-action-edit">

                                                    <svg xmlns="http://www.w3.org/2000/svg"

                                                         fill="none"

                                                         viewBox="0 0 24 24"

                                                         stroke="currentColor"

                                                         stroke-width="2">

                                                        <path stroke-linecap="round"

                                                              stroke-linejoin="round"

                                                              d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>

                                                        <path stroke-linecap="round"

                                                              stroke-linejoin="round"

                                                              d="M19.5 7.125 16.875 4.5"/>

                                                    </svg>

                                                    Edit

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    {{-- =================================================

                         MOBILE CARDS

                    ================================================== --}}

                    <div class="mm-mobile-list">

                        @foreach($mothers as $mother)

                            @php

                                $statusClass = match($mother->status) {

                                    'Pregnant' => 'mm-status-pregnant',

                                    'Delivered' => 'mm-status-delivered',

                                    'Referred' => 'mm-status-referred',

                                    default => 'mm-status-default',

                                };

                            @endphp

                            <div class="mm-mother-card">

                                <div class="mm-mobile-top">

                                    <div class="mm-mobile-mother">

                                        <div class="mm-avatar">

                                            <svg xmlns="http://www.w3.org/2000/svg"

                                                 fill="none"

                                                 viewBox="0 0 24 24"

                                                 stroke="currentColor"

                                                 stroke-width="1.8">

                                                <path stroke-linecap="round"

                                                      stroke-linejoin="round"

                                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                            </svg>

                                        </div>

                                        <div class="mm-mobile-info">

                                            <p class="mm-mobile-name">

                                                {{ $mother->first_name }}

                                                {{ $mother->middle_name }}

                                                {{ $mother->last_name }}

                                            </p>

                                            <p class="mm-mobile-code">

                                                {{ $mother->mother_code }}

                                            </p>

                                        </div>

                                    </div>

                                    <span class="mm-status {{ $statusClass }}">

                                        {{ $mother->status }}

                                    </span>

                                </div>

                                <div class="mm-mobile-details">

                                    <div>

                                        <p class="mm-detail-label">

                                            Barangay

                                        </p>

                                        <p class="mm-detail-value">

                                            {{ $mother->barangay }}

                                        </p>

                                    </div>

                                    <div>

                                        <p class="mm-detail-label">

                                            Contact Number

                                        </p>

                                        <p class="mm-detail-value">

                                            {{ $mother->contact_number }}

                                        </p>

                                    </div>

                                </div>

                                <div class="mm-mobile-actions">

                                    <a href="{{ route('mothers.show', $mother->id) }}"

                                       class="mm-action mm-action-view">

                                        <svg xmlns="http://www.w3.org/2000/svg"

                                             fill="none"

                                             viewBox="0 0 24 24"

                                             stroke="currentColor"

                                             stroke-width="2">

                                            <path stroke-linecap="round"

                                                  stroke-linejoin="round"

                                                  d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.178a1.012 1.012 0 010 .644C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178Z"/>

                                            <path stroke-linecap="round"

                                                  stroke-linejoin="round"

                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                                        </svg>

                                        View

                                    </a>

                                    <a href="{{ route('mothers.edit', $mother->id) }}"

                                       class="mm-action mm-action-edit">

                                        <svg xmlns="http://www.w3.org/2000/svg"

                                             fill="none"

                                             viewBox="0 0 24 24"

                                             stroke="currentColor"

                                             stroke-width="2">

                                            <path stroke-linecap="round"

                                                  stroke-linejoin="round"

                                                  d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>

                                            <path stroke-linecap="round"

                                                  stroke-linejoin="round"

                                                  d="M19.5 7.125 16.875 4.5"/>

                                        </svg>

                                        Edit

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    {{-- =================================================

                         EMPTY STATE

                    ================================================== --}}

                    <div class="mm-empty-wrap">

                        <div class="mm-empty">

                            <div class="mm-empty-icon">

                                <svg xmlns="http://www.w3.org/2000/svg"

                                     fill="none"

                                     viewBox="0 0 24 24"

                                     stroke="currentColor"

                                     stroke-width="1.8">

                                    <path stroke-linecap="round"

                                          stroke-linejoin="round"

                                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                </svg>

                            </div>

                            <h3 class="mm-empty-title">

                                No Registered Mothers Found

                            </h3>

                            <p class="mm-empty-description">

                                There are currently no maternal records in the registry.

                                Register the first mother to begin maintaining electronic

                                maternal health records.

                            </p>

                            <a href="{{ route('mothers.create') }}"

                               class="mm-register-btn mm-empty-btn">

                                <svg xmlns="http://www.w3.org/2000/svg"

                                     fill="none"

                                     viewBox="0 0 24 24"

                                     stroke="currentColor"

                                     stroke-width="1.8">

                                    <path stroke-linecap="round"

                                          stroke-linejoin="round"

                                          d="M12 4.5v15m7.5-7.5h-15"/>

                                </svg>

                                Register Mother

                            </a>

                        </div>

                    </div>

                @endif

                {{-- =================================================

                     PAGINATION

                ================================================== --}}

                @if(method_exists($mothers, 'links'))

                    <div class="mm-pagination">

                        {{ $mothers->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
