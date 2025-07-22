<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserTaskController;
use App\Exports\TaskExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

// Middleware auth dan verified untuk semua halaman user
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (user dashboard)
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');

    // Task: input & simpan
    Route::get('/task/form', [UserTaskController::class, 'create'])->name('task.form');
    Route::post('/task/store', [UserTaskController::class, 'store'])->name('task.store');

    // Task: update kategori (ubah jadi done/cancel)
    Route::patch('/task/{id}', [UserDashboardController::class, 'update'])->name('task.update');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/user/task/{id}', [UserDashboardController::class, 'update'])->name('user.task.update');


    Route::get('/export-task', function () {
        return Excel::download(new TaskExport, 'tasks.xlsx');
    })->name('task.export');


});

require __DIR__.'/auth.php';
