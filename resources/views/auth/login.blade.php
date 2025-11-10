@extends('layouts.main')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header text-center" style="background-color: #ffe9b1; color: #4b2e05;">
                <h4 class="mb-0">Bienvenido de nuevo</h4>
                <p class="mb-0 small text-muted">Inicia sesión para acceder a tus recetas y preferencias 🍳</p>
            </div>

            <div class="card-body p-4">

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

                {{-- Formulario de inicio de sesión --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Correo electrónico --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email') }}" required autofocus autocomplete="email">
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                    </div>

                    {{-- Recordar sesión --}}
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('register') }}" class="text-decoration-none text-secondary small">
                            ¿No tienes cuenta? <strong>Regístrate aquí</strong>
                        </a>

                        <button type="submit" class="btn btn-primario px-4">
                            Iniciar sesión
                        </button>
                    </div>

                    {{-- Recuperar contraseña --}}
                    @if (Route::has('password.request'))
                        <div class="mt-3 text-end">
                            <a class="text-decoration-none text-secondary small" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
