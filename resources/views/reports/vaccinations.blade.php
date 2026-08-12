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
                              d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Vaccination Report
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Immunization Reporting Center
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Review vaccination records, monitor infant immunization
                        coverage, and generate official healthcare reports for
                        the CareCradle Electronic Medical Record System to
                        support child health services within the Rural Health
                        Unit.
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

    {{-- Total Vaccinations --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Vaccinations
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $totalVaccinations }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Total vaccination records administered.
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
                          d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                </svg>

            </div>

        </div>

    </div>

    {{-- Vaccinated Infants --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Vaccinated Infants
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $totalInfants }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Infants who received vaccination services.
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
                          d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                </svg>

            </div>

        </div>

    </div>

    {{-- Vaccine Types --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Vaccine Types
                </p>

                <h2 class="mt-3 text-4xl font-bold text-gray-900">
                    {{ $vaccineTypes }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Distinct vaccines available in the report.
                </p>

            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-7 w-7">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.428 15.428a2.25 2.25 0 00-3.182-3.182L5.25 23.25m0 0L3 21m2.25 2.25L21 7.5l-2.25-2.25-15.75 15.75Z"/>
                </svg>

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- Search Toolbar --}}
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
                    Search Vaccination Records
                </h2>

                <p class="text-sm text-gray-500">
                    Search vaccination records by vaccine name, infant, or related healthcare information.
                </p>

            </div>

        </div>

    </div>

    <div class="p-6">

        <form
            method="GET"
            action="{{ route('reports.vaccinations') }}"
            class="space-y-6">

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-4">

                {{-- Search --}}
                <div class="lg:col-span-3">

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Search Vaccine
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
                            placeholder="Search Vaccine..."
                            class="w-full rounded-xl border-gray-300 py-3 pl-11 pr-4 text-sm shadow-sm focus:border-pink-500 focus:ring-pink-500">

                    </div>

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
                            href="{{ route('reports.vaccinations') }}"
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
                    {{ $vaccinations->count() }}
                </span>
                vaccination record(s) based on the current search results.
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
                href="{{ route('reports.vaccinations.pdf') }}"
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
{{-- Vaccination Report Table --}}
{{-- ====================================== --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Vaccination Report
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Immunization records from the CareCradle Electronic Medical Record System.
                </p>

            </div>

            <div class="rounded-xl border border-gray-200 bg-white px-4 py-2 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                    Total Records
                </p>

                <p class="mt-1 text-lg font-bold text-pink-600">
                    {{ $vaccinations->count() }}
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
                        Infant
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Mother
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Vaccine
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Dose
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Date Given
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Next Due
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        Administered By
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">

                @forelse($vaccinations as $vaccination)

                    <tr class="transition duration-150 hover:bg-pink-50/40">

                        {{-- No. --}}
                        <td class="px-6 py-5 text-center text-sm font-semibold text-gray-700">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Infant --}}
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
                                        {{ $vaccination->infant->first_name }}
                                        {{ $vaccination->infant->last_name }}
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
                                    {{ $vaccination->infant->mother->first_name }}
                                    {{ $vaccination->infant->mother->last_name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    Mother
                                </p>

                            </div>

                        </td>

                        {{-- Vaccine --}}
                        <td class="px-6 py-5">

                            <span class="inline-flex rounded-xl bg-pink-100 px-3 py-2 text-sm font-semibold text-pink-700">
                                {{ $vaccination->vaccine_name }}
                            </span>

                        </td>

                        {{-- Dose --}}
                        <td class="px-6 py-5 text-center">

                            <span class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-xs font-semibold text-blue-700">
                                {{ $vaccination->dose }}
                            </span>

                        </td>

                        {{-- Date Given --}}
                        <td class="px-6 py-5 text-sm text-gray-700">

                            {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}

                        </td>

                        {{-- Next Due --}}
                        <td class="px-6 py-5 text-sm text-gray-700">

                            @if($vaccination->next_due_date)

                                <span class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                                </span>

                            @else

                                <span class="text-gray-400">
                                    -
                                </span>

                            @endif

                        </td>

                        {{-- Administered By --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.964 0a9 9 0 10-11.964 0m11.964 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                    </svg>

                                </div>

                                <div>

                                    <p class="font-medium text-gray-900">
                                        {{ $vaccination->administered_by }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Healthcare Provider
                                    </p>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

{{-- ====================================== --}}
{{-- Empty State --}}
{{-- ====================================== --}}
<tr>

    <td colspan="8" class="px-6 py-16">

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
                          d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                </svg>

            </div>

            <h3 class="mt-6 text-xl font-semibold text-gray-900">
                No Vaccination Records Found
            </h3>

            <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                No vaccination records match the current search criteria.
                Try modifying the search keyword or resetting the search to
                display all available immunization records.
            </p>

            <div class="mt-8">

                <a
                    href="{{ route('reports.vaccinations') }}"
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

                    Reset Search

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