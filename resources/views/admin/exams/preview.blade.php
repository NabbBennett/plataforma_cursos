@extends('layouts.admin')

@section('title', 'Vista Previa del Examen')

@section('content')
<!-- MathJax Configuration -->
<script>
window.MathJax = {
    tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']],
        packages: { '[+]': ['mhchem'] }
    },
    svg: { 
        fontCache: 'global',
        scale: 0.9
    }
};
</script>
<script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<div class="container mt-4">
    <div class="exam-preview-header">
        <h2 class="mb-2">{{ $exam->title }}</h2>
        <div class="exam-meta">
            <span class="badge bg-primary">
                <i class="bi bi-clock"></i> {{ $exam->duration_minutes }} minutos
            </span>
            <span class="badge bg-secondary">
                <i class="bi bi-question-circle"></i> {{ $exam->questions->count() }} preguntas
            </span>
        </div>
    </div>

    <div class="exam-questions">
        @foreach ($exam->questions as $index => $question)
            <div class="question-card">
                <div class="question-header">
                    <div class="question-title">
                        <strong class="question-number">Pregunta {{ $index + 1 }}</strong>
                    </div>
                </div>
                
                <div class="question-content">
                    @if($question->image_path)
                        <div class="question-image mb-3">
                            <img src="{{ $question->getImageUrl() }}" 
                                 alt="Imagen de pregunta {{ $index + 1 }}" 
                                 class="img-fluid rounded question-img"
                                 onerror="this.style.display='none'">             
                        </div>
                    @endif
                    <div class="question-text math-content">
                        {!! $question->text !!}
                    </div>
                </div>

                <div class="question-answers">
                    <h6 class="answers-title">Respuestas:</h6>
                    <div class="answers-list">
                        @foreach ($question->answers as $answerIndex => $answer)
                            <div class="answer-item {{ $answer->is_correct ? 'correct-answer' : 'incorrect-answer' }}">
                                <div class="answer-content">
                                    @if($answer->image_path)
                                        <div class="answer-image mb-2">
                                            <img src="{{ $answer->getImageUrl() }}" 
                                                 alt="Imagen de respuesta {{ $answerIndex + 1 }}" 
                                                 class="img-fluid rounded answer-img"
                                                 onerror="this.style.display='none'">
                                        </div>
                                    @endif
                                    <div class="answer-text math-content">
                                        {!! $answer->text !!}
                                    </div>
                                </div>
                                <div class="answer-badge">
                                    @if ($answer->is_correct)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Correcta
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> Incorrecta
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="exam-actions mt-4">
        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Exámenes
        </a>
    </div>
</div>

<style>
.exam-preview-header {
    background: linear-gradient(135deg, var(--bg-secondary), var(--bg-primary));
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
}

.exam-preview-header h2 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 700;
}

.exam-meta {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.exam-meta .badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.question-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.question-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-color);
}

.question-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.question-number {
    font-size: 1.1rem;
    color: var(--text-primary);
    font-weight: 700;
}

.question-theme {
    color: var(--text-muted);
    font-style: italic;
}

.question-content {
    margin-bottom: 1.5rem;
}

.question-image, .answer-image {
    text-align: center;
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    background-color: var(--bg-secondary);
}

.question-img, .answer-img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.question-img:hover, .answer-img:hover {
    transform: scale(1.02);
}

.image-path {
    font-family: monospace;
    background: var(--bg-primary);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    margin-top: 0.5rem;
}

.question-text {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--text-primary);
    padding: 1rem;
    background-color: var(--bg-secondary);
    border-radius: 8px;
    border-left: 4px solid var(--btn-primary-bg);
}

.answers-title {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 600;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border-color);
}

.answers-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.answer-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    gap: 1rem;
}

.answer-item:hover {
    transform: translateX(5px);
}

.correct-answer {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
    border-left: 4px solid #28a745;
}

.incorrect-answer {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(108, 117, 125, 0.05));
    border-left: 4px solid #6c757d;
}

.answer-content {
    flex: 1;
    min-width: 0;
}

.answer-text {
    font-size: 0.95rem;
    line-height: 1.5;
    color: var(--text-primary);
}

.answer-badge {
    flex-shrink: 0;
}

.answer-badge .badge {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 12px;
}

.exam-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding: 1.5rem;
    background-color: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

/* Estilos para imágenes que fallan al cargar */
.image-error {
    border: 2px dashed #dc3545;
    background: #f8d7da;
    padding: 2rem;
    text-align: center;
    border-radius: 8px;
}

.image-error-message {
    color: #721c24;
    font-weight: bold;
}

/* Estilos para MathJax */
.math-content mjx-container {
    display: inline-block;
    margin: 0 0.1em;
    vertical-align: middle;
}

.math-content mjx-container[jax="CHTML"][display="true"] {
    display: block;
    margin: 1em 0;
    text-align: center;
}

.math-content mjx-container svg {
    max-width: 100%;
    height: auto;
}

/* Estilos para impresión */
@media print {
    .exam-actions {
        display: none;
    }
    
    .question-card {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #ccc;
    }
    
    .answer-badge .badge {
        border: 1px solid #000;
        color: #000;
        background: transparent !important;
    }
    
    .correct-answer {
        background: #f8fff8 !important;
    }
    
    .incorrect-answer {
        background: #f8f9fa !important;
    }
    
    .question-img, .answer-img {
        max-height: 250px;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .exam-preview-header {
        padding: 1.5rem;
    }
    
    .exam-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .question-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .answer-item {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .answer-badge {
        align-self: flex-end;
    }
    
    .exam-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0.5rem;
    }
    
    .question-card {
        padding: 1rem;
    }
    
    .question-text {
        padding: 0.75rem;
    }
    
    .question-img, .answer-img {
        max-height: 250px;
    }
}
</style>

<script>
// Función para verificar el estado de las imágenes
function checkImages() {
    const images = document.querySelectorAll('img');
    let loaded = 0;
    let failed = 0;
    
    images.forEach(img => {
        if (img.complete && img.naturalHeight !== 0) {
            loaded++;
        } else {
            failed++;
            // Mostrar mensaje de error
            const container = img.parentElement;
            const errorDiv = document.createElement('div');
            errorDiv.className = 'image-error';
            errorDiv.innerHTML = `
                <div class="image-error-message">
                    <i class="bi bi-exclamation-triangle"></i> Imagen no disponible
                </div>
                <small>Ruta: ${img.src}</small>
            `;
            container.appendChild(errorDiv);
        }
    });
    
    alert(`Imágenes cargadas: ${loaded}\nImágenes fallidas: ${failed}`);
}

// Verificar imágenes automáticamente después de cargar
window.addEventListener('load', function() {
    setTimeout(() => {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            if (!img.complete || img.naturalHeight === 0) {
                console.warn('Imagen no cargada:', img.src);
            }
        });
    }, 2000);
});

// Esperar a que MathJax cargue y procese todo el contenido
if (window.MathJax) {
    MathJax.startup.promise.then(() => {
        console.log('MathJax procesando fórmulas en el preview...');
        setTimeout(() => {
            MathJax.typesetPromise().catch(error => {
                console.warn('Error procesando MathJax:', error);
            });
        }, 500);
    }).catch(error => {
        console.warn('Error inicializando MathJax:', error);
    });
}

// Función para reprocesar fórmulas si es necesario
function reprocessMath() {
    if (window.MathJax && MathJax.typesetPromise) {
        MathJax.typesetPromise();
    }
}

// Reprocesar cuando se cambie el tamaño de la ventana
window.addEventListener('resize', () => {
    setTimeout(reprocessMath, 100);
});
</script>
@endsection