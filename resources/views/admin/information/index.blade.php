@extends('layouts.admin')

@section('title', 'Información Institucional')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Información Institucional</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="mb-3 text-end">
        <a href="{{ route('admin.information.create') }}" class="btn btn-primary">+ Registrar nueva información</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($infos as $info)
                <tr>
                    <td>{{ $info->name }}</td>
                    <td>{{ $info->location }}</td>
                    <td>
                        @if($info->image_path)
                            <img src="{{ asset('storage/' . $info->image_path) }}" alt="imagen" width="80">
                        @else
                            <em>Sin imagen</em>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.information.edit', $info->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.information.destroy', $info->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta información?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay registros disponibles.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
