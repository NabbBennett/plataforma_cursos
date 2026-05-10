@extends('layouts.app')

@section('title', 'Información Institucional')

@section('content')
<style>
    .info-section {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .university-header {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
        border-radius: 16px;
        padding: 2.5rem 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        text-align: center;
        position: relative;
    }
    
    .university-selector {
        position: relative;
        display: inline-block;
        max-width: 600px;
        width: 100%;
    }
    
    .university-dropdown-btn {
        background: var(--bg-primary);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }
    
    .university-dropdown-btn:hover {
        border-color: var(--btn-primary-bg);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .university-dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-primary);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        margin-top: 0.5rem;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }
    
    .university-dropdown-content.show {
        display: block;
    }
    
    .university-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .university-item:last-child {
        border-bottom: none;
    }
    
    .university-item:hover {
        background: var(--bg-secondary);
    }
    
    .university-item.active {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .university-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .university-info {
        flex: 1;
    }
    
    .university-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .university-location {
        font-size: 0.85rem;
        opacity: 0.7;
    }
    
    .image-carousel {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }
    
    .carousel-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .info-card {
        background: var(--bg-secondary);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    
    .section-title {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--btn-primary-bg);
        border-radius: 2px;
    }
    
    .admission-dates {
        background: linear-gradient(135deg, var(--btn-primary-bg) 0%, var(--bg-secondary) 100%);
        color: var(--btn-primary-text);
        border-radius: 16px;
        padding: 2rem;
        margin: 2rem 0;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    
    .careers-section {
        background: var(--bg-secondary);
        border-radius: 16px;
        padding: 2rem;
        margin: 2rem 0;
        border: 1px solid var(--border-color);
    }
    
    .career-list {
        columns: 2;
        column-gap: 2rem;
    }
    
    .career-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
        break-inside: avoid;
    }
    
    .career-item:last-child {
        border-bottom: none;
    }
    
    .course-card {
        background: var(--bg-secondary);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
    }
    
    .course-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .course-content {
        padding: 1.5rem;
    }
    
    .course-price {
        color: var(--success-color);
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .btn-view-course {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-view-course:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    
    .map-container {
        border-radius: 12px;
        overflow: hidden;
        height: 300px;
    }
    
    .no-institutions {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .no-institutions-icon {
        font-size: 4rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    /* Estilos para móvil */
    @media (max-width: 768px) {
        .university-header {
            padding: 2rem 1rem;
            margin-bottom: 1.5rem;
        }
        
        .university-dropdown-btn {
            font-size: 1.4rem;
            padding: 0.8rem 1.5rem;
        }
        
        .info-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .career-list {
            columns: 1;
        }
        
        .admission-dates {
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .careers-section {
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .course-content {
            padding: 1.25rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .carousel-image {
            height: 300px;
        }
    }
    
    @media (max-width: 576px) {
        .carousel-image {
            height: 250px;
        }
        
        .info-card {
            padding: 1.25rem;
        }
        
        .university-dropdown-btn {
            font-size: 1.2rem;
        }
        
        .university-item {
            padding: 0.8rem 1rem;
        }
        
        .university-avatar {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }
    }
</style>

<div class="container mt-4 mb-5 info-section" style="max-width: 1200px;">
    
    @if(!$info)
        <!-- Estado cuando no hay instituciones -->
        <div class="no-institutions">
            <div class="no-institutions-icon">
                <i class="bi bi-building-slash"></i>
            </div>
            <h3 class="mb-3">No hay instituciones disponibles</h3>
            <p class="text-muted mb-4">Actualmente no hay información institucional cargada en el sistema.</p>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.information.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Agregar Primera Institución
                    </a>
                @endif
            @endauth
        </div>
    @else
        <!-- Encabezado de la universidad con selector -->
        <div class="university-header">
            <div class="university-selector">
                <button class="university-dropdown-btn" id="universityDropdownBtn">
                    <span id="currentUniversity">{{ $info->name ?? 'SELECCIONA UNA UNIVERSIDAD' }}</span>
                    <i class="bi bi-chevron-down" id="dropdownIcon"></i>
                </button>
                
                <div class="university-dropdown-content" id="universityDropdown">
                    @foreach($institutions as $institution)
                        <div class="university-item {{ $institution->id == $info->id ? 'active' : '' }}" 
                             data-id="{{ $institution->id }}"
                             data-name="{{ $institution->name }}"
                             data-url="{{ route('information.index', ['id' => $institution->id]) }}">
                            <div class="university-avatar">
                                @if($institution->image_path)
                                    <img src="{{ asset('storage/' . $institution->image_path) }}" 
                                         alt="{{ $institution->name }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                @else
                                    <i class="bi bi-building"></i>
                                @endif
                            </div>
                            <div class="university-info">
                                <div class="university-name">{{ $institution->name }}</div>
                                @if($institution->location)
                                    <div class="university-location">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ Str::limit($institution->location, 30) }}
                                    </div>
                                @endif
                            </div>
                            @if($institution->id == $info->id)
                                <i class="bi bi-check-circle-fill"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Carrusel de imagen -->
        <div class="image-carousel">
            <img src="{{ asset('storage/' . $info->image_path) }}"
                 class="carousel-image"
                 alt="{{ $info->name ?? 'Universidad' }}"
                 id="universityImage">
        </div>

        <!-- Descripción y Ubicación -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <h3 class="section-title text-center">Descripción</h3>
                    <div class="description-content" style="line-height: 1.7;" id="universityDescription">
                        {{ $info->description ?? 'DESCRIPCIÓN' }}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <h3 class="section-title text-center">Ubicación</h3>
                    <div class="map-container" id="universityMap">
                        @if(!empty($info->location))
                            <iframe
                                width="100%"
                                height="300"
                                style="border:0;"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps?q={{ urlencode($info->location) }}&output=embed">
                            </iframe>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light rounded">
                                <div class="text-center">
                                    <i class="bi bi-map" style="font-size: 3rem; color: var(--text-secondary);"></i>
                                    <p class="mt-2 text-muted">Ubicación no disponible</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Fechas de Admisión -->
        <div class="admission-dates" id="admissionDates">
            <h3 class="section-title text-center mb-4" style="color: inherit;">Fechas de Admisión</h3>
            <div class="dates-content" style="font-size: 1.2rem; line-height: 1.8;">
                {!! nl2br(e($info->admission_dates ?? 'FECHAS DE ADMISIÓN')) !!}
            </div>
        </div>

        <!-- Carreras Ofertadas -->
        <div class="careers-section" id="careersSection">
            <h3 class="section-title text-center mb-4">Carreras Ofertadas</h3>
            <div class="career-list" id="careersList">
                @php
                    $careers = array_filter(array_map('trim', explode(',', $info->careers ?? '')));
                @endphp
                
                @foreach($careers as $career)
                    <div class="career-item">
                        <i class="bi bi-check-circle-fill me-2" style="color: var(--success-color);"></i>
                        {{ $career }}
                    </div>
                @endforeach
                
                @if(empty($careers))
                    <div class="text-center text-muted">
                        <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                        <p class="mt-2">No hay carreras disponibles</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cursos Recomendados -->
        <div class="mt-5" id="recommendedCourses">
            <h3 class="section-title text-center mb-5">Cursos Recomendados</h3>
            <div class="row g-4">
                @foreach($recommendedCourses as $course)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="course-card">
                            @if($course->image)
                                <img src="{{ $course->image_url }}" 
                                     class="course-image" 
                                     alt="{{ $course->title }}">
                            @else
                                <div class="course-image bg-light d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="bi bi-image" style="font-size: 2rem; color: var(--text-secondary);"></i>
                                        <p class="small mt-2 text-muted">Sin imagen</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="course-content">
                                <h6 class="fw-bold mb-2" style="color: var(--text-primary);">
                                    {{ $course->title }}
                                </h6>
                                
                                <div class="course-details mb-3">
                                    <div class="small mb-1" style="color: var(--text-secondary);">
                                        <i class="bi bi-clock me-1"></i>
                                        Duración: {{ $course->number_of_weeks }} semanas
                                    </div>
                                    <div class="course-price">
                                        <i class="bi bi-currency-dollar me-1"></i>
                                        ${{ number_format($course->price_per_week, 2) }} /semana
                                    </div>
                                </div>
                                
                                <a href="{{ route('store.course', $course->id) }}" 
                                   class="btn-view-course">
                                    <i class="bi bi-eye me-2"></i>
                                    Ver Curso
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($recommendedCourses->isEmpty())
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-book" style="font-size: 3rem; color: var(--text-secondary);"></i>
                        <p class="mt-3 text-muted">No hay cursos recomendados disponibles</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('universityDropdownBtn');
    const dropdown = document.getElementById('universityDropdown');
    const dropdownIcon = document.getElementById('dropdownIcon');
    const currentUniversity = document.getElementById('currentUniversity');
    const universityItems = document.querySelectorAll('.university-item');
    
    if (dropdownBtn && dropdown) {
        // Toggle dropdown
        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
            dropdownIcon.classList.toggle('bi-chevron-down');
            dropdownIcon.classList.toggle('bi-chevron-up');
        });
        
        // Seleccionar universidad
        universityItems.forEach(item => {
            item.addEventListener('click', function() {
                const universityUrl = this.getAttribute('data-url');
                // Redirigir a la página de la universidad seleccionada
                window.location.href = universityUrl;
            });
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && !dropdownBtn.contains(e.target)) {
                dropdown.classList.remove('show');
                dropdownIcon.classList.remove('bi-chevron-up');
                dropdownIcon.classList.add('bi-chevron-down');
            }
        });
        
        // Prevenir que el dropdown se cierre cuando se hace clic dentro
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Efecto de hover para las tarjetas de curso
    const courseCards = document.querySelectorAll('.course-card');
    
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection