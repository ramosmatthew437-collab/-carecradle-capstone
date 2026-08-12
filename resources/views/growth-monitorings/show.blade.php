<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Growth Record Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-6xl space-y-8 sm:px-6 lg:px-8">

            {{-- ====================================== --}}
            {{-- Section 1 : Hero Header --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-50 via-white to-white shadow-sm">

                <div class="p-8">

                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left Content --}}
                        <div class="flex items-start gap-5">

                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-8 w-8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M15.75 19.5L8.25 12l7.5-7.5" />

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 3v18" />

                                </svg>

                            </div>

                            <div>

                                <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                                    Growth Record Details
                                </h1>

                                <p class="mt-2 text-gray-600">
                                    Review infant growth measurements, anthropometric records,
                                    and developmental monitoring information documented during
                                    this health assessment.
                                </p>

                            </div>

                        </div>

                        {{-- Infant Information Card --}}
                        <div class="w-full rounded-2xl border border-pink-200 bg-white p-6 shadow-sm lg:max-w-sm">

                            <div class="mb-4 flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-6 w-6">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75a17.933 17.933 0 01-7.5-1.632Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-sm font-medium uppercase tracking-wide text-pink-600">
                                        Infant Information
                                    </p>

                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $growthMonitoring->infant->first_name }}
                                        {{ $growthMonitoring->infant->last_name }}
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-3 border-t border-gray-100 pt-4">

                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-gray-500">
                                        Date Measured
                                    </span>

                                    <span class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}
                                    </span>

                                </div>

                                <div class="flex items-center justify-between">

                                    <span class="text-sm text-gray-500">
                                        Age
                                    </span>

                                    <span class="font-semibold text-pink-600">
                                        {{ $growthMonitoring->age_in_months }} month(s)
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 2 : Action Toolbar --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Growth Record Summary --}}
                    <div class="grid flex-1 grid-cols-1 gap-4 sm:grid-cols-3">

                        {{-- Date Measured --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M8.25 6.75V4.5m7.5 2.25V4.5M3.75 9.75h16.5M5.25 21h13.5A2.25 2.25 0 0021 18.75V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Date Measured
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Age --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0Z"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Age
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ $growthMonitoring->age_in_months }} month(s)
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Weight --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-pink-100 text-pink-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 3v18m9-9H3"/>

                                    </svg>

                                </div>

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                        Weight
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-900">
                                        {{ number_format($growthMonitoring->weight,2) }} kg
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('infants.show', $growthMonitoring->infant) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>

                            </svg>

                            Back to Infant

                        </a>

                        <a
                            href="{{ route('growth-monitorings.edit', $growthMonitoring) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

                            </svg>

                            Edit

                        </a>

                        <form
                            action="{{ route('growth-monitorings.destroy', $growthMonitoring) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this growth record?')"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor"
                                     class="h-5 w-5">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5"/>

                                </svg>

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>


                        {{-- ====================================== --}}
            {{-- Section 3 : Growth Measurements --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Card Header --}}
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
                                      d="M3.75 6.75h16.5M6.75 3.75v16.5m10.5-16.5v16.5" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Growth Measurements
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Anthropometric measurements recorded during the infant's growth monitoring visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="p-8">

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                        {{-- Date Measured --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Date Measured
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($growthMonitoring->date_measured)->format('F d, Y') }}
                            </p>

                        </div>

                        {{-- Age --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Age
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $growthMonitoring->age_in_months }} month(s)
                            </p>

                        </div>

                        {{-- Weight --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Weight
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ number_format($growthMonitoring->weight,2) }} kg
                            </p>

                        </div>

                        {{-- Height --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                            <p class="text-sm font-medium text-gray-500">
                                Height
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ number_format($growthMonitoring->height,2) }} cm
                            </p>

                        </div>

                        {{-- Head Circumference --}}
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 md:col-span-2 lg:col-span-2">

                            <p class="text-sm font-medium text-gray-500">
                                Head Circumference
                            </p>

                            <p class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $growthMonitoring->head_circumference
                                    ? number_format($growthMonitoring->head_circumference,2).' cm'
                                    : '-' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

                        {{-- ====================================== --}}
            {{-- Section 4 : Remarks --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Card Header --}}
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
                                      d="M7.5 8.25h9m-9 3h6m-8.25 8.25h13.5A2.25 2.25 0 0021 17.25V6.75A2.25 2.25 0 0018.75 4.5H5.25A2.25 2.25 0 003 6.75v10.5A2.25 2.25 0 005.25 19.5Z" />

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Clinical Remarks
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Healthcare provider observations, recommendations, and additional notes recorded during the infant's growth monitoring visit.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Card Body --}}
                <div class="space-y-8 p-8">

                    {{-- Remarks --}}
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50">

                        <div class="border-b border-gray-200 px-6 py-4">

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-pink-600">
                                Remarks
                            </h3>

                        </div>

                        <div class="px-6 py-6">

                            <p class="whitespace-pre-line leading-7 text-gray-700">
                                {{ $growthMonitoring->remarks ?: '-' }}
                            </p>

                        </div>

                    </div>

                    {{-- Record Summary --}}
                    <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6">

                        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                            <div>

                                <h3 class="text-lg font-semibold text-pink-700">
                                    Growth Record Management
                                </h3>

                                <p class="mt-1 text-sm text-pink-600">
                                    Review this growth monitoring record carefully. You may return to the
                                    infant profile, edit the measurements, or permanently delete this
                                    record if necessary.
                                </p>

                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row">

                                <a
                                    href="{{ route('infants.show', $growthMonitoring->infant) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>

                                    </svg>

                                    Back to Infant

                                </a>

                                <a
                                    href="{{ route('growth-monitorings.edit', $growthMonitoring) }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor"
                                         class="h-5 w-5">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M16.862 4.487a2.625 2.625 0 113.712 3.713L7.5 21H3v-4.5L16.862 4.487Z"/>

                                    </svg>

                                    Edit Record

                                </a>

                                <form
                                    action="{{ route('growth-monitorings.destroy', $growthMonitoring) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this growth record?')"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             class="h-5 w-5">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M6 7.5h12m-9.75 0v10.125a1.125 1.125 0 001.125 1.125h5.25a1.125 1.125 0 001.125-1.125V7.5M9.75 7.5V6.375A1.125 1.125 0 0110.875 5.25h2.25a1.125 1.125 0 011.125 1.125V7.5" />

                                        </svg>

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>