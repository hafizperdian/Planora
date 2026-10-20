<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Ambil bulan yang dipilih pengguna dari query string, jika tidak ada gunakan bulan berjalan (contoh: '2026-10')
        $selectedMonth = $request->query('month', date('Y-m'));

        // 1. Ambil batas anggaran khusus untuk bulan yang dipilih
        $budgets = Budget::where('user_id', $userId)
            ->where('month', $selectedMonth)
            ->get();

        // 2. Ambil pengeluaran aktual khusus untuk bulan yang dipilih
        $expenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->where('date', 'like', $selectedMonth . '%')
            ->get()
            ->groupBy('category');

        // 3. Gabungkan batas anggaran bulan ini dengan total pengeluaran riil bulan ini
        $budgetSummaries = $budgets->map(function ($budget) use ($expenses) {
            $spent = isset($expenses[$budget->category]) 
                ? $expenses[$budget->category]->sum('amount') 
                : 0;
            
            $percentage = $budget->amount_limit > 0 
                ? min(100, round(($spent / $budget->amount_limit) * 100)) 
                : 0;

            return [
                'id' => $budget->id,
                'category' => $budget->category,
                'limit' => $budget->amount_limit,
                'spent' => $spent,
                'remaining' => $budget->amount_limit - $spent,
                'percentage' => $percentage,
            ];
        });

        // Hitung total anggaran dan total pengeluaran teranggarkan bulan ini
        $totalLimit = $budgets->sum('amount_limit');
        $totalSpent = $budgetSummaries->sum('spent');

        return view('budgets.index', compact(
            'budgetSummaries', 
            'selectedMonth', 
            'totalLimit', 
            'totalSpent'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount_limit' => 'required|numeric|min:1',
            'month' => 'required|string',
        ]);

        // Simpan atau update anggaran khusus untuk kategori & bulan tertentu
        Budget::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'category' => $request->category,
                'month' => $request->month,
            ],
            [
                'amount_limit' => $request->amount_limit,
            ]
        );

        return redirect()->route('budgets.index', ['month' => $request->month])
            ->with('success', 'Anggaran berhasil disimpan!');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $savedMonth = $budget->month;
        $budget->delete();

        return redirect()->route('budgets.index', ['month' => $savedMonth])
            ->with('success', 'Anggaran berhasil dihapus!');
    }
}