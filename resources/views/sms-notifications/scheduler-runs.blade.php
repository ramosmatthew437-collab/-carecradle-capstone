<x-app-layout>
    @include('sms-notifications._styles')

    @php
        $tz = $monitor['timezone'];
        $fmt = fn ($t) => $t ? $t->copy()->setTimezone($tz)->format('M d, Y · g:i:s A') : '—';
    @endphp

    <div class="smx">
        <div class="smx-container">

            <a href="{{ route('sms-notifications.index') }}" class="smx-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                Back to SMS Notifications
            </a>

            <header class="smx-head">
                <div class="smx-head-main">
                    <div>
                        <p class="smx-kicker">Communication Center</p>
                        <h1 class="smx-title">Automatic Reminder Runs</h1>
                        <p class="smx-subtitle">Each row is a run recorded by the reminder command itself when it started and finished. Only runs started by the Scheduler count toward the status above; Manual (CLI) runs are listed for reference.</p>
                    </div>
                </div>
            </header>

            @include('sms-notifications._scheduler-monitor')

            <section class="smx-panel" aria-label="Recorded runs">
                @if ($runs->isEmpty())
                    <div class="smx-empty">
                        <h2>No runs recorded yet</h2>
                        <p>The daily reminder run has not reported to CareCradle. On the server, a cron job must run <span class="smx-mono">php artisan schedule:run</span> every minute.</p>
                    </div>
                @else
                    <table class="smx-runs">
                        <thead>
                            <tr><th>Started</th><th>Trigger</th><th>Finished</th><th>Result</th><th>Processed</th><th>Sent</th><th>Failed</th><th>Unknown</th><th>Skipped</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($runs as $run)
                                <tr>
                                    <td data-label="Started">{{ $fmt($run->started_at) }}</td>
                                    <td data-label="Trigger"><span @class(['smx-trigger', 'smx-trigger-scheduler' => $run->trigger === 'scheduler'])>{{ $run->triggerLabel() }}</span></td>
                                    <td data-label="Finished">{{ $fmt($run->finished_at) }}</td>
                                    <td data-label="Result">
                                        <span class="smx-badge {{ ['completed' => 'smx-s-sent', 'failed' => 'smx-s-failed', 'running' => 'smx-s-sending'][$run->status] ?? 'smx-s-cancelled' }}">{{ ucfirst($run->status) }}</span>
                                        @if ($run->error)<span class="smx-meta">{{ $run->error }}</span>@endif
                                    </td>
                                    <td data-label="Processed">{{ $run->processed }}</td>
                                    <td data-label="Sent">{{ $run->sent }}</td>
                                    <td data-label="Failed">{{ $run->failed }}</td>
                                    <td data-label="Unknown">{{ $run->unknown }}</td>
                                    <td data-label="Skipped">{{ $run->skipped }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>

            @if ($runs->hasPages())
                <div class="smx-pagination">{{ $runs->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
