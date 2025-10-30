@extends('layouts.app')

@section('title', 'Resultados del examen')

@section('content')
<div class="container mt-4">
    <h2>Examen finalizado</h2>

    {{-- Resumen de estadísticas --}}
    <p><strong>Puntaje:</strong> {{ round(($examResult->correct_answers / $examResult->total_questions) * 100, 2) }}%</p>
    <p><strong>Preguntas contestadas:</strong> {{ $examResult->correct_answers + $examResult->wrong_answers }}/{{ $examResult->total_questions }}</p>
    <p><strong>Preguntas no contestadas:</strong> {{ $examResult->total_questions - ($examResult->correct_answers + $examResult->wrong_answers) }}/{{ $examResult->total_questions }}</p>
    <p><strong>Tiempo total en responder:</strong> {{ gmdate("i:s", $examResult->total_duration) }} minutos</p>
    <p><strong>Tiempo promedio por pregunta:</strong> {{ $examResult->average_time }} segundos</p>

    
    {{-- Análisis de errores por tema --}}
    @php
        // Contar los temas de las respuestas incorrectas
        $temasIncorrectos = [];
        foreach ($examResult->examAnswers as $answer) {
            if ($answer->selected_answer_id != $answer->correct_answer_id) {
                $tema = $answer->topic ?? 'Sin tema';
                if (!isset($temasIncorrectos[$tema])) {
                    $temasIncorrectos[$tema] = 0;
                }
                $temasIncorrectos[$tema]++;
            }
        }
        // Ordenar de mayor a menor errores
        arsort($temasIncorrectos);
    @endphp

    @if(count($temasIncorrectos))
        <div class="alert alert-warning">
            <strong>Temas menos acertados:</strong>
            <ul class="mb-0">
                @foreach($temasIncorrectos as $tema => $errores)
                    <li>{{ $tema }} ({{ $errores }} error{{ $errores > 1 ? 'es' : '' }})</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Detalle por pregunta (Correctas / Incorrectas) --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Preguntas correctas ✅</h4>
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Tema</th>
                        <th>Pregunta</th>
                        <th>Tu respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($examResult->examAnswers as $answer)
                        @if ($answer->selected_answer_id == $answer->correct_answer_id)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $answer->topic ?? '-' }}</td>
                                <td>{!! $answer->question->text !!}</td>
                                <td>{!! optional($answer->selectedAnswer)->text !!}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        
        <div class="col-md-6">
            <h4>Preguntas incorrectas ❌</h4>
            <table class="table table-bordered">
                <thead class="table-danger">
                    <tr>
                        <th>#</th>
                        <th>Tema</th>
                        <th>Pregunta</th>
                        <th>Tu respuesta</th>
                        <th>Respuesta correcta</th>
                    </tr>
                </thead>
                <tbody>
                    @php $j = 1; @endphp
                    @foreach ($examResult->examAnswers as $answer)
                        @if ($answer->selected_answer_id != $answer->correct_answer_id)
                            <tr>
                                <td>{{ $j++ }}</td>
                                <td>{{ $answer->topic ?? '-' }}</td>
                                <td>{!! $answer->question->text !!}</td>
                                <td>{!! optional($answer->selectedAnswer)->text ?? '<em>Sin responder</em>' !!}</td>
                                <td>{!! optional($answer->correctAnswer)->text !!}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Botón de regreso --}}
    <a href="{{ route('student.courses.show', ['id' => $course->id]) }}" class="btn btn-primary mt-4">
        Volver al curso
    </a>
</div>
@endsection
