@extends('layouts.guest')

@section('title', 'Criar conta · TaskFlow')

@section('content')
    <h1 class="mb-1 text-2xl font-bold tracking-tight">Criar conta</h1>
    <p class="mb-6 text-sm text-slate-500 dark:text-slate-400">
        Cadastre-se para começar a organizar suas tarefas.
    </p>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Nome</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirmar senha</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900"
            >
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/30 transition hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
        >
            Criar conta
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Já tem conta?
        <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:underline dark:text-blue-400">Entrar</a>
    </p>
@endsection
