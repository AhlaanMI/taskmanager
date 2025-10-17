<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Task Manager') }} — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-br from-slate-900 via-slate-950 to-black"></div>
    <div class="relative flex min-h-screen flex-col">
        <nav class="border-b border-slate-800 bg-slate-900/70 backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-lg font-semibold text-white">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-500/90 text-sm font-bold uppercase">
                            TM
                        </span>
                        <span>{{ config( 'Task Manager') }}</span>
                    </a>
                    @auth
                        <div class="hidden items-center gap-1 rounded-full border border-slate-800 bg-slate-900/60 px-1 py-1 text-sm text-slate-300 md:flex">
                            <a href="{{ route('tasks.index') }}" class="rounded-full px-3 py-1 font-medium transition {{ request()->routeIs('tasks.*') ? 'bg-indigo-500/80 text-white shadow' : 'hover:bg-slate-800/60 hover:text-white' }}">Tasks</a>
                            <a href="{{ route('categories.index') }}" class="rounded-full px-3 py-1 font-medium transition {{ request()->routeIs('categories.*') ? 'bg-indigo-500/80 text-white shadow' : 'hover:bg-slate-800/60 hover:text-white' }}">Categories</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="rounded-full px-3 py-1 font-medium transition {{ request()->is('admin*') ? 'bg-amber-500/80 text-slate-900 shadow' : 'hover:bg-slate-800/60 hover:text-white' }}">Admin</a>
                            @endif
                        </div>
                    @endauth
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden text-right md:block">
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-800 text-sm font-medium uppercase text-slate-200 md:hidden">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="pointer-events-auto">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-900/70 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-red-500/60 hover:bg-red-500/10 hover:text-red-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <div class="pointer-events-auto flex items-center gap-2 text-sm">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="rounded-full border border-slate-800 bg-slate-900/60 px-4 py-2 font-semibold text-slate-200 transition hover:border-indigo-500/60 hover:bg-indigo-500/10 hover:text-white">Log in</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full bg-indigo-500 px-4 py-2 font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">Register</a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        @auth
            <div class="border-b border-slate-800 bg-slate-900/40">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-3 text-sm text-slate-400">
                    <div>
                        <span class="font-semibold text-slate-200">Welcome back, {{ \Illuminate\Support\Str::headline(Auth::user()->name) }}.</span>
                        <span class="ml-2">You have {{ Auth::user()->tasks()->count() }} tasks in your queue.</span>
                    </div>
                    <div class="flex items-center gap-3" aria-label="Quick stats">
                        <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900/80 px-3 py-1">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            {{ now()->format('D, M j') }}
                        </span>
                        <span class="hidden rounded-full border border-slate-800 bg-indigo-500/20 px-3 py-1 font-semibold text-indigo-200 md:inline-flex">
                            {{ ucfirst(Auth::user()->role ?? 'user') }}
                        </span>
                    </div>
                </div>
            </div>
        @endauth

        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-6 py-10">
                @include('components.alerts')

                @hasSection('page-header')
                    <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
                        @yield('page-header')
                    </header>
                @endif

                <section class="space-y-8">
                    @yield('content')
                </section>
            </div>
        </main>

        <footer class="border-t border-slate-800 bg-slate-900/60 py-6">
            <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 text-sm text-slate-500 md:flex-row">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Task Manager') }}. All rights reserved.</span>
                <div class="flex items-center gap-4">
                    <a href="https://laravel.com" target="_blank" rel="noopener" class="transition hover:text-white">Built with Laravel</a>
                    <a href="https://tailwindcss.com" target="_blank" rel="noopener" class="transition hover:text-white">Styled with Tailwind</a>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
