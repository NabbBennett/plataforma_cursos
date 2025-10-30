@extends('layouts.admin')

@section('title', 'Cursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Cursos</h1>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Nuevo Curso</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Precio Semanal</th>
            <th>Inicio de cursos</th>
            <th>Imagen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->title }}</td>
            <td>{{ $course->description }}</td>
            <td>{{ $course->price_per_week}}</td>
            <td>{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : '—' }}</td>
            <td>
                @if ($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="Portada" width="100">
                @else
                    <em>Sin imagen</em>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('admin.courses.delete', $course->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este curso?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
