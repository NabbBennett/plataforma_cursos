@extends('layouts.app')

@section('title', 'Tienda de Cursos')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Cursos disponibles</h2>
    <div class="row">
        <!-- Sidebar de filtros -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm p-3">
                <form method="GET" action="{{ route('store') }}" id="filter-form" autocomplete="off">
                    <div class="mb-3">
                        <label for="search" class="form-label">Buscar por nombre</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Nombre del curso">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio máximo por semana</label>
                        <input type="number" name="price" id="price" value="{{ request('price') }}" class="form-control" min="0" step="0.01" placeholder="Ej: 500">
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duración máxima (semanas)</label>
                        <input type="number" name="duration" id="duration" value="{{ request('duration') }}" class="form-control" min="1" placeholder="Ej: 10">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </form>
            </div>
        </div>

        <!-- Grid de cursos -->
        <div class="col-md-9">
            <div id="courses-grid">
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Imagen del curso">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                                        <span>Sin imagen</span>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $course->title }}</h5>
                                    <p class="mb-1 text-muted">Duración: {{ $course->weeks->count() }} semanas</p>
                                    <div class="mt-auto">
                                        @php
                                            $weeksCompradas = $userWeeks[$course->id] ?? 0;
                                            $weeksTotal = $course->weeks->count();
                                            $cursoComprado = $weeksCompradas >= $weeksTotal;
                                        @endphp

                                        @if($cursoComprado)
                                            <div class="text-success fw-bold small mb-2">CURSO COMPRADO</div>
                                        @endif
                                        <p class="fw-bold mb-2">Precio por semana: ${{ number_format($course->price_per_week, 2) }}</p>
                                        <a href="{{ route('store.course', $course->id) }}" class="btn btn-primary w-100" @if($cursoComprado) disabled @endif>Ver curso</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const inputs = form.querySelectorAll('input');
    const grid = document.getElementById('courses-grid');

    let timeout = null;
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();
                fetch(form.action + '?' + params, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    // Extrae solo el grid de cursos del HTML de respuesta
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const newGrid = tempDiv.querySelector('#courses-grid');
                    if (newGrid) grid.innerHTML = newGrid.innerHTML;
                });
            }, 400);
        });
    });
});
</script>
