@extends('layouts.app')

@section('title', 'Minhas tarefas · TaskFlow')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-semibold">Minhas tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="rounded-md bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Nova tarefa</a>
    </div>

    @php($labels = ['pending' => 'Pendente', 'in_progress' => 'Em progresso', 'completed' => 'Concluída'])

    @forelse ($tasks as $task)
        <article class="mb-3 flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div>
                <h2 class="font-medium {{ $task->status === 'completed' ? 'line-through opacity-60' : '' }}">{{ $task->title }}</h2>
                @if ($task->description)
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $task->description }}</p>
                @endif
                <span class="mt-2 inline-block rounded-full bg-slate-100 px-2 py-0.5 text-xs dark:bg-slate-700">{{ $labels[$task->status] }}</span>
            </div>

            <div class="flex shrink-0 items-center gap-3 text-sm">
                @if ($task->status !== 'completed')
                    <form method="POST" action="{{ route('tasks.complete', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="font-medium text-green-700 hover:underline dark:text-green-400">Concluir</button>
                    </form>
                @endif
                <a href="{{ route('tasks.edit', $task) }}" class="font-medium text-blue-700 hover:underline dark:text-blue-400">Editar</a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Excluir esta tarefa?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-medium text-red-600 hover:underline dark:text-red-400">Excluir</button>
                </form>
            </div>
        </article>
    @empty
        <p class="rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 dark:border-slate-600">
            Nenhuma tarefa por aqui. Que paz... ou procrastinação?
        </p>
    @endforelse
@endsection
