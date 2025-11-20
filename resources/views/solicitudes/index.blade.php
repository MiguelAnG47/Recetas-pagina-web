@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h2 class="text-3xl font-semibold text-brown-800 mb-6 text-center">
        Solicitar Receta con IA 🍳
    </h2>

    {{-- Mensaje de error si existe --}}
    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulario de solicitud --}}
    <form action="{{ route('solicitudes.store') }}" method="POST"
          class="bg-yellow-50 border border-orange-100 p-6 rounded-xl shadow-sm">

        @csrf

        {{-- Descripción de lo que quiere cocinar --}}
        <label for="prompt"
               class="block text-brown-700 font-medium mb-2">
            Describe lo que deseas cocinar:
        </label>

        <textarea name="prompt" id="prompt" rows="4" required
            class="w-full p-3 border border-orange-200 rounded-lg focus:ring-2 
                   focus:ring-orange-300 focus:outline-none bg-white text-brown-800"
            placeholder="Ejemplo: Quiero una receta fácil con pollo, arroz y zanahoria...">
            {{ old('prompt', $prompt ?? '') }}
        </textarea>

        {{-- Ingredientes básicos adicionales --}}
        <div class="mt-6">
            <h3 class="text-md font-semibold text-brown-800 mb-2">
                Ingredientes básicos que puedes tener (marca si tienes):
            </h3>

            <div class="grid grid-cols-2 gap-2 text-brown-700 text-sm">
                @php
                    $basicos = [
                        'aceite de cocina',
                        'mantequilla',
                        'sal',
                        'azúcar',
                        'harina',
                        'arroz',
                        'pasta',
                        'ajo',
                        'cebolla',
                        'tomate',
                        'limón',
                        'leche',
                        'huevos'
                    ];
                @endphp

                @foreach ($basicos as $item)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="basicos[]" value="{{ $item }} "
                               class="h-4 w-4 text-orange-400">
                        <span>{{ ucfirst($item) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botón enviar --}}
        <button type="submit"
            class="mt-6 bg-orange-200 hover:bg-orange-300 text-brown-800 font-semibold
                   px-6 py-2 rounded-lg transition-all">
            Generar Receta
        </button>

    </form>

    {{-- Mostrar receta generada por IA --}}
    @isset($receta)
        <div class="mt-10 bg-white border border-yellow-200 rounded-xl shadow-lg p-6">

            <h3 class="text-2xl font-semibold text-brown-800 mb-4">
                🍽️ Recetas Generadas con IA
            </h3>
            <pre class="whitespace-pre-wrap text-brown-700 leading-6">
                {{ $receta }}
            </pre>

            {{-- Botón para agregar a favoritas --}}
            <form action="{{ route('recetas.store') }}" method="POST" class="mt-6">
                @csrf

                <input type="hidden" name="titulo" value="{{ $prompt }}">
                <input type="hidden" name="contenido" value="{{ $receta }}">

                <button type="submit"
                    class="bg-yellow-200 hover:bg-yellow-300 text-brown-800 font-semibold 
                           px-5 py-2 rounded-lg transition-all">
                    ⭐ Agregar a favoritas
                </button>
            </form>

        </div>
    @else
        <p>No se pudo generar la receta.</p> <!-- Mensaje para el caso de que no haya receta -->

    @endisset

</div>
@endsection
