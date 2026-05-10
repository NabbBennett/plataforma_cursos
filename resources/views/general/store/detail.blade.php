@extends('layouts.app')

@section('title', $course->title)

@section('content')
<style>
    .course-details {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .course-image {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .course-image:hover {
        transform: scale(1.02);
    }
    
    .price-section {
        background-color: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .weeks-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .schedule-selector-detail {
        background-color: var(--bg-secondary);
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
    }
    
    .schedule-label-detail {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }
    
    .schedule-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .schedule-option {
        padding: 0.5rem 1rem;
        border: 2px solid var(--border-color);
        background-color: var(--bg-primary);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        color: var(--text-primary);
        text-decoration: none;
        display: inline-block;
        font-size: 0.9rem;
    }
    
    .schedule-option:hover {
        border-color: var(--btn-primary-bg);
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .schedule-option.active {
        border-color: var(--btn-primary-bg);
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }
    
    .weeks-input {
        width: 80px;
        text-align: center;
    }
    
    .btn-add-cart {
        background-color: var(--btn-primary-bg);
        border-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .reviews-section {
        padding: 2rem 0;
        border-top: 1px solid var(--border-color);
    }
    
    .review-card {
        background-color: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .verified-badge {
        color: #28a745;
        font-size: 0.8rem;
    }
    
    .review-date {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .star-rating {
        color: #ffc107;
        margin-bottom: 0.5rem;
    }
    
    .rating-summary {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: var(--bg-secondary);
        border-radius: 12px;
    }
    
    .rating-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .rating-stars {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex-grow: 1;
    }
    
    .rating-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .bar-container {
        flex-grow: 1;
        height: 8px;
        background-color: var(--border-color);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .bar-fill {
        height: 100%;
        background-color: #ffc107;
    }
    
    .review-form {
        background-color: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .star-rating-input {
        display: flex;
        gap: 0.25rem;
        margin-bottom: 1rem;
    }
    
    .course-description-content {
        line-height: 1.8;
    }
    
    .course-description-content div,
    .course-description-content span {
        background-color: transparent !important;
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
    }
    
    .star-input {
        font-size: 1.5rem;
        color: var(--border-color);
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .star-input:hover,
    .star-input.active {
        color: #ffc107;
    }
    
    .review-sort {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .rating-summary {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .weeks-selector {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .weeks-selector .btn-add-cart {
            width: 100%;
            margin-top: 1rem;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .review-date {
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container mt-4 course-details">
    <a href="{{ route('store') }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left me-2"></i>Volver al catálogo
    </a>
    
    <div class="row g-4 align-items-start">
        <!-- Imagen del curso -->
        <div class="col-md-5">
            @if ($course->image)
                <img src="{{ $course->image_url }}" class="img-fluid rounded course-image" alt="Imagen del curso {{ $course->title }}">
            @else
                <div class="bg-secondary text-white text-center p-5 rounded course-image" style="min-height:300px; display:flex; align-items:center; justify-content:center;">
                    <div>
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p class="mt-2">Sin imagen</p>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Info principal -->
        <div class="col-md-7">
            <h1 class="mb-3">{{ $course->title }}</h1>
            <h4 class="mb-3">Horario: <strong>{{ $course->schedule }}</strong></p>
            @php
                $capacity   = $course->capacity;
                $enrolled   = $course->enrolled_count ?? 0;
                $available  = $course->available_capacity; // en lugar de $available_numeric
                $progress   = ($capacity) ? round(($enrolled / $capacity) * 100) : 0;
            @endphp

            <div class="price-section">
                <h5>Precio del curso</h5>
                <div class="fs-4 text-success mb-2">
                    ${{ number_format($course->price_per_week, 2) }} <small class="text">por semana</small>
                </div>

                {{-- Cupos --}}
                @if($capacity)
                    @if($available > 0)
                        <div class="progress my-2" style="height:18px;">
                            <div class="progress-bar {{ $available <= 5 ? 'bg-warning' : 'bg-success' }}"
                                 role="progressbar"
                                 style="width: {{ $progress }}%;"
                                 aria-valuenow="{{ $enrolled }}"
                                 aria-valuemin="0"
                                 aria-valuemax="{{ $capacity }}">
                                {{ $enrolled }} / {{ $capacity }} inscritos
                            </div>
                        </div>
                        <small class="text d-block">
                            @if($available <= 5)
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                                Quedan {{ $available }} cupos
                            @else
                                <i class="bi bi-check-circle text-success"></i>
                                {{ $available }} cupos disponibles
                            @endif
                        </small>
                    @else
                        <div class="alert alert-danger mb-0 mt-2 p-2 text-center">
                            <i class="bi bi-x-circle me-1"></i> Curso lleno ({{ $capacity }} / {{ $capacity }})
                        </div>
                    @endif
                @else
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-infinity text-primary"></i> Cupos ilimitados
                    </small>
                @endif
            </div>
            
            {{-- Selector de horarios si hay más disponibles --}}
            @if(auth()->check() && auth()->user()->isAdmin())
            @if(count($schedules) > 0)
                <div class="schedule-selector-detail">
                    <label class="schedule-label-detail">
                        <i class="bi bi-clock"></i> Otros horarios disponibles:
                    </label>
                    <div class="schedule-options">
                        @foreach($schedules as $schedule)
                            <a href="{{ route('store.course', $schedule['id']) }}" class="schedule-option">
                                {{ $schedule['schedule'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            @endif
            
            
            <div class="mb-4">
                <h5>Semanas de duración</h5>
                <div class="weeks-selector">
                    <form method="POST" action="{{ route('cart.add', $course->id) }}" class="d-flex align-items-center gap-2 flex-wrap">
                        @csrf
                        {{-- CORRECCIÓN: Usar $available en lugar de $available_numeric --}}
                        <button type="button" class="btn btn-outline-secondary" onclick="changeWeeks(-1)" {{ ($capacity && $available !== null && $available <= 0) ? 'disabled' : '' }}>-</button>
                        <input type="number" name="weeks_count" id="weeks_count" class="form-control text-center weeks-input" value="1" min="1" max="{{ $course->weeks->count() }}" style="width:70px;" required {{ ($capacity && $available !== null && $available <= 0) ? 'disabled' : '' }}>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeWeeks(1)" {{ ($capacity && $available !== null && $available <= 0) ? 'disabled' : '' }}>+</button>
                        <span class="ms-2 text">de {{ $course->weeks->count() }} semana(s)</span>
                        
                        {{-- CORRECCIÓN PRINCIPAL: Verificar correctamente la disponibilidad --}}
                        @if($capacity && $available !== null && $available <= 0)
                            <button type="button" class="btn btn-secondary ms-3 btn-add-cart" disabled>
                                <i class="bi bi-lock-fill me-2"></i>No disponible
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary ms-3 btn-add-cart">
                                <i class="bi bi-cart-plus me-2"></i>Añadir al carrito
                            </button>
                        @endif
                    </form>
                </div>
            </div>
            
            <div class="mb-4">
                <h5>Descripción</h5>
                <div class="text course-description-content">{!! $course->description !!}</div>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-4 pt-3 border-top">
                <h2>Detalles del curso</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Duración:</strong> {{ $course->weeks->count() }} semanas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sección de comentarios y puntuación -->
    @auth
        @if(Auth::user()->hasPurchasedAllModules($course))
        <div class="reviews-section">
            <h3 class="mb-4">Comentarios y Puntuaciones</h3>
            
            <!-- Resumen de puntuaciones -->
            <div class="rating-summary">
                <div class="d-flex align-items-center">
                    <div class="rating-number">{{ number_format($course->averageRating(), 1) }}</div>
                    <div class="ms-3">
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($course->averageRating()))
                                    <i class="bi bi-star-fill"></i>
                                @elseif($i - 0.5 <= $course->averageRating())
                                    <i class="bi bi-star-half"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="text">({{ $course->reviews->count() }} reseñas)</div>
                    </div>
                </div>
                
                <div class="rating-stars">
                    @for($i = 5; $i >= 1; $i--)
                        <div class="rating-bar">
                            <span>{{ $i }} <i class="bi bi-star-fill text-warning"></i></span>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: {{ $course->percentageForRating($i) }}%"></div>
                            </div>
                            <span class="text">{{ $course->countForRating($i) }}</span>
                        </div>
                    @endfor
                </div>
            </div>
            
            <!-- Formulario para agregar reseña -->
            <div class="review-form">
                <h5>Agregar tu reseña</h5>
                <form method="POST" action="{{ route('course.review.store', $course->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="rating" class="form-label">Tu calificación</label>
                        <div class="star-rating-input" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star-input" data-rating="{{ $i }}"><i class="bi bi-star"></i></span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="comment" class="form-label">Tu comentario</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Comparte tu experiencia con este curso..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar reseña</button>
                </form>
            </div>
            
            <div id="reviewsList">
                @foreach($course->reviews->sortByDesc('created_at') as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="verified-badge"><i class="bi bi-patch-check-fill"></i> Verificado</span>
                        </div>
                        <div class="review-date">
                            {{ $review->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    
                    <div class="review-content">
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
                @endforeach
                
                @if($course->reviews->count() == 0)
                <div class="text-center py-4">
                    <i class="bi bi-chat-square-text" style="font-size: 3rem; color: var(--text-secondary);"></i>
                    <p class="mt-2 text">Aún no hay reseñas para este curso. ¡Sé el primero en opinar!</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="reviews-section">
            <div class="alert text-center p-4 rounded shadow-lg h-100 mt-4">
                <h5>Reseñas del curso</h5>
                <p class="mb-0">Para ver y agregar reseñas, necesitas haber completado la compra de todos los módulos de este curso.</p>
            </div>
        </div>
        @endif
    @else
    <div class="reviews-section">
        <div class="alert text-center p-4 rounded shadow-lg h-100 mt-4">
            <h5>Reseñas del curso</h5>
            <p class="mb-0">Para ver y agregar reseñas, necesitas <a href="{{ route('login') }}" class="alert-link">iniciar sesión</a> y haber completado la compra de todos los módulos de este curso.</p>
        </div>
    </div>
    @endauth
</div>

<script>
function changeWeeks(delta) {
    const input = document.getElementById('weeks_count');
    let value = parseInt(input.value) || 1;
    const min = parseInt(input.min);
    const max = parseInt(input.max);
    value += delta;
    if (value < min) value = min;
    if (value > max) value = max;
    input.value = value;
}

// Sistema de calificación con estrellas
document.addEventListener('DOMContentLoaded', function() {
    const starRating = document.getElementById('starRating');
    const ratingInput = document.getElementById('ratingInput');
    
    if (starRating) {
        const stars = starRating.querySelectorAll('.star-input');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                
                // Actualizar visualización de estrellas
                stars.forEach(s => {
                    const starRating = parseInt(s.getAttribute('data-rating'));
                    if (starRating <= rating) {
                        s.classList.add('active');
                        s.innerHTML = '<i class="bi bi-star-fill"></i>';
                    } else {
                        s.classList.remove('active');
                        s.innerHTML = '<i class="bi bi-star"></i>';
                    }
                });
            });
        });
        
        // Inicializar con 5 estrellas seleccionadas
        stars[4].click();
    }
});
</script>
@endsection