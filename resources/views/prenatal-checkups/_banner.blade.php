{{-- Mother banner for the Prenatal Visit pages. Expects $mother. --}}
@php
    $pvStatusClass = match($mother->status) {
        'Pregnant' => 'pv-status-pregnant',
        'Delivered' => 'pv-status-delivered',
        'Referred' => 'pv-status-referred',
        default => 'pv-status-default',
    };
@endphp

<section class="pv-banner" aria-label="Mother">
    <div class="pv-banner-identity">
        <div class="pv-avatar">
            @if ($mother->profile_photo_path)
                <img src="{{ asset('storage/' . $mother->profile_photo_path) }}"
                     alt="Profile photo of {{ $mother->first_name }} {{ $mother->last_name }}">
            @else
                <span aria-hidden="true">{{ strtoupper(substr($mother->first_name ?? '', 0, 1) . substr($mother->last_name ?? '', 0, 1)) }}</span>
            @endif
        </div>

        <div class="pv-banner-copy">
            <p class="pv-banner-label">Mother</p>
            <p class="pv-banner-name">{{ $mother->first_name }} {{ $mother->last_name }}</p>
            <div class="pv-banner-ids">
                <span class="pv-code"><span class="pv-sr">Mother code: </span>{{ $mother->mother_code }}</span>
                @if ($mother->barangay)
                    <span>Barangay {{ $mother->barangay }}</span>
                @endif
            </div>
        </div>
    </div>

    <dl class="pv-banner-facts">
        <div class="pv-fact">
            <dt class="pv-fact-label">Status</dt>
            <dd><span class="pv-status {{ $pvStatusClass }}">{{ $mother->status }}</span></dd>
        </div>
        <div class="pv-fact">
            <dt class="pv-fact-label">Expected Delivery</dt>
            <dd class="pv-fact-value">
                {{ $mother->expected_delivery_date ? \Carbon\Carbon::parse($mother->expected_delivery_date)->format('M d, Y') : '—' }}
            </dd>
        </div>
    </dl>
</section>
