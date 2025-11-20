<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_profile_page_is_displayed()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Login real
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response = $this->get('/profile');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_profile_information_can_be_updated()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response = $this->patch('/profile', [
            'nombre' => 'NuevoNombre',
            'apellido' => 'NuevoApellido',
            'email' => 'nuevo@example.com',
            'edad' => 25,
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertSame('NuevoNombre', $user->nombre);
        $this->assertSame('NuevoApellido', $user->apellido);
        $this->assertSame('nuevo@example.com', $user->email);
        $this->assertSame(25, $user->edad);
    }

    /** @test */
    public function test_user_can_delete_their_account()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response = $this->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasNoErrors();

        // Usuario debe desaparecer
        $this->assertNull(User::find($user->id));

        // Ya no debe estar autenticado
        $this->assertGuest();
    }

    /** @test */
    public function test_correct_password_must_be_provided_to_delete_account()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response = $this->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHasErrors(['password']);

        // Usuario NO se debe eliminar
        $this->assertNotNull(User::find($user->id));
    }
}
