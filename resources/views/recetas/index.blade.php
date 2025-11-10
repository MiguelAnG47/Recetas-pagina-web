@extends('layouts.main')

@section('title', 'Mis Recetas Favoritas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h4 class="mb-0">🍲 Mis Recetas Favoritas</h4>
                <p class="mb-0 small text-muted">Consulta y gestiona tus recetas preferidas</p>
            </div>

            <div class="card-body p-4">

                {{-- Mensajes de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Si no hay recetas --}}
                @if ($recetas->isEmpty())
                    <div class="text-center text-muted py-4">
                        <p class="mb-2">No tienes recetas favoritas aún 😢</p>
                        <a href="{{ route('solicitudes.index') }}" class="btn btn-primario">
                            Buscar una nueva receta
                        </a>
                    </div>
                @else
                    {{-- Tabla de recetas --}}
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
                                    @if (is_array($receta->recetas))
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
                                    @endif
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
