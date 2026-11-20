<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use DateTimeInterface;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app()->setLocale('pt_BR');
    }

    public function test_created_ago_says_now_for_tasks_created_within_a_minute(): void
    {
        $task = $this->taskCreatedAt(now()->subSeconds(10));

        $this->assertSame('agora mesmo', $task->createdAgo());
    }

    public function test_created_ago_uses_relative_time_for_older_tasks(): void
    {
        $task = $this->taskCreatedAt(now()->subHours(3));

        $this->assertSame('há 3 horas', $task->createdAgo());
    }

    /**
     * Monta a tarefa só em memória, sem factory: a factory cria um usuário no
     * banco e este teste não usa RefreshDatabase (na CI o banco começa vazio).
     */
    private function taskCreatedAt(DateTimeInterface $date): Task
    {
        $task = new Task;
        $task->created_at = $date;

        return $task;
    }
}
