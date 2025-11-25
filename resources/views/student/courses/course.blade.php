@extends('layouts.app')

@section('title', $course->title)

@section('content')
<style>
    .course-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .info-panel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .course-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .info-value {
        color: var(--text-primary);
        font-size: 1rem;
    }
    
    .instructions-box {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .instructions-title {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
    }
    
    .instructions-text {
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0;
    }
    
    .carousel-section {
        margin-bottom: 3rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }
    
    .carousel-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .carousel-wrapper {
        flex: 1;
        overflow-x: hidden;
        border-radius: 12px;
        position: relative;
    }
    
    .carousel-track {
        display: flex;
        gap: 1rem;
        padding: 0.5rem 0;
        transition: transform 0.3s ease;
        width: max-content;
    }
    
    .carousel-btn {
        background: var(--bg-primary);
        border: 2px solid var(--border-color);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        z-index: 2;
    }
    
    .carousel-btn:hover {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-color: var(--btn-primary-bg);
        transform: scale(1.05);
    }
    
    .carousel-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
        transform: none;
    }
    
    .week-card {
        flex: 0 0 300px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    
    .week-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .week-card.evaluation {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
        border: 2px solid var(--btn-primary-bg);
    }
    
    .week-header {
        margin-bottom: 1.25rem;
    }
    
    .week-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }
    
    .week-type {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .week-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .content-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .content-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        text-align: center;
    }
    
    .btn-primary {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-secondary {
        background: var(--bg-primary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: var(--bg-secondary);
        transform: translateY(-2px);
    }
    
    .btn-success {
        background: #28a745;
        color: white;
    }
    
    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
    }
    
    .no-exam {
        color: var(--text-secondary);
        font-style: italic;
        font-size: 0.9rem;
        text-align: center;
        padding: 0.5rem;
    }
    
    .progress-section {
        margin-bottom: 2.5rem;
    }
    
    .charts-container {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .chart-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }
    
    .chart-container {
        margin-bottom: 5rem;
        position: relative;
        height: 250px;
    }
    
    .chart-container:last-child {
        margin-bottom: 0;
    }
    
    .filter-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .filter-select {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: var(--text-primary);
        font-size: 0.9rem;
        min-width: 200px;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--btn-primary-bg);
    }
    
    /* Estilos para móvil */
    @media (max-width: 768px) {
        .course-container {
            margin: 1rem auto;
            padding: 0 0.75rem;
        }
        
        .info-panel {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .course-title {
            font-size: 1.8rem;
            margin-bottom: 1.25rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .instructions-box {
            padding: 1.25rem;
        }
        
        .carousel-container {
            flex-direction: column;
            gap: 1rem;
        }
        
        .carousel-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            width: 100%;
        }
        
        .carousel-btn {
            width: 44px;
            height: 44px;
            position: static;
        }
        
        .carousel-wrapper {
            order: -1;
            width: 100%;
        }
        
        .week-card {
            flex: 0 0 280px;
            padding: 1.25rem;
        }
        
        .week-title {
            font-size: 1.2rem;
        }
        
        .charts-container {
            padding: 1.5rem;
        }
        
        .chart-container {
            height: 220px;
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
        
        .filter-section {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        
        .filter-select {
            min-width: auto;
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .course-container {
            padding: 0 0.5rem;
        }
        
        .info-panel {
            padding: 1.25rem;
        }
        
        .course-title {
            font-size: 1.6rem;
        }
        
        .week-card {
            flex: 0 0 260px;
            padding: 1rem;
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .charts-container {
            padding: 1.25rem;
        }
        
        .chart-container {
            height: 200px;
        }
        
        .carousel-btn {
            width: 40px;
            height: 40px;
        }
        
        .carousel-track {
            gap: 0.75rem;
        }
    }
    
    .progress-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .progress-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    
    .progress-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        border-color: var(--btn-primary-bg);
    }
    
    .progress-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .progress-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .progress-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .icon-score {
        background: rgba(54, 162, 235, 0.2);
        color: rgba(54, 162, 235, 1);
    }
    
    .icon-time {
        background: rgba(255, 206, 86, 0.2);
        color: rgba(255, 206, 86, 1);
    }
    
    .icon-correct {
        background: rgba(75, 192, 192, 0.2);
        color: rgba(75, 192, 192, 1);
    }
    
    .progress-card-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .progress-card-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .btn-view-chart {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        color: var(--btn-primary-bg);
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        animation: fadeIn 0.3s ease;
    }
    
    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        background: var(--bg-secondary);
        border-radius: 16px;
        padding: 2rem;
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideIn 0.3s ease;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }
    
    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .modal-close {
        background: transparent;
        border: none;
        font-size: 2rem;
        color: var(--text-secondary);
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .modal-close:hover {
        background: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .modal-chart-container {
        height: 400px;
        position: relative;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="course-container">
    <!-- Panel informativo del curso -->
    <div class="info-panel">
        <h1 class="course-title">{{ $course->title }}</h1>
        
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Número de Administración</span>
                <span class="info-value">101</span>
            </div>
            <div class="info-item">
                <span class="info-label">Número de DUAS</span>
                <span class="info-value">202</span>
            </div>
            <div class="info-item">
                <span class="info-label">Psicólogo vocacional</span>
                <span class="info-value">Mtra. Ana Pérez</span>
            </div>
        </div>
        
        <div class="instructions-box">
            <div class="instructions-title">Instrucciones</div>
            <p class="instructions-text">
                Este curso está diseñado para guiarte paso a paso. Revisa las clases, realiza los exámenes 
                y consulta los recursos cada semana para obtener el máximo provecho de tu aprendizaje.
            </p>
        </div>
    </div>

    <!-- Carrusel de semanas -->
    <div class="carousel-section">
        <h2 class="section-title">Contenido del Curso</h2>
        
        <div class="carousel-container">
            <button id="prev-week" class="carousel-btn" aria-label="Semana anterior" disabled>
                <i class="bi bi-chevron-left"></i>
            </button>
            
            <div class="carousel-wrapper">
                <div class="carousel-track" id="carousel-track">
                    @foreach ($combined as $item)
                        @php
                            $isEvaluation = $item['type'] === 'evaluation';
                            $week = $item['data'];
                        @endphp

                        <div class="week-card {{ $isEvaluation ? 'evaluation' : '' }}">
                            <div class="week-header">
                                <h3 class="week-title">
                                    {{ $isEvaluation ? 'Bloque de Evaluación' : 'Semana ' . $week->number }}
                                </h3>
                            </div>
                            
                            <div class="week-content">
                                @if ($week->live_meet_link)
                                    <div class="content-item">
                                        <span class="content-label">Clase en Vivo</span>
                                        <a href="{{ $week->live_meet_link }}" target="_blank" class="btn-action btn-primary">
                                            <i class="bi bi-camera-video"></i>
                                            Unirse a Clase
                                        </a>
                                    </div>
                                @endif

                                @if ($week->recording_link)
                                    <div class="content-item">
                                        <span class="content-label">Clase Grabada</span>
                                        <a href="{{ route('student.recorded', $week->recording_link) }}" class="btn-action btn-secondary">
                                            <i class="bi bi-play-circle"></i>
                                            Ver Grabación
                                        </a>
                                    </div>
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

                                    <div class="content-item">
                                        <span class="content-label">Examen</span>
                                        @if ($result)
                                            <a href="{{ route('student.exams.result', ['course' => $course->id, 'exam' => $exam->id]) }}" class="btn-action btn-success">
                                                <i class="bi bi-check-circle"></i>
                                                Ver Resultados
                                            </a>
                                        @else
                                            <a href="{{ route('student.exams.start', ['course' => $course->id, 'exam' => $exam->id]) }}" class="btn-action btn-primary">
                                                <i class="bi bi-pencil-square"></i>
                                                Realizar Examen
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="no-exam">
                                        No hay examen asignado
                                    </div>
                                @endif

                                @if ($week->resource_id)
                                    <div class="content-item">
                                        <span class="content-label">Recursos</span>
                                        <a href="{{ route('student.resources.view', ['type' => $isEvaluation ? 'evaluation' : 'week', 'id' => $week->id]) }}" class="btn-action btn-secondary">
                                            <i class="bi bi-folder"></i>
                                            Ver Recursos
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <button id="next-week" class="carousel-btn" aria-label="Siguiente semana">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Progresos -->
    <div class="progress-section">
        <h2 class="section-title">Mi Progreso</h2>
        
        <!-- Filtros para las gráficas -->
        <div class="filter-section">
            <span class="filter-label">Filtrar por:</span>
            <select id="chart-filter" class="filter-select">
                <option value="all">Todos los exámenes</option>
                <option value="week">Semanas normales</option>
                <option value="evaluation">Bloques de evaluación</option>
            </select>
        </div>
        
        <!-- Tarjetas de progreso -->
        <div class="progress-cards">
            <div class="progress-card" onclick="openModal('scoreModal')">
                <div class="progress-card-header">
                    <div class="progress-card-title">Puntaje Promedio</div>
                    <div class="progress-card-icon icon-score">
                        <i class="bi bi-graph-up"></i>
                    </div>
                </div>
                <div class="progress-card-value" id="avg-score">--</div>
                <div class="progress-card-label">Porcentaje</div>
                <div class="btn-view-chart">
                    <i class="bi bi-eye"></i>
                    Ver gráfica
                </div>
            </div>
            
            <div class="progress-card" onclick="openModal('timeModal')">
                <div class="progress-card-header">
                    <div class="progress-card-title">Tiempo Promedio</div>
                    <div class="progress-card-icon icon-time">
                        <i class="bi bi-clock"></i>
                    </div>
                </div>
                <div class="progress-card-value" id="avg-time">--</div>
                <div class="progress-card-label">Segundos</div>
                <div class="btn-view-chart">
                    <i class="bi bi-eye"></i>
                    Ver gráfica
                </div>
            </div>
            
            <div class="progress-card" onclick="openModal('correctModal')">
                <div class="progress-card-header">
                    <div class="progress-card-title">Respuestas Correctas</div>
                    <div class="progress-card-icon icon-correct">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="progress-card-value" id="avg-correct">-- /10</div>
                <div class="progress-card-label">Promedio</div>
                <div class="btn-view-chart">
                    <i class="bi bi-eye"></i>
                    Ver gráfica
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
<div id="scoreModal" class="modal" onclick="closeModalOnBackdrop(event, 'scoreModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Gráfica de Puntajes</h3>
            <button class="modal-close" onclick="closeModal('scoreModal')">&times;</button>
        </div>
        <div class="filter-section">
            <span class="filter-label">Filtrar por:</span>
            <select id="chart-filter-score" class="filter-select">
                <option value="all">Todos los exámenes</option>
                <option value="week">Semanas normales</option>
                <option value="evaluation">Bloques de evaluación</option>
            </select>
        </div>
        <div class="modal-chart-container">
            <canvas id="scoreChartModal"></canvas>
        </div>
    </div>
</div>

<div id="timeModal" class="modal" onclick="closeModalOnBackdrop(event, 'timeModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Gráfica de Tiempos</h3>
            <button class="modal-close" onclick="closeModal('timeModal')">&times;</button>
        </div>
        <div class="filter-section">
            <span class="filter-label">Filtrar por:</span>
            <select id="chart-filter-time" class="filter-select">
                <option value="all">Todos los exámenes</option>
                <option value="week">Semanas normales</option>
                <option value="evaluation">Bloques de evaluación</option>
            </select>
        </div>
        <div class="modal-chart-container">
            <canvas id="timeChartModal"></canvas>
        </div>
    </div>
</div>

<div id="correctModal" class="modal" onclick="closeModalOnBackdrop(event, 'correctModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 class="modal-title">Gráfica de Respuestas Correctas</h3>
            <button class="modal-close" onclick="closeModal('correctModal')">&times;</button>
        </div>
        <div class="filter-section">
            <span class="filter-label">Filtrar por:</span>
            <select id="chart-filter-correct" class="filter-select">
                <option value="all">Todos los exámenes</option>
                <option value="week">Semanas normales</option>
                <option value="evaluation">Bloques de evaluación</option>
            </select>
        </div>
        <div class="modal-chart-container">
            <canvas id="correctChartModal"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Datos originales de las gráficas
    const originalLabels = @json($labels);
    const originalScores = @json($scores);
    const originalAverageTimes = @json($averageTimes);
    const originalCorrectAnswers = @json($correctAnswers);
    const examTypes = @json($examTypes ?? []);
    
    // DEBUG: Verifica los datos
    console.log('Labels:', originalLabels);
    console.log('Exam Types:', examTypes);
    console.log('Scores:', originalScores);
    
    // Configuración del carrusel
    const track = document.getElementById('carousel-track');
    const prevBtn = document.getElementById('prev-week');
    const nextBtn = document.getElementById('next-week');
    const cards = track.querySelectorAll('.week-card');
    
    if (track && cards.length > 0) {
        const cardWidth = cards[0].offsetWidth + parseInt(getComputedStyle(track).gap);
        const visibleCards = Math.floor(track.parentElement.offsetWidth / cardWidth);
        let currentPosition = 0;
        const maxPosition = track.scrollWidth - track.parentElement.offsetWidth;
        
        function updateButtons() {
            prevBtn.disabled = currentPosition <= 0;
            nextBtn.disabled = currentPosition >= maxPosition;
        }
        
        function scrollCarousel(direction) {
            const scrollAmount = cardWidth * visibleCards;
            currentPosition += direction * scrollAmount;
            currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));
            
            track.style.transform = `translateX(-${currentPosition}px)`;
            updateButtons();
        }
        
        prevBtn.addEventListener('click', () => scrollCarousel(-1));
        nextBtn.addEventListener('click', () => scrollCarousel(1));
        
        // Inicializar estado de botones
        updateButtons();
        
        // Actualizar en resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                currentPosition = 0;
                track.style.transform = 'translateX(0)';
                updateButtons();
            }, 250);
        });
    }
    
    // Configuración de gráficas
    let scoreChartModal, timeChartModal, correctChartModal;
    let currentGlobalFilter = 'all'; // Almacenar el filtro global actual
    
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: 'var(--text-secondary)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: 'var(--text-secondary)'
                }
            }
        }
    };
    
    function filterData(filterType) {
        let filteredLabels = [];
        let filteredScores = [];
        let filteredTimes = [];
        let filteredCorrect = [];
        
        for (let i = 0; i < originalLabels.length; i++) {
            const type = examTypes[i];
            let include = false;
            
            switch(filterType) {
                case 'all':
                    include = true;
                    break;
                case 'week':
                    include = type === 'week';
                    break;
                case 'evaluation':
                    include = type === 'evaluation';
                    break;
            }
            
            if (include) {
                filteredLabels.push(originalLabels[i]);
                filteredScores.push(originalScores[i]);
                filteredTimes.push(originalAverageTimes[i]);
                filteredCorrect.push(originalCorrectAnswers[i]);
            }
        }
        
        return { filteredLabels, filteredScores, filteredTimes, filteredCorrect };
    }
    
    function calculateAverage(arr) {
        if (arr.length === 0) return 0;
        const sum = arr.reduce((a, b) => a + b, 0);
        return (sum / arr.length).toFixed(1);
    }
    
    function updateStats(filterType) {
        const { filteredScores, filteredTimes, filteredCorrect } = filterData(filterType);
        
        document.getElementById('avg-score').textContent = filteredScores.length > 0 ? calculateAverage(filteredScores) + '%' : '--';
        document.getElementById('avg-time').textContent = filteredTimes.length > 0 ? calculateAverage(filteredTimes) + 's' : '--';
        document.getElementById('avg-correct').textContent = filteredCorrect.length > 0 ? calculateAverage(filteredCorrect) + ' / 10' : '-- / 10';
    }
    
    function updateChart(chart, filterType) {
        const { filteredLabels, filteredScores, filteredTimes, filteredCorrect } = filterData(filterType);
        
        if (chart === scoreChartModal) {
            chart.data.labels = filteredLabels;
            chart.data.datasets[0].data = filteredScores;
        } else if (chart === timeChartModal) {
            chart.data.labels = filteredLabels;
            chart.data.datasets[0].data = filteredTimes;
        } else if (chart === correctChartModal) {
            chart.data.labels = filteredLabels;
            chart.data.datasets[0].data = filteredCorrect;
        }
        
        chart.update();
    }
    
    function syncFilters(filterValue) {
        // Actualizar todos los selectores de filtro
        document.getElementById('chart-filter').value = filterValue;
        document.getElementById('chart-filter-score').value = filterValue;
        document.getElementById('chart-filter-time').value = filterValue;
        document.getElementById('chart-filter-correct').value = filterValue;
        
        // Actualizar todas las gráficas
        updateChart(scoreChartModal, filterValue);
        updateChart(timeChartModal, filterValue);
        updateChart(correctChartModal, filterValue);
        
        // Actualizar estadísticas
        updateStats(filterValue);
        
        // Guardar el filtro actual
        currentGlobalFilter = filterValue;
    }
    
    // Inicializar gráficas
    function initializeCharts() {
        const initialData = filterData('all');
        const isMobile = window.innerWidth <= 768;
        
        // Configuración base de gráficas con detección de móvil
        const getChartOptions = (maxY = null) => {
            const options = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'var(--text-secondary)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'var(--text-secondary)',
                            display: !isMobile // Ocultar etiquetas en móvil
                        }
                    }
                }
            };
            
            if (maxY) {
                options.scales.y.max = maxY;
            }
            
            return options;
        };
        
        // Gráfica de Puntaje en Modal
        scoreChartModal = new Chart(document.getElementById('scoreChartModal'), {
            type: 'line',
            data: {
                labels: initialData.filteredLabels,
                datasets: [{
                    label: 'Puntaje (%)',
                    data: initialData.filteredScores,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: getChartOptions(100)
        });
        
        // Gráfica de Tiempo en Modal
        timeChartModal = new Chart(document.getElementById('timeChartModal'), {
            type: 'line',
            data: {
                labels: initialData.filteredLabels,
                datasets: [{
                    label: 'Tiempo promedio (s)',
                    data: initialData.filteredTimes,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(255, 206, 86, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: getChartOptions()
        });
        
        // Gráfica de Respuestas correctas en Modal
        correctChartModal = new Chart(document.getElementById('correctChartModal'), {
            type: 'line',
            data: {
                labels: initialData.filteredLabels,
                datasets: [{
                    label: 'Respuestas correctas',
                    data: initialData.filteredCorrect,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: getChartOptions()
        });
        
        // Inicializar estadísticas
        updateStats('all');
    }
    
    // Inicializar gráficas
    initializeCharts();
    
    // Reinicializar gráficas cuando cambie el tamaño de ventana
    let resizeChartTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeChartTimeout);
        resizeChartTimeout = setTimeout(() => {
            // Destruir gráficas existentes
            if (scoreChartModal) scoreChartModal.destroy();
            if (timeChartModal) timeChartModal.destroy();
            if (correctChartModal) correctChartModal.destroy();
            
            // Reinicializar con nueva configuración
            initializeCharts();
            
            // Aplicar el filtro actual
            syncFilters(currentGlobalFilter);
        }, 500);
    });
    
    // Event listener para el filtro GLOBAL (fuera de los modales)
    document.getElementById('chart-filter').addEventListener('change', function(e) {
        syncFilters(e.target.value);
    });
    
    // Event listeners para los filtros INDIVIDUALES (dentro de los modales)
    document.getElementById('chart-filter-score').addEventListener('change', function(e) {
        syncFilters(e.target.value);
    });
    
    document.getElementById('chart-filter-time').addEventListener('change', function(e) {
        syncFilters(e.target.value);
    });
    
    document.getElementById('chart-filter-correct').addEventListener('change', function(e) {
        syncFilters(e.target.value);
    });
});

// Funciones para los modales
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    document.body.style.overflow = 'auto';
}

function closeModalOnBackdrop(event, modalId) {
    if (event.target.classList.contains('modal')) {
        closeModal(modalId);
    }
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = 'auto';
    }
});
</script>
@endsection