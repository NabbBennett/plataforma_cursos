
@extends('layouts.admin')

@section('title', 'Recursos')

@section('content')
<style>
    .resources-container {
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
        background-color: transparent;
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

    .btn-download {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .btn-download:hover {
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

    .badge-pdf {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-image {
        background-color: rgba(25, 135, 84, 0.2);
        color: #198754;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-total {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
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
        .resources-container {
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
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .table-container {
            padding: 0.75rem;
        }

        .btn-create {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="resources-container">
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-file-earmark me-2"></i>Gestión de Recursos</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.resources.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i>Subir Recurso
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="alert alert-success alert-custom mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-custom mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Tabla de recursos -->
        <div class="table-container">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary-custom">
                    <i class="bi bi-list me-2"></i>Lista de Recursos
                </h5>
                <span class="badge-total">
                    {{ $resources->total() }} recursos
                </span>
            </div>

            @if ($resources->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resources as $resource)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-primary-custom">{{ Str::limit($resource->title, 40) }}</h6>
                                            <small class="text-secondary-custom">ID: {{ $resource->id }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($resource->type === 'pdf')
                                            <span class="badge-pdf">
                                                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                            </span>
                                        @else
                                            <span class="badge-image">
                                                <i class="bi bi-image me-1"></i>Imagen
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-primary-custom">
                                                {{ $resource->created_at->format('d/m/Y') }}
                                            </span>
                                            <small class="text-secondary-custom">
                                                {{ $resource->created_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center mobile-stack">
                                            <a href="{{ Storage::url($resource->file_path) }}" 
                                               target="_blank" 
                                               class="btn-action btn-view"
                                               title="Vista previa">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                            <a href="{{ route('admin.resources.download', $resource) }}" 
                                               class="btn-action btn-download"
                                               title="Descargar">
                                                <i class="bi bi-download"></i> Descargar
                                            </a>
                                            <form action="{{ route('admin.resources.destroy', $resource) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-action btn-delete"
                                                        onclick="return confirm('¿Estás seguro de eliminar este recurso?')"
                                                        title="Eliminar">
                                                    <i class="bi bi-trash"></i> Borrar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="mb-2 mb-md-0">
                            <p class="mb-0 text-secondary-custom">
                                Mostrando <span class="fw-bold text-primary-custom">{{ $resources->firstItem() }}</span> 
                                a <span class="fw-bold text-primary-custom">{{ $resources->lastItem() }}</span> 
                                de <span class="fw-bold text-primary-custom">{{ $resources->total() }}</span> resultados
                            </p>
                        </div>
                        <div>
                            {{ $resources->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Estado vacío -->
                <div class="empty-state">
                    <i class="bi bi-folder-open"></i>
                    <h5 class="text-secondary-custom">No hay recursos disponibles</h5>
                    <p class="text-secondary-custom mb-4">Comienza subiendo tu primer archivo PDF o imagen</p>
                    <a href="{{ route('admin.resources.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Subir Primer Recurso
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

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