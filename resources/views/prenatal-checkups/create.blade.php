<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Prenatal Visit
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

            @if ($errors->any())
    <div class="mb-6 rounded-lg bg-red-100 border border-red-400 text-red-700 p-4">
        <strong>Validation Errors:</strong>

        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                {{-- Mother Information --}}
                <h2 class="text-2xl font-bold mb-2">
                    {{ $mother->first_name }} {{ $mother->last_name }}
                </h2>

                <p class="text-pink-600 font-semibold mb-6">
                    {{ $mother->mother_code }}
                </p>

             <form action="{{ route('prenatal-checkups.store', $mother->id) }}" method="POST">

    @csrf

                    {{-- ========================= --}}
                    {{-- Visit Information --}}
                    {{-- ========================= --}}

                    <h2 class="text-xl font-bold mb-4">
                        Visit Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium">Visit Date</label>

                            <input
    type="date"
    name="visit_date"
    value="{{ old('visit_date') }}"
    class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Gestational Age (Weeks)
                            </label>

                            <input
                                type="number"
                                name="gestational_age_weeks"
                                class="w-full border rounded-lg p-2">
                        </div>

                    </div>

                    <hr class="my-8">

                    {{-- ========================= --}}
                    {{-- Maternal Assessment --}}
                    {{-- ========================= --}}

                    <h2 class="text-xl font-bold mb-4">
                        Maternal Assessment
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium">
                                Weight (kg)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="weight"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Fundal Height (cm)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="fundal_height"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Systolic Blood Pressure
                            </label>

                            <input
                                type="number"
                                name="systolic_bp"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Diastolic Blood Pressure
                            </label>

                            <input
                                type="number"
                                name="diastolic_bp"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Fetal Heart Rate (bpm)
                            </label>

                            <input
                                type="number"
                                name="fetal_heart_rate"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Fetal Movement
                            </label>

                            <select
                                name="fetal_movement"
                                class="w-full border rounded-lg p-2">

                               <option value="">Select</option>
<option value="Normal">Normal</option>
<option value="Reduced">Reduced</option>
<option value="Not Yet Felt">Not Yet Felt</option>

                            </select>

                        </div>

                    </div>

                    <hr class="my-8">

                    {{-- ========================= --}}
                    {{-- Laboratory Findings --}}
                    {{-- ========================= --}}

                    <h2 class="text-xl font-bold mb-4">
                        Laboratory Findings
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium">
                                Urine Protein
                            </label>

                            <select
                                name="urine_protein"
                                class="w-full border rounded-lg p-2">

                              <option value="">Select</option>
<option value="Negative">Negative</option>
<option value="Trace">Trace</option>
<option value="+1">+1</option>
<option value="+2">+2</option>
<option value="+3">+3</option>

                            </select>

                        </div>

                        <div>
                            <label class="font-medium">
                                Urine Glucose
                            </label>

                            <select
                                name="urine_glucose"
                                class="w-full border rounded-lg p-2">

                              <option value="">Select</option>
<option value="Negative">Negative</option>
<option value="Trace">Trace</option>
<option value="+1">+1</option>
<option value="+2">+2</option>
<option value="+3">+3</option>

                            </select>

                        </div>

                    </div>

                    <hr class="my-8">

                    {{-- ========================= --}}
                    {{-- Assessment --}}
                    {{-- ========================= --}}

                    <h2 class="text-xl font-bold mb-4">
                        Assessment
                    </h2>

                    <div>

                        <label class="font-medium">
                            Maternal Condition
                        </label>

                        <textarea
                            name="maternal_condition"
                            rows="3"
                            class="w-full border rounded-lg p-2"></textarea>

                    </div>

                    <div class="mt-4">

                        <label class="font-medium">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            rows="3"
                            class="w-full border rounded-lg p-2"></textarea>

                    </div>

                    <hr class="my-8">

                    {{-- ========================= --}}
                    {{-- Follow-up --}}
                    {{-- ========================= --}}

                    <h2 class="text-xl font-bold mb-4">
                        Follow-up
                    </h2>

                    <div>

                        <label class="font-medium">
                            Next Visit Date
                        </label>

                        <input
                            type="date"
                            name="next_visit_date"
                            class="w-full border rounded-lg p-2">

                    </div>

                    <div class="mt-8">

                        <button
                            type="submit"
                            class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg">

                            Save Prenatal Visit

                        </button>

                        <a
                            href="{{ route('mothers.show', $mother->id) }}"
                            class="ml-2 bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>