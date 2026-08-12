<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mother Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-6">

{{-- ====================================== --}}
{{-- SUCCESS ALERT --}}
{{-- ====================================== --}}

@if(session('success'))

    <div class="mb-6 overflow-hidden rounded-2xl border border-green-200 bg-green-50 shadow-sm">

        <div class="flex items-start gap-4 px-6 py-5">

            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                </svg>

            </div>

            <div class="flex-1">

                <h3 class="text-sm font-semibold text-green-800">
                    Operation Successful
                </h3>

                <p class="mt-1 text-sm leading-6 text-green-700">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    </div>

@endif

{{-- ====================================== --}}
{{-- PAGE HEADER --}}
{{-- ====================================== --}}

<div class="mb-8">

    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-start gap-4">

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Zm9 0v.01M6 12v.01"/>
                </svg>

            </div>

            <div>

                <p class="text-sm font-semibold uppercase tracking-widest text-pink-600">
                    Maternal Health Management
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                    Mother Registry
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                    Manage registered mothers, maintain maternal records, update patient information,
                    and monitor pregnancy status through a centralized electronic medical record system.
                </p>

            </div>

        </div>

        <div class="flex flex-col gap-3 sm:flex-row">

            <a href="{{ route('mothers.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>

                Register Mother

            </a>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- DASHBOARD STATISTICS --}}
{{-- ====================================== --}}

