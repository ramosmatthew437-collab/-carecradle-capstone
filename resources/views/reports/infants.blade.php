<x-app-layout>

    
    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-6">
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
                              d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Infant Report
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Infant Healthcare Reporting Center
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Review infant healthcare records, monitor newborn
                        registration statistics, and generate official reports
                        for child health monitoring within the CareCradle
                        Electronic Medical Record System.
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
                                      d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-medium uppercase tracking-wider text-pink-100">
                                Report Generated
                            </p>

                            <p class="mt-1 text-sm font-semibold text-white">
                                {{ now()->format('F d, Y h:i A') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- Summary Statistics --}}
{{-- ====================================== --}}
<div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

    {{-- Total Infants --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Infants
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $totalInfants }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Registered infant healthcare records.
                </p>

            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-7 w-7">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                </svg>

            </div>

        </div>

    </div>

    {{-- Male --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Male Infants
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $male }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Total registered male infants.
                </p>

            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-7 w-7">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                </svg>

            </div>

        </div>

    </div>

    {{-- Female --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Female Infants
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $female }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Total registered female infants.
                </p>

            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-7 w-7">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                </svg>

            </div>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- Search & Filter Toolbar --}}
{{-- ====================================== --}}
<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm no-print">

    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Search & Filter Infants
                </h2>

                <p class="text-sm text-gray-500">
                    Search infant healthcare records and narrow the report using infant sex.
                </p>

            </div>

        </div>

    </div>

    <div class="p-6">

        <form
            method="GET"
            action="{{ route('reports.infants') }}"
            class="space-y-6">

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

                {{-- Search --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Search Infant
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5 text-gray-400">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>

                        </div>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search Infant..."
                            class="w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                    </div>

                </div>

                {{-- Sex --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Infant Sex
                    </label>

                    <select
                        name="sex"
                        class="w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                        <option value="">All Sex</option>

                        <option
                            value="Male"
                            @selected(request('sex')=='Male')>

                            Male

                        </option>

                        <option
                            value="Female"
                            @selected(request('sex')=='Female')>

                            Female

                        </option>

                    </select>

                </div>

                {{-- Empty Spacer --}}
                <div></div>

                {{-- Actions --}}
                <div class="flex flex-col justify-end">

                    <div class="flex gap-3">

                        <button
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>

                            Search

                        </button>

                        <a
                            href="{{ route('reports.infants') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865A8.25 8.25 0 0 1 17.803 6.17l3.181 3.182"/>
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
<div class="mb-8 no-print">

    <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm lg:flex-row lg:items-center lg:justify-between">

        <div>

            <h2 class="text-lg font-semibold text-gray-900">
                Report Actions
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Showing
                <span class="font-semibold text-pink-600">
                    {{ $infants->count() }}
                </span>
                registered infant record(s) based on the current search and filters.
            </p>

        </div>

        <div class="flex flex-col gap-3 sm:flex-row">

            {{-- Print Report --}}
            <button
                onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-5 w-5">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6.75 7.5V3.75h10.5V7.5m-10.5 7.5h10.5m-10.5 0A2.25 2.25 0 0 1 4.5 12.75v-3A2.25 2.25 0 0 1 6.75 7.5h10.5a2.25 2.25 0 0 1 2.25 2.25v3A2.25 2.25 0 0 1 17.25 15h-10.5ZM7.5 15v5.25h9V15"/>
                </svg>

                <span>Print Report</span>

            </button>

            {{-- Export PDF --}}
            <a
                href="{{ route('reports.infants.pdf') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-5 w-5">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 14.25v2.625A2.625 2.625 0 0 1 16.875 19.5H7.125A2.625 2.625 0 0 1 4.5 16.875V14.25m10.5-6.75L12 4.5m0 0L9 7.5m3-3v10.5"/>
                </svg>

                <span>Export PDF</span>

            </a>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- Infant Report Table --}}
{{-- ====================================== --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Infant Report
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Registered infant healthcare records from the CareCradle Electronic Medical Record System.
                </p>

            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-2 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                    Total Records
                </p>

                <p class="mt-1 text-lg font-bold text-pink-600">
                    {{ $infants->count() }}
                </p>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                        #
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Infant ID
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Infant Name
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Mother
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Sex
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Birth Date
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Birth Status
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">

                @forelse($infants as $infant)

                    <tr class="transition duration-150 hover:bg-pink-50/40">

                        <td class="px-6 py-5 text-center text-sm font-semibold text-gray-700">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Infant ID --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-xl bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700">
                                {{ $infant->id }}
                            </span>

                        </td>

                        {{-- Infant Name --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-semibold text-gray-900">
                                        {{ $infant->first_name }}
                                        {{ $infant->middle_name }}
                                        {{ $infant->last_name }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Infant Patient
                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- Mother --}}
                        <td class="px-6 py-5">

                            <div>

                                <p class="font-medium text-gray-900">
                                    {{ $infant->mother->first_name }}
                                    {{ $infant->mother->last_name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    Mother
                                </p>

                            </div>

                        </td>

                        {{-- Sex --}}
                        <td class="px-6 py-5 text-center">

                            @php
                                $sexClass = match($infant->sex) {
                                    'Male' => 'bg-blue-100 text-blue-700',
                                    'Female' => 'bg-pink-100 text-pink-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="inline-flex rounded-full px-4 py-2 text-xs font-semibold {{ $sexClass }}">
                                {{ $infant->sex }}
                            </span>

                        </td>

                        {{-- Birth Date --}}
                        <td class="px-6 py-5 text-sm text-gray-700">

                            {{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}

                        </td>

                        {{-- Birth Status --}}
                        <td class="px-6 py-5 text-center">

                            @php
                                $birthStatusClass = match($infant->birth_status) {
                                    'Alive' => 'bg-green-100 text-green-700',
                                    'Stillbirth' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="inline-flex rounded-full px-4 py-2 text-xs font-semibold {{ $birthStatusClass }}">
                                {{ $infant->birth_status }}
                            </span>

                        </td>

                    </tr>

                @empty
{{-- ====================================== --}}
{{-- Empty State --}}
{{-- ====================================== --}}
<tr>

    <td colspan="7" class="px-6 py-16">

        <div class="flex flex-col items-center justify-center text-center">

            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-10 w-10">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                </svg>

            </div>

            <h3 class="mt-6 text-xl font-semibold text-gray-900">
                No Infant Records Found
            </h3>

            <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                No infant healthcare records match the current search criteria
                or selected filters. Try adjusting the search keyword or
                infant sex filter to display available infant records.
            </p>

            <div class="mt-8">

                <a
                    href="{{ route('reports.infants') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-5 w-5">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865A8.25 8.25 0 0 1 17.803 6.17l3.181 3.182"/>
                    </svg>

                    Reset Filters

                </a>

            </div>

        </div>

    </td>

</tr> {{-- Section 6: Empty State --}}

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<footer class="report-footer">

    <strong>CareCradle Electronic Medical Record System</strong><br>

    Irosin Rural Health Unit<br>

    Generated on {{ now()->format('F d, Y') }}

</footer>

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