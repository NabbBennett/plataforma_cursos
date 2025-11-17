@extends('layouts.app')

@section('title', 'Recurso - ' . $resource->title)

@section('content')
<style>
    .resource-container {
        background-color: var(--bg-primary);
        min-height: 100vh;
        padding: 2rem 0;
        transition: all 0.3s;
    }

    .resource-header {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .resource-title {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    .resource-description {
        color: var(--text-secondary);
        font-size: 1.1rem;
        text-align: center;
        line-height: 1.6;
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

    .file-info {
        background-color: var(--bg-primary);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
        border: 1px solid var(--border-color);
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
        .resource-container {
            padding: 1rem 0;
        }

        .resource-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .viewer-container {
            padding: 1rem;
        }

        .resource-title {
            font-size: 1.5rem;
        }

        .resource-description {
            font-size: 1rem;
        }

        .pdf-frame, .video-player, .generic-frame {
            height: 400px;
        }

        .watermark {
            font-size: 18px;
            gap: 20px;
        }

        .preview-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .resource-header {
            padding: 1rem;
        }

        .viewer-container {
            padding: 0.75rem;
        }

        .resource-title {
            font-size: 1.25rem;
        }

        .pdf-frame, .video-player, .generic-frame {
            height: 300px;
        }

        .watermark {
            font-size: 14px;
            gap: 15px;
        }

        .download-btn, .back-btn {
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

<div class="resource-container">
    <div class="container" style="max-width: 1200px;">
        <!-- Botón de volver - Corregido -->
        <a href="{{ url()->previous() }}" class="back-btn slide-in">
            <i class="bi bi-arrow-left"></i>
            Volver Atrás
        </a>

        <!-- Header del recurso -->
        <div class="resource-header fade-in">
            <h1 class="resource-title">{{ $resource->title }}</h1>
            @if($resource->description)
                <p class="resource-description">{{ $resource->description }}</p>
            @endif
        </div>

        <!-- Visor del recurso -->
        <div class="viewer-container fade-in">
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