
<x-app-layout>
    <div class="py-4 sm:py-6 lg:py-8">
        <div class="mx-auto w-full max-w-6xl space-y-5 px-4 sm:space-y-8 sm:px-6 lg:px-8">

            {{-- BACK TO DASHBOARD --}}
            <div>
                <a
                   href="{{ route('mother.dashboard') }}"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-pink-200 bg-white px-4 py-2.5 text-sm font-semibold text-pink-700 shadow-sm transition hover:border-pink-300 hover:bg-pink-50 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400 focus-visible:ring-offset-2"
                    aria-label="Back to Dashboard"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    <span>Back to Dashboard</span>
                </a>
            </div>

            {{-- 1. PAGE HEADER / HERO --}}
            <header class="relative isolate overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-teal-50 p-5 shadow-sm sm:p-8">
                <div class="pointer-events-none absolute -right-10 -top-10 -z-10 h-40 w-40 rounded-full bg-pink-100/60 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-12 right-8 -z-10 h-32 w-32 rounded-full bg-teal-100/50 blur-2xl sm:right-24"></div>

                <div class="flex min-w-0 items-start gap-3 sm:gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-pink-600 text-white shadow-md shadow-pink-200 sm:h-16 sm:w-16 sm:rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/>
                        </svg>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-600 sm:text-sm">
                            CareCradle Health Education
                        </p>
                        <h1 class="mt-1 break-words text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            Health Tips Library
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600 sm:text-base sm:leading-7">
                            Helpful information for a healthy pregnancy, safe delivery, and caring for your baby.
                        </p>
                    </div>
                </div>
            </header>

            @if(isset($tips) && $tips->count())

                {{-- 2. FEATURED HEALTH TIP --}}
                @php
                    $featuredTip = $tips->first();
                @endphp

                <section aria-labelledby="featured-tip-heading">
                    <h2 id="featured-tip-heading" class="mb-3 text-xs font-semibold uppercase tracking-widest text-teal-600 sm:text-sm">
                        Featured Health Tip
                    </h2>

                    <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md sm:flex">
                        <div class="flex h-44 w-full shrink-0 items-center justify-center overflow-hidden bg-gradient-to-br from-pink-100 to-teal-100 sm:h-auto sm:min-h-64 sm:w-2/5">
                            @if(!empty($featuredTip->image))
                                <img
                                    src="{{ asset('storage/' . $featuredTip->image) }}"
                                    alt="{{ $featuredTip->title ?? 'Health tip' }}"
                                    class="h-full w-full object-cover"
                                    loading="eager"
                                >
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-pink-400 sm:h-16 sm:w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="flex min-w-0 flex-1 flex-col items-start p-5 sm:p-7">
                            @if(!empty($featuredTip->category))
                                <span class="inline-flex max-w-full items-center break-words rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">
                                    {{ $featuredTip->category }}
                                </span>
                            @endif

                            <h3 class="mt-3 break-words text-lg font-bold text-gray-900 sm:text-2xl">
                                {{ $featuredTip->title ?? 'Health Tip' }}
                            </h3>

                            @if(!empty($featuredTip->description))
                                <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-600 sm:text-base sm:leading-7">
                                    {{ \Illuminate\Support\Str::limit($featuredTip->description, 200) }}
                                </p>
                            @endif

                            <a
                                href="{{ route('mother.health-tips.show', $featuredTip) }}"
                                class="mt-5 inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400 focus-visible:ring-offset-2"
                            >
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                </section>

                {{-- 3. CATEGORY LABELS --}}
                <section aria-labelledby="category-heading">
                    <h2 id="category-heading" class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-500 sm:text-sm">
                        Browse by Category
                    </h2>

                    <div class="-mx-4 flex gap-2 overflow-x-auto overscroll-x-contain px-4 pb-3 sm:mx-0 sm:flex-wrap sm:overflow-visible sm:px-0 sm:pb-0" aria-label="Health tip categories">
                        <span class="inline-flex min-h-9 shrink-0 items-center rounded-full bg-pink-600 px-4 py-2 text-xs font-semibold text-white shadow-sm sm:text-sm">
                            All
                        </span>

                        @foreach([
                            'Pregnancy Care',
                            'Nutrition',
                            'Danger Signs',
                            'Preparing for Delivery',
                            'Breastfeeding',
                            'Newborn Care',
                            'Vaccination',
                            'Postpartum Care',
                        ] as $category)
                            <span class="inline-flex min-h-9 shrink-0 items-center rounded-full border border-gray-200 bg-white px-4 py-2 text-xs font-medium text-gray-600 transition hover:border-pink-200 hover:text-pink-700 sm:text-sm">
                                {{ $category }}
                            </span>
                        @endforeach
                    </div>
                </section>

                {{-- 4. HEALTH TIP CARD GRID --}}
                <section aria-labelledby="all-tips-heading">
                    <h2 id="all-tips-heading" class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-500 sm:text-sm">
                        All Health Tips
                    </h2>

                    <div class="grid min-w-0 grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
                        @foreach($tips->skip(1) as $tip)

                            @php
                                $categoryClasses = match($tip->category ?? null) {
                                    'Pregnancy Care' => 'bg-pink-100 text-pink-700',
                                    'Nutrition' => 'bg-teal-100 text-teal-700',
                                    'Danger Signs' => 'bg-red-100 text-red-700',
                                    'Preparing for Delivery' => 'bg-amber-100 text-amber-700',
                                    'Breastfeeding' => 'bg-purple-100 text-purple-700',
                                    'Newborn Care' => 'bg-blue-100 text-blue-700',
                                    'Vaccination' => 'bg-emerald-100 text-emerald-700',
                                    'Postpartum Care' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <article class="flex min-w-0 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                <div class="relative flex h-44 shrink-0 items-center justify-center overflow-hidden bg-gradient-to-br from-pink-50 to-teal-50 sm:h-40">
                                    @if(!empty($tip->image))
                                        <img
                                            src="{{ asset('storage/' . $tip->image) }}"
                                            alt="{{ $tip->title ?? 'Health tip' }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        >
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 01-18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex min-w-0 flex-1 flex-col p-4 sm:p-5">
                                    @if(!empty($tip->category))
                                        <span class="inline-flex w-fit max-w-full items-center break-words rounded-full {{ $categoryClasses }} px-2.5 py-1 text-[11px] font-semibold">
                                            {{ $tip->category }}
                                        </span>
                                    @endif

                                    <h3 class="mt-2.5 break-words text-base font-bold text-gray-900">
                                        {{ $tip->title ?? 'Untitled Health Tip' }}
                                    </h3>

                                    @if(!empty($tip->description))
                                        <p class="mt-1.5 flex-1 whitespace-pre-line break-words text-sm leading-6 text-gray-500">
                                            {{ \Illuminate\Support\Str::limit($tip->description, 110) }}
                                        </p>
                                    @endif

                                    <a
                                        href="{{ route('mother.health-tips.show', $tip) }}"
                                        class="mt-4 inline-flex min-h-11 items-center gap-1.5 self-start text-sm font-semibold text-pink-600 transition hover:text-pink-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pink-400 focus-visible:ring-offset-2"
                                    >
                                        Read More
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

            @else

                {{-- 5. EMPTY STATE --}}
                <section class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-pink-100 bg-white px-5 py-12 text-center sm:px-6 sm:py-16">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-100 to-teal-100 text-pink-500 sm:h-20 sm:w-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900 sm:text-xl">
                        No health tips available yet
                    </h3>

                    <p class="mt-2 max-w-sm text-sm text-gray-500 sm:text-base">
                        Health education materials will appear here soon.
                    </p>
                </section>

            @endif

            {{-- 5. IMPORTANT HEALTH REMINDER --}}
            <aside class="rounded-2xl border border-teal-100 bg-teal-50 px-5 py-4 sm:px-6 sm:py-5">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-teal-100 text-teal-600 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Zm-9 5.25h.008v.008H12v-.008Z"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900">
                            Need help?
                        </p>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            Health tips are for educational purposes. For medical concerns, contact your RHU or healthcare provider.
                        </p>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</x-app-layout>
