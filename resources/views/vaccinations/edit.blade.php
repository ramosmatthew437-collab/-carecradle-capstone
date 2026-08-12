<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Vaccination Record
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

                <form action="{{ route('vaccinations.update', $vaccination) }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Vaccine --}}
                    <div class="mb-5">

                        <label class="block font-medium mb-2">
                            Vaccine Name
                        </label>

                        <select name="vaccine_name"
                                class="w-full border rounded-lg p-3">

                            @foreach([
                                'BCG',
                                'Hepatitis B',
                                'Pentavalent',
                                'OPV',
                                'IPV',
                                'PCV',
                                'MMR',
                                'Measles'
                            ] as $vaccine)

                                <option
                                    value="{{ $vaccine }}"
                                    {{ old('vaccine_name', $vaccination->vaccine_name) == $vaccine ? 'selected' : '' }}>

                                    {{ $vaccine }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Dose --}}
                    <div class="mb-5">

                        <label class="block font-medium mb-2">
                            Dose
                        </label>

                        <select name="dose"
                                class="w-full border rounded-lg p-3">

                            @foreach([
                                'Birth Dose',
                                '1st Dose',
                                '2nd Dose',
                                '3rd Dose',
                                'Booster'
                            ] as $dose)

                                <option
                                    value="{{ $dose }}"
                                    {{ old('dose', $vaccination->dose) == $dose ? 'selected' : '' }}>

                                    {{ $dose }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Date Given --}}
                    <div class="mb-5">

                        <label class="block font-medium mb-2">
                            Date Given
                        </label>

                        <input
                            type="date"
                            name="date_given"
                            value="{{ old('date_given', $vaccination->date_given) }}"
                            class="w-full border rounded-lg p-3">

                    </div>

                    {{-- Next Due --}}
                    <div class="mb-5">

                        <label class="block font-medium mb-2">
                            Next Due Date
                        </label>

                        <input
                            type="date"
                            name="next_due_date"
                            value="{{ old('next_due_date', $vaccination->next_due_date) }}"
                            class="w-full border rounded-lg p-3">

                    </div>

                    {{-- Administered By --}}
                    <div class="mb-5">

                        <label class="block font-medium mb-2">
                            Administered By
                        </label>

                        <input
                            type="text"
                            name="administered_by"
                            value="{{ old('administered_by', $vaccination->administered_by) }}"
                            class="w-full border rounded-lg p-3">

                    </div>

                    {{-- Remarks --}}
                    <div class="mb-6">

                        <label class="block font-medium mb-2">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            rows="4"
                            class="w-full border rounded-lg p-3">{{ old('remarks', $vaccination->remarks) }}</textarea>

                    </div>

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                            Update Vaccination

                        </button>

                        <a
                            href="{{ route('vaccinations.show', $vaccination) }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>