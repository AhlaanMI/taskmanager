@extends('layouts.app')

@section('title', 'Manage Users')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Manage users</h1>
        <p class="mt-1 text-sm text-slate-400">Review roles and task assignments.</p>
    </div>
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-slate-900/40">
        <header class="flex items-center justify-between border-b border-slate-800 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">Workspace members</h2>
            <span class="rounded-full border border-slate-800 bg-slate-900/70 px-3 py-1 text-xs text-slate-300">{{ $users->count() }} users</span>
        </header>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800/90 text-left text-sm text-slate-300">
                <thead class="bg-slate-900/70 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Tasks</th>
                        <th class="px-6 py-3">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/70">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-slate-900">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-white">{{ $user->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-400">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-xs uppercase">{{ $user->role ?? 'user' }}</td>
                            <td class="px-6 py-4">{{ $user->tasks_count }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ optional($user->created_at)->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
