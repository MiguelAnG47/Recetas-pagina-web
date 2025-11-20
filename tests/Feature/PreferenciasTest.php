<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Preferencia;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PreferenciasTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_actualizar_sus_preferencias()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        // Autenticar usuario en el guard 'web'
        $this->actingAs($user, 'web');

        $data = [
            'ingredientesPositivos' => 'pollo, ajo',
            'ingredientesNegativos' => 'tomate',
        ];

        $response = $this->post(route('recetas.guardarPreferencias'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('recetas.index'));

        $pref = Preferencia::where('usuario_id', $user->id)->first();

        $this->assertNotNull($pref);
        $this->assertEquals('pollo, ajo', $pref->ingredientesPositivos);
        $this->assertEquals('tomate', $pref->ingredientesNegativos);
    }
}
