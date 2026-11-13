
<x-app-layout>
    <div class="min-h-screen bg-[#fff7fa] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            <a href="{{ route('mothers.show', $mother->id) }}"
               class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-pink-700 hover:text-pink-900">
                <span aria-hidden="true">&larr;</span>
                Back to Mother Profile
            </a>

            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-pink-600">
                    Maternal Health
                </p>

                <h1 class="mt-2 text-3xl font-bold text-[#a20e50]"
                    style="font-family: 'DM Serif Display', Georgia, serif;">
                    Edit Maternal Vaccination
                </h1>

                <p class="mt-2 text-sm text-gray-600">
                    Update the vaccination details in the mother's health history.
                </p>
            </div>

            <div class="mb-6 rounded-2xl border border-pink-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Mother
                </p>

                <h2 class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $mother->name ?? trim(($mother->first_name ?? '') . ' ' . ($mother->last_name ?? '')) }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Mother ID: {{ $mother->id }}
                </p>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Please check the following fields:</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('midwife.maternal-vaccinations.update', [$mother->id, $vaccination->id]) }}"
                  class="space-y-6 rounded-2xl border border-pink-100 bg-white p-5 shadow-sm sm:p-8">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    @include('midwife.maternal-vaccinations._vaccine-dose-fields', ['vaccination' => $vaccination])

                    <div>
                        <label for="date_given" class="mb-2 block text-sm font-semibold text-gray-700">
                            Date Given <span class="text-pink-600">*</span>
                        </label>

                        <input id="date_given"
                               name="date_given"
                               type="date"
                               value="{{ old('date_given', optional($vaccination->date_given)->format('Y-m-d')) }}"
                               max="{{ now()->toDateString() }}"
                               required
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">

                        @error('date_given')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="next_due_date" class="mb-2 block text-sm font-semibold text-gray-700">
                            Next Due Date
                        </label>

                        <input id="next_due_date"
                               name="next_due_date"
                               type="date"
                               value="{{ old('next_due_date', optional($vaccination->next_due_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">

                        <p class="mt-1 text-xs text-gray-500">
                            Leave blank if no follow-up date is scheduled.
                        </p>

                        @error('next_due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="administered_by" class="mb-2 block text-sm font-semibold text-gray-700">
                            Administered By <span class="text-pink-600">*</span>
                        </label>

                        <input id="administered_by"
                               name="administered_by"
                               type="text"
                               value="{{ old('administered_by', $vaccination->administered_by) }}"
                               maxlength="255"
                               required
                               placeholder="Name of health worker"
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">

                        @error('administered_by')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="remarks" class="mb-2 block text-sm font-semibold text-gray-700">
                            Remarks
                        </label>

                        <textarea id="remarks"
                                  name="remarks"
                                  rows="4"
                                  maxlength="5000"
                                  placeholder="Optional notes about the vaccination"
                                  class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('remarks', $vaccination->remarks) }}</textarea>

                        @error('remarks')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-pink-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('mothers.show', $mother->id) }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-300">
                        Update Vaccination Record
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
