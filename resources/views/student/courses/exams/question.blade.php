@extends('layouts.app')

@section('content')

<!-- Configuración de MathJax ANTES de cargar el script -->
<script>
    window.MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']]
        },
        svg: {
            fontCache: 'global'
        },
        startup: {
            pageReady: () => {
                console.log('MathJax startup pageReady');
                return MathJax.typesetPromise();
            }
        }
    };
</script>

<style>
    .exam-bg {
        background-color: var(--bg-primary);
        min-height: 100vh;
        transition: background-color 0.3s;
    }
    
    .exam-header {
        background: rgba(0, 0, 0, 0.1) !important;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid var(--border-color);
    }
    
    .question-container, .answer-container {
        background-color: var(--bg-secondary);
        border-radius: 10px;
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }
    
    .indicators-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: var(--bg-secondary);
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    
    .indicators-table th, .indicators-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        transition: all 0.3s;
    }
    
    .indicators-table th {
        background-color: var(--bg-primary);
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
    }
    
    .indicators-table tr:last-child td {
        border-bottom: none;
    }
    
    .value-cell {
        text-align: center;
        font-weight: bold;
        color: var(--text-secondary);
    }
    
    .nav-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        margin: 0 2px;
        opacity: 0.7;
        transition: all 0.3s;
        text-decoration: none;
        border: 1px solid var(--border-color);
    }
    
    .nav-btn.active {
        opacity: 1;
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-color: var(--btn-primary-bg);
    }

    .nav-btn.active.answered {
        /* Mantener estilo de activa pero con el tachado/X visibles */
        opacity: 1;
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text) !important;
        border-color: var(--btn-primary-bg);
        text-decoration: line-through !important;
        text-decoration-thickness: 2px;
        text-decoration-color: var(--btn-primary-text);
    }
    
    .nav-btn.answered {
        text-decoration: line-through !important;
        text-decoration-thickness: 2px;
        text-decoration-color: var(--text-primary);
        text-decoration-skip-ink: none;
        background-color: var(--bg-secondary);
        color: var(--text-primary) !important;
        font-weight: 700;
        position: relative;
    }

    .nav-btn.answered::after {
        content: '✕';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-primary);
        pointer-events: none;
    }
    
    .form-check-input:checked {
        background-color: var(--btn-primary-bg);
        border-color: var(--btn-primary-bg);
    }

    body.dark-mode .form-check-input{
        background-color: var(--dark-base);
    }
    
    .form-check-label {
        color: var(--text-primary);
        transition: color 0.3s;
    }
    
    .section-title {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    hr {
        border-color: var(--border-color);
        opacity: 0.5;
    }
    
    /* Estados hover para botones de navegación */
    .nav-btn:not(.active):hover {
        opacity: 0.9;
        background-color: var(--bg-secondary);
    }
    
    /* Estilos específicos para modo oscuro */
    body.dark-mode .exam-header {
        background: rgba(255, 255, 255, 0.05) !important;
    }
    
    body.dark-mode .question-container,
    body.dark-mode .answer-container {
        background: rgba(255, 255, 255, 0.03);
    }
    
    body.dark-mode .indicators-table {
        background: rgba(255, 255, 255, 0.03);
    }
    
    body.dark-mode .indicators-table th {
        background: rgba(255, 255, 255, 0.08);
    }
    
    @media (max-width: 768px) {
        .exam-header {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .indicators-table {
            font-size: 0.85rem;
        }
        
        .indicators-table th, .indicators-table td {
            padding: 8px 10px;
        }
        
        .nav-btn {
            width: 35px;
            height: 35px;
            margin: 1px;
            font-size: 0.9rem;
        }
        
        .question-container, .answer-container {
            padding: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .indicators-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        
        .nav-btn {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        
        .exam-title span {
            font-size: 1.5rem !important;
        }
        
        .question-container, .answer-container {
            padding: 12px;
        }
    }
</style>

<div class="exam-bg py-3">
    <div class="container">
        <!-- Header del examen -->
        <div class="d-flex justify-content-between align-items-center mb-4 exam-header">
            <div class="d-flex align-items-center">
                <span class="fs-5 fw-bold" style="color: var(--text-primary);">Instituto Resiliencia</span>
            </div>
            <div class="exam-title text-center flex-grow-1">
                <span class="fs-5 fw-bold" style="color: var(--text-primary);">Examen de semana #{{ $exam->id }}</span>
            </div>
            <div>
                <span class="fs-5 fw-bold" style="color: var(--text-primary);" id="timer">00:00</span>
            </div>
        </div>

        <!-- Formulario del examen -->
        <form id="examAnswersForm" method="POST" action="{{ route('student.exams.submit', ['course' => $course->id, 'exam' => $exam->id]) }}">
            @csrf
            <div class="row g-4">
                <!-- Columna de pregunta -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong class="section-title">Num pregunta: {{ $questionNumber }}</strong>
                    </div>
                    <div class="question-container" style="min-height: 180px;">
                        <div style="color: var(--text-primary);">
                            @if($question->image_path)
                                <img src="{{ asset('storage/' . $question->image_path) }}" alt="Pregunta" style="max-width: 100%; max-height: 300px; border-radius: 8px; object-fit: contain;">
                            @else
                                {!! $question->text !!}
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Columna de respuestas -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong class="section-title">RESPUESTA</strong>
                    </div>
                    <div class="answer-container" style="min-height: 180px;">
                        @foreach ($question->answers as $answer)
                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                       type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $answer->id }}"
                                       id="answer_{{ $answer->id }}"
                                       onchange="saveAnswer({{ $question->id }}, {{ $answer->id }})"
                                       {{ old("answers.{$question->id}", session("exam_{$exam->id}.answers.{$question->id}")) == $answer->id ? 'checked' : '' }}
                                       {{ session("exam_{$exam->id}.finished") ? 'disabled' : '' }}>
                                <label class="form-check-label" for="answer_{{ $answer->id }}" style="display: flex; align-items: center; gap: 10px;">
                                    @if($answer->image_path)
                                        <img src="{{ asset('storage/' . $answer->image_path) }}" alt="Respuesta" style="max-width: 120px; max-height: 80px; border-radius: 4px; object-fit: contain;">
                                    @else
                                        {!! $answer->text !!}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-4">

        <!-- Navegación inferior -->
        <div class="exam-nav d-flex flex-wrap justify-content-center align-items-center gap-2 py-3">
            @foreach ($exam->questions->sortBy('order')->values() as $i => $q)
                @php
                    $answered = session("exam_{$exam->id}.answers.{$q->id}") ?? null;
                    $active = $q->id == $question->id;
                @endphp
                <a href="{{ route('student.exams.question', [
                        'course' => $course->id,
                        'exam' => $exam->id,
                        'questionNumber' => $i + 1
                    ]) }}"
                   class="nav-btn btn btn-sm {{ $active ? 'active' : '' }} {{ $answered ? 'answered' : '' }}"
                   style="color: {{ $active ? 'var(--btn-primary-text)' : 'var(--text-primary)' }};"
                   onclick="typesetMath();">
                    {{ $i + 1 }}
                </a>
            @endforeach
            <button type="submit" form="examAnswersForm" class="btn btn-danger btn-sm ms-3" {{ session("exam_{$exam->id}.finished") ? 'disabled' : '' }}>FIN</button>
        </div>
    </div>
