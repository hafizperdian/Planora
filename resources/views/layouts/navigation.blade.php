<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                
                <!-- Logo & Brand Name (Planora) -->
                <div class="shrink-0 flex items-center mr-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 object-contain">
                        <span class="text-slate-800 dark:text-white font-bold text-lg tracking-wide">Planora</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop - Gaya Pills) -->
                <div class="hidden space-x-2 sm:flex sm:items-center">
                    <!-- Menu Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' }}">
                        Dashboard
                    </a>

                    <!-- Menu To-Do List -->
                    <a href="{{ route('tasks.index') }}" 
                       class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('tasks.*') ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' }}">
                        To-Do List
                    </a>

                    <!-- Menu Keuangan -->
                    <a href="{{ route('finances.index') }}" 
                       class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('finances.*') ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' }}">
                        Keuangan
                    </a>

                    <!-- Menu Anggaran (Sudah Dipindah ke Dalam Kontainer) -->
                    <a href="{{ route('budgets.index') }}" 
                       class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('budgets.*') ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm' : 'text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' }}">
                        Anggaran
                    </a>
                </div>

            </div>

            <!-- Settings Dropdown & Tombol Dark Mode (Sisi Kanan) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
                <!-- Tombol Toggle Dark Mode -->
                <button @click="darkMode = !darkMode" 
                        class="p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition duration-150">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                
                <!-- Dropdown Nama Akun -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:text-slate-900 dark:hover:text-white focus:outline-none transition ease-in-out duration-150 gap-2">
                            
                            <!-- Foto Profil atau Inisial di Navbar -->
                            @if(Auth::user()->avatar)
                                <img class="h-7 w-7 rounded-full object-cover border border-indigo-500 shadow-sm" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                            @else
                                <div class="h-7 w-7 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif

                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-700 dark:text-slate-200 rounded-md">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" class="text-slate-700 dark:text-slate-200 rounded-md">
                {{ __('To-Do List') }}
            </x-responsive-nav_link>
            <x-responsive-nav-link :href="route('finances.index')" :active="request()->routeIs('finances.*')" class="text-slate-700 dark:text-slate-200 rounded-md">
                {{ __('Keuangan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('budgets.index')" :active="request()->routeIs('budgets.*')" class="text-slate-700 dark:text-slate-200 rounded-md">
                {{ __('Anggaran') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200 dark:border-slate-800">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4 pb-3">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-md text-slate-700 dark:text-slate-200">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="rounded-md text-slate-700 dark:text-slate-200"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>