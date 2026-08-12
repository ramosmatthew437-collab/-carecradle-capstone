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
                        Mother Report
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Maternal Healthcare Reporting Center
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Review maternal healthcare records, monitor patient
                        registration status, and generate official reports for
                        pregnant, delivered, and referred mothers within the
                        CareCradle Electronic Medical Record System.
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
<div class="mb-8">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">
            Maternal Healthcare Overview
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Summary of registered mothers and maternal healthcare status within the current report.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Mothers --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Mothers
                    </p>

                    <h2 class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $totalMothers }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Registered maternal patients.
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

        {{-- Pregnant --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Pregnant
                    </p>

                    <h2 class="mt-3 text-3xl font-bold text-green-600">
                        {{ $pregnant }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Mothers currently under prenatal care.
                    </p>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-7 w-7">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Delivered --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Delivered
                    </p>

                    <h2 class="mt-3 text-3xl font-bold text-blue-600">
                        {{ $delivered }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Mothers with completed deliveries.
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
                              d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>

                </div>

            </div>

        </div>

        {{-- Referred --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Referred
                    </p>

                    <h2 class="mt-3 text-3xl font-bold text-red-600">
                        {{ $referred }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Mothers referred for advanced care.
                    </p>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-red-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-7 w-7">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M17.25 6.75 6.75 17.25M6.75 6.75l10.5 10.5"/>
                    </svg>

                </div>

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
                    Search & Filter Mothers
                </h2>

                <p class="text-sm text-gray-500">
                    Search maternal records and narrow the report using healthcare status and barangay.
                </p>

            </div>

        </div>

    </div>

    <div class="p-6">

        <form
            method="GET"
            action="{{ route('reports.mothers') }}"
            class="space-y-6">

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

                {{-- Search --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Search Mother
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
                            placeholder="Search Mother..."
                            class="w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                    </div>

                </div>

                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Maternal Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                        <option value="">All Status</option>

                        <option value="Pregnant"
                            @selected(request('status')=='Pregnant')>
                            Pregnant
                        </option>

                        <option value="Delivered"
                            @selected(request('status')=='Delivered')>
                            Delivered
                        </option>

                        <option value="Referred"
                            @selected(request('status')=='Referred')>
                            Referred
                        </option>

                    </select>

                </div>

                {{-- Barangay --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Barangay
                    </label>

                    <select
                        name="barangay"
                        class="w-full rounded-xl border-gray-300 py-3 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                        <option value="">All Barangays</option>

                        @foreach($barangays as $barangay)

                            <option
                                value="{{ $barangay }}"
                                @selected(request('barangay')==$barangay)>

                                {{ $barangay }}

                            </option>

                        @endforeach

                    </select>

                </div>

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
                            href="{{ route('reports.mothers') }}"
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
                Showing <span class="font-semibold text-pink-600">{{ $mothers->count() }}</span> registered mother record(s) based on the current search and filters.
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
                href="{{ route('reports.mothers.pdf') }}"
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
{{-- Mother Report Table --}}
{{-- ====================================== --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Mother Report
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Registered maternal healthcare records from the CareCradle Electronic Medical Record System.
                </p>

            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-2 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                    Total Records
                </p>

                <p class="mt-1 text-lg font-bold text-pink-600">
                    {{ $mothers->count() }}
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
                        Mother Code
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Full Name
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Barangay
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Contact Number
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">

                @forelse($mothers as $mother)

                    <tr class="transition duration-150 hover:bg-pink-50/40">

                        <td class="px-6 py-5 text-center text-sm font-semibold text-gray-700">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-xl bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700">
                                {{ $mother->mother_code }}
                            </span>

                        </td>

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
                                        {{ $mother->first_name }}
                                        {{ $mother->middle_name }}
                                        {{ $mother->last_name }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Maternal Patient
                                    </p>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 text-sm text-gray-700">
                            {{ $mother->barangay }}
                        </td>

                        <td class="px-6 py-5 text-sm text-gray-700">
                            {{ $mother->contact_number }}
                        </td>

                        <td class="px-6 py-5 text-center">

                            @php
                                $statusClass = match($mother->status) {
                                    'Pregnant' => 'bg-green-100 text-green-700',
                                    'Delivered' => 'bg-blue-100 text-blue-700',
                                    'Referred' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="inline-flex rounded-full px-4 py-2 text-xs font-semibold {{ $statusClass }}">
                                {{ $mother->status }}
                            </span>

                        </td>

                    </tr>

                @empty

                  {{-- ====================================== --}}
{{-- Empty State --}}
{{-- ====================================== --}}
<tr>

    <td colspan="6" class="px-6 py-16">

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
                No Mother Records Found
            </h3>

            <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                No maternal healthcare records match the current search criteria
                or selected filters. Try modifying the search keyword,
                healthcare status, or barangay filter to display available
                mother records.
            </p>

            <div class="mt-8">

                <a
                    href="{{ route('reports.mothers') }}"
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

</tr>

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