</div>

<script>
function saveAnswer(questionId, answerId) {
    fetch("{{ route('student.exams.saveAnswer', ['course' => $course->id, 'exam' => $exam->id]) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            question_id: questionId,
            answer_id: answerId,
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Guardado correctamente:', data);
        // Actualizar el estado de la pregunta en la navegación
        const navBtn = document.querySelector(`a[href*="questionNumber={{ $questionNumber }}"]`);
        if (navBtn) {
            navBtn.classList.add('answered');
        }
    })
    .catch(error => console.error('Error al guardar respuesta:', error));
}

// Timer
const expirationTimestamp = "{{ session("exam_{$exam->id}")['expires_at'] ?? now() }}";
const endTime = new Date(expirationTimestamp).getTime();

function updateTimer() {
    const now = new Date().getTime();
    const distance = endTime - now;
    
    if (distance < 0) {
        clearInterval(timerInterval);
        document.getElementById("timer").textContent = "00:00";
        document.getElementById('examAnswersForm').submit();
        return;
    }
    
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("timer").textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

const timerInterval = setInterval(updateTimer, 1000);
updateTimer();

// Procesar MathJax cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOMContentLoaded ===');
    console.log('MathJax disponible:', !!window.MathJax);
    console.log('MathJax.typesetPromise:', typeof window.MathJax?.typesetPromise);
    
    if (window.MathJax) {
        console.log('Iniciando procesamiento de MathJax...');
        
        // Usar un timeout como fallback para asegurar que MathJax se procese
        // aunque las imágenes no hayan terminado de cargar
        setTimeout(() => {
            console.log('Timeout 500ms - Procesando MathJax...');
            MathJax.typesetPromise()
                .then(() => console.log('✓ MathJax procesado exitosamente en timeout'))
                .catch(err => console.error('✗ Error en MathJax timeout:', err));
        }, 500);
        
        // También procesar cuando las imágenes carguen
        const images = document.querySelectorAll('img');
        console.log('Imágenes encontradas:', images.length);
        
        images.forEach((img, idx) => {
            img.addEventListener('load', () => {
                console.log(`✓ Imagen ${idx} cargada - Reprocesando MathJax...`);
                MathJax.typesetPromise()
                    .then(() => console.log('✓ MathJax procesado después de cargar imagen'))
                    .catch(err => console.error('✗ Error en MathJax:', err));
            });
            
            img.addEventListener('error', () => {
                console.log(`✗ Imagen ${idx} falló en cargar`);
            });
        });
    } else {
        console.error('✗ MathJax no está disponible');
    }
});

// Función para reprocesar MathJax cuando se navega a otra pregunta
function typesetMath() {
    console.log('=== typesetMath() llamado ===');
    if (window.MathJax && MathJax.typesetPromise) {
        // Procesar inmediatamente y también con delay para asegurar
        console.log('Procesando MathJax inmediatamente...');
        MathJax.typesetPromise()
            .then(() => console.log('✓ MathJax procesado inmediatamente'))
            .catch(err => console.error('✗ Error MathJax inmediato:', err));
        
        setTimeout(() => {
            console.log('Procesando MathJax con delay 300ms...');
            MathJax.typesetPromise()
                .then(() => console.log('✓ MathJax procesado con delay'))
                .catch(err => console.error('✗ Error MathJax delay:', err));
        }, 300);
    } else {
        console.error('✗ MathJax no disponible en typesetMath()');
    }
}

// Asegurar que los estilos se apliquen correctamente al cambiar de tema
document.addEventListener('DOMContentLoaded', function() {
    const themeToggleButtons = document.querySelectorAll('.theme-toggle');
    themeToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Forzar actualización de estilos después del cambiar de tema
            setTimeout(() => {
                document.querySelectorAll('.question-container, .answer-container, .indicators-table').forEach(el => {
                    el.style.display = 'none';
                    el.offsetHeight; // Trigger reflow
                    el.style.display = '';
                });
            }, 100);
        });
    });
});
</script>

<!-- MathJax CDN - CARGADO AL FINAL -->
<script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

@endsection