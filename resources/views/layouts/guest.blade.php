<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'TaskFlow'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-900 dark:text-slate-100">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
            <a href="{{ url('/') }}" class="mb-8 flex items-center gap-2 text-2xl font-bold text-blue-700 dark:text-blue-400">
                TaskFlow
            </a>

            <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                @yield('content')
            </div>
        </div>
    </body>
</html>
