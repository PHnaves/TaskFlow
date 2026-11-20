@php
    $priorityLabels = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'];
    $isDone = $task->status === 'completed';
@endphp

<article @class(['task-card', 'is-done' => $isDone])>
    <div class="flex items-start gap-2.5">
        @if ($isDone)
            <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-done text-white">
                <x-icon name="check" class="size-3" stroke-width="3" />
            </span>
        @endif

        <div class="min-w-0 flex-1">
            <h3 class="task-title" title="{{ $task->title }}">{{ $task->title }}</h3>

            @if ($task->description)
                <p class="task-desc">{{ $task->description }}</p>
            @endif
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between gap-2">
        <div class="flex min-w-0 items-center gap-2.5">
            <span class="chip chip-{{ $task->priority }}">
                <span class="dot"></span>{{ $priorityLabels[$task->priority] }}
            </span>
            <time class="flex items-center gap-1 truncate text-xs text-muted" datetime="{{ $task->created_at->toIso8601String() }}">
                <x-icon name="clock" class="size-3.5 shrink-0" />
                <span class="truncate">{{ $task->createdAgo() }}</span>
            </time>
        </div>

        <div class="-mr-1.5 flex shrink-0 items-center">
            @unless ($isDone)
                <form method="POST" action="{{ route('tasks.complete', $task) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="icon-btn icon-btn-ok" title="Concluir" aria-label="Concluir tarefa {{ $task->title }}">
                        <x-icon name="check" class="size-4" />
                    </button>
                </form>
            @endunless

            <a href="{{ route('tasks.edit', $task) }}" class="icon-btn" title="Editar" aria-label="Editar tarefa {{ $task->title }}">
                <x-icon name="pencil" class="size-4" />
            </a>

            <button
                type="button"
                class="icon-btn icon-btn-danger"
                title="Excluir"
                aria-label="Excluir tarefa {{ $task->title }}"
                data-delete-url="{{ route('tasks.destroy', $task) }}"
                data-delete-title="{{ $task->title }}"
            >
                <x-icon name="trash" class="size-4" />
            </button>
        </div>
    </div>
</article>
