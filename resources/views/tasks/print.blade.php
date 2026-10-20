<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Daftar Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 30px;
            background-color: #fff;
        }
        .no-print {
            margin-bottom: 20px;
            text-align: right;
        }
        .btn {
            padding: 8px 16px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            font-size: 13px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 13px;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 13px;
            background: #f9fafb;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-completed { background: #d1fae5; color: #065f46; }
        .badge-active { background: #fef3c7; color: #92400e; }
        .footer {
            margin-top: 40px;
            float: right;
            text-align: center;
            font-size: 13px;
        }
        .footer .signature {
            margin-top: 55px;
            font-weight: bold;
            text-decoration: underline;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi Cetak -->
    <div class="no-print">
        <button onclick="window.print()" class="btn">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Daftar Tugas (To-Do List)</h1>
        <p>Sistem Manajemen Tugas Akademik & Produktivitas Harian</p>
    </div>

    <div class="summary">
        <div><strong>Pemilik Akun:</strong> {{ Auth::user()->name }}</div>
        <div><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</div>
        <div><strong>Statistik:</strong> Total ({{ $totalTasks }}), Belum ({{ $activeTasks }}), Selesai ({{ $completedTasks }})</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Judul Tugas</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 12%;">Prioritas</th>
                <th style="width: 15%;">Tenggat Waktu</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 11%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $index => $task)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $task->title }}</strong></td>
                    <td>{{ $task->category }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">
                        @if($task->is_completed)
                            <span class="badge badge-completed">Selesai</span>
                        @else
                            <span class="badge badge-active">Belum</span>
                        @endif
                    </td>
                    <td>{{ $task->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #666;">Tidak ada data tugas yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <div class="signature">{{ Auth::user()->name }}</div>
    </div>

    <script>
        // Otomatis memicu dialog cetak saat halaman terbuka di tab baru
        window.addEventListener('DOMContentLoaded', () => {
            window.print();
        });
    </script>

</body>
</html>