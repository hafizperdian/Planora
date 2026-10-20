<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $userQuery = Auth::user()->tasks();

        $totalTasks = (clone $userQuery)->count();
        $activeTasks = (clone $userQuery)->where('is_completed', false)->count();
        $completedTasks = (clone $userQuery)->where('is_completed', true)->count();

        // Data statistik kategori untuk grafik
        $kuliahCount = (clone $userQuery)->where('category', 'Kuliah')->count();
        $pribadiCount = (clone $userQuery)->where('category', 'Pribadi')->count();
        $pekerjaanCount = (clone $userQuery)->where('category', 'Pekerjaan')->count();

        $query = Auth::user()->tasks()->latest();

        if ($status === 'active') {
            $query->where('is_completed', false);
        } elseif ($status === 'completed') {
            $query->where('is_completed', true);
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%');
        }

        $tasks = $query->get();

        return view('tasks.index', compact(
            'tasks', 'totalTasks', 'activeTasks', 'completedTasks', 
            'kuliahCount', 'pribadiCount', 'pekerjaanCount'
        ));
    }
    public function create()
    {
    return view('tasks.create');
    }
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            Auth::user()->tasks()->whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Tugas terpilih berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Tidak ada tugas yang dipilih.');
    }

    public function print(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $userQuery = Auth::user()->tasks();

        $totalTasks = (clone $userQuery)->count();
        $activeTasks = (clone $userQuery)->where('is_completed', false)->count();
        $completedTasks = (clone $userQuery)->where('is_completed', true)->count();

        $query = Auth::user()->tasks()->latest();

        if ($status === 'active') {
            $query->where('is_completed', false);
        } elseif ($status === 'completed') {
            $query->where('is_completed', true);
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $tasks = $query->get();

        return view('tasks.print', compact('tasks', 'totalTasks', 'activeTasks', 'completedTasks', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:Rendah,Sedang,Tinggi',
            'notes' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'category' => $request->category,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'notes' => $request->notes,
            'tags' => $request->tags,
            'is_completed' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // 1. Menampilkan halaman form edit
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tasks.edit', compact('task'));
    }

    // 2. Menyimpan perubahan teks tugas dari form edit
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:Rendah,Sedang,Tinggi',
            'notes' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        $task->update([
            'title' => $request->title,
            'category' => $request->category,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'notes' => $request->notes,
            'tags' => $request->tags,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    // 3. Mengubah status selesai / belum selesai (Checkbox)
    public function toggle(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }
    public function bulkComplete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            Auth::user()->tasks()->whereIn('id', $ids)->update(['is_completed' => true]);
            return redirect()->back()->with('success', 'Tugas terpilih berhasil ditandai selesai!');
        }

        return redirect()->back()->with('error', 'Tidak ada tugas yang dipilih.');
    }

    public function sendReminder(Task $task)
    {
        // Pengecekan keamanan: Pastikan tugas ini milik user yang sedang login
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Mengirim email ke pengguna yang sedang login
        \Illuminate\Support\Facades\Mail::to(Auth::user()->email)->send(new \App\Mail\TaskReminderMail($task));

        return redirect()->back()->with('success', 'Email pengingat tugas berhasil dikirim!');
    }   
}
