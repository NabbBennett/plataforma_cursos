@extends('layouts.app')

@section('title', 'Verificar Correo')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-content">
            <div class="login-form-section">
                <h2>Verificación de Correo Electrónico</h2>
                
                @if(session('resent'))
                    <div class="alert alert-success">
                        {{ session('resent') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="form-description">Hemos enviado un código de verificación a tu correo. Ingrésalo a continuación para completar tu registro.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('verification.check') }}" method="POST" class="login-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                    
                    <div class="form-group">
                        <label for="code" class="form-label">Código de verificación</label>
                        <input type="text" id="code" name="code" class="form-input" 
                               placeholder="Ingresa el código de 6 dígitos" 
                               required maxlength="6" pattern="[0-9]{6}"
                               value="{{ old('code') }}">
                        @error('code')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="login-btn">Verificar</button>
                </form>

                <div class="resend-section">
                    <form action="{{ route('verification.resend') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                        <button type="submit" class="resend-btn">
                            ¿No recibiste el código? <strong>Reenviar</strong>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Usa los mismos estilos de tu login */
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

.alert-success {
    background: rgba(25, 135, 84, 0.1);
    border: 1px solid rgba(25, 135, 84, 0.3);
    color: #155724;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #721c24;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
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

.resend-section {
    text-align: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.resend-btn {
    background: none;
    border: none;
    color: var(--btn-primary-bg);
    cursor: pointer;
    font-size: 0.9rem;
    text-decoration: underline;
    padding: 0.5rem;
}

.resend-btn:hover {
    color: var(--text-primary);
}

.error-message {
    color: var(--btn-danger-bg);
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: block;
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