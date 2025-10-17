@extends('layouts.app')

@section('title', 'New Category')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Create category</h1>
        <p class="mt-1 text-sm text-slate-400">Organise related workstreams under a shared label.</p>
    </div>
@endsection

@section('page-actions')
    <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-5 py-2 text-sm font-semibold text-slate-200 transition hover:border-slate-500/80 hover:text-white">
        ← Back to categories
    </a>
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
        @include('categories._form', [
            'action' => route('categories.store'),
            'method' => 'POST',
            'category' => $category,
            'statuses' => $statuses,
        ])
    </div>
@endsection
