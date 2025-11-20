<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecetasPreferidas;
use App\Models\Preferencia;

class RecetaController extends Controller
{
    // Mostrar recetas favoritas y preferencias
    public function index()
    {
        $userId = Auth::id();

        // Obtener recetas favoritas
        $recetas = RecetasPreferidas::where('usuario_id', $userId)->get();

        foreach ($recetas as $receta) {
            if (is_string($receta->recetas)) {
                $receta->recetas = json_decode($receta->recetas, true);
            }
        }

        // Obtener preferencias del usuario
        $preferencias = Preferencia::where('usuario_id', $userId)->first();

        return view('recetas.index', compact('recetas', 'preferencias'));
    }

    // Guardar preferencias
    public function guardarPreferencias(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'ingredientesPositivos' => 'nullable|string',
            'ingredientesNegativos' => 'nullable|string',
        ]);

        $preferencias = Preferencia::firstOrCreate(
            ['usuario_id' => $userId],
            ['ingredientesPositivos' => null, 'ingredientesNegativos' => null]
        );

        $preferencias->ingredientesPositivos = $request->ingredientesPositivos;
        $preferencias->ingredientesNegativos = $request->ingredientesNegativos;
        $preferencias->save();

        return redirect()->route('recetas.index')->with('success', 'Preferencias actualizadas correctamente.');
    }

    // Eliminar receta favorita
    public function destroy($id)
    {
        $receta = RecetasPreferidas::where('usuario_id', Auth::id())->findOrFail($id);
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada correctamente.');
    }
}
