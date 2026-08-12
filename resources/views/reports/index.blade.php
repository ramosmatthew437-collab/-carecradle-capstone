<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Reports
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                              d="M3 3v18h18M7.5 15l3-3 2.25 2.25L17.25 9"/>
                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        CareCradle Reports
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Healthcare Reporting Center
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Access and generate comprehensive maternal and infant
                        healthcare reports for appointments, registered mothers,
                        infant records, and vaccination history within the
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
                                      d="M3 3v18h18M7.5 15l3-3 2.25 2.25L17.25 9"/>
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-medium uppercase tracking-wider text-pink-100">
                                Module
                            </p>

                            <p class="mt-1 text-sm font-semibold text-white">
                                Reports & Analytics
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>




{{-- ====================================== --}}
{{-- Report Cards --}}
{{-- ====================================== --}}
<div class="mt-8">

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Appointment Report --}}
        <a href="{{ route('reports.appointments') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-yellow-300 hover:shadow-md">

            <div class="p-7">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-8 w-8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-xl font-semibold text-gray-900">
                                Appointment Report
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Generate detailed reports of scheduled prenatal,
                                postnatal, and maternal healthcare appointments.
                            </p>

                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6 text-gray-400 transition group-hover:translate-x-1 group-hover:text-yellow-600">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>

                </div>

            </div>

        </a>

        {{-- Mother Report --}}
        <a href="{{ route('reports.mothers') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-pink-300 hover:shadow-md">

            <div class="p-7">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-8 w-8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-xl font-semibold text-gray-900">
                                Mother Report
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                View and export comprehensive maternal health
                                records and registered mother information.
                            </p>

                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6 text-gray-400 transition group-hover:translate-x-1 group-hover:text-pink-600">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>

                </div>

            </div>

        </a>

        {{-- Infant Report --}}
        <a href="{{ route('reports.infants') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-300 hover:shadow-md">

            <div class="p-7">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-8 w-8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-xl font-semibold text-gray-900">
                                Infant Report
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Access infant registration records, growth
                                monitoring information, and healthcare data.
                            </p>

                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6 text-gray-400 transition group-hover:translate-x-1 group-hover:text-blue-600">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>

                </div>

            </div>

        </a>

        {{-- Vaccination Report --}}
        <a href="{{ route('reports.vaccinations') }}"
           class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-green-300 hover:shadow-md">

            <div class="p-7">

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-green-100 text-green-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-8 w-8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-xl font-semibold text-gray-900">
                                Vaccination Report
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                Review vaccination history, immunization schedules,
                                and administered vaccine records.
                            </p>

                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6 text-gray-400 transition group-hover:translate-x-1 group-hover:text-green-600">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>

                </div>

            </div>

        </a>

    </div>

</div> 

</x-app-layout>