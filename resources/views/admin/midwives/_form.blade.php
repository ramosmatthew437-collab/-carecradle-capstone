{{-- ============================= --}}
{{-- 1. PERSONAL INFORMATION --}}
{{-- ============================= --}}
<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

    {{-- Header --}}
    <div class="border-b border-gray-100 bg-gray-50 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Personal Information</h2>
                <p class="mt-0.5 text-sm text-gray-500">The midwife's legal name and contact details.</p>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-5 sm:p-6">

        <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

            {{-- First Name --}}
            <div>
                <label for="first_name" class="mb-2 block text-sm font-semibold text-gray-700">
                    First Name <span class="text-red-500">*</span>
                </label>

                <input
                    id="first_name"
                    type="text"
                    name="first_name"
                    value="{{ old('first_name', $midwife->first_name ?? '') }}"
                    placeholder="Enter first name"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

                @error('first_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Middle Name --}}
            <div>
                <label for="middle_name" class="mb-2 block text-sm font-semibold text-gray-700">
                    Middle Name
                </label>

                <input
                    id="middle_name"
                    type="text"
                    name="middle_name"
                    value="{{ old('middle_name', $midwife->middle_name ?? '') }}"
                    placeholder="Enter middle name"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                @error('middle_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div>
                <label for="last_name" class="mb-2 block text-sm font-semibold text-gray-700">
                    Last Name <span class="text-red-500">*</span>
                </label>

                <input
                    id="last_name"
                    type="text"
                    name="last_name"
                    value="{{ old('last_name', $midwife->last_name ?? '') }}"
                    placeholder="Enter last name"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

                @error('last_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contact Number --}}
            <div>
                <label for="contact_number" class="mb-2 block text-sm font-semibold text-gray-700">
                    Contact Number
                </label>

                <input
                    id="contact_number"
                    type="text"
                    name="contact_number"
                    value="{{ old('contact_number', $midwife->contact_number ?? '') }}"
                    placeholder="09XXXXXXXXX"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                @error('contact_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="md:col-span-2">
                <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $midwife->email ?? '') }}"
                    placeholder="name@example.com"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100">

                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </div>

</section>

{{-- ============================= --}}
{{-- 2. ACCOUNT INFORMATION --}}
{{-- ============================= --}}
<section class="mt-6 sm:mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white">

    {{-- Header --}}
    <div class="border-b border-gray-100 bg-gray-50 px-5 py-5 sm:px-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5V12a1.5 1.5 0 011.5-1.5z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Account Information</h2>
                <p class="mt-0.5 text-sm text-gray-500">
                    @if(!isset($midwife))
                        Login credentials for accessing the CareCradle system.
                    @else
                        The midwife's system login username.
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-5 sm:p-6">

        <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

            {{-- Username --}}
            <div class="{{ !isset($midwife) ? '' : 'md:col-span-2' }}">
                <label for="username" class="mb-2 block text-sm font-semibold text-gray-700">
                    Username <span class="text-red-500">*</span>
                </label>

                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username', $midwife->username ?? '') }}"
                    placeholder="Enter username"
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                    required>

                @error('username')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if(!isset($midwife))

                {{-- Password --}}
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">
                        Password <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                        required>

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Re-enter password"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                        required>

                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            @endif

        </div>

    </div>

</section>