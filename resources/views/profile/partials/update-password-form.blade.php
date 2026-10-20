<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Perbarui Password') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 focus:ring-indigo-500 rounded-lg transition shadow-sm">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 dark:text-emerald-400 font-medium"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>