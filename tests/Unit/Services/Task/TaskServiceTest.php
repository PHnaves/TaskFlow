<?php

namespace Tests\Unit\Services\Task;

use App\Models\Task;
use App\Models\User;
use App\Services\Task\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_attaches_task_to_user(): void
    {
        $user = User::factory()->create();

        $task = (new TaskService)->create($user, ['title' => 'Nova']);

        $this->assertSame($user->id, $task->user_id);
        $this->assertSame(Task::STATUS_PENDING, $task->fresh()->status);
    }

    public function test_complete_marks_task_as_completed(): void
    {
        $task = Task::factory()->create();

        (new TaskService)->complete($task);

        $this->assertSame(Task::STATUS_COMPLETED, $task->fresh()->status);
    }

    public function test_list_returns_only_user_tasks(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(2)->for($user)->create();
        Task::factory()->create();

        $this->assertCount(2, (new TaskService)->listForUser($user));
    }
}
