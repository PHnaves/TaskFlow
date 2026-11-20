@extends('layouts.app')

@section('title', 'Minhas tarefas · TaskFlow')

@section('content')
    @php
        // Colunas do quadro (uma por status).
        $columns = [
            'pending' => ['label' => 'Pendentes', 'dot' => 'bg-pending', 'empty' => 'Nada pendente por aqui.'],
            'in_progress' => ['label' => 'Em progresso', 'dot' => 'bg-progress', 'empty' => 'Nada em andamento agora.'],
            'completed' => ['label' => 'Concluídas', 'dot' => 'bg-done', 'empty' => 'Nenhuma tarefa concluída ainda.'],
        ];

        $filters = [
            '' => ['label' => 'Todas', 'dot' => null],
            'high' => ['label' => 'Alta', 'dot' => 'bg-p-high'],
            'medium' => ['label' => 'Média', 'dot' => 'bg-p-medium'],
            'low' => ['label' => 'Baixa', 'dot' => 'bg-p-low'],
        ];

        $grouped = $tasks->groupBy('status');
        $total = array_sum($counts);
        $percent = $total > 0 ? (int) round($counts['completed'] / $total * 100) : 0;
        $firstName = Str::before(auth()->user()->name, ' ');
    @endphp

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight sm:text-[28px]">Minhas tarefas</h1>
            <p class="mt-1 text-muted">
                @if ($total === 0)
                    Olá, {{ $firstName }}! Vamos criar a primeira tarefa?
                @else
                    Olá, {{ $firstName }}!
                    Você tem {{ $counts['in_progress'] }} em andamento e
                    {{ $counts['pending'] }} {{ $counts['pending'] === 1 ? 'pendente' : 'pendentes' }}.
                @endif
            </p>
        </div>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg">
            <x-icon name="plus" class="size-[18px]" stroke-width="2.5" />
            Nova tarefa
        </a>
    </div>

    @if ($total === 0)
        {{-- Estado vazio: ainda não há nenhuma tarefa --}}
        <div class="panel mt-8 grid place-items-center border-dashed px-6 py-20 text-center">
            <span class="grid size-16 place-items-center rounded-2xl bg-brand-soft text-brand-ink">
                <x-icon name="clipboard" class="size-8" stroke-width="1.75" />
            </span>
            <h2 class="mt-5 text-lg font-semibold">Nenhuma tarefa por aqui</h2>
            <p class="mt-1 max-w-sm text-muted">
                Que paz... ou procrastinação? Crie sua primeira tarefa e comece a acompanhar o seu fluxo de trabalho.
            </p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg mt-6">
                <x-icon name="plus" class="size-[18px]" stroke-width="2.5" />
                Criar primeira tarefa
            </a>
        </div>
    @else
        {{-- Barra de ferramentas: filtro por prioridade + progresso geral --}}
        <div class="mt-7 flex flex-wrap items-center justify-between gap-x-8 gap-y-4">
            <div class="flex items-center gap-3">
                <span class="hidden text-sm font-medium text-muted sm:inline">Prioridade</span>
                <nav class="segmented" aria-label="Filtrar por prioridade">
                    @foreach ($filters as $value => $filter)
                        <a
                            href="{{ $value === '' ? route('tasks.index') : route('tasks.index', ['priority' => $value]) }}"
                            @class(['segment', 'segment-active' => (string) $priority === (string) $value])
                            @if ((string) $priority === (string) $value) aria-current="page" @endif
                        >
                            @if ($filter['dot'])
                                <span class="size-2 rounded-full {{ $filter['dot'] }}"></span>
                            @endif
                            {{ $filter['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="flex min-w-60 flex-1 items-center gap-3 sm:max-w-sm" title="{{ $counts['completed'] }} de {{ $total }} tarefas concluídas">
                <div class="progress" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progresso geral">
                    <div class="progress-bar" style="width: {{ $percent }}%"></div>
                </div>
                <span class="whitespace-nowrap text-sm font-medium text-ink-2">
                    <span class="font-semibold text-ink">{{ $percent }}%</span> concluído
                </span>
            </div>
        </div>

        {{-- Quadro Kanban --}}
        <div class="mt-6 grid gap-5 lg:grid-cols-3">
            @foreach ($columns as $status => $column)
                @php($items = $grouped->get($status, collect()))

                <section class="lane" aria-labelledby="lane-{{ $status }}">
                    <header class="lane-header">
                        <span class="size-2.5 rounded-full {{ $column['dot'] }}"></span>
                        <h2 id="lane-{{ $status }}" class="text-sm font-semibold">{{ $column['label'] }}</h2>
                        <span class="lane-count">{{ $items->count() }}</span>
                    </header>

                    <div class="space-y-3">
                        @forelse ($items as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <p class="lane-empty">
                                {{ $priority ? 'Nenhuma tarefa com essa prioridade.' : $column['empty'] }}
                            </p>
                        @endforelse

                        @if ($status === 'pending')
                            <a href="{{ route('tasks.create') }}" class="add-card">
                                <x-icon name="plus" class="size-4" />
                                Adicionar tarefa
                            </a>
                        @endif
                    </div>
                </section>
            @endforeach
        </div>
    @endif

    @include('tasks._delete-modal')
@endsection
