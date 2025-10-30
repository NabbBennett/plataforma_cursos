@extends('layouts.app')

@section('title', 'Clases grabadas - ' . $day->week->title)

@section('content')
<div class="container" style="max-width: 1100px; margin: 2rem auto;">
    
    <div class="mb-3">
        <a href="{{ route('student.courses.show', $day->week->course_id ?? $day->week->course->id) }}" class="btn btn-secondary">⬅️ Volver al curso</a>
    </div>

    <h3>Semana {{ $day->week->number }}</h3>
    <div style="display: flex; gap: 1rem;">

        {{-- Lista lateral de días --}}
        <div style="width: 250px;">
            <h4>Días disponibles</h4>
            <ul class="list-group">
                @foreach ($day->week->weekDays as $d)
                    <li class="list-group-item day-item" data-url="{{ $d->recording_link }}">
                        Día {{ $d->day_number }} – {{ $d->title }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Área del reproductor --}}
        <div style="flex: 1;">
            <h4>Reproductor</h4>
            <div style="position: relative; border: 1px solid #ccc; border-radius: 8px; padding: 0.5rem; overflow: hidden;">
                <iframe id="video-iframe" src="{{ $day->recording_link }}" width="100%" height="400" frameborder="0" allowfullscreen></iframe>

                {{-- Marca de agua permanente con texto --}}
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
                    @for ($i = 0; $i < 30; $i++)
                        <div>INSTITUTO RESILIENCIA</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    const items = document.querySelectorAll('.day-item');
    const iframe = document.getElementById('video-iframe');

    function getDriveEmbedUrl(url) {
        if (!url.includes('drive.google.com')) return url;

        const match = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (match) {
            return `https://drive.google.com/file/d/${match[1]}/preview`;
        }
        return url;
    }

    items.forEach(item => {
        item.addEventListener('click', () => {
            const url = item.getAttribute('data-url');
            iframe.src = getDriveEmbedUrl(url);
        });
    });

    // Cargar el primer video automáticamente
    if (items.length > 0) {
        const firstUrl = items[0].getAttribute('data-url');
        iframe.src = getDriveEmbedUrl(firstUrl);
    }
</script>
@endsection

