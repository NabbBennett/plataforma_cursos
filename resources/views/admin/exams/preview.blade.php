@extends('layouts.admin')

@section('title', 'Vista Previa del Examen')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">{{ $exam->title }}</h2>
    <p><strong>Duración:</strong> {{ $exam->duration_minutes }} minutos</p>

    @foreach ($exam->questions as $index => $question)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Pregunta {{ $index + 1 }} - {{ $question->theme ?? 'Sin tema' }}</strong>
            </div>
            <div class="card-body">
                <div>{!! $question->text !!}</div>
                <ul>
                    @foreach ($question->answers as $answer)
                        <li class="respuesta-examen">
                            <span>{!! $answer->text !!}</span>
                            @if ($answer->is_correct)
                                <span class="badge bg-success ms-2">Correcta</span>
                            @else
                                <span class="badge bg-secondary ms-2">Incorrecta</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
<style>
    .respuesta-examen {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 0.5rem;
    }
    .respuesta-examen .badge {
        margin-left: 0.5rem;
        vertical-align: middle;
    }
    .respuesta-examen span {
        display: flex;
        align-items: center;
    }
</style>
@endsection
