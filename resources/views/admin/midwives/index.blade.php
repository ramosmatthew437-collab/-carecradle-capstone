<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Midwife Management
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- SECTION 1 : SUCCESS ALERT --}}
            {{-- ====================================== --}}

            @if(session('success'))

                <div class="overflow-hidden rounded-2xl border border-green-200 bg-white shadow-sm">
                    <div class="flex items-start gap-4 border-l-4 border-green-500 px-5 py-4 sm:px-6 sm:py-5">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-xs sm:text-sm font-semibold uppercase tracking-wide text-green-700">Success</h3>
                            <p class="mt-1 text-sm leading-6 text-gray-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>

            @endif

            {{-- ====================================== --}}
            {{-- SECTION 2 : HEADER --}}
            {{-- ====================================== --}}

            <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-6 shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9.75h.008v.008h-.008V9.75Zm-3.75 0h.008v.008H12V9.75Zm-3.75 0h.008v.008H8.25V9.75Z" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-widest text-pink-600">Healthcare Workforce</p>
                        <h1 class="mt-0.5 text-lg sm:text-2xl font-bold text-gray-900">Midwife Management</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage registered midwives and their access to the CareCradle system.
                        </p>
                    </div>

                </div>

                <a href="{{ route('midwives.create') }}"
                   class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Register Midwife
                </a>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 3 : SUMMARY STATISTICS --}}
            {{-- ====================================== --}}

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />
                            </svg>
                        </div>
                        <span class="rounded-full bg-pink-50 px-2 py-0.5 text-[11px] font-semibold text-pink-600">Total</span>
                    </div>
                    <h3 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">{{ $totalMidwives }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Registered healthcare staff</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-600">Active</span>
                    </div>
                    <h3 class="mt-4 text-3xl font-bold tracking-tight text-emerald-600">{{ $activeMidwives }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Currently providing services</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <span class="rounded-full bg-red-50 px-2 py-0.5 text-[11px] font-semibold text-red-600">Inactive</span>
                    </div>
                    <h3 class="mt-4 text-3xl font-bold tracking-tight text-red-600">{{ $inactiveMidwives }}</h3>
                    <p class="mt-1 text-sm text-gray-500">Accounts currently disabled</p>
                </div>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 4 : SEARCH --}}
            {{-- ====================================== --}}

            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">

                <form method="GET" action="{{ route('midwives.index') }}">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        <div class="relative w-full lg:max-w-xl">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"/>
                                </svg>
                            </div>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search username, name, contact number, email..."
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-12 pr-24 sm:pr-28 text-sm text-gray-700 placeholder-gray-400 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">

                            <button
                                type="submit"
                                class="absolute right-2 top-2 rounded-xl bg-pink-600 px-4 sm:px-5 py-2 text-sm font-semibold text-white transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500">
                                Search
                            </button>

                        </div>

                        {{-- Status legend (visual reference only — matches the badges below, not a live filter) --}}
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-3.5 py-1.5 text-xs font-medium text-gray-600">All Midwives</span>
                            <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3.5 py-1.5 text-xs font-medium text-emerald-700">Active</span>
                            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3.5 py-1.5 text-xs font-medium text-red-700">Inactive</span>
                        </div>

                    </div>

                    @if(request('search'))
                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('midwives.index') }}"
                               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0112.89-5.303M19.5 4.5v6h-6"/>
                                </svg>
                                Reset Search
                            </a>
                        </div>
                    @endif

                </form>

            </div>

            {{-- ====================================== --}}
            {{-- SECTION 5 : MIDWIFE LIST --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-4 sm:px-6 sm:py-5">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Registered Midwives</h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Manage healthcare professionals assigned to the Rural Health Unit.</p>
                        </div>
                        <span class="w-fit inline-flex items-center rounded-full bg-pink-50 px-3 py-1 text-xs sm:text-sm font-semibold text-pink-700">
                            @if(request('search'))
                                Showing {{ $midwives->count() }} of {{ $totalMidwives }} Records
                            @else
                                {{ $totalMidwives }} Records
                            @endif
                        </span>
                    </div>
                </div>

                @if($midwives->count())

                    {{-- Desktop table --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Username</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Full Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Contact Number</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Email Address</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($midwives as $midwife)
                                    <tr class="transition duration-200 hover:bg-gray-50">

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <p class="font-semibold text-gray-900">{{ $midwife->username }}</p>
                                            <p class="text-sm text-gray-500">System Account</p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-pink-100 text-sm font-semibold text-pink-700">
                                                    {{ strtoupper(substr($midwife->first_name, 0, 1) . substr($midwife->last_name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 truncate">
                                                        {{ trim($midwife->first_name.' '.$midwife->middle_name.' '.$midwife->last_name) }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">Registered Midwife</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-gray-700">
                                            {{ $midwife->contact_number ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-gray-700">
                                            {{ $midwife->email ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-5 text-center">
                                            @if($midwife->is_active)
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                    <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5">
                                            <div class="flex items-center justify-center gap-2">

                                                <a href="{{ route('midwives.edit', $midwife->id) }}"
                                                   aria-label="Edit {{ $midwife->username }}"
                                                   class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-amber-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                                    </svg>
                                                    Edit
                                                </a>

                                                @if($midwife->is_active)
                                                    <form action="{{ route('midwives.destroy', $midwife->id) }}" method="POST" onsubmit="return confirm('Deactivate this midwife?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                aria-label="Deactivate {{ $midwife->username }}"
                                                                class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                            </svg>
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('midwives.activate', $midwife->id) }}" method="POST" onsubmit="return confirm('Activate this midwife?')">
                                                        @csrf
                                                        <button type="submit"
                                                                aria-label="Activate {{ $midwife->username }}"
                                                                class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                                            </svg>
                                                            Activate
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile / tablet cards --}}
                    <div class="lg:hidden divide-y divide-gray-100">
                        @foreach($midwives as $midwife)
                            <div class="p-4 sm:p-5">

                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 min-w-0">
                                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-pink-100 text-sm font-semibold text-pink-700">
                                            {{ strtoupper(substr($midwife->first_name, 0, 1) . substr($midwife->last_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">
                                                {{ trim($midwife->first_name.' '.$midwife->middle_name.' '.$midwife->last_name) }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">{{ $midwife->username }}</p>
                                        </div>
                                    </div>

                                    @if($midwife->is_active)
                                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="flex-shrink-0 inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-xs text-gray-400">Contact Number</p>
                                        <p class="text-gray-700 font-medium truncate">{{ $midwife->contact_number ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Email</p>
                                        <p class="text-gray-700 font-medium truncate">{{ $midwife->email ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2">

                                    <a href="{{ route('midwives.edit', $midwife->id) }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-amber-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
                                        Edit
                                    </a>

                                    @if($midwife->is_active)
                                        <form action="{{ route('midwives.destroy', $midwife->id) }}" method="POST" onsubmit="return confirm('Deactivate this midwife?')" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('midwives.activate', $midwife->id) }}" method="POST" onsubmit="return confirm('Activate this midwife?')" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                                                Activate
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            </div>
                        @endforeach
                    </div>

                @else

                    {{-- ====================================== --}}
                    {{-- SECTION 6 : EMPTY STATE --}}
                    {{-- ====================================== --}}

                    <div class="px-5 py-12 sm:px-6 sm:py-16">
                        <div class="flex flex-col items-center justify-center text-center">

                            <div class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-2xl bg-pink-50 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.742.78A9 9 0 0 0 12 3a9 9 0 0 0-9 9c0 1.846.556 3.562 1.508 4.99L3 21l4.01-1.508A8.963 8.963 0 0 0 12 21c1.249 0 2.44-.254 3.522-.712" />
                                </svg>
                            </div>

                            <h3 class="mt-5 sm:mt-6 text-lg sm:text-xl font-semibold text-gray-900">No Registered Midwives</h3>

                            <p class="mt-2 max-w-md text-sm leading-6 text-gray-500">
                                There are currently no registered midwives in the CareCradle system.
                                Add a healthcare provider to begin managing midwife accounts for the
                                Rural Health Unit.
                            </p>

                            <div class="mt-6 sm:mt-8">
                                <a href="{{ route('midwives.create') }}"
                                   class="inline-flex h-11 items-center gap-2 rounded-xl bg-pink-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Register Midwife
                                </a>
                            </div>

                        </div>
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>