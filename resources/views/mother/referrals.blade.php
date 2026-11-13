<x-app-layout>
    {{--
        Mother Portal: My Referrals (read-only).
        Shows the signed-in mother's own Current and Closed referrals using
        only the columns the controller loads for mothers: referral date,
        receiving facility, status, and the date the follow-up was recorded.
        No reason, staff names or IDs, internal notes, sources, follow-up
        details, or "Entered in error" corrections are shown, and nothing on
        this page changes data. Styles: resources/css/mother-dashboard-polish.css
        (Mother Portal design, "My Referrals" section).
    --}}

    @php
        $date = fn ($value) => $value ? \Illuminate\Support\Carbon::parse($value)->format('F d, Y') : null;
        $total = $current->count() + $closed->count();
        $plural = fn (int $n, string $word) => $n . ' ' . $word . ($n === 1 ? '' : 's');
        $infoIcon = 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9-3.75h.008v.008H12V8.25Z';
    @endphp

    <div class="mdb apx rfx">

        <div class="mdb-container">

            {{-- ================= PAGE HEADER ================= --}}
            <header class="apx-head">
                <a href="{{ route('mother.dashboard') }}" class="apx-back" aria-label="Back to dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>

                <div class="apx-head-copy">
                    <p class="apx-eyebrow">Maternal care</p>
                    <h1 class="apx-title">My Referrals</h1>
                    <p class="apx-lead">
                        Referrals to other health facilities recorded by the Irosin Rural Health Unit.
                        @unless($total === 0 && $isLegacyReferred)
                            <span class="apx-lead-count">{{ $plural($total, 'referral') }} recorded.</span>
                        @endunless
                    </p>
                </div>
            </header>


            {{-- ================= LEGACY "REFERRED" NOTICE ================= --}}
            @if($isLegacyReferred)
                <section class="rfx-legacy" role="note" aria-labelledby="rfx-legacy-title">
                    <span class="rfx-legacy-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $infoIcon }}"/></svg>
                    </span>
                    <div>
                        <h2 class="rfx-legacy-title" id="rfx-legacy-title">An earlier referral is noted on your record</h2>
                        <p>You were referred before referral details were kept in CareCradle, so the date and facility are not shown here. Please ask the Irosin Rural Health Unit for the details.</p>
                    </div>
                </section>
            @endif


            @if($total === 0)

                {{-- ================= NO REFERRALS ================= --}}
                @unless($isLegacyReferred)
                    <section class="mdb-card" aria-labelledby="rfx-empty-title">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="rfx-empty-title">No referrals</h2>
                        <p class="mdb-empty-text">No referrals are recorded for you in CareCradle. If your health worker refers you to another facility, it will appear here.</p>
                    </section>
                @endunless

            @else

                {{-- ================= CURRENT REFERRAL ================= --}}
                <section class="mdb-card" aria-labelledby="rfx-current-title">
                    <header class="mdb-card-head">
                        <span class="mdb-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                        </span>
                        <h2 class="mdb-card-title" id="rfx-current-title">{{ $current->count() > 1 ? 'Current referrals' : 'Current referral' }}</h2>
                        @if($current->count() > 1)
                            <span class="mdb-card-count">{{ $current->count() }}</span>
                        @endif
                    </header>

                    @if($current->isNotEmpty())
                        <ul class="rfx-list">
                            @foreach($current as $referral)
                                <li class="rfx-current">
                                    <div class="rfx-current-top">
                                        <h3 class="rfx-facility">{{ $referral->receiving_facility }}</h3>
                                        <span class="rfx-status is-current">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>
                                            Current
                                        </span>
                                    </div>
                                    <p class="rfx-meta">Referred on <strong>{{ $date($referral->referred_at) }}</strong></p>
                                </li>
                            @endforeach
                        </ul>

                        <p class="rfx-help">
                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $infoIcon }}"/></svg>
                            <span>Please bring your Mother and Child Book and any documents given by the RHU when you visit the receiving facility.</span>
                        </p>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No current referral</p>
                            <p class="mdb-empty-text">If your health worker refers you to another facility, it will appear here.</p>
                        </div>
                    @endif
                </section>


                {{-- ================= PAST REFERRALS ================= --}}
                <section class="mdb-card" aria-labelledby="rfx-past-title">
                    <header class="mdb-card-head">
                        <h2 class="mdb-card-title" id="rfx-past-title">Past referrals</h2>
                        <span class="mdb-card-count">{{ $closed->count() }}</span>
                    </header>

                    @if($closed->isNotEmpty())
                        <ul class="rfx-list">
                            @foreach($closed as $referral)
                                @php $referred = \Illuminate\Support\Carbon::parse($referral->referred_at); @endphp
                                <li class="rfx-row">
                                    <span class="apx-mini-date" aria-hidden="true">
                                        <span>{{ $referred->format('M') }}</span>
                                        <strong>{{ $referred->format('d') }}</strong>
                                    </span>
                                    <span class="rfx-row-main">
                                        <span class="rfx-facility">{{ $referral->receiving_facility }}</span>
                                        <span class="rfx-meta">Referred on {{ $date($referral->referred_at) }}</span>
                                        <span class="rfx-meta">
                                            @if($referral->outcome_at)
                                                Follow-up recorded on {{ $date($referral->outcome_at) }}
                                            @else
                                                <span class="rfx-muted">Follow-up not recorded</span>
                                            @endif
                                        </span>
                                    </span>
                                    <span class="rfx-status is-closed">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        Closed
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No past referrals</p>
                            <p class="mdb-empty-text">Closed referrals will be listed here.</p>
                        </div>
                    @endif
                </section>

            @endif


            {{-- ================= GUIDANCE (shown once) ================= --}}
            <p class="rfx-footnote">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $infoIcon }}"/></svg>
                <span>For the reason for a referral or any other details, please ask the Irosin Rural Health Unit.</span>
            </p>

        </div>

    </div>
</x-app-layout>
