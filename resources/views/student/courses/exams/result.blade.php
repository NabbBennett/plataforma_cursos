@extends('layouts.app')

@section('title', 'Resultados del examen')

@section('content')
<style>
    .results-container {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        min-height: 100vh;
        padding: 2rem 0;
        transition: all 0.3s;
    }

    .results-header {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: var(--bg-primary);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        text-align: center;
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        font-weight: bold;
        border: 4px solid;
    }

    .score-excellent {
        background-color: rgba(40, 167, 69, 0.1);
        border-color: #28a745;
        color: #28a745;
    }

    .score-good {
        background-color: rgba(23, 162, 184, 0.1);
        border-color: #17a2b8;
        color: #17a2b8;
    }

    .score-average {
        background-color: rgba(255, 193, 7, 0.1);
        border-color: #ffc107;
        color: #ffc107;
    }

    .score-poor {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
        color: #dc3545;
    }

    .questions-section {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .section-title {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .table-custom {
        background-color: var(--bg-primary);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .table-custom th {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        border-color: var(--border-color);
        font-weight: 600;
        padding: 1rem;
    }

    .table-custom td {
        border-color: var(--border-color);
        padding: 1rem;
        color: var(--text-primary);
        vertical-align: top;
    }

    .table-success-custom th {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }

    .table-danger-custom th {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }

    .alert-warning-custom {
        background-color: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 1.5rem;
    }

    .btn-custom {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .topic-badge {
        background-color: var(--bg-primary);
        color: var(--text-secondary);
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        border: 1px solid var(--border-color);
    }

    .question-text, .answer-text {
        max-height: 100px;
        overflow-y: auto;
        padding-right: 0.5rem;
        line-height: 1.4;
    }

    .question-text::-webkit-scrollbar,
    .answer-text::-webkit-scrollbar {
        width: 4px;
    }

    .question-text::-webkit-scrollbar-thumb,
    .answer-text::-webkit-scrollbar-thumb {
        background-color: var(--border-color);
        border-radius: 2px;
    }

    .correct-answer {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 3px solid #28a745;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.25rem;
    }

    .incorrect-answer {
        background-color: rgba(220, 53, 69, 0.1);
        border-left: 3px solid #dc3545;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.25rem;
    }

    .correct-label {
        color: #28a745;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .incorrect-label {
        color: #dc3545;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .answer-comparison {
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .results-header {
            padding: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .score-circle {
            width: 100px;
            height: 100px;
            font-size: 1.5rem;
        }

        .questions-section {
            padding: 1rem;
        }

        .table-custom {
            font-size: 0.85rem;
        }

        .table-custom th,
        .table-custom td {
            padding: 0.75rem 0.5rem;
        }

        .question-text, .answer-text {
            max-height: 80px;
        }
    }

    @media (max-width: 576px) {
        .results-container {
            padding: 1rem 0;
        }

        .results-header {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
        }

        .score-circle {
            width: 80px;
            height: 80px;
            font-size: 1.25rem;
        }

        .btn-custom {
            width: 100%;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .table-responsive-custom {
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
    }
</style>

<div class="results-container">
    <div class="container">
        <!-- Header de resultados -->
        <div class="results-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-3" style="color: var(--text-primary);">Resultados del Examen</h1>
                </div>
                <div class="col-md-4 text-center">
                    @php
                        $score = round(($examResult->correct_answers / $examResult->total_questions) * 100, 2);
                        $scoreClass = $score >= 80 ? 'score-excellent' : 
                                    ($score >= 60 ? 'score-good' : 
                                    ($score >= 40 ? 'score-average' : 'score-poor'));
                    @endphp
                    <div class="score-circle {{ $scoreClass }}">
                        {{ $score }}%
                    </div>
                    <small style="color: var(--text-secondary);">Puntuación Final</small>
                </div>
            </div>
        </div>

        <!-- Estadísticas principales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value text-success">{{ $examResult->correct_answers }}</div>
                <div class="stat-label">Correctas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-danger">{{ $examResult->wrong_answers }}</div>
                <div class="stat-label">Incorrectas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--text-secondary);">
                    {{ $examResult->total_questions - ($examResult->correct_answers + $examResult->wrong_answers) }}
                </div>
                <div class="stat-label">Sin responder</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--text-primary);">
                    {{ gmdate("i:s", $examResult->total_duration) }}
                </div>
                <div class="stat-label">Tiempo Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--text-primary);">
                    {{ $examResult->average_time }}s
                </div>
                <div class="stat-label">Promedio por Pregunta</div>
            </div>
        </div>

        <!-- Análisis de temas con errores -->
        @php
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
            arsort($temasIncorrectos);
        @endphp

        @if(count($temasIncorrectos))
            <div class="alert-warning-custom mb-4">
                <strong style="color: var(--text-primary);">Temas que necesitas repasar:</strong>
                <div class="mt-2">
                    @foreach($temasIncorrectos as $tema => $errores)
                        <span class="topic-badge me-2 mb-2 d-inline-block">
                            {{ $tema }} ({{ $errores }} error{{ $errores > 1 ? 'es' : '' }})
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Detalle de preguntas correctas e incorrectas -->
        <div class="questions-section">
            <h3 class="section-title">Detalle de Respuestas</h3>
            
            <div class="row">
                <!-- Preguntas Correctas -->
                <div class="row-lg-6 mb-4">
                    <h5 class="text-success mb-3">Preguntas Correctas ({{ $examResult->correct_answers }})</h5>
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-custom table-success-custom">
                            <thead>
                                <tr class="align-middle text-left">
                                    <th>#</th>
                                    <th>Tema</th>
                                    <th>Pregunta</th>
                                    <th>Tu Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($examResult->examAnswers as $answer)
                                    @if ($answer->selected_answer_id == $answer->correct_answer_id)
                                        <tr>
                                            <td><strong>{{ $i++ }}</strong></td>
                                            <td><span class="topic-badge">{{ $answer->topic ?? '-' }}</span></td>
                                            <td>{!! Str::limit(strip_tags($answer->question->text), 60) !!}</td>
                                            <td>{!! Str::limit(strip_tags($answer->selectedAnswer->text ?? ''), 50) !!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Preguntas Incorrectas -->
                <div class="row-lg-6 mb-4">
                    <h5 class="text-danger mb-3">Preguntas Incorrectas ({{ $examResult->wrong_answers }})</h5>
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-custom table-danger-custom">
                            <thead>
                                <tr class="align-middle text-left">
                                    <th>#</th>
                                    <th>Tema</th>
                                    <th>Pregunta</th>
                                    <th>Tu Respuesta</th>
                                    <th>Respuesta Correcta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $j = 1; @endphp
                                @foreach ($examResult->examAnswers as $answer)
                                    @if ($answer->selected_answer_id != $answer->correct_answer_id)
                                        <tr>
                                            <td><strong>{{ $j++ }}</strong></td>
                                            <td><span class="topic-badge">{{ $answer->topic ?? '-' }}</span></td>
                                            <td>{!! Str::limit(strip_tags($answer->question->text), 60) !!}</td>
                                            <td>
                                                @if($answer->selectedAnswer)
                                                    {!! Str::limit(strip_tags($answer->selectedAnswer->text), 40) !!}
                                                @else
                                                    <small class="incorrect-label">No respondiste</small>
                                                @endif
                                            </td>   
                                            <td>{!! Str::limit(strip_tags($answer->correctAnswer->text ?? ''), 40) !!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de regreso -->
        <div class="text-center mt-4">
            <a href="{{ url()->previous() }}" class="btn-custom me-3">
                ← Volver Atrás
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación suave para las tarjetas de estadísticas
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Scroll suave para las tablas en móvil
    const tables = document.querySelectorAll('.table-responsive-custom');
    tables.forEach(table => {
        if (window.innerWidth < 768) {
            table.addEventListener('touchstart', function() {
                this.style.overflowX = 'auto';
            });
        }
    });
});
</script>
@endsection