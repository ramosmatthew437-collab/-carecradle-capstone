<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Add Midwife
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- SECTION 1 : HEADER --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:px-7 sm:py-6 shadow-sm">

                <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Healthcare Workforce</p>
                    <h1 class="mt-0.5 text-lg sm:text-2xl font-bold text-gray-900">Add Midwife</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Register a new healthcare worker and grant access to the CareCradle system.
                    </p>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 2 : VALIDATION ERROR CARD --}}
            {{-- ====================================== --}}

            @if ($errors->any())

                <div class="overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

                    <div class="border-b border-red-100 bg-red-50 px-5 py-4 sm:px-6 sm:py-5">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-semibold text-red-700">Validation Error</h3>
                                <p class="mt-0.5 text-sm text-gray-600">
                                    Please review the highlighted fields below and correct the following issues before submitting the form.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 py-4 sm:px-6 sm:py-5">
                        <ul class="space-y-2.5">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            @endif

            {{-- ====================================== --}}
            {{-- SECTION 3 : MAIN CARD --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-7 sm:py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Midwife Information</h2>
                            <p class="mt-0.5 text-sm text-gray-500">
                                Complete the required information below to register a new midwife.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">

                    <form action="{{ route('midwives.store') }}" method="POST">

                        @csrf

                        @include('admin.midwives._form')

                        {{-- ====================================== --}}
                        {{-- SECTION 4 : ACTION BUTTONS --}}
                        {{-- ====================================== --}}

                        <div class="mt-8 sm:mt-10 border-t border-gray-100 pt-6">
                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                <a href="{{ route('midwives.index') }}"
                                   class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                    Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75h2.25A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25H7.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75h6M9.75 3h4.5A1.5 1.5 0 0 1 15.75 4.5v.75h-7.5V4.5A1.5 1.5 0 0 1 9.75 3Z" />
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