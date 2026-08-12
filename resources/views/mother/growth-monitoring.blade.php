<x-app-layout>

<div class="py-8">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div class="overflow-hidden rounded-2xl border border-green-100 bg-white shadow-sm">

            <div class="flex items-center justify-between p-8">

                <div>

                    <p class="text-sm font-semibold uppercase tracking-widest text-green-600">
                        Mother Portal
                    </p>

                    <h1 class="mt-2 text-4xl font-bold text-gray-900">
                        Growth Monitoring
                    </h1>

                    <p class="mt-3 max-w-2xl text-gray-500">
                        Track your baby's growth measurements and development records.
                    </p>

                </div>

                <div class="flex h-24 w-24 items-center justify-center rounded-3xl bg-green-100 text-5xl">
                    📈
                </div>

            </div>

        </div>

        {{-- Records --}}
        <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5">

                <h2 class="text-xl font-bold text-gray-900">
                    Growth Records
                </h2>

            </div>

            @if($growthRecords->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Date Measured
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Age (Months)
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Weight
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Height
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                                Head Circumference
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                    @foreach($growthRecords as $record)

                        <tr>

                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($record->date_measured)->format('F d, Y') }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $record->age_in_months }}
                            </td>

                            <td class="px-6 py-5">
                                {{ $record->weight }} kg
                            </td>

                            <td class="px-6 py-5">
                                {{ $record->height }} cm
                            </td>

                            <td class="px-6 py-5">
                                {{ $record->head_circumference }} cm
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <div class="p-6">
                {{ $growthRecords->links() }}
            </div>

            @else

            <div class="p-12 text-center">

                <div class="text-6xl">
                    📈
                </div>

                <h3 class="mt-4 text-xl font-bold text-gray-900">
                    No Growth Records
                </h3>

                <p class="mt-2 text-gray-500">
                    No growth monitoring records found.
                </p>

            </div>

            @endif

        </div>

    </div>

</div>

</x-app-layout>