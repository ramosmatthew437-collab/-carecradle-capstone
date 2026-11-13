{{--
    Automated Reminder Monitor. Status, "Last run" and "Last result" all come
    from the latest run started by Laravel's scheduler, recorded by the
    reminder command itself. A configured schedule is never treated as proof,
    and manual command-line runs never count.
--}}
@php
    $tz = $monitor['timezone'];
    $fmt = fn ($t) => $t ? $t->copy()->setTimezone($tz)->format('M d, Y · g:i A') : null;
    $last = $monitor['last'];
    $ok = $monitor['lastSuccessful'];
    $manual = $monitor['newerManual'];
    $counts = fn ($r) => "{$r->processed} processed · {$r->sent} sent · {$r->failed} failed · {$r->skipped} skipped" . ($r->unknown ? " · {$r->unknown} unknown" : '');
@endphp
<section class="smx-monitor smx-monitor-{{ $monitor['state'] }}" aria-labelledby="smx-monitor-title">
    <div class="smx-monitor-main">
        <span class="smx-monitor-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
        </span>
        <div class="smx-monitor-copy">
            <h2 class="smx-monitor-title" id="smx-monitor-title">
                Automatic reminders
                <span class="smx-badge smx-m-{{ $monitor['state'] }}">{{ $monitor['label'] }}</span>
            </h2>
            <p class="smx-monitor-reason">{{ $monitor['reason'] }}</p>
            @if ($manual)
                <p class="smx-monitor-reason">A manual command-line run on {{ $fmt($manual->started_at) }} is listed in Run history; manual runs do not count toward this status.</p>
            @endif
        </div>
    </div>
    <dl class="smx-monitor-facts">
        <div><dt>Schedule</dt><dd>{{ $monitor['schedule'] }}</dd></div>
        <div><dt>Last run</dt><dd>{{ $last ? $fmt($last->started_at) : 'Never recorded' }}</dd></div>
        <div>
            <dt>Last result</dt>
            <dd data-smx-last-result="{{ $last?->status ?? 'none' }}">
                @if (! $last)
                    —
                @elseif ($last->status === 'running')
                    <span class="smx-result-running">In progress</span> · {{ $last->processed }} processed so far ({{ $last->sent }} sent)
                @elseif ($last->status === 'failed')
                    <span class="smx-result-failed">Failed</span>{{ $last->error ? ' — ' . $last->error : '' }}
                    @if ($last->processed > 0)
                        <span class="smx-monitor-sub">Before stopping: {{ $counts($last) }}</span>
                    @endif
                @else
                    {{ $counts($last) }}
                @endif
            </dd>
        </div>
        <div>
            <dt>Next scheduled</dt>
            <dd>{{ $fmt($monitor['nextRun']) }}</dd>
            @if ($ok && $last && $ok->id !== $last->id)
                <dt class="smx-monitor-sub-dt">Last successful run</dt>
                <dd data-smx-last-success>{{ $fmt($ok->started_at) }} · {{ $counts($ok) }}</dd>
            @endif
        </div>
    </dl>
    @if (! request()->routeIs('sms-notifications.scheduler-runs'))
        <a class="smx-monitor-link" href="{{ route('sms-notifications.scheduler-runs') }}">Run history</a>
    @endif
</section>
