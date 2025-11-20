@extends('layouts.main')

@section('title', 'Mis Recetas Favoritas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- ============================ --}}
        {{-- CARD PREFERENCIAS DEL USUARIO --}}
        {{-- ============================ --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h5 class="mb-0">Preferencias de Ingredientes</h5>
                <p class="mb-0 small text-muted">Configura ingredientes que te gustan o quieres evitar</p>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('recetas.guardarPreferencias') }}" method="POST">
                    @csrf

                    <div class="row">
                        {{-- Ingredientes Positivos --}}
                        <div class="col-md-6">
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-warning text-dark fw-bold">
                                    Ingredientes que me gustan
                                </div>
                                <div class="card-body">
                                    <textarea name="ingredientesPositivos" rows="4" class="form-control">
                                        {{ $preferencias->ingredientesPositivos ?? '' }}
                                    </textarea>
                                    <small class="text-muted">Separa los ingredientes con comas.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Ingredientes Negativos --}}
                        <div class="col-md-6">
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-danger text-white fw-bold">
                                    Ingredientes que no me gustan
                                </div>
                                <div class="card-body">
                                    <textarea name="ingredientesNegativos" rows="4" class="form-control">
                                        {{ $preferencias->ingredientesNegativos ?? '' }}
                                    </textarea>
                                    <small class="text-muted">Separa los ingredientes con comas.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success px-4">
                            Guardar preferencias
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ========================================== --}}
        {{-- CARD DE RECETAS FAVORITAS (ya existente) --}}
        {{-- ========================================== --}}
        <div class="card shadow-sm border-0">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h4 class="mb-0">Mis Recetas Favoritas</h4>
                <p class="mb-0 small text-muted">Consulta y gestiona tus recetas preferidas</p>
            </div>

            <div class="card-body p-4">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($recetas->isEmpty())
                    <div class="text-center text-muted py-4">
                        <p class="mb-2">No tienes recetas favoritas aún.</p>
                        <a href="{{ route('solicitudes.index') }}" class="btn btn-primario">
                            Buscar una nueva receta
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Ingredientes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($recetas as $receta)
                                    @foreach ($receta->recetas as $r)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><strong>{{ $r['nombre'] ?? 'Receta sin nombre' }}</strong></td>
                                            <td>{{ Str::limit($r['descripcion'] ?? 'Sin descripción', 80) }}</td>

                                            <td>
                                                @if (!empty($r['ingredientes']))
                                                    <ul class="mb-0">
                                                        @foreach ($r['ingredientes'] as $ing)
                                                            <li>{{ $ing }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">No especificados</span>
                                                @endif
                                            </td>

                                            <td>
                                                <form action="{{ route('recetas.destroy', $receta->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta receta?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
