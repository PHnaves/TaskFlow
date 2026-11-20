<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts._head')
    </head>
    <body class="min-h-screen">
        <main class="flex min-h-screen flex-col items-center justify-center px-6 py-16 text-center">
            <a href="{{ url('/') }}" aria-label="TaskFlow — início">
                <x-logo />
            </a>

            <p class="mt-14 bg-linear-to-br from-indigo-500 to-violet-500 bg-clip-text text-8xl font-bold tracking-tighter text-transparent sm:text-9xl">
                @yield('code')
            </p>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight sm:text-3xl">@yield('heading')</h1>
            <p class="mt-3 max-w-md text-pretty text-muted">@yield('message')</p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <button type="button" class="btn btn-secondary btn-lg" onclick="history.back()">
                    <x-icon name="arrow-left" class="size-[18px]" />
                    Voltar
                </button>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Ir para o início</a>
            </div>
        </main>
    </body>
</html>
