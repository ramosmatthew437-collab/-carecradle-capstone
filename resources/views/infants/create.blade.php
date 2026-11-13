<x-app-layout>
    @include('infants._styles')

    <div class="inf">
        <div class="inf-container inf-container-narrow">

            <a href="{{ route('mothers.show', $mother) }}" class="inf-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Mother Profile
            </a>

            <header class="inf-head">
                <div>
                    <p class="inf-kicker">Infant Records</p>
                    <h1 class="inf-title">Register Infant</h1>
                    <p class="inf-subtitle">The infant will be linked to this mother's maternal record.</p>
                </div>
            </header>

            @include('infants._mother-banner', ['mother' => $mother, 'eligible' => $eligible])

            <form action="{{ route('infants.store', $mother) }}" method="POST">
                @csrf

                {{-- In notice mode the eligibility card below explains the error. --}}
                @if ($eligible || $exceptionMode)
                    @include('infants._form-errors', ['infErrorTitle' => 'The infant was not registered'])
                @endif

                {{-- Panel requirement: no qualifying prenatal checkup (Section 1) --}}
                @unless ($eligible)
                    <div style="margin-top: 1rem;">
                        @include('infants._registration-eligibility', ['mother' => $mother, 'exceptionMode' => $exceptionMode])
                    </div>
                @endunless

                {{-- Registration fields: shown when the mother is eligible, or for an authorized exception. --}}
                @if ($eligible || $exceptionMode)
                    @include('infants._infant-fields', ['infant' => null])

                    <div class="inf-actions">
                        <p class="inf-actions-note">Fields marked <span class="inf-req">*</span> are required.</p>
                        <div class="inf-actions-buttons">
                            <a href="{{ route('mothers.show', $mother) }}" class="inf-btn inf-btn-quiet">Cancel</a>
                            <button type="submit" class="inf-btn inf-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ $eligible ? 'Register Infant' : 'Register with Exception' }}
                            </button>
                        </div>
                    </div>
                @endif
            </form>

        </div>
    </div>
</x-app-layout>
