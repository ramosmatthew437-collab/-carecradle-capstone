<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Schedule Appointment
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

                <h2 class="text-2xl font-bold mb-2">
                    {{ $mother->first_name }} {{ $mother->last_name }}
                </h2>

                <p class="text-pink-600 font-semibold mb-6">
                    {{ $mother->mother_code }}
                </p>

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('appointments.store', $mother->id) }}" method="POST">

                    @csrf

                    <h2 class="text-xl font-bold mb-4">
                        Appointment Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium">
                                Appointment Type
                            </label>

                            <select
                                name="appointment_type"
                                class="w-full border rounded-lg p-2">

                                <option value="">Select</option>

                                <option value="Prenatal Checkup">
                                    Prenatal Checkup
                                </option>

                                <option value="Vaccination">
                                    Vaccination
                                </option>

                                <option value="Postpartum Checkup">
                                    Postpartum Checkup
                                </option>

                            </select>
                        </div>

                        <div>
                            <label class="font-medium">
                                Appointment Date
                            </label>

                            <input
                                type="date"
                                name="appointment_date"
                                class="w-full border rounded-lg p-2">
                        </div>

                        <div>
                            <label class="font-medium">
                                Appointment Time
                            </label>

                            <input
                                type="time"
                                name="appointment_time"
                                class="w-full border rounded-lg p-2">
                        </div>

                    </div>

                    <div class="mt-6">

                        <label class="font-medium">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            rows="4"
                            class="w-full border rounded-lg p-2"></textarea>

                    </div>

                    <div class="mt-8">

                        <button
                            type="submit"
                            class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg">

                            Save Appointment

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