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
        <h2 class="section-title">Cursos Comprados</h2>
        
        @if($compras->isEmpty())
            <div class="empty-state">
                <p>No has comprado ningún curso todavía.</p>
                <a href="{{ route('store') }}" class="btn btn-primary">Explorar Cursos</a>
            </div>
        @else
            <div class="courses-grid">
                @foreach($compras as $compra)
                    @php $curso = $compra->course; @endphp
                    @if($curso)
                    <div class="course-card">
                        <img src="{{ $curso->image ? asset('storage/' . $curso->image) : 'https://via.placeholder.com/300x160/4A5568/FFFFFF?text=CURSO' }}" 
                             alt="{{ $curso->title }}" class="course-image">
                        <div class="course-content">
                            <h3 class="course-title">{{ $curso->title }}</h3>
                            <p class="course-description">{{ Str::limit($curso->description, 100) }}</p>
                            <div class="course-actions">
                                <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-primary">Acceder</a>
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
                            <h3 class="course-title">{{ $curso->title }}</h3>                            <div class="course-actions">
                                <a href="{{ route('courses.show', $curso->id) }}" class="btn btn-outline-primary">Saber Más</a>
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
    background: var(--bg-primary);        /* blanco en light-mode, negro en dark-mode */
    color: var(--text-primary);           /* texto acorde al tema */
    border: 2px solid var(--border-color);
    border-radius: 999px;
    text-decoration: none;
    transition: background .15s ease, color .15s ease, border-color .15s ease, transform .12s ease;
}

/* Hover / focus: invertir fondo y texto respecto al tema (usa variables existentes) */
.btn-edit-profile:hover,
.btn-edit-profile:focus {
    background: var(--text-primary);      /* en light -> texto oscuro; en dark -> texto claro */
    color: var(--bg-primary);             /* invierte con el background */
    border-color: currentColor;           /* borde sigue el color visual actual */
    transform: translateY(-2px);
}

.btn-edit-profile:active { transform: translateY(0); }

/* información: separada por espacio por debajo del avatar */
.profile-info {
    margin-top: 90px; /* espacio para que el avatar no tape el contenido */
    text-align: center;
    padding: 1.25rem 1rem 1.5rem;
    z-index: 1;
}

.profile-info h1 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.profile-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 1rem;
}

.section-title {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
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
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.recommended-courses { 
    margin: 3rem 0; 
}

.carousel-container { 
    position: relative; 
    overflow: hidden; 
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
    height: 360px;            /* altura fija total (50% imagen, 40% contenido, 10% spacer) */
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
    height: 60%;            
    object-fit: cover;
    display: block;
    flex-shrink: 0;
}


.course-content {
    height: 40%;
    padding: 1rem;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
}

/* Responsive: reduce ancho de slide en móvil */
@media (max-width: 767.98px) {
    .carousel-slide { 
        flex: 0 0 90%; 
    }

    .carousel-track { 
        gap: 12px; 
        padding: 10px 0; 
    }

    .course-card { 
        height: 420px; 
    }

    .course-image { 
        height: 60%; 
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