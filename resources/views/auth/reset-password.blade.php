@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('content')
<div style="max-width: 400px; margin: 3rem auto;">
    <h2>Restablecer contraseña</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Nueva contraseña</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmar contraseña</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Restablecer</button>
    </form>
</div>
@endsection
