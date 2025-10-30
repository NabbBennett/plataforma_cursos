<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Plataforma Educativa')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- Header principal -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-2 shadow-sm w-100" style="min-width:100vw;">
            <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">Inicio</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item ms-3">
                    <a class="nav-link" href="{{ route('store') }}">Tienda</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="nav-link" href="{{ route('information.index') }}">Información</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="{{ route('cart.view') }}" class="btn btn-link me-2" style="font-size: 1.5rem;">
                    <i class="bi bi-cart"></i>
                </a>
                @auth
                    <a class="btn btn-outline-primary me-2" href="{{ route('student.profile') }}">Mi Cuenta</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Cerrar Sesión</button>
                    </form>
                @else
                    <a class="btn btn-primary me-2" href="{{ route('login') }}">Ingresar</a>
                @endauth
            </div>
        </nav>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
