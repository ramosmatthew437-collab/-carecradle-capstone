{{--
    Referral card on the Midwife Mother Profile. Expects $mother.
--}}
@include('mothers.referrals._styles')
@php
    $mrfActive = $mother->referrals->firstWhere('status', 'Active');
    $mrfPast = $mother->referrals->reject(fn ($r) => $r->status === 'Active')->values();
@endphp
<section class="mshow-card mrf" id="referral" aria-labelledby="mrf-card-title">
    <div class="mshow-card-header">
        <div>
            <p class="mshow-section-kicker mshow-kicker-amber"><span class="mshow-section-kicker-dot"></span>Referral</p>
            <h2 class="mshow-card-title" id="mrf-card-title">Referral</h2>
            <p class="mshow-section-sub">Referral is recorded separately from pregnancy status. It does not change her account, records, appointments or reminders.</p>
        </div>
        @if (! $mrfActive)
            <div class="mshow-card-actions">
                <a href="{{ route('referrals.create', $mother->id) }}" class="mrf-btn mrf-btn-secondary">Record referral</a>
            </div>
        @endif
    </div>

    <div style="padding: 0 1.25rem 1.25rem">
        @if (session('referral_success'))
            <div class="mrf-alert mrf-alert-success" role="status"><div><strong>Done</strong>{{ session('referral_success') }}</div></div>
        @endif
        @if (session('referral_error'))
            <div class="mrf-alert mrf-alert-error" role="alert"><div><strong>Not saved</strong>{{ session('referral_error') }}</div></div>
        @endif

        @if ($mother->isLegacyReferred())
            <div class="mrf-alert mrf-alert-info" role="note">
                <div>
                    <strong>Referred before referral details were tracked</strong>
                    This record was marked Referred in the old status field. Its referral date, facility and reason were not recorded, and her pregnancy status is unknown.
                    Once the RHU confirms it, set Pregnant or Delivered on Edit Mother. If the referral details are known, record them here.
                </div>
            </div>
        @endif

        @if ($mrfActive)
            <p style="margin:0 0 0.75rem"><span class="mrf-badge mrf-b-active">Active referral</span></p>
            <dl class="mrf-dl">
                <dt>Referral date</dt><dd>{{ $mrfActive->referred_at->format('M d, Y') }}</dd>
                <dt>Receiving facility</dt><dd>{{ $mrfActive->receiving_facility }}</dd>
                <dt>Reason</dt><dd>{{ $mrfActive->reason }}</dd>
                @if ($mrfActive->notes)<dt>Notes</dt><dd>{{ $mrfActive->notes }}</dd>@endif
                <dt>Referred by</dt><dd>{{ $mrfActive->referred_by_name ?? 'unknown' }}</dd>
            </dl>
            <div class="mrf-actions">
                <a href="{{ route('referrals.edit', $mrfActive->id) }}" class="mrf-btn mrf-btn-primary">Update or record follow-up</a>
            </div>
        @elseif (! $mother->isLegacyReferred())
            <p class="mrf-hint" style="margin:0">Not currently referred.</p>
        @endif

        @if ($mrfPast->isNotEmpty())
            <h3 class="mrf-card-title" style="margin:1.25rem 0 0.25rem;font-size:1rem">Referral history</h3>
            @include('mothers.referrals._history', ['referrals' => $mrfPast])
        @endif
    </div>
</section>
