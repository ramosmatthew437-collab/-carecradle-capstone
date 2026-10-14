<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Mother
        </h2>
    </x-slot>

    <div class="me-wrap">
        <div class="me-container">

            {{-- =====================================================
                 PAGE HEADER
            ====================================================== --}}

            <div class="me-page-head">

                <div class="me-page-main">

                    <div class="me-page-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19.5 7.125 16.875 4.5"/>
                        </svg>
                    </div>

                    <div class="me-page-copy">

                        <p class="me-eyebrow">
                            Maternal Records
                        </p>

                        <h1 class="me-title">
                            Edit Mother Record
                        </h1>

                        <p class="me-description">
                            Update the mother's personal, pregnancy, and maternal
                            health information while keeping the existing record
                            securely maintained.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 MOTHER CODE
            ====================================================== --}}

            <div class="me-identity">

                <div class="me-identity-main">

                    <div class="me-identity-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                        </svg>
                    </div>

                    <div class="me-identity-copy">

                        <span class="me-identity-label">
                            Mother Code
                        </span>

                        <span class="me-identity-code">
                            {{ $mother->mother_code }}
                        </span>

                    </div>

                </div>


                <span class="me-locked">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>

                    Locked

                </span>

            </div>


            {{-- =====================================================
                 VALIDATION ERRORS
            ====================================================== --}}

            @if ($errors->any())

                <div class="me-error">

                    <div class="me-error-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>

                    </div>

                    <div class="me-error-content">

                        <h3 class="me-error-title">
                            {{ $errors->count() }}
                            {{ Str::plural('issue', $errors->count()) }}
                            need{{ $errors->count() === 1 ? 's' : '' }} your attention
                        </h3>

                        <ul class="me-error-list">

                            @foreach ($errors->all() as $error)

                                <li>
                                    <span></span>
                                    <p>{{ $error }}</p>
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 FORM
            ====================================================== --}}

            <form action="{{ route('mothers.update', $mother->id) }}"
                  method="POST"
                  class="me-form">

                @csrf
                @method('PUT')


                {{-- Existing form fields --}}
                @include('admin.mothers._form')


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="me-actions-wrap">

                    <div class="me-actions">

                        <button
                            type="submit"
                            class="me-update-btn">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>

                            Update Mother

                        </button>


                        <a
                            href="{{ route('mothers.index') }}"
                            class="me-cancel-btn">

                            Cancel

                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>