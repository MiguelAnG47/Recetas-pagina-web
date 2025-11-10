<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    // Vista principal de la página
    public function index()
    {
        return view('solicitudes.index');
    }

    // Procesar el texto del usuario
    public function store(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        // 🔹 En esta parte se llamará a la API de la IA (aún no implementado)
        // Por ahora simulamos una respuesta
        $recetaGenerada = "Receta simulada para: " . $request->prompt . "\n\n1. Ingredientes...\n2. Preparación...";

        // Retornamos la misma vista con la receta generada
        return view('solicitudes.index', [
            'prompt' => $request->prompt,
            'receta' => $recetaGenerada,
        ]);
    }
}
