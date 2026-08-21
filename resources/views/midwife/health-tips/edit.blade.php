<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Edit Health Tip
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-white p-5 sm:p-8 shadow-sm">

                <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-pink-100/60 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-12 right-24 h-32 w-32 rounded-full bg-pink-50 blur-2xl"></div>

                <div class="relative flex items-start gap-4">

                    <div class="flex h-14 w-14 sm:h-16 sm:w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-pink-600 text-white shadow-md shadow-pink-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a2.25 2.25 0 113.182 3.182L10.582 17.13a4.5 4.5 0 01-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-pink-600">
                            Health Education
                        </p>
                        <h1 class="mt-1 text-2xl sm:text-3xl font-bold tracking-tight text-gray-900">
                            Edit Health Tip
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-500">
                            Update this health education article for the CareCradle Health Tips Library.
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
            {{-- FORM CARD --}}
            {{-- ====================================== --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 sm:h-11 sm:w-11 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Health Tip Details</h2>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500">
                                Update the article title, category, and content below.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('midwife.health-tips.update', $healthTip) }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5 sm:gap-6 md:grid-cols-2">

                        {{-- Title --}}
                        <div class="md:col-span-2">
                            <label for="title" class="mb-2 block text-sm font-semibold text-gray-700">
                                Title <span class="text-red-500">*</span>
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title', $healthTip->title) }}"
                                placeholder="e.g. Eating Well During Pregnancy"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                required>

                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="md:col-span-2">
                            <label for="category" class="mb-2 block text-sm font-semibold text-gray-700">
                                Category <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="category"
                                name="category"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                required>

                                <option value="">Select a category</option>

                                @foreach([
                                    'Pregnancy Care',
                                    'Nutrition',
                                    'Danger Signs',
                                    'Preparing for Delivery',
                                    'Breastfeeding',
                                    'Newborn Care',
                                    'Vaccination',
                                    'Postpartum Care',
                                ] as $category)
                                    <option value="{{ $category }}" @selected(old('category', $healthTip->category) == $category)>
                                        {{ $category }}
                                    </option>
                                @endforeach

                            </select>

                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description" class="mb-2 block text-sm font-semibold text-gray-700">
                                Description <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="10"
                                placeholder="Write clear and easy-to-understand health information for mothers..."
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-4 text-sm leading-7 text-gray-900 shadow-sm placeholder:text-gray-400 transition focus:border-pink-500 focus:outline-none focus:ring-4 focus:ring-pink-100"
                                required>{{ old('description', $healthTip->description) }}</textarea>

                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="md:col-span-2">
                            <label for="image" class="mb-2 block text-sm font-semibold text-gray-700">
                                Image <span class="text-xs font-normal text-gray-400">(optional)</span>
                            </label>

                            @if(!empty($healthTip->image))
                                <div class="mb-3 flex items-center gap-4 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                    <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl bg-white shadow-sm">
                                        <img src="{{ asset('storage/' . $healthTip->image) }}" alt="{{ $healthTip->title }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-700">Current image</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Uploading a new image below will replace this one.</p>
                                    </div>
                                </div>
                            @endif

                            <label
                                for="image"
                                class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center transition hover:border-pink-300 hover:bg-pink-50/40">

                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75Z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ !empty($healthTip->image) ? 'Click to upload a replacement image' : 'Click to upload an image' }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-400">JPG, JPEG, PNG, or WEBP</p>
                                    @if(!empty($healthTip->image))
                                        <p class="mt-1 text-xs font-medium text-amber-600">Leave this empty to keep the current image.</p>
                                    @endif
                                </div>

                                <input
                                    id="image"
                                    type="file"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="hidden">

                            </label>

                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- ====================================== --}}
                    {{-- INFO NOTE --}}
                    {{-- ====================================== --}}

                    <div class="mt-6 sm:mt-8 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-4 sm:px-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9h1.5v6h-1.5V9Zm0-3h1.5v1.5h-1.5V6Zm9.75 6a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                                </svg>
                            </div>
                            <p class="text-sm leading-6 text-gray-600">
                                Health information should be clear, accurate, and appropriate for maternal and infant care.
                            </p>
                        </div>
                    </div>

                    {{-- ====================================== --}}
                    {{-- ACTIONS --}}
                    {{-- ====================================== --}}

                    <div class="mt-6 sm:mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row">

                        <a
                            href="{{ route('midwife.health-tips.index') }}"
                            class="flex h-12 items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 active:scale-[0.98] sm:flex-none">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="flex h-12 items-center justify-center gap-2 rounded-xl bg-pink-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-pink-700 active:scale-[0.98] sm:flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                            </svg>
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>