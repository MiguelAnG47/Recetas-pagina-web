<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Preferencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Importamos Log

class SolicitudController extends Controller
{
    public function index()
    {
        return view('solicitudes.index');
    }

    public function store(Request $request)
    {
        // Validamos que el prompt (los ingredientes) sea proporcionado
        $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        // Obtenemos el usuario autenticado
        $user = Auth::user();
        Log::info("Usuario autenticado: {$user->id}"); // Log del usuario autenticado

        // Obtenemos las preferencias del usuario
        $preferencias = Preferencia::where('usuario_id', $user->id)->first();

        $ingredientesPositivos = $preferencias?->ingredientesPositivos ?? [];
        $ingredientesNegativos = $preferencias?->ingredientesNegativos ?? [];
        $edad = $user->edad ?? 'No especificada';

        // Ingredientes básicos seleccionados
        $basicosSeleccionados = $request->basicos ? implode(", ", $request->basicos) : "Ninguno";

        // ======================================================
        // 🧠 Creación del Prompt Completo
        // ======================================================
        $prompt = <<<EOT
Eres un asistente de recetas especializado en salud, nutrición y cocina personalizada.
Tu tarea es generar **3 recetas distintas** bajo el tema “saludables”, basadas en los siguientes datos reales:

Edad del usuario: {$edad}
Ingredientes positivos: {$this->formatearLista($ingredientesPositivos)}
Ingredientes negativos: {$this->formatearLista($ingredientesNegativos)}
Ingredientes disponibles en cocina: {$request->prompt}
Ingredientes básicos marcados por el usuario: {$basicosSeleccionados}

=== INSTRUCCIONES ===
1. Genera **3 recetas saludables**, con niveles:
   - Nivel 1 → ligera / rápida
   - Nivel 2 → equilibrada
   - Nivel 3 → completa / elaborada

2. Cada receta debe incluir:
   - Título
   - Tiempo total
   - Lista de ingredientes (respetando positivos y evitando negativos)
   - Sustituciones si un ingrediente clave no está disponible
   - Preparación paso a paso
   - Variantes
   - Nota final: “Puedes marcar como favorita esta receta si te gustó.”

3. Personaliza las recetas según la edad del usuario.
4. Sugiere agregar proteína, aceite o básicos si crees que el usuario podría tenerlos.
5. Evita ingredientes negativos por completo.

Formato sugerido:

Receta Nivel 1 – [Título]
Tiempo: XX min
Ingredientes: …
Preparación: …
Notas/sustituciones: …
----------------------

Receta Nivel 2 – [Título]
…

Receta Nivel 3 – [Título]
…

Genera ahora las 3 recetas saludables adaptadas al usuario, usando todos los datos anteriores.
EOT;

        // ======================================================
        // 🔥 Realización de la Llamada a la API de Groq
        // ======================================================
        try {
            // Log: Empezamos la llamada a la API
            Log::info("Llamando a la API de Groq con el prompt: {$prompt}");

            // Realizamos la llamada POST a la API de Groq
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'), // API KEY de Groq
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/responses', [ // Endpoint de Groq
                'model' => 'openai/gpt-oss-20b',  // Modelo que estamos utilizando
                'input' => $prompt,
                'max_output_tokens' => 1500, // Número máximo de tokens en la respuesta
            ]);

            // Verificamos si la respuesta fue exitosa
            if (!$response->successful()) {
                throw new \Exception("Error API Groq: " . $response->body());
            }

            // Log: Respuesta exitosa de la API
            Log::info("Respuesta exitosa de la API de Groq.");

            // Parseamos la respuesta y obtenemos la receta
            $receta = $response->json('output_text');

            // Log: Receta generada
            Log::info("Receta generada exitosamente: " . substr($receta, 0, 100) . '...'); // Muestra solo los primeros 100 caracteres de la receta

        } catch (\Exception $e) {
            // Si hay error, asignamos un mensaje de error
            Log::error("Error al generar receta desde la API de Groq: " . $e->getMessage());
            $receta = "⚠️ Error al generar receta desde la API de Groq.\n" . $e->getMessage();
        }
        Log::info('Respuesta completa de la API:', ['response' => $response->body()]);


        // Retornamos la vista con la receta generada
        return view('solicitudes.index', [
            'prompt' => $request->prompt,
            'receta' => $receta,
        ]);
    }

    // Función para formatear la lista de ingredientes (si están vacíos, lo indica como "No especificado")
    private function formatearLista($items)
    {
        if (empty($items)) {
            return 'No especificado';
        }

        if (is_array($items)) {
            return implode(', ', $items);
        }

        return $items;
    }
}
