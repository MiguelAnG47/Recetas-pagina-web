@extends('layouts.main')

@section('title', 'Mi Perfil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h4 class="mb-0">👤 Mi Perfil</h4>
                <p class="mb-0 small text-muted">Consulta y actualiza tu información personal</p>
            </div>

            <div class="card-body p-4">

                {{-- Mensaje de éxito --}}
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success text-center">
                        Tu perfil ha sido actualizado correctamente ✅
                    </div>
                @endif

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulario de actualización --}}
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" 
                               value="{{ old('nombre', auth()->user()->nombre) }}" required>
                    </div>

                    {{-- Apellido --}}
                    <div class="mb-3">
                        <label for="apellido" class="form-label fw-semibold">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" 
                               value="{{ old('apellido', auth()->user()->apellido) }}">
                    </div>

                    {{-- Correo --}}
                    <div class="mb-3">
                        <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control" 
                               value="{{ old('correo', auth()->user()->correo) }}" required>
                    </div>

                    {{-- Edad --}}
                    <div class="mb-3">
                        <label for="edad" class="form-label fw-semibold">Edad</label>
                        <input type="number" id="edad" name="edad" class="form-control" 
                               value="{{ old('edad', auth()->user()->edad) }}" min="1" max="120">
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Nueva contraseña (opcional)</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Volver</a>
                        <button type="submit" class="btn btn-primario px-4">Guardar cambios</button>
                    </div>
                </form>

                {{-- Eliminar cuenta --}}
                <hr class="my-4">
                <div class="text-center">
                    <form method="POST" action="{{ route('profile.destroy') }}" 
                          onsubmit="return confirm('⚠️ ¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            🗑️ Eliminar mi cuenta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
