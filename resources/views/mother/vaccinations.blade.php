<x-app-layout>
    {{--
        Mother Portal: My Vaccinations (overview).
        Data from MotherVaccinationController: the signed-in mother's own
        maternal records and her children's complete vaccination histories.
        Statuses come from the model rules (isSupersededWithin / dueStatus)
        and the 7-day dashboard window. Dates are shown exactly as recorded;
        no schedule guidance is added. Staff-only fields (administered by,
        remarks) are not loaded. Styles: resources/css/mother-dashboard-polish.css
        ("My Vaccinations" section).
    --}}

    @php
        $date = fn ($value) => \Carbon\Carbon::parse($value)->format('F d, Y');
        $plural = fn (int $n, string $word) => $n . ' ' . $word . ($n === 1 ? '' : 's');
        $fullName = fn ($child) => trim(implode(' ', array_filter([$child->first_name, $child->middle_name, $child->last_name])));
        $initialOf = fn ($child) => strtoupper(mb_substr((string) $child->first_name, 0, 1));
        $hasChildren = $infants->isNotEmpty();
    @endphp

    <div class="mdb apx vxx">
        <div class="mdb-container">

            {{-- ================= PAGE HEADER ================= --}}
            <header class="apx-head">
                <a href="{{ route('mother.dashboard') }}" class="apx-back" aria-label="Back to dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="apx-head-copy">
                    <p class="apx-eyebrow">Immunizations</p>
                    <h1 class="apx-title">My Vaccinations</h1>
                    <p class="apx-lead">Vaccinations recorded for you and your children at the Irosin Rural Health Unit, with the dates exactly as recorded.</p>
                </div>
            </header>


            {{-- ================= SUMMARY (complete records; maternal and infant kept separate) ================= --}}
            <section class="vxx-summary" aria-label="Vaccination summary">

                <article class="mdb-card vxx-summary-card">
                    <p class="apx-eyebrow">Your vaccinations</p>
                    <p class="vxx-summary-main">
                        @if($seriesNextDose === null)
                            Td/TT series complete
                        @elseif($seriesRecorded === 0)
                            No Td/TT doses yet
                        @else
                            Dose {{ $seriesRecorded }} of {{ $seriesTotal }} recorded
                        @endif
                    </p>
                    <p class="vxx-summary-sub">{{ $plural($maternalSummary['doses'], 'maternal record') }}</p>
                    <dl class="vxx-counts">
                        <div class="{{ $maternalSummary['overdue'] ? 'is-overdue' : '' }}"><dt>Overdue</dt><dd>{{ $maternalSummary['overdue'] }}</dd></div>
                        <div class="{{ $maternalSummary['soon'] ? 'is-soon' : '' }}"><dt>Due within 7 days</dt><dd>{{ $maternalSummary['soon'] }}</dd></div>
                        <div><dt>Upcoming</dt><dd>{{ $maternalSummary['upcoming'] }}</dd></div>
                    </dl>
                </article>

                <article class="mdb-card vxx-summary-card">
                    <p class="apx-eyebrow">Your {{ $infantSummary['children'] === 1 ? "child's" : "children's" }} vaccinations</p>
                    <p class="vxx-summary-main">{{ $plural($infantSummary['doses'], 'dose') }} recorded</p>
                    <p class="vxx-summary-sub">
                        {{ $hasChildren ? $infantSummary['children'] . ' ' . ($infantSummary['children'] === 1 ? 'child' : 'children') : 'No children registered yet' }}
                    </p>
                    <dl class="vxx-counts">
                        <div class="{{ $infantSummary['overdue'] ? 'is-overdue' : '' }}"><dt>Overdue</dt><dd>{{ $infantSummary['overdue'] }}</dd></div>
                        <div class="{{ $infantSummary['soon'] ? 'is-soon' : '' }}"><dt>Due within 7 days</dt><dd>{{ $infantSummary['soon'] }}</dd></div>
                        <div><dt>Upcoming</dt><dd>{{ $infantSummary['upcoming'] }}</dd></div>
                    </dl>
                </article>

            </section>


            {{-- ================= MATERNAL Td/TT ================= --}}
            <section class="mdb-card" id="maternal-vaccinations" aria-labelledby="vxx-maternal-title">
                <header class="mdb-card-head">
                    <span class="mdb-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7.5-4.6-9.4-9.2C1.2 8.4 3.2 4.5 6.9 4.5c2 0 3.4 1.1 5.1 3 1.7-1.9 3.1-3 5.1-3 3.7 0 5.7 3.9 4.3 7.3C19.5 16.4 12 21 12 21Z"/></svg>
                    </span>
                    <h2 class="mdb-card-title" id="vxx-maternal-title">Your vaccinations (Td/TT)</h2>
                    <span class="mdb-card-count">{{ $maternalVaccinations->count() }}</span>
                </header>

                {{-- Series progress: existing nextEligibleDose() rule; no dates implied. --}}
                <div class="vxx-series">
                    <div class="vxx-series-top">
                        <p class="vxx-series-title">
                            @if($seriesNextDose === null)
                                Series complete · Dose {{ $seriesTotal }} of {{ $seriesTotal }} recorded
                            @elseif($seriesRecorded === 0)
                                No Td/TT doses recorded yet
                            @else
                                Dose {{ $seriesRecorded }} of {{ $seriesTotal }} recorded
                            @endif
                        </p>
                        @if($seriesNextDose !== null)
                            <p class="vxx-series-next">Next in the series: {{ $seriesNextDose }}</p>
                        @endif
                    </div>
                    <ol class="vxx-meter" role="img" aria-label="{{ $seriesRecorded }} of {{ $seriesTotal }} doses of the Td/TT series recorded">
                        @for($i = 1; $i <= $seriesTotal; $i++)
                            <li class="{{ $i <= $seriesRecorded ? 'is-done' : '' }}"><span>{{ $i }}</span></li>
                        @endfor
                    </ol>
                    <p class="vxx-series-note">Td and TT doses count toward one series that continues across pregnancies.</p>
                </div>

                @if($maternalVaccinations->isNotEmpty())
                    <ul class="vxx-list">
                        @foreach($maternalVaccinations as $dose)
                            @php $next = $maternalStatus[$dose->id]; @endphp
                            <li class="vxx-dose">
                                <div class="vxx-dose-top">
                                    <p class="vxx-dose-name">{{ $dose->vaccine_name }} <span>· {{ $dose->dose }}</span></p>
                                    <span class="vxx-given">
                                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        Given
                                    </span>
                                </div>
                                <p class="vxx-dose-meta">Given on {{ $date($dose->date_given) }}</p>
                                <p class="vxx-next is-{{ $next['key'] }}">
                                    @if($next['due'])
                                        Next dose date {{ $next['due']->format('F d, Y') }} ·
                                    @endif
                                    <strong>{{ $next['label'] }}</strong>
                                </p>
                                @unless($dose->isSeriesRecord())
                                    <p class="vxx-dose-flag">Recorded as entered · not counted in the Td/TT series</p>
                                @endunless
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="mdb-empty">
                        <p class="mdb-empty-title">No maternal vaccinations recorded yet</p>
                        <p class="mdb-empty-text">Td or TT doses given to you at the RHU will appear here.</p>
                    </div>
                @endif
            </section>


            {{-- ================= INFANT VACCINATIONS, GROUPED BY CHILD ================= --}}
            @forelse($infants as $infant)
                <section class="mdb-card vxx-child" id="child-{{ $infant->id }}" aria-labelledby="vxx-child-{{ $infant->id }}">
                    <header class="vxx-child-head">
                        <span class="vxx-child-initial" aria-hidden="true">{{ $initialOf($infant) }}</span>
                        <div class="vxx-child-copy">
                            <p class="apx-eyebrow">Child's vaccinations</p>
                            <h2 class="vxx-child-name" id="vxx-child-{{ $infant->id }}">{{ $fullName($infant) }}</h2>
                            @if($infant->birth_date)
                                <p class="vxx-child-born">Born {{ $date($infant->birth_date) }}</p>
                            @endif
                        </div>
                        <span class="mdb-card-count" aria-label="{{ $plural($infant->vaccinations->count(), 'dose') }}">{{ $infant->vaccinations->count() }}</span>
                    </header>

                    @if($infant->vaccinations->isNotEmpty())
                        <ul class="vxx-list">
                            @foreach($infant->vaccinations as $dose)
                                @php $next = $infantStatus[$dose->id]; @endphp
                                <li class="vxx-dose">
                                    <div class="vxx-dose-top">
                                        <p class="vxx-dose-name">{{ $dose->vaccine_name }} <span>· {{ $dose->dose }}</span></p>
                                        <span class="vxx-given">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                            Given
                                        </span>
                                    </div>
                                    <p class="vxx-dose-meta">Given on {{ $date($dose->date_given) }}</p>
                                    <p class="vxx-next is-{{ $next['key'] }}">
                                        @if($next['due'])
                                            Next dose date {{ $next['due']->format('F d, Y') }} ·
                                        @endif
                                        <strong>{{ $next['label'] }}</strong>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mdb-empty">
                            <p class="mdb-empty-title">No vaccinations recorded for {{ $infant->first_name }} yet</p>
                            <p class="mdb-empty-text">Doses given to {{ $infant->first_name }} at the RHU will appear here.</p>
                        </div>
                    @endif

                    <a href="{{ route('mother.infant-records', ['infant' => $infant->id]) }}" class="mdb-btn mdb-btn-outline vxx-child-link">
                        View {{ $infant->first_name }}'s Infant Records
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </section>
            @empty
                <section class="mdb-card" aria-labelledby="vxx-nochild-title">
                    <h2 class="mdb-card-title" id="vxx-nochild-title">Your children's vaccinations</h2>
                    <div class="mdb-empty">
                        <p class="mdb-empty-title">No children registered yet</p>
                        <p class="mdb-empty-text">Once your midwife registers your baby, their vaccinations will appear here.</p>
                    </div>
                </section>
            @endforelse

            <p class="rfx-footnote">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.75Z"/></svg>
                <span>Dates are shown as recorded by the Irosin Rural Health Unit. For questions about a dose, please ask your midwife.</span>
            </p>

        </div>
    </div>
</x-app-layout>
