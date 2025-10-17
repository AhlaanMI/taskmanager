@extends('layouts.app')

@section('title', 'Create an account')

@section('content')
<div class="mx-auto mt-12 max-w-md rounded-3xl border border-slate-800 bg-slate-900/80 p-8 shadow-2xl shadow-slate-900/40">
    <h1 class="text-2xl font-semibold text-white">Create your account</h1>
    <p class="mt-1 text-sm text-slate-400">Get started in less than a minute.</p>

    <form method="POST" action="{{ route('register.submit') }}" class="mt-6 space-y-5">
        @csrf

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
            @error('name') <p class="text-xs font-medium text-rose-300">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
            @error('email') <p class="text-xs font-medium text-rose-300">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
            @error('password') <p class="text-xs font-medium text-rose-300">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Confirm password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
        </div>

        @auth
        @else
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-200">Role (optional)</label>
                <select name="role" class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                    <option value="user" @selected(old('role') === 'user')>User</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
                <p class="text-xs text-slate-500">Only pick “Admin” if you intend to manage the whole workspace.</p>
            </div>
        @endauth

        <button type="submit"
                class="w-full rounded-full bg-indigo-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            Create account
        </button>

        <p class="text-center text-xs text-slate-500">
            Already have an account?
            <a class="font-semibold text-indigo-300 hover:text-indigo-200" href="{{ route('login') }}">Sign in</a>
        </p>
    </form>
</div>
@endsection