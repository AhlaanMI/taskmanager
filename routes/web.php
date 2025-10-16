<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth routes (optional; guard against missing scaffolding files)
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// 👤 Authenticated users (e.g., Interns) can manage their own tasks
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // You can customize this
    })->name('dashboard');

    // Intern (or general user) task management
    Route::resource('tasks', TaskController::class);

    // Categories: non-admins get read access only
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);

    // Admin-only category routes stacked on top of read-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('categories', CategoryController::class)->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
    });
});

// 🔐 Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // You can put more admin routes here
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
});
