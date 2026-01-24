@extends('layouts.app')

@section('title', 'Acceso')

@section('content')
<div class="login-container">
    <div class="login-card" id="loginCard">
        <div class="card-inner">
            
            {{-- Login Form (Frente) --}}
            <div class="card-face card-front">
                <div class="login-content">
                    <div class="login-form-section">
                        <h2>Iniciar Sesión</h2>
                        <p class="form-description">Ingresa tus datos para acceder a tu cuenta</p>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="text" id="email" name="email" class="form-input" 
                                        placeholder="Ingresa tu correo electrónico" 
                                        value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="password-input-container">
                                    <input type="password" id="password" name="password" class="form-input password-input" 
                                            placeholder="Ingresa tu contraseña" required>
                                    <button type="button" class="password-toggle" data-target="password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-help">
                                
                                <a href="{{ route('password.request') }}" class="help-link">¿Olvidaste tu contraseña?</a>
                            </div>

                            <button type="submit" class="login-btn">Iniciar Sesión</button>
                        </form>

                        <div class="login-footer">
                            <p>¿No tienes una cuenta?<br><a href="#" class="footer-link" id="flipToRegister">Regístrate Ahora</a></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Register Form (Reverso) --}}
            <div class="card-face card-back">
                <div class="login-content">
                    <div class="login-form-section">
                        <h2>Crear Cuenta</h2>
                        <p class="form-description">Llena los requisitos para tu registro</p>

                        <form method="POST" action="{{ route('register') }}" class="login-form" onsubmit="return validateForm()">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name" class="form-label">Nombre y Apellidos</label>
                                <input type="text" id="name" name="name" class="form-input" 
                                        placeholder="Nombre y Apellidos" 
                                        value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="register_email" class="form-label">Correo electrónico</label>
                                <input type="email" id="register_email" name="email" class="form-input" 
                                        placeholder="Correo electrónico" 
                                        value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone_mobile" class="form-label">Número telefónico</label>
                                <input type="text" id="phone_mobile" name="phone_mobile" class="form-input" 
                                        placeholder="Número telefónico (10 dígitos)" 
                                        value="{{ old('phone_mobile') }}" 
                                        pattern="\d{10}" maxlength="10" minlength="10" 
                                        title="Debe contener exactamente 10 dígitos numéricos" required>
                                @error('phone_mobile')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="register_password" class="form-label">Contraseña</label>
                                <div class="password-input-container">
                                    <input type="password" id="register_password" name="password" class="form-input password-input" 
                                            placeholder="Contraseña" required oninput="validatePassword()">
                                    <button type="button" class="password-toggle" data-target="register_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <div class="password-input-container">
                                    <input type="password" id="confirm_password" name="password_confirmation" class="form-input password-input" 
                                            placeholder="Confirma tu contraseña" required oninput="validatePasswordMatch()">
                                    <button type="button" class="password-toggle" data-target="confirm_password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-warnings">
                                <small id="passwordWarning" class="warning-message"></small>
                                <small id="matchWarning" class="warning-message"></small>
                            </div>

                            <button type="submit" class="login-btn">Registrarse</button>
                        </form>

                        <div class="login-footer">
                            <p>¿Ya tienes una cuenta?<br> <a href="#" class="footer-link" id="flipToLogin">Inicia Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ------------------------------------
 * CSS ESENCIAL PARA EL FLIP CARD Y ESTILOS
 * ------------------------------------ */
:root {
    /* Variables de ejemplo, ajústalas a tus estilos de Laravel */
    --bg-primary: #ffffff;
    --border-color: #e0e0e0;
    --text-primary: #333333;
    --text-secondary: #666666;
    --btn-primary-bg: #004754; /* Tu color azul/verde principal */
    --btn-primary-text: #ffffff;
    --btn-danger-bg: #dc3545;
}

.login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-primary);
    padding: 3rem 1rem; 
    perspective: 1000px; 
}

.login-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 440px;
    /* CAMBIO: Eliminar min-height fija, ahora se controlará por JS */
    height: auto; 
    position: relative;
    transform-style: preserve-3d; 
    transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275), height 0.4s ease-in-out; /* Agregar transición a la altura */
}

/* CLAVE: Transforma toda la tarjeta cuando está en estado "flipped" */
.login-card.flipped {
    transform: rotateY(180deg);
}

.card-inner {
    /* CAMBIO: position relative para que el contenido determine su altura */
    position: relative; 
    width: 100%;
    height: auto; /* CAMBIO: Altura automática para que se ajuste al contenido */
    transform-style: preserve-3d;
}

.card-face {
    width: 100%;
    /* CAMBIO: min-height para asegurar que ocupe el espacio */
    min-height: 100%; 
    backface-visibility: hidden; 
    -webkit-backface-visibility: hidden;
    position: absolute; 
    top: 0;
    left: 0;
}

