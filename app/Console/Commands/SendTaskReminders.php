<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Kirim email pengingat otomatis untuk tugas yang deadline-nya hari ini';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        
        // Ambil tugas yang belum selesai dan jatuh tempo hari ini
        $tasks = Task::with('user')
                    ->where('is_completed', false)
                    ->whereDate('due_date', $today)
                    ->get();

        if ($tasks->isEmpty()) {
            $this->info('Tidak ada tugas dengan deadline hari ini.');
            return;
        }

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)->send(new TaskReminderMail($task));
                $this->info("Pengingat terkirim ke: {$task->user->email} untuk tugas: {$task->title}");
            }
        }

        $this->info('Semua pengingat deadline hari ini berhasil diproses.');
    }
}