<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Register Mother
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8 space-y-6">

            {{-- ====================================== --}}
            {{-- HERO HEADER --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-white p-5 sm:p-8 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-pink-100/60 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-12 right-24 h-32 w-32 rounded-full bg-pink-50 blur-2xl"></div>

                <div class="relative flex items-start gap-4">

                    <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white shadow-md shadow-pink-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.742-.479 3 3 0 00-4.682-2.72m.94 3.198v.75A2.25 2.25 0 0115.75 21H8.25A2.25 2.25 0 016 18.75V18m12-6a3 3 0 11-6 0 3 3 0 016 0Zm-9 0a3 3 0 11-6 0 3 3 0 016 0Zm9 0v.01M6 12v.01"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-600">
                            Maternal Health Management
                        </p>
                        <h1 class="mt-1 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                            Register a New Mother
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                            Create a maternal health record and portal account so this mother's prenatal
                            visits, appointments, and infant records can be tracked from day one.
                        </p>
                    </div>

                </div>

            </div>

            {{-- ====================================== --}}
            {{-- VALIDATION ERRORS --}}
            {{-- ====================================== --}}

            @if ($errors->any())
                <div class="overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">
                    <div class="flex items-start gap-3 sm:gap-4 px-4 py-4 sm:px-6 sm:py-5">
                        <div class="flex h-9 w-9 sm:h-10 sm:w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-red-800">
                                {{ $errors->count() }} {{ Str::plural('issue', $errors->count()) }} need{{ $errors->count() === 1 ? 's' : '' }} your attention
                            </h3>
                            <ul class="mt-2 space-y-1 text-sm leading-6 text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-1.5">
                                        <span class="mt-1.5 h-1 w-1 flex-shrink-0 rounded-full bg-red-500"></span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ====================================== --}}
            {{-- FORM --}}
            {{-- ====================================== --}}

            <form action="{{ route('mothers.store') }}" method="POST" class="space-y-6">

                @csrf

                @include('admin.mothers._form')

                {{-- ====================================== --}}
                {{-- ACTIONS — sticky on mobile, inline on desktop --}}
                {{-- ====================================== --}}

                <div class="sticky bottom-0 z-10 -mx-4 border-t border-gray-200 bg-white/95 px-4 py-3 backdrop-blur sm:static sm:z-auto sm:mx-0 sm:border-0 sm:bg-transparent sm:px-0 sm:py-0">
                    <div class="flex gap-3 sm:justify-start">

                        <button
                            type="submit"
                            class="flex h-12 flex-1 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98] sm:flex-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Register Mother
                        </button>

                        <a
                            href="{{ route('mothers.index') }}"
                            class="flex h-12 flex-1 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 active:scale-[0.98] sm:flex-none">
                            Cancel
                        </a>

                    </div>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>