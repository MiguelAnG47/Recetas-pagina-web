<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Autenticar con login real
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Una vez logueado, acceder a la ruta
        $response = $this->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Login normal (sin actingAs)
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Enviar confirmación
        $response = $this->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Login normal
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Enviar contraseña incorrecta
        $response = $this->post('/confirm-password', [
            'password' => 'incorrecta',
        ]);

        $response->assertSessionHasErrors();
    }
}
