{{--
    Read-only summary of an authorized registration exception, parsed from
    the structured block at the start of the infant's remarks
    (Infant::registrationException). Shown separately from clinical remarks.
    Expects $infant. Renders nothing when there is no exception.
--}}
@php
    $irsException = $infant->registrationException();
@endphp

@if ($irsException)
    @once
        <style>
            .irs {
                padding: 1.125rem 1.25rem;
                border: 1px solid #f8d3e2;
                border-radius: 1rem;
                background: #fdf2f7;
                color: #334155;
                font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            }

            .irs-kicker {
                margin: 0;
                color: #be185d;
                font-size: 0.6875rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .irs-title {
                margin: 0.25rem 0 0;
                color: #0f172a;
                font-size: 0.9375rem;
                font-weight: 600;
            }

            .irs-grid {
                display: grid;
                gap: 0.75rem 1.5rem;
                margin: 0.875rem 0 0;
            }

            @media (min-width: 640px) {
                .irs-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            .irs-grid dt {
                color: #64748b;
                font-size: 0.6875rem;
                font-weight: 600;
                letter-spacing: 0.06em;
                text-transform: uppercase;
            }

            .irs-grid dd {
                margin: 0.125rem 0 0;
                color: #1e293b;
                font-size: 0.875rem;
                line-height: 1.55;
                overflow-wrap: anywhere;
                white-space: pre-line;
            }

            .irs-wide {
                grid-column: 1 / -1;
            }
        </style>
    @endonce

    <section class="irs" aria-label="Registration exception">
        <p class="irs-kicker">Registration exception</p>
        <p class="irs-title">Registered without a prenatal checkup recorded in CareCradle</p>
        <dl class="irs-grid">
            <div>
                <dt>Reason</dt>
                <dd>{{ $irsException['reason'] ?: '—' }}</dd>
            </div>
            @if ($irsException['facility'])
                <div>
                    <dt>Healthcare facility</dt>
                    <dd>{{ $irsException['facility'] }}</dd>
                </div>
            @endif
            <div>
                <dt>Authorized by</dt>
                <dd>{{ $irsException['authorized_by'] ?: '—' }}</dd>
            </div>
            <div>
                <dt>Recorded</dt>
                <dd>{{ $irsException['recorded'] ? \Illuminate\Support\Carbon::parse($irsException['recorded'])->format('M d, Y g:i A') : '—' }}</dd>
            </div>
            <div class="irs-wide">
                <dt>Supporting notes</dt>
                <dd>{{ $irsException['notes'] ?: '—' }}</dd>
            </div>
        </dl>
    </section>
@endif
