<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Mother Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- SECTION 1 : HERO HEADER --}}
            {{-- ====================================== --}}

            <!-- Your Hero Header goes here -->

            {{-- ====================================== --}}
            {{-- SECTION 2 : REGISTRATION FORM --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">

                    <h2 class="text-xl font-semibold text-gray-900">
                        Maternal Registration Form
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Complete all required fields to create the patient's electronic maternal record.
                    </p>

                </div>

                <form action="{{ route('mothers.store') }}" method="POST">

                    @csrf

                    <div class="p-8">

                        @include('admin.mothers._form')

                    </div>

                    {{-- ====================================== --}}
                    {{-- SECTION 3 : ACTION BUTTONS --}}
                    {{-- ====================================== --}}

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 px-8 py-6 sm:flex-row sm:justify-end">

                        <a href="{{ route('mothers.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow-md">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 19.5 8.25 12l7.5-7.5"/>

                            </svg>

                            Cancel

                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-pink-100">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 4.5v15m7.5-7.5h-15"/>

                            </svg>

                            Register Mother

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>