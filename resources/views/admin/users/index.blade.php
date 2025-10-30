@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Usuarios</h2>

    <!-- Filtro por rol -->
    <form method="GET" action="{{ route('admin.users') }}" class="mb-3">
        <label for="role">Filtrar por rol:</label>
        <select name="role" id="role" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="">Todos</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admins</option>
            <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Estudiantes</option>
        </select>
    </form>

    <!-- Tabla de usuarios -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>

                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No se encontraron usuarios.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $users->appends(['role' => request('role')])->links() }}
</div>
@endsection
