<x-app-layout>
   

    <div class="py-4 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- MOBILE-FRIENDLY BACK BUTTON --}}
            <div class="mb-4">
                <a
                    href="{{ route('mother.health-tips') }}"
                    class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-pink-200 bg-white px-4 py-2.5 text-sm font-semibold text-pink-700 shadow-sm transition hover:bg-pink-50 hover:border-pink-300 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400 focus-visible:ring-offset-2"
                    aria-label="Go back to Health Tips Library"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 flex-shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                        />
                    </svg>

                    <span>Back to Health Tips</span>
                </a>
            </div>

            {{-- ARTICLE CARD --}}
            <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- HEALTH TIP IMAGE --}}
                @if (!empty($healthTip->image))
                    <div class="h-52 sm:h-72 w-full overflow-hidden bg-gradient-to-br from-pink-100 to-teal-100">
                        <img
                            src="{{ asset('storage/' . $healthTip->image) }}"
                            alt="{{ $healthTip->title }}"
                            class="h-full w-full object-cover"
                        >
                    </div>
                @endif

                <div class="p-5 sm:p-8">

                    {{-- CATEGORY --}}
                    @if (!empty($healthTip->category))
                        <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">
                            {{ $healthTip->category }}
                        </span>
                    @endif

                    {{-- TITLE --}}
                    <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                        {{ $healthTip->title }}
                    </h1>

                    {{-- ACCENT LINE --}}
                    <div class="mt-4 h-1 w-16 rounded-full bg-gradient-to-r from-pink-500 to-teal-400"></div>

                    {{-- DESCRIPTION --}}
                    <div class="mt-6 whitespace-pre-line text-base leading-7 sm:leading-8 text-gray-700">
                        {{ $healthTip->description }}
                    </div>

                </div>
            </article>

            {{-- EDUCATIONAL REMINDER --}}
            <div class="rounded-2xl border border-teal-100 bg-teal-50 px-5 py-4 sm:px-6 sm:py-5">
                <div class="flex items-start gap-3">

                    {{-- INFORMATION ICON --}}
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-teal-100 text-teal-700">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-teal-900">
                            A Gentle Reminder
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            Health information is for educational purposes. For medical concerns, contact your RHU or healthcare provider.
                        </p>
                    </div>

                </div>
            </div>

          
</x-app-layout>