<div class="mb-8">

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

        <!-- Total Mothers -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Total Registered Mothers
                    </p>

                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900">
                        {{ $totalMothers }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                       Registered maternal records
                    </p>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Z"/>
                    </svg>

                </div>

            </div>

        </div>

        <!-- Active Mothers -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Pregnant Mothers
                    </p>

                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900">
                      {{ $pregnantMothers }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                       Currently under prenatal monitoring
                    </p>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>

                </div>

            </div>

        </div>

        <!-- Inactive Mothers -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Upcoming Appointments
                    </p>

                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-gray-900">
                      {{ $upcomingAppointments }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Scheduled maternal visits
                    </p>

                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M8.25 6.75V3m7.5 3.75V3M3.75 9.75h16.5m-15 10.5h13.5A1.5 1.5 0 0020.25 18V6A1.5 1.5 0 0018.75 4.5H5.25A1.5 1.5 0 003.75 6v12A1.5 1.5 0 005.25 20.25Z"/>
                    </svg>
                </div>
            </div>

        </div>

        <!-- Registry Overview -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Registered Infants
                    </p>

                    <h2 class="mt-3 text-4xl font-bold tracking-tight text-pink-600">
                       {{ $totalInfants }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                       Infant health records
                    </p>

                </div>

               
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.499-1.632Z"/>
                    </svg>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- SEARCH BAR --}}
{{-- ====================================== --}}

<div class="mb-8">

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Search Mother Records
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Search by mother's name, mother code, barangay, contact number, or maternal status.
                    </p>

                </div>

            </div>

        </div>

        <div class="p-6">

            <form method="GET" action="{{ route('mothers.index') }}">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center">

                    <div class="relative flex-1">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-gray-400"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                            </svg>

                        </div>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by mother name, mother code, barangay, contact number, or status..."
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 py-3 pl-12 pr-4 text-sm text-gray-700 placeholder:text-gray-400 transition focus:border-pink-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-pink-100">

                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m21 21-4.35-4.35m0 0A7.65 7.65 0 1 0 5.825 5.825a7.65 7.65 0 0 0 10.825 10.825Z"/>

                            </svg>

                            Search

                        </button>

                        @if(request('search'))

                            <a
                                href="{{ route('mothers.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M4.5 12a7.5 7.5 0 0 1 12.89-5.303M19.5 4.5v6h-6"/>

                                </svg>

                                Reset Search

                            </a>

                        @endif

                    </div>

                </div>

            </form>

            <div class="mt-6 flex flex-wrap gap-2">

                <span class="rounded-full bg-pink-50 px-3 py-1 text-xs font-medium text-pink-700">
                    Mother Name
                </span>

                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                    Mother Code
                </span>

                <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                    Barangay
                </span>

                <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700">
                    Contact Number
                </span>

                <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-purple-700">
                    Maternal Status
                </span>

            </div>

        </div>

    </div>

</div>


                {{-- ====================================== --}}
{{-- MOTHERS LISTING --}}
{{-- Desktop: table (unchanged). Mobile: card layout (new). --}}
{{-- Same $mothers collection, same routes, same search/pagination. --}}
{{-- ====================================== --}}

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-200 px-6 py-4">

        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Registered Mothers
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    View and manage all maternal patient records.
                </p>

            </div>

            <span class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-sm font-medium text-pink-700">

    @if(request('search'))
        Showing {{ $mothers->count() }} of {{ $totalMothers }} Records
    @else
        {{ $totalMothers }} Records
    @endif

</span>

        </div>

    </div>

    @if($mothers->count())

        {{-- ====================================== --}}
        {{-- DESKTOP TABLE — unchanged, hidden below md --}}
        {{-- ====================================== --}}

        <div class="hidden md:block overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Mother Code
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Full Name
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Barangay
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Contact Number
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @foreach($mothers as $mother)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="font-semibold text-gray-900">
                                    {{ $mother->mother_code }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-pink-100 text-pink-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                        </svg>

                                    </div>

                                    <div>

                                        <p class="font-semibold text-gray-900">
                                            {{ $mother->first_name }}
                                            {{ $mother->middle_name }}
                                            {{ $mother->last_name }}
                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $mother->barangay }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $mother->contact_number }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $mother->status }}
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('mothers.show', $mother->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.178a1.012 1.012 0 010 .644C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178Z"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                                        </svg>

                                        View

                                    </a>

                                    <a href="{{ route('mothers.edit', $mother->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl bg-yellow-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-yellow-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M19.5 7.125 16.875 4.5"/>

                                        </svg>

                                        Edit

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ====================================== --}}
        {{-- MOBILE CARDS — new, shown below md only --}}
        {{-- Same $mothers loop, same fields, same routes --}}
        {{-- ====================================== --}}

        <div class="md:hidden divide-y divide-gray-100">

            @foreach($mothers as $mother)

                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-start gap-3 min-w-0">

                            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">
                                    {{ $mother->first_name }} {{ $mother->middle_name }} {{ $mother->last_name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $mother->mother_code }}
                                </p>
                            </div>

                        </div>

                        <span class="flex-shrink-0 inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $mother->status }}
                        </span>

                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-3 text-sm">

                        <div>
                            <p class="text-xs text-gray-400">Barangay</p>
                            <p class="text-gray-700 font-medium">{{ $mother->barangay }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Contact Number</p>
                            <p class="text-gray-700 font-medium">{{ $mother->contact_number }}</p>
                        </div>

                    </div>

                    <div class="mt-4 flex items-center gap-2">

                        <a href="{{ route('mothers.show', $mother->id) }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.178a1.012 1.012 0 010 .644C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                            </svg>

                            View

                        </a>

                        <a href="{{ route('mothers.edit', $mother->id) }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-yellow-600">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                            </svg>

                            Edit

                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- ====================================== --}}
        {{-- EMPTY STATE — unchanged, same for both breakpoints --}}
        {{-- ====================================== --}}

        <div class="px-6 py-12">

            <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-16 text-center">

                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                    </svg>

                </div>

                <h3 class="mt-6 text-xl font-semibold text-gray-900">
                    No Registered Mothers Found
                </h3>

                <p class="mt-3 max-w-md text-sm leading-6 text-gray-500">
                    There are currently no maternal records in the registry.
                    Register the first mother to begin maintaining electronic maternal health records.
                </p>

                <div class="mt-8">

                    <a href="{{ route('mothers.create') }}"
                       class="inline-flex items-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4.5v15m7.5-7.5h-15"/>

                        </svg>

                        Register Mother

                    </a>

                </div>

            </div>

        </div>

    @endif

    @if(method_exists($mothers, 'links'))

        <div class="border-t border-gray-200 px-6 py-5">
            {{ $mothers->links() }}
        </div>

    @endif

</div>



</x-app-layout>