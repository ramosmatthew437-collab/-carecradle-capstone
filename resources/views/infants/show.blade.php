<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Infant Profile
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">
{{-- ====================================== --}}
{{-- SECTION 1 : HERO PROFILE HEADER --}}
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
                          d="M15.75 11.25a3.75 3.75 0 1 0-7.5 0v.75A2.25 2.25 0 0 1 6 14.25v1.5A2.25 2.25 0 0 0 8.25 18h7.5A2.25 2.25 0 0 0 18 15.75v-1.5A2.25 2.25 0 0 1 15.75 12v-.75Z" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 3.75v1.5" />

                </svg>

            </div>

            <div>

                <p class="text-sm font-semibold uppercase tracking-widest text-pink-600">
                    Infant Health Record
                </p>

                <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">

                    {{ $infant->first_name }}
                    {{ $infant->middle_name }}
                    {{ $infant->last_name }}

                </h1>

                <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-600">

                    <div class="flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-pink-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6.75a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"/>

                        </svg>

                        <span class="font-medium text-gray-700">
                            Mother:
                        </span>

                        <span>

                            {{ $infant->mother->first_name }}
                            {{ $infant->mother->last_name }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="flex flex-col items-start gap-3 lg:items-end">

            @if($infant->birth_status == 'Alive')

                <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">

                    <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

                    Alive

                </span>

            @else

                <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">

                    <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                    Stillbirth

                </span>

            @endif

            <div class="rounded-2xl border border-pink-100 bg-pink-50 px-5 py-4">

                <p class="text-xs font-semibold uppercase tracking-wide text-pink-600">
                    CareCradle EMR
                </p>

                <p class="mt-1 text-sm font-semibold text-gray-900">
                    Infant Profile
                </p>

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- SECTION 2 : INFANT INFORMATION --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

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
                          d="M18 18.72a9.094 9.094 0 0 0 3-6.72A9 9 0 1 0 3 12a9.094 9.094 0 0 0 3 6.72M9 10.5h6M9 13.5h3"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Infant Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Basic demographic information and birth details recorded during infant registration.
                </p>

            </div>

        </div>

    </div>

    <div class="p-6">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

            {{-- Full Name --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Full Name
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">

                    {{ $infant->first_name }}
                    {{ $infant->middle_name }}
                    {{ $infant->last_name }}

                </p>

            </div>

            {{-- Sex --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Sex
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ $infant->sex }}
                </p>

            </div>

            {{-- Birth Date --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Birth Date
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($infant->birth_date)->format('F d, Y') }}
                </p>

            </div>

            {{-- Birth Weight --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Birth Weight
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ number_format($infant->birth_weight,2) }} kg
                </p>

            </div>

            {{-- Birth Length --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Birth Length
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ number_format($infant->birth_length,2) }} cm
                </p>

            </div>

            {{-- Head Circumference --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Head Circumference
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">

                    {{ $infant->head_circumference
                        ? number_format($infant->head_circumference,2).' cm'
                        : '-' }}

                </p>

            </div>

        </div>

        {{-- Remarks --}}
        <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 p-6">

            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                Clinical Remarks
            </h3>

            <div class="mt-3 rounded-xl border border-gray-200 bg-white p-4 text-sm leading-7 text-gray-700">

                {{ $infant->remarks ?: '-' }}

            </div>

        </div>

    </div>

</div>


{{-- ====================================== --}}
{{-- SECTION 3 : GROWTH MONITORING --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-6 py-5 md:flex-row md:items-center md:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 3v18h18M7.5 15l3-3 2.5 2.5L17 9"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Growth Monitoring
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Track the infant's physical growth through regular health assessments.
                </p>

            </div>

        </div>

        <a
            href="{{ route('growth-monitorings.create', $infant) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">

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

            Add Growth Record

        </a>

    </div>

    @if ($infant->growthMonitorings->isEmpty())

        <div class="px-6 py-12 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-gray-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 3v18h18"/>

                </svg>

            </div>

            <h3 class="mt-4 text-lg font-semibold text-gray-900">
                No Growth Records
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                No growth monitoring records have been recorded yet.
            </p>

        </div>

    @else

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr class="border-b border-gray-200">

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Date Measured
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Age
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Weight
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Height
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Head Circumference
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">

                    @foreach($infant->growthMonitorings as $growth)

                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                {{ \Carbon\Carbon::parse($growth->date_measured)->format('M d, Y') }}

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                {{ $growth->age_in_months }} month(s)

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">

                                {{ number_format($growth->weight, 2) }} kg

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">

                                {{ number_format($growth->height, 2) }} cm

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                {{ $growth->head_circumference
                                    ? number_format($growth->head_circumference, 2).' cm'
                                    : '-' }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                <a
                                    href="{{ route('growth-monitorings.show', $growth) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.01 9.964 7.178a1 1 0 010 .644C20.577 16.49 16.639 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                                    </svg>

                                    View

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>

{{-- ====================================== --}}
{{-- SECTION 4 : VACCINATION RECORDS --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-6 py-5 md:flex-row md:items-center md:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 7.5 16.5 4.5m0 0L9 12m7.5-7.5 3 3M9 12l-4.5 4.5M6 18l-1.5 1.5"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Vaccination Records
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Immunization history and scheduled vaccine doses for the infant.
                </p>

            </div>

        </div>

        <a
            href="{{ route('vaccinations.create', $infant) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md">

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

            Add Vaccination

        </a>

    </div>

    @if ($infant->vaccinations->isEmpty())

        <div class="px-6 py-12 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-gray-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 7.5 16.5 4.5m0 0L9 12m7.5-7.5 3 3M9 12l-4.5 4.5M6 18l-1.5 1.5"/>

                </svg>

            </div>

            <h3 class="mt-4 text-lg font-semibold text-gray-900">
                No Vaccination Records
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                No vaccination records have been added for this infant.
            </p>

        </div>

    @else

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr class="border-b border-gray-200">

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Vaccine
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Dose
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Date Given
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Next Due
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">

                    @foreach($infant->vaccinations as $vaccination)

                        <tr class="transition hover:bg-gray-50">

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">

                                {{ $vaccination->vaccine_name }}

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $vaccination->dose }}

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                {{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                {{ $vaccination->next_due_date
                                    ? \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y')
                                    : '-' }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                <a
                                    href="{{ route('vaccinations.show', $vaccination) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.01 9.964 7.178a1 1 0 010 .644C20.577 16.49 16.639 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178Z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>

                                    </svg>

                                    View

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>


{{-- ====================================== --}}
{{-- SECTION 5 : ACTION BUTTONS --}}
{{-- ====================================== --}}

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-4 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h3 class="text-lg font-semibold text-gray-900">
                Record Management
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Manage this infant's medical profile and return to the linked maternal record.
            </p>

        </div>

        <div class="flex flex-col gap-3 sm:flex-row">

            {{-- Back to Mother --}}
            <a
                href="{{ route('mothers.show', $infant->mother->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 19.5 8.25 12l7.5-7.5"/>

                </svg>

                Back to Mother

            </a>

            {{-- Edit Infant --}}
            <a
                href="{{ route('infants.edit', $infant->id) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600 hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16.862 4.487a2.25 2.25 0 1 1 3.182 3.182L7.5 20.25 3 21l.75-4.5L16.862 4.487Z"/>

                </svg>

                Edit Infant

            </a>

            {{-- Delete Infant --}}
            <form
                action="{{ route('infants.destroy', $infant->id) }}"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    onclick="return confirm('Delete this infant record?')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 hover:shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 7.5h12M9.75 7.5V6a2.25 2.25 0 0 1 2.25-2.25h0A2.25 2.25 0 0 1 14.25 6v1.5m2.25 0v10.125A2.625 2.625 0 0 1 13.875 20.25h-3.75A2.625 2.625 0 0 1 7.5 17.625V7.5m3 3v5.25m3-5.25v5.25"/>

                    </svg>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>
                

</x-app-layout>