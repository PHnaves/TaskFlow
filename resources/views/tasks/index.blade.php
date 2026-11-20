@extends('layouts.app')

@section('title', 'Minhas tarefas · TaskFlow')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-semibold">Minhas tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="rounded-md bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Nova tarefa</a>
    </div>

    @php($labels = ['pending' => 'Pendente', 'in_progress' => 'Em progresso', 'completed' => 'Concluída'])
    @php($priorityLabels = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'])

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 flex items-center gap-2 text-sm">
        <label for="priority-filter" class="font-medium">Prioridade:</label>
        <select id="priority-filter" name="priority" onchange="this.form.submit()" class="rounded-md border border-slate-300 px-2 py-1 dark:border-slate-600 dark:bg-slate-900">
            <option value="">Todas</option>
            @foreach ($priorityLabels as $value => $label)
                <option value="{{ $value }}" @selected($priority === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    @forelse ($tasks as $task)
        <article class="mb-3 flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-800">
            <div>
                <h2 class="font-medium {{ $task->status === 'completed' ? 'line-through opacity-60' : '' }}">{{ $task->title }}</h2>
                @if ($task->description)
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $task->description }}</p>
                @endif
                <span class="mt-2 inline-block rounded-full bg-slate-100 px-2 py-0.5 text-xs dark:bg-slate-700">{{ $labels[$task->status] }}</span>
                <span class="mt-2 inline-block rounded-full px-2 py-0.5 text-xs {{ $task->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ($task->priority === 'low' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300') }}">{{ $priorityLabels[$task->priority] }}</span>
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
                <button
                    type="button"
                    data-delete-url="{{ route('tasks.destroy', $task) }}"
                    data-delete-title="{{ $task->title }}"
                    class="font-medium text-red-600 hover:underline dark:text-red-400"
                >Excluir</button>
            </div>
        </article>
    @empty
        <p class="rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 dark:border-slate-600">
            Nenhuma tarefa por aqui. Que paz... ou procrastinação?
        </p>
    @endforelse

    {{-- Modal de confirmação de exclusão --}}
    <dialog id="delete-modal" class="m-auto w-full max-w-sm rounded-xl border border-slate-200 bg-white p-6 text-slate-900 shadow-xl backdrop:bg-black/50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
        <h2 class="text-lg font-semibold">Excluir tarefa?</h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Você está prestes a excluir <strong id="delete-modal-title"></strong>. Essa ação não pode ser desfeita.
        </p>
        <form id="delete-modal-form" method="POST" class="mt-6 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" id="delete-modal-cancel" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700">Cancelar</button>
            <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Excluir</button>
        </form>
    </dialog>

    <script>
        (function () {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-modal-form');
            const title = document.getElementById('delete-modal-title');

            document.querySelectorAll('[data-delete-url]').forEach(function (button) {
                button.addEventListener('click', function () {
                    form.action = button.dataset.deleteUrl;
                    title.textContent = '"' + button.dataset.deleteTitle + '"';
                    modal.showModal();
                });
            });

            document.getElementById('delete-modal-cancel').addEventListener('click', function () {
                modal.close();
            });

            // Clique fora da caixa fecha o modal
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.close();
                }
            });
        })();
    </script>
@endsection
