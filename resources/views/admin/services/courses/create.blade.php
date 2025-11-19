@extends('layouts.admin')

@section('title', 'Crear Curso')

@section('content')
<div class="container">
    <h2>Crear Nuevo Curso</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="start_date" class="form-label">Inicio del curso</label>
            <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">
        </div>

        <div class="mb-3">
            <label for="price_per_week" class="form-label">Precio por semana</label>
            <input type="number" name="price_per_week" class="form-control"
            step="0.01" min="0"
            value="{{ old('price_per_week', $course->price_per_week ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="weeks" class="form-label">Número de semanas (mínimo 1)</label>
            <input type="number" class="form-control" id="weeks" name="number_of_weeks" min="1" max="52" value="4" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen del curso (opcional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success">Crear Curso</button>
        </div>
    </form>
</div>
@endsection
