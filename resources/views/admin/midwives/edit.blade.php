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
                            <path d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                            <path d="M19.5 7.125 16.875 4.5"/>
                        </svg>
                    </div>

                    <div>
                        <p class="adm-eyebrow">Healthcare Workforce</p>
                        <h1 class="adm-page-title">Edit Midwife</h1>
                        <p class="adm-page-desc">Update the midwife's profile and account information.</p>
                    </div>
                </div>

                <div class="adm-page-actions">
                    <span class="adm-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 21a8 8 0 0 1 16 0"/>
                        </svg>
                        <span>Account Management</span>
                    </span>
                </div>

            </section>


            {{-- ====================================== --}}
            {{-- 2. MAIN FORM CARD --}}
            {{-- ====================================== --}}

            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-card-head-main">
                        <div class="adm-card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                <path d="M19.5 7.125 16.875 4.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="adm-card-title">Midwife Information</h2>
                            <p class="adm-card-sub">Review and update the registered midwife's account information.</p>
                        </div>
                    </div>
                </div>

                <div class="adm-card-body">

                    <form action="{{ route('midwives.update', $midwife->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        @include('admin.midwives._form')


                        {{-- ====================================== --}}
                        {{-- 3. ACTION BUTTONS --}}
                        {{-- ====================================== --}}

                        <div class="adm-form-actions">

                            <a href="{{ route('midwives.index') }}" class="adm-btn adm-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                                <span>Cancel</span>
                            </a>

                            <button type="submit" class="adm-btn adm-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                                </svg>
                                <span>Update Midwife</span>
                            </button>

                        </div>

                    </form>

                </div>

            </section>

        </div>
    </div>

</x-app-layout>
