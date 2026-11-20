<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/tasks')->assertRedirect('/login');
    }

    public function test_user_sees_only_own_tasks(): void
    {
        $user = User::factory()->create();
        $mine = Task::factory()->for($user)->create(['title' => 'Minha tarefa']);
        $other = Task::factory()->create(['title' => 'Tarefa alheia']);

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertOk()->assertSee($mine->title)->assertDontSee($other->title);
    }

    public function test_user_can_create_a_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Escrever testes',
            'description' => 'Cobrir o CRUD',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'title' => 'Escrever testes',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    public function test_task_requires_a_title(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', ['title' => ''])->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_rejects_invalid_status(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/tasks', ['title' => 'X', 'status' => 'bogus'])
            ->assertSessionHasErrors('status');
    }

    public function test_task_defaults_to_medium_priority(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', ['title' => 'Sem prioridade']);

        $this->assertDatabaseHas('tasks', ['title' => 'Sem prioridade', 'priority' => 'medium']);
    }

    public function test_task_rejects_invalid_priority(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/tasks', ['title' => 'X', 'priority' => 'urgentissima'])
            ->assertSessionHasErrors('priority');
    }

    public function test_user_can_filter_tasks_by_priority(): void
    {
        $user = User::factory()->create();
        Task::factory()->for($user)->create(['title' => 'Apagar incendio', 'priority' => 'high']);
        Task::factory()->for($user)->create(['title' => 'Regar planta', 'priority' => 'low']);

        $this->actingAs($user)->get('/tasks?priority=high')
            ->assertOk()
            ->assertSee('Apagar incendio')
            ->assertDontSee('Regar planta');
    }

    public function test_user_can_update_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $this->actingAs($user)
            ->put("/tasks/{$task->id}", ['title' => 'Novo título', 'status' => 'in_progress'])
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Novo título', 'status' => 'in_progress']);
    }

    public function test_user_can_complete_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $this->actingAs($user)->patch("/tasks/{$task->id}/complete")->assertRedirect('/tasks');

        $this->assertSame('completed', $task->fresh()->status);
    }

    public function test_user_can_delete_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $this->actingAs($user)->delete("/tasks/{$task->id}")->assertRedirect('/tasks');

        $this->assertModelMissing($task);
    }

    public function test_user_cannot_touch_someone_elses_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->actingAs($user)->get("/tasks/{$task->id}/edit")->assertNotFound();
        $this->actingAs($user)->put("/tasks/{$task->id}", ['title' => 'Hack'])->assertNotFound();
        $this->actingAs($user)->delete("/tasks/{$task->id}")->assertNotFound();
        $this->assertModelExists($task);
    }
}
