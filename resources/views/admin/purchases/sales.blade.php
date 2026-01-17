@extends('layouts.admin')

@section('title', 'Gestión de Ventas')

@section('content')
<style>
    .sales-container {
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

    .form-container {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
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

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .btn-primary-custom {
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

    .btn-primary-custom:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .form-control-custom, .form-select-custom {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        background-color: var(--bg-primary);
        border-color: var(--btn-primary-bg);
        color: var(--text-primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-label-custom {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .badge-status {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
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

    .divider-custom {
        border-top: 1px solid var(--border-color);
        margin: 2rem 0;
        opacity: 0.5;
    }

    .stats-badge {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Paginación personalizada */
    .pagination-custom .page-link {
        background-color: var(--bg-secondary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .pagination-custom .page-link:hover {
        background-color: var(--hover-bg);
        color: var(--text-primary);
    }

    .pagination-custom .page-item.active .page-link {
        background-color: var(--btn-primary-bg);
        border-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .pagination-custom .page-item.disabled .page-link {
        opacity: 0.6;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .sales-container {
            padding: 1rem 0;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .table-container, .form-container {
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
    }

    @media (max-width: 576px) {
        .page-header, .form-container {
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

        .btn-primary-custom {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="sales-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-graph-up me-2"></i>Gestión de Ventas</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="stats-badge">
                        <i class="bi bi-cart-check me-1"></i>
                        {{ $ventas->total() }} Ventas
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-custom mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-custom mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de activación -->
        <div class="form-container">
            <h4 class="mb-3 text-primary-custom">
                <i class="bi bi-plus-circle me-2"></i>Activación o compra manual
            </h4>
            <form method="POST" action="{{ route('admin.purchases.manual.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="user_id" class="form-label-custom">Alumno</label>
                        <input
                            type="text"
                            id="userSearch"
                            class="form-control form-control-custom mb-2"
                            placeholder="Buscar alumno por nombre o email...">
                        <select name="user_id" id="userSelect" class="form-select form-select-custom" required>
                            <option value="">-- Selecciona un alumno --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="course_id" class="form-label-custom">Curso</label>
                        <select name="course_id" class="form-select form-select-custom" id="courseSelect" required>
                            <option value="">-- Selecciona un curso --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" data-semanas="{{ $course->number_of_weeks }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="paid_weeks" class="form-label-custom">Semanas pagadas</label>
                        <input type="number" name="paid_weeks" id="paidWeeksInput" class="form-control form-control-custom" min="1" required>
                        <small class="text-secondary-custom" id="weeksLimitInfo"></small>
                    </div>
                </div>
                <button type="submit" class="btn-primary-custom mt-3">
                    <i class="bi bi-check-lg"></i> Guardar acceso
                </button>
            </form>
        </div>

        <div class="divider-custom"></div>

        <!-- Buscador -->
        <div class="table-container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="text-primary-custom mb-0">Ventas registradas</h5>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.purchases.sales') }}" class="d-flex gap-2">
                        <input
                            type="text"
                            id="searchInput"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control form-control-custom"
                            placeholder="Buscar por alumno o curso...">
                    </form>
                </div>
            </div>

            <!-- Tabla de ventas -->
            <div class="table-responsive">
                @if($ventas->count() > 0)
                    <div class="table-responsive table-responsive-custom">
                        <table class="table table-custom table-hover" id="ventasTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th class="mobile-hidden">Curso adquirido</th>
                                    <th>Semanas desbloqueadas</th>
                                    <th>Semanas pagadas</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    @php
                                        $courseStart = \Carbon\Carbon::parse($venta->course->start_date);
                                        $hoy = \Carbon\Carbon::today();
                                        $semanasTranscurridas = $courseStart->isFuture() ? 0 : $courseStart->diffInWeeks($hoy);
                                        $atraso = $semanasTranscurridas - $venta->paid_weeks;

                                        if ($atraso <= 0) {
                                            $estado = ['CORRIENTE', 'badge-success'];
                                        } elseif ($atraso <= 2) {
                                            $estado = ['PENDIENTE', 'badge-warning'];
                                        } else {
                                            $estado = ['ATRASADO', 'badge-danger'];
                                        }

                                        $maxSemanas = $venta->course?->number_of_weeks ?? $venta->course?->weeks()->count() ?? 20;
                                    @endphp
                                    <tr data-start-date="{{ $venta->course->start_date }}">
                                        <td>
                                            <div class="text-primary-custom fw-bold">{{ $venta->user->name }}</div>
                                            <small class="text-secondary-custom mobile-hidden">
                                                {{ $venta->user->phone_mobile ?? 'Sin teléfono' }} <br> {{ $venta->user->email }}
                                            </small>
                                        </td>
                                        <td class="mobile-hidden">
                                            <div class="text-primary-custom">{{ $venta->course->title }}</div>
                                            <small class="text-secondary-custom">
                                                Inicio: {{ $courseStart->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-custom field-editable" data-id="{{ $venta->id }}" data-field="weeks_unlocked">
                                                @for ($i = 0; $i <= $maxSemanas; $i++)
                                                    <option value="{{ $i }}" @selected($i == $venta->weeks_unlocked)>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-custom field-editable" data-id="{{ $venta->id }}" data-field="paid_weeks">
                                                @for ($i = 0; $i <= $maxSemanas; $i++)
                                                    <option value="{{ $i }}" @selected($i == $venta->paid_weeks)>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <span class="badge-status {{ $estado[1] }}" id="status-{{ $venta->id }}">{{ $estado[0] }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 mobile-stack">
                                                <form action="{{ route('admin.purchases.destroy', $venta->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar la venta de {{ $venta->user->name }} para el curso {{ $venta->course->title }}? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" title="Eliminar venta">
                                                        <i class="bi bi-trash"></i>
                                                        <span class="mobile-hidden">Eliminar</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Estado vacío -->
                    <div class="empty-state">
                        <i class="bi bi-cart-x"></i>
                        <h5 class="text-secondary-custom">No hay ventas registradas</h5>
                        <p class="text-secondary-custom mb-4">Comienza creando tu primera venta manualmente.</p>
                    </div>
                @endif
            </div>

            @if($ventas->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Paginación de ventas">
                        <ul class="pagination pagination-custom mb-0">
                            {{-- Anterior --}}
                            @if ($ventas->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-left me-1"></i> Anterior
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $ventas->previousPageUrl() }}" rel="prev">
                                        <i class="bi bi-chevron-left me-1"></i> Anterior
                                    </a>
                                </li>
                            @endif

                            {{-- Números de página (máximo 5 enlaces visibles) --}}
                            @php
                                $currentPage = $ventas->currentPage();
                                $lastPage = $ventas->lastPage();
                                $pages = [];

                                if ($lastPage <= 5) {
                                    // Si hay 5 páginas o menos, mostrar todas
                                    for ($i = 1; $i <= $lastPage; $i++) {
                                        $pages[] = $i;
                                    }
                                } else {
                                    // Siempre mostrar la primera página
                                    $pages[] = 1;

                                    if ($currentPage <= 3) {
                                        // Estamos al inicio: 1, 2, 3, 4, última
                                        $pages[] = 2;
                                        $pages[] = 3;
                                        $pages[] = 4;
                                    } elseif ($currentPage >= $lastPage - 2) {
                                        // Estamos al final: 1, última-3, última-2, última-1, última
                                        $pages[] = $lastPage - 3;
                                        $pages[] = $lastPage - 2;
                                        $pages[] = $lastPage - 1;
                                    } else {
                                        // Zona intermedia: 1, actual-1, actual, actual+1, última
                                        $pages[] = $currentPage - 1;
                                        $pages[] = $currentPage;
                                        $pages[] = $currentPage + 1;
                                    }

                                    // Siempre mostrar la última página
                                    $pages[] = $lastPage;

                                    // Eliminar duplicados y ordenar
                                    $pages = array_values(array_unique($pages));
                                    sort($pages);
                                }

                                $previousPage = null;
                            @endphp

                            @foreach ($pages as $page)
                                @if (!is_null($previousPage) && $page - $previousPage > 1)
                                    <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                @endif

                                @if ($page == $currentPage)
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $ventas->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif

                                @php $previousPage = $page; @endphp
                            @endforeach

                            {{-- Siguiente --}}
                            @if ($ventas->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $ventas->nextPageUrl() }}" rel="next">
                                        Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Búsqueda en tiempo real (lado servidor) con debounce
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let searchTimeout = null;
        searchInput.addEventListener('input', function () {
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            searchTimeout = setTimeout(() => {
                const form = this.form;
                if (form) {
                    form.submit();
                }
            }, 500); // espera 500ms después de dejar de escribir
        });
    }

    // Búsqueda local de alumnos en el select de "Alumno"
    const userSelect = document.getElementById('userSelect');
    const userSearch = document.getElementById('userSearch');
    if (userSelect && userSearch) {
        const allUserOptions = Array.from(userSelect.options);

        userSearch.addEventListener('input', function () {
            const term = this.value.toLowerCase();

            // Mantener siempre la primera opción como placeholder
            const placeholder = allUserOptions[0].cloneNode(true);
            userSelect.innerHTML = '';
            userSelect.appendChild(placeholder);

            allUserOptions.slice(1).forEach(option => {
                const text = option.textContent.toLowerCase();
                if (!term || text.includes(term)) {
                    userSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    }

    // Límite dinámico para semanas pagadas
    document.getElementById('courseSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const maxWeeks = selectedOption.dataset.semanas;
        const weeksInput = document.getElementById('paidWeeksInput');
        const infoText = document.getElementById('weeksLimitInfo');

        if (maxWeeks) {
            weeksInput.max = maxWeeks;
            infoText.textContent = `Máximo permitido: ${maxWeeks} semanas`;
        } else {
            weeksInput.removeAttribute('max');
            infoText.textContent = '';
        }

        if (parseInt(weeksInput.value) > parseInt(maxWeeks)) {
            weeksInput.value = maxWeeks;
        }
    });

    // Actualización inmediata con estatus visual dinámico
    document.querySelectorAll('.field-editable').forEach(select => {
        select.addEventListener('change', function () {
            const id = this.dataset.id;
            const field = this.dataset.field;
            const value = this.value;

            fetch("{{ route('admin.purchases.updateField') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ purchase_id: id, field: field, value: value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = select.closest('tr');
                    const weeksPaid = parseInt(row.querySelector('select[data-field="paid_weeks"]').value);
                    const startDateStr = row.dataset.startDate;
                    const courseStart = new Date(startDateStr);
                    const today = new Date();
                    const msPerWeek = 1000 * 60 * 60 * 24 * 7;
                    const weeksSinceStart = courseStart > today ? 0 : Math.floor((today - courseStart) / msPerWeek);
                    const atraso = weeksSinceStart - weeksPaid;

                    let estadoTexto = '';
                    let estadoColor = '';

                    if (atraso <= 0) {
                        estadoTexto = 'CORRIENTE';
                        estadoColor = 'badge-success';
                    } else if (atraso <= 2) {
                        estadoTexto = 'PENDIENTE';
                        estadoColor = 'badge-warning';
                    } else {
                        estadoTexto = 'ATRASADO';
                        estadoColor = 'badge-danger';
                    }

                    const badge = row.querySelector('.badge-status');
                    badge.classList.remove('badge-success', 'badge-danger', 'badge-warning');
                    badge.classList.add(estadoColor);
                    badge.textContent = estadoTexto;
                }
            });
        });
    });

    // Confirmación mejorada para eliminación
    const deleteForms = document.querySelectorAll('form[onsubmit]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const userName = this.closest('tr').querySelector('.fw-bold').textContent;
            const courseName = this.closest('tr').querySelector('.text-primary-custom').textContent;
            if (!confirm(`¿Estás seguro de eliminar la venta de "${userName}" para el curso "${courseName}"?\n\nEsta acción eliminará permanentemente el registro de venta y el acceso del usuario al curso.`)) {
                e.preventDefault();
            }
        });
    });

    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Mejora de accesibilidad para móviles
    if (window.innerWidth < 768) {
        const formSelects = document.querySelectorAll('.form-select-custom');
        formSelects.forEach(select => {
            select.style.padding = '0.5rem 0.75rem';
            select.style.fontSize = '0.85rem';
        });
    }
});
</script>
@endsection