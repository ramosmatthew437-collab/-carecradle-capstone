{{--
    Infant identity banner (used on Infant Edit, Infant Vaccination and
    Growth Monitoring pages). Expects $infant (with mother).
    Optional $infBannerLink (bool, default true): link to the Infant Profile.
    Optional $infPhotoRoute (default 'midwife.infant-photo.show'): photo route
    for the viewing portal (the shared Growth Record page passes the Mother route).
--}}
@php
    $infBirth = $infant->birth_date ? \Carbon\Carbon::parse($infant->birth_date) : null;
    $infAge = null;
    if ($infBirth) {
        $infDiff = $infBirth->diff(now());
        $infAge = $infDiff->y > 0
            ? $infDiff->y . ' ' . \Illuminate\Support\Str::plural('year', $infDiff->y) . ($infDiff->m ? ', ' . $infDiff->m . ' ' . \Illuminate\Support\Str::plural('month', $infDiff->m) : '')
            : ($infDiff->m > 0
                ? $infDiff->m . ' ' . \Illuminate\Support\Str::plural('month', $infDiff->m) . ($infDiff->d ? ', ' . $infDiff->d . ' ' . \Illuminate\Support\Str::plural('day', $infDiff->d) : '')
                : $infDiff->d . ' ' . \Illuminate\Support\Str::plural('day', $infDiff->d));
    }
    $infMother = $infant->mother;
@endphp

<section class="inf-banner" aria-label="Infant">
    <div class="inf-banner-identity">
        <div class="inf-avatar">
            @php
                // Photo only when the stored file exists; otherwise, or if it fails
                // to load, the initials avatar is shown instead of a broken image.
                $infHasPhoto = $infant->photo_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($infant->photo_path);
                $infInitials = strtoupper(substr($infant->first_name ?? '', 0, 1) . substr($infant->last_name ?? '', 0, 1));
            @endphp
            @if ($infHasPhoto)
                <img src="{{ route($infPhotoRoute ?? 'midwife.infant-photo.show', $infant->id) }}"
                     alt="Photo of {{ $infant->first_name }} {{ $infant->last_name }}"
                     onerror="this.style.display = 'none'; this.nextElementSibling.style.display = '';">
                <span aria-hidden="true" style="display: none;">{{ $infInitials }}</span>
            @else
                <span aria-hidden="true">{{ $infInitials }}</span>
            @endif
        </div>
        <div class="inf-banner-copy">
            <p class="inf-banner-label">Infant</p>
            <p class="inf-banner-name">
                @if ($infBannerLink ?? true)
                    <a href="{{ route('infants.show', $infant) }}" style="color: inherit; text-decoration: none;">{{ trim($infant->first_name . ' ' . $infant->middle_name . ' ' . $infant->last_name) }}</a>
                @else
                    {{ trim($infant->first_name . ' ' . $infant->middle_name . ' ' . $infant->last_name) }}
                @endif
            </p>
            <div class="inf-banner-ids">
                <span class="inf-badge inf-badge-pink">{{ $infant->sex }}</span>
                @if ($infMother)
                    <span>Mother: {{ $infMother->first_name }} {{ $infMother->last_name }}</span>
                    <span class="inf-code"><span class="inf-sr">Mother code: </span>{{ $infMother->mother_code }}</span>
                @endif
            </div>
        </div>
    </div>

    <dl class="inf-banner-facts">
        <div class="inf-fact">
            <dt class="inf-fact-label">Date of Birth</dt>
            <dd class="inf-fact-value">{{ $infBirth ? $infBirth->format('M d, Y') : '—' }}</dd>
        </div>
        <div class="inf-fact">
            <dt class="inf-fact-label">Age</dt>
            <dd class="inf-fact-value">{{ $infAge ?? '—' }}</dd>
        </div>
        <div class="inf-fact">
            <dt class="inf-fact-label">Birth Status</dt>
            <dd>
                <span class="inf-badge {{ $infant->birth_status === 'Stillbirth' ? 'inf-badge-gray' : 'inf-badge-green' }}">{{ $infant->birth_status }}</span>
            </dd>
        </div>
    </dl>
</section>
