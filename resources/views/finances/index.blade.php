<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Kelola Keuangan') }}
            </h2>
            <a href="{{ route('finances.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                + Tambah Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 3000)" 
                     x-transition.duration.500ms
                     class="mb-4 bg-green-100 dark:bg-green-900/40 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-md relative flex justify-between items-center shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-700 dark:text-green-300 hover:text-green-900 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            <!-- Filter Bulan Keuangan -->
            <div class="flex justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Periode Bulan:</span>
                <form method="GET" action="{{ route('finances.index') }}">
                    <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-1.5 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500">
                </form>
            </div>

            <!-- Kartu Ringkasan (Summary Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-rose-600 dark:text-rose-400 mt-2">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Saldo Akhir</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Grid 2 Kolom: Grafik & Ringkasan Kategori -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Kolom Kiri: Grafik Chart.js -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 flex flex-col justify-between">
                    <h3 class="text-lg font-bold mb-4">Grafik Perbandingan Keuangan</h3>
                    <div class="max-w-xs mx-auto py-2">
                        <canvas id="financeChart"></canvas>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400 text-center">
                        Visualisasi rasio pemasukan dan pengeluaran keseluruhan
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan per Kategori -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold mb-4">Ringkasan per Kategori</h3>
                        
                        @if($transactions->isEmpty())
                            <p class="text-slate-500 dark:text-slate-400 text-sm py-8 text-center">Belum ada kategori transaksi.</p>
                        @else
                            <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                                @foreach($transactions->groupBy('category') as $category => $items)
                                    @php
                                        $catIncome = $items->where('type', 'income')->sum('amount');
                                        $catExpense = $items->where('type', 'expense')->sum('amount');
                                        $catNet = $catIncome - $catExpense;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700">
                                        <div>
                                            <span class="font-semibold text-slate-800 dark:text-slate-200 text-sm">{{ $category }}</span>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $items->count() }} transaksi tercatat</p>
                                        </div>
                                        <span class="text-sm font-bold {{ $catNet >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $catNet >= 0 ? '+' : '' }} Rp {{ number_format($catNet, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400 flex justify-between">
                        <span>Total Kategori: {{ $transactions->unique('category')->count() }}</span>
                        <span>Planora Hub</span>
                    </div>
                </div>

            </div>

            <!-- Tabel Riwayat Transaksi -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 dark:border-slate-700">
                <div class="p-6 text-slate-800 dark:text-slate-200">
                    <h3 class="text-lg font-bold mb-4">Riwayat Transaksi</h3>
                    
                    @if($transactions->isEmpty())
                        <p class="text-slate-500 dark:text-slate-400 text-center py-6">Belum ada catatan keuangan yang tersimpan.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-sm">
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Judul / Keterangan</th>
                                        <th class="py-3 px-4">Kategori</th>
                                        <th class="py-3 px-4">Tipe</th>
                                        <th class="py-3 px-4">Jumlah</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                                    @foreach($transactions as $trx)
                                        <tr>
                                            <td class="py-3 px-4 text-slate-700 dark:text-slate-300">{{ $trx->date }}</td>
                                            <td class="py-3 px-4 font-medium text-slate-900 dark:text-slate-100">{{ $trx->title }}</td>
                                            <td class="py-3 px-4"><span class="bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-md text-xs">{{ $trx->category }}</span></td>
                                            <td class="py-3 px-4">
                                                @if($trx->type === 'income')
                                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Pemasukan</span>
                                                @else
                                                    <span class="text-rose-600 dark:text-rose-400 font-semibold">Pengeluaran</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 font-bold {{ $trx->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <form action="{{ route('finances.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 font-medium">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const isDarkMode = document.documentElement.classList.contains('dark');
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                    backgroundColor: ['#34d399', '#f87171'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: isDarkMode ? '#cbd5e1' : '#475569'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>