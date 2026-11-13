<x-app-layout>
    @include('prenatal-checkups._styles')

    <div class="pv">
        <div class="pv-container">

            <a href="{{ route('mothers.show', $mother->id) }}" class="pv-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Mother Profile
            </a>

            <header class="pv-head">
                <div>
                    <p class="pv-kicker">Maternal Records</p>
                    <h1 class="pv-title">Add Prenatal Visit</h1>
                    <p class="pv-subtitle">Record vital signs, fetal assessment, and laboratory findings for this visit.</p>
                </div>
            </header>

            @include('prenatal-checkups._banner', ['mother' => $mother])

            <form action="{{ route('prenatal-checkups.store', $mother->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                @include('prenatal-checkups._visit-fields', ['visit' => null])

                <div class="pv-actions">
                    <p class="pv-actions-note">Fields marked <span class="pv-req">*</span> are required. Laboratory documents are optional.</p>
                    <div class="pv-actions-buttons">
                        <a href="{{ route('mothers.show', $mother->id) }}" class="pv-btn pv-btn-quiet">Cancel</a>
                        <button type="submit" class="pv-btn pv-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                            Save Prenatal Visit
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
