<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Plataforma Educativa')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--icono de la pagina-->
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
            --footer-text: var(--light-400);
            --footer-border: var(--light-200);
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
            --footer-text: var(--dark-600);
            --footer-border: var(--dark-300);
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .navbar {
            background-color: var(--navbar-bg) !important;
            border-bottom: 1px solid var(--border-color);
            margin: 0;
            padding: 0.5rem 1rem;
        }
        
        .navbar-brand, .nav-link {
            color: var(--text-primary) !important; 
        }
        
        .nav-link:hover { 
            color: var(--text-secondary) !important; 
        }
        
        .btn-primary { 
            background-color: var(--btn-primary-bg); 
            border-color: var(--btn-primary-bg); 
            color: var(--btn-primary-text); 
        }
        
        .btn-primary:hover { 
            background-color: var(--btn-outline-hover-bg); 
            border-color: var(--btn-outline-hover-bg); 
            color: var(--btn-outline-hover-text); 
        }
        
        .btn-outline-primary { 
            border-color: var(--btn-outline-border); 
            color: var(--btn-outline-text); 
            background-color: transparent; 
        }
        
        .btn-outline-primary:hover { 
            background-color: var(--btn-outline-hover-bg); 
            color: var(--btn-outline-hover-text); 
            border-color: var(--btn-outline-hover-bg); 
        }
        
        .btn-outline-danger { 
            border-color: #dc3545; 
            color: #dc3545; 
            background-color: transparent; 
        }
        
        .btn-outline-danger:hover { 
            background-color: var(--btn-danger-bg); 
            color: var(--btn-danger-text); 
        }
        
        .btn-link { 
            color: var(--text-primary); 
            background: none; 
            border: none; 
            text-decoration: none; 
        }
        
        .btn-link:hover { 
            color: var(--text-secondary); 
        }
        
        .theme-toggle { 
            background: none; 
            border: none;
            font-size: 1.5rem; 
            color: var(--text-primary); 
            cursor: pointer; 
            transition: transform 0.3s; 
            padding: 0.25rem; 
        }
        
        .theme-toggle:hover { 
            transform: rotate(15deg); 
            color: var(--text-secondary); 
        }
        
        .logo-container { 
            display: flex; 
            align-items: center; 
        }
        
        .logo-image { 
            width: 60px; 
            height: 60px; 
            margin-right: 10px; 
            object-fit: contain; 
        }
        
        .instituto-text { 
            font-weight: bold; 
            color: var(--text-primary); 
            font-size: 20px; 
        }
        
        .navbar-container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            width: 100%; 
        }
        
        .navbar-left { 
            display: flex; 
            align-items: center; 
            flex: 1; 
        }
        
        .navbar-center { 
            display: flex; 
            justify-content: center; 
            flex: 2; 
        }
        
        .navbar-right { 
            display: flex; 
            justify-content: flex-end; 
            align-items: center; 
            flex: 1; 
            gap: 0.5rem; 
        }
        
        .mobile-navbar {
            display: none; 
            justify-content: space-between; 
            align-items: center; 
            width: 100%; 
            padding: 0.5rem 0; 
        }
        
        .mobile-menu-toggle { 
            background: none; 
            border: none; 
            font-size: 1.5rem; 
            color: var(--text-primary); 
            cursor: pointer; 
            padding: 0.25rem; 
        }
        
        .mobile-logo { 
            display: flex; 
            align-items: center; 
        }
        
        .mobile-user-icon { 
            font-size: 1.5rem; 
            color: var(--text-primary); 
            text-decoration: none; 
            padding: 0.25rem; 
        }
        
        .mobile-user-icon:hover { 
            color: var(--text-secondary); 
        }
        
        .mobile-menu { 
            position: fixed; 
            top: 0; 
            left: -100%; 
            width: 80%; 
            height: 100vh; 
            background-color: var(--navbar-bg); 
            z-index: 1050; 
            transition: left 0.3s ease; 
            padding: 2rem; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.1); 
        }
        
        .mobile-menu.active { 
            left: 0; 
        }
        
        .mobile-menu-overlay { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.5); 
            z-index: 1049; 
            display: none; 
        }
        
        .mobile-menu-overlay.active { display: block; 
        }
        
        .mobile-menu-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem;
            padding-bottom: 1rem; 
            border-bottom: 1px solid var(--border-color); 
        }
        
        .mobile-menu-close { 
            background: none; 
            border: none; 
            font-size: 1.5rem; 
            color: var(--text-primary); 
            cursor: pointer; 
            padding: 0.25rem; 
        }
        
        .mobile-nav-links { 
            list-style: none; 
            padding: 0; 
            margin: 0; 
        }
        
        .mobile-nav-links li { 
            margin-bottom: 1rem; 
        }

        .mobile-nav-links a { 
            color: var(--text-primary); 
            text-decoration: none; 
            font-size: 1.1rem; 
            display: block; 
            padding: 0.5rem 0; 
            transition: color 0.3s;  
        }

        .mobile-nav-links a:hover {
             color: var(--text-secondary); 
        }

        .auth-buttons { 
            display: flex; 
            align-items: center; 
            gap: 0.5rem; 
        }

        .auth-buttons .btn { 
            white-space: nowrap; 
        }
        
        main {
            padding: 2rem 0;
        }

        /* Estilos actualizados para el footer */
        .main-footer {
            width: 100%;
            background-color: var(--bg-primary);
            padding: 2rem 1rem;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }

        .footer-separator {
            font-size: 100%;
            margin: 0 15px;
            color: var(--text-primary);
            font-weight: bold;
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .footer-logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .footer-logo-image {
            width: 60px;
            height: 60px;
            margin-right: 10px;
            object-fit: contain;
        }
        
        .footer-text {
            font-weight: bold;
            color: var(--text-primary);
            font-size: 20px;
            text-align: left;
            line-height: 1.2;
        }
        
        .footer-copy {
            color: var(--footer-text);
            font-size: 0.75rem;
            margin-top: 1rem;
        }

        .mobile-user-section {
            position: relative;
        }

        .mobile-profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 180px;
            background-color: var(--navbar-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1060;
            overflow: hidden;
            /* Se oculta por defecto y solo se muestra con la clase .active */
            display: none; 
        }

        .mobile-profile-dropdown.active {
            display: block;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: var(--bg-secondary);
        }

        .mobile-profile-dropdown form {
            width: 100%;
        }

        .mobile-profile-dropdown .dropdown-item[type="submit"] {
            color: #dc3545;
            width: 100%;
            text-align: left;
        }

        .mobile-profile-dropdown .dropdown-item[type="submit"]:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        @media (max-width: 992px) {
            .desktop-navbar { display: none !important; }
            .mobile-navbar { display: flex; }
            .navbar-center { display: none; }
            .navbar-right .btn-link, .navbar-right .theme-toggle, .navbar-right .auth-buttons .btn { display: none; }
            .mobile-logo .logo-image { width: 40px; height: 40px; }
        }
        
        @media (min-width: 993px) {
            .mobile-navbar { display: none; }
            .desktop-navbar { display: flex !important; }
        }
    </style>
</head>
<body class="light-mode">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light px-4 py-2 shadow-sm w-100">
            <div class="desktop-navbar navbar-container">
                <div class="navbar-left">
                    <div class="logo-container">
                        <img src="{{ asset('images/Icono.png') }}" alt="Instituto Resiliencia" class="logo-image">
                        <span class="instituto-text">Instituto<br>Resiliencia</span>
                    </div>
                </div>
                
                <div class="navbar-center">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('welcome') }}">Inicio</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('contact') }}">Contactanos</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('store') }}">Tienda</a>
                        </li>
                        <!--
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('information.index') }}">Información</a>
                        </li>
                        -->
                    </ul>
                </div>
                
                <div class="navbar-right">
                    <a href="{{ route('cart.view') }}" class="btn btn-link me-2" style="font-size: 1.5rem;">
                        <i class="bi bi-cart"></i>
                    </a>
                    <button class="theme-toggle me-2" id="themeToggleDesktop">
                        <i class="bi bi-sun"></i>
                    </button>
                    <div class="auth-buttons">
                        @auth
                            <a class="btn btn-outline-primary me-2" href="{{ route('student.profile') }}">Mi Cuenta</a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isMaestro() || auth()->user()->isAyudante()) 
                            <a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Cerrar Sesión</button>
                            </form>
                        @else
                            <a class="btn btn-primary" href="{{ route('login') }}">Ingresar</a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="mobile-navbar">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="mobile-logo">
                    <img src="{{ asset('images/Icono.png') }}" alt="Instituto Resiliencia" class="logo-image">
                </div>
                
                <div class="mobile-user-section">
                    @auth
                        <a href="#" class="mobile-user-icon" id="mobileProfileToggle">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <div class="mobile-profile-dropdown" id="mobileProfileDropdown">
                            <a href="{{ route('student.profile') }}" class="dropdown-item">Ir a Cuenta</a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isMaestro() || auth()->user()->isAyudante()) 
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Panel Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="padding: 0.375rem 0.75rem;">
                            Ingresar
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
        
        <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-header">
                <h5>Menú</h5>
                <div class="d-flex align-items-center">
                    <button class="theme-toggle me-3" id="themeToggleMobile">
                        <i class="bi bi-sun"></i>
                    </button>
                    <button class="mobile-menu-close" id="mobileMenuClose">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
            <ul class="mobile-nav-links">
                <li><a href="{{ route('welcome') }}">Inicio</a></li>
                <li><a href="{{ route('contact') }}">Contactanos</a></li>
                <li><a href="{{ route('store') }}">Tienda</a></li>
                <!--
                <li><a href="{{ route('information.index') }}">Información</a></li>
                -->
                <li><a href="{{ route('cart.view') }}">Carrito</a></li>
            </ul>
        </div>
    </header>
    
    <main class="py-0">
        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-logo-container">
                <img src="{{ asset('images/Icono.png') }}" alt="Instituto Resiliencia" class="footer-logo-image">
                <span class="footer-separator">|</span>
                <div class="footer-text">
                    INSTITUTO<br>RESILIENCIA
                </div>
            </div>
            <p class="footer-copy">Copyright &copy; 2026 Instituto Resiliencia</p>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Toggle de Tema ---
        const themeToggleDesktop = document.getElementById('themeToggleDesktop');
        const themeToggleMobile = document.getElementById('themeToggleMobile');
        
        function toggleTheme() {
            if (document.body.classList.contains('light-mode')) {
                document.body.classList.replace('light-mode', 'dark-mode');
                updateThemeIcons('moon');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.replace('dark-mode', 'light-mode');
                updateThemeIcons('sun');
                localStorage.setItem('theme', 'light');
            }
        }
        
        function updateThemeIcons(icon) {
            const iconClass = icon === 'sun' ? 'bi-sun' : 'bi-moon';
            const elements = [themeToggleDesktop, themeToggleMobile];
            
            elements.forEach(element => {
                if (element) {
                    element.innerHTML = `<i class="bi ${iconClass}"></i>`;
                }
            });
        }
        
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.replace('light-mode', 'dark-mode');
            updateThemeIcons('moon');
        } else {
             // Asegura que el ícono es el correcto al inicio si no hay tema guardado o es 'light'
             updateThemeIcons('sun');
        }
        
        if (themeToggleDesktop) {
            themeToggleDesktop.addEventListener('click', toggleTheme);
        }
        if (themeToggleMobile) {
            themeToggleMobile.addEventListener('click', toggleTheme);
        }
        
        // --- Toggle del Menú Móvil ---
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        
        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.add('active');
                mobileMenuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                // Asegúrate de cerrar el dropdown de perfil si el menú lateral se abre
                if (mobileProfileDropdown && mobileProfileDropdown.classList.contains('active')) {
                    closeProfileDropdown();
                }
            });
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', closeMobileMenu);
        }
        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMobileMenu);
        }
        
        // --- Toggle del Dropdown de Perfil Móvil ---
        const mobileProfileToggle = document.getElementById('mobileProfileToggle');
        const mobileProfileDropdown = document.getElementById('mobileProfileDropdown');

        if (mobileProfileToggle && mobileProfileDropdown) {
            let isDropdownOpen = false;

            // Función para cerrar el dropdown
            function closeProfileDropdown() {
                mobileProfileDropdown.classList.remove('active');
                isDropdownOpen = false;
                // Remover el event listener global cuando se cierra
                document.removeEventListener('click', closeOnClickOutside);
            }

            // Función para manejar clics fuera del dropdown
            function closeOnClickOutside(event) {
                if (!mobileProfileToggle.contains(event.target) && !mobileProfileDropdown.contains(event.target)) {
                    closeProfileDropdown();
                }
            }

            // Evento para el botón de perfil
            mobileProfileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Asegúrate de cerrar el menú lateral si está abierto
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }

                if (isDropdownOpen) {
                    closeProfileDropdown();
                } else {
                    // Abrir dropdown
                    mobileProfileDropdown.classList.add('active');
                    isDropdownOpen = true;
                    
                    // Agregar event listener para clics fuera del dropdown
                    // Usamos setTimeout para que no se active inmediatamente
                    setTimeout(() => {
                        document.addEventListener('click', closeOnClickOutside);
                    }, 10);
                }
            });

            // Cerrar dropdown cuando se hace clic en un enlace dentro de él
            const dropdownLinks = mobileProfileDropdown.querySelectorAll('a, button');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function() {
                    closeProfileDropdown();
                });
            });

            // Cerrar dropdown cuando se cambia el tamaño de la ventana
            window.addEventListener('resize', function() {
                closeProfileDropdown();
            });

        }
    });
    </script>
</body>
</html>