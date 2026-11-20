@extends('layouts.app')

@section('title', 'Minhas tarefas · TaskFlow')

@section('content')
    @php($labels = ['pending' => 'Pendente', 'in_progress' => 'Em progresso', 'completed' => 'Concluída'])
    @php($priorityLabels = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'])
    @php($statusStyles = ['pending' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300', 'in_progress' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300', 'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'])
    @php($priorityStyles = ['low' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300', 'medium' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300', 'high' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'])
    @php($priorityBorder = ['low' => 'border-l-emerald-400', 'medium' => 'border-l-amber-400', 'high' => 'border-l-red-500'])

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">Minhas tarefas</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Acompanhe o que está pendente, em andamento e concluído.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/30 transition hover:from-blue-700 hover:to-indigo-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nova tarefa
        </a>
    </div>

    {{-- Resumo --}}
    <div class="mb-6 grid grid-cols-3 gap-3">
        @foreach (['pending' => ['Pendentes', 'text-slate-700 dark:text-slate-200'], 'in_progress' => ['Em progresso', 'text-blue-600 dark:text-blue-400'], 'completed' => ['Concluídas', 'text-green-600 dark:text-green-400']] as $key => [$name, $color])
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ $name }}</p>
                <p class="mt-1 text-3xl font-bold {{ $color }}">{{ $tasks->where('status', $key)->count() }}</p>
            </div>
        @endforeach
    </div>

    {{-- Filtro --}}
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 flex items-center gap-2 text-sm">
        <label for="priority-filter" class="font-medium text-slate-600 dark:text-slate-300">Filtrar por prioridade:</label>
        <select id="priority-filter" name="priority" onchange="this.form.submit()" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 shadow-sm focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900">
            <option value="">Todas</option>
            @foreach ($priorityLabels as $value => $label)
                <option value="{{ $value }}" @selected($priority === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    @forelse ($tasks as $task)
        <article class="mb-3 flex flex-wrap items-start justify-between gap-4 rounded-xl border border-l-4 border-slate-200 {{ $priorityBorder[$task->priority] }} bg-white p-4 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
            <div class="min-w-0 flex-1">
                <h2 class="font-semibold {{ $task->status === 'completed' ? 'text-slate-400 line-through' : '' }}">{{ $task->title }}</h2>
                @if ($task->description)
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $task->description }}</p>
                @endif
                <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                    <span class="rounded-full px-2.5 py-0.5 font-medium {{ $statusStyles[$task->status] }}">{{ $labels[$task->status] }}</span>
                    <span class="rounded-full px-2.5 py-0.5 font-medium {{ $priorityStyles[$task->priority] }}">Prioridade {{ mb_strtolower($priorityLabels[$task->priority]) }}</span>
                    <span class="text-slate-400">{{ $task->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-2 text-sm">
                @if ($task->status !== 'completed')
                    <form method="POST" action="{{ route('tasks.complete', $task) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-lg bg-green-50 px-3 py-1.5 font-medium text-green-700 transition hover:bg-green-100 dark:bg-green-900/30 dark:text-green-300">Concluir</button>
                    </form>
                @endif
                <a href="{{ route('tasks.edit', $task) }}" class="rounded-lg bg-blue-50 px-3 py-1.5 font-medium text-blue-700 transition hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-300">Editar</a>
                <button
                    type="button"
                    data-delete-url="{{ route('tasks.destroy', $task) }}"
                    data-delete-title="{{ $task->title }}"
                    class="rounded-lg bg-red-50 px-3 py-1.5 font-medium text-red-600 transition hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300"
                >Excluir</button>
            </div>
        </article>
    @empty
        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white/60 p-12 text-center dark:border-slate-600 dark:bg-slate-800/40">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="mt-3 font-medium">Nenhuma tarefa por aqui</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Que paz... ou procrastinação? Crie a primeira tarefa.</p>
        </div>
    @endforelse

    {{-- Modal de confirmação de exclusão --}}
    <dialog id="delete-modal" class="m-auto w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-6 text-slate-900 shadow-xl backdrop:bg-black/50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
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
