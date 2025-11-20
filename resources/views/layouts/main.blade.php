<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecetasApp')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #fffdf6;
            color: #4b2e05;
        }
        .navbar {
            background-color: #ffe9b1;
        }
        .navbar-brand {
            font-weight: bold;
            color: #4b2e05 !important;
        }
        footer {
            background-color: #fbd18b;
            color: #4b2e05;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }
        .btn-primario {
            background-color: #ffb347;
            color: #4b2e05;
            border: none;
        }
        .btn-primario:hover {
            background-color: #ff9c1a;
        }
    </style>
</head>
<body>

    {{-- Navbar superior --}}
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">RecetasApp</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('solicitudes.index') }}">Solicitar receta</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('recetas.index') }}">Mis recetas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('perfil.index') }}">Perfil</a></li>

                    @auth
                        {{-- 🔥 Logout con POST --}}
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Salir
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer>
        <p>Desarrollado por UNAB ESTUDENTS © {{ date('Y') }}</p>
    </footer>

</body>
</html>
