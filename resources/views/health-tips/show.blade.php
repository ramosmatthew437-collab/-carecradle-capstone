<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Health Tip Details
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ====================================== --}}
            {{-- BACK TO HEALTH TIPS LIBRARY --}}
            {{-- ====================================== --}}

            <a href="{{ route('mother.health-tips') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-pink-600 transition hover:text-pink-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Health Tips Library
            </a>

            {{-- ====================================== --}}
            {{-- ARTICLE CARD --}}
            {{-- ====================================== --}}

            <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Optional Image --}}
                @if(!empty($healthTip->image))
                    <div class="h-52 sm:h-72 w-full overflow-hidden bg-gradient-to-br from-pink-100 to-teal-100">
                        <img src="{{ asset('storage/' . $healthTip->image) }}" alt="{{ $healthTip->title }}" class="h-full w-full object-cover">
                    </div>
                @endif

                <div class="p-5 sm:p-8">

                    {{-- Category Badge --}}
                    @if(!empty($healthTip->category))
                        <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">
                            {{ $healthTip->category }}
                        </span>
                    @endif

                    {{-- Title --}}
                    <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                        {{ $healthTip->title }}
                    </h1>

                    {{-- Divider accent --}}
                    <div class="mt-4 h-1 w-16 rounded-full bg-gradient-to-r from-pink-500 to-teal-400"></div>

                    {{-- Content --}}
                    <div class="mt-6 text-base leading-7 sm:leading-8 text-gray-700 whitespace-pre-line">
                        {{ $healthTip->description }}
                    </div>

                </div>

            </article>

            {{-- ====================================== --}}
            {{-- EDUCATIONAL REMINDER --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-teal-100 bg-teal-50 px-5 py-4 sm:px-6 sm:py-5">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-teal-100 text-teal-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9 5.25h.008v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm leading-6 text-gray-600">
                            Health information is for educational purposes. For medical concerns, contact your RHU or healthcare provider.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- BACK TO HEALTH TIPS LIBRARY (bottom) --}}
            {{-- ====================================== --}}

            <div class="flex justify-center pt-2">
                <a href="{{ route('mother.health-tips') }}"
                   class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Health Tips Library
                </a>
            </div>

        </div>
    </div>

</x-app-layout>