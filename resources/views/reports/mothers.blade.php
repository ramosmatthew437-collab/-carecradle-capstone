<x-app-layout>

    <div class="py-6 sm:py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- Header --}}
            {{-- ====================================== --}}

            <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-6 shadow-sm no-print">

                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Healthcare Reporting Center</p>
                        <h1 class="mt-0.5 text-lg sm:text-2xl font-bold text-gray-900">Mother Report</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Review maternal healthcare records and registration status across the Rural Health Unit.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 self-start rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 sm:self-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4.5 w-4.5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wide text-gray-400">Report Generated</p>
                        <p class="text-sm font-medium text-gray-700">{{ now()->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Back to Reports --}}
            {{-- ====================================== --}}

            <a href="{{ route('reports.index') }}"
               class="no-print inline-flex items-center gap-1.5 rounded-xl px-3 py-2 text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Back to Reports
            </a>

            {{-- ====================================== --}}
            {{-- Summary Statistics --}}
            {{-- ====================================== --}}

            <div class="no-print">

                <div class="mb-4 sm:mb-5">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Maternal Healthcare Overview</h2>
                    <p class="mt-1 text-sm text-gray-500">Summary of registered mothers and maternal healthcare status within the current report.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mt-3 text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalMothers }}</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Total Mothers</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mt-3 text-2xl sm:text-3xl font-bold text-blue-600">{{ $pregnant }}</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Pregnant</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mt-3 text-2xl sm:text-3xl font-bold text-emerald-600">{{ $delivered }}</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Delivered</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 6.75 17.25M6.75 6.75l10.5 10.5"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mt-3 text-2xl sm:text-3xl font-bold text-amber-600">{{ $referred }}</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Referred</p>
                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- Search & Filter Toolbar --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm no-print">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-4 sm:px-6 sm:py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 sm:h-6 sm:w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Search &amp; Filter Mothers</h2>
                            <p class="text-sm text-gray-500">Search maternal records and narrow the report using healthcare status and barangay.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-6">

                    <form method="GET" action="{{ route('reports.mothers') }}" class="space-y-5">

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Search Mother</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search Mother..."
                                        class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Maternal Status</label>
                                <select
                                    name="status"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-3 px-3 text-sm shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                                    <option value="">All Status</option>
                                    <option value="Pregnant" @selected(request('status')=='Pregnant')>Pregnant</option>
                                    <option value="Delivered" @selected(request('status')=='Delivered')>Delivered</option>
                                    <option value="Referred" @selected(request('status')=='Referred')>Referred</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Barangay</label>
                                <select
                                    name="barangay"
                                    class="w-full rounded-xl border border-gray-300 bg-white py-3 px-3 text-sm shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
                                    <option value="">All Barangays</option>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay }}" @selected(request('barangay')==$barangay)>
                                            {{ $barangay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end">
                                <div class="flex w-full gap-2">
                                    <button
                                        type="submit"
                                        class="inline-flex h-[46px] flex-1 items-center justify-center gap-2 rounded-xl bg-pink-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                        </svg>
                                        Search
                                    </button>

                                    <a
                                        href="{{ route('reports.mothers') }}"
                                        aria-label="Reset filters"
                                        class="inline-flex h-[46px] w-[46px] flex-shrink-0 items-center justify-center rounded-xl border border-gray-300 bg-white text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865A8.25 8.25 0 0 1 17.803 6.17l3.181 3.182"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Report Action Buttons --}}
            {{-- ====================================== --}}

            <div class="no-print">
                <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h2 class="text-base sm:text-lg font-semibold text-gray-900">Report Actions</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Showing <span class="font-semibold text-pink-600">{{ $mothers->count() }}</span> registered mother record(s) based on the current search and filters.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        <button
                            onclick="window.print()"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5V3.75h10.5V7.5m-10.5 7.5h10.5m-10.5 0A2.25 2.25 0 0 1 4.5 12.75v-3A2.25 2.25 0 0 1 6.75 7.5h10.5a2.25 2.25 0 0 1 2.25 2.25v3A2.25 2.25 0 0 1 17.25 15h-10.5ZM7.5 15v5.25h9V15"/>
                            </svg>
                            Print Report
                        </button>

                        <a
                            href="{{ route('reports.mothers.pdf') }}"
                            class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 active:scale-[0.98]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v2.625A2.625 2.625 0 0 1 16.875 19.5H7.125A2.625 2.625 0 0 1 4.5 16.875V14.25m10.5-6.75L12 4.5m0 0L9 7.5m3-3v10.5"/>
                            </svg>
                            Generate PDF
                        </a>

                    </div>

                </div>
            </div>

            {{-- ====================================== --}}
            {{-- Mother Report Table --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-4 sm:px-6 sm:py-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Mother Report</h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Registered maternal healthcare records from the CareCradle Electronic Medical Record System.
                            </p>
                        </div>
                        <div class="w-fit rounded-xl border border-gray-200 bg-white px-4 py-2 shadow-sm">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total Records</p>
                            <p class="mt-0.5 text-lg font-bold text-pink-600">{{ $mothers->count() }}</p>
                        </div>
                    </div>
                </div>

                @if($mothers->count())

                    {{-- Desktop table --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">#</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Mother Code</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Full Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Barangay</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Contact Number</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($mothers as $mother)

                                    @php
                                        $statusClass = match($mother->status) {
                                            'Pregnant' => 'bg-blue-100 text-blue-700',
                                            'Delivered' => 'bg-emerald-100 text-emerald-700',
                                            'Referred' => 'bg-amber-100 text-amber-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <tr class="transition duration-150 hover:bg-pink-50/40">
                                        <td class="px-6 py-5 text-center text-sm font-semibold text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex rounded-lg bg-gray-100 px-3 py-1.5 font-mono text-xs font-semibold text-gray-700">
                                                {{ $mother->mother_code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}</p>
                                                    <p class="text-xs text-gray-500">Maternal Patient</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-gray-700">{{ $mother->barangay }}</td>
                                        <td class="px-6 py-5 text-sm text-gray-700">{{ $mother->contact_number }}</td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">{{ $mother->status }}</span>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile / tablet cards --}}
                    <div class="lg:hidden divide-y divide-gray-100">
                        @foreach($mothers as $mother)

                            @php
                                $statusClass = match($mother->status) {
                                    'Pregnant' => 'bg-blue-100 text-blue-700',
                                    'Delivered' => 'bg-emerald-100 text-emerald-700',
                                    'Referred' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <div class="p-4 sm:p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 min-w-0">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">{{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}</p>
                                            <p class="font-mono text-xs text-gray-500">#{{ $loop->iteration }} · {{ $mother->mother_code }}</p>
                                        </div>
                                    </div>
                                    <span class="flex-shrink-0 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $mother->status }}</span>
                                </div>

                                <div class="mt-3 grid grid-cols-2 gap-3 rounded-xl bg-gray-50 p-3 text-sm">
                                    <div>
                                        <p class="text-xs text-gray-400">Barangay</p>
                                        <p class="text-gray-700 font-medium truncate">{{ $mother->barangay }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Contact Number</p>
                                        <p class="text-gray-700 font-medium truncate">{{ $mother->contact_number }}</p>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                @else

                    {{-- ====================================== --}}
                    {{-- Empty State --}}
                    {{-- ====================================== --}}

                    <div class="px-5 py-14 sm:px-6 sm:py-16">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 sm:h-10 sm:w-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                </svg>
                            </div>
                            <h3 class="mt-5 sm:mt-6 text-lg sm:text-xl font-semibold text-gray-900">No Mother Records Found</h3>
                            <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                                No maternal healthcare records match the current search criteria or selected filters.
                                Try modifying the search keyword, healthcare status, or barangay filter to display
                                available mother records.
                            </p>
                            <div class="mt-6 sm:mt-8">
                                <a href="{{ route('reports.mothers') }}"
                                   class="inline-flex h-11 items-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0 3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865A8.25 8.25 0 0117.803 6.17l3.181 3.182"/>
                                    </svg>
                                    Reset Filters
                                </a>
                            </div>
                        </div>
                    </div>

                @endif

            </div>

            <footer class="report-footer">
                <strong>CareCradle Electronic Medical Record System</strong><br>
                Irosin Rural Health Unit<br>
                Generated on {{ now()->format('F d, Y') }}
            </footer>

        </div>

    </div>

</x-app-layout>

<style>

@media print {

    nav,
    header,
    .no-print {

        display: none !important;

    }

    body {

        background: white !important;

    }

    .shadow,
    .shadow-sm,
    .shadow-md,
    .shadow-lg {

        box-shadow: none !important;

    }

    thead {

        display: table-header-group;

    }

    tr {

        page-break-inside: avoid;

    }

    .report-footer {

        position: fixed;

        bottom: 0;

        left: 0;

        right: 0;

        padding: 10px 0;

        border-top: 1px solid #d1d5db;

        background: white;

        text-align: center;

        font-size: 12px;

        color: #666;

    }

}

</style>