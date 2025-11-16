@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-content">
            <div class="login-form-section">
                <h2>Recuperar Contraseña</h2>
                <p class="form-description">Ingresa tu email para recibir el enlace de restablecimiento</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" 
                                placeholder="Ingresa tu email" 
                                value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="login-btn">Enviar Enlace</button>
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

.error-message {
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
}
</style>
@endsection