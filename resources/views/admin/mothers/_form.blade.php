@if(!isset($mother))
    {{-- ============================= --}}
    {{-- ACCOUNT INFORMATION --}}
    {{-- ============================= --}}
    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gradient-to-r from-pink-50 via-white to-white px-6 py-5">
            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-1.5 0h12a1.5 1.5 0 011.5 1.5v7.5a1.5 1.5 0 01-1.5 1.5h-12A1.5 1.5 0 014.5 19.5V12a1.5 1.5 0 011.5-1.5z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Account Information
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Create secure login credentials for the mother's portal.
                    </p>
                </div>

            </div>
        </div>

        {{-- Body --}}
        <div class="p-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Username --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Username
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                            placeholder="Enter username"
                            required>

                    </div>

                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Initial Password --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Initial Password
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 5.25a3 3 0 013 3m-3-3a3 3 0 00-3 3m3-3h3m-3 0v3m-6.75 4.5l-4.5 4.5m0 0H3m1.5 0v-1.5m0 1.5h1.5"/>
                            </svg>
                        </div>

                        <input
                            id="mother-initial-password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-12 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                            placeholder="Enter temporary password"
                            required>

                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-pink-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-inset"
                            data-password-toggle="mother-initial-password"
                            aria-label="Show initial password"
                            aria-pressed="false">
                            <svg data-eye-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.58 10.59a2 2 0 0 0 2.83 2.83"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.24A10.8 10.8 0 0 1 12 5.04c6.25 0 9.75 6.96 9.75 6.96a17.5 17.5 0 0 1-3.03 3.83M6.61 6.61C3.78 8.34 2.25 12 2.25 12s3.5 6.96 9.75 6.96c1.2 0 2.28-.26 3.25-.69"/>
                            </svg>
                        </button>

                    </div>

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Confirm Password
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="h-5 w-5">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 12.75 11.25 15 15 9.75m6 2.25c0 5.523-3.84 10.29-9 11.623C6.84 22.29 3 17.523 3 12V5.741c0-.339.224-.636.55-.733l8.25-2.475a.75.75 0 01.4 0l8.25 2.475a.75.75 0 01.55.733V12Z"/>
                            </svg>
                        </div>

                        <input
                            id="mother-confirm-password"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-12 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                            placeholder="Re-enter password"
                            required>

                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-pink-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-inset"
                            data-password-toggle="mother-confirm-password"
                            aria-label="Show confirmation password"
                            aria-pressed="false">
                            <svg data-eye-open xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg data-eye-closed xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18M10.58 10.59a2 2 0 0 0 2.83 2.83"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.24A10.8 10.8 0 0 1 12 5.04c6.25 0 9.75 6.96 9.75 6.96a17.5 17.5 0 0 1-3.03 3.83M6.61 6.61C3.78 8.34 2.25 12 2.25 12s3.5 6.96 9.75 6.96c1.2 0 2.28-.26 3.25-.69"/>
                            </svg>
                        </button>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <div class="my-8 border-t border-gray-200"></div>
@endif

