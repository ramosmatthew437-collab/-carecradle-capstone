<x-app-layout>

<div class="py-8">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div class="overflow-hidden rounded-2xl border border-purple-100 bg-white shadow-sm">

            <div class="flex items-center justify-between p-8">

                <div>

                    <p class="text-sm font-semibold uppercase tracking-widest text-purple-600">
                        Mother Portal
                    </p>

                    <h1 class="mt-2 text-4xl font-bold text-gray-900">
                        Vaccination Records
                    </h1>

                    <p class="mt-3 max-w-2xl text-gray-500">
                        View your infant's vaccination history and upcoming immunizations.
                    </p>

                </div>

                <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-purple-100 text-5xl">
                    💉
                </div>

            </div>

        </div>

        {{-- Vaccination Table --}}
        <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

                <h2 class="text-xl font-bold text-gray-900">
                    Vaccination Records
                </h2>

            </div>

            @if($vaccinations->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Vaccine
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Dose
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Date Given
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Next Due Date
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                    @foreach($vaccinations as $vaccination)

                        <tr>

                            <td class="px-6 py-5">
                                {{ $vaccination->vaccine_name }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $vaccination->dose }}
                            </td>

                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($vaccination->date_given)->format('F d, Y') }}
                            </td>

                            <td class="px-6 py-5">

                                @if($vaccination->next_due_date)

                                    {{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('F d, Y') }}

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <div class="p-6">

                {{ $vaccinations->links() }}

            </div>

            @else

            <div class="p-12 text-center">

                <div class="text-6xl">
                    💉
                </div>

                <h3 class="mt-4 text-xl font-bold text-gray-900">
                    No Vaccination Records
                </h3>

                <p class="mt-2 text-gray-500">
                    No vaccination records found.
                </p>

            </div>

            @endif

        </div>

    </div>

</div>

</x-app-layout>