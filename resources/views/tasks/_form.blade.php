@php($input = 'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/30 dark:border-slate-600 dark:bg-slate-900')

<div class="space-y-5">
    <div>
        <label for="title" class="mb-1.5 block text-sm font-medium">Título</label>
        <input id="title" type="text" name="title" value="{{ old('title', $task->title ?? '') }}" required maxlength="255" autofocus placeholder="O que precisa ser feito?" class="{{ $input }}">
        @error('title')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1.5 block text-sm font-medium">Descrição</label>
        <textarea id="description" name="description" rows="4" placeholder="Detalhes, links, contexto..." class="{{ $input }}">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="status" class="mb-1.5 block text-sm font-medium">Status</label>
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
            <label for="priority" class="mb-1.5 block text-sm font-medium">Prioridade</label>
            <select id="priority" name="priority" class="{{ $input }}">
                @foreach (['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('priority', $task->priority ?? 'medium') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/30 transition hover:from-blue-700 hover:to-indigo-700">Salvar</button>
        <a href="{{ route('tasks.index') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium transition hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700">Cancelar</a>
    </div>
</div>
