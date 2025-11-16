@extends('layouts.app')

@section('title', 'Tienda de Cursos')

@section('content')
<div class="store-container">
    <!-- Header de la tienda -->
    <div class="store-header">
        <h1>Nuestros Cursos</h1>
        <p>Descubre todos los cursos disponibles y encuentra el perfecto para ti</p>
    </div>

    <div class="store-content">
        <!-- Sidebar de filtros (Desktop) -->
        <div class="store-sidebar">
            <div class="filter-card">
                <div class="filter-header">
                    <h3>Filtros</h3>
                    <button class="btn-clear-filters" onclick="clearFilters()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Limpiar
                    </button>
                </div>
                
                <form method="GET" action="{{ route('store') }}" id="filter-form" autocomplete="off">
                    <div class="filter-group">
                        <label for="search" class="filter-label">
                            <i class="bi bi-search"></i>
                            Buscar curso
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="filter-input" placeholder="Nombre del curso...">
                    </div>
                    
                    <div class="filter-group">
                        <label for="price" class="filter-label">
                            <i class="bi bi-currency-dollar"></i>
                            Precio máximo
                        </label>
                        <div class="price-input-group">
                            <input type="number" name="price" id="price" value="{{ request('price') }}" 
                                   class="filter-input" min="0" step="0.01" placeholder="Ej: 500">
                            <span class="price-suffix">por semana</span>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label for="duration" class="filter-label">
                            <i class="bi bi-calendar-week"></i>
                            Duración máxima
                        </label>
                        <div class="duration-input-group">
                            <input type="number" name="duration" id="duration" value="{{ request('duration') }}" 
                                   class="filter-input" min="1" placeholder="Ej: 10">
                            <span class="duration-suffix">semanas</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-funnel"></i>
                        Aplicar Filtros
                    </button>
                </form>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="store-main">
            <!-- Header móvil con filtro desplegable -->
            <div class="mobile-filter-container">
                <div class="mobile-filter-header">
                    <div class="courses-count">
                        <span id="courses-count">{{ $courses->count() }}</span> cursos encontrados
                    </div>
                    <button class="btn-mobile-filter-toggle" id="mobileFilterToggle">
                        <i class="bi bi-funnel"></i>
                        Filtros
                        <i class="bi bi-chevron-down" id="filterToggleIcon"></i>
                    </button>
                </div>
                
                <div class="mobile-filter-dropdown" id="mobileFilterDropdown">
                    <form method="GET" action="{{ route('store') }}" id="mobile-filter-form" autocomplete="off">
                        <div class="filter-group">
                            <label for="mobile-search" class="filter-label">
                                <i class="bi bi-search"></i>
                                Buscar curso
                            </label>
                            <input type="text" name="search" id="mobile-search" value="{{ request('search') }}" 
                                   class="filter-input" placeholder="Nombre del curso...">
                        </div>
                        
                        <div class="filter-group">
                            <label for="mobile-price" class="filter-label">
                                <i class="bi bi-currency-dollar"></i>
                                Precio máximo
                            </label>
                            <div class="price-input-group">
                                <input type="number" name="price" id="mobile-price" value="{{ request('price') }}" 
                                       class="filter-input" min="0" step="0.01" placeholder="Ej: 500">
                                <span class="price-suffix">por semana</span>
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label for="mobile-duration" class="filter-label">
                                <i class="bi bi-calendar-week"></i>
                                Duración máxima
                            </label>
                            <div class="duration-input-group">
                                <input type="number" name="duration" id="mobile-duration" value="{{ request('duration') }}" 
                                       class="filter-input" min="1" placeholder="Ej: 10">
                                <span class="duration-suffix">semanas</span>
                            </div>
                        </div>
                        
                        <div class="mobile-filter-actions">
                            <button type="button" class="btn-clear-filters" onclick="clearMobileFilters()">
                                <i class="bi bi-arrow-clockwise"></i>
                                Limpiar
                            </button>
                            <button type="submit" class="btn-filter">
                                <i class="bi bi-funnel"></i>
                                Aplicar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grid de cursos -->
            <div id="courses-grid" class="courses-grid">
                @if($courses->count() > 0)
                    @foreach($courses as $course)
                        <div class="course-card">
                            <div class="course-image-container">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="course-image" alt="{{ $course->title }}">
                                @else
                                    <div class="course-image-placeholder">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                
                                @php
                                    $weeksCompradas = $userWeeks[$course->id] ?? 0;
                                    $weeksTotal = $course->weeks->count();
                                    $cursoComprado = $weeksCompradas >= $weeksTotal;
                                @endphp
                                
                                @if($cursoComprado)
                                    <div class="course-badge purchased">
                                        <i class="bi bi-check-circle"></i>
                                        Comprado
                                    </div>
                                @else
                                    <div class="course-badge price">
                                        ${{ number_format($course->price_per_week, 0) }}/semana
                                    </div>
                                @endif
                            </div>
                            
                            <div class="course-content">
                                <h3 class="course-title">{{ $course->title }}</h3>
                                <p class="course-description">{{ Str::limit($course->description, 120) }}</p>
                                
                                <div class="course-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $course->weeks->count() }} semanas</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-collection-play"></i>
                                        <span>{{ $course->weeks->count() }} módulos</span>
                                    </div>
                                </div>
                                
                                <div class="course-actions">
                                    @if($cursoComprado)
                                        <button class="btn-course purchased" disabled>
                                            <i class="bi bi-check-circle"></i>
                                            Curso Comprado
                                        </button>
                                    @else
                                        <a href="{{ route('store.course', $course->id) }}" class="btn-course primary">
                                            <i class="bi bi-eye"></i>
                                            Ver Curso
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-courses">
                        <i class="bi bi-search"></i>
                        <h3>No se encontraron cursos</h3>
                        <p>Intenta ajustar los filtros para ver más resultados</p>
                        <button class="btn-clear-filters" onclick="clearFilters()">
                            Limpiar filtros
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.store-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.store-header {
    text-align: center;
    margin-bottom: 3rem;
}

