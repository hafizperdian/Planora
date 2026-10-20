<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BudgetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $userId = auth()->id();

    // Data Tugas (Task)
    $pendingTasksCount = \App\Models\Task::where('user_id', $userId)->where('is_completed', false)->count();
    $recentTasks = \App\Models\Task::where('user_id', $userId)->latest()->take(5)->get();

    // Data Keuangan (Transaction)
    $transactions = \App\Models\Transaction::where('user_id', $userId)->get();
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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/tasks/{task}/reminder', [App\Http\Controllers\TaskController::class, 'sendReminder'])->name('tasks.reminder');
    Route::post('/tasks/bulk-complete', [App\Http\Controllers\TaskController::class, 'bulkComplete'])->name('tasks.bulkComplete');
    Route::delete('/tasks/bulk-destroy', [App\Http\Controllers\TaskController::class, 'bulkDestroy'])->name('tasks.bulkDestroy');
    Route::get('/tasks/print', [App\Http\Controllers\TaskController::class, 'print'])->name('tasks.print');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
    Route::resource('tasks', TaskController::class);
    Route::resource('finances', TransactionController::class);
      
});

require __DIR__.'/auth.php';
