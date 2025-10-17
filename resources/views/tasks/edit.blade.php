@extends('layouts.app')

@section('title', 'Edit Task')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Update task</h1>
        <p class="mt-1 text-sm text-slate-400">Refine scope, adjust deadlines, or reassign ownership in seconds.</p>
    </div>
    @if (Route::has('tasks.show'))
        <a href="{{ route('tasks.show', $task) }}" class="hidden items-center gap-2 rounded-full border border-slate-700 px-5 py-2 text-sm font-semibold text-slate-200 transition hover:border-slate-500/80 hover:text-white md:inline-flex">
            View task
        </a>
    @endif
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
        @include('tasks._form', [
            'action' => route('tasks.update', $task),
            'method' => 'PUT',
            'task' => $task,
            'categories' => $categories,
            'users' => $users,
        ])
    </div>
@endsection
