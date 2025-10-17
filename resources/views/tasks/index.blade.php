@extends('layouts.app')

@section('title', 'Tasks')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">My tasks</h1>
        <p class="mt-1 text-sm text-slate-400">Monitor deadlines, ownership, and progress without leaving this page.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            New task
        </a>
    </div>
@endsection

@section('content')
    @php
        $collection = collect($tasks->items());
        $statusCounts = $collection->groupBy('status')->map->count();
        $palette = [
            'pending' => 'border-amber-400/40 bg-amber-400/10 text-amber-100',
            'in_progress' => 'border-sky-400/30 bg-sky-400/10 text-sky-100',
            'completed' => 'border-emerald-400/40 bg-emerald-400/15 text-emerald-100',
            'cancelled' => 'border-rose-400/40 bg-rose-400/10 text-rose-100',
        ];
    @endphp

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-sm uppercase tracking-wider text-slate-400">Visible tasks</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $tasks->count() }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $tasks->total() }} total across pagination</p>
        </article>

        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-sm uppercase tracking-wider text-slate-400">Awaiting action</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $statusCounts->get('pending', 0) + $statusCounts->get('in_progress', 0) }}</p>
            <p class="mt-1 text-xs text-slate-500">Pending or in-progress tasks assigned to you</p>
        </article>

        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/30">
            <p class="text-sm uppercase tracking-wider text-slate-400">Completed</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $statusCounts->get('completed', 0) }}</p>
            <p class="mt-1 text-xs text-slate-500">Nice work—keep shipping great results.</p>
        </article>
    </div>

    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-slate-900/40">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 px-6 py-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Task list</h2>
                <p class="text-xs text-slate-400">Latest tasks first. Use browser search (⌘/Ctrl+F) for quick filtering.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800/90 text-left text-sm text-slate-300">
                <thead class="bg-slate-900/70 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-3">Task</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Assignee</th>
                        <th class="px-6 py-3">Deadline</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/70">
                    @forelse ($tasks as $task)
                        @php
                            $badgeClass = $palette[$task->status] ?? 'border-slate-500/40 bg-slate-500/10 text-slate-100';
                        @endphp
                        <tr class="transition hover:bg-slate-900">
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-white">{{ $task->name }}</div>
                                <p class="mt-1 text-xs text-slate-500">Created {{ $task->created_at?->diffForHumans() ?? 'N/A' }}</p>
                                @if ($task->description)
                                    <p class="mt-2 text-xs text-slate-400 line-clamp-2">{{ $task->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span class="rounded-full border border-slate-700 bg-slate-800/80 px-3 py-1 text-xs text-slate-200">
                                    {{ $task->category->name ?? 'Uncategorised' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-700 bg-slate-800/70 text-xs font-semibold uppercase text-slate-200">
                                        {{ strtoupper(substr($task->user->name ?? 'NA', 0, 2)) }}
                                    </span>
                                    <div>
                                        <p class="text-sm text-white">{{ $task->user->name ?? 'Unassigned' }}</p>
                                        <p class="text-xs text-slate-500">{{ $task->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @if ($task->deadline)
                                    @php
                                        $deadline = $task->deadline instanceof \Illuminate\Support\Carbon
                                            ? $task->deadline
                                            : \Illuminate\Support\Carbon::parse($task->deadline);
                                    @endphp
                                    <span class="rounded-full border border-slate-700 bg-slate-800/80 px-3 py-1 text-xs text-slate-200">
                                        {{ $deadline->format('M j, Y') }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-500">TBD</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span class="inline-flex items-center gap-2 rounded-full border {{ $badgeClass }} px-3 py-1 text-xs font-semibold uppercase tracking-wide">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ strtoupper(str_replace('_', ' ', $task->status ?? 'unknown')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top text-right">
                                @php
                                    $canManage = auth()->user()?->isAdmin() || auth()->id() === $task->user_id;
                                @endphp
                                @if ($canManage)
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center gap-1 rounded-full border border-slate-700 px-3 py-1 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/60 hover:text-white">
                                            Edit
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-full border border-rose-500/40 bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-100 transition hover:bg-rose-500/20">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-500">View only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                <div class="mx-auto flex max-w-sm flex-col items-center gap-3">
                                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 text-3xl">📭</span>
                                    <p class="text-base font-semibold text-white">Nothing to show yet</p>
                                    <p class="text-xs text-slate-500">Create your first task to see progress roll in.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-800 bg-slate-900/70 px-6 py-4">
            {{ $tasks->withQueryString()->links() }}
        </div>
    </div>
@endsection
