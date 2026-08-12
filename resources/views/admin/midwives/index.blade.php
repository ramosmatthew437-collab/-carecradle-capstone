<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Midwife Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-6">


{{-- ====================================== --}}
{{-- SECTION 1 : SUCCESS ALERT --}}
{{-- ====================================== --}}

@if(session('success'))

<div class="mb-8 overflow-hidden rounded-2xl border border-green-200 bg-white shadow-sm">

    <div class="flex items-start gap-4 border-l-4 border-green-500 px-6 py-5">

        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-green-100 text-green-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m4.5 12.75 6 6 9-13.5" />

            </svg>

        </div>

        <div class="flex-1">

            <h3 class="text-sm font-semibold uppercase tracking-wide text-green-700">
                Success
            </h3>

            <p class="mt-1 text-sm leading-6 text-gray-700">
                {{ session('success') }}
            </p>

        </div>

    </div>

</div>

@endif
{{-- ====================================== --}}
{{-- SECTION 2 : HERO HEADER --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-6 p-8 lg:flex-row lg:items-center lg:justify-between">

        <div class="flex items-start gap-5">

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 9.75h.008v.008h-.008V9.75Zm-3.75 0h.008v.008H12V9.75Zm-3.75 0h.008v.008H8.25V9.75Z" />

                </svg>

            </div>

            <div>

                <p class="text-sm font-semibold uppercase tracking-widest text-pink-600">
                    Healthcare Workforce
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                    Midwife Management
                </h1>

                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-500">
                    Manage registered midwives within the CareCradle Maternal & Infant Health
                    Monitoring System. Monitor workforce availability, maintain staff records,
                    and manage account access for Rural Health Unit healthcare providers.
                </p>

            </div>

        </div>

        <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center">

            <div class="rounded-2xl border border-pink-100 bg-pink-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                        </svg>

                    </div>

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-pink-600">
                            CareCradle EMR
                        </p>

                        <p class="text-sm font-semibold text-gray-900">
                            Midwife Registry
                        </p>

                    </div>

                </div>

            </div>

            <a href="{{ route('midwives.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4.5v15m7.5-7.5h-15" />

                </svg>

                Add Midwife

            </a>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- SECTION 3 : SUMMARY STATISTICS --}}
{{-- ====================================== --}}


