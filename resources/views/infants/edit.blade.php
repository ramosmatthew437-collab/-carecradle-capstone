<x-app-layout>
    @include('infants._styles')

    <div class="inf">
        <div class="inf-container inf-container-narrow">

            <a href="{{ route('infants.show', $infant) }}" class="inf-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Infant Profile
            </a>

            <header class="inf-head">
                <div>
                    <p class="inf-kicker">Infant Records</p>
                    <h1 class="inf-title">Edit Infant Record</h1>
                    <p class="inf-subtitle">Update the infant's details and birth measurements.</p>
                </div>
            </header>

            @include('infants._infant-banner', ['infant' => $infant])

            <form action="{{ route('infants.update', $infant) }}" method="POST">
                @csrf
                @method('PUT')

                @include('infants._form-errors', ['infErrorTitle' => 'The changes were not saved'])

                {{-- Registration exception (Section 1): read-only, kept as stored on save --}}
                @if ($infant->registrationException())
                    <div style="margin-top: 1rem;">
                        @include('infants._registration-exception-summary', ['infant' => $infant])
                    </div>
                @endif

                @include('infants._infant-fields', ['infant' => $infant])

                <p class="inf-hint" style="margin-top: 0.75rem;">
                    The linked mother ({{ $infant->mother?->mother_code ?? 'unavailable' }}) is set at registration and cannot be changed here.
                </p>

                <div class="inf-actions">
                    <p class="inf-actions-note">Fields marked <span class="inf-req">*</span> are required.</p>
                    <div class="inf-actions-buttons">
                        <a href="{{ route('infants.show', $infant) }}" class="inf-btn inf-btn-quiet">Cancel</a>
                        <button type="submit" class="inf-btn inf-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
