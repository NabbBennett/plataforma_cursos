@extends('layouts.admin')

@section('title', 'Recursos')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>Recursos disponibles</h2>
        <a href="{{ route('admin.resources.create') }}" class="btn btn-primary">+ Subir recurso</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $res)
                <tr>
                    <td>{{ $res->title }}</td>
                    <td>{{ strtoupper($res->type) }}</td>
                    <td>
                        @if(in_array($res->type, ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/'.$res->file_path) }}" alt="img" width="100">
                        @else
                            <a href="{{ route('admin.resources.download', $res->id) }}" target="_blank">Descargar PDF</a>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.resources.destroy', $res->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este recurso?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
