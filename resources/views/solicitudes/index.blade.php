@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h2 class="text-2xl font-semibold text-brown-800 mb-6 text-center">Solicitar Receta con IA 🍳</h2>

    {{-- Formulario de solicitud --}}
    <form action="{{ route('solicitudes.store') }}" method="POST" class="bg-yellow-50 border border-orange-100 p-6 rounded-xl shadow-sm">
        @csrf
        <label for="prompt" class="block text-brown-700 font-medium mb-2">Describe lo que deseas cocinar:</label>
        <textarea name="prompt" id="prompt" rows="4" required
            class="w-full p-3 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-300 focus:outline-none bg-white text-brown-800"
            placeholder="Ejemplo: Quiero una receta fácil con pollo, arroz y zanahoria...">{{ old('prompt', $prompt ?? '') }}</textarea>

        @error('prompt')
            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit"
            class="mt-4 bg-orange-200 hover:bg-orange-300 text-brown-800 font-semibold px-6 py-2 rounded-lg transition-all">
            Generar Receta
        </button>
    </form>

    {{-- Mostrar resultado de la IA --}}
    @isset($receta)
    <div class="mt-8 bg-white border border-yellow-200 rounded-xl shadow-md p-6">
        <h3 class="text-xl font-semibold text-brown-800 mb-3">🍽️ Receta Generada</h3>
        <pre class="whitespace-pre-wrap text-brown-700">{{ $receta }}</pre>

        {{-- Botón de favoritos --}}
        <form action="{{ route('recetas.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="titulo" value="{{ $prompt }}">
            <input type="hidden" name="contenido" value="{{ $receta }}">
            <button type="submit"
                class="bg-yellow-200 hover:bg-yellow-300 text-brown-800 font-semibold px-5 py-2 rounded-lg transition-all">
                ⭐ Agregar a favoritas
            </button>
        </form>
    </div>
    @endisset
</div>
@endsection
