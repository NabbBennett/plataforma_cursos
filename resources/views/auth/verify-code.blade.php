@extends('layouts.app')

@section('title', 'Verificar Correo')

@section('content')
<div class="container">
    <h2>Verificación de Correo Electrónico</h2>

    @if(session('resent'))
        <div class="alert alert-success">{{ session('resent') }}</div>
    @endif

    <p>Hemos enviado un código de verificación a tu correo. Ingrésalo a continuación para completar tu registro.</p>

    @if (isset($user))
        <p><strong>Tu código (modo debug):</strong> <span style="color: blue">{{ $user->verification_code }}</span></p>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('verification.check') }}" method="POST">
        @csrf
            <input type="hidden" name="user_id" value="{{ session('user_id') }}">
        <div class="mb-3">
            <label for="code">Código de verificación</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Verificar</button>
    </form>

    <form action="{{ route('verification.resend') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="user_id" value="{{ session('user_id') }}">
        <button type="submit" class="btn btn-link">¿No recibiste el código? Reenviar</button>
    </form>
</div>
@endsection
