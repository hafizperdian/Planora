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
            
            <!-- Sisi Kiri: Area Putih Miring -->
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
                        Kelola tugas harian, lacak keuangan, dan atur anggaran bulanan Anda dalam satu platform yang terintegrasi, rapi, dan mudah digunakan.
                    </p>
                </div>
            </div>

            <!-- Sisi Kanan: Form Login -->
            <div class="md:col-span-5 bg-[#1e60c8] p-8 sm:p-12 flex flex-col justify-center relative z-10 text-white -ml-0 md:-ml-16">
                <div class="max-w-sm w-full mx-auto space-y-5 pl-0 md:pl-4">
                    
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Selamat Datang Kembali! 👋</h3>
                        <p class="text-xs text-blue-100 mt-0.5">Silakan masuk ke akun Planora Anda</p>
                    </div>

                    <!-- Status Session -->
                    <x-auth-session-status class="mb-3 text-xs" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Input Email -->
                        <div>
                            <label for="email" class="block text-xs font-medium text-blue-100 mb-1">Alamat Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="w-full px-3.5 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
                                placeholder="nama@email.com">
                           <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-200" />
                        </div>

                        <!-- Input Password dengan Toggle Mata -->
<div x-data="{ showPassword: false }">
    <div class="flex items-center justify-between mb-1">
        <label for="password" class="block text-xs font-medium text-blue-100">Kata Sandi</label>
        @if (Route::has('password.request'))
            <a class="text-xs text-blue-200 hover:text-white transition" href="{{ route('password.request') }}">
                Lupa sandi?
            </a>
        @endif
    </div>
    
    <div class="relative">
        <input id="password" 
               :type="showPassword ? 'text' : 'password'" 
               name="password" 
               required 
               autocomplete="current-password"
               class="w-full pl-3.5 pr-10 py-2.5 bg-white/10 border border-white/20 rounded-lg text-sm text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition"
               placeholder="••••••••">

        <!-- Tombol Ikon Mata -->
        <button type="button" 
                @click="showPassword = !showPassword" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-200 hover:text-white focus:outline-none">
            <!-- Ikon Mata Terbuka (Lihat Sandi) -->
            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <!-- Ikon Mata Tertutup/Coret (Sembunyikan Sandi) -->
            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 013.982-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.558 1.488L3 3l18 18" />
            </svg>
        </button>
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-200" />
</div>
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer text-xs text-blue-100">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded bg-white/10 border-white/30 text-blue-900 focus:ring-0">
                                <span class="ms-2">Ingat saya</span>
                            </label>
                        </div>

                        <!-- Tombol Login -->
                        <button type="submit" class="w-full py-2.5 px-4 bg-white hover:bg-blue-50 text-[#1e60c8] font-bold text-xs uppercase tracking-wider rounded-lg shadow-md transition duration-150">
                            MASUK KE PLANORA
                        </button>
                    </form>

                    <!-- Link Register -->
                    <div class="pt-4 border-t border-white/20 text-center text-xs text-blue-100">
                        Belum punya akun Planora? 
                        <a href="{{ route('register') }}" class="font-semibold text-white hover:underline transition">
                            Daftar di sini
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>