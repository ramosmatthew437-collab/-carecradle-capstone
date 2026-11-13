{{--
    Read-only referral history (used on the Midwife profile and the
    Administrator patient record). Expects $referrals (newest first).
--}}
@php
    $mrfBadge = fn ($s) => match ($s) { 'Active' => 'mrf-b-active', 'Closed' => 'mrf-b-closed', default => 'mrf-b-error' };
    $mrfDate = fn ($d) => $d ? \Illuminate\Support\Carbon::parse($d)->format('M d, Y') : '—';
@endphp
@if ($referrals->isEmpty())
    <p class="mrf-hint" style="margin:0">No referrals recorded in CareCradle.</p>
@else
    <ul class="mrf-history">
        @foreach ($referrals as $r)
            <li>
                <div class="mrf-history-head">
                    <span>{{ $mrfDate($r->referred_at) }} · {{ $r->receiving_facility }}</span>
                    <span class="mrf-badge {{ $mrfBadge($r->status) }}">{{ $r->status }}</span>
                </div>
                <p><strong>Reason:</strong> {{ $r->reason }}</p>
                @if ($r->notes)<p><strong>Notes:</strong> {{ $r->notes }}</p>@endif
                <p>Referred by {{ $r->referred_by_name ?? 'unknown' }}</p>
                @if ($r->status === 'Closed')
                    <p><strong>Follow-up ({{ $mrfDate($r->outcome_at) }}):</strong> {{ $r->outcome_notes }}</p>
                    @if ($r->outcome_source)<p>Information from: {{ $r->outcome_source }}</p>@endif
                    <p>Closed by {{ $r->closed_by_name ?? 'unknown' }} on {{ $mrfDate($r->closed_at) }}</p>
                @elseif ($r->status === 'Entered in error')
                    <p>Marked as entered in error by {{ $r->voided_by_name ?? 'unknown' }} on {{ $mrfDate($r->voided_at) }}: {{ $r->voided_reason }}</p>
                @endif
            </li>
        @endforeach
    </ul>
@endif
