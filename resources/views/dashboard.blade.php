@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Welcome back</h1>
        <p class="mt-1 text-sm text-slate-400">Here's how your team is progressing this week.</p>
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
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/40">
            <p class="text-xs uppercase tracking-wider text-slate-400">Total tasks</p>
            <p class="mt-2 text-4xl font-semibold text-white">{{ $total }}</p>
            <p class="mt-1 text-xs text-slate-500">Across all categories</p>
        </article>

        <article class="rounded-3xl border border-slate-800 bg-emerald-500/10 p-6 shadow-2xl shadow-emerald-900/20">
            <p class="text-xs uppercase tracking-wider text-emerald-200">Completed</p>
            <p class="mt-2 text-4xl font-semibold text-emerald-100">{{ $completed }}</p>
            <p class="mt-1 text-xs text-emerald-200/80">Wins worth celebrating</p>
        </article>

        <article class="rounded-3xl border border-slate-800 bg-amber-500/10 p-6 shadow-2xl shadow-amber-900/20">
            <p class="text-xs uppercase tracking-wider text-amber-200">Pending</p>
            <p class="mt-2 text-4xl font-semibold text-amber-100">{{ $pending }}</p>
            <p class="mt-1 text-xs text-amber-100/70">Waiting for momentum</p>
        </article>

        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-indigo-900/40">
            <p class="text-xs uppercase tracking-wider text-slate-400">Completion rate</p>
            @php
                $rate = $total > 0 ? round(($completed / $total) * 100) : 0;
            @endphp
            <p class="mt-2 text-4xl font-semibold text-white">{{ $rate }}%</p>
            <p class="mt-1 text-xs text-slate-500">Completed out of total tasks</p>
        </article>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-2xl shadow-slate-900/40">
            <h2 class="text-lg font-semibold text-white">Quick actions</h2>
            <p class="mt-1 text-xs text-slate-400">Keep momentum by jumping straight into the most common flows.</p>
            <div class="mt-4 grid gap-3">
                <a href="{{ route('tasks.index') }}" class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-slate-200 transition hover:border-indigo-500/50 hover:text-white">
                    <span>Review task board</span>
                    <span class="text-xs text-slate-500">View assignments</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center justify-between rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-slate-200 transition hover:border-indigo-500/50 hover:text-white">
                    <span>Browse categories</span>
                    <span class="text-xs text-slate-500">Organise workstreams</span>
                </a>
                <a href="{{ route('tasks.create') }}" class="flex items-center justify-between rounded-2xl border border-indigo-500/60 bg-indigo-500/15 px-4 py-3 text-sm font-semibold text-indigo-100 transition hover:bg-indigo-500/25">
                    <span>Log a new task</span>
                    <span class="text-xs">Stay ahead</span>
                </a>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-2xl shadow-slate-900/40">
            <h2 class="text-lg font-semibold text-white">Today</h2>
            <p class="mt-1 text-xs text-slate-400">One-liners to keep you aligned.</p>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li class="flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    {{ now()->format('l, F jS') }} — focus on wrapping up the oldest pending task.
                </li>
                <li class="flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                    <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                    Schedule a retro once completion rate hits 80%.
                </li>
                <li class="flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    Nudge owners of tasks past their deadline.
                </li>
            </ul>
        </section>
    </div>
@endsection
