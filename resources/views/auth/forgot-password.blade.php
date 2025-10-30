@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div style="max-width: 400px; margin: 3rem auto;">
    <h2>Recuperar contraseña</h2>
    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" required placeholder="Correo electrónico" value="{{ old('email') }}" class="form-control">
            @error('email') <span style="color:red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enviar enlace</button>
    </form>
</div>
@endsection
