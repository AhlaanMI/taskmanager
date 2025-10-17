@extends('layouts.app')

@section('title', 'Create Task')

@section('page-header')
	<div>
		<h1 class="text-3xl font-semibold text-white">Create a new task</h1>
		<p class="mt-1 text-sm text-slate-400">Capture the details so everyone understands what needs to happen next.</p>
	</div>
@endsection

@section('content')
	<div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
		@include('tasks._form', [
			'action' => route('tasks.store'),
			'method' => 'POST',
			'task' => $task ?? null,
			'categories' => $categories,
			'users' => $users,
		])
	</div>
@endsection
