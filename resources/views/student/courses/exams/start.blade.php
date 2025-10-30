@extends('layouts.app')

@section('title', 'Iniciar Examen')

@section('content')
<div class="container mt-4">
    <h3>{{ $exam->title }}</h3>
    <p>Duración: {{ $exam->duration_minutes }} minutos.</p>
    <p>Este examen tiene {{ $exam->questions->count() }} preguntas.</p>

    <p class="text-danger">⚠️ Recuerda que el tiempo corre desde que inicies. No cierres la ventana.</p>

    <form method="POST" action="{{ route('student.exams.begin', ['course' => $course->id, 'exam' => $exam->id]) }}">
        @csrf
        <button type="submit" class="btn btn-success">
            Iniciar examen
        </button>
    </form>
</div>
@endsection
