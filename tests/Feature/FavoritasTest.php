<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\RecetasPreferidas;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritasTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_agregar_receta_a_favoritas()
    {
        // Crear usuario manualmente (sin factory)
        $user = User::create([
            'nombre'   => 'Santiago',
            'apellido' => 'Test',
            'email'    => 'favoritas@test.com',
            'password' => bcrypt('password'),
            'edad'     => 22,
        ]);

        // Autenticar usuario
        $this->actingAs($user, 'web');

        // Crear receta favorita
        $receta = RecetasPreferidas::create([
            'usuario_id' => $user->id,
            'recetas' => [
                [
                    'nombre' => 'Receta Prueba',
                    'descripcion' => 'Contenido de prueba',
                    'ingredientes' => ['pollo', 'ajo']
                ]
            ]
        ]);

        // Validar que existe en la base de datos
        $this->assertDatabaseHas('recetas_preferidas', [
            'usuario_id' => $user->id,
        ]);

        // Validar contenido del JSON casteado
        $this->assertEquals('Receta Prueba', $receta->recetas[0]['nombre']);
        $this->assertEquals(['pollo', 'ajo'], $receta->recetas[0]['ingredientes']);
    }
}
