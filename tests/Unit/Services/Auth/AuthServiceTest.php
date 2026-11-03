<?php

namespace Tests\Unit\Services\Auth;

use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = new AuthService;
    }

    public function test_register_creates_a_user_with_hashed_password(): void
    {
        $user = $this->authService->register([
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
        ]);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_register_logs_the_new_user_in(): void
    {
        $user = $this->authService->register([
            'name' => 'Pedro Naves',
            'email' => 'pedro@example.com',
            'password' => 'password123',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::id() === $user->id);
    }

    public function test_login_authenticates_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $authenticated = $this->authService->login([
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertSame($user->id, $authenticated->id);
    }

    public function test_login_throws_validation_exception_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->expectException(ValidationException::class);

        $this->authService->login([
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }

    public function test_login_does_not_authenticate_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        try {
            $this->authService->login([
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        } catch (ValidationException) {
            // esperado
        }

        $this->assertFalse(Auth::check());
    }

    public function test_logout_clears_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->authService->logout();

        $this->assertFalse(Auth::check());
    }
}
