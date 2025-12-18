@extends('layouts.app')

@section('title', 'Capturas de Evidencia')

@section('content')
<!-- Hero Section -->
<section class="evidence-hero py-5">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">Capturas de Evidencia</h1>
            <p class="lead">Conoce el trabajo y dedicación de nuestros estudiantes a través de estas capturas</p>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="evidence-gallery py-5">
    <div class="container">
        <div class="row g-4">
            @for($i = 1; $i <= 28; $i++)
            @php
                $imageJpg = public_path('images/testimonios/' . $i . '.jpg');
                $imageJpeg = public_path('images/testimonios/' . $i . '.jpeg');
                $imagePng = public_path('images/testimonios/' . $i . '.png');
                $imageExt = file_exists($imageJpg) ? 'jpg' : (file_exists($imageJpeg) ? 'jpeg' : (file_exists($imagePng) ? 'png' : 'jpg'));
            @endphp
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="evidence-card">
                    <div class="evidence-image-container" 
                         onclick="openCustomModal('{{ asset('images/testimonios/' . $i . '.' . $imageExt) }}', 'Evidencia {{ $i }}')"
                         style="cursor: pointer;">
                        <img src="{{ asset('images/testimonios/' . $i . '.' . $imageExt) }}" 
                             alt="Evidencia {{ $i }}" 
                             class="evidence-image">
                        <div class="evidence-overlay">
                            <i class="bi bi-zoom-in"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Incluir el modal -->
@include('general.testimonial.modal')

<style>
/* Hero Section */
.evidence-hero {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
    border-bottom: 1px solid var(--border-color);
}

.evidence-hero h1 {
    color: var(--text-primary);
}

.evidence-hero .lead {
    color: var(--text-secondary);
}

/* Gallery Section */
.evidence-gallery {
    background-color: var(--bg-primary);
    min-height: 100vh;
}

/* Evidence Card */
.evidence-card {
    background-color: var(--light-base);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

body.dark-mode .evidence-card {
    background-color: var(--dark-300);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.evidence-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

body.dark-mode .evidence-card:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

/* Image Container */
.evidence-image-container {
    position: relative;
    width: 100%;
    padding-top: 100%; /* Aspecto cuadrado 1:1 */
    overflow: hidden;
    cursor: pointer;
}

.evidence-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.evidence-image:hover {
    transform: scale(1.1);
}

/* Overlay */
.evidence-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.evidence-image-container:hover .evidence-overlay {
    opacity: 1;
}

.evidence-overlay i {
    color: white;
    font-size: 3rem;
}

/* Responsive Design */
@media (max-width: 992px) {
    .evidence-card {
        margin-bottom: 1.5rem;
    }
    
    .evidence-overlay i {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .evidence-hero h1 {
        font-size: 2.5rem;
    }
    
    .evidence-hero .lead {
        font-size: 1.1rem;
    }
    
    .evidence-overlay i {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .evidence-hero h1 {
        font-size: 2rem;
    }
    
    .evidence-hero .lead {
        font-size: 1rem;
    }
    
    .evidence-card {
        margin-bottom: 1rem;
    }
    
    .evidence-overlay i {
        font-size: 1.5rem;
    }
}

/* Animaciones */
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

.evidence-card {
    animation: fadeIn 0.5s ease-in-out;
}

/* Grid gaps ajustados */
.row.g-4 {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 1.5rem;
}

@media (max-width: 768px) {
    .row.g-4 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }
}
</style>
@endsection
