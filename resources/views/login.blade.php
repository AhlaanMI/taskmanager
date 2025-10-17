@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<div class="mx-auto mt-12 max-w-sm rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
    <h1 class="text-2xl font-semibold text-white">Welcome back</h1>
    <p class="mt-1 text-sm text-slate-400">Sign in to access your workspace.</p>

    <form method="POST" action="{{ route('login.submit') }}" class="mt-6 space-y-5">
        @csrf

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
            @error('email')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
            @error('password')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-900 text-indigo-500 focus:ring-indigo-500">
            Remember me
        </label>

        <button type="submit"
            class="w-full rounded-full bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            Sign in
        </button>
    </form>
</div>
@endsection