/* CLAVE: Rota la cara trasera 180 grados para que esté orientada correctamente */
.card-back {
    transform: rotateY(180deg);
}

.login-content {
    padding: 2rem;
    /* CAMBIO: min-height para que el contenido empuje la altura mínima */
    min-height: inherit; /* Heredar min-height del padre o establecer una si es necesario */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-form-section {
    width: 100%;
}

.login-form-section h2 {
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align: center;
}

.form-description {
    color: var(--text-secondary);
    text-align: center;
    margin-bottom: 2rem;
    font-size: 0.9rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: var(--text-primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--btn-primary-bg);
    box-shadow: 0 0 0 3px rgba(0, 71, 84, 0.1); /* Usando el color principal */
}

/* Estilos para el contenedor de contraseña con icono */
.password-input-container {
    position: relative;
    width: 100%;
}

.password-input {
    padding-right: 3rem; /* Espacio para el icono */
}

.password-toggle {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: color 0.3s ease;
    font-size: 1.1rem;
}

.password-toggle:hover {
    color: var(--btn-primary-bg);
}

.password-toggle:focus {
    outline: none;
}

.error-message, .warning-message {
    color: var(--btn-danger-bg);
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: block;
}

.alert-success {
    background: rgba(25, 135, 84, 0.1);
    border: 1px solid rgba(25, 135, 84, 0.3);
    color: var(--text-primary);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.form-help {
    text-align: right;
    margin-bottom: 1.5rem;
}

.help-link, .footer-link {
    color: var(--btn-primary-bg);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
}

.help-link:hover, .footer-link:hover {
    text-decoration: underline;
}

.login-btn {
    width: 100%;
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

.login-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.login-footer {
    text-align: center;
    border-top: 1px solid var(--border-color);
    padding-top: 1.5rem;
    margin-top: auto;
}

.login-footer p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

/* Responsive */
@media (max-width: 480px) {
    .login-card {
        margin: 1rem;
        max-width: none;
        /* Remover min-height específica para móviles si ya es auto */
    }
    
    .login-content {
        padding: 1.5rem;
    }
    
    .password-toggle {
        right: 0.5rem;
    }
}
</style>

<script>
/* ------------------------------------
 * JAVASCRIPT PARA EL FLIP Y VALIDACIÓN
 * ------------------------------------ */
document.addEventListener('DOMContentLoaded', function() {
    const loginCard = document.getElementById('loginCard');
    const flipToRegister = document.getElementById('flipToRegister');
    const flipToLogin = document.getElementById('flipToLogin');
    const cardFront = document.querySelector('.card-front'); 
    const cardBack = document.querySelector('.card-back');   

    // Función para ajustar la altura de la tarjeta
    function adjustCardHeight() {
        const targetHeight = loginCard.classList.contains('flipped') ? 
                             cardBack.offsetHeight : 
                             cardFront.offsetHeight;
        loginCard.style.height = `${targetHeight}px`;
    }

    function flipCard(event) {
        event.preventDefault(); 
        loginCard.classList.toggle('flipped');
        
        // Esperamos un momento para que la clase 'flipped' se aplique y el contenido de la nueva cara sea visible.
        // El tiempo (400ms) es la mitad de la duración de la transición del giro (0.8s).
        setTimeout(adjustCardHeight, 400); 
    }

    if (flipToRegister) {
        flipToRegister.addEventListener('click', flipCard);
    }
    if (flipToLogin) {
        flipToLogin.addEventListener('click', flipCard);
    }

    // Ajusta la altura inicial de la tarjeta al cargar la página (para el Login)
    adjustCardHeight();

    // Opcional: Ajustar la altura si la ventana cambia de tamaño
    window.addEventListener('resize', adjustCardHeight);

    // Función para mostrar/ocultar contraseña
    function setupPasswordToggles() {
        const toggles = document.querySelectorAll('.password-toggle');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    }

    // Inicializar los toggles de contraseña
    setupPasswordToggles();
});

function validatePassword() {
    const password = document.getElementById("register_password").value;
    const warning = document.getElementById("passwordWarning");
    
    if (password.length < 6) {
        warning.textContent = "La contraseña debe tener al menos 6 caracteres.";
        return false;
    } else {
        warning.textContent = "";
        return true;
    }
}

function validatePasswordMatch() {
    const password = document.getElementById("register_password").value;
    const confirm = document.getElementById("confirm_password").value;
    const matchWarning = document.getElementById("matchWarning");
    
    if (password !== confirm) {
        matchWarning.textContent = "Las contraseñas no coinciden.";
        return false;
    } else {
        matchWarning.textContent = "";
        return true;
    }
}

function validateForm() {
    return validatePassword() && validatePasswordMatch();
}
</script>
@endsection