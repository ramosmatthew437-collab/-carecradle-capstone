
<x-app-layout>
    <div class="min-h-[calc(100vh-5rem)] bg-[#fff8fb] py-7 sm:py-9">
        <div class="mx-auto max-w-5xl space-y-5 px-4 sm:px-6 lg:px-8">

            {{-- PAGE HEADER --}}
            <header class="relative overflow-hidden rounded-2xl border border-pink-100
                           bg-white shadow-[0_8px_28px_rgba(190,24,93,0.06)]">

                <div class="absolute inset-y-0 left-0 w-1.5
                            bg-gradient-to-b from-pink-400 via-pink-500 to-rose-400">
                </div>

                <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row
                            sm:items-center sm:justify-between sm:px-7 sm:py-6">

                    <div class="flex min-w-0 items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center
                                    rounded-2xl border border-pink-100 bg-pink-50
                                    text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7"
                                 aria-hidden="true">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 21a8 8 0 0 1 16 0"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="text-[0.68rem] font-bold uppercase
          tracking-[0.18em] text-pink-600">
    {{ auth()->user()->isMidwife() ? 'Midwife Portal' : (auth()->user()->isAdministrator() ? 'Administrator Portal' : 'Mother Portal') }}
</p>

                            <h1 class="mt-1 text-2xl font-normal leading-tight
                                       text-slate-900 sm:text-3xl"
                                style="font-family: 'DM Serif Display', Georgia, serif;">
                                My Profile
                            </h1>

                            <p class="mt-1 max-w-xl text-sm leading-6 text-slate-500">
                                Manage your personal information and keep your
                                CareCradle account secure.
                            </p>
                        </div>
                    </div>

                    <div class="inline-flex w-fit shrink-0 items-center gap-2
                                rounded-full border border-pink-100 bg-pink-50/80
                                px-3.5 py-2 text-xs font-semibold text-pink-700">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             aria-hidden="true">
                            <rect x="4" y="10" width="16" height="11" rx="2"/>
                            <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                        </svg>
                        Account Settings
                    </div>
                </div>
            </header>


            
{{-- MIDWIFE PROFILE PHOTO --}}
@if (auth()->user()->isMidwife())
    @php
        $midwife = auth()->user();

        $profilePhotoUrl = $midwife->profile_photo_path
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($midwife->profile_photo_path)
            : null;
    @endphp

    <section class="overflow-hidden rounded-2xl border border-pink-100
                    bg-white shadow-[0_4px_20px_rgba(190,24,93,0.04)]">

        <div class="border-b border-pink-50 px-5 py-4 sm:px-7">
            <h2 class="text-base font-semibold text-slate-800">
                Profile Photo
            </h2>
            <p class="mt-1 text-xs text-slate-500">
                Upload a photo to personalize your Midwife Portal.
            </p>
        </div>

        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:p-7">

            <div class="flex h-24 w-24 shrink-0 items-center justify-center
                        overflow-hidden rounded-full border-4 border-pink-100
                        bg-pink-50 text-3xl font-semibold text-pink-600">

                @if ($profilePhotoUrl)
                    <img src="{{ $profilePhotoUrl }}"
                         alt="Midwife profile photo"
                         class="h-full w-full object-cover">
                @else
                    {{ strtoupper(substr($midwife->name ?? 'M', 0, 1)) }}
                @endif
            </div>

            <div class="min-w-0 flex-1">

                <form method="POST"
                      action="{{ route('midwife.profile-photo.update') }}"
                      enctype="multipart/form-data"
                      class="space-y-3">

                    @csrf

                    <input type="file"
                           name="profile_photo"
                           accept="image/jpeg,image/png,image/webp"
                           required
                           class="block w-full text-sm text-slate-600
                                  file:mr-3 file:rounded-lg file:border-0
                                  file:bg-pink-50 file:px-4 file:py-2
                                  file:font-semibold file:text-pink-700
                                  hover:file:bg-pink-100">

                    @error('profile_photo')
                        <p class="text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-slate-400">
                        JPG, PNG, or WEBP. Maximum file size: 2 MB.
                    </p>

                    <button type="submit"
                            class="rounded-xl bg-pink-600 px-5 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-pink-700">
                        Upload Photo
                    </button>
                </form>

                @if ($profilePhotoUrl)
                    <form method="POST"
                          action="{{ route('midwife.profile-photo.destroy') }}"
                          class="mt-3"
                          onsubmit="return confirm('Remove your profile photo?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-sm font-semibold text-rose-600
                                       hover:text-rose-700">
                            Remove Photo
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </section>
@endif


            {{-- PROFILE INFORMATION --}}
            <section class="overflow-hidden rounded-2xl border border-pink-100
                            bg-white shadow-[0_4px_20px_rgba(190,24,93,0.04)]">

                <div class="border-b border-pink-50 px-5 py-4 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center
                                    rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-800">
                                Profile Information
                            </h2>
                            <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                Update your personal details and account information.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </section>

            {{-- ACCOUNT SECURITY --}}
            <section class="overflow-hidden rounded-2xl border border-pink-100
                            bg-white shadow-[0_4px_20px_rgba(190,24,93,0.04)]">

                <div class="border-b border-pink-50 px-5 py-4 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center
                                    rounded-xl bg-pink-50 text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 aria-hidden="true">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                                <path d="M12 14v3"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-slate-800">
                                Account Security
                            </h2>
                            <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                Change your password to help protect your account.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </section>

            {{-- DELETE ACCOUNT: EXISTING BEHAVIOR PRESERVED --}}
            <section class="overflow-hidden rounded-2xl border border-rose-200
                            bg-white shadow-sm">

                <div class="border-b border-rose-100 bg-rose-50/50
                            px-5 py-4 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center
                                    rounded-xl bg-rose-100 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 aria-hidden="true">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4h8v2"/>
                                <path d="m19 6-1 14H6L5 6"/>
                                <path d="M10 11v5M14 11v5"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-rose-700">
                                Delete Account
                            </h2>
                            <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                Review your account deletion options carefully.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </section>

            {{-- END OF PROFILE PAGE --}}
        </div>
    </div>
</x-app-layout>
