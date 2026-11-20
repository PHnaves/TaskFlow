@extends('layouts.app')

@section('title', 'Nova tarefa · TaskFlow')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted transition hover:text-ink">
            <x-icon name="arrow-left" class="size-4" />
            Voltar às tarefas
        </a>

        <h1 class="mt-4 text-2xl font-semibold tracking-tight sm:text-[28px]">Nova tarefa</h1>
        <p class="mt-1 text-muted">Descreva o que precisa ser feito e defina a prioridade.</p>

        <form method="POST" action="{{ route('tasks.store') }}" class="panel mt-6 p-6 sm:p-8">
            @csrf
            @include('tasks._form')
        </form>
    </div>
@endsection
