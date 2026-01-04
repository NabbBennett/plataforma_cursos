@extends('layouts.admin')

@section('title', 'Gestión de Cursos')

@section('content')
<style>
    .courses-container {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        min-height: calc(100vh - var(--header-height));
        padding: 2rem 0;
    }

    .page-header {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table-container {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .table-custom {
        background-color: transparent;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .table-custom th {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        border-color: var(--border-color);
        font-weight: 600;
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-custom td {
        background-color: transparent;
        border-color: var(--border-color);
        padding: 1rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .table-custom tbody tr {
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--hover-bg);
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-edit {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .btn-edit:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: var(--btn-danger-bg);
        color: var(--btn-danger-text);
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .btn-create {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-create:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .course-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .image-placeholder {
        width: 80px;
        height: 60px;
        background-color: var(--bg-primary);
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    .price-badge {
        background-color: #28a745;
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .date-badge {
        background-color: #6f42c1;
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .text-primary-custom {
        color: var(--text-primary) !important;
    }

    .text-secondary-custom {
        color: var(--text-secondary) !important;
    }

    .description-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 300px;
    }

    .search-container {
        margin-bottom: 1.5rem;
    }

    .search-input-group {
        position: relative;
        max-width: 400px;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--btn-primary-bg);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        pointer-events: none;
    }

    .clear-search {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 0.25rem;
        display: none;
        transition: color 0.3s ease;
    }

    .clear-search:hover {
        color: var(--text-primary);
    }

    .clear-search.active {
        display: block;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    .no-results i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .alert-custom {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
    }

    .alert-success {
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    @media (max-width: 768px) {
        .courses-container {
            padding: 1rem 0;
        }

        .search-input-group {
            max-width: 100%;
        }

        .search-input {
            font-size: 0.9rem;
            padding: 0.65rem 1rem 0.65rem 2.5rem;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .table-container {
            padding: 1rem;
        }

        .table-custom {
            font-size: 0.85rem;
        }

        .table-custom th,
        .table-custom td {
            padding: 0.75rem 0.5rem;
        }

        .btn-action {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }

        .mobile-stack {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-hidden {
            display: none;
        }

        .description-truncate {
            max-width: 200px;
            -webkit-line-clamp: 3;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .table-container {
            padding: 0.75rem;
            overflow-x: auto;
        }

        .table-responsive-custom {
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .btn-create {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .course-image, .image-placeholder {
            width: 60px;
            height: 45px;
        }
    }
</style>

<div class="courses-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-book me-2"></i>Gestión de Cursos</h1>
                </div>
                @if(auth()->user()->isAdmin())
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.courses.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Nuevo Curso
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-custom mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-custom mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Buscador -->
        @if($courses->count() > 0)
            <div class="search-container">
                <div class="search-input-group">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" 
                           id="searchInput" 
                           class="search-input" 
                           placeholder="Buscar curso por nombre..."
                           autocomplete="off">
                    <button type="button" class="clear-search" id="clearSearch">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Tabla de cursos -->
        <div class="table-responsive">
            @if($courses->count() > 0)
                <div class="table-responsive table-responsive-custom" id="tableContainer">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Horario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>
                                        @if ($course->image)
                                            <img src="{{ asset('storage/' . $course->image) }}" 
                                                 alt="{{ $course->title }}" 
                                                 class="course-image"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="image-placeholder" style="display: none;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @else
                                            <div class="image-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-primary-custom fw-bold">{{ $course->title }}</div>
                                        <small class="text-secondary-custom mobile-hidden">
                                            ID: #{{ $course->id }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($course->schedule)
                                            <i class="bi bi-clock me-1"></i>{{ $course->schedule }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 mobile-stack">
                                            <a href="{{ route('admin.courses.edit', $course->id) }}" 
                                               class="btn-action btn-edit"
                                               title="Editar curso">
                                                <i class="bi bi-pencil"></i>
                                                <span class="mobile-hidden">Editar</span>
                                            </a>
                                            <form action="{{ route('admin.courses.delete', $course->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar el curso \"{{ $course->title }}\"? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @if(auth()->user()->isAdmin())
                                                <button type="submit" class="btn-action btn-delete" title="Eliminar curso">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="mobile-hidden">Eliminar</span>
                                                </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mensaje de sin resultados (oculto por defecto) -->
                <div class="no-results" id="noResults" style="display: none;">
                    <i class="bi bi-search"></i>
                    <h5>No se encontraron cursos</h5>
                    <p>No hay cursos que coincidan con "<span id="searchTerm"></span>"</p>
                    <button class="btn-create" onclick="document.getElementById('clearSearch').click();">
                        <i class="bi bi-x-circle"></i> Limpiar búsqueda
                    </button>
                </div>

                <!-- Información de paginación - Solo si es paginator -->
                @if(method_exists($courses, 'hasPages') && $courses->hasPages())
                    <div class="mt-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-secondary-custom">
                                    Mostrando {{ $courses->count() }} cursos
                                    @if(method_exists($courses, 'total'))
                                        de {{ $courses->total() }}
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Paginación de cursos" class="d-flex justify-content-end">
                                    <ul class="pagination pagination-sm">
                                        {{ $courses->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Estado vacío -->
                <div class="empty-state">
                    <i class="bi bi-book"></i>
                    <h5 class="text-secondary-custom">No hay cursos creados</h5>
                    <p class="text-secondary-custom mb-4">Comienza creando tu primer curso para ofrecer a los estudiantes.</p>
                    <a href="{{ route('admin.courses.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Crear Primer Curso
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const tableBody = document.querySelector('.table-custom tbody');
    const tableContainer = document.getElementById('tableContainer');
    const noResults = document.getElementById('noResults');
    const searchTerm = document.getElementById('searchTerm');

    // Ordenar cursos alfabéticamente al cargar
    if (tableBody) {
        sortTableAlphabetically();
    }

    // Función para ordenar la tabla alfabéticamente
    function sortTableAlphabetically() {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        rows.sort((a, b) => {
            const titleA = a.querySelector('.fw-bold').textContent.trim().toLowerCase();
            const titleB = b.querySelector('.fw-bold').textContent.trim().toLowerCase();
            return titleA.localeCompare(titleB);
        });
        
        rows.forEach(row => tableBody.appendChild(row));
    }

    // Función de búsqueda
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('tr');
            let visibleCount = 0;

            // Mostrar/ocultar botón de limpiar
            if (searchValue.length > 0) {
                clearSearch.classList.add('active');
            } else {
                clearSearch.classList.remove('active');
            }

            // Filtrar filas
            rows.forEach(row => {
                const title = row.querySelector('.fw-bold').textContent.toLowerCase();
                
                if (title.includes(searchValue)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Mostrar mensaje de sin resultados
            if (visibleCount === 0 && searchValue.length > 0) {
                tableContainer.style.display = 'none';
                noResults.style.display = 'block';
                searchTerm.textContent = searchInput.value;
            } else {
                tableContainer.style.display = 'block';
                noResults.style.display = 'none';
            }
        });

        // Limpiar búsqueda
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            clearSearch.classList.remove('active');
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => row.style.display = '');
            tableContainer.style.display = 'block';
            noResults.style.display = 'none';
            searchInput.focus();
        });

        // Limpiar con tecla Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                clearSearch.click();
            }
        });
    }

    // Animación suave para las filas de la tabla
    const tableRows = document.querySelectorAll('.table-custom tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
    });

    // Confirmación mejorada para eliminación
    const deleteForms = document.querySelectorAll('form[onsubmit]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const courseTitle = this.closest('tr').querySelector('.fw-bold').textContent;
            if (!confirm(`¿Estás seguro de eliminar el curso "${courseTitle}"?\n\nEsta acción eliminará permanentemente el curso y toda su información.`)) {
                e.preventDefault();
            }
        });
    });

    // Manejo de errores en imágenes
    const images = document.querySelectorAll('.course-image');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('image-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });
    });

    // Mejora de accesibilidad para móviles
    if (window.innerWidth < 768) {
        const actionButtons = document.querySelectorAll('.btn-action');
        actionButtons.forEach(btn => {
            btn.style.padding = '0.5rem 0.75rem';
            btn.style.fontSize = '0.8rem';
        });
    }

    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>
@endsection