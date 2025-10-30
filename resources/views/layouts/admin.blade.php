<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-2 bg-white border-end min-vh-100 p-3">
                <h6 class="text-muted">Menú Admin</h6>
                <ul class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm mt-2">Panel de control</a>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-light btn-sm mt-2">Crear curso</a>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-light btn-sm mt-2">Crear examen</a>
                    <a href="{{ route('admin.resources.index') }}" class="btn btn-light btn-sm mt-2">Crear recursos</a>
                    <a href="{{ route('admin.purchases.sales') }}" class="btn btn-light btn-sm mt-2">Panel de compras</a>
                    <a href="{{ route('admin.information.index') }}" class="btn btn-light btn-sm mt-2">Panel de informacion</a>
                </ul>
            </aside>

            <!-- Main content -->
            <main class="col-md-10 p-4">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
