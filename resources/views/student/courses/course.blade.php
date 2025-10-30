@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container" style="max-width: 1000px; margin: 2rem auto;">

    {{-- Panel informativo del curso --}}
    <div style="margin-bottom: 2rem; padding: 1rem; border: 1px solid #ccc; border-radius: 8px;">
        <h2>{{ $course->title }}</h2>
        <p><strong>Número de Administración:</strong> 101</p>
        <p><strong>Número de DUAS:</strong> 202</p>
        <p><strong>Psicólogo vocacional:</strong> Mtra. Ana Pérez</p>
        <p><strong>Instrucciones:</strong> Este curso está diseñado para guiarte paso a paso. Revisa las clases, realiza los exámenes y consulta los recursos cada semana.</p>
    </div>

    {{-- Carrusel de semanas --}}
    <div style="margin-bottom: 3rem;">
        <h3>Contenido del curso</h3>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <button id="prev-week" class="btn btn-light">⬅️</button>

            <div id="carousel-wrapper" style="overflow-x: auto; scroll-behavior: smooth; white-space: nowrap; width: 100%; border-radius: 8px;">
                @foreach ($combined as $item)
                    @php
                        $isEvaluation = $item['type'] === 'evaluation';
                        $week = $item['data'];
                    @endphp

                    <div class="week-card" style="
                        display: inline-block;
                        vertical-align: top;
                        width: 300px;
                        margin-right: 16px;
                        border: 1px solid #ccc;
                        border-radius: 8px;
                        padding: 1rem;
                        white-space: normal;
                        background-color: {{ $isEvaluation ? '#f9f9f9' : 'white' }};
                    ">
                        <h4>{{ $isEvaluation ? 'Bloque de Evaluación' : 'Semana ' . $week->number }}</h4>

                        @if ($week->live_meet_link)
                            <p><strong>Clases en línea:</strong><br>
                                <a href="{{ $week->live_meet_link }}" target="_blank" class="btn btn-primary btn-sm mt-1">Ir a la clase en vivo</a>
                            </p>
                        @endif

                        @if ($week->recording_link)
                            <p><strong>Clases grabadas:</strong><br>
                                <a href="{{ route('student.recorded', $week->recording_link) }}" class="btn btn-secondary btn-sm mt-1">Ver clases grabadas</a>
                            </p>
                        @endif

                        @php
                            $exam = isset($week->exam) ? $week->exam : null;
                            if (!$exam && isset($week->exam_id)) {
                                $exam = \App\Models\Exam::find($week->exam_id);
                            }
                        @endphp

                        @if ($exam)
                            @php
                                $result = \App\Models\ExamResult::where('user_id', Auth::id())->where('exam_id', $exam->id)->latest()->first();
                            @endphp

                            @if ($result)
                                <a href="{{ route('student.exams.result', ['course' => $course->id, 'exam' => $exam->id]) }}" class="btn btn-success btn-sm">Ver resultados</a>
                            @else
                                <a href="{{ route('student.exams.start', ['course' => $course->id, 'exam' => $exam->id]) }}" class="btn btn-primary btn-sm">Realizar examen</a>
                            @endif
                        @else
                            <p><em>No hay examen asignado</em></p>
                        @endif

                        @if ($week->resource_id)
                            <p>
                                <a href="{{ route('student.resources.view', ['type' => $isEvaluation ? 'evaluation' : 'week', 'id' => $week->id]) }}" class="btn btn-secondary btn-sm">Ver recursos</a>
                            </p>
                        @endif

                    </div>
                @endforeach
            </div>
            <button id="next-week" class="btn btn-light">➡️</button>
        </div>
    </div>

    {{-- Progresos --}}
    <div style="margin-bottom: 2rem;">
        <h3>Progresos</h3>
    </div>

    <div class="card p-4 mb-4">
        <h5>Puntaje (%)</h5>
        <canvas id="scoreChart" height="200"></canvas>
        <h5 class="mt-4">Tiempo promedio (s)</h5>
        <canvas id="timeChart" height="200"></canvas>
        <h5 class="mt-4">Respuestas correctas</h5>
        <canvas id="correctChart" height="200"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($labels);
        const scores = @json($scores);
        const averageTimes = @json($averageTimes);
        const correctAnswers = @json($correctAnswers);

        // Gráfica de Puntaje
        new Chart(document.getElementById('scoreChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Puntaje (%)',
                    data: scores,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });

        // Gráfica de Tiempo promedio
        new Chart(document.getElementById('timeChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tiempo promedio (s)',
                    data: averageTimes,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Gráfica de Respuestas correctas
        new Chart(document.getElementById('correctChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Correctas',
                    data: correctAnswers,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
    </script>

    <style>
        #progressChart { min-height: 200px; }
    </style>
</div>
@endsection



