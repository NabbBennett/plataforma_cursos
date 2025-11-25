<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('images/Icono.png') }}">
    <style>
        :root {
            /* Colores modo claro */
            --light-base: #FFFFFF;
            --light-50: #FAFAFA;
            --light-100: #F5F5F5;
            --light-200: #E5E5E5;
            --light-300: #D4D4D4;
            --light-400: #A3A3A3;
            --light-500: #737373;
            --light-600: #525252;
            --light-700: #404040;
            --light-800: #262626;
            --light-900: #171717;
            --light-950: #0A0A0A;
            
            /* Colores modo oscuro */
            --dark-base: #000000;
            --dark-50: #0A0A0A;
            --dark-100: #171717;
            --dark-200: #262626;
            --dark-300: #373737;
            --dark-400: #525252;
            --dark-500: #8A8A8A;
            --dark-600: #A3A3A3;
            --dark-700: #D4D4D4;
            --dark-800: #E5E5E5;
            --dark-900: #F5F5F5;
            --dark-950: #FAFAFA;

            /* Variables para el layout */
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 70px;
            --header-height: 60px;
            --transition-speed: 0.3s;
        }
        
        body.light-mode {
            --bg-primary: var(--light-base);
            --bg-secondary: var(--light-50);
            --text-primary: var(--light-900);
            --text-secondary: var(--light-600);
            --border-color: var(--light-200);
            --btn-primary-bg: var(--light-800);
            --btn-primary-text: var(--light-base);
            --btn-outline-border: var(--light-800);
            --btn-outline-text: var(--light-800);
            --btn-outline-hover-bg: var(--light-800);
            --btn-outline-hover-text: var(--light-base);
            --btn-danger-bg: #dc3545;
            --btn-danger-text: white;
            --navbar-bg: var(--light-base);
            --sidebar-bg: var(--light-base);
            --card-bg: var(--light-base);
            --hover-bg: var(--light-100);
        }
        
        body.dark-mode {
            --bg-primary: var(--dark-base);
            --bg-secondary: var(--dark-50);
            --text-primary: var(--dark-950);
            --text-secondary: var(--dark-500);
            --border-color: var(--dark-300);
            --btn-primary-bg: var(--dark-700);
            --btn-primary-text: var(--dark-base);
            --btn-outline-border: var(--dark-700);
            --btn-outline-text: var(--dark-700);
            --btn-outline-hover-bg: var(--dark-700);
            --btn-outline-hover-text: var(--dark-base);
            --btn-danger-bg: #dc3545;
            --btn-danger-text: white;
            --navbar-bg: var(--dark-base);
            --sidebar-bg: var(--dark-100);
            --card-bg: var(--dark-100);
            --hover-bg: var(--dark-200);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Header Styles */
        .admin-header {
            background-color: var(--navbar-bg);
            height: var(--header-height);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
            transition: all var(--transition-speed) ease;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            background-color: var(--sidebar-bg);
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all var(--transition-speed) ease;
            border-right: 1px solid var(--border-color);
            z-index: 999;
        }

        .admin-sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        .admin-sidebar.collapsed .sidebar-brand-text,
        .admin-sidebar.collapsed .nav-link span {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .admin-sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }

        .admin-sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left var(--transition-speed) ease;
            background-color: var(--bg-primary);
        }

        .admin-main.expanded {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Sidebar Content */
        .sidebar-brand {
            padding: 1.5rem 0.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-brand-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-text {
            transition: all var(--transition-speed) ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background-color: var(--hover-bg);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-link:hover {
            background-color: var(--hover-bg);
            color: var(--text-primary);
        }

        .nav-link.active {
            background-color: var(--btn-primary-bg);
            color: var(--btn-primary-text);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            transition: margin-right var(--transition-speed) ease;
        }

        /* Card Styles */
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }

        .stats-card .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            opacity: 0.9;
            color: var(--text-primary);
        }

        .stats-card .card-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .stats-card .card-icon {
            font-size: 3rem;
            opacity: 0.2;
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: var(--text-primary);
        }

        /* Chart Container */
        .chart-container {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: 2rem;
            border: 1px solid var(--border-color);
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            background-color: var(--hover-bg);
            transform: rotate(15deg);
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            .admin-sidebar.mobile-open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
                padding: 1rem;
            }

            .mobile-menu-btn {
                display: block;
            }

            .stats-card .card-value {
                font-size: 2rem;
            }

            .chart-container {
                padding: 1rem;
            }

            .admin-sidebar.collapsed {
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }

            .admin-sidebar.collapsed.mobile-open {
                transform: translateX(0);
            }
        }

        /* Desktop Styles */
        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none;
            }
        }

        /* Utility Classes para tarjetas */
        .bg-users { 
            background: linear-gradient(135deg, #3498db, #2980b9) !important; 
            color: white !important; 
        }
        .bg-services { 
            background: linear-gradient(135deg, #27ae60, #229954) !important; 
            color: white !important; 
        }
        .bg-exams { 
            background: linear-gradient(135deg, #f39c12, #e67e22) !important; 
            color: white !important; 
        }
        .bg-resources { 
            background: linear-gradient(135deg, #9b59b6, #8e44ad) !important; 
            color: white !important; 
        }
        .bg-coupons { 
            background: linear-gradient(135deg, #16a085, #1abc9c) !important; 
            color: white !important; 
        }
        .bg-sales { 
            background: linear-gradient(135deg, #e74c3c, #c0392b) !important; 
            color: white !important; 
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
            display: none;
        }

        /* Asegurar que el texto en tarjetas con colores sea siempre blanco */
        .bg-users .card-title,
        .bg-services .card-title,
        .bg-exams .card-title,
        .bg-resources .card-title,
        .bg-coupons .card-title,
        .bg-sales .card-title,
        .bg-users .card-value,
        .bg-services .card-value,
        .bg-exams .card-value,
        .bg-resources .card-value,
        .bg-coupons .card-value,
        .bg-sales .card-value {
            color: white !important;
        }
    </style>
</head>
<body class="light-mode">
    <!-- Header -->
    <header class="admin-header">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center">
                <div class="col d-flex align-items-center">
                    <button class="row btn btn-light mobile-menu-btn" id="mobileMenuToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="row fw-bold ms-3" style="color: var(--text-primary);">Panel de Administración</span>
                </div>
                <div class="col-auto d-flex align-items-center gap-2">
                    <button class="theme-toggle" id="themeToggle">
                        <i class="bi bi-sun"></i>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-content">
                <i class="bi bi-building" style="font-size: 1.5rem; color: var(--text-primary);"></i>
                <div class="sidebar-brand-text">
                    <h5 class="mb-0" style="color: var(--text-primary);">INSTITUTO<br>RESILIENCIA</h5>
                </div>
            </div>
            <button class="sidebar-toggle d-none d-md-block" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
    <div class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        
        @if(auth()->user()->isAdmin() || auth()->user()->isAyudante())
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Usuarios</span>
        </a>
        @endif
        
        @if(auth()->user()->isAdmin() || auth()->user()->isMaestro())
        <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i>
            <span>Cursos</span>
        </a>
        <a href="{{ route('admin.exams.index') }}" class="nav-link {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
            <i class="bi bi-file-text"></i>
            <span>Exámenes</span>
        </a>
        <a href="{{ route('admin.resources.index') }}" class="nav-link {{ request()->routeIs('admin.resources.*') ? 'active' : '' }}">
            <i class="bi bi-folder"></i>
            <span>Recursos</span>
        </a>
        @endif
        
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i>
            <span>Cupones</span>
        </a>
        @endif
        
        @if(auth()->user()->isAdmin() || auth()->user()->isAyudante())
        <a href="{{ route('admin.purchases.sales') }}" class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>
            <span>Ventas</span>
        </a>
        @endif
    </div>
</nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main" id="adminMain">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Sistema de temas
        const themeToggle = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('admin-theme') || 'light-mode';

        // Aplicar tema guardado
        document.body.className = currentTheme;
        updateThemeIcon();

        function toggleTheme() {
            if (document.body.classList.contains('light-mode')) {
                document.body.classList.replace('light-mode', 'dark-mode');
                localStorage.setItem('admin-theme', 'dark-mode');
            } else {
                document.body.classList.replace('dark-mode', 'light-mode');
                localStorage.setItem('admin-theme', 'light-mode');
            }
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const icon = themeToggle.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.className = 'bi bi-moon';
            } else {
                icon.className = 'bi bi-sun';
            }
        }

        themeToggle.addEventListener('click', toggleTheme);

        // Sidebar toggle para desktop
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        const adminMain = document.getElementById('adminMain');
        const sidebarToggleIcon = sidebarToggle.querySelector('i');

        sidebarToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('collapsed');
            adminMain.classList.toggle('expanded');
            
            if (adminSidebar.classList.contains('collapsed')) {
                sidebarToggleIcon.className = 'bi bi-chevron-right';
            } else {
                sidebarToggleIcon.className = 'bi bi-chevron-left';
            }
        });

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');

        mobileMenuToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('mobile-open');
            mobileOverlay.style.display = adminSidebar.classList.contains('mobile-open') ? 'block' : 'none';
        });

        // Close sidebar when clicking overlay
        mobileOverlay.addEventListener('click', function() {
            adminSidebar.classList.remove('mobile-open');
            this.style.display = 'none';
        });

        // Auto-hide sidebar on mobile when clicking a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    adminSidebar.classList.remove('mobile-open');
                    mobileOverlay.style.display = 'none';
                }
            });
        });

        // Responsive adjustments
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                adminSidebar.classList.remove('mobile-open');
                mobileOverlay.style.display = 'none';
                
                // Asegurar que el sidebar no esté colapsado por defecto en desktop
                if (!localStorage.getItem('sidebar-collapsed')) {
                    adminSidebar.classList.remove('collapsed');
                    adminMain.classList.remove('expanded');
                    sidebarToggleIcon.className = 'bi bi-chevron-left';
                }
            }
        });

        // Guardar estado del sidebar
        adminSidebar.addEventListener('transitionend', function() {
            if (window.innerWidth >= 768) {
                localStorage.setItem('sidebar-collapsed', adminSidebar.classList.contains('collapsed'));
            }
        });

        // Aplicar estado guardado del sidebar al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 768 && localStorage.getItem('sidebar-collapsed') === 'true') {
                adminSidebar.classList.add('collapsed');
                adminMain.classList.add('expanded');
                sidebarToggleIcon.className = 'bi bi-chevron-right';
            }
        });
    </script>

    @yield('scripts')
</body>
</html>