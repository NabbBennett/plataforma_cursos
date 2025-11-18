@extends('layouts.admin')

@section('title', 'Gestión de Exámenes')

@section('content')
<style>
    .exams-container {
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

    .btn-view {
        background-color: #17a2b8;
        color: white;
    }

    .btn-view:hover {
        background-color: #138496;
        transform: translateY(-2px);
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
        background-color: #dc3545;
        color: white;
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

    .exam-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-duration {
        background-color: #6f42c1;
        color: white;
    }

    .badge-questions {
        background-color: #20c997;
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

    .stats-badge {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
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

    @media (max-width: 768px) {
        .exams-container {
            padding: 1rem 0;
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
    }
</style>

<div class="exams-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-file-text me-2"></i>Gestión de Exámenes</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.exams.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Crear Examen
                    </a>
                </div>
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

        <!-- Tabla de exámenes -->
        <div class="table-container">
            @if($exams->count() > 0)
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th class="mobile-hidden">Duración</th>
                                <th>Preguntas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td>
                                        <strong class="text-primary-custom">#{{ $exam->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-primary-custom fw-bold">{{ $exam->title }}</div>
                                        <small class="text-secondary-custom mobile-hidden">
                                            Creado: {{ $exam->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="mobile-hidden">
                                        <i class="bi bi-clock me-1"></i>{{ $exam->duration_minutes }} min
                                    </td>
                                    <td>
                                        <i class="bi bi-question-circle me-1"></i>{{ $exam->questions_count }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 mobile-stack">
                                            <a href="{{ route('admin.exams.preview', $exam->id) }}" 
                                               class="btn-action btn-view"
                                               title="Vista previa del examen">
                                                <i class="bi bi-eye"></i>
                                                <span class="mobile-hidden">Ver</span>
                                            </a>
                                            <a href="{{ route('admin.exams.edit', $exam->id) }}" 
                                               class="btn-action btn-edit"
                                               title="Editar examen">
                                                <i class="bi bi-pencil"></i>
                                                <span class="mobile-hidden">Editar</span>
                                            </a>
                                            <form action="{{ route('admin.exams.destroy', $exam->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar el examen \"{{ $exam->title }}\"? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Eliminar examen">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="mobile-hidden">Borrar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Información de paginación - Solo si es paginator -->
                @if(method_exists($exams, 'hasPages') && $exams->hasPages())
                    <div class="mt-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-secondary-custom">
                                    Mostrando {{ $exams->count() }} exámenes
                                    @if(method_exists($exams, 'total'))
                                        de {{ $exams->total() }}
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Paginación de exámenes" class="d-flex justify-content-end">
                                    <ul class="pagination pagination-sm">
                                        {{ $exams->links() }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Estado vacío -->
                <div class="empty-state">
                    <i class="bi bi-file-text"></i>
                    <h5 class="text-secondary-custom">No hay exámenes creados</h5>
                    <p class="text-secondary-custom mb-4">Comienza creando tu primer examen para evaluar a los estudiantes.</p>
                    <a href="{{ route('admin.exams.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Crear Primer Examen
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
            const examTitle = this.closest('tr').querySelector('.fw-bold').textContent;
            if (!confirm(`¿Estás seguro de eliminar el examen "${examTitle}"?\n\nEsta acción eliminará permanentemente el examen y todas sus preguntas.`)) {
                e.preventDefault();
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