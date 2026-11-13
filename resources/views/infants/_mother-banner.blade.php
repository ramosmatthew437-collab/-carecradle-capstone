{{--
    Mother identity banner for Infant Registration. Expects $mother.
    Optional $eligible (bool): shows the prenatal history fact used by the
    registration rule.
--}}
@php
    $infMotherStatus = match ($mother->status) {
        'Pregnant' => 'inf-badge-green',
        'Delivered' => 'inf-badge-gray',
        'Referred' => 'inf-badge-amber',
        default => 'inf-badge-pink',
    };
@endphp

<section class="inf-banner" aria-label="Mother">
    <div class="inf-banner-identity">
        <div class="inf-avatar">
            @if ($mother->profile_photo_path)
                <img src="{{ asset('storage/' . $mother->profile_photo_path) }}"
                     alt="Profile photo of {{ $mother->first_name }} {{ $mother->last_name }}">
            @else
                <span aria-hidden="true">{{ strtoupper(substr($mother->first_name ?? '', 0, 1) . substr($mother->last_name ?? '', 0, 1)) }}</span>
            @endif
        </div>
        <div class="inf-banner-copy">
            <p class="inf-banner-label">Mother</p>
            <p class="inf-banner-name">{{ trim($mother->first_name . ' ' . $mother->middle_name . ' ' . $mother->last_name) }}</p>
            <div class="inf-banner-ids">
                <span class="inf-code"><span class="inf-sr">Mother code: </span>{{ $mother->mother_code }}</span>
                @if ($mother->barangay)
                    <span>Barangay {{ $mother->barangay }}</span>
                @endif
            </div>
        </div>
    </div>

    <dl class="inf-banner-facts">
        <div class="inf-fact">
            <dt class="inf-fact-label">Status</dt>
            <dd><span class="inf-badge {{ $infMotherStatus }}">{{ $mother->status }}</span></dd>
        </div>
        @isset($eligible)
            <div class="inf-fact">
                <dt class="inf-fact-label">Prenatal History</dt>
                <dd>
                    @if ($eligible)
                        <span class="inf-badge inf-badge-green">On record</span>
                    @else
                        <span class="inf-badge inf-badge-amber">Not recorded</span>
                    @endif
                </dd>
            </div>
        @endisset
        <div class="inf-fact">
            <dt class="inf-fact-label">Infants</dt>
            <dd class="inf-fact-value">{{ $mother->infants()->count() }}</dd>
        </div>
    </dl>
</section>
