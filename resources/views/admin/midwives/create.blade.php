<x-app-layout>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
       
    </style>

    <div class="mwf-wrap py-6 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- 1. PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="mwf-banner">

                <div class="mwf-banner-blob-a" aria-hidden="true"></div>
                <div class="mwf-banner-blob-b" aria-hidden="true"></div>
                <div class="mwf-banner-blob-c" aria-hidden="true"></div>

                <div class="mwf-banner-inner">

                    <div class="mwf-banner-main">

                        <div class="mwf-banner-eyebrow">

                            <div class="mwf-banner-eyebrow-icon">
                                <svg
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="rgba(255,255,255,0.9)"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M19 8v6M22 11h-6"/>
                                </svg>
                            </div>

                            <span class="mwf-banner-eyebrow-text">
                                Healthcare Workforce
                            </span>

                        </div>

                        <h1 class="mwf-banner-title">
                            Add Midwife
                        </h1>

                        <p class="mwf-banner-sub">
                            Register a new healthcare worker and grant access to the CareCradle system.
                        </p>

                    </div>

                    <div class="mwf-banner-tag">

                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="rgba(255,255,255,0.85)"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6M22 11h-6"/>
                        </svg>

                        <span>New Healthcare Account</span>

                    </div>

                </div>
            </div>


            {{-- ====================================== --}}
            {{-- 2. VALIDATION ERRORS --}}
            {{-- ====================================== --}}

            @if ($errors->any())

                <div class="mwf-errors">

                    <div class="mwf-errors-head">

                        <div class="mwf-errors-head-inner">

                            <div class="mwf-errors-icon">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <h3 class="mwf-errors-title">
                                    Validation Error
                                </h3>

                                <p class="mwf-errors-sub">
                                    Please review the highlighted fields below and correct the following issues before submitting the form.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="mwf-errors-body">

                        <ul class="mwf-error-list">

                            @foreach ($errors->all() as $error)

                                <li class="mwf-error-item">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mwf-error-item-icon"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                        />
                                    </svg>

                                    <span class="mwf-error-item-text">
                                        {{ $error }}
                                    </span>

                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- ====================================== --}}
            {{-- 3. MIDWIFE FORM --}}
            {{-- ====================================== --}}

            <div class="mwf-form-card">

                <div class="mwf-form-head">

                    <div class="mwf-form-head-inner">

                        <div class="mwf-form-head-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">

                            <h2 class="mwf-form-head-title">
                                Midwife Information
                            </h2>

                            <p class="mwf-form-head-sub">
                                Complete the required information below to register a new midwife.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="mwf-form-body">

                    <form action="{{ route('midwives.store') }}" method="POST">

                        @csrf

                        @include('admin.midwives._form')


                        {{-- ====================================== --}}
                        {{-- 4. ACTION BUTTONS --}}
                        {{-- ====================================== --}}

                        <div class="mwf-actions">

                            <div class="mwf-actions-inner">

                                <a
                                    href="{{ route('midwives.index') }}"
                                    class="mwf-btn mwf-btn-cancel"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 19.5 8.25 12l7.5-7.5"
                                        />
                                    </svg>

                                    Cancel
                                </a>


                                <button
                                    type="submit"
                                    class="mwf-btn mwf-btn-submit"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.5 3.75h2.25A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25H7.5"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 3.75h6M9.75 3h4.5A1.5 1.5 0 0 1 15.75 4.5v.75h-7.5V4.5A1.5 1.5 0 0 1 9.75 3Z"
                                        />
                                    </svg>

                                    Register Midwife
                                </button>

                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>