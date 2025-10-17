@extends('layouts.app')

@section('title', 'Edit Category')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Edit category</h1>
        <p class="mt-1 text-sm text-slate-400">Keep names and descriptions up to date for your team.</p>
    </div>
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
        @include('categories._form', [
            'action' => route('categories.update', $category),
            'method' => 'PUT',
            'category' => $category,
            'statuses' => $statuses,
        ])
    </div>
@endsection
