@extends('layouts.admin')

@section('title', 'Crear Información Institucional')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registrar Información Institucional</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.information.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la institución</label>
            <input type="text" class="form-control" name="institution_name" required>
        </div>

        <div class="mb-3">
            <label for="image_path" class="form-label">Foto representativa</label>
            <input type="file" class="form-control" name="image_path">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Ubicación</label>
            <input type="text" name="location" value="{{ old('location') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="careers" class="form-label">Carreras ofertadas</label>
            <textarea class="form-control" name="careers" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="admission_dates" class="form-label">Fechas de admisión</label>
            <textarea class="form-control" name="admission_dates" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Cursos recomendados</label>
            @php
                $selected = old('recommended_courses', []);
            @endphp
            @foreach($courses as $course)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="recommended_courses[]" value="{{ $course->id }}"
                        {{ is_array($selected) && in_array($course->id, $selected) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $course->title }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
