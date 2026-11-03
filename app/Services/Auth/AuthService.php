<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Cadastra um novo usuário e já inicia a sessão autenticada.
     *
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return $user;
    }

    /**
     * Autentica um usuário a partir das credenciais informadas.
     *
     * @param  array{email: string, password: string}  $credentials
     *
     * @throws ValidationException quando as credenciais são inválidas.
     */
    public function login(array $credentials, bool $remember = false): User
    {
        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        return Auth::user();
    }

    /**
     * Encerra a sessão do usuário autenticado.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
