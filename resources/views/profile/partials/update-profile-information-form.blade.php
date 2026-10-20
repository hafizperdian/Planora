<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __("Perbarui informasi profil, alamat email, dan foto avatar Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Tambahkan enctype agar form bisa memproses file gambar -->
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <!-- Preview & Input Foto Profil -->
<div class="flex items-center space-x-5 py-2">
    <div class="shrink-0">
        @if($user->avatar)
            <img class="h-16 w-16 object-cover rounded-full border-2 border-indigo-500 shadow-md" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
        @else
            <div class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                {{ substr($user->name, 0, 1) }}
            </div>
        @endif
    </div>

    <div x-data="{ fileName: '' }">
        <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-lg border border-slate-300 dark:border-slate-600 transition shadow-sm">
            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Pilih Foto Baru
            <input type="file" name="avatar" class="hidden" @change="fileName = $event.target.files[0]?.name">
        </label>
        <span x-text="fileName || 'Belum ada foto dipilih'" class="block mt-1 text-xs text-slate-500 dark:text-slate-400"></span>
    </div>
</div>
<x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

        <div>
            <x-input-label for="name" :value="__('Nama')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 dark:text-slate-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 focus:ring-indigo-500 rounded-lg transition shadow-sm">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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