<section class="space-y-5">
    <header class="space-y-1">
        <h2 class="text-base font-semibold text-slate-800">
            {{ __('Change Password') }}
        </h2>

        <p class="text-sm leading-6 text-slate-500">
            {{ __('Use a strong, unique password to help protect your account.') }}
        </p>
    </header>

    <form method="post"
          action="{{ route('password.update') }}"
          class="space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label
                for="update_password_current_password"
                :value="__('Current Password')"
            />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1.5 block w-full rounded-xl border-slate-200
                       bg-white px-4 py-3 text-sm shadow-sm
                       focus:border-pink-400 focus:ring-pink-200"
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="update_password_password"
                :value="__('New Password')"
            />

            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1.5 block w-full rounded-xl border-slate-200
                       bg-white px-4 py-3 text-sm shadow-sm
                       focus:border-pink-400 focus:ring-pink-200"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label
                for="update_password_password_confirmation"
                :value="__('Confirm Password')"
            />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1.5 block w-full rounded-xl border-slate-200
                       bg-white px-4 py-3 text-sm shadow-sm
                       focus:border-pink-400 focus:ring-pink-200"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">
            <x-primary-button>
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-700"
                >
                    {{ __('Password updated.') }}
                </p>
            @endif
        </div>
    </form>
</section>