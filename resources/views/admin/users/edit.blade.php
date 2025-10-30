@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Estudiante</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
