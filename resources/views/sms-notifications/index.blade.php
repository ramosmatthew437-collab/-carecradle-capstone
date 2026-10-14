<x-app-layout>

    <div class="sms-page">

        <div class="sms-container">

            {{-- Flash Messages --}}

            @if (session('success'))

                <div class="sms-alert sms-alert-success">

                    <div class="sms-alert-icon">

                        ✓

                    </div>

                    <div class="sms-alert-content">

                        <strong>Success</strong>

                        <span>{{ session('success') }}</span>

                    </div>

                </div>

            @endif

            @if (session('error'))

                <div class="sms-alert sms-alert-error">

                    <div class="sms-alert-icon">

                        !

                    </div>

                    <div class="sms-alert-content">

                        <strong>Something went wrong</strong>

                        <span>{{ session('error') }}</span>

                    </div>

                </div>

            @endif

            {{-- Hero --}}

            <section class="sms-hero">

                <div class="sms-hero-content">

                    <div class="sms-hero-eyebrow">

                        Communication Center

                    </div>

                    <h1>SMS Notification History</h1>

                    <p>

                        Monitor, review, and manage SMS notifications sent to mothers

                        through CareCradle.

                    </p>

                </div>

                <div class="sms-hero-icon">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">

                        <path stroke-linecap="round" stroke-linejoin="round"

                              d="M8 10h8M8 14h5m-8 6 3.2-3.2A8 8 0 1 1 20 12a8 8 0 0 1-8 8H5Z"/>

                    </svg>

                </div>

            </section>

            {{-- Statistics --}}

            <section class="sms-stats">

                <div class="sms-stat-card">

                    <div class="sms-stat-icon sms-stat-icon-pink">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">

                            <path stroke-linecap="round" stroke-linejoin="round"

                                  d="M8 10h8M8 14h5m-8 6 3.2-3.2A8 8 0 1 1 20 12a8 8 0 0 1-8 8H5Z"/>

                        </svg>

                    </div>

                    <div>

                        <span class="sms-stat-label">Total</span>

                        <strong>{{ $totalNotifications }}</strong>

                    </div>

                </div>

                <div class="sms-stat-card">

                    <div class="sms-stat-icon sms-stat-icon-orange">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">

                            <circle cx="12" cy="12" r="8"/>

                            <path stroke-linecap="round" d="M12 8v4l2.5 1.5"/>

                        </svg>

                    </div>

                    <div>

                        <span class="sms-stat-label">Pending</span>

                        <strong>

                            {{ $pendingNotifications }}

                        </strong>

                    </div>

                </div>

                <div class="sms-stat-card">

                    <div class="sms-stat-icon sms-stat-icon-rose">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">

                            <path stroke-linecap="round" stroke-linejoin="round"

                                  d="m5 12 4 4L19 6"/>

                        </svg>

                    </div>

                    <div>

                        <span class="sms-stat-label">Sent</span>

                        <strong>

                            {{ $sentNotifications }}

                        </strong>

                    </div>

                </div>

                <div class="sms-stat-card">

                    <div class="sms-stat-icon sms-stat-icon-red">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">

                            <circle cx="12" cy="12" r="8"/>

                            <path stroke-linecap="round" d="m9 9 6 6m0-6-6 6"/>

                        </svg>

                    </div>

                    <div>

                        <span class="sms-stat-label">Failed</span>

                        <strong>

                            {{ $failedNotifications }}

                        </strong>

                    </div>

                </div>

            </section>

            {{-- Search --}}

            <section class="sms-card sms-search-card">

                <div class="sms-search-heading">

                    <div>

                        <span class="sms-section-eyebrow">Notification Records</span>

                        <h2>Search Notifications</h2>

                    </div>

                </div>

                <form method="GET" action="{{ route('sms-notifications.index') }}" class="sms-search-form">
                    @if (($status ?? 'All') !== 'All')
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif

                    <div class="sms-search-input-wrap">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                            <circle cx="11" cy="11" r="7"/>

                            <path stroke-linecap="round" d="m20 20-4-4"/>

                        </svg>

                        <input

                            type="text"

                            name="search"

                            value="{{ $search ?? request('search', '') }}"

                            placeholder="Search by mother, phone number, or notification type..."

                            class="sms-search-input"

                        >

                    </div>

                    <button type="submit" class="sms-search-btn">

                        Search

                    </button>

                    @if(request('search'))

                        <a href="{{ route('sms-notifications.index', ($status ?? 'All') !== 'All' ? ['status' => $status] : []) }}" class="sms-clear-btn">

                            Clear

                        </a>

                    @endif

                </form>

                <div class="sms-search-tags">

                    <span>Search by:</span>

                    <span>Mother name</span>

                    <span>Phone number</span>

                    <span>Notification type</span>

                </div>

            </section>

            {{-- Notification Records --}}

            <section class="sms-card sms-records-card">

                <div class="sms-records-header">

                    <div>

                        <span class="sms-section-eyebrow">Communication Logs</span>

                        <h2>Notification Records</h2>

                    </div>

                    <span class="sms-record-count">

                        {{ $notifications->total() }}

                        {{ Str::plural('record', $notifications->total()) }}

                    </span>

                </div>

    {{-- ========================================= --}}

    {{-- STATUS FILTERS --}}

    {{-- ========================================= --}}

    <div class="sms-filter-bar">

        <span class="sms-filter-label">Filter by status</span>

        <div class="sms-filter-options">

            @foreach (['All', 'Pending', 'Sent', 'Failed'] as $filterStatus)

                @php

                    $filterCount = match ($filterStatus) {

                        'Pending' => $pendingNotifications,

                        'Sent' => $sentNotifications,

                        'Failed' => $failedNotifications,

                        default => $totalNotifications,

                    };

                    $filterUrl = route('sms-notifications.index', array_filter([

                        'search' => $search,

                        'status' => $filterStatus === 'All' ? null : $filterStatus,

                    ], fn ($value) => $value !== null && $value !== ''));

                @endphp

                <a

                    href="{{ $filterUrl }}"

                    class="sms-filter-link sms-filter-{{ strtolower($filterStatus) }} {{ $status === $filterStatus ? 'is-active' : '' }}"

                    @if ($status === $filterStatus) aria-current="page" @endif

                >

                    <span>{{ $filterStatus }}</span>

                    <span class="sms-filter-count">{{ $filterCount }}</span>

                </a>

            @endforeach

        </div>

    </div>


                @if($notifications->count())

                    {{-- Desktop / Tablet Table --}}

                    <div class="sms-table-wrapper">

                        <table class="sms-table">

                            <thead>

                                <tr>

                                    <th>Recipient</th>

                                    <th>Notification</th>

                                    <th>Status</th>

                                    <th>Sent / Created</th>

                                    <th class="sms-actions-header">Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($notifications as $notification)

                                    @php

                                        $status = strtolower($notification->status ?? 'pending');

                                        $statusClass = match($status) {

                                            'sent' => 'sms-status-sent',

                                            'failed' => 'sms-status-failed',

                                            default => 'sms-status-pending',

                                        };

                                    @endphp

                                    <tr>

                                        {{-- Recipient --}}

                                        <td>

                                            <div class="sms-recipient">

                                                <div class="sms-avatar">

                                                    {{ strtoupper(substr($notification->mother->first_name ?? 'M', 0, 1)) }}

                                                </div>

                                                <div class="sms-recipient-info">

                                                    <strong>

                                                        {{ $notification->mother->first_name ?? 'Unknown' }}

                                                        {{ $notification->mother->last_name ?? '' }}

                                                    </strong>

                                                    <span>

                                                        {{ $notification->recipient_number }}

                                                    </span>

                                                </div>

                                            </div>

                                        </td>

                                        {{-- Notification Type --}}

                                        <td>

                                            <div class="sms-type">

                                                <strong>

                                                    {{ $notification->notification_type }}

                                                </strong>

                                                @if($notification->error_message)

                                                    <span class="sms-error-preview">

                                                        {{ Str::limit($notification->error_message, 50) }}

                                                    </span>

                                                @endif

                                            </div>

                                        </td>

                                        {{-- Status --}}

                                        <td>

                                            <span class="sms-status {{ $statusClass }}">

                                                <span class="sms-status-dot"></span>

                                                {{ $notification->status }}

                                            </span>

                                        </td>

                                        {{-- Date --}}

                                        <td>

                                            <div class="sms-date">

                                                @if($notification->sent_at)

                                                    <strong>

                                                        {{ \Carbon\Carbon::parse($notification->sent_at)->format('M d, Y') }}

                                                    </strong>

                                                    <span>

                                                        {{ \Carbon\Carbon::parse($notification->sent_at)->format('h:i A') }}

                                                    </span>

                                                @else

                                                    <strong>Not sent</strong>

                                                    <span>

                                                        {{ $notification->created_at?->format('M d, Y h:i A') }}

                                                    </span>

                                                @endif

                                            </div>

                                        </td>

                                        {{-- Actions --}}

                                        <td>

                                            <div class="sms-actions">

                                                <a

                                                    href="{{ route('sms-notifications.show', $notification->id) }}"

                                                    class="sms-view-btn"

                                                >

                                                    <span>View details</span>

                                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">

                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h11m-4-4 4 4-4 4"/>

                                                    </svg>

                                                </a>

                                                @if($notification->status === 'Pending')

                                                    <form

                                                        action="{{ route('sms-notifications.send', $notification) }}"

                                                        method="POST"

                                                        class="sms-send-form"

                                                    >

                                                        @csrf

                                                        <button type="submit" class="sms-send-btn">

                                                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">

                                                                <path stroke-linecap="round" stroke-linejoin="round"

                                                                      d="m3 10 13-6-4 12-3-5-6-1Z"/>

                                                                <path stroke-linecap="round" d="M9 11 16 4"/>

                                                            </svg>

                                                            <span>Send</span>

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

                    {{-- Mobile Cards --}}

                    <div class="sms-mobile-list">

                        @foreach($notifications as $notification)

                            @php

                                $status = strtolower($notification->status ?? 'pending');

                                $statusClass = match($status) {

                                    'sent' => 'sms-status-sent',

                                    'failed' => 'sms-status-failed',

                                    default => 'sms-status-pending',

                                };

                            @endphp

                            <article class="sms-mobile-card">

                                <div class="sms-mobile-top">

                                    <div class="sms-recipient">

                                        <div class="sms-avatar">

                                            {{ strtoupper(substr($notification->mother->first_name ?? 'M', 0, 1)) }}

                                        </div>

                                        <div class="sms-recipient-info">

                                            <strong>

                                                {{ $notification->mother->first_name ?? 'Unknown' }}

                                                {{ $notification->mother->last_name ?? '' }}

                                            </strong>

                                            <span>

                                                {{ $notification->recipient_number }}

                                            </span>

                                        </div>

                                    </div>

                                    <span class="sms-status {{ $statusClass }}">

                                        <span class="sms-status-dot"></span>

                                        {{ $notification->status }}

                                    </span>

                                </div>

                                <div class="sms-mobile-details">

                                    <div class="sms-mobile-detail">

                                        <span>Notification</span>

                                        <strong>{{ $notification->notification_type }}</strong>

                                    </div>

                                    <div class="sms-mobile-detail">

                                        <span>Date</span>

                                        <strong>

                                            @if($notification->sent_at)

                                                {{ \Carbon\Carbon::parse($notification->sent_at)->format('M d, Y h:i A') }}

                                            @else

                                                Not sent

                                            @endif

                                        </strong>

                                    </div>

                                    @if($notification->error_message)

                                        <div class="sms-mobile-error">

                                            <span>Error</span>

                                            {{ $notification->error_message }}

                                        </div>

                                    @endif

                                </div>

                                {{-- Mobile Actions --}}

                                <div class="sms-mobile-actions">

                                    <a

                                        href="{{ route('sms-notifications.show', $notification->id) }}"

                                        class="sms-view-btn"

                                    >

                                        <span>View details</span>

                                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">

                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h11m-4-4 4 4-4 4"/>

                                        </svg>

                                    </a>

                                    @if($notification->status === 'Pending')

                                        <form

                                            action="{{ route('sms-notifications.send', $notification) }}"

                                            method="POST"

                                            class="sms-send-form"

                                        >

                                            @csrf

                                            <button type="submit" class="sms-send-btn">

                                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">

                                                    <path stroke-linecap="round" stroke-linejoin="round"

                                                          d="m3 10 13-6-4 12-3-5-6-1Z"/>

                                                    <path stroke-linecap="round" d="M9 11 16 4"/>

                                                </svg>

                                                <span>Send</span>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>

                    {{-- Pagination --}}

                    @if($notifications->hasPages())

                        <div class="sms-pagination">

                            {{ $notifications->links() }}

                        </div>

                    @endif

                @else

                    {{-- Empty State --}}

                    <div class="sms-empty">

                        <div class="sms-empty-icon">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">

                                <path stroke-linecap="round" stroke-linejoin="round"

                                      d="M8 10h8M8 14h5m-8 6 3.2-3.2A8 8 0 1 1 20 12a8 8 0 0 1-8 8H5Z"/>

                            </svg>

                        </div>

                        <h3>No SMS notifications found</h3>

                        <p>

                            There are no notification records matching your current search.

                        </p>

                        <div class="sms-empty-features">

                            <div class="sms-empty-feature">

                                <div class="sms-empty-feature-icon">

                                    ✓

                                </div>

                                <span>Track SMS delivery</span>

                            </div>

                            <div class="sms-empty-feature">

                                <div class="sms-empty-feature-icon">

                                    ✓

                                </div>

                                <span>Review notification history</span>

                            </div>

                            <div class="sms-empty-feature">

                                <div class="sms-empty-feature-icon">

                                    ✓

                                </div>

                                <span>Manage pending messages</span>

                            </div>

                        </div>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>
