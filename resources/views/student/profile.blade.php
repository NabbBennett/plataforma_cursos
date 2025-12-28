@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="profile-container">
    <!-- Encabezado del perfil -->
    <div class="profile-header">
        <!-- Banner superior: muestra el banner elegido en configuración (storage o URL) -->
        <div class="profile-banner"
             style="background-image: url('{{ $user->banner_url }}')">
        </div>

        <!-- Avatar solapado: usa storage o fallback a avatar_url -->
        <div class="profile-avatar-wrapper">
            <img src="{{ $user->avatar_url }}"
                 alt="Foto de perfil" class="profile-avatar">
        </div>

        <!-- Botón editar (posicionado en la esquina superior derecha en desktop) -->
        <a href="{{ route('student.configuration') }}" class="btn-edit-profile">
            <i class="bi bi-pencil-square"></i>
            Editar perfil
        </a>

        <!-- Info (nombre, email u otros) -->
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
        </div>
    </div>
    
    <!-- Cursos comprados -->
    <div class="purchased-courses">
        <h2 class="section-title">Cursos Adquiridos</h2>
        
        @if($compras->isEmpty())
            <div class="empty-state">
                <p>No has comprado ningún curso todavía.</p>
                <a href="{{ route('store') }}" class="btn btn-primary">Explorar Cursos</a>
            </div>
        @else
            <div class="courses-horizontal">
                @foreach($compras as $compra)
                    @php $curso = $compra->course; @endphp
                    @if($curso)
                    <div class="course-horizontal-card">
                        <div class="course-horizontal-image">
                            <img src="{{ $curso->image ? asset('storage/' . $curso->image) : 'https://via.placeholder.com/200x120/4A5568/FFFFFF?text=CURSO' }}" 
                                 alt="{{ $curso->title }}">
                        </div>
                        <div class="course-horizontal-content">
                            <div class="course-horizontal-info">
                                <h3 class="course-horizontal-title">{{ $curso->title }}</h3>
                            </div>
                            <div class="course-horizontal-actions">
                                <a href="{{ route('courses.show', $curso->id) }}" class="btn-access-course">
                                    <i class="bi bi-play-circle me-2"></i>
                                    Acceder al Curso
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Cursos recomendados -->
    @if($cursosRecomendados->isNotEmpty())
    <div class="recommended-courses">
        <h2 class="section-title">Cursos Recomendados</h2>
        <div class="carousel-container">            
            <div class="carousel-track" id="carouselTrack">
                @foreach($cursosRecomendados as $curso)
                <div class="carousel-slide">
                    <div class="course-card">
                        <img src="{{ $curso->image ? asset('storage/' . $curso->image) : 'https://via.placeholder.com/300x160/4A5568/FFFFFF?text=RECOMENDADO' }}" 
                             alt="{{ $curso->title }}" class="course-image">
                        <div class="course-content">
                            <h3 class="course-title">{{ $curso->title }}</h3>
                            <div class="course-actions">
                                <a href="{{ route('store.course', $curso->id) }}" class="btn btn-outline-primary">Saber Más</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="carousel-controls">
            <button class="carousel-btn prev" aria-label="Anterior"><i class="bi bi-chevron-left"></i></button>
            <button class="carousel-btn next" aria-label="Siguiente"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
    @else
    <div class="recommended-courses">
        <h2 class="section-title">Cursos Recomendados</h2>
        <div class="empty-state">
            <p>¡Has comprado todos nuestros cursos disponibles! Pronto agregaremos más contenido.</p>
            <a href="{{ route('store') }}" class="btn btn-outline-primary">Ver Tienda</a>
        </div>
    </div>
    @endif
</div>

<style>
.profile-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

/* HEADER: banner + avatar solapado (desktop / tablet) */
.profile-header {
    position: relative;
    border-radius: 12px;
    overflow: visible;
    margin-bottom: 2rem;
}

/* banner superior */
.profile-banner {
    height: 200px;
    border-radius: 12px 12px 0 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    box-shadow: inset 0 -20px 40px rgba(0,0,0,0.08);
}

/* avatar wrapper solapado y centrado */
.profile-avatar-wrapper {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 130px; /* solapa la banner */
    width: 140px;
    height: 140px;
    border-radius: 50%;
    padding: 6px;
    background: var(--bg-secondary, #fff);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    border: 0.5px solid rgba(255,255,255,0.9);
}

.profile-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    display: block;
}

.btn-edit-profile {
    position: absolute;
    right: 18px;
    top: 18px;
    z-index: 7;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .45rem .9rem;
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 2px solid var(--border-color);
    border-radius: 999px;
    text-decoration: none;
    transition: background .15s ease, color .15s ease, border-color .15s ease, transform .12s ease;
}

