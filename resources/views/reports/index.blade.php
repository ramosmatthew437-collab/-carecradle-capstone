<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Reports
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- Header --}}
            {{-- ====================================== --}}

            <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:px-7 sm:py-6 shadow-sm">

                <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7.5 15l3-3 2.25 2.25L17.25 9"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Reports &amp; Analytics</p>
                    <h1 class="mt-0.5 text-lg sm:text-2xl font-bold text-gray-900">CareCradle Reports</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Generate and review maternal and infant healthcare reports for the Rural Health Unit.
                    </p>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- Report Cards --}}
            {{-- ====================================== --}}

            <div>

                <div class="mb-4 sm:mb-5">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Choose a Report</h2>
                    <p class="mt-1 text-sm text-gray-500">Select a category to view its detailed report.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:gap-5 md:grid-cols-2">

                    {{-- Appointment Report --}}
                    <a href="{{ route('reports.appointments') }}"
                       class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition duration-200 hover:border-amber-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M4.5 5.25h15a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75v-12a1.5 1.5 0 011.5-1.5Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900">Appointment Report</h3>
                                <p class="mt-1.5 text-sm leading-6 text-gray-500">
                                    Generate detailed reports of scheduled prenatal, postnatal, and maternal healthcare appointments.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-1.5 border-t border-gray-100 pt-4 text-sm font-semibold text-amber-600">
                            View Report
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4 transition group-hover:translate-x-1" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                    </a>

                    {{-- Mother Report --}}
                    <a href="{{ route('reports.mothers') }}"
                       class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition duration-200 hover:border-pink-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-50 text-pink-600 transition group-hover:bg-pink-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900">Mother Report</h3>
                                <p class="mt-1.5 text-sm leading-6 text-gray-500">
                                    View and export comprehensive maternal health records and registered mother information.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-1.5 border-t border-gray-100 pt-4 text-sm font-semibold text-pink-600">
                            View Report
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4 transition group-hover:translate-x-1" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                    </a>

                    {{-- Infant Report --}}
                    <a href="{{ route('reports.infants') }}"
                       class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372A9.337 9.337 0 0021 18.842m-6-9.592a3 3 0 11-6 0 3 3 0 016 0Zm-9.003 9.75a9.712 9.712 0 0112.006 0"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900">Infant Report</h3>
                                <p class="mt-1.5 text-sm leading-6 text-gray-500">
                                    Access infant registration records, growth monitoring information, and healthcare data.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-1.5 border-t border-gray-100 pt-4 text-sm font-semibold text-blue-600">
                            View Report
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4 transition group-hover:translate-x-1" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                    </a>

                    {{-- Vaccination Report --}}
                    <a href="{{ route('reports.vaccinations') }}"
                       class="group flex flex-col rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition duration-200 hover:border-emerald-200 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5 12 18l-3.75-3.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900">Vaccination Report</h3>
                                <p class="mt-1.5 text-sm leading-6 text-gray-500">
                                    Review vaccination history, immunization schedules, and administered vaccine records.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-1.5 border-t border-gray-100 pt-4 text-sm font-semibold text-emerald-600">
                            View Report
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4 w-4 transition group-hover:translate-x-1" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                    </a>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>