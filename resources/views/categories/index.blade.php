@extends('layouts.app')

@section('title', 'Categories')

@section('page-header')
    <div>
        <h1 class="text-3xl font-semibold text-white">Categories</h1>
        <p class="mt-1 text-sm text-slate-400">Group tasks by workstream, initiative, or department.</p>
    </div>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            New category
        </a>
    @endif
@endsection

@section('content')
    <div class="rounded-3xl border border-slate-800 bg-slate-900/80 shadow-2xl shadow-slate-900/40">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 px-6 py-4">
            <div>
                <h2 class="text-xl font-semibold text-white">Category list</h2>
                <p class="text-xs text-slate-400">Colour-coded by status for quick scanning.</p>
            </div>
            <span class="rounded-full border border-slate-800 bg-slate-900/70 px-3 py-1 text-xs text-slate-300">{{ $categories->count() }} categories</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800/90 text-left text-sm text-slate-300">
                <thead class="bg-slate-900/70 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Status</th>
                        @if (auth()->user()->isAdmin())
                            <th class="px-6 py-3 text-right">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/70">
                    @forelse ($categories as $category)
                        <tr class="transition hover:bg-slate-900">
                            <td class="px-6 py-4 align-top">
                                <p class="text-sm font-semibold text-white">{{ $category->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">Created {{ $category->created_at?->diffForHumans() ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4 align-top text-sm text-slate-300">
                                {{ $category->description ?: 'No description provided' }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                @php
                                    $badge = $category->status === 'active'
                                        ? 'border-emerald-400/40 bg-emerald-400/10 text-emerald-100'
                                        : 'border-slate-500/40 bg-slate-500/10 text-slate-100';
                                @endphp
                                <span class="inline-flex items-center gap-2 rounded-full border {{ $badge }} px-3 py-1 text-xs font-semibold uppercase tracking-wide">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    {{ strtoupper($category->status) }}
                                </span>
                            </td>
                            @if (auth()->user()->isAdmin())
                                <td class="px-6 py-4 align-top text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center gap-1 rounded-full border border-slate-700 px-3 py-1 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/60 hover:text-white">
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-full border border-rose-500/40 bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-100 transition hover:bg-rose-500/20">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="px-6 py-12 text-center text-sm text-slate-400">
                                <div class="mx-auto flex max-w-sm flex-col items-center gap-3">
                                    <span class="inline-flex h-16 w-16 items-center justify-center rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 text-3xl">📂</span>
                                    <p class="text-base font-semibold text-white">No categories yet</p>
                                    <p class="text-xs text-slate-500">{{ auth()->user()->isAdmin() ? 'Create a category to start grouping work.' : 'Ask an admin to create categories for your team.' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