<div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

    {{-- Total Midwives --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Midwives
                </p>

                <h3 class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalMidwives }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Registered healthcare staff
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
                          d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                </svg>

            </div>

        </div>

    </div>

    {{-- Active Midwives --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Active Midwives
                </p>

                <h3 class="mt-2 text-3xl font-bold text-green-600">
                    {{ $activeMidwives }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Currently providing services
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
                          d="m4.5 12.75 6 6 9-13.5" />

                </svg>

            </div>

        </div>

    </div>

    {{-- Inactive Midwives --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Inactive Midwives
                </p>

                <h3 class="mt-2 text-3xl font-bold text-red-600">
                    {{ $inactiveMidwives }}
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Accounts currently disabled
                </p>

            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-red-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18 18 6M6 6l12 12" />

                </svg>

            </div>

        </div>

    </div>

</div>
{{-- ====================================== --}}
{{-- SECTION 4 : SEARCH BAR --}}
{{-- ====================================== --}}

<div class="mb-8 rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Search Midwives
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Quickly locate midwives by username, name, contact number, email, or account status.
                </p>

            </div>

        </div>

    </div>

    {{-- Search --}}
    <div class="p-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

           <form method="GET" action="{{ route('midwives.index') }}" class="w-full">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div class="relative w-full lg:max-w-xl">

            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-gray-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"/>

                </svg>

            </div>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search username, name, contact number, email..."
                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-28 text-sm text-gray-700 placeholder-gray-400 shadow-sm transition focus:border-pink-500 focus:ring-2 focus:ring-pink-100">

            <button
                type="submit"
                class="absolute right-2 top-2 rounded-xl bg-pink-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-pink-700">

                Search

            </button>

        </div>

        {{-- Filter Chips --}}
        <div class="flex flex-wrap gap-2">

            <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600">
                All Midwives
            </span>

            <span class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-4 py-2 text-sm font-medium text-green-700">
                Active
            </span>

            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-700">
                Inactive
            </span>

        </div>

    </div>

    @if(request('search'))

        <div class="mt-4 flex justify-end">

            <a href="{{ route('midwives.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4.5 12a7.5 7.5 0 0112.89-5.303M19.5 4.5v6h-6"/>

                </svg>

                Reset Search

            </a>

        </div>

    @endif

</form>
        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- SECTION 5 : MIDWIFE TABLE --}}
{{-- ====================================== --}}

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Table Header --}}
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Registered Midwives
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Manage healthcare professionals assigned to the Rural Health Unit.
                </p>

            </div>

            <div class="rounded-xl border border-pink-100 bg-pink-50 px-4 py-2">

                @if(request('search'))

    <span class="text-sm font-semibold text-pink-700">
        Showing {{ $midwives->count() }} of {{ $totalMidwives }} Records
    </span>

@else

    <span class="text-sm font-semibold text-pink-700">
        {{ $totalMidwives }} Records
    </span>

@endif

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Username
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Full Name
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Contact Number
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Email Address
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

            @forelse($midwives as $midwife)

                <tr class="transition duration-200 hover:bg-gray-50">

                    {{-- Username --}}
                    <td class="px-6 py-5 whitespace-nowrap">

                        <div>

                            <p class="font-semibold text-gray-900">
                                {{ $midwife->username }}
                            </p>

                            <p class="text-sm text-gray-500">
                                System Account
                            </p>

                        </div>

                    </td>

                    {{-- Full Name --}}
                    <td class="px-6 py-5 whitespace-nowrap">

                        <div>

                            <p class="font-semibold text-gray-900">
                                {{ trim($midwife->first_name.' '.$midwife->middle_name.' '.$midwife->last_name) }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Registered Midwife
                            </p>

                        </div>

                    </td>

                    {{-- Contact --}}
                    <td class="px-6 py-5 whitespace-nowrap">

                        <span class="text-gray-700">
                            {{ $midwife->contact_number ?: '-' }}
                        </span>

                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-5 whitespace-nowrap">

                        <span class="text-gray-700">
                            {{ $midwife->email ?: '-' }}
                        </span>

                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-5 text-center whitespace-nowrap">

                        @if($midwife->is_active)

                            <span class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-100 px-3 py-1.5 text-sm font-semibold text-green-700">

                                <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

                                Active

                            </span>

                        @else

                            <span class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-100 px-3 py-1.5 text-sm font-semibold text-red-700">

                                <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                                Inactive

                            </span>

                        @endif

                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-5">

                        <div class="flex items-center justify-center gap-2">

                            {{-- Edit --}}
                            <a href="{{ route('midwives.edit', $midwife->id) }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 hover:shadow-md">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-4 w-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>

                                </svg>

                                Edit

                            </a>

                            {{-- Deactivate --}}
                            @if($midwife->is_active)

                                <form action="{{ route('midwives.destroy', $midwife->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Deactivate this midwife?')"
                                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 hover:shadow-md">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M6 18 18 6M6 6l12 12"/>

                                        </svg>

                                        Deactivate

                                    </button>

                                </form>

                            @else

                                <form action="{{ route('midwives.activate', $midwife->id) }}" method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        onclick="return confirm('Activate this midwife?')"
                                        class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m4.5 12.75 6 6 9-13.5"/>

                                        </svg>

                                        Activate

                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty



            {{-- ====================================== --}}
{{-- SECTION 6 : EMPTY STATE --}}
{{-- ====================================== --}}

            <tr>

                <td colspan="6" class="px-6 py-20">

                    <div class="flex flex-col items-center justify-center text-center">

                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-10 w-10"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />

                            </svg>

                        </div>

                        <h3 class="mt-6 text-xl font-semibold text-gray-900">
                            No Registered Midwives
                        </h3>

                        <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                            There are currently no registered midwives in the CareCradle system.
                            Add a healthcare provider to begin managing midwife accounts for the
                            Rural Health Unit.
                        </p>

                        <div class="mt-8">

                            <a href="{{ route('midwives.create') }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-pink-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 hover:shadow-md">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 4.5v15m7.5-7.5h-15" />

                                </svg>

                                Add Midwife

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


    

</x-app-layout>