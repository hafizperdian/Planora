<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
             <!-- Notifikasi Berhasil -->
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
            
            <!-- Box Form Tambah Tugas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100 transition-colors duration-200">
               <!-- Form Tambah Tugas -->
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tambah Tugas Baru</h3>

                <!-- Form Tambah Tugas -->
                <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Baris Utama (4 Kolom Sejajar & Simetris) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <input type="text" name="title" placeholder="Apa rencana tugasmu hari ini...?" required 
                               class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                        
                        <select name="category" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                            <option value="Kuliah">Kuliah</option>
                            <option value="Pribadi">Pribadi</option>
                            <option value="Pekerjaan">Pekerjaan</option>
                        </select>

                        <!-- Input Tanggal dengan Teks Pendamping / Helper Kiri yang Rapi -->
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm overflow-hidden focus-within:ring-1 focus-within:ring-indigo-500 focus-within:border-indigo-500">
                            <span class="pl-3 text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap border-r border-gray-200 dark:border-gray-600 pr-2">
                                Deadline:
                            </span>
                            <input type="date" name="due_date" id="due_date" 
                                   class="border-0 dark:bg-gray-700 dark:text-white focus:ring-0 w-full text-sm py-2 px-2 cursor-pointer">
                        </div>

                        <select name="priority" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                            <option value="Rendah">Prioritas: Rendah</option>
                            <option value="Sedang" selected>Prioritas: Sedang</option>
                            <option value="Tinggi">Prioritas: Tinggi</option>
                        </select>
                    </div>

                    <!-- Baris Tambahan (Tag Kustom, Catatan, & Tombol Tambah) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <input type="text" name="tags" placeholder="Tag kustom (pisahkan koma, misal: Laravel, UAS, Web)..." 
                               class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        
                        <textarea name="notes" placeholder="Catatan tambahan (opsional)..." rows="1"
                                  class="sm:col-span-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-md shadow-sm transition">
                            Tambah Tugas
                        </button>
                    </div>
                </form> 
               
            </div>

            <!-- Kotak Statistik Ringkas -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-indigo-500 transition-colors duration-200">
                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Tugas</div>
                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $totalTasks }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-amber-500 transition-colors duration-200">
                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Belum Selesai</div>
                    <div class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $activeTasks }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5 border-l-4 border-emerald-500 transition-colors duration-200">
                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Selesai</div>
                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $completedTasks }}</div>
                </div>
            </div>

            <!-- Grafik Statistik Visual (Diperkecil & Dipisah agar Rapi) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Grafik Status Tugas -->
                <div class="bg-white dark:bg-gray-800 p-5 shadow-sm sm:rounded-lg transition-colors duration-200">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider text-center">Statistik Status Tugas</h3>
                    <div class="relative h-48 flex justify-center items-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Grafik Kategori Tugas -->
                <div class="bg-white dark:bg-gray-800 p-5 shadow-sm sm:rounded-lg transition-colors duration-200">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider text-center">Statistik Kategori Tugas</h3>
                    <div class="relative h-48 flex justify-center items-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Skrip Inisialisasi Chart.js -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const isDarkMode = document.documentElement.classList.contains('dark');
                    const textColor = isDarkMode ? '#9ca3af' : '#4b5563';

                    // 1. Chart Status (Donut - Kompak)
                    const ctxStatus = document.getElementById('statusChart').getContext('2d');
                    new Chart(ctxStatus, {
                        type: 'doughnut',
                        data: {
                            labels: ['Belum Selesai', 'Selesai'],
                            datasets: [{
                                data: [{{ $activeTasks }}, {{ $completedTasks }}],
                                backgroundColor: ['#f59e0b', '#10b981'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { color: textColor, boxWidth: 12, font: { size: 11 } }
                                }
                            }
                        }
                    });

                    // 2. Chart Kategori (Bar - Kompak)
                    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
                    new Chart(ctxCategory, {
                        type: 'bar',
                        data: {
                            labels: ['Kuliah', 'Pribadi', 'Pekerjaan'],
                            datasets: [{
                                label: 'Jumlah',
                                data: [{{ $kuliahCount }}, {{ $pribadiCount }}, {{ $pekerjaanCount }}],
                                backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6'],
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { color: textColor, stepSize: 1, font: { size: 11 } },
                                    grid: { color: isDarkMode ? '#374151' : '#e5e7eb' }
                                },
                                x: {
                                    ticks: { color: textColor, font: { size: 11 } },
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                });
            </script>

            <!-- Box Daftar Tugas (Terpisah & Rapi) -->
            <div x-data="{ selected: [] }" class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg transition-colors duration-200">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Tugas</h3>
                    
                    <!-- Form Pencarian & Tab Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center flex-wrap">
                        <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-2 w-full sm:w-auto">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tugas..." 
                                   class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full sm:w-48">
                            <button type="submit" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-md shadow-sm transition">
                                Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('tasks.index', ['status' => request('status')]) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                    Reset
                                </a>
                            @endif
                        </form>

                        <div class="flex gap-1.5 items-center">
                            <a href="{{ route('tasks.index', ['search' => request('search')]) }}" 
                               class="px-3 py-1.5 text-xs font-semibold rounded-md shadow-sm transition {{ request('status') === null ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                Semua
                            </a>
                            <a href="{{ route('tasks.index', ['status' => 'active', 'search' => request('search')]) }}" 
                               class="px-3 py-1.5 text-xs font-semibold rounded-md shadow-sm transition {{ request('status') === 'active' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                Belum
                            </a>
                            <a href="{{ route('tasks.index', ['status' => 'completed', 'search' => request('search')]) }}" 
                               class="px-3 py-1.5 text-xs font-semibold rounded-md shadow-sm transition {{ request('status') === 'completed' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                Selesai
                            </a>
                            
                            <a href="{{ route('tasks.print', ['status' => request('status'), 'search' => request('search')]) }}" target="_blank" 
                               class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-md shadow-sm transition inline-flex items-center gap-1 ml-2">
                                🖨️ Cetak
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Toolbar Aksi Massal (Muncul jika ada tugas yang dicentang) -->
                <div x-show="selected.length > 0" x-transition class="mb-4 p-3 bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 rounded-md flex items-center justify-between">
                    <span class="text-sm font-medium text-indigo-800 dark:text-indigo-300">
                        <span x-text="selected.length"></span> tugas dipilih:
                    </span>
                    <div class="flex items-center gap-2">
                        @if(request('status') !== 'completed')
                            <form action="{{ route('tasks.bulkComplete') }}" method="POST">
                                @csrf
                                <template x-for="id in selected">
                                    <input type="hidden" name="ids[]" :value="id">
                                </template>
                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded shadow transition">
                                    ✓ Tandai Selesai
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('tasks.bulkDestroy') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua tugas yang dipilih?');">
                            @csrf
                            @method('DELETE')
                            <template x-for="id in selected">
                                <input type="hidden" name="ids[]" :value="id">
                            </template>
                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded shadow transition">
                                🗑️ Hapus Terpilih
                            </button>
                        </form>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse ($tasks as $task)
                        <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-colors duration-200">
                            
                            <!-- Sisi Kiri -->
                            <div class="flex items-start gap-3.5 flex-1 min-w-0 w-full">
                                <input type="checkbox" value="{{ $task->id }}" x-model="selected"
                                       class="mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 cursor-pointer shrink-0">

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-base break-words {{ $task->is_completed ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-800 dark:text-gray-200 font-medium' }}">
                                            {{ $task->title }}
                                        </span>
                                        
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full shrink-0 
                                            {{ $task->category === 'Kuliah' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300' : ($task->category === 'Pekerjaan' ? 'bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300' : 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300') }}">
                                            {{ $task->category }}
                                        </span>

                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full shrink-0 
                                            {{ $task->priority === 'Tinggi' ? 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' : ($task->priority === 'Sedang' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300') }}">
                                            ⚡ {{ $task->priority }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-1 mt-1.5">
                                        @if ($task->due_date)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                📅 Target: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                            </p>
                                        @endif

                                        <!-- Badge Tag Kustom -->
                                        @if ($task->tags)
                                            <div class="flex items-center gap-1 flex-wrap mt-0.5">
                                                @foreach (array_map('trim', explode(',', $task->tags)) as $tag)
                                                    <a href="{{ route('tasks.index', ['search' => $tag]) }}" 
                                                       class="text-[11px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900/50 hover:text-indigo-600 transition">
                                                        #{{ $tag }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if ($task->notes)
                                            <p class="text-xs text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-2 rounded border border-gray-200 dark:border-gray-700 mt-0.5">
                                                📝 <span class="font-medium">Catatan:</span> {{ $task->notes }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Sisi Kanan: Aksi Tugas (Selesai, Edit, Hapus) -->
                            <div class="flex items-center gap-3 shrink-0">
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 text-xs font-semibold rounded border {{ $task->is_completed ? 'border-amber-300 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/30' : 'border-emerald-300 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30' }} transition">
                                        {{ $task->is_completed ? 'Batal Selesai' : 'Selesai' }}
                                    </button>
                                </form>

                                <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold text-xs sm:text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-semibold text-xs sm:text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            Belum ada daftar tugas untuk kategori ini. 🚀
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>