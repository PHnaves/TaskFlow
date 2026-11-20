@php
    $statuses = [
        'pending' => ['label' => 'Pendente', 'dot' => 'bg-pending'],
        'in_progress' => ['label' => 'Em progresso', 'dot' => 'bg-progress'],
        'completed' => ['label' => 'Concluída', 'dot' => 'bg-done'],
    ];

    $priorities = [
        'low' => ['label' => 'Baixa', 'dot' => 'bg-p-low'],
        'medium' => ['label' => 'Média', 'dot' => 'bg-p-medium'],
        'high' => ['label' => 'Alta', 'dot' => 'bg-p-high'],
    ];

    $currentStatus = old('status', $task->status ?? 'pending');
    $currentPriority = old('priority', $task->priority ?? 'medium');
@endphp

<div class="space-y-6">
    <div>
        <label for="title" class="label">Título</label>
        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $task->title ?? '') }}"
            placeholder="Ex.: Revisar contrato com a transportadora"
            maxlength="255"
            required
            autofocus
            @class(['input', 'input-error' => $errors->has('title')])
        >
        @error('title')
            <p class="field-error"><x-icon name="alert" class="mt-0.5 size-4 shrink-0" /><span>{{ $message }}</span></p>
        @enderror
    </div>

    <div>
        <label for="description" class="label">
            Descrição <span class="font-normal text-muted">(opcional)</span>
        </label>
        <textarea
            id="description"
            name="description"
            rows="4"
            placeholder="Detalhes, links, contexto..."
            @class(['input', 'input-error' => $errors->has('description')])
        >{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="field-error"><x-icon name="alert" class="mt-0.5 size-4 shrink-0" /><span>{{ $message }}</span></p>
        @enderror
    </div>

    <fieldset>
        <legend class="label">Status</legend>
        <div class="grid gap-2 sm:grid-cols-3">
            @foreach ($statuses as $value => $option)
                <label>
                    <input type="radio" name="status" value="{{ $value }}" class="peer sr-only" @checked($currentStatus === $value)>
                    <span class="choice-box">
                        <span class="size-2.5 rounded-full {{ $option['dot'] }}"></span>
                        {{ $option['label'] }}
                    </span>
                </label>
            @endforeach
        </div>
        @error('status')
            <p class="field-error"><x-icon name="alert" class="mt-0.5 size-4 shrink-0" /><span>{{ $message }}</span></p>
        @enderror
    </fieldset>

    <fieldset>
        <legend class="label">Prioridade</legend>
        <div class="grid gap-2 sm:grid-cols-3">
            @foreach ($priorities as $value => $option)
                <label>
                    <input type="radio" name="priority" value="{{ $value }}" class="peer sr-only" @checked($currentPriority === $value)>
                    <span class="choice-box">
                        <span class="size-2.5 rounded-full {{ $option['dot'] }}"></span>
                        {{ $option['label'] }}
                    </span>
                </label>
            @endforeach
        </div>
        @error('priority')
            <p class="field-error"><x-icon name="alert" class="mt-0.5 size-4 shrink-0" /><span>{{ $message }}</span></p>
        @enderror
    </fieldset>

    <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        <button type="submit" class="btn btn-primary btn-lg">
            <x-icon name="check" class="size-[18px]" stroke-width="2.5" />
            Salvar tarefa
        </button>
    </div>
</div>
