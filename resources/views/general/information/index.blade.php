@extends('layouts.app')

@section('title', 'Información Institucional')

@section('content')

<div class="container mt-5 mb-5" style="max-width: 1100px;">
    <h1 class="fw-bold text-center mb-4" style="font-size:2.5rem;">{{ $info->name ?? 'NOMBRE DE LA UNIVERSIDAD' }}</h1>

    {{-- Carrusel de imagen full width --}}
    <div class="mb-5 position-relative">
        <img src="{{ asset('storage/' . $info->image_path) }}"
             class="w-100 rounded shadow"
             style="height:500px;object-fit:cover;">
        {{-- Flecha izquierda --}}
        @if($prevId)
            <a href="{{ route('information.index', ['id' => $prevId]) }}" class="position-absolute top-50 start-0 translate-middle-y btn btn-light" style="font-size:2rem; z-index:2;">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif
        {{-- Flecha derecha --}}
        @if($nextId)
            <a href="{{ route('information.index', ['id' => $nextId]) }}" class="position-absolute top-50 end-0 translate-middle-y btn btn-light" style="font-size:2rem; z-index:2;">
                <i class="bi bi-chevron-right"></i>
            </a>
        @endif
    </div>

    <div class="row mb-5">
        <div class="col-md-6">
            <h4 class="fw-bold text-center mb-3 text-uppercase">Descripción</h4>
            <div class="border p-4 text-center" style="min-height:180px;">
                {{ $info->description ?? 'DESCRIPCIÓN' }}
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="fw-bold text-center mb-3 text-uppercase">Ubicación</h4>
            <div class="border p-4 text-center" style="min-height:180px;">
                @if(!empty($info->location))
                    <iframe
                        width="100%"
                        height="180"
                        style="border:0;"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ urlencode($info->location) }}&output=embed">
                    </iframe>
                @else
                    MAPA
                @endif
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-center mt-5 mb-3 text-uppercase">Fechas de Admisión</h4>
    <div class="bg-secondary text-white p-4 mb-4 text-center rounded" style="font-size:1.2rem;">
        {!! nl2br(e($info->admission_dates ?? 'FECHAS DE ADMISION')) !!}
    </div>

    {{-- Carreras Ofertadas --}}
    <h4 class="fw-bold text-center mt-5 mb-3 text-uppercase">Carreras Ofertadas</h4>
    <div class="bg-secondary text-white p-4 mb-4 rounded">
        <div class="row">
            @php
                $careers = array_filter(array_map('trim', explode(',', $info->careers ?? '')));
                $half = ceil(count($careers) / 2);
            @endphp
            <div class="col-md-6">
                <ul class="list-unstyled">
                    @foreach(array_slice($careers, 0, $half) as $career)
                        <li class="mb-2">{{ $career }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    @foreach(array_slice($careers, $half) as $career)
                        <li class="mb-2">{{ $career }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-center mt-5 mb-4 text-lowercase" style="font-size:1.7rem;">cursos recomendados</h4>
    <div class="row justify-content-center">
        @foreach($recommendedCourses as $course)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" style="height:160px;object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                            <span class="text-muted">Sin imagen</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $course->title }}</h6>
                        <div class="small mb-1">Duración: {{ $course->number_of_weeks }} semanas</div>
                        <div class="small mb-2">Precio por semana: <span class="fw-bold">${{ number_format($course->price_per_week, 2) }}</span></div>
                        <a href="{{ route('store.course', $course->id) }}" class="btn btn-primary w-100">Ver curso</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
