@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-content">
            <div class="login-form-section">
                <h2>Restablecer Contraseña</h2>
                <p class="form-description">Ingresa tu nueva contraseña</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="login-form" id="resetForm">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <!-- Campo de email oculto o visible pero no editable -->
                    <input type="hidden" name="email" value="{{ request()->query('email') }}">

                    @if(request()->query('email'))
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" 
                               value="{{ request()->query('email') }}" 
                               disabled
                               style="background-color: #f8f9fa; cursor: not-allowed;">
                        <small style="color: var(--text-secondary); font-size: 0.8rem;">
                            Este es el email donde se envió el enlace de restablecimiento
                        </small>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" class="form-input" 
                                placeholder="Ingresa tu nueva contraseña" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                                placeholder="Confirma tu nueva contraseña" required>
                    </div>

                    <div class="form-warnings">
                        <small id="passwordWarning" class="warning-message"></small>
                        <small id="matchWarning" class="warning-message"></small>
                    </div>

                    <button type="submit" class="login-btn">Restablecer Contraseña</button>
                </form>

                <div class="login-footer">
                    <p>¿Recordaste tu contraseña?<br><a href="{{ route('login') }}" class="footer-link">Iniciar Sesión</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --bg-primary: #ffffff;
    --border-color: #e0e0e0;
    --text-primary: #333333;
    --text-secondary: #666666;
    --btn-primary-bg: #004754;
    --btn-primary-text: #ffffff;
    --btn-danger-bg: #dc3545;
}

.login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-primary);
    padding: 2rem 1rem;
    min-height: calc(100vh - 200px);
}

.login-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 440px;
}

.login-content {
    padding: 2rem;
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
    box-shadow: 0 0 0 3px rgba(0, 71, 84, 0.1);
}

.form-input:disabled {
    background-color: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
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
    color: #155724;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.form-warnings {
    margin-bottom: 1.5rem;
    min-height: 40px;
}

.footer-link {
    color: var(--btn-primary-bg);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
}

.footer-link:hover {
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

.login-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.login-footer {
    text-align: center;
    border-top: 1px solid var(--border-color);
    padding-top: 1.5rem;
}

.login-footer p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 480px) {
    .login-card {
        margin: 1rem;
        max-width: none;
    }
    
    .login-content {
        padding: 1.5rem;
    }
    
    .login-container {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetForm');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const passwordWarning = document.getElementById('passwordWarning');
    const matchWarning = document.getElementById('matchWarning');
    const submitBtn = form.querySelector('button[type="submit"]');

    function validatePassword() {
        const password = passwordInput.value;
        
        if (password.length < 6) {
            passwordWarning.textContent = "La contraseña debe tener al menos 6 caracteres.";
            return false;
        } else {
            passwordWarning.textContent = "";
            return true;
        }
    }

    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (password !== confirm && confirm.length > 0) {
            matchWarning.textContent = "Las contraseñas no coinciden.";
            return false;
        } else {
            matchWarning.textContent = "";
            return true;
        }
    }

    function validateForm() {
        const isPasswordValid = validatePassword();
        const isMatchValid = validatePasswordMatch();
        
        // Habilitar/deshabilitar botón
        submitBtn.disabled = !(isPasswordValid && isMatchValid && passwordInput.value && confirmInput.value);
        
        return isPasswordValid && isMatchValid;
    }

    // Event listeners
    passwordInput.addEventListener('input', validateForm);
    confirmInput.addEventListener('input', validateForm);

    // Validación inicial
    validateForm();

    // Prevenir envío si no es válido
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection