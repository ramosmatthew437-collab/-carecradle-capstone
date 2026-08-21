<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Midwife
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- Header --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:px-7 sm:py-6 shadow-sm">

                <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Healthcare Workforce</p>
                    <h1 class="mt-0.5 text-lg sm:text-2xl font-bold text-gray-900">Edit Midwife</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Update the midwife's profile and account information.
                    </p>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Main Card --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-7 sm:py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5V6a3 3 0 10-6 0v1.5m-3 0h9m-9 0A1.5 1.5 0 007.5 9v9A1.5 1.5 0 009 19.5h9A1.5 1.5 0 0019.5 18V9A1.5 1.5 0 0018 7.5Zm-9 0V6a6 6 0 1112 0v1.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Midwife Information</h2>
                            <p class="mt-0.5 text-sm text-gray-500">Review and update the registered midwife's account information.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">

                    <form action="{{ route('midwives.update', $midwife->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        @include('admin.midwives._form')

                        {{-- ====================================== --}}
                        {{-- Action Buttons --}}
                        {{-- ====================================== --}}

                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                                <a href="{{ route('midwives.index') }}"
                                   class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                    </svg>
                                    Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"/>
                                    </svg>
                                    Update Midwife
                                </button>

                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>