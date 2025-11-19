<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserTaskController;
use App\Exports\TaskExport;
use App\Http\Controllers\Admin\AdminDashboardController;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

// Middleware auth dan verified untuk semua halaman user
Route::middleware(['auth', 'verified'])->group(function () {

    // Task: input & simpan (tambah task baru)
    Route::get('/task/form', [UserTaskController::class, 'create'])->name('task.form');
    Route::post('/task/store', [UserTaskController::class, 'store'])->name('task.store');

    // Task: edit & update
    Route::get('/task/{id}/edit', [UserTaskController::class, 'edit'])->name('task.edit');
    Route::patch('/task/{id}', [UserTaskController::class, 'update'])->name('task.update');

    // Task: delete
    Route::delete('/task/{id}', [UserDashboardController::class, 'destroy'])->name('task.destroy');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Export Task
    Route::get('/export-task', function () {
        return Excel::download(new TaskExport, 'tasks.xlsx');
    })->name('task.export');

    // Route dashboard user
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard'); // Dashboard User

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Rute untuk User Dashboard dan admin redirection setelah login
Route::middleware(['auth'])->group(function () {

    // Redirect setelah login berdasarkan role
    Route::get('/home', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard'); // Jika admin, arahkan ke dashboard admin
        } else {
            return redirect()->route('user.dashboard'); // Jika user, arahkan ke dashboard user
        }
    });

});

require __DIR__.'/auth.php';
