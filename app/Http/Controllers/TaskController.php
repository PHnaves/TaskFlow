<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Task\TaskService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {}

    public function index(Request $request): View
    {
        // Ignora valores inválidos na URL (ex.: ?priority=banana) em vez de filtrar por eles.
        $priority = $request->query('priority');
        $priority = in_array($priority, Task::PRIORITIES, true) ? $priority : null;

        return view('tasks.index', [
            'tasks' => $this->taskService->listForUser($request->user(), $priority),
            'counts' => $this->taskService->countByStatus($request->user()),
            'priority' => $priority,
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->taskService->create($request->user(), $request->validated());

        return redirect()->route('tasks.index')->with('status', 'Tarefa criada com sucesso.');
    }

    public function edit(Request $request, Task $task): View
    {
        $this->authorizeOwner($request, $task);

        return view('tasks.edit', ['task' => $task]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorizeOwner($request, $task);

        $this->taskService->update($task, $request->validated());

        return redirect()->route('tasks.index')->with('status', 'Tarefa atualizada.');
    }

    public function complete(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeOwner($request, $task);

        $this->taskService->complete($task);

        return redirect()->route('tasks.index')->with('status', 'Tarefa concluída. Merece um café!');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeOwner($request, $task);

        $this->taskService->delete($task);

        return redirect()->route('tasks.index')->with('status', 'Tarefa excluída.');
    }

    /**
     * Garante que o usuário só mexa nas próprias tarefas (404 caso contrário).
     */
    private function authorizeOwner(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 404);
    }
}
