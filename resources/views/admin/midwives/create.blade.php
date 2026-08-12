<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Midwife
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">


{{-- ====================================== --}}
{{-- SECTION 1 : HERO HEADER --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-6 p-8 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-start gap-5">

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                </svg>

            </div>

            <div>

                <p class="text-sm font-semibold uppercase tracking-widest text-pink-600">
                    Healthcare Workforce
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                    Register New Midwife
                </h1>

                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-500">
                    Create a new midwife account for the CareCradle Maternal & Infant Health
                    Monitoring System. Registered midwives will be able to securely access
                    maternal and infant healthcare records, manage patient information,
                    and support Rural Health Unit services.
                </p>

            </div>

        </div>

        <div class="rounded-2xl border border-pink-100 bg-pink-50 px-6 py-5">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15" />

                    </svg>

                </div>

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wide text-pink-600">
                        CareCradle EMR
                    </p>

                    <p class="text-sm font-semibold text-gray-900">
                        Midwife Registration
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ====================================== --}}
{{-- SECTION 2 : VALIDATION ERROR CARD --}}
{{-- ====================================== --}}

@if ($errors->any())

<div class="mb-8 overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

    <div class="border-b border-red-100 bg-red-50 px-6 py-5">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-red-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                </svg>

            </div>

            <div>

                <h3 class="text-lg font-semibold text-red-700">
                    Validation Error
                </h3>

                <p class="mt-1 text-sm text-gray-600">
                    Please review the highlighted fields below and correct the following issues before submitting the form.
                </p>

            </div>

        </div>

    </div>

    <div class="px-6 py-5">

        <ul class="space-y-3">

            @foreach ($errors->all() as $error)

                <li class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />

                    </svg>

                    <span class="text-sm text-gray-700">
                        {{ $error }}
                    </span>

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

    {{-- Card Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">

        <div class="flex items-start gap-4">

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                </svg>

            </div>

            <div>

                <h2 class="text-2xl font-bold text-gray-900">
                    Midwife Information
                </h2>

                <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-500">
                    Complete the required information below to register a new midwife.
                    The account created will allow authorized healthcare personnel to
                    securely access the CareCradle Maternal & Infant Health Monitoring
                    System and manage patient records within the Rural Health Unit.
                </p>

            </div>

        </div>

    </div>

    {{-- Form Content --}}
    <div class="p-8">

        <form action="{{ route('midwives.store') }}" method="POST">

            @csrf

            @include('admin.midwives._form')

            {{-- ====================================== --}}
{{-- SECTION 4 : ACTION BUTTONS --}}
{{-- ====================================== --}}

            <div class="mt-10 border-t border-gray-200 pt-6">

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('midwives.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow-md">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 19.5 8.25 12l7.5-7.5" />

                        </svg>

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16.5 3.75h2.25A2.25 2.25 0 0 1 21 6v12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V6a2.25 2.25 0 0 1 2.25-2.25H7.5" />

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 3.75h6M9.75 3h4.5A1.5 1.5 0 0 1 15.75 4.5v.75h-7.5V4.5A1.5 1.5 0 0 1 9.75 3Z" />

                        </svg>

                        Save Midwife

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
               
</x-app-layout>