{{-- ============================= --}}
{{-- PERSONAL INFORMATION --}}
{{-- ============================= --}}
<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="border-b border-gray-200 bg-gradient-to-r from-pink-50 via-white to-white px-6 py-5">
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Personal Information
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Record the mother's demographic and contact information.
                </p>
            </div>

        </div>
    </div>

    {{-- Body --}}
    <div class="p-6">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- First Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    First Name <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="first_name"
                    value="{{ old('first_name', $mother->first_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter first name"
                    required>

                @error('first_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Middle Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Middle Name
                </label>

                <input
                    type="text"
                    name="middle_name"
                    value="{{ old('middle_name', $mother->middle_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter middle name">
            </div>

            {{-- Last Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Last Name <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="last_name"
                    value="{{ old('last_name', $mother->last_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter last name"
                    required>

                @error('last_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Birth Date --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Birth Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="birth_date"
                    value="{{ old('birth_date', $mother->birth_date ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                @error('birth_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contact Number --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Contact Number <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="contact_number"
                    value="{{ old('contact_number', $mother->contact_number ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="09XXXXXXXXX"
                    required>

                @error('contact_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Barangay: searchable Irosin suggestions; any barangay or location can still be typed --}}
            @php
                $irosinBarangays = [
                    'Bacolod (Poblacion)', 'Bagsangan', 'Batang', 'Bolos', 'Buenavista', 'Bulawan', 'Carriedo',
                    'Casini', 'Cawayan', 'Cogon', 'Gabao', 'Gulang-Gulang', 'Gumapia', 'Liang', 'Macawayan',
                    'Mapaso', 'Monbon', 'Patag', 'Salvacion', 'San Agustin', 'San Isidro', 'San Juan (Poblacion)',
                    'San Julian (Poblacion)', 'San Pedro (Poblacion)', 'Santo Domingo (Lamboon)', 'Tabon-Tabon',
                    'Tinampo', 'Tongdol',
                ];
                $barangayValue = old('barangay', $mother->barangay ?? '');
                $normalizeBarangay = fn ($v) => mb_strtolower(preg_replace('/\s+/', ' ', trim((string) $v)));
                $isIrosinBarangay = in_array($normalizeBarangay($barangayValue), array_map($normalizeBarangay, $irosinBarangays), true);
            @endphp
            <div>
                <label for="barangay" class="mb-2 block text-sm font-semibold text-gray-700">
                    Barangay <span class="text-red-500">*</span>
                </label>

                <div class="cc-combo" data-cc-combo>
                    <input
                        type="text"
                        id="barangay"
                        name="barangay"
                        value="{{ $barangayValue }}"
                        class="cc-combo-input w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                        placeholder="Search or type a barangay"
                        autocomplete="off"
                        role="combobox"
                        aria-autocomplete="list"
                        aria-expanded="false"
                        aria-controls="barangay-listbox"
                        aria-describedby="barangay-help barangay-postal"
                        required>

                    <button type="button"
                            class="cc-combo-toggle"
                            tabindex="-1"
                            aria-label="Show barangay suggestions"
                            data-cc-combo-toggle
                            hidden>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>

                    <ul id="barangay-listbox"
                        class="cc-combo-list"
                        role="listbox"
                        aria-label="Irosin barangays"
                        hidden>
                        @foreach ($irosinBarangays as $index => $irosinBarangay)
                            <li id="barangay-option-{{ $index }}"
                                class="cc-combo-option"
                                role="option"
                                aria-selected="false"
                                data-value="{{ $irosinBarangay }}">{{ $irosinBarangay }}</li>
                        @endforeach
                        <li class="cc-combo-empty" role="presentation" data-cc-combo-empty hidden>
                            Not in the Irosin list. Your entry will be saved as typed.
                        </li>
                    </ul>
                </div>

                <p id="barangay-help" class="cc-combo-help">
                    Choose an Irosin barangay, or type another barangay or location.
                </p>

                {{-- Postal code is a hint only; it is not stored with the record. --}}
                <p id="barangay-postal" class="cc-combo-postal" data-cc-combo-postal aria-live="polite" @unless($isIrosinBarangay) hidden @endunless>
                    Postal code: 4707 (Irosin, Sorsogon)
                </p>

                @error('barangay')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Blood Type --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Blood Type <span class="text-red-500">*</span>
                </label>

                <select
                    name="blood_type"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                    <option value="">Select Blood Type</option>

                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                        <option
                            value="{{ $type }}"
                            @selected(old('blood_type', $mother->blood_type ?? '') == $type)>
                            {{ $type }}
                        </option>
                    @endforeach

                </select>

                @error('blood_type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Complete Address <span class="text-red-500">*</span>
                </label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="House No., Street, Sitio/Purok, Barangay, Municipality"
                    required>{{ old('address', $mother->address ?? '') }}</textarea>

                @error('address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </div>

</section>

<div class="my-8 border-t border-gray-200"></div>



{{-- ============================= --}}
{{-- FATHER'S INFORMATION --}}
{{-- ============================= --}}
<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="border-b border-gray-200 bg-gradient-to-r from-pink-50 via-white to-white px-6 py-5">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Father's Information
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Record the father's details for the mother's maternal health record.
                </p>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Father's First Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's First Name
                </label>
                <input
                    type="text"
                    name="father_first_name"
                    value="{{ old('father_first_name', $mother->father_first_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter father's first name">

                @error('father_first_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Father's Middle Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's Middle Name
                </label>
                <input
                    type="text"
                    name="father_middle_name"
                    value="{{ old('father_middle_name', $mother->father_middle_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter father's middle name (optional)">

                @error('father_middle_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Father's Last Name --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's Last Name
                </label>
                <input
                    type="text"
                    name="father_last_name"
                    value="{{ old('father_last_name', $mother->father_last_name ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter father's last name">

                @error('father_last_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Father's Birth Date --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's Birth Date
                </label>
                <input
                    type="date"
                    name="father_birth_date"
                    value="{{ old('father_birth_date', $mother->father_birth_date ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100">

                @error('father_birth_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Father's Contact Number --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's Contact Number
                </label>
                <input
                    type="text"
                    name="father_contact_number"
                    value="{{ old('father_contact_number', $mother->father_contact_number ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="09XXXXXXXXX">

                @error('father_contact_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Father's Occupation --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Father's Occupation
                </label>
                <input
                    type="text"
                    name="father_occupation"
                    value="{{ old('father_occupation', $mother->father_occupation ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter father's occupation">

                @error('father_occupation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>
</section>

<div class="my-8 border-t border-gray-200"></div>

{{-- ============================= --}}
{{-- PREGNANCY INFORMATION --}}
{{-- ============================= --}}
<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- Header --}}
    <div class="border-b border-gray-200 bg-gradient-to-r from-pink-50 via-white to-white px-6 py-5">
        <div class="flex items-center gap-4">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-100 text-pink-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
                </svg>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Pregnancy Information
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Record maternal health details for prenatal monitoring and follow-up.
                </p>
            </div>

        </div>
    </div>

    {{-- Body --}}
    <div class="p-6">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            {{-- Civil Status --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Civil Status <span class="text-red-500">*</span>
                </label>

                <select
                    name="civil_status"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                    <option value="">Select Civil Status</option>

                    @foreach(['Single','Married','Widowed','Separated'] as $status)
                        <option
                            value="{{ $status }}"
                            @selected(old('civil_status', $mother->civil_status ?? '') == $status)>
                            {{ $status }}
                        </option>
                    @endforeach

                </select>

                @error('civil_status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Occupation --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Occupation
                </label>

                <input
                    type="text"
                    name="occupation"
                    value="{{ old('occupation', $mother->occupation ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter occupation">

                @error('occupation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- PhilHealth --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    PhilHealth Number
                </label>

                <input
                    type="text"
                    name="philhealth_number"
                    value="{{ old('philhealth_number', $mother->philhealth_number ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter PhilHealth number">

                @error('philhealth_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Height --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Height (cm) <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="height"
                    value="{{ old('height', $mother->height ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="e.g. 160"
                    required>

                @error('height')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Weight --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Weight (kg) <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="weight"
                    value="{{ old('weight', $mother->weight ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="e.g. 55"
                    required>

                @error('weight')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Menstrual Period --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Last Menstrual Period <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="last_menstrual_period"
                    id="last_menstrual_period"
                    value="{{ old('last_menstrual_period', $mother->last_menstrual_period ?? '') }}"
                    max="{{ now()->toDateString() }}"
                    data-edd-lmp
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                @error('last_menstrual_period')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Expected Delivery Date --}}
            @php
                $eddValue = old('expected_delivery_date', $mother->expected_delivery_date ?? '');
                $eddInitial = old('edd_initial', $mother->expected_delivery_date ?? '');
                $eddLmpValue = old('last_menstrual_period', $mother->last_menstrual_period ?? '');
                $eddCalculated = rescue(fn () => \App\Models\Mother::calculateExpectedDeliveryDate($eddLmpValue ?: null), null, false);
                $eddDiffers = filled($eddValue) && $eddCalculated && $eddValue !== $eddCalculated;
            @endphp
            <div>
                <div class="mb-2 flex flex-wrap items-center justify-between gap-x-3 gap-y-1">
                    <label for="expected_delivery_date" class="block text-sm font-semibold text-gray-700">
                        Expected Delivery Date
                    </label>

                    <span class="cc-edd-badge" data-edd-badge @unless($eddDiffers) hidden @endunless>
                        Adjusted — differs from LMP + 280 days
                    </span>
                </div>

                {{-- Automatic from the LMP (also calculated on the server) unless the
                     midwife adjusts it. edd_initial lets the server tell an
                     intentional change from an untouched field. --}}
                <input type="hidden" name="edd_initial" value="{{ $eddInitial }}" data-edd-initial>

                <input
                    type="date"
                    name="expected_delivery_date"
                    id="expected_delivery_date"
                    value="{{ $eddValue }}"
                    data-edd-output
                    data-original-lmp="{{ $mother->last_menstrual_period ?? '' }}"
                    data-original-edd="{{ $mother->expected_delivery_date ?? '' }}"
                    aria-describedby="expected_delivery_date_help expected_delivery_date_status"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100">

                <div class="cc-edd-meta">
                    <p id="expected_delivery_date_help" class="text-xs text-gray-500">
                        Automatically calculated from LMP + 280 days. You may adjust this date when clinically necessary.
                    </p>

                    <button type="button" class="cc-edd-link" data-edd-recalc hidden>
                        Recalculate from LMP
                    </button>
                </div>

                {{-- Shown when the LMP changes after a manual adjustment. --}}
                <div class="cc-edd-prompt" data-edd-prompt role="group" aria-labelledby="expected_delivery_date_prompt" hidden>
                    <p id="expected_delivery_date_prompt">
                        The LMP changed. Recalculate the expected delivery date to
                        <strong data-edd-prompt-date></strong> (LMP + 280 days), or keep your adjusted date?
                    </p>
                    <div class="cc-edd-prompt-actions">
                        <button type="button" class="cc-edd-prompt-primary" data-edd-prompt-recalc>Recalculate</button>
                        <button type="button" class="cc-edd-prompt-secondary" data-edd-prompt-keep>Keep my date</button>
                    </div>
                </div>

                <p id="expected_delivery_date_status" class="cc-edd-sr" aria-live="polite" data-edd-status></p>

                @error('expected_delivery_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pregnancy History (Gravida) — stored in pregnancy_number --}}
            <div>
                <label for="pregnancy_number" class="mb-2 block text-sm font-semibold text-gray-700">
                    Pregnancy History (Gravida) <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    min="1"
                    step="1"
                    inputmode="numeric"
                    name="pregnancy_number"
                    id="pregnancy_number"
                    value="{{ old('pregnancy_number', $mother->pregnancy_number ?? '') }}"
                    aria-describedby="pregnancy_number_help"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="e.g. 1 for a first pregnancy"
                    required>

                <p id="pregnancy_number_help" class="mt-2 text-xs text-gray-500">
                    Total number of pregnancies, including the current one (at least 1).
                </p>

                @error('pregnancy_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if(isset($mother))
                {{-- Pregnancy status: full-width row. Referral is recorded separately
                     on the mother's profile (Referral card). --}}
                <div class="md:col-span-2 border-t border-gray-100 pt-5">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Pregnancy Status <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                        required>

                        <option value="Pregnant"
                            @selected(old('status', $mother->status) == 'Pregnant')>
                            Pregnant
                        </option>

                        <option value="Delivered"
                            @selected(old('status', $mother->status) == 'Delivered')>
                            Delivered
                        </option>

                        {{-- Older records only: keeps a legacy "Referred" value (pregnancy
                             status unknown) until the RHU confirms Pregnant or Delivered. --}}
                        @if ($mother->isLegacyReferred())
                            <option value="Referred"
                                @selected(old('status', $mother->status) == 'Referred')>
                                Unknown (older Referred record) - keep as is
                            </option>
                        @endif

                    </select>

                    <p class="mt-2 text-xs text-gray-500">
                        Referrals are recorded on the mother's profile and do not change her pregnancy status.
                    </p>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

        </div>

    </div>

</section>


@once
    <script>
        // Expected delivery date: LMP + 280 days, editable by the midwife.
        // Mirrors the server rule (ResolvesExpectedDeliveryDate): a changed LMP
        // recalculates the EDD; on edit, the recorded LMP shows the recorded EDD.
        // After a manual adjustment in this form, an LMP change asks first
        // instead of overwriting the adjusted date.
        (() => {
            const lmpInput = document.querySelector('[data-edd-lmp]');
            const eddInput = document.querySelector('[data-edd-output]');

            if (!lmpInput || !eddInput) return;

            const initialInput = document.querySelector('[data-edd-initial]');
            const badge = document.querySelector('[data-edd-badge]');
            const recalcButton = document.querySelector('[data-edd-recalc]');
            const prompt = document.querySelector('[data-edd-prompt]');
            const promptDate = document.querySelector('[data-edd-prompt-date]');
            const promptRecalc = document.querySelector('[data-edd-prompt-recalc]');
            const promptKeep = document.querySelector('[data-edd-prompt-keep]');
            const status = document.querySelector('[data-edd-status]');

            const originalLmp = eddInput.dataset.originalLmp || '';
            const originalEdd = eddInput.dataset.originalEdd || '';
            const isDate = (value) => /^\d{4}-\d{2}-\d{2}$/.test(value);

            const calculate = (lmp) => {
                if (!isDate(lmp)) return '';
                const [year, month, day] = lmp.split('-').map(Number);
                const date = new Date(Date.UTC(year, month - 1, day));
                date.setUTCDate(date.getUTCDate() + 280);
                return date.toISOString().slice(0, 10);
            };

            // The automatic value for the current LMP (the recorded EDD while
            // the LMP equals the recorded LMP on the edit form).
            const automatic = () => {
                const lmp = lmpInput.value;
                if (originalLmp && originalEdd && lmp === originalLmp) return originalEdd;
                return calculate(lmp);
            };

            const formatDate = (value) => {
                if (!isDate(value)) return value;
                const [year, month, day] = value.split('-').map(Number);
                return new Date(Date.UTC(year, month - 1, day)).toLocaleDateString(undefined, {
                    year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC',
                });
            };

            const announce = (message) => { if (status) status.textContent = message; };

            // Adjusted in this form session (also true after a validation
            // round-trip that returned a manual value).
            let manual = eddInput.value !== ''
                && eddInput.value !== (initialInput ? initialInput.value : '')
                && eddInput.value !== automatic();

            const refresh = () => {
                const calculated = calculate(lmpInput.value);
                const differs = eddInput.value !== '' && calculated !== '' && eddInput.value !== calculated;
                if (badge) badge.hidden = !differs;
                if (recalcButton) recalcButton.hidden = !differs;
            };

            const hidePrompt = () => { if (prompt) prompt.hidden = true; };

            const recalculate = () => {
                eddInput.value = calculate(lmpInput.value);
                manual = false;
                hidePrompt();
                refresh();
                announce(eddInput.value
                    ? 'Expected delivery date recalculated to ' + formatDate(eddInput.value) + '.'
                    : 'Enter the last menstrual period to calculate the expected delivery date.');
            };

            const onLmpChange = () => {
                if (!isDate(lmpInput.value)) {
                    if (!manual) eddInput.value = '';
                    hidePrompt();
                    refresh();
                    return;
                }

                const next = automatic();

                if (manual && eddInput.value !== next) {
                    if (prompt) {
                        if (promptDate) promptDate.textContent = formatDate(calculate(lmpInput.value));
                        prompt.hidden = false;
                    }
                    refresh();
                    return;
                }

                eddInput.value = next;
                manual = false;
                hidePrompt();
                refresh();
            };

            eddInput.addEventListener('input', () => {
                manual = eddInput.value !== '' && eddInput.value !== automatic();
                hidePrompt();
                refresh();
            });

            lmpInput.addEventListener('change', onLmpChange);
            lmpInput.addEventListener('input', onLmpChange);

            if (recalcButton) recalcButton.addEventListener('click', recalculate);
            if (promptRecalc) promptRecalc.addEventListener('click', recalculate);
            if (promptKeep) {
                promptKeep.addEventListener('click', () => {
                    hidePrompt();
                    announce('Kept the adjusted expected delivery date.');
                    eddInput.focus();
                });
            }

            // First load: fill an empty EDD from the LMP (no-JS forms are
            // calculated on the server instead).
            if (eddInput.value === '' && isDate(lmpInput.value)) {
                eddInput.value = automatic();
            }

            refresh();
        })();

        (() => {
            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
                if (button.dataset.toggleReady === 'true') return;

                const input = document.getElementById(button.dataset.passwordToggle);
                if (!input) return;

                button.dataset.toggleReady = 'true';

                button.addEventListener('click', () => {
                    const willShow = input.type === 'password';

                    input.type = willShow ? 'text' : 'password';
                    button.setAttribute('aria-pressed', String(willShow));
                    button.setAttribute(
                        'aria-label',
                        willShow ? 'Hide password' : 'Show password'
                    );

                    const openEye = button.querySelector('[data-eye-open]');
                    const closedEye = button.querySelector('[data-eye-closed]');

                    if (openEye) openEye.classList.toggle('hidden', willShow);
                    if (closedEye) closedEye.classList.toggle('hidden', !willShow);
                });
            });
        })();
    </script>
@endonce

{{-- =====================================================
     BARANGAY COMBOBOX
     Enhances the barangay text input with filterable Irosin
     suggestions (ARIA combobox, list autocomplete). Without
     JavaScript it stays a plain text input. Any typed value is
     kept and submitted as-is; the 4707 postal code is a hint only.
     ===================================================== --}}
@once
    <style>
        .cc-combo {
            position: relative;
        }

        .cc-combo .cc-combo-input.cc-combo-enhanced {
            padding-right: 2.75rem;
        }

        .cc-combo-toggle {
            position: absolute;
            top: 50%;
            right: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            color: #9ca3af;
            background: transparent;
            border: 0;
            border-radius: 0.625rem;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .cc-combo-toggle:hover {
            color: #be185d;
            background: #fdf2f8;
        }

        .cc-combo-toggle svg {
            width: 1rem;
            height: 1rem;
            transition: transform 0.15s ease;
        }

        .cc-combo.is-open .cc-combo-toggle svg {
            transform: rotate(180deg);
        }

        .cc-combo-list {
            position: absolute;
            top: calc(100% + 0.375rem);
            left: 0;
            right: 0;
            z-index: 40;
            max-height: 16rem;
            margin: 0;
            padding: 0.375rem;
            overflow-y: auto;
            overscroll-behavior: contain;
            list-style: none;
            background: #ffffff;
            border: 1px solid #fbcfe8;
            border-radius: 1rem;
            box-shadow: 0 12px 32px -8px rgba(157, 23, 77, 0.18), 0 2px 6px rgba(15, 23, 42, 0.06);
        }

        .cc-combo-option {
            padding: 0.5625rem 0.75rem;
            color: #1f2937;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            line-height: 1.35;
            cursor: pointer;
        }

        .cc-combo-option:hover {
            background: #fdf2f8;
        }

        .cc-combo-option.is-active {
            color: #9d174d;
            background: #fce7f3;
        }

        .cc-combo-option.is-current {
            font-weight: 600;
        }

        .cc-combo-empty {
            padding: 0.625rem 0.75rem;
            color: #6b7280;
            font-size: 0.8125rem;
            line-height: 1.45;
        }

        .cc-combo-help {
            margin: 0.375rem 0 0;
            color: #6b7280;
            font-size: 0.75rem;
            line-height: 1.45;
        }

        .cc-combo-postal {
            display: inline-flex;
            align-items: center;
            margin: 0.5rem 0 0;
            padding: 0.25rem 0.625rem;
            color: #9d174d;
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .cc-combo-postal[hidden],
        .cc-combo-list[hidden],
        .cc-combo-toggle[hidden],
        .cc-combo-empty[hidden],
        .cc-combo-option[hidden] {
            display: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .cc-combo-toggle svg {
                transition: none;
            }
        }
    </style>

    <script>
        (function () {
            var normalize = function (value) {
                return String(value || '')
                    .normalize('NFD').replace(/[̀-ͯ]/g, '')
                    .replace(/\s+/g, ' ').trim().toLowerCase();
            };

            document.querySelectorAll('[data-cc-combo]').forEach(function (combo) {
                var input = combo.querySelector('[role="combobox"]');
                var list = combo.querySelector('[role="listbox"]');
                var toggle = combo.querySelector('[data-cc-combo-toggle]');
                var empty = combo.querySelector('[data-cc-combo-empty]');
                var field = combo.parentElement;
                var postal = field ? field.querySelector('[data-cc-combo-postal]') : null;
                var options = Array.prototype.slice.call(list.querySelectorAll('[role="option"]'));
                var official = options.map(function (option) { return normalize(option.dataset.value); });
                var activeIndex = -1;

                input.classList.add('cc-combo-enhanced');
                if (toggle) { toggle.hidden = false; }

                var visibleOptions = function () {
                    return options.filter(function (option) { return !option.hidden; });
                };

                var updatePostal = function () {
                    if (postal) { postal.hidden = official.indexOf(normalize(input.value)) === -1; }
                };

                var setActive = function (option) {
                    options.forEach(function (o) {
                        o.classList.remove('is-active');
                        o.setAttribute('aria-selected', 'false');
                    });
                    if (option) {
                        option.classList.add('is-active');
                        option.setAttribute('aria-selected', 'true');
                        input.setAttribute('aria-activedescendant', option.id);
                        option.scrollIntoView({ block: 'nearest' });
                    } else {
                        input.removeAttribute('aria-activedescendant');
                    }
                };

                var filter = function (query) {
                    var q = normalize(query);
                    var current = normalize(input.value);
                    var shown = 0;
                    options.forEach(function (option) {
                        var match = q === '' || normalize(option.dataset.value).indexOf(q) !== -1;
                        option.hidden = !match;
                        option.classList.toggle('is-current', normalize(option.dataset.value) === current);
                        if (match) { shown++; }
                    });
                    if (empty) { empty.hidden = shown !== 0; }
                };

                var open = function () {
                    if (!list.hidden) { return; }
                    list.hidden = false;
                    combo.classList.add('is-open');
                    input.setAttribute('aria-expanded', 'true');
                };

                var close = function () {
                    list.hidden = true;
                    combo.classList.remove('is-open');
                    input.setAttribute('aria-expanded', 'false');
                    activeIndex = -1;
                    setActive(null);
                };

                var choose = function (option) {
                    input.value = option.dataset.value;
                    close();
                    updatePostal();
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                };

                var move = function (step) {
                    var shown = visibleOptions();
                    if (!shown.length) { setActive(null); return; }
                    activeIndex = activeIndex + step;
                    if (activeIndex < 0) { activeIndex = shown.length - 1; }
                    if (activeIndex >= shown.length) { activeIndex = 0; }
                    setActive(shown[activeIndex]);
                };

                input.addEventListener('input', function () {
                    filter(input.value);
                    activeIndex = -1;
                    setActive(null);
                    open();
                    updatePostal();
                });

                input.addEventListener('keydown', function (event) {
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        if (list.hidden) { filter(''); open(); }
                        if (!event.altKey) { move(1); }
                    } else if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        if (event.altKey) { close(); return; }
                        if (list.hidden) { filter(''); open(); }
                        move(-1);
                    } else if (event.key === 'Enter') {
                        var shown = visibleOptions();
                        if (!list.hidden && activeIndex >= 0 && shown[activeIndex]) {
                            event.preventDefault();
                            choose(shown[activeIndex]);
                        } else if (!list.hidden) {
                            close();
                        }
                    } else if (event.key === 'Escape') {
                        if (!list.hidden) {
                            event.preventDefault();
                            close();
                        }
                    } else if (event.key === 'Tab') {
                        close();
                    }
                });

                input.addEventListener('blur', function () {
                    window.setTimeout(close, 120);
                });

                list.addEventListener('mousedown', function (event) {
                    event.preventDefault(); // keep focus in the input
                });

                list.addEventListener('click', function (event) {
                    var option = event.target.closest('[role="option"]');
                    if (option) { choose(option); }
                });

                if (toggle) {
                    toggle.addEventListener('mousedown', function (event) { event.preventDefault(); });
                    toggle.addEventListener('click', function () {
                        if (list.hidden) {
                            filter('');
                            open();
                            input.focus();
                        } else {
                            close();
                        }
                    });
                }

                updatePostal();
            });
        })();
    </script>
@endonce

{{-- Expected delivery date: adjusted badge, recalculate action, LMP-change prompt --}}
@once
    <style>
        .cc-edd-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.5rem;
            color: #92400e;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 999px;
            font-size: 0.6875rem;
            font-weight: 600;
            line-height: 1.5;
        }

        .cc-edd-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.25rem 0.75rem;
            margin-top: 0.5rem;
        }

        .cc-edd-meta p {
            flex: 1 1 14rem;
            margin: 0;
            line-height: 1.5;
        }

        .cc-edd-link {
            flex: 0 0 auto;
            padding: 0;
            color: #be185d;
            background: none;
            border: 0;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.5;
            text-decoration: underline;
            text-underline-offset: 2px;
            cursor: pointer;
        }

        .cc-edd-link:hover {
            color: #9d174d;
        }

        .cc-edd-link:focus-visible,
        .cc-edd-prompt button:focus-visible {
            outline: 3px solid rgba(236, 72, 153, 0.3);
            outline-offset: 2px;
            border-radius: 0.375rem;
        }

        .cc-edd-prompt {
            margin-top: 0.625rem;
            padding: 0.75rem 0.875rem;
            color: #78350f;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.875rem;
            font-size: 0.8125rem;
            line-height: 1.5;
        }

        .cc-edd-prompt p {
            margin: 0;
        }

        .cc-edd-prompt-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.625rem;
        }

        .cc-edd-prompt-primary,
        .cc-edd-prompt-secondary {
            min-height: 2.25rem;
            padding: 0.375rem 0.875rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
        }

        .cc-edd-prompt-primary {
            color: #ffffff;
            background: #be185d;
            border: 1px solid #be185d;
        }

        .cc-edd-prompt-primary:hover {
            background: #9d174d;
        }

        .cc-edd-prompt-secondary {
            color: #374151;
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }

        .cc-edd-prompt-secondary:hover {
            background: #f9fafb;
        }

        .cc-edd-sr {
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .cc-edd-badge[hidden],
        .cc-edd-link[hidden],
        .cc-edd-prompt[hidden] {
            display: none;
        }
    </style>
@endonce
