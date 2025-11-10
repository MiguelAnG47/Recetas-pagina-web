@extends('layouts.main')

@section('title', 'Registro de Usuario')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h4 class="mb-0">Crear una nueva cuenta</h4>
            </div>

            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" 
                               value="{{ old('nombre') }}" required autofocus>
                    </div>

                    {{-- Apellido --}}
                    <div class="mb-3">
                        <label for="apellido" class="form-label fw-semibold">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" 
                               value="{{ old('apellido') }}" required>
                    </div>

                    {{-- Correo electrónico --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email') }}" required>
                    </div>

                    {{-- Edad --}}
                    <div class="mb-3">
                        <label for="edad" class="form-label fw-semibold">Edad</label>
                        <input type="number" id="edad" name="edad" class="form-control" 
                               value="{{ old('edad') }}" min="1" max="120">
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-control" required>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('login') }}" class="text-decoration-none text-secondary">
                            ¿Ya tienes una cuenta? <strong>Inicia sesión</strong>
                        </a>

                        <button type="submit" class="btn btn-primario px-4">
                            Registrarme
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
