<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'General User',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $categories = collect([
            ['name' => 'Product Launch', 'description' => 'Work that supports upcoming launches.'],
            ['name' => 'Engineering', 'description' => 'Engineering tasks and code improvements.'],
            ['name' => 'Operations', 'description' => 'Business operations and internal processes.'],
        ])->map(function ($data) {
            $data['status'] = 'active';
            return Category::updateOrCreate(['name' => $data['name']], $data);
        });

        Task::updateOrCreate(
            ['name' => 'Prepare launch checklist'],
            [
                'description' => 'Draft the checklist for the next product launch.',
                'category_id' => $categories[0]->id,
                'user_id' => $admin->id,
                'assignment_date' => now(),
                'deadline' => now()->addWeek(),
                'status' => 'pending',
            ]
        );

        Task::updateOrCreate(
            ['name' => 'Clean up backlog'],
            [
                'description' => 'Groom and prioritise tasks before planning.',
                'category_id' => $categories[1]->id,
                'user_id' => $user->id,
                'assignment_date' => now()->subDay(),
                'deadline' => now()->addDays(3),
                'status' => 'in_progress',
            ]
        );
    }
}
