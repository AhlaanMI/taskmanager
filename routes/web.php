<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Task;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



Route::get('/', function () {
    return view('/login');
});

// Auth routes (optional; guard against missing scaffolding files)
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// 👤 Authenticated users (e.g., Interns) can manage their own tasks
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $taskQuery = Task::with('category');

        if (!auth()->user()->isAdmin()) {
            $taskQuery->where('user_id', auth()->id());
        }

        $tasks = $taskQuery->get();

        $total = $tasks->count();
        $completed = $tasks->where('status', 'completed')->count();
        $pending = $tasks->whereIn('status', ['pending', 'in_progress'])->count();

        return view('dashboard', compact('total', 'completed', 'pending'));
    })->name('dashboard');

    // Intern (or general user) task management
    Route::resource('tasks', TaskController::class);



    // Admin-only category routes stacked on top of read-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('categories', CategoryController::class);
         Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
         Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
         Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
         Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
         Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});

// Categories: non-admins get read access only
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// 🔐 Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // You can put more admin routes here
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
});
