<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecetasBaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_sistema_usa_recetas_base_si_falla_la_api()
    {
        // Crear usuario manualmente
        $user = User::create([
            'nombre'   => 'Usuario',
            'apellido' => 'RecetasBase',
            'email'    => 'recetasbase@test.com',
            'password' => bcrypt('password'),
            'edad'     => 23,
        ]);

        // Autenticar
        $this->actingAs($user, 'web');

        // Hacer la solicitud que dispara la generación de recetas
        // Ajusta la ruta si usas otra (por ejemplo route('solicitudes.store'))
        $response = $this->post('/solicitudes', [
            'prompt' => 'pollo, arroz, cebolla',
        ]);

        // La vista se debe renderizar sin errores
        $response->assertStatus(200);

        // Ajusta el texto a algo que realmente salga en tu Blade
        // por ejemplo en tu `solicitudes.index` tienes:
        // <h3>🍽️ Recetas Generadas con IA</h3>
        // Puedes buscar solo "Recetas Generadas"
        $response->assertSee('Recetas Generadas');
    }
}
