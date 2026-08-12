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
                            type="password"
                            name="password"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                            placeholder="Enter temporary password"
                            required>

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
                            type="password"
                            name="password_confirmation"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                            placeholder="Re-enter password"
                            required>

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
                    Record the patient's demographic and contact information.
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

            {{-- Barangay --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Barangay <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="barangay"
                    value="{{ old('barangay', $mother->barangay ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter barangay"
                    required>

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
                    value="{{ old('last_menstrual_period', $mother->last_menstrual_period ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                @error('last_menstrual_period')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Expected Delivery Date --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Expected Delivery Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="expected_delivery_date"
                    value="{{ old('expected_delivery_date', $mother->expected_delivery_date ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    required>

                @error('expected_delivery_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pregnancy Number --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Pregnancy Number <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    min="1"
                    name="pregnancy_number"
                    value="{{ old('pregnancy_number', $mother->pregnancy_number ?? '') }}"
                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-100"
                    placeholder="Enter pregnancy number"
                    required>

                @error('pregnancy_number')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if(isset($mother))
                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Status <span class="text-red-500">*</span>
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

                        <option value="Referred"
                            @selected(old('status', $mother->status) == 'Referred')>
                            Referred
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

        </div>

    </div>

</section>