.btn-edit-profile:hover,
.btn-edit-profile:focus {
    background: var(--text-primary);
    color: var(--bg-primary);
    border-color: currentColor;
    transform: translateY(-2px);
}

.btn-edit-profile:active { transform: translateY(0); }

/* información: separada por espacio por debajo del avatar */
.profile-info {
    margin-top: 90px;
    text-align: center;
    padding: 1.25rem 1rem 1.5rem;
    z-index: 1;
}

.profile-info h1 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.section-title {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
}

body.dark-mode .bi{
    color: var(--text-primary);
}

body.dark-mode .bi:hover{
    color: black;
}

/* CURSOS ADQUIRIDOS - DISEÑO HORIZONTAL */
.courses-horizontal {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.course-horizontal-card {
    display: flex;
    height: 150px;
    margin: 0 auto;
    max-width: 100%;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.course-horizontal-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.course-horizontal-image {
    flex: 0 0 200px;
    position: relative;
    overflow: hidden;
}

.course-horizontal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-horizontal-card:hover .course-horizontal-image img {
    transform: scale(1.05);
}

.course-horizontal-content {
    flex: 1;
    display: flex;
    padding: 1.5rem;
    align-items: center;
    gap: 1.5rem;
}

.course-horizontal-info {
    flex: 1;
}

.course-horizontal-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0 0 0.75rem 0;
    color: var(--text-primary);
    line-height: 1.3;
}

.course-horizontal-description {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
    font-size: 0.95rem;
}

.course-horizontal-actions {
    flex-shrink: 0;
}

.btn-access-course {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-access-course:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    background: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
}

/* CARRUSEL DE CURSOS RECOMENDADOS */
.recommended-courses { 
    margin: 3rem 0; 
}

.carousel-container {
    width: 100%;
    position: relative; 
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
}

.carousel-track {
    display: flex;
    gap: 24px;      
    transition: transform 0.5s ease;
    will-change: transform;
    padding: 12px 0;
    box-sizing: border-box;
}

.carousel-slide {
    flex: 0 0 320px;       
    box-sizing: border-box;
    display: flex;
    align-items: stretch;
}

.course-card {
    width: 100%;
    min-height: 360px;
    display: flex;
    flex-direction: column;
    background-color: var(--bg-secondary);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.course-image {
    width: 100%;
    height: 180px;            
    object-fit: cover;
    display: block;
    flex-shrink: 0;
}

.course-content {
    flex: 1;
    padding: 1rem;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 140px;
}

.carousel-controls {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.carousel-btn {
    background: var(--bg-primary);
    border: 2px solid var(--border-color);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.3s, box-shadow 0.3s;
}

.carousel-btn:hover {
    background: var(--btn-primary-bg);
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .profile-container {
        margin: 1rem auto;
        padding: 0 0.75rem;
    }

    .profile-banner {
        height: 160px;
    }

    .profile-avatar-wrapper {
        width: 100px;
        height: 100px;
        top: 100px;
    }

    .profile-info {
        margin-top: 70px;
        padding: 1rem 0.75rem;
    }

    .profile-info h1 {
        font-size: 1.5rem;
    }

    /* CURSOS HORIZONTAL - MÓVIL */
    .course-horizontal-card {
        flex-direction: column;
        margin: 0 !important;
        height: auto;
    }

    .course-horizontal-image {
        flex: 0 0 160px;
        width: 100%;
    }

    .course-horizontal-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
    }

    .course-horizontal-actions {
        width: 100%;
    }

    .btn-access-course {
        width: 100%;
        justify-content: center;
    }

    /* CARRUSEL MÓVIL */
    .carousel-slide { 
        flex: 0 0 100% !important;
        max-width: 100%;
    }

    .carousel-track { 
        gap: 12px; 
        padding: 10px 0; 
    }

    .course-card { 
        min-height: 380px; 
    }

    .course-image { 
        height: 200px; 
    }

    .section-title {
        font-size: 1.3rem;
    }
}

@media (max-width: 480px) {
    .profile-banner {
        height: 140px;
    }

    .profile-avatar-wrapper {
        width: 80px;
        height: 80px;
        top: 90px;
    }

    .profile-info {
        margin-top: 60px;
    }

    .profile-info h1 {
        font-size: 1.3rem;
    }

    .course-horizontal-title {
        font-size: 1.1rem;
    }

    .course-horizontal-description {
        font-size: 0.9rem;
    }

    .btn-access-course {
        padding: 0.625rem 1.25rem;
        font-size: 0.9rem;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .carousel-slide {
        flex: 0 0 calc(100% - 12px) !important;
        max-width: calc(100% - 12px);
    }
}

@media (max-width: 360px) {
    .course-horizontal-content {
        padding: 1rem;
    }

    .course-horizontal-title {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carouselTrack');
    if (!track) return;
    const prevButton = document.querySelector('.carousel-btn.prev');
    const nextButton = document.querySelector('.carousel-btn.next');

    const getVisibleSlides = () => {
        if (window.innerWidth >= 992) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    };

    let slides, index, autoTimer;

    async function buildLoop() {
        // esperar carga de imágenes para mediciones fiables
        await Promise.all(Array.from(track.querySelectorAll('img')).map(img => {
            return new Promise(resolve => {
                if (img.complete) return resolve();
                img.onload = img.onerror = () => resolve();
            });
        }));

        // limpiar clones previos
        track.querySelectorAll('.clone').forEach(n => n.remove());
        slides = Array.from(track.children);
        const visible = getVisibleSlides();
        if (slides.length === 0) return;

        const realCount = slides.length;
        // crear clones para loop
        for (let i = realCount - visible; i < realCount; i++) {
            const clone = slides[i].cloneNode(true);
            clone.classList.add('clone');
            track.insertBefore(clone, track.firstChild);
        }
        for (let i = 0; i < visible; i++) {
            const clone = slides[i].cloneNode(true);
            clone.classList.add('clone');
            track.appendChild(clone);
        }

        // actualizar lista de slides (ahora incluye clones)
        slides = Array.from(track.children);

        // medir ancho real de una slide (basado en CSS flex-basis)
        const slideWidth = slides[0].getBoundingClientRect().width;
        const gap = parseFloat(getComputedStyle(track).gap) || 0;
        const step = slideWidth + gap;

        // establecer index inicial desplazado por clones
        index = visible;
        track.style.transition = 'none';
        track.style.transform = 'translateX(-' + (step * index) + 'px)';
        // force reflow then enable transition
        track.getBoundingClientRect();
        track.style.transition = 'transform 0.5s ease';
    }

    function moveTo(targetIndex) {
        const gap = parseFloat(getComputedStyle(track).gap) || 0;
        const slideWidth = slides[0].getBoundingClientRect().width;
        const step = slideWidth + gap;
        track.style.transform = 'translateX(-' + (step * targetIndex) + 'px)';
        index = targetIndex;
    }

    function next() {
        if (!slides || slides.length === 0) return;
        const visible = getVisibleSlides();
        const total = slides.length;
        moveTo(index + 1);

        const onEnd = function() {
            const realLast = total - visible - 1;
            if (index > realLast) {
                track.style.transition = 'none';
                index = visible;
                const gap = parseFloat(getComputedStyle(track).gap) || 0;
                const slideWidth = slides[0].getBoundingClientRect().width;
                const step = slideWidth + gap;
                track.style.transform = 'translateX(-' + (step * index) + 'px)';
                track.getBoundingClientRect();
                track.style.transition = 'transform 0.5s ease';
            }
            track.removeEventListener('transitionend', onEnd);
        };
        track.addEventListener('transitionend', onEnd);
    }

    function prev() {
        if (!slides || slides.length === 0) return;
        const visible = getVisibleSlides();
        moveTo(index - 1);

        const onEnd = function() {
            if (index < visible) {
                track.style.transition = 'none';
                index = slides.length - visible - 1;
                const gap = parseFloat(getComputedStyle(track).gap) || 0;
                const slideWidth = slides[0].getBoundingClientRect().width;
                const step = slideWidth + gap;
                track.style.transform = 'translateX(-' + (step * index) + 'px)';
                track.getBoundingClientRect();
                track.style.transition = 'transform 0.5s ease';
            }
            track.removeEventListener('transitionend', onEnd);
        };
        track.addEventListener('transitionend', onEnd);
    }

    // autoscroll cada 5 segundos (5000 ms)
    const startAuto = () => {
        stopAuto();
        autoTimer = setInterval(() => { next(); }, 5000);
    };
    const stopAuto = () => { if (autoTimer) clearInterval(autoTimer); };

    // inicializa
    buildLoop();
    startAuto();

    if (nextButton) nextButton.addEventListener('click', () => { next(); startAuto(); });
    if (prevButton) prevButton.addEventListener('click', () => { prev(); startAuto(); });

    // reconfigurar en resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            stopAuto();
            // quitar clones e inicializar de nuevo
            buildLoop();
            startAuto();
        }, 250);
    });
});
</script>
@endsection