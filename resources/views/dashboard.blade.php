<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Selamat Datang & Quick Actions -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selamat datang kembali di Planora. Berikut ringkasan produktivitas dan keuanganmu hari ini.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('tasks.index') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        + Tugas Baru
                    </a>
                    <a href="{{ route('finances.create') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        + Catat Keuangan
                    </a>
                </div>
            </div>

            <!-- Grid Ringkasan Utama (Metrics Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Task Pending -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Tugas Belum Selesai</p>
                    <p class="text-3xl font-bold text-amber-500 dark:text-amber-400 mt-2">{{ $pendingTasksCount }}</p>
                    <a href="{{ route('tasks.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline mt-3 inline-block">Kelola tugas &rarr;</a>
                </div>
                <!-- Total Saldo -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Sisa Saldo Aktif</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                    <a href="{{ route('finances.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline mt-3 inline-block">Kelola keuangan &rarr;</a>
                </div>
                <!-- Pemasukan Bulan Ini -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <!-- Pengeluaran Bulan Ini -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-rose-600 dark:text-rose-400 mt-2">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Bagian Aktivitas Terbaru (Split 2 Kolom: Tasks & Finances) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Kolom Task Terbaru -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Task Terbaru</h3>
                        <a href="{{ route('tasks.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua</a>
                    </div>

                    @if($recentTasks->isEmpty())
                        <p class="text-slate-500 dark:text-slate-400 text-sm py-4 text-center">Belum ada task yang dibuat.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($recentTasks as $task)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center space-x-3">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $task->is_completed ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        <span class="text-sm {{ $task->is_completed ? 'line-through text-slate-400 dark:text-slate-500' : 'text-slate-800 dark:text-slate-200' }}">
                                            {{ $task->title }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $task->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Kolom Transaksi Keuangan Terbaru -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Transaksi Terakhir</h3>
                        <a href="{{ route('finances.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua</a>
                    </div>

                    @if($recentTransactions->isEmpty())
                        <p class="text-slate-500 dark:text-slate-400 text-sm py-4 text-center">Belum ada catatan keuangan.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($recentTransactions as $trx)
                                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700">
                                    <div>
                                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $trx->title }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $trx->date }} &bull; <span class="bg-slate-200 dark:bg-slate-800 px-1.5 py-0.5 rounded text-slate-700 dark:text-slate-300">{{ $trx->category }}</span></p>
                                    </div>
                                    <span class="text-sm font-bold {{ $trx->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>