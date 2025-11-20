<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        // Crear usuario real
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Intentar login normal (sin actingAs)
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));

        // Verificar login con guard real
        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'clave-mal',
        ]);

        // Debe seguir como invitado
        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        // Crear usuario e iniciar sesión con POST
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Login normal
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Logout (sin actingAs)
        $response = $this->post('/logout');

        $response->assertRedirect('/');

        // Verificar que ya NO está autenticado
        $this->assertGuest();
    }
}
