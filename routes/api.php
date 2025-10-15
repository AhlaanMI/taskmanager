<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Example: admin-only API routes
// Use the 'admin' middleware alias defined in `app/Http/Kernel.php`.
// Wrap admin endpoints in a group so all routes require admin privileges.
// Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/stats', [\App\Http\Controllers\Admin\StatsController::class, 'index']);
// });
