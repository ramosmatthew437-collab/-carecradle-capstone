<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Health Tip Details
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- 1. HEADER / HERO --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-14 right-24 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative flex flex-col gap-5 p-5 sm:p-8 sm:flex-row sm:items-start">

                    <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-100">
                            Health Tip Details
                        </p>
                        <p class="mt-1 text-sm text-pink-100/90">
                            Review the health education material before editing or managing it.
                        </p>

                        @if(!empty($healthTip->category))
                            <span class="mt-3 inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white">
                                {{ $healthTip->category }}
                            </span>
                        @endif

                        <h1 class="mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white">
                            {{ $healthTip->title }}
                        </h1>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 2. ARTICLE IMAGE --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                @if(!empty($healthTip->image))
                    <div class="h-56 sm:h-80 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $healthTip->image) }}" alt="{{ $healthTip->title }}" class="h-full w-full object-cover">
                    </div>
                @else
                    <div class="flex h-48 sm:h-64 w-full flex-col items-center justify-center gap-3 bg-gradient-to-br from-pink-50 to-teal-50 text-center">
                        <div class="flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-white text-pink-400 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-400">No image attached to this health tip</p>
                    </div>
                @endif

            </div>

            {{-- ====================================== --}}
            {{-- 3. ARTICLE CONTENT --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-8">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5A3.375 3.375 0 0010.125 2.25H6.75A2.25 2.25 0 004.5 4.5v15A2.25 2.25 0 006.75 21.75h10.5a2.25 2.25 0 002.25-2.25V14.25Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 2.25v4.875a1.125 1.125 0 001.125 1.125H19.5"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Article Content</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">Full health education content as mothers will read it.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">

                    {{-- Meta info --}}
                    <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-3">

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Category</p>
                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $healthTip->category ?: '—' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Date Created</p>
                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ optional($healthTip->created_at)->format('F d, Y') ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Last Updated</p>
                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ optional($healthTip->updated_at)->format('F d, Y') ?? '-' }}
                            </p>
                        </div>

                    </div>

                    {{-- Divider accent --}}
                    <div class="mt-6 h-1 w-16 rounded-full bg-gradient-to-r from-pink-500 to-teal-400"></div>

                    {{-- Full description --}}
                    <div class="mt-6 max-w-3xl text-base leading-7 sm:leading-8 text-gray-700 whitespace-pre-line">
                        {{ $healthTip->description }}
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 4. ACTION BUTTONS --}}
            {{-- ====================================== --}}

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                <a href="{{ route('midwife.health-tips.index') }}"
                   class="inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Health Tips
                </a>

                <div class="flex flex-col gap-3 sm:flex-row">

                    <a href="{{ route('midwife.health-tips.edit', $healthTip) }}"
                       class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                        </svg>
                        Edit Health Tip
                    </a>

                    <form action="{{ route('midwife.health-tips.destroy', $healthTip) }}" method="POST" onsubmit="return confirm('Delete this health tip? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-9.75 0V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0114.25 6v1.5m2.25 0v10.125A2.625 2.625 0 0113.875 20.25h-3.75A2.625 2.625 0 017.5 17.625V7.5M10.5 11.25v5.25m3-5.25v5.25"/>
                            </svg>
                            Delete Health Tip
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>