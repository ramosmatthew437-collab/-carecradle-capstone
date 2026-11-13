<x-app-layout>

    {{-- Shared Administrator styles (admin-only, scoped to .adm-page; no rebuild needed) --}}
    @include('admin.partials.ui-styles')

    <div class="adm-page">
        <div class="adm-container adm-container-narrow">

            {{-- ====================================== --}}
            {{-- 1. PAGE HEADER --}}
            {{-- ====================================== --}}

            <section class="adm-page-header">

                <div class="adm-page-header-main">
                    <div class="adm-page-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6M22 11h-6"/>
                        </svg>
                    </div>

                    <div>
                        <p class="adm-eyebrow">Healthcare Workforce</p>
                        <h1 class="adm-page-title">Add Midwife</h1>
                        <p class="adm-page-desc">Register a new healthcare worker and grant access to the CareCradle system.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6M22 11h-6"/>
                        </svg>
                        <span>New Healthcare Account</span>
                    </span>
                </div>

            </section>


            {{-- ====================================== --}}
            {{-- 2. VALIDATION ERRORS --}}
            {{-- ====================================== --}}

            @if ($errors->any())

                <div class="adm-errors" role="alert">

                    <div class="adm-errors-head">
                        <div class="adm-errors-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="adm-errors-title">
                                Validation Error
                            </h3>

                            <p class="adm-errors-sub">
                                Please review the highlighted fields below and correct the following issues before submitting the form.
                            </p>
                        </div>
                    </div>

                    <ul class="adm-errors-list">
                        @foreach ($errors->all() as $error)
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>

                </div>

            @endif


            {{-- ====================================== --}}
            {{-- 3. MIDWIFE FORM --}}
            {{-- ====================================== --}}

            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12h6M9 16h6M8 3h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="adm-card-title">Midwife Information</h2>
                            <p class="adm-card-sub">Complete the required information below to register a new midwife.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">

                    <form action="{{ route('midwives.store') }}" method="POST">

                        @csrf

                        @include('admin.midwives._form')


                        {{-- ====================================== --}}
                        {{-- 4. ACTION BUTTONS --}}
                        {{-- ====================================== --}}

                        <div class="adm-form-actions">

                            <a href="{{ route('midwives.index') }}" class="adm-btn adm-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                                Cancel
                            </a>

                            <button type="submit" class="adm-btn adm-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                                </svg>
                                Register Midwife
                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>
    </div>

</x-app-layout>
