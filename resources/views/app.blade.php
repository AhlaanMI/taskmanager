<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} | @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Breeze setup -->
</head>
<body class="bg-gray-100 text-gray-900">

    <nav class="bg-white shadow p-4 flex justify-between">
        <a href="{{ route('dashboard') }}" class="font-bold">Task Manager</a>
        <div>
            @auth
                <span>{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 ml-4">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="p-6">
        @include('components.alerts')
        @yield('content')
    </main>

</body>
</html>
