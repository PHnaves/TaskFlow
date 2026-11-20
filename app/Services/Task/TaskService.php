<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * Lista as tarefas do usuário, da mais recente para a mais antiga.
     * Quando $priority é informada, filtra apenas por ela.
     *
     * @return Collection<int, Task>
     */
    public function listForUser(User $user, ?string $priority = null): Collection
    {
        return $user->tasks()
            ->when(
                in_array($priority, Task::PRIORITIES, true),
                fn ($query) => $query->where('priority', $priority),
            )
            ->latest()
            ->get();
    }

    /**
     * Conta as tarefas do usuário por status (sempre com as três chaves),
     * independente de qualquer filtro aplicado na listagem.
     *
     * @return array{pending: int, in_progress: int, completed: int}
     */
    public function countByStatus(User $user): array
    {
        $counts = $user->tasks()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            Task::STATUS_PENDING => (int) $counts->get(Task::STATUS_PENDING, 0),
            Task::STATUS_IN_PROGRESS => (int) $counts->get(Task::STATUS_IN_PROGRESS, 0),
            Task::STATUS_COMPLETED => (int) $counts->get(Task::STATUS_COMPLETED, 0),
        ];
    }

    /**
     * Cria uma tarefa para o usuário.
     *
     * @param  array{title: string, description?: string|null, status?: string, priority?: string}  $data
     */
    public function create(User $user, array $data): Task
    {
        return $user->tasks()->create($data);
    }

    /**
     * Atualiza os dados de uma tarefa.
     *
     * @param  array{title?: string, description?: string|null, status?: string, priority?: string}  $data
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function complete(Task $task): Task
    {
        $task->markAsCompleted();

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
