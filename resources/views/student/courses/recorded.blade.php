@extends('layouts.app')

@section('title', 'Clases grabadas - ' . $day->week->title)

@section('content')
<style>
    .recorded-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0 1rem;
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .back-button {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: var(--text-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .back-button:hover {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        transform: translateY(-2px);
    }
    
    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }
    
    .week-info {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }
    
    .content-layout {
        display: flex;
        gap: 2rem;
    }
    
    .days-sidebar {
        width: 280px;
        flex-shrink: 0;
    }
    
    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .days-list {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .day-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }
    
    .day-item:last-child {
        border-bottom: none;
    }
    
    .day-item:hover {
        background: var(--bg-primary);
    }
    
    .day-item.active {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .day-number {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .day-title {
        font-size: 0.9rem;
        color: inherit;
        opacity: 0.8;
    }
    
    .player-section {
        flex: 1;
        min-width: 0;
    }
    
    .player-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .player-container {
        position: relative;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        background: var(--bg-secondary);
    }
    
    .video-iframe {
        width: 100%;
        height: 400px;
        border: none;
        display: block;
    }
    
    .watermark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        pointer-events: none;
        opacity: 0.08;
        font-size: 18px;
        color: var(--text-primary);
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        transform: rotate(-30deg);
        gap: 30px;
        font-weight: 700;
    }
    
    .watermark-text {
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }
    
    .no-video {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--text-secondary);
    }
    
    .no-video-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    /* Estilos para móvil */
    @media (max-width: 768px) {
        .recorded-container {
            margin: 1rem auto;
            padding: 0 0.75rem;
        }
        
        .content-layout {
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .days-sidebar {
            width: 100%;
        }
        
        .video-iframe {
            height: 300px;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .week-info {
            font-size: 1.1rem;
        }
        
        .watermark {
            font-size: 14px;
            gap: 20px;
        }
        
        .back-button {
            padding: 0.625rem 1.25rem;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .recorded-container {
            padding: 0 0.5rem;
        }
        
        .video-iframe {
            height: 250px;
        }
        
        .day-item {
            padding: 0.875rem 1rem;
        }
        
        .watermark {
            font-size: 12px;
            gap: 15px;
            transform: rotate(-25deg);
        }
        
        .page-title {
            font-size: 1.3rem;
        }
        
        .week-info {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 360px) {
        .video-iframe {
            height: 200px;
        }
        
        .watermark {
            font-size: 10px;
            gap: 10px;
        }
    }
</style>

<div class="recorded-container">
    <!-- Botón de volver -->
    <a href="{{ route('courses.show', $day->week->course_id ?? $day->week->course->id) }}" class="back-button">
        <i class="bi bi-arrow-left"></i>
        Volver al curso
    </a>
    
    <h1 class="page-title">Clases Grabadas</h1>
    <div class="week-info">Semana {{ $day->week->number }}</div>
    
    <div class="content-layout">
        <!-- Lista lateral de días -->
        <div class="days-sidebar">
            <h3 class="sidebar-title">Días disponibles</h3>
            <div class="days-list">
                @foreach ($day->week->weekDays as $d)
                    <div class="day-item {{ $d->id == $day->id ? 'active' : '' }}" 
                         data-url="{{ $d->recording_link }}"
                         data-day="{{ $d->id }}">
                        <div class="day-number">Día {{ $d->day_number }}</div>
                        <div class="day-title">{{ $d->title }}</div>
                    </div>
                @endforeach
                
                @if($day->week->weekDays->isEmpty())
                    <div class="no-video">
                        <div class="no-video-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>
                        <p>No hay días disponibles</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Área del reproductor -->
        <div class="player-section">
            <h3 class="player-title">Reproductor</h3>
            <div class="player-container">
                @if($day->recording_link)
                    <iframe id="video-iframe" 
                            class="video-iframe" 
                            src="{{ $day->recording_link }}" 
                            frameborder="0" 
                            allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                    
                    <!-- Marca de agua permanente -->
                    <div class="watermark" id="watermark">
                        @for ($i = 0; $i < 20; $i++)
                            <div class="watermark-text">INSTITUTO RESILIENCIA</div>
                        @endfor
                    </div>
                @else
                    <div class="no-video">
                        <div class="no-video-icon">
                            <i class="bi bi-camera-video-off"></i>
                        </div>
                        <p>No hay video disponible para este día</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dayItems = document.querySelectorAll('.day-item');
    const videoIframe = document.getElementById('video-iframe');
    const watermark = document.getElementById('watermark');

    // Función para convertir URL de Google Drive a embed
    function getDriveEmbedUrl(url) {
        if (!url) return '';
        
        if (!url.includes('drive.google.com')) return url;

        const match = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (match) {
            return `https://drive.google.com/file/d/${match[1]}/preview`;
        }
        
        // Si es un enlace de vista previa directa, dejarlo como está
        if (url.includes('/preview')) {
            return url;
        }
        
        return url;
    }

    // Cargar el video inicial
    function loadInitialVideo() {
        const activeDay = document.querySelector('.day-item.active');
        if (activeDay && videoIframe) {
            const url = activeDay.getAttribute('data-url');
            if (url) {
                videoIframe.src = getDriveEmbedUrl(url);
            }
        }
    }

    // Manejar clic en los días
    dayItems.forEach(item => {
        item.addEventListener('click', () => {
            const url = item.getAttribute('data-url');
            const dayId = item.getAttribute('data-day');
            
            if (url && videoIframe) {
                // Actualizar iframe
                videoIframe.src = getDriveEmbedUrl(url);
                
                // Actualizar clases activas
                dayItems.forEach(day => day.classList.remove('active'));
                item.classList.add('active');
                
                // Actualizar URL en el navegador sin recargar
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('day', dayId);
                window.history.replaceState({}, '', newUrl);
            }
        });
    });

    // Ajustar marca de agua dinámicamente
    function adjustWatermark() {
        if (!watermark) return;
        
        const container = watermark.parentElement;
        if (container) {
            const containerWidth = container.offsetWidth;
            const fontSize = Math.max(12, containerWidth / 25); // Tamaño responsive
            watermark.style.fontSize = `${fontSize}px`;
        }
    }

    // Cargar video inicial
    loadInitialVideo();
    
    // Ajustar marca de agua al cargar y al redimensionar
    adjustWatermark();
    window.addEventListener('resize', adjustWatermark);

    // Efectos hover mejorados
    dayItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.3s ease';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Manejar parámetros de URL al cargar la página
    function handleUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const dayParam = urlParams.get('day');
        
        if (dayParam) {
            const targetDay = document.querySelector(`.day-item[data-day="${dayParam}"]`);
            if (targetDay) {
                targetDay.click();
            }
        }
    }

    // Ejecutar manejo de parámetros URL
    handleUrlParams();
});
</script>
@endsection