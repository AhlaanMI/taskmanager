@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Admin control centre</h1>
        <p class="mt-1 text-sm text-slate-400">High-level overview of the workspace.</p>
    </div>
@endsection

@section('content')
    <div class="grid gap-6 md:grid-cols-3">
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-xs uppercase tracking-wider text-slate-400">Total users</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $totalUsers }}</p>
        </article>
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-xs uppercase tracking-wider text-slate-400">Categories</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $totalCategories }}</p>
        </article>
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-xs uppercase tracking-wider text-slate-400">Tasks</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $totalTasks }}</p>
        </article>
    </div>

    <section class="mt-10 rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-slate-900/40">
        <header class="flex items-center justify-between border-b border-slate-800 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-white">Recent tasks</h2>
                <p class="text-xs text-slate-400">Latest activity across the organisation.</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-xs font-semibold uppercase tracking-wide text-indigo-300 hover:text-indigo-200">View all</a>
        </header>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800/90 text-left text-sm text-slate-300">
                <thead class="bg-slate-900/70 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-3">Task</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Owner</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/70">
                    @forelse ($recentTasks as $task)
                        <tr class="transition hover:bg-slate-900">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-white">{{ $task->name }}</p>
                                <p class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($task->description, 60) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ $task->category->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $task->user->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4 uppercase text-xs">{{ str_replace('_', ' ', $task->status) }}</td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $task->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">No tasks yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
