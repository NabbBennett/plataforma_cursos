@extends('layouts.app')

@section('title', 'Iniciar Examen')

@section('content')
<style>
    .exam-start-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .exam-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .exam-header {
        margin-bottom: 2rem;
    }
    
    .exam-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .exam-subtitle {
        font-size: 1.1rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    
    .exam-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .info-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    
    .info-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--btn-primary-bg);
    }
    
    .info-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .warning-section {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
        border: 1px solid rgba(220, 53, 69, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
        text-align: left;
    }
    
    .warning-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .warning-icon {
        font-size: 1.5rem;
        color: #dc3545;
    }
    
    .warning-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #dc3545;
        margin: 0;
    }
    
    .warning-text {
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }
    
    .instructions-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
        text-align: left;
    }
    
    .instructions-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .instructions-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .instructions-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        color: var(--text-secondary);
    }
    
    .instructions-item:last-child {
        margin-bottom: 0;
    }
    
    .instruction-check {
        color: var(--success-color);
        font-size: 1.1rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
    }
    
    .start-button {
        background: linear-gradient(135deg, var(--btn-primary-bg) 0%, var(--success-color) 100%);
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 1.25rem 3rem;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .start-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .start-button:active {
        transform: translateY(-1px);
    }
    
    .button-icon {
        font-size: 1.4rem;
        color: currentColor;
    }
    
    .exam-progress {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }
    
    .progress-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .progress-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--border-color);
    }
    
    .progress-dot.active {
        background: var(--success-color);
    }
    
    /* Estilos para móvil */
    @media (max-width: 768px) {
        .exam-start-container {
            margin: 1rem auto;
            padding: 0 0.75rem;
        }
        
        .exam-card {
            padding: 2rem 1.5rem;
        }
        
        .exam-title {
            font-size: 1.8rem;
        }
        
        .exam-info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .info-card {
            padding: 1.25rem;
        }
        
        .info-icon {
            font-size: 2rem;
        }
        
        .info-value {
            font-size: 1.2rem;
        }
        
        .warning-section,
        .instructions-section {
            padding: 1.25rem;
        }
        
        .start-button {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            width: 100%;
            justify-content: center;
        }
        
        .exam-progress {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
    
    @media (max-width: 480px) {
        .exam-start-container {
            padding: 0 0.5rem;
        }
        
        .exam-card {
            padding: 1.5rem 1.25rem;
        }
        
        .exam-title {
            font-size: 1.6rem;
        }
        
        .exam-subtitle {
            font-size: 1rem;
        }
        
        .info-card {
            padding: 1rem;
        }
        
        .info-icon {
            font-size: 1.8rem;
        }
        
        .warning-section,
        .instructions-section {
            padding: 1rem;
        }
        
        .start-button {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
    }
    
    @media (max-width: 360px) {
        .exam-title {
            font-size: 1.4rem;
        }
        
        .exam-card {
            padding: 1.25rem 1rem;
        }
    }
</style>

<div class="exam-start-container">
    <div class="exam-card">
        <!-- Encabezado del examen -->
        <div class="exam-header">
            <h1 class="exam-title">{{ $exam->title }}</h1>
        </div>
        
        <!-- Información del examen -->
        <div class="exam-info-grid">
            <div class="info-card">
                <div class="info-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="info-label">Duración</div>
                <div class="info-value">{{ $exam->duration_minutes }} min</div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="bi bi-question-circle"></i>
                </div>
                <div class="info-label">Preguntas</div>
                <div class="info-value">{{ $exam->questions->count() }}</div>
            </div>
        </div>
        
        <!-- Advertencia importante -->
        <div class="warning-section">
            <div class="warning-header">
                <i class="bi bi-exclamation-triangle warning-icon"></i>
                <h4 class="warning-title">Importante</h4>
            </div>
            <p class="warning-text">
                El tiempo comenzará a correr desde el momento en que inicies el examen. 
                No cierres esta ventana ni recargues la página durante la evaluación. 
                Cualquier interrupción podría afectar tu progreso.
            </p>
        </div>
        
        <!-- Instrucciones -->
        <div class="instructions-section">
            <h4 class="instructions-title">
                <i class="bi bi-list-check"></i>
                Instrucciones del examen
            </h4>
            <ul class="instructions-list">
                <li class="instructions-item">
                    <i class="bi bi-check-circle instruction-check"></i>
                    <span>Responde todas las preguntas dentro del tiempo establecido</span>
                </li>
                <li class="instructions-item">
                    <i class="bi bi-check-circle instruction-check"></i>
                    <span>No podrás retroceder a preguntas anteriores</span>
                </li>
                <li class="instructions-item">
                    <i class="bi bi-check-circle instruction-check"></i>
                    <span>Tu progreso se guarda automáticamente</span>
                </li>
                <li class="instructions-item">
                    <i class="bi bi-check-circle instruction-check"></i>
                    <span>Revisa tus respuestas antes de finalizar</span>
                </li>
            </ul>
        </div>
        
        <!-- Botón de inicio -->
        <form method="POST" action="{{ route('student.exams.begin', ['course' => $course->id, 'exam' => $exam->id]) }}">
            @csrf
            <button type="submit" class="start-button">
                <i class="bi bi-play-circle button-icon"></i>
                Iniciar Examen
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efectos de hover para las tarjetas de información
    const infoCards = document.querySelectorAll('.info-card');
    
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Confirmación antes de iniciar el examen
    const startButton = document.querySelector('.start-button');
    const startForm = startButton.closest('form');
    
    startForm.addEventListener('submit', function(e) {
        if (!confirm('¿Estás listo para comenzar el examen? El tiempo empezará a correr inmediatamente.')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection