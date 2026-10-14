<section class="space-y-5">
    <header class="space-y-1">
        <h2 class="text-base font-semibold text-slate-800">
            {{ __('Personal Details') }}
        </h2>
        <p class="text-sm leading-6 text-slate-500">
            {{ __("Update your account's name, email address, and contact number.") }}
        </p>
    </header>

    <form id="send-verification"
          method="post"
          action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post"
          action="{{ route('profile.update') }}"
          class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1.5 block w-full rounded-xl border-slate-200
                       bg-white px-4 py-3 text-sm shadow-sm
                       focus:border-pink-400 focus:ring-pink-200"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1.5 block w-full rounded-xl border-slate-200
                       bg-white px-4 py-3 text-sm shadow-sm
                       focus:border-pink-400 focus:ring-pink-200"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 p-3">
                    <p class="text-sm text-amber-800">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button
                        form="send-verification"
                        class="mt-2 text-sm font-medium text-pink-700 underline
                               decoration-pink-300 underline-offset-4
                               hover:text-pink-800 focus:outline-none
                               focus:ring-2 focus:ring-pink-300"
                    >
                        {{ __('Resend verification email') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->isMother() && $user->mother)
            <div>
                <x-input-label
                    for="contact_number"
                    :value="__('Contact Number')"
                />

                <x-text-input
                    id="contact_number"
                    name="contact_number"
                    type="tel"
                    class="mt-1.5 block w-full rounded-xl border-slate-200
                           bg-white px-4 py-3 text-sm shadow-sm
                           focus:border-pink-400 focus:ring-pink-200"
                    :value="old('contact_number', $user->mother->contact_number)"
                    required
                    autocomplete="tel"
                    placeholder="09XXXXXXXXX"
                />

                <x-input-error
                    class="mt-2"
                    :messages="$errors->get('contact_number')"
                />

                <p class="mt-1.5 text-xs leading-5 text-slate-500">
                    {{ __('Use a valid Philippine mobile number, such as 09630031263.') }}
                </p>
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
            <x-primary-button>
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-700"
                >
                    {{ __('Changes saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>