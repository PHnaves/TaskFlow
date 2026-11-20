@php($input = 'w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 dark:border-slate-600 dark:bg-slate-900')

<div class="space-y-4">
    <div>
        <label for="title" class="mb-1 block text-sm font-medium">Título</label>
        <input id="title" type="text" name="title" value="{{ old('title', $task->title ?? '') }}" required maxlength="255" class="{{ $input }}">
        @error('title')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium">Descrição</label>
        <textarea id="description" name="description" rows="4" class="{{ $input }}">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="mb-1 block text-sm font-medium">Status</label>
        <select id="status" name="status" class="{{ $input }}">
            @foreach (['pending' => 'Pendente', 'in_progress' => 'Em progresso', 'completed' => 'Concluída'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $task->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="priority" class="mb-1 block text-sm font-medium">Prioridade</label>
        <select id="priority" name="priority" class="{{ $input }}">
            @foreach (['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'] as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $task->priority ?? 'medium') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('priority')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3">
        <button type="submit" class="rounded-md bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Salvar</button>
        <a href="{{ route('tasks.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700">Cancelar</a>
    </div>
</div>
