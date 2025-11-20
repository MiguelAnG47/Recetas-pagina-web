<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientesTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_guardar_ingredientes_en_la_bd()
    {
        // Crear usuario manualmente
        $user = User::create([
            'nombre'   => 'Usuario',
            'apellido' => 'Ingredientes',
            'email'    => 'ingredientes@test.com',
            'password' => bcrypt('password'),
            'edad'     => 22,
        ]);

        // Autenticar
        $this->actingAs($user, 'web');

        // Llamada al endpoint que guarda ingredientes
        // (ajusta la ruta si en tu web.php se llama diferente)
        $response = $this->post('/ingredientes', [
            'nombre' => 'Pollo',
        ]);

        $response->assertStatus(302);

        // Verificar que se haya guardado en la tabla `ingredientes`
        $this->assertDatabaseHas('ingredientes', [
            'nombre'     => 'Pollo',
            'usuario_id' => $user->id,
        ]);
    }
}
