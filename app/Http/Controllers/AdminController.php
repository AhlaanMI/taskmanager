<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * Render the admin control centre dashboard.
     */
    public function dashboard(): View
    {
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalTasks = Task::count();

        $recentTasks = Task::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCategories',
            'totalTasks',
            'recentTasks'
        ));
    }

    /**
     * Manage users screen.
     */
    public function manageUsers(): View
    {
        $users = User::withCount('tasks')->orderBy('name')->get();

        return view('admin.users', compact('users'));
    }
}
