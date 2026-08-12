<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vaccination Record Details
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-8">

                <h1 class="text-2xl font-bold mb-6">
                    💉 Vaccination Details
                </h1>

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <strong>Infant</strong><br>
                        {{ $vaccination->infant->first_name }}
                        {{ $vaccination->infant->last_name }}
                    </div>

                    <div>
                        <strong>Vaccine</strong><br>
                        {{ $vaccination->vaccine_name }}
                    </div>

                    <div>
                        <strong>Dose</strong><br>
                        {{ $vaccination->dose }}
                    </div>

                    <div>
                        <strong>Date Given</strong><br>
                        {{ \Carbon\Carbon::parse($vaccination->date_given)->format('F d, Y') }}
                    </div>

                    <div>
                        <strong>Next Due Date</strong><br>

                        {{ $vaccination->next_due_date
                            ? \Carbon\Carbon::parse($vaccination->next_due_date)->format('F d, Y')
                            : '-' }}
                    </div>

                    <div>
                        <strong>Administered By</strong><br>
                        {{ $vaccination->administered_by }}
                    </div>

                    <div class="col-span-2">
                        <strong>Remarks</strong><br>
                        {{ $vaccination->remarks ?: '-' }}
                    </div>

                </div>

                <hr class="my-8">

                <div class="flex gap-3">

                    <a
                        href="{{ route('infants.show', $vaccination->infant) }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">

                        ← Back to Infant

                    </a>

                    <a
                        href="{{ route('vaccinations.edit', $vaccination) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">

                        ✏ Edit

                    </a>

                    <form
                        action="{{ route('vaccinations.destroy', $vaccination) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Delete this vaccination record?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                            🗑 Delete

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>