.store-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.store-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
}

.store-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    align-items: start;
}

/* Sidebar Styles (Desktop) */
.store-sidebar {
    position: sticky;
    top: 2rem;
}

.filter-card {
    background-color: var(--bg-secondary);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.filter-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.btn-clear-filters {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: color 0.3s;
}

.btn-clear-filters:hover {
    color: var(--text-primary);
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.filter-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background-color: var(--bg-primary);
    color: var(--text-primary);
    font-size: 0.9rem;
    transition: border-color 0.3s;
}

.filter-input:focus {
    outline: none;
    border-color: var(--btn-primary-bg);
}

.price-input-group,
.duration-input-group {
    position: relative;
}

.price-suffix,
.duration-suffix {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.8rem;
    color: var(--text-secondary);
    pointer-events: none;
}

.btn-filter {
    width: 100%;
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-filter:hover {
    background-color: var(--btn-outline-hover-bg);
    transform: translateY(-2px);
}

/* Main Content Styles */
.store-main {
    min-height: 500px;
}

/* Mobile Filter Container */
.mobile-filter-container {
    display: none;
    margin-bottom: 1.5rem;
    background-color: var(--bg-secondary);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.mobile-filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    cursor: pointer;
}

.courses-count {
    font-size: 1rem;
    color: var(--text-primary);
    font-weight: 500;
}

.courses-count span {
    font-weight: 700;
    color: var(--btn-primary-bg);
}

.btn-mobile-filter-toggle {
    background: none;
    border: none;
    color: var(--btn-primary-bg);
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: background-color 0.3s;
}

.btn-mobile-filter-toggle:hover {
    background-color: var(--bg-primary);
}

.mobile-filter-dropdown {
    display: none;
    padding: 0 1.25rem 1.25rem;
    border-top: 1px solid var(--border-color);
    background-color: var(--bg-secondary);
}

.mobile-filter-dropdown.active {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mobile-filter-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.mobile-filter-actions .btn-clear-filters,
.mobile-filter-actions .btn-filter {
    flex: 1;
    padding: 0.75rem;
    font-size: 0.9rem;
}

/* Courses Grid */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.course-card {
    background-color: var(--bg-secondary);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.course-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.course-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-card:hover .course-image {
    transform: scale(1.05);
}

.course-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--bg-primary), var(--border-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: 3rem;
}

.course-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.course-badge.price {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.course-badge.purchased {
    background-color: #28a745;
    color: white;
}

.course-content {
    padding: 1.5rem;
}

.course-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
    line-height: 1.4;
}

.course-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.course-actions {
    margin-top: auto;
}

.btn-course {
    width: 100%;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-course.primary {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.btn-course.primary:hover {
    background-color: var(--btn-outline-hover-bg);
    transform: translateY(-2px);
}

.btn-course.purchased {
    background-color: var(--bg-primary);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
    cursor: not-allowed;
}

/* Empty State */
.empty-courses {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-courses i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-courses h3 {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.empty-courses p {
    margin-bottom: 2rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .store-content {
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
    }
    
    .courses-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

@media (max-width: 768px) {
    .store-container {
        padding: 1rem 0.5rem;
    }
    
    .store-header h1 {
        font-size: 2rem;
    }
    
    .store-content {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .store-sidebar {
        display: none;
    }
    
    .mobile-filter-container {
        display: block;
    }
    
    .courses-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .course-card {
        margin-bottom: 0;
    }
}

@media (max-width: 480px) {
    .store-header {
        margin-bottom: 2rem;
    }
    
    .store-header h1 {
        font-size: 1.75rem;
    }
    
    .course-content {
        padding: 1.25rem;
    }
    
    .course-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .mobile-filter-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .mobile-filter-actions .btn-clear-filters,
    .mobile-filter-actions .btn-filter {
        flex: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filter-form');
    const mobileForm = document.getElementById('mobile-filter-form');
    const inputs = form.querySelectorAll('input');
    const mobileInputs = mobileForm.querySelectorAll('input');
    const grid = document.getElementById('courses-grid');
    const coursesCount = document.getElementById('courses-count');
    
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileFilterDropdown = document.getElementById('mobileFilterDropdown');
    const filterToggleIcon = document.getElementById('filterToggleIcon');

    // Mobile filter toggle
    if (mobileFilterToggle) {
        mobileFilterToggle.addEventListener('click', function() {
            const isActive = mobileFilterDropdown.classList.contains('active');
            
            if (isActive) {
                mobileFilterDropdown.classList.remove('active');
                filterToggleIcon.classList.remove('bi-chevron-up');
                filterToggleIcon.classList.add('bi-chevron-down');
            } else {
                mobileFilterDropdown.classList.add('active');
                filterToggleIcon.classList.remove('bi-chevron-down');
                filterToggleIcon.classList.add('bi-chevron-up');
            }
        });
    }

    // Close mobile filter when clicking outside
    document.addEventListener('click', function(e) {
        if (!mobileFilterToggle.contains(e.target) && !mobileFilterDropdown.contains(e.target)) {
            mobileFilterDropdown.classList.remove('active');
            filterToggleIcon.classList.remove('bi-chevron-up');
            filterToggleIcon.classList.add('bi-chevron-down');
        }
    });

    let timeout = null;
    
    function debouncedFilter(inputs, form) {
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    performFilter(form);
                }, 400);
            });
        });
    }

    function performFilter(form) {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        
        fetch(form.action + '?' + params, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newGrid = tempDiv.querySelector('#courses-grid');
            const newCount = tempDiv.querySelector('#courses-count');
            
            if (newGrid) grid.innerHTML = newGrid.innerHTML;
            if (newCount && coursesCount) coursesCount.textContent = newCount.textContent;
        })
        .catch(error => {
            console.error('Error filtering courses:', error);
        });
    }

    // Initialize debounced filtering for both forms
    debouncedFilter(inputs, form);
    debouncedFilter(mobileInputs, mobileForm);
});

function clearFilters() {
    document.getElementById('filter-form').reset();
    document.getElementById('filter-form').dispatchEvent(new Event('submit', { cancelable: true }));
}

function clearMobileFilters() {
    document.getElementById('mobile-filter-form').reset();
    document.getElementById('mobile-filter-form').dispatchEvent(new Event('submit', { cancelable: true }));
}
</script>
@endsection