<x-app-layout>
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
 {{ Auth::user()->role == 'Administrator'
    ? 'CareCradle Administrator Dashboard'
    : 'CareCradle Midwife Dashboard' }}
</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">

                {{-- Welcome --}}
                <h1 class="text-3xl font-bold text-blue-700">
                    Welcome, {{ Auth::user()->name }}!
                </h1>

                <p class="mt-2 text-gray-600">
                    Role: <strong>{{ Auth::user()->role }}</strong>
                </p>

                <hr class="my-6">

                {{-- Dashboard Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                  <!-- Infants -->
<div class="bg-blue-100 p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold">
        👶 Infants
    </h3>

    <p class="text-3xl font-bold text-blue-700">
        {{ $infants }}
    </p>
</div>

                    <!-- Mothers -->
                    <div class="bg-pink-100 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-bold">
                            🤰 Mothers
                        </h3>

                        <p class="text-3xl font-bold text-pink-700">
                            {{ $mothers }}
                        </p>
                    </div>

                 <!-- Vaccinations -->
<div class="bg-green-100 p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold">
        💉 Vaccinations
    </h3>

    <p class="text-3xl font-bold text-green-700">
        {{ $vaccinations }}
    </p>
</div>

                    <!-- Upcoming Appointments -->
                    <div class="bg-yellow-100 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-bold">
                            📅 Upcoming Appointments
                        </h3>

                        <p class="text-3xl font-bold text-yellow-700">
                            {{ $appointments }}
                        </p>
                    </div>

                </div>
                {{-- Quick Actions --}}
<div class="mt-8">

    <h2 class="text-2xl font-bold mb-4">
        ⚡ Quick Actions
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Register Mother -->
        <a href="{{ route('mothers.create') }}"
           class="bg-pink-600 hover:bg-pink-700 text-white rounded-xl p-6 shadow transition duration-300 hover:shadow-xl">

            <div class="text-3xl mb-2">🤰</div>

            <h3 class="text-lg font-bold">
                Register Mother
            </h3>

            <p class="text-sm text-pink-100 mt-1">
                Add a new pregnant mother.
            </p>

        </a>

        <!-- Add Prenatal Visit -->
        <a href="{{ route('mothers.index') }}"
           class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-6 shadow transition duration-300 hover:shadow-xl">

            <div class="text-3xl mb-2">🩺</div>

            <h3 class="text-lg font-bold">
                Add Prenatal Visit
            </h3>

            <p class="text-sm text-green-100 mt-1">
                Select a mother to record a prenatal visit.
            </p>

        </a>

        <!-- Schedule Appointment -->
        <a href="{{ route('mothers.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-6 shadow transition duration-300 hover:shadow-xl">

            <div class="text-3xl mb-2">📅</div>

            <h3 class="text-lg font-bold">
                Schedule Appointment
            </h3>

            <p class="text-sm text-blue-100 mt-1">
                Select a mother to schedule an appointment.
            </p>

        </a>

    </div>

</div>

                {{-- Today's Appointments --}}
                <hr class="my-8">

                <h2 class="text-2xl font-bold mb-4">
                    📅 Today's Appointments
                </h2>

                <div class="bg-white border rounded-xl shadow overflow-hidden">

                    @if($todayAppointments->count())

                        <table class="min-w-full">

                            <thead class="bg-gray-100">

                                <tr>

                                    <th class="px-4 py-3 text-left">
                                        Time
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Mother
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Type
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Status
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($todayAppointments as $appointment)

                                    @php
                                        $statusClasses = match($appointment->status) {
                                            'Scheduled' => 'bg-blue-100 text-blue-700',
                                            'Completed' => 'bg-green-100 text-green-700',
                                            'Cancelled' => 'bg-red-100 text-red-700',
                                            'Missed' => 'bg-yellow-100 text-yellow-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <tr class="border-t">

                                        <td class="px-4 py-3">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $appointment->mother->first_name }}
                                            {{ $appointment->mother->last_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $appointment->appointment_type }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full font-semibold {{ $statusClasses }}">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="p-10 text-center">

                            <div class="text-5xl mb-3">
                                📅
                            </div>

                            <h3 class="text-lg font-semibold text-gray-700">
                                No Appointments Today
                            </h3>

                            <p class="text-gray-500 mt-2">
                                There are no scheduled appointments for today.
                            </p>

                        </div>

                    @endif
</div>


<hr class="my-8">

<h2 class="text-2xl font-bold mb-4">
    💉 Upcoming Vaccinations
</h2>

<div class="bg-white border rounded-xl shadow overflow-hidden">

    @if($upcomingVaccinations->count())

        <table class="min-w-full">

            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Infant</th>
                    <th class="px-4 py-3 text-left">Vaccine</th>
                    <th class="px-4 py-3 text-left">Next Due Date</th>
                </tr>
            </thead>

            <tbody>

                @foreach($upcomingVaccinations as $vaccination)

                    <tr class="border-t">

                        <!-- Infant -->
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">
                                👶 {{ $vaccination->infant->first_name }}
                                {{ $vaccination->infant->last_name }}
                            </div>

                            <div class="text-xs text-gray-500">
                                Upcoming Vaccine
                            </div>
                        </td>

                        <!-- Vaccine -->
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">
                                💉 {{ $vaccination->vaccine_name }}
                            </div>

                            <div class="text-xs text-gray-500">
                                Scheduled Dose
                            </div>
                        </td>

                        <!-- Next Due Date -->
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <div class="p-10 text-center">

            <div class="text-5xl mb-3">
                💉
            </div>

            <h3 class="text-lg font-semibold text-gray-700">
                No Upcoming Vaccinations
            </h3>

            <p class="text-gray-500 mt-2">
                Upcoming vaccination schedules will appear here.
            </p>

        </div>

    @endif

</div>

<hr class="my-8">

<h2 class="text-2xl font-bold mb-4">
    👶 Recent Infant Registrations
</h2>

<div class="bg-white border rounded-xl shadow overflow-hidden">

    @if($recentInfants->count())

        <table class="min-w-full">

            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Infant</th>
                    <th class="px-4 py-3 text-left">Mother</th>
                    <th class="px-4 py-3 text-left">Registered</th>
                </tr>
            </thead>

            <tbody>

                @foreach($recentInfants as $infant)

                    <tr class="border-t">
<td class="px-4 py-3">
    <div class="font-semibold text-gray-900">
        👶 {{ $infant->first_name }} {{ $infant->last_name }}
    </div>

    <div class="text-xs text-gray-500">
        Infant Record
    </div>
</td>

<td class="px-4 py-3">
    <div class="font-semibold text-gray-900">
        🤰 {{ $infant->mother->first_name }} {{ $infant->mother->last_name }}
    </div>

    <div class="text-xs text-gray-500">
        Registered Mother
    </div>
</td>

                        <td class="px-4 py-3">
                            {{ $infant->created_at->format('M d, Y') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <div class="p-10 text-center">

            <div class="text-5xl mb-3">👶</div>

            <h3 class="text-lg font-semibold text-gray-700">
                No Infant Records Yet
            </h3>

            <p class="text-gray-500 mt-2">
                Newly registered infants will appear here.
            </p>

        </div>

    @endif

</div>






            </div>

        </div>
    </div>

</x-app-layout>