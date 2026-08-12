<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Midwife
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

            {{-- ====================================== --}}
{{-- Hero Header --}}
{{-- ====================================== --}}
<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 to-pink-700 shadow-sm">

    <div class="px-8 py-8">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-start gap-5">

                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-8 w-8 text-white">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5" />
                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Edit Midwife
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Update Midwife Information
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Modify the assigned midwife's account details and profile
                        information. Ensure that all records are accurate before
                        saving the changes to the CareCradle Electronic Medical
                        Record system.
                    </p>

                </div>

            </div>

            <div class="flex-shrink-0">

                <div class="rounded-2xl border border-white/20 bg-white/10 px-6 py-5 backdrop-blur-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5 text-white">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0118.75 12v6A1.5 1.5 0 0117.25 19.5H6.75A1.5 1.5 0 015.25 18v-6a1.5 1.5 0 011.5-1.5Z"/>
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-medium uppercase tracking-wider text-pink-100">
                                Module
                            </p>

                            <p class="mt-1 text-sm font-semibold text-white">
                                Midwife Management
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



               {{-- ====================================== --}}
{{-- Main Card --}}
{{-- ====================================== --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Card Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-8 py-6">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                </svg>

            </div>

            <div>

                <h2 class="text-xl font-semibold text-gray-900">
                    Midwife Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Review and update the registered midwife's account information.
                </p>

            </div>

        </div>

    </div>

    {{-- Card Body --}}
    <div class="p-8">

        <form action="{{ route('midwives.update', $midwife->id) }}" method="POST">

            @csrf
            @method('PUT')

            @include('admin.midwives._form')

{{-- ====================================== --}}
{{-- Action Buttons --}}
{{-- ====================================== --}}
<div class="mt-8 border-t border-gray-200 pt-6">

    <div class="flex flex-col-reverse gap-4 sm:flex-row sm:justify-end">

        {{-- Cancel --}}
        <a href="{{ route('midwives.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition duration-200 hover:bg-gray-50 hover:border-gray-400">

            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="h-5 w-5">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>

            <span>Cancel</span>

        </a>

        {{-- Update --}}
        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="h-5 w-5">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
            </svg>

            <span>Update Midwife</span>

        </button>

    </div>

</div>






        </form>

    </div>

</div>

</x-app-layout>