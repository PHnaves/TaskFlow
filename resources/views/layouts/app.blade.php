<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'TaskFlow'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-900 dark:text-slate-100">
        <header class="border-b border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-4">
                <a href="{{ route('tasks.index') }}" class="text-xl font-bold text-blue-700 dark:text-blue-400">TaskFlow</a>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-slate-500 dark:text-slate-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="font-medium text-blue-700 hover:underline dark:text-blue-400">Sair</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-4xl px-4 py-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
