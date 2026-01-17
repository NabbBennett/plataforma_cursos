@extends('layouts.app')

@section('title', 'Recurso - ' . $resource->title)

@section('content')
<style>
    /* Basado en la vista recorded.blade.php para un look consistente */
    .resources-recorded-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0 1rem 2rem;
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }

    .resources-back-button {
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

    .resources-back-button:hover {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        transform: translateY(-2px);
    }

    .resources-page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }

    .resources-week-info {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        color: var(--text-secondary);
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .resources-content-layout {
        display: flex;
        gap: 2rem;
    }

    .resources-sidebar {
        width: 280px;
        flex-shrink: 0;
    }

    .resources-sidebar-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .resources-sidebar-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem;
    }

    .day-item {
        margin-bottom: 0.5rem;
    }

    .day-item a {
        display: block;
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid transparent;
        background: var(--bg-primary);
        text-decoration: none;
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .day-item a:hover {
        border-color: var(--btn-primary-bg);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transform: translateY(-1px);
    }

    .day-item.active a {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-color: var(--btn-primary-bg);
    }

    .day-number {
        font-weight: 600;
    }

    .resource-title {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .resource-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .file-info {
        background-color: var(--bg-primary);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-top: 0.5rem;
        border: 1px solid var(--border-color);
        font-size: 0.9rem;
    }

    .file-type-badge {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .resources-player-section {
        flex: 1;
        min-width: 0;
    }

    .resources-player-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .viewer-container {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .file-preview {
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        background: var(--bg-primary);
    }

    .image-preview {
        max-width: 100%;
        border-radius: 8px;
        display: block;
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .pdf-frame, .video-player, .generic-frame {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .download-btn {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .download-btn:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .back-btn {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .back-btn:hover {
        background-color: var(--bg-primary);
        transform: translateY(-2px);
    }

    .watermark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        pointer-events: none;
        opacity: 0.03;
        font-size: 24px;
        color: var(--text-primary);
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        transform: rotate(-30deg);
        gap: 40px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }

    .preview-title {
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 768px) {
        .resources-recorded-container {
            margin: 1rem auto;
            padding: 0 0.75rem 1.5rem;
        }

        .resources-content-layout {
            flex-direction: column;
            gap: 1.5rem;
        }

        .resources-sidebar {
            width: 100%;
        }

        .viewer-container {
            padding: 1rem;
        }

        .resources-page-title {
            font-size: 1.5rem;
        }

        .resources-week-info {
            font-size: 1rem;
        }

        .pdf-frame, .video-player, .generic-frame {
            height: 400px;
        }

        .watermark {
            font-size: 18px;
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .viewer-container {
            padding: 0.75rem;
        }

        .resources-page-title {
            font-size: 1.3rem;
        }

        .pdf-frame, .video-player, .generic-frame {
            height: 300px;
        }

        .watermark {
            font-size: 14px;
            gap: 15px;
        }

        .download-btn, .resources-back-button {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animaciones */
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-in {
        animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<div class="resources-recorded-container">
    <!-- Botón de volver -->
    <a href="{{ route('courses.show', $courseId) }}" class="resources-back-button slide-in">
        <i class="bi bi-arrow-left"></i>
        Volver al curso
    </a>

    <h1 class="resources-page-title">Recursos</h1>
    <div class="resources-week-info">Recurso asignado al curso</div>

    <div class="resources-content-layout">
        <!-- Lado izquierdo: lista/detalle de recursos -->
        <div class="resources-sidebar fade-in">
            @if(isset($daysWithResources) && $daysWithResources->count() > 0)
                <h3 class="resources-sidebar-title">Recursos disponibles</h3>
                <div class="resources-sidebar-card">
                    @foreach ($daysWithResources as $d)
                        <div class="day-item {{ isset($currentDay) && $currentDay->id === $d->id ? 'active' : '' }}">
                            <a href="{{ route('student.resources.view', ['type' => 'week', 'id' => $weekId]) }}?day={{ $d->id }}">
                                <div class="day-number">Día {{ $d->day_number }}</div>
                                @if($d->title)
                                    <div class="day-title" style="font-size:0.85rem; opacity:0.8; margin-top:2px;">{{ $d->title }}</div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <h3 class="resources-sidebar-title">Detalle del recurso</h3>
                <div class="resources-sidebar-card">
                    <h2 class="resource-title">{{ $resource->title }}</h2>
                    @if($resource->description)
                        <p class="resource-description">{{ $resource->description }}</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Lado derecho: visor del recurso -->
        <div class="resources-player-section fade-in">
            <h3 class="resources-player-title">Visor de recurso</h3>
            <div class="viewer-container">
                <div class="file-preview">
                @php
                    $filePath = Storage::disk('public')->url($resource->file_path);
                    $extension = strtolower(pathinfo($resource->file_path, PATHINFO_EXTENSION));
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
                    <img src="{{ $filePath }}" alt="{{ $resource->title }}" class="image-preview">
                
                @elseif ($extension === 'pdf')
                    <iframe 
                        src="{{ $filePath }}#toolbar=0&navpanes=0&scrollbar=1" 
                        width="100%" 
                        height="600" 
                        frameborder="0"
                        class="pdf-frame"
                        title="PDF - {{ $resource->title }}">
                    </iframe>

                @elseif (in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi']))
                    <video width="100%" height="500" controls class="video-player">
                        <source src="{{ $filePath }}" type="video/{{ $extension }}">
                        Tu navegador no soporta la reproducción de este video.
                    </video>

                @elseif (in_array($extension, ['mp3', 'wav', 'ogg', 'aac']))
                    <div class="audio-player" style="background: var(--bg-primary); padding: 2rem; border-radius: 10px; text-align: center;">
                        <h5 style="color: var(--text-primary); margin-bottom: 1rem;">Reproductor de Audio</h5>
                        <audio controls style="width: 100%; max-width: 500px;">
                            <source src="{{ $filePath }}" type="audio/{{ $extension }}">
                            Tu navegador no soporta la reproducción de audio.
                        </audio>
                    </div>

                @else
                    <div class="text-center" style="padding: 3rem; background: var(--bg-primary); border-radius: 10px;">
                        <i class="bi bi-file-earmark" style="font-size: 4rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <h5 style="color: var(--text-primary); margin-bottom: 1rem;">Vista previa no disponible</h5>
                        <p style="color: var(--text-secondary);">Este tipo de archivo no puede mostrarse en el visor.</p>
                    </div>
                @endif

                <!-- Marca de agua -->
                <div class="watermark">
                    @for ($i = 0; $i < 25; $i++)
                        <div>INSTITUTO RESILIENCIA</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Efecto de carga progresiva
    const elements = document.querySelectorAll('.fade-in, .slide-in');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        setTimeout(() => {
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            element.style.opacity = '1';
        }, index * 200);
    });

    // Optimización para móviles
    if (window.innerWidth < 768) {
        const iframes = document.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            iframe.style.height = '300px';
        });
        
        const videos = document.querySelectorAll('video');
        videos.forEach(video => {
            video.style.height = '300px';
        });
    }

    // Prevenir clics en la marca de agua
    const watermark = document.querySelector('.watermark');
    if (watermark) {
        watermark.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    }
});
</script>
@endsection