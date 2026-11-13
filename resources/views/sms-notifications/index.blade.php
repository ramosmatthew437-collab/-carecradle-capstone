<x-app-layout>
    @include('sms-notifications._styles')

    @php
        $statusLabels = [
            'Pending' => 'Pending', 'Sending' => 'Sending', 'Sent' => 'Sent', 'Failed' => 'Failed',
            'Unknown' => 'Unknown', 'Cancelled' => 'Cancelled', 'Expired' => 'Expired',
        ];
        $statusHints = [
            'Pending' => 'Not sent yet',
            'Sending' => 'Submission in progress',
            'Sent' => 'Accepted by TextBee',
            'Failed' => 'Not accepted',
            'Unknown' => 'Outcome not confirmed',
            'Cancelled' => 'Will not be sent',
            'Expired' => 'Will not be sent',
        ];
        // Status cards keep the current search; they clear the attention filter.
        $filterUrl = fn (string $value) => route('sms-notifications.index', array_filter([
            'search' => $search ?: null,
            'status' => $value === 'All' ? null : $value,
        ]));
        // Attention chips keep the search and status; clicking the active chip turns it off.
        $attentionUrl = fn (string $value) => route('sms-notifications.index', array_filter([
            'search' => $search ?: null,
            'status' => $status === 'All' ? null : $status,
            'attention' => $attention === $value ? null : $value,
        ]));
        $cards = [
            ['All', 'Total', $stats['total'], 'total'],
            ['Pending', 'Pending', $stats['pending'], 'pending'],
            ['Sent', 'Sent', $stats['sent'], 'sent'],
            ['Failed', 'Failed', $stats['failed'], 'failed'],
        ];
        $when = fn ($t) => $t ? \Illuminate\Support\Carbon::parse($t)->format('M d, Y · g:i A') : null;
    @endphp

    <div class="smx">
        <div class="smx-container">

            <header class="smx-head">
                <div class="smx-head-main">
                    <span class="smx-head-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6 2.6-2.6A2 2 0 0 1 8 16.8h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"/></svg>
                    </span>
                    <div>
                        <p class="smx-kicker">Communication Center</p>
                        <h1 class="smx-title">SMS Notifications</h1>
                        <p class="smx-subtitle">Appointment reminders sent through TextBee. <strong>Sent</strong> means TextBee accepted the message; delivery to the phone is shown only when TextBee confirms it.</p>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            @foreach (['success' => 'Done', 'warning' => 'Please check', 'error' => 'Not sent'] as $key => $heading)
                @if (session($key))
                    <div class="smx-alert smx-alert-{{ $key }}" role="{{ $key === 'success' ? 'status' : 'alert' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            @if ($key === 'success')
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                            @endif
                        </svg>
                        <div><strong>{{ $heading }}</strong><p>{{ session($key) }}</p></div>
                    </div>
                @endif
            @endforeach

            @include('sms-notifications._scheduler-monitor')

            {{-- Statistics (they follow the search) --}}
            <nav class="smx-stats" aria-label="Filter by status">
                @foreach ($cards as [$value, $label, $count, $dot])
                    <a href="{{ $filterUrl($value) }}" class="smx-stat" @if ($status === $value && $attention === '') aria-current="true" @endif>
                        <span class="smx-stat-label"><span class="smx-stat-dot smx-dot-{{ $dot }}" aria-hidden="true"></span>{{ $label }}</span>
                        <span class="smx-stat-value">{{ number_format($count) }}</span>
                    </a>
                @endforeach
            </nav>
            @if ($filtered || $otherStatuses->isNotEmpty())
                <p class="smx-stats-note">
                    @if ($filtered)Counts reflect the current search.@endif
                    @if ($otherStatuses->isNotEmpty())
                        Total also includes {{ $otherStatuses->map(fn ($c, $s) => $c . ' ' . strtolower($s))->implode(', ') }}.
                    @endif
                </p>
            @endif

            {{-- Attention: extra conditions that overlap with the statuses above (not added to Total) --}}
            <nav class="smx-attention" aria-label="Needs attention">
                <span class="smx-attention-label">Needs attention</span>
                @foreach (['review' => 'Needs review', 'overdue' => 'Overdue'] as $value => $label)
                    <a href="{{ $attentionUrl($value) }}" @class(['smx-chip', 'smx-chip-' . $value, 'smx-chip-zero' => $attentionCounts[$value] === 0])
                        @if ($attention === $value) aria-current="true" @endif
                        title="{{ $value === 'review' ? 'Unknown outcomes, interrupted sends, number changes and reminders whose appointment is closed' : 'Pending reminders whose appointment date has passed' }}">
                        {{ $label }} <span class="smx-chip-count">{{ $attentionCounts[$value] }}</span>
                    </a>
                @endforeach
                <span>A notification can be in both.</span>
            </nav>

            {{-- Search and filters --}}
            <form method="GET" action="{{ route('sms-notifications.index') }}" class="smx-filters" role="search">
                <div class="smx-field smx-search-field">
                    <label class="smx-label" for="smx-search">Search</label>
                    <div class="smx-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3.5-3.5"/></svg>
                        <input id="smx-search" type="search" name="search" value="{{ $search }}" maxlength="100" class="smx-input" placeholder="Name, Mother Code or mobile number" autocomplete="off">
                    </div>
                </div>
                <div class="smx-field">
                    <label class="smx-label" for="smx-status">Status</label>
                    <select id="smx-status" name="status" class="smx-select">
                        <option value="All" @selected($status === 'All')>All statuses</option>
                        @foreach ($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($attention !== '')
                    <input type="hidden" name="attention" value="{{ $attention }}">
                @endif
                <div class="smx-filter-actions">
                    <button type="submit" class="smx-btn smx-btn-primary">Apply</button>
                    @if ($filtered || $status !== 'All' || $attention !== '')
                        <a href="{{ route('sms-notifications.index') }}" class="smx-btn smx-btn-quiet">Clear</a>
                    @endif
                </div>
            </form>

            @if ($notifications->total() > 0)
                <p class="smx-results" aria-live="polite">
                    <span>Showing {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }} of {{ number_format($notifications->total()) }} notification{{ $notifications->total() === 1 ? '' : 's' }}</span>
                </p>
            @endif

            <section class="smx-panel" aria-label="SMS notifications">
                @if ($notifications->isEmpty())
                    <div class="smx-empty">
                        <span class="smx-empty-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 6 2.6-2.6A2 2 0 0 1 8 16.8h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v14Z"/></svg>
                        </span>
                        @if ($filtered || $status !== 'All' || $attention !== '')
                            <h2>No matching notifications</h2>
                            <p>No SMS notification matches this search or filter. Try a different name, Mother Code or number, or clear the filters.</p>
                            <a href="{{ route('sms-notifications.index') }}" class="smx-btn smx-btn-secondary">Clear filters</a>
                        @else
                            <h2>No SMS notifications yet</h2>
                            <p>A reminder is created automatically when an appointment is scheduled for a mother.</p>
                        @endif
                    </div>
                @else
                    <div class="smx-list-head" aria-hidden="true">
                        <span>Recipient</span><span>Type &amp; appointment</span><span>Status</span><span>Timeline</span><span style="text-align:right">Actions</span>
                    </div>

                    <ul style="list-style:none;margin:0;padding:0">
                        @foreach ($notifications as $sms)
                            @php
                                $f = $flags[$sms->id];
                                $mother = $sms->mother;
                                $appt = $sms->appointmentDetails();
                                // The stored status, as recorded (an interrupted send stays "Sending"
                                // until the scheduled reconciliation marks it Unknown).
                                $displayStatus = $sms->status;
                            @endphp
                            <li class="smx-row">
                                <div class="smx-cell smx-cell-recipient">
                                    <span class="smx-cell-label">Recipient</span>
                                    @if ($mother)
                                        <a class="smx-name" href="{{ route('mothers.show', $mother->id) }}">{{ trim($mother->first_name . ' ' . $mother->last_name) }}</a>
                                        <span class="smx-meta">{{ $mother->mother_code }}</span>
                                    @else
                                        <span class="smx-name">Mother record unavailable</span>
                                    @endif
                                    <span class="smx-meta smx-mono">{{ $sms->recipient_number }}</span>
                                    @if ($f['mismatch'] && in_array($sms->status, ['Pending', 'Failed'], true))
                                        <span class="smx-flags"><span class="smx-badge smx-s-review">Number differs from current</span></span>
                                    @endif
                                </div>

                                <div class="smx-cell">
                                    <span class="smx-cell-label">Type &amp; appointment</span>
                                    <span class="smx-name" style="font-weight:600">{{ $sms->notification_type }}</span>
                                    @if ($sms->appointmentWasDeleted())
                                        <span class="smx-flags" style="margin-top:0.25rem"><span class="smx-badge smx-badge-plain smx-deleted">Appointment Deleted</span></span>
                                        @if ($appt)
                                            <span class="smx-meta">Was: {{ $appt['type'] }} · {{ \Illuminate\Support\Carbon::parse($appt['date'])->format('M d, Y') }} · {{ \Illuminate\Support\Carbon::parse($appt['time'])->format('g:i A') }}</span>
                                        @else
                                            <span class="smx-meta">Appointment details were not recorded</span>
                                        @endif
                                    @elseif ($appt)
                                        <span class="smx-meta">{{ $appt['type'] }} · {{ \Illuminate\Support\Carbon::parse($appt['date'])->format('M d, Y') }} · {{ \Illuminate\Support\Carbon::parse($appt['time'])->format('g:i A') }}</span>
                                        <span class="smx-meta">Appointment: {{ $appt['status'] }}</span>
                                    @endif
                                    @if ($f['overdue'])
                                        <span class="smx-flags"><span class="smx-badge smx-s-unknown">Overdue</span></span>
                                    @endif
                                </div>

                                <div class="smx-cell">
                                    <span class="smx-cell-label">Status</span>
                                    <span class="smx-flags" style="margin-top:0">
                                        <span class="smx-badge smx-s-{{ strtolower($displayStatus) }}">{{ $displayStatus }}</span>
                                        @if ($sms->status === 'Sent' && $sms->delivered_at)
                                            <span class="smx-badge smx-delivered">Delivered</span>
                                        @endif
                                    </span>
                                    <span class="smx-meta" style="margin-top:0.25rem">
                                        @if ($sms->status === 'Sent' && $sms->delivered_at)
                                            Delivery confirmed by TextBee {{ $when($sms->delivered_at) }}
                                        @elseif ($sms->status === 'Sent')
                                            Accepted by TextBee · delivery not yet confirmed
                                        @elseif ($f['stuck'])
                                            Interrupted · the automatic check will mark it Unknown for review
                                        @else
                                            {{ $statusHints[$sms->status] ?? '' }}
                                        @endif
                                    </span>
                                    @if (in_array($sms->status, ['Cancelled', 'Expired'], true) && $sms->closedReasonLabel())
                                        <span class="smx-meta">Reason: {{ $sms->closedReasonLabel() }}</span>
                                    @endif
                                    @if ($f['review'])
                                        <span class="smx-flags"><span class="smx-badge smx-s-review">Needs review</span></span>
                                    @endif
                                </div>

                                <div class="smx-cell">
                                    <span class="smx-cell-label">Timeline</span>
                                    <span class="smx-meta">Created {{ $when($sms->created_at) }}</span>
                                    @if ($sms->sent_at)
                                        <span class="smx-meta">Sent {{ $when($sms->sent_at) }}</span>
                                    @elseif ($sms->last_attempt_at)
                                        <span class="smx-meta">Last attempt {{ $when($sms->last_attempt_at) }}</span>
                                    @endif
                                    @if ($sms->attempts > 0)
                                        <span class="smx-meta">{{ $sms->attempts }} attempt{{ $sms->attempts === 1 ? '' : 's' }}</span>
                                    @endif
                                    @if ($source = $sms->sourceLabel())
                                        <span @class(['smx-source', 'smx-source-auto' => $source === 'Automatic'])
                                            title="{{ $source === 'Automatic' ? 'Sent by the daily reminder schedule' : 'Sent by a midwife' }}">{{ $source }}</span>
                                    @elseif (in_array($sms->status, ['Sent', 'Failed'], true))
                                        <span class="smx-meta">Source not recorded</span>
                                    @endif
                                </div>

                                <div class="smx-cell smx-cell-actions">
                                    <span class="smx-cell-label">Actions</span>
                                    <div class="smx-actions">
                                        <a href="{{ route('sms-notifications.show', $sms->id) }}" class="smx-btn smx-btn-quiet smx-btn-sm" aria-label="View notification #{{ $sms->id }}">View</a>

                                        @if ($f['canSend'])
                                            <form method="POST" action="{{ route('sms-notifications.send', $sms->id) }}" data-smx-submit data-busy-label="Sending…"
                                                data-confirm="Send this reminder to {{ $sms->maskedRecipient() }} now?">
                                                @csrf
                                                <button type="submit" class="smx-btn smx-btn-primary smx-btn-sm">Send</button>
                                            </form>
                                        @elseif ($f['canRetry'])
                                            <form method="POST" action="{{ route('sms-notifications.retry', $sms->id) }}" data-smx-submit data-busy-label="Retrying…"
                                                data-confirm="TextBee did not accept this message before. Try sending it again to {{ $sms->maskedRecipient() }}?">
                                                @csrf
                                                <button type="submit" class="smx-btn smx-btn-secondary smx-btn-sm">Retry</button>
                                            </form>
                                        @elseif ($f['review'] || in_array($sms->status, ['Pending', 'Failed'], true))
                                            <a href="{{ route('sms-notifications.show', $sms->id) }}#review" class="smx-btn smx-btn-warn smx-btn-sm">Review</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            @if ($notifications->hasPages())
                <div class="smx-pagination">{{ $notifications->onEachSide(1)->links() }}</div>
            @endif
        </div>
    </div>

    @include('sms-notifications._scripts')
</x-app-layout>
