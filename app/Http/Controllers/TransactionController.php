<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Ambil filter bulan dari URL, jika tidak ada gunakan bulan saat ini (format: YYYY-MM)
        $selectedMonth = $request->query('month', date('Y-m'));

        // 1. Hitung Saldo Keseluruhan (All-time balance) dari semua transaksi tanpa batasan bulan
        $allTransactions = Transaction::where('user_id', $userId)->get();
        $totalIncomeAll = $allTransactions->where('type', 'income')->sum('amount');
        $totalExpenseAll = $allTransactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncomeAll - $totalExpenseAll;

        // 2. Ambil transaksi khusus untuk bulan yang dipilih (untuk Pemasukan & Pengeluaran bulanan)
        $monthlyTransactions = $allTransactions->filter(function ($trx) use ($selectedMonth) {
            // Memeriksa apakah tanggal transaksi diawali dengan tahun-bulan yang dipilih (contoh: '2026-10')
            return str_starts_with($trx->date, $selectedMonth);
        });

        // Pemasukan dan Pengeluaran ini akan otomatis ter-reset/berubah saat berganti bulan
        $totalIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $totalExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');

        // Urutkan transaksi bulanan berdasarkan tanggal terbaru
        $transactions = $monthlyTransactions->sortByDesc('date');

        return view('finances.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'selectedMonth'
        ));
    }

    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'date' => $request->date,
        ]);

        return redirect()->route('finances.index')->with('success', 'Catatan keuangan berhasil ditambahkan!');
    }

    public function destroy(Transaction $finance)
    {
        if ($finance->user_id !== Auth::id()) {
            abort(403);
        }

        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Catatan keuangan berhasil dihapus!');
    }
}