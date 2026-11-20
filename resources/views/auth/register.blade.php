@extends('layouts.guest')

@section('title', 'Criar conta · TaskFlow')

@section('content')
    <h1 class="text-[28px] font-semibold leading-tight tracking-tight">Crie sua conta</h1>
    <p class="mt-2 text-muted">Comece a organizar suas tarefas em poucos segundos.</p>

    <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5">
        @csrf

        <x-field
            name="name"
            label="Nome"
            icon="user"
            placeholder="Como devemos te chamar?"
            autocomplete="name"
            required
            autofocus
        />

        <x-field
            name="email"
            label="E-mail"
            type="email"
            icon="mail"
            placeholder="voce@empresa.com"
            autocomplete="username"
            required
        />

        <x-field
            name="password"
            label="Senha"
            type="password"
            icon="lock"
            placeholder="Crie uma senha"
            hint="Use pelo menos 8 caracteres."
            autocomplete="new-password"
            required
        />

        <x-field
            name="password_confirmation"
            label="Confirmar senha"
            type="password"
            icon="lock"
            placeholder="Repita a senha"
            autocomplete="new-password"
            required
        />

        <button type="submit" class="btn btn-primary btn-lg btn-block">Criar conta</button>
    </form>

    <p class="mt-8 text-center text-sm text-muted">
        Já tem conta?
        <a href="{{ route('login') }}" class="link">Entrar</a>
    </p>
@endsection
