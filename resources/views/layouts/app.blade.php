<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts._head')
    </head>
    <body class="min-h-screen">
        <header class="sticky top-0 z-30 border-b border-line bg-surface/80 backdrop-blur-md">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
                <a href="{{ route('tasks.index') }}" aria-label="TaskFlow — início">
                    <x-logo />
                </a>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2.5">
                        <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <div class="hidden leading-tight sm:block">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-muted">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <span class="h-6 w-px bg-line" aria-hidden="true"></span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost h-9 px-3">
                            <x-icon name="logout" class="size-4" />
                            <span class="hidden sm:inline">Sair</span>
                            <span class="sr-only sm:hidden">Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-10">
            @yield('content')
        </main>

        @if (session('status'))
            <div class="toast" role="status" data-toast>
                <span class="mt-px grid size-5 shrink-0 place-items-center rounded-full bg-ok-soft text-ok-ink">
                    <x-icon name="check" class="size-3" stroke-width="3" />
                </span>
                <p class="py-px leading-snug">{{ session('status') }}</p>
                <button type="button" class="icon-btn -my-1 size-7" data-toast-close aria-label="Fechar aviso">
                    <x-icon name="x" class="size-4" />
                </button>
            </div>
        @endif
    </body>
</html>
