@extends('layouts.guest')

@section('title', 'Entrar · TaskFlow')

@section('content')
    <h1 class="mb-1 text-2xl font-bold tracking-tight">Entrar</h1>
    <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">
        Acesse sua conta para gerenciar suas tarefas.
    </p>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Senha</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                <input id="remember" type="checkbox" name="remember" class="rounded border-slate-300">
                Lembrar de mim
            </label>
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/30 transition hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
        >
            Entrar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Ainda não tem conta?
        <a href="{{ route('register') }}" class="font-medium text-blue-700 hover:underline dark:text-blue-400">Cadastre-se</a>
    </p>
@endsection
