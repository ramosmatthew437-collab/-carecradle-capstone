<x-app-layout>
    @include('infants._styles')

    @php
        $infant = $vaccination->infant;
    @endphp

    <div class="inf">
        <div class="inf-container inf-container-narrow">

            <a href="{{ route('vaccinations.show', $vaccination) }}" class="inf-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Vaccination Record
            </a>

            <header class="inf-head">
                <div>
                    <p class="inf-kicker">Infant Vaccination</p>
                    <h1 class="inf-title">Edit Vaccination Record</h1>
                    <p class="inf-subtitle">{{ $vaccination->vaccine_name }} · {{ $vaccination->dose }}</p>
                </div>
            </header>

            @include('infants._infant-banner', ['infant' => $infant])

            <form action="{{ route('vaccinations.update', $vaccination) }}" method="POST">
                @csrf
                @method('PUT')

                @include('infants._form-errors', ['infErrorTitle' => 'The changes were not saved'])

                @include('vaccinations._fields', ['infant' => $infant, 'vaccination' => $vaccination])

                <div class="inf-actions">
                    <p class="inf-actions-note">Fields marked <span class="inf-req">*</span> are required.</p>
                    <div class="inf-actions-buttons">
                        <a href="{{ route('vaccinations.show', $vaccination) }}" class="inf-btn inf-btn-quiet">Cancel</a>
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
