<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Health Tips Management
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- 1. PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-white p-5 sm:p-8 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-pink-100/60 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-12 right-24 h-32 w-32 rounded-full bg-pink-50 blur-2xl"></div>

                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-start gap-4">

                        <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white shadow-md shadow-pink-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-600">
                                Health Education
                            </p>
                            <h1 class="mt-1 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                                Health Tips Management
                            </h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                                Create and maintain health education materials for mothers.
                            </p>
                        </div>

                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row lg:flex-shrink-0">
                        <a href="{{ route('midwife.health-tips.create') }}"
                           class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm shadow-pink-200 transition hover:bg-pink-700 hover:shadow-md active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add Health Tip
                        </a>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 2. SEARCH / FILTER --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="p-4 sm:p-6">

                    <form method="GET" action="{{ route('midwife.health-tips.index') }}">

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <div class="relative flex-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>
                                    </svg>
                                </div>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by title..."
                                    class="w-full rounded-2xl border border-gray-300 bg-gray-50 py-3 pl-12 pr-4 text-sm text-gray-700 placeholder:text-gray-400 transition focus:border-pink-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-100">
                            </div>

                            <select
                                name="category"
                                class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-700 transition focus:border-pink-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-100 sm:w-56">
                                <option value="">All Categories</option>
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
                                    <option value="{{ $category }}" @selected(request('category') == $category)>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>

                            <button
                                type="submit"
                                class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98] sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>
                                </svg>
                                Search
                            </button>

                            @if(request('search') || request('category'))
                                <a href="{{ route('midwife.health-tips.index') }}"
                                   class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 sm:w-auto">
                                    Reset
                                </a>
                            @endif

                        </div>

                    </form>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- 3. HEALTH TIP LIST --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-5 py-5 sm:px-6">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Health Tips</h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Manage published health education materials.</p>
                        </div>
                        <span class="w-fit inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs sm:text-sm font-medium text-pink-700">
                            {{ $tips->count() }} {{ Str::plural('tip', $tips->count()) }}
                        </span>
                    </div>
                </div>

                @if($tips->count())

                    {{-- Desktop table --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tip</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Category</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Date Created</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($tips as $tip)
                                    <tr class="transition hover:bg-pink-50/40">

                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-3">
                                                <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-pink-100 to-teal-100">
                                                    @if(!empty($tip->image))
                                                        <img src="{{ asset('storage/' . $tip->image) }}" alt="{{ $tip->title }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center text-pink-400">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 truncate max-w-xs">{{ $tip->title }}</p>
                                                    @if(!empty($tip->description))
                                                        <p class="mt-0.5 text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($tip->description, 70) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            @if(!empty($tip->category))
                                                <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-xs font-semibold text-pink-700">
                                                    {{ $tip->category }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ optional($tip->created_at)->format('M d, Y') ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">

                                                <a href="{{ route('midwife.health-tips.show', $tip) }}"
                                                   title="View"
                                                   class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.178a1.012 1.012 0 010 .644C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                                    </svg>
                                                    View
                                                </a>

                                                <a href="{{ route('midwife.health-tips.edit', $tip) }}"
                                                   title="Edit"
                                                   class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-amber-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('midwife.health-tips.destroy', $tip) }}" method="POST" onsubmit="return confirm('Delete this health tip? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            title="Delete"
                                                            class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-9.75 0V6a1.5 1.5 0 011.5-1.5h3A1.5 1.5 0 0114.25 6v1.5m2.25 0v10.125A2.625 2.625 0 0113.875 20.25h-3.75A2.625 2.625 0 017.5 17.625V7.5M10.5 11.25v5.25m3-5.25v5.25"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile / tablet cards --}}
                    <div class="lg:hidden divide-y divide-gray-100">
                        @foreach($tips as $tip)
                            <div class="p-4 sm:p-5">

                                <div class="flex items-start gap-3">
                                    <div class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-pink-100 to-teal-100">
                                        @if(!empty($tip->image))
                                            <img src="{{ asset('storage/' . $tip->image) }}" alt="{{ $tip->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-pink-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-gray-900 truncate">{{ $tip->title }}</p>

                                        <div class="mt-1 flex flex-wrap items-center gap-2">
                                            @if(!empty($tip->category))
                                                <span class="inline-flex items-center rounded-full bg-pink-100 px-2.5 py-0.5 text-[11px] font-semibold text-pink-700">
                                                    {{ $tip->category }}
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-400">
                                                {{ optional($tip->created_at)->format('M d, Y') ?? '-' }}
                                            </span>
                                        </div>

                                        @if(!empty($tip->description))
                                            <p class="mt-1.5 text-sm text-gray-500 line-clamp-2">{{ $tip->description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2">

                                    <a href="{{ route('midwife.health-tips.show', $tip) }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
                                        View
                                    </a>

                                    <a href="{{ route('midwife.health-tips.edit', $tip) }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-amber-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('midwife.health-tips.destroy', $tip) }}" method="POST" onsubmit="return confirm('Delete this health tip? This cannot be undone.')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                @else

                    {{-- ====================================== --}}
                    {{-- 4. EMPTY STATE --}}
                    {{-- ====================================== --}}

                    <div class="px-6 py-12 sm:py-16">
                        <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 sm:py-16 text-center">

                            <div class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            </div>

                            <h3 class="mt-6 text-lg sm:text-xl font-semibold text-gray-900">
                                No health tips available
                            </h3>

                            <p class="mt-3 max-w-md text-sm leading-6 text-gray-500">
                                Create your first health education article.
                            </p>

                            <div class="mt-8">
                                <a href="{{ route('midwife.health-tips.create') }}"
                                   class="inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Add Health Tip
                                </a>
                            </div>

                        </div>
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>