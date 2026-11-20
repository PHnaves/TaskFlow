@extends('layouts.app')

@section('title', 'Editar tarefa · TaskFlow')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-muted transition hover:text-ink">
            <x-icon name="arrow-left" class="size-4" />
            Voltar às tarefas
        </a>

        <h1 class="mt-4 text-2xl font-semibold tracking-tight sm:text-[28px]">Editar tarefa</h1>
        <p class="mt-1 text-muted">Criada {{ $task->createdAgo() }}.</p>

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="panel mt-6 p-6 sm:p-8">
            @csrf
            @method('PUT')
            @include('tasks._form')
        </form>
    </div>
@endsection
