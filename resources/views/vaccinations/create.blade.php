<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💉 Add Vaccination Record
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

            

                <form action="{{ route('vaccinations.store', $infant) }}" method="POST">

                    @csrf

                    {{-- ====================================== --}}
{{-- Section 1 : Hero Header --}}
{{-- Place INSIDE the <form>, immediately after @csrf --}}
{{-- ====================================== --}}

<div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-pink-600 via-pink-600 to-pink-700 shadow-sm">

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
                            d="M9 12.75 11.25 15 15 9.75m6.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                    </svg>

                </div>

                <div>

                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Add Vaccination Record
                    </h1>

                    <p class="mt-2 text-base text-pink-100">
                        Infant Immunization Electronic Medical Record
                    </p>

                    <p class="mt-4 max-w-3xl text-sm leading-7 text-pink-100/90">
                        Record a new vaccination for the selected infant.
                        This information will become part of the child's
                        permanent Electronic Medical Record and will support
                        immunization tracking, vaccine scheduling, and public
                        health monitoring.
                    </p>

                </div>

            </div>

            <div class="lg:w-72">

                <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">

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
                                    d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0"/>

                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-pink-100">
                                Record Date
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
{{-- Section 2 : Validation Error Card --}}
{{-- Place directly BELOW the Hero Header --}}
{{-- Still INSIDE the <form> --}}
{{-- ====================================== --}}

@if ($errors->any())

    <div class="mb-8 overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-red-200 bg-red-50 px-6 py-5">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-red-600">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m0 3.75h.008v.008H12v-.008Zm9-3.758a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-lg font-semibold text-red-700">
                        Unable to Save Vaccination Record
                    </h2>

                    <p class="mt-1 text-sm text-red-600">
                        Please correct the validation errors below before saving this immunization record.
                    </p>

                </div>

            </div>

        </div>

        {{-- Body --}}
        <div class="p-6">

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                <ul class="space-y-3">

                    @foreach ($errors->all() as $error)

                        <li class="flex items-start gap-3">

                            <div class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-red-100">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="h-4 w-4 text-red-600">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"/>

                                </svg>

                            </div>

                            <span class="text-sm leading-6 text-red-700">
                                {{ $error }}
                            </span>

                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif

{{-- ====================================== --}}
{{-- Section 3 : Vaccination Form --}}
{{-- Place directly BELOW the Validation Error Card --}}
{{-- Still INSIDE the <form> --}}
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
                        d="M9 12.75 11.25 15 15 9.75m6.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-gray-900">
                    Vaccination Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Complete the immunization details to update the infant's Electronic Medical Record.
                </p>

            </div>

        </div>

    </div>

    {{-- Form Body --}}
    <div class="p-8">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Vaccine Name --}}
            <div>

                <label for="vaccine_name" class="mb-2 block text-sm font-semibold text-gray-700">
                    Vaccine Name
                </label>

                <select
                    id="vaccine_name"
                    name="vaccine_name"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

                    <option value="">Select Vaccine</option>

                    <option value="BCG">BCG</option>
                    <option value="Hepatitis B">Hepatitis B</option>
                    <option value="Pentavalent">Pentavalent</option>
                    <option value="OPV">OPV</option>
                    <option value="IPV">IPV</option>
                    <option value="PCV">PCV</option>
                    <option value="MMR">MMR</option>
                    <option value="Measles">Measles</option>

                </select>

            </div>

            {{-- Dose --}}
            <div>

                <label for="dose" class="mb-2 block text-sm font-semibold text-gray-700">
                    Dose
                </label>

                <select
                    id="dose"
                    name="dose"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

                    <option value="">Select Dose</option>

                    <option value="Birth Dose">Birth Dose</option>
                    <option value="1st Dose">1st Dose</option>
                    <option value="2nd Dose">2nd Dose</option>
                    <option value="3rd Dose">3rd Dose</option>
                    <option value="Booster">Booster</option>

                </select>

            </div>

            {{-- Date Given --}}
            <div>

                <label for="date_given" class="mb-2 block text-sm font-semibold text-gray-700">
                    Date Given
                </label>

                <input
                    id="date_given"
                    type="date"
                    name="date_given"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

            </div>

            {{-- Next Due Date --}}
            <div>

                <label for="next_due_date" class="mb-2 block text-sm font-semibold text-gray-700">
                    Next Due Date
                </label>

                <input
                    id="next_due_date"
                    type="date"
                    name="next_due_date"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

            </div>

            {{-- Administered By --}}
            <div class="md:col-span-2">

                <label for="administered_by" class="mb-2 block text-sm font-semibold text-gray-700">
                    Administered By
                </label>

                <input
                    id="administered_by"
                    type="text"
                    name="administered_by"
                    placeholder="e.g. Midwife Maria Santos"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

            </div>

            {{-- Remarks --}}
            <div class="md:col-span-2">

                <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                    Remarks
                </label>

                <textarea
                    id="remarks"
                    name="remarks"
                    rows="5"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm transition duration-200 focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    placeholder="Enter additional vaccination notes (optional)..."></textarea>

            </div>

        </div>

    </div>

</div>

{{-- ====================================== --}}
{{-- Section 4 : Action Buttons --}}
{{-- Place directly BELOW the Vaccination Form --}}
{{-- KEEP THIS INSIDE THE <form> --}}
{{-- DO NOT close </form> until AFTER this section --}}
{{-- ====================================== --}}

<div class="mt-8 flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

    {{-- Information --}}
    <div class="flex items-start gap-3 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3">

        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 9h1.5v3.75h-1.5V9Zm0 5.25h1.5v1.5h-1.5v-1.5Zm9.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

            </svg>

        </div>

        <div>

            <p class="text-sm font-semibold text-gray-900">
                Review Before Saving
            </p>

            <p class="mt-1 text-sm leading-6 text-gray-600">
                Ensure the vaccine, dose, administration date, and healthcare provider information are accurate before saving this vaccination record.
            </p>

        </div>

    </div>

    {{-- Buttons --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row">

        {{-- Cancel --}}
        <a
            href="{{ route('infants.show', $infant) }}"
            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 hover:bg-gray-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 19.5L8.25 12l7.5-7.5"/>

            </svg>

            Cancel

        </a>

        {{-- Save Vaccination --}}
        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75m6.75-2.25a9 9 0 11-18 0 9 9 0 0118 0Z"/>

            </svg>

            Save Vaccination

        </button>

    </div>

</div>

</form>

</div>

</div>

</div>

</x-app-layout>


