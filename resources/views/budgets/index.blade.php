<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Anggaran Bulanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-100 dark:bg-emerald-900/40 border border-emerald-400 dark:border-emerald-600 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-lg text-sm shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Periode Bulan -->
            <div class="flex justify-between items-center bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 w-full shadow-sm">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Periode Bulan:</span>
                <form method="GET" action="{{ route('budgets.index') }}">
                    <input type="month" name="month" value="{{ $selectedMonth }}" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-1.5 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-500 cursor-pointer">
                </form>
            </div>

            <!-- Ringkasan Anggaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">Total Limit Anggaran ({{ $selectedMonth }})</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">Rp {{ number_format($totalLimit, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">Total Terpakai ({{ $selectedMonth }})</p>
                    <p class="text-2xl font-bold {{ $totalSpent > $totalLimit && $totalLimit > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }} mt-1">
                        Rp {{ number_format($totalSpent, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Form Set Anggaran & Progress -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Input -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <h3 class="text-lg font-bold mb-4">Set Anggaran ({{ $selectedMonth }})</h3>
                    <form action="{{ route('budgets.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">

                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Kategori Transaksi</label>
                            <input type="text" name="category" placeholder="Contoh: Makanan, Transport, Hiburan" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Batas Pengeluaran (Rp)</label>
                            <input type="text" id="budget_display" placeholder="Contoh: 1.500.000" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-sm text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                            <input type="hidden" name="amount_limit" id="budget_real">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 rounded-lg text-sm transition shadow-sm">
                            Simpan Anggaran
                        </button>
                    </form>
                </div>

                <!-- Progress Anggaran -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <h3 class="text-lg font-bold mb-4">Progress Anggaran Periode {{ $selectedMonth }}</h3>

                    @if($budgetSummaries->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada anggaran yang diatur untuk bulan {{ $selectedMonth }}.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Gunakan form di samping untuk mulai membatasi pengeluaranmu.</p>
                        </div>
                    @else
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                            @foreach($budgetSummaries as $item)
                                @php
                                    $colorClass = 'bg-emerald-500';
                                    if ($item['percentage'] >= 100) {
                                        $colorClass = 'bg-rose-500';
                                    } elseif ($item['percentage'] >= 80) {
                                        $colorClass = 'bg-amber-500';
                                    }
                                @endphp
                                <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-lg border border-slate-200 dark:border-slate-700 space-y-2">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-800 dark:text-slate-200 font-semibold">{{ $item['category'] }}</span>
                                        <span class="text-slate-500 dark:text-slate-400 text-xs">
                                            Rp {{ number_format($item['spent'], 0, ',', '.') }} / 
                                            <span class="text-slate-800 dark:text-slate-200 font-medium">Rp {{ number_format($item['limit'], 0, ',', '.') }}</span>
                                        </span>
                                    </div>

                                    <!-- Progress Bar Track -->
                                    <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                        <div class="{{ $colorClass }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $item['percentage'] }}%"></div>
                                    </div>

                                    <div class="flex justify-between items-center text-xs text-slate-500 dark:text-slate-400 pt-1">
                                        <span>
                                            @if($item['remaining'] < 0)
                                                <span class="text-rose-600 dark:text-rose-400 font-semibold">Overbudget Rp {{ number_format(abs($item['remaining']), 0, ',', '.') }}!</span>
                                            @else
                                                Sisa: Rp {{ number_format($item['remaining'], 0, ',', '.') }}
                                            @endif
                                        </span>
                                        <div class="flex items-center space-x-3">
                                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $item['percentage'] }}%</span>
                                            <form action="{{ route('budgets.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus anggaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 font-medium">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Script Format Ribuan -->
    <script>
        const budgetDisplay = document.getElementById('budget_display');
        const budgetReal = document.getElementById('budget_real');

        if (budgetDisplay) {
            budgetDisplay.addEventListener('input', function() {
                let rawValue = this.value.replace(/[^0-9]/g, '');
                budgetReal.value = rawValue;
                this.value = rawValue ? parseInt(rawValue, 10).toLocaleString('id-ID') : '';
            });
        }
    </script>
</x-app-layout>