@extends('layouts.admin')

@section('title', 'Editar Información Institucional')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Editar Información Institucional</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.information.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="institution_name" class="form-label">Nombre de la institución</label>
            <input type="text" class="form-control" name="institution_name" value="{{ old('institution_name', $info->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto representativa</label><br>
            @if($info->image_path)
                <img src="{{ asset('storage/' . $info->image_path) }}" class="img-thumbnail mb-2" style="max-height: 200px;"><br>
            @endif
            <input type="file" class="form-control" name="image_path">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Ubicación</label>
            <input type="text" class="form-control" name="location" value="{{ old('location', $info->location) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="3">{{ old('description', $info->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="careers" class="form-label">Carreras ofertadas</label>
            <textarea class="form-control" name="careers" rows="3">{{ old('careers', $info->careers) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="admission_dates" class="form-label">Fechas de admisión</label>
            <textarea class="form-control" name="admission_dates" rows="2">{{ old('admission_dates', $info->admission_dates) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Cursos recomendados</label>
            @php
                $selected = is_array($info->recommended_courses) ? $info->recommended_courses : json_decode($info->recommended_courses, true);
            @endphp
            @foreach($courses as $course)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="recommended_courses[]" value="{{ $course->id }}"
                        {{ is_array($selected) && in_array($course->id, $selected) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $course->title }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>
@endsection
