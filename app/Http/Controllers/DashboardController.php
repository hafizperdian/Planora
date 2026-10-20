<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Data Tugas (Task)
        $pendingTasksCount = Task::where('user_id', $userId)->where('is_completed', false)->count();
        $recentTasks = Task::where('user_id', $userId)->latest()->take(5)->get();

        // Data Keuangan (Transaction)
        $transactions = Transaction::where('user_id', $userId)->get();
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        $recentTransactions = $transactions->sortByDesc('date')->take(5);

        return view('dashboard', compact(
            'pendingTasksCount', 
            'recentTasks', 
            'totalIncome', 
            'totalExpense', 
            'balance', 
            'recentTransactions'
        ));
    }
}