<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengingat Tugas</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px; color: #374151;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #4f46e5; margin-top: 0;">Halo, {{ $task->user->name }}! 👋</h2>
        <p>Ini adalah pengingat otomatis untuk tugas Anda yang memiliki tenggat waktu:</p>
        
        <div style="background: #f9fafb; border-left: 4px solid #4f46e5; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 5px 0;"><strong>Judul Tugas:</strong> {{ $task->title }}</p>
            <p style="margin: 5px 0;"><strong>Kategori:</strong> {{ $task->category }}</p>
            <p style="margin: 5px 0;"><strong>Prioritas:</strong> {{ $task->priority }}</p>
            <p style="margin: 5px 0;"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
            @if($task->tags)
                <p style="margin: 5px 0;"><strong>Tag:</strong> #{{ str_replace(',', ', #', $task->tags) }}</p>
            @endif
            @if($task->notes)
                <p style="margin: 5px 0;"><strong>Catatan:</strong> {{ $task->notes }}</p>
            @endif
        </div>

        <p>Segera selesaikan tugas Anda tepat waktu ya! 🚀</p>
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
        <p style="font-size: 12px; color: #9ca3af; text-align: center;">Aplikasi To-Do List - Sistem Pengingat Akademik</p>
    </div>
</body>
</html>