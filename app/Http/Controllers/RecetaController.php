<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecetasPreferidas;

class RecetaController extends Controller
{
    // Mostrar recetas favoritas del usuario
    public function index()
    {
        // Obtiene las recetas favoritas del usuario autenticado
        $recetas = RecetasPreferidas::where('usuario_id', Auth::id())->get();

        // Si las recetas están almacenadas como JSON (lista de recetas)
        // puedes decodificarlas antes de pasarlas a la vista
        foreach ($recetas as $receta) {
            if (is_string($receta->recetas)) {
                $receta->recetas = json_decode($receta->recetas, true);
            }
        }

        return view('recetas.index', compact('recetas'));
    }

    // Eliminar receta favorita
    public function destroy($id)
    {
        $receta = RecetasPreferidas::where('usuario_id', Auth::id())->findOrFail($id);
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada correctamente.');
    }
}
