<x-guest-layout>
    <style>
        /* CSS Khusus Pemotong Miring (Diagonal Split) Presisi 100% */
        .diagonal-left {
            clip-path: polygon(0 0, 100% 0, 75% 100%, 0 100%);
        }
        @media (max-width: 767px) {
            .diagonal-left {
                clip-path: none;
            }
        }
    </style>

    <div class="min-h-screen w-full flex items-center justify-center bg-slate-950 p-4 sm:p-6 font-sans">
        
        <!-- Card Utama (Background Biru Murni Planora) -->
        <div class="relative w-full max-w-4xl bg-[#1e60c8] rounded-3xl shadow-2xl overflow-hidden border border-blue-400/20 grid grid-cols-1 md:grid-cols-12 min-h-[520px]">
            
            <!-- Sisi Kiri: Area Putih Miring (Informasi Branding) -->
            <div class="md:col-span-7 bg-white p-8 sm:p-12 flex flex-col justify-center items-center text-center relative z-20 diagonal-left">
                <div class="max-w-xs mx-auto space-y-4 my-auto pr-0 md:pr-10">
                    
                    <!-- Logo Aplikasi -->
                    <div class="mx-auto w-24 h-24 p-3 bg-slate-50 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Planora Logo" class="w-full h-full object-contain">
                    </div>
                    
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Planora</h2>
                        <p class="text-[11px] text-indigo-600 mt-1 uppercase tracking-wider font-semibold">Productivity & Financial Hub</p>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed">
                        Mulai perjalanan produktivitas dan kelola keuanganmu dengan lebih terstruktur, aman, dan mudah diakses bersama Planora.
                    </p>
                </div>
            </div>

            <!-- Sisi Kanan: Form Pendaftaran (Register) -->
            <div class="md:col-span-5 bg-[#1e60c8] p-8 sm:p-12 flex flex-col justify-center relative z-10 text-white -ml-0 md:-ml-16">
                <div class="max-w-sm w-full mx-auto space-y-4 pl-0 md:pl-4">
                    
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Buat Akun Baru 🚀</h3>
                        <p class="text-xs text-blue-100 mt-0.5">Daftar untuk mulai menggunakan Planora</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-3">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-medium text-blue-100 mb-1">Nama Lengkap</label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                class="w-full px-3.5 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
                                placeholder="Nama Lengkap">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-200" />
                        </div>

                        <!-- Alamat Email -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-blue-100 mb-1">Alamat Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                class="w-full px-3.5 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
                                placeholder="nama@email.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-200" />
                        </div>

                        <!-- Kata Sandi dengan Toggle Mata -->
<div x-data="{ showPassword: false }">
    <label for="password" class="block text-xs font-medium text-blue-100 mb-1">Kata Sandi</label>
    <div class="relative">
        <input id="password" 
               :type="showPassword ? 'text' : 'password'" 
               name="password" 
               required 
               autocomplete="new-password"
               class="w-full pl-3.5 pr-10 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
               placeholder="••••••••">

        <button type="button" 
                @click="showPassword = !showPassword" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-200 hover:text-white focus:outline-none">
            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 013.982-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.558 1.488L3 3l18 18" />
            </svg>
        </button>
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-200" />
</div>

<!-- Konfirmasi Kata Sandi dengan Toggle Mata -->
<div x-data="{ showConfirmPassword: false }">
    <label for="password_confirmation" class="block text-xs font-medium text-blue-100 mb-1">Konfirmasi Kata Sandi</label>
    <div class="relative">
        <input id="password_confirmation" 
               :type="showConfirmPassword ? 'text' : 'password'" 
               name="password_confirmation" 
               required 
               autocomplete="new-password"
               class="w-full pl-3.5 pr-10 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
               placeholder="••••••••">

        <button type="button" 
                @click="showConfirmPassword = !showConfirmPassword" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-200 hover:text-white focus:outline-none">
            <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 013.982-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.558 1.488L3 3l18 18" />
            </svg>
        </button>
    </div>
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-200" />
</div>

                        <!-- Tombol Register -->
                        <button type="submit" class="w-full py-2.5 px-4 bg-white hover:bg-blue-50 text-[#1e60c8] font-bold text-xs uppercase tracking-wider rounded-lg shadow-md transition duration-150 mt-2">
                            DAFTAR AKUN
                        </button>
                    </form>

                    <!-- Link Login -->
                    <div class="pt-3 border-t border-white/20 text-center text-xs text-blue-100">
                        Sudah punya akun Planora? 
                        <a href="{{ route('login') }}" class="font-semibold text-white hover:underline transition">
                            Masuk di sini
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>