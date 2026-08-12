<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Mother
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl p-6">
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-600 mb-2">
        Mother Code
    </label>

    <input
        type="text"
        value="{{ $mother->mother_code }}"
        class="w-full bg-gray-100 border border-gray-300 rounded-lg p-3 text-lg font-bold text-pink-600"
        readonly>
</div>
                



                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mothers.update', $mother->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    @include('admin.mothers._form')

                    <div class="mt-8 flex gap-3">

                        <button
                            type="submit"
                            class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg">

                            Update Mother

                        </button>

                        <a
                            href="{{ route('mothers.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>