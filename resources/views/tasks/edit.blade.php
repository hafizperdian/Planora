<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    
                    <div class="mb-4">
    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Nama / Judul Tugas</label>
    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required 
           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
</div>

<div class="mb-4">
    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
    <select name="category" id="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
        <option value="Kuliah" {{ $task->category === 'Kuliah' ? 'selected' : '' }}>Kuliah</option>
        <option value="Pribadi" {{ $task->category === 'Pribadi' ? 'selected' : '' }}>Pribadi</option>
        <option value="Pekerjaan" {{ $task->category === 'Pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
    </select>
</div>

<div class="mb-4">
    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prioritas</label>
    <select name="priority" id="priority" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
        <option value="Rendah" {{ $task->priority === 'Rendah' ? 'selected' : '' }}>Rendah</option>
        <option value="Sedang" {{ $task->priority === 'Sedang' ? 'selected' : '' }}>Sedang</option>
        <option value="Tinggi" {{ $task->priority === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
    </select>

    <div class="mb-4">
    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan / Deskripsi </label>
    <textarea name="notes" id="notes" rows="3" 
              class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('notes', $task->notes) }}</textarea>
</div>

</div>
    <div class="mb-4">
    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Tenggat Waktu </label>
    <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date) }}" 
           class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
</div>
<!-- Input Tag Kustom di Form Edit -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tag Kustom</label>
                    <input type="text" name="tags" value="{{ old('tags', $task->tags) }}" placeholder="Contoh: Laravel, UAS, Web"
                           class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-sm">
                </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                        <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>