@extends('layouts.admin')

@section('title', 'Exámenes')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Exámenes</h2>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">+ Crear Examen</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Duración</th>
                <th>Preguntas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exams as $exam)
                <tr>
                    <td>{{ $exam->id }}</td>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->duration_minutes }} min</td>
                    <td>{{ $exam->questions_count }}</td>
                    <td>
                        <a href="{{ route('admin.exams.preview', $exam->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este examen?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
