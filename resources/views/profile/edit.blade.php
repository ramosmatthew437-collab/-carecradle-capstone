<x-app-layout>

    <div class="min-h-[calc(100vh-5rem)] bg-[#fff8fb] py-7 sm:py-9">
       <div class="mx-auto max-w-5xl space-y-5 px-4 sm:px-6 lg:px-8">

            {{-- PROFILE INFORMATION --}}
            <div class="overflow-hidden rounded-2xl border border-pink-100
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
                                 stroke-width="1.8">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">
                                Profile Information
                            </h3>
                            <p class="mt-0.5 text-xs text-slate-500">
                                Update your personal details.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="overflow-hidden rounded-2xl border border-pink-100
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
                                 stroke-width="1.8">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 1 1 8 0v3"/>
                                <path d="M12 14v3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">
                                Account Security
                            </h3>
                            <p class="mt-0.5 text-xs text-slate-500">
                                Keep your account protected with a strong password.
                            </p>
                        </div>
                    </div>
                </div>

               <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- DELETE ACCOUNT: PRESERVED --}}
            <div class="overflow-hidden rounded-2xl border border-rose-200
                        bg-white shadow-sm">
                <div class="border-b border-rose-100 bg-rose-50/50 px-5 py-4 sm:px-7">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center
                                    rounded-xl bg-rose-100 text-rose-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4h8v2"/>
                                <path d="m19 6-1 14H6L5 6"/>
                                <path d="M10 11v5M14 11v5"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-rose-700">
                                Delete Account
                            </h3>
                            <p class="mt-0.5 text-xs text-slate-500">
                                Manage your account deletion options.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>