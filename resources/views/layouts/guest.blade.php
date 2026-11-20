<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'TaskFlow'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100 text-slate-900 antialiased dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 dark:text-slate-100">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
            <a href="{{ url('/') }}" class="mb-8 flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-600/30">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                <span class="text-2xl font-bold tracking-tight">Task<span class="text-blue-600 dark:text-blue-400">Flow</span></span>
            </a>

            <div class="w-full max-w-md rounded-2xl border border-white/60 bg-white/90 p-8 shadow-xl shadow-slate-900/5 backdrop-blur dark:border-slate-700 dark:bg-slate-800/90">
                @yield('content')
            </div>

            <p class="mt-6 text-xs text-slate-400">Organize o fluxo. Entregue mais.</p>
        </div>
    </body>
</html>
