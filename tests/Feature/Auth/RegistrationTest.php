<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertViewIs('auth.register');
    }

    public function test_registration_screen_is_not_available_to_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    public function test_a_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'pedro@example.com',
        ]);
    }

    public function test_registration_fails_with_duplicated_email(): void
    {
        User::factory()->create(['email' => 'pedro@example.com']);

        $response = $this->post('/register', [
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_fails_when_password_confirmation_does_not_match(): void
    {
        $response = $this->post('/register', [
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_registration_fails_without_required_fields(): void
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }
}
