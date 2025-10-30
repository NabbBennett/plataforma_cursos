@extends('layouts.app')

@section('title', 'Acceso')

@section('content')
<div class="container" id="container">
    {{-- Registro --}}
    <div class="form-container sign-up">
        <form method="POST" action="{{ route('register') }}" onsubmit="return validateForm()">
            @csrf
            <h2>Llena los requisitos para tu registro</h2>
            <input type="text" name="name" required placeholder="Nombre y Apellidos" value="{{ old('name') }}">
            @error('name') <span style="color:red;">{{ $message }}</span> @enderror

            <input type="email" name="email" required placeholder="Correo electrónico" value="{{ old('email') }}">
            @error('email') <span style="color:red;">{{ $message }}</span> @enderror

            <input type="text" name="phone_mobile" required placeholder="Numero telefonico (10 digitos)" value="{{ old('phone_number') }}"pattern="\d{10}" maxlength="10" minlength="10" title="Debe contener exactamente 10 dígitos numéricos">
            @error('email') <span style="color:red;">{{ $message }}</span> @enderror

            <input type="password" id="password" name="password" placeholder="Contraseña" required oninput="validatePassword()">
            <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirma tu contraseña" required oninput="validatePasswordMatch()">

            <small id="passwordWarning" style="color: red;"></small>
            <small id="matchWarning" style="color: red;"></small>

            <button type="submit">Registrarse</button>
        </form>
    </div>
    {{-- Login --}}
    <div class="form-container sign-in">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if (session('status'))
                <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                    {{ session('status') }}
                </div>
            @endif
            <h2>Ingresa con tu Email y contraseña</h2>
            <input type="email" name="email" required placeholder="Correo electrónico" value="{{ old('email') }}">
            @error('email') <span style="color:red;">{{ $message }}</span> @enderror
            <input type="password" name="password" required placeholder="Contraseña">
            @error('password') <span style="color:red;">{{ $message }}</span> @enderror
            <a href="{{ route('password.request') }}" style="color: #004754; font-weight: bold; text-decoration: underline;">Olvidaste tu contraseña?</a>

            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
    {{-- Panel animado --}}
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Bienvenido!</h1>
                <p>¿Ya tienes una cuenta?</p>
                <button class="hidden" id="login">Iniciar Sesión</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Hola Resiliente</h1>
                <p>Regístrate para poder acceder y hacer un examen de evaluación GRATIS</p>
                <button class="hidden" id="register">Registrate</button>
            </div>
        </div>
    </div>
</div>

{{-- Estilos y scripts --}}
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background-color:rgb(255, 255, 255); display: flex; align-items: center; justify-content: center; flex-direction: column; height: 100vh; }
    header { width: 100vw; position: relative; z-index: 10;}
    #container, .container { display: flex; align-items: center; justify-content: center; flex-direction: column; margin: 150px auto 180px auto; }
    .container { background-color: #fff; border-radius: 30px; box-shadow: 0 5px 15px rgba(60, 48, 48, 0.35); position: relative; overflow: hidden; width: 768px; max-width: 100%; min-height: 480px; }
    .container p { font-size: 14px; line-height: 20px; letter-spacing: 0.3px; margin: 20px 0; }
    .container button { background-color: #004754; color: #ffffff; font-size: 12px; padding: 10px 45px; border: 1px solid transparent; border-radius: 0px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 10px; cursor: pointer; }
    .container button.hidden { background-color: transparent; border-color: #ffffff; }
    .container form { background-color: #ffffff; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 40px; height: 100%; }
    .container input { background-color: #cccccc; border: none; margin: 8px 0; padding: 10px 15px; font-size: 13px; border-radius: 0px; width: 100%; outline: none; }
    .form-container { position: absolute; top: 0; height: 100%; transition: all 0.6s ease-in-out; }
    .sign-in { left: 0; width: 50%; z-index: 2; }
    .container.active .sign-in { transform: translateX(100%); }
    .sign-up { left: 0; width: 50%; opacity: 0; z-index: 1; }
    .container.active .sign-up { transform: translateX(100%); opacity: 1; z-index: 5; animation: move 0.6s; }
    @keyframes move { 0%,49.99%{opacity:0;z-index:1;} 50%,100%{opacity:1;z-index:5;} }
    .toggle-container { position: absolute; top: 0; left: 50%; width: 50%; height: 100%; overflow: hidden; transition: all 0.6s ease-in-out; border-radius: 150px 0 0 100px; z-index: 1000; }
    .container.active .toggle-container { transform: translateX(-100%); border-radius: 0 150px 100px 0; }
    .toggle { background-color: #004754; height: 100%; background: linear-gradient(to right, #004754, #004754); color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%; transform: translateX(0); transition: all 0.6s ease-in-out; }
    .container.active .toggle { transform: translateX(50%); }
    .toggle-panel { position: absolute; width: 50%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 0 30px; text-align: center; top: 0; transform: translateX(0); transition: all 0.6s ease-in-out; }
    .toggle-left { transform: translateX(-200%); }
    .container.active .toggle-left { transform: translateX(0); }
    .toggle-right { right: 0; transform: translateX(0); }
    .container.active .toggle-right { transform: translateX(200%); }
</style>

<script>
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });
    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });

    function validatePassword() {
        const password = document.getElementById("password").value;
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
        const password = document.getElementById("password").value;
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