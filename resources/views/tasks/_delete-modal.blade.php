{{-- Modal de confirmação de exclusão (aberto pelo JS em resources/js/app.js) --}}
<dialog id="delete-modal" class="modal" aria-labelledby="delete-modal-title">
    <div class="flex items-start gap-4">
        <span class="grid size-11 shrink-0 place-items-center rounded-full bg-danger-soft text-danger-ink">
            <x-icon name="trash" class="size-5" />
        </span>

        <div class="min-w-0">
            <h2 id="delete-modal-title" class="text-lg font-semibold">Excluir tarefa?</h2>
            <p class="mt-1.5 text-sm leading-relaxed text-muted">
                Você está prestes a excluir
                <strong class="break-words font-semibold text-ink" data-delete-target></strong>.
                Essa ação não pode ser desfeita.
            </p>
        </div>
    </div>

    <form method="POST" class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        @csrf
        @method('DELETE')

        <button type="button" class="btn btn-secondary" data-modal-close autofocus>Cancelar</button>
        <button type="submit" class="btn btn-danger">
            <x-icon name="trash" class="size-4" />
            Excluir tarefa
        </button>
    </form>
</dialog>
