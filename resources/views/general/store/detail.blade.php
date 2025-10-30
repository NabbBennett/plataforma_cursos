@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container mt-4">
    <a href="{{ route('store') }}" class="btn btn-outline-secondary mb-3">Volver al catálogo</a>
    <div class="row g-4 align-items-start">
        <!-- Imagen del curso -->
        <div class="col-md-5">
            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded shadow" alt="Imagen del curso" style="width:100%;max-width:400px;">
            @else
                <div class="bg-secondary text-white text-center p-5 rounded" style="min-height:300px;">Sin imagen</div>
            @endif
        </div>
        <!-- Info principal -->
        <div class="col-md-7">
            <h2 class="mb-3">{{ $course->title }}</h2>
            <div class="mb-3">
                <h5>Precio del curso</h5>
                <div class="fs-4 text-success mb-2">${{ number_format($course->price_per_week, 2) }} <small class="text-muted">por semana</small></div>
            </div>
            <div class="mb-3">
                <h5>Semanas de duración</h5>
                <div class="d-flex align-items-center gap-2">
                    <form method="POST" action="{{ route('cart.add', $course->id) }}" class="d-flex align-items-center gap-2">
                        @csrf
                        <button type="button" class="btn btn-outline-secondary" onclick="changeWeeks(-1)">-</button>
                        <input type="number" name="weeks_count" id="weeks_count" class="form-control text-center" value="1" min="1" max="{{ $course->weeks->count() }}" style="width:70px;" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeWeeks(1)">+</button>
                        <span class="ms-2 text-muted">de {{ $course->weeks->count() }} semana(s)</span>
                        <button type="submit" class="btn btn-primary ms-3">Añadir al carrito</button>
                    </form>
                </div>
            </div>
            <div class="mb-3">
                <h5>Descripción</h5>
                <p class="text-muted">{{ $course->description }}</p>
            </div>
        </div>
    </div>
</div>

<script>
function changeWeeks(delta) {
    const input = document.getElementById('weeks_count');
    let value = parseInt(input.value) || 1;
    const min = parseInt(input.min);
    const max = parseInt(input.max);
    value += delta;
    if (value < min) value = min;
    if (value > max) value = max;
    input.value = value;
}
</script>
@endsection
