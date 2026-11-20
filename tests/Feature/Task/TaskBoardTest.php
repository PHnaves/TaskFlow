<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskBoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_board_places_tasks_in_their_status_columns(): void
    {
        $user = User::factory()->create();
        Task::factory()->for($user)->create(['title' => 'Alfa', 'status' => 'pending']);
        Task::factory()->for($user)->create(['title' => 'Bravo', 'status' => 'in_progress']);
        Task::factory()->for($user)->create(['title' => 'Charlie', 'status' => 'completed']);

        $this->actingAs($user)->get('/tasks')
            ->assertOk()
            ->assertSeeInOrder(['Pendentes', 'Alfa', 'Em progresso', 'Bravo', 'Concluídas', 'Charlie']);
    }

    public function test_board_shows_overall_progress_regardless_of_the_filter(): void
    {
        $user = User::factory()->create();
        Task::factory()->for($user)->create(['status' => 'completed', 'priority' => 'low']);
        Task::factory()->for($user)->create(['status' => 'pending', 'priority' => 'high']);

        $response = $this->actingAs($user)->get('/tasks?priority=high');

        $response->assertOk()
            ->assertViewHas('counts', ['pending' => 1, 'in_progress' => 0, 'completed' => 1])
            ->assertSee('50%');
    }

    public function test_invalid_priority_filter_is_ignored(): void
    {
        $user = User::factory()->create();
        Task::factory()->for($user)->create(['title' => 'Primeira', 'priority' => 'high']);
        Task::factory()->for($user)->create(['title' => 'Segunda', 'priority' => 'low']);

        $this->actingAs($user)->get('/tasks?priority=banana')
            ->assertOk()
            ->assertViewHas('priority', null)
            ->assertSee('Primeira')
            ->assertSee('Segunda');
    }

    public function test_empty_state_is_shown_when_the_user_has_no_tasks(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/tasks')
            ->assertOk()
            ->assertSee('Nenhuma tarefa por aqui')
            ->assertSee('Criar primeira tarefa');
    }

    public function test_unknown_pages_render_the_friendly_404(): void
    {
        $this->get('/rota-que-nao-existe')
            ->assertNotFound()
            ->assertSee('Página não encontrada');
    }
}
