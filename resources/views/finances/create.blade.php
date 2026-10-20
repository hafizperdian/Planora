<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Tambah Transaksi Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                
                <form action="{{ route('finances.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul / Keterangan</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Gaji Bulanan / Belanja Bulanan" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                        @error('title') <span class="text-rose-500 dark:text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tipe Transaksi</label>
                            <select name="type" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                                <option value="income">Pemasukan (Income)</option>
                                <option value="expense">Pengeluaran (Expense)</option>
                            </select>
                            @error('type') <span class="text-rose-500 dark:text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jumlah (Rp)</label>
                            <input type="text" 
                                id="amount_display" 
                                placeholder="Contoh: 200.000" 
                                value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}" 
                                required 
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
    
                            <!-- Input Tersembunyi (Hidden) untuk Mengirim Angka Asli ke Database -->
                            <input type="hidden" name="amount" id="amount_real" value="{{ old('amount') }}">
                            @error('amount') <span class="text-rose-500 dark:text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                            <input type="text" name="category" placeholder="Contoh: Makanan, Transport, Gaji" value="{{ old('category') }}" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                            @error('category') <span class="text-rose-500 dark:text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2 text-slate-800 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                            @error('date') <span class="text-rose-500 dark:text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('finances.index') }}" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg text-sm font-medium transition">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg text-sm font-medium transition shadow-sm">Simpan Transaksi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script Format Ribuan Otomatis -->
    <script>
        const amountDisplay = document.getElementById('amount_display');
        const amountReal = document.getElementById('amount_real');

        if (amountDisplay) {
            amountDisplay.addEventListener('input', function(e) {
                let rawValue = this.value.replace(/[^0-9]/g, '');
                amountReal.value = rawValue;
                this.value = rawValue ? parseInt(rawValue, 10).toLocaleString('id-ID') : '';
            });
        }
    </script>
</x-app-layout>