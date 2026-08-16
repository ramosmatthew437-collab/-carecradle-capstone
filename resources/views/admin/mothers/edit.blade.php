<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Mother
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="mb-6 flex items-center gap-4">
                <div class="flex h-12 w-12 sm:h-14 sm:w-14 shrink-0 items-center justify-center rounded-2xl bg-pink-100 text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Maternal Records</p>
                    <h1 class="mt-0.5 truncate text-xl sm:text-2xl font-bold text-gray-900">Edit Mother Record</h1>
                </div>
            </div>

            {{-- ====================================== --}}
            {{-- MOTHER CODE (read-only identity strip) --}}
            {{-- ====================================== --}}

            <div class="mb-6 flex items-center justify-between gap-4 rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-50 to-white px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Mother Code
                    </label>
                    <input
                        type="text"
                        value="{{ $mother->mother_code }}"
                        class="mt-1 w-full border-0 bg-transparent p-0 font-mono text-lg sm:text-xl font-bold text-pink-600 focus:outline-none focus:ring-0"
                        readonly>
                </div>
                <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-gray-500 shadow-sm ring-1 ring-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    Locked
                </span>
            </div>

            {{-- ====================================== --}}
            {{-- VALIDATION ERRORS --}}
            {{-- ====================================== --}}

            @if ($errors->any())
                <div class="mb-6 overflow-hidden rounded-2xl border border-red-200 bg-red-50 shadow-sm">
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

            <form action="{{ route('mothers.update', $mother->id) }}" method="POST" class="space-y-6">

                @csrf
                @method('PUT')

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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            Update Mother
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