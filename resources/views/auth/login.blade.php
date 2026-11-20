@extends('layouts.guest')

@section('title', 'Entrar · TaskFlow')

@section('content')
    <h1 class="text-[28px] font-semibold leading-tight tracking-tight">Bem-vindo de volta</h1>
    <p class="mt-2 text-muted">Entre na sua conta para continuar organizando suas tarefas.</p>

    @if (session('status'))
        <div class="mt-6 flex items-start gap-2.5 rounded-field bg-ok-soft px-4 py-3 text-sm text-ok-ink">
            <x-icon name="check-circle" class="mt-0.5 size-4 shrink-0" />
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
        @csrf

        <x-field
            name="email"
            label="E-mail"
            type="email"
            icon="mail"
            placeholder="voce@empresa.com"
            autocomplete="username"
            required
            autofocus
        />

        <x-field
            name="password"
            label="Senha"
            type="password"
            icon="lock"
            placeholder="Digite sua senha"
            autocomplete="current-password"
            required
        />

        <label for="remember" class="flex w-fit cursor-pointer items-center gap-2.5 text-sm text-ink-2">
            <input id="remember" type="checkbox" name="remember" class="checkbox">
            Lembrar de mim
        </label>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
    </form>

    <p class="mt-8 text-center text-sm text-muted">
        Ainda não tem conta?
        <a href="{{ route('register') }}" class="link">Cadastre-se</a>
    </p>
@endsection
