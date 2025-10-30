@extends('layouts.app')

@section('title', 'Recurso - ' . $resource->title)

@section('content')
<div class="container" style="max-width: 1100px; margin: 2rem auto;">
    
    <div class="mb-3">
        <a href="{{ route('student.courses.show', $courseId) }}" class="btn btn-secondary">⬅️ Volver al curso</a>
    </div>

    <h3 class="mb-3 text-center">{{ $resource->title }}</h3>

    @if($resource->description)
        <p class="text-center text-muted">{{ $resource->description }}</p>
    @endif

    {{-- Área del visor --}}
        <div style="position: relative; border: 1px solid #ccc; border-radius: 8px; padding: 0.5rem; overflow: hidden;">
        @php
            $filePath = $resource->url;
            $extension = strtolower(pathinfo($resource->file_path, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
            <img src="{{ $filePath }}" alt="Imagen" style="max-width: 100%; border-radius: 8px;">
        
        @elseif ($extension === 'pdf')
            {{-- Solo vista previa del PDF --}}
            <iframe src="{{ $filePath }}#toolbar=0&navpanes=0&scrollbar=1" width="100%" height="600" frameborder="0"></iframe>

        @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
            <video width="100%" height="500" controls>
                <source src="{{ $filePath }}" type="video/{{ $extension }}">
                Tu navegador no soporta la reproducción de este video.
            </video>

        @else
            {{-- Otros archivos: vista previa + descarga --}}
            <iframe src="{{ $filePath }}" width="100%" height="500" frameborder="0"></iframe>
            <a href="{{ $filePath }}" download class="btn btn-primary mt-2">Descargar archivo</a>
        @endif

            {{-- Marca de agua --}}
            <div id="watermark" style="
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10;
                pointer-events: none;
                opacity: 0.1;
                font-size: 16px;
                color: gray;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                transform: rotate(-30deg);
                gap: 20px;
            ">
                @for ($i = 0; $i < 50; $i++)
                    <div>INSTITUTO RESILIENCIA</div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection


