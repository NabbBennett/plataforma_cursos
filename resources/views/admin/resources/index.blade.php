@extends('layouts.admin')

@section('title', 'Recursos')

@section('content')
<div class="container-fluid px-4 mt-4">
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
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Principal -->
    <div class="card border-0 shadow-lg card-custom">
        <div class="card-header py-3 border-bottom card-header-custom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0 text-primary-custom">
                        <i class="fas fa-list me-2"></i>Lista de Recursos
                    </h5>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="badge badge-primary-custom fs-6">
                        {{ $resources->total() }} recursos encontrados
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if ($resources->count() > 0)
                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead class="table-header-custom">
                            <tr>
                                <th class="px-4 py-3 border-0">Título</th>
                                <th class="px-4 py-3 border-0 text-center">Tipo</th>
                                <th class="px-4 py-3 border-0 text-center">Fecha</th>
                                <th class="px-4 py-3 border-0 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-body-custom">
                            @foreach ($resources as $resource)
                                <tr class="border-bottom table-row-custom">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0 fw-bold text-primary-custom">{{ Str::limit($resource->title, 40) }}</h6>
                                                <small class="text-secondary-custom">ID: {{ $resource->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($resource->type === 'pdf')
                                            <span class="badge badge-pdf fs-6 px-3 py-2">
                                                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                                            </span>
                                        @else
                                            <span class="badge badge-image fs-6 px-3 py-2">
                                                <i class="bi bi-image me-1"></i>Imagen
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-primary-custom">
                                                {{ $resource->created_at->format('d/m/Y') }}
                                            </span>
                                            <small class="text-secondary-custom">
                                                {{ $resource->created_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group btn-group-custom" role="group">
                                            <a href="{{ Storage::url($resource->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-action btn-view"
                                               data-bs-toggle="tooltip"
                                               title="Vista previa">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.resources.download', $resource) }}" 
                                               class="btn btn-action btn-download"
                                               data-bs-toggle="tooltip"
                                               title="Descargar">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <form action="{{ route('admin.resources.destroy', $resource) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-action btn-delete"
                                                        onclick="return confirm('¿Estás seguro de eliminar este recurso?')"
                                                        data-bs-toggle="tooltip"
                                                        title="Eliminar">
                                                        <i class="bi bi-trash"></i>
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
                <div class="card-footer py-4 card-footer-custom">
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
                <div class="text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-folder-open fs-1 mb-3 text-secondary-custom"></i>
                        <h4 class="mb-3 text-secondary-custom">No hay recursos disponibles</h4>
                        <p class="mb-4 text-secondary-custom">Comienza subiendo tu primer archivo PDF o imagen</p>
                        <a href="{{ route('admin.resources.create') }}" class="btn btn-primary-custom btn-lg px-4">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Subir Primer Recurso
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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

.page-header {
    background-color: var(--bg-secondary);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
/* Variables y utilidades */
.text-primary-custom { color: var(--text-primary) !important; }
.text-secondary-custom { color: var(--text-secondary) !important; }

.card-custom { 
    background-color: var(--card-bg); 
    border-radius: 15px;
}

.card-header-custom { 
    background-color: var(--card-bg) !important; 
    border-color: var(--border-color) !important; 
}

.card-footer-custom { 
    background-color: var(--card-bg); 
    border-color: var(--border-color) !important; 
}

/* ESTILOS ESPECÍFICOS PARA LA TABLA - CORREGIDOS */
.table-custom {
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
}

.table-header-custom { 
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
}

.table-header-custom th { 
    color: var(--text-secondary) !important; 
    border-color: var(--border-color) !important; 
    font-weight: 600;
    letter-spacing: 0.5px;
    background-color: transparent !important;
}

.table-body-custom {
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
}

.table-body-custom tr {
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
}

.table-body-custom td {
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
    border-color: var(--border-color) !important;
}

.table-row-custom { 
    border-color: var(--border-color) !important; 
    background-color: transparent !important;
    --bs-table-bg: transparent !important;
    transition: all 0.3s ease;
}

.table-row-custom:hover {
    background-color: var(--hover-bg) !important;
    transform: translateY(-1px);
}

/* Forzar transparencia en todos los elementos de la tabla */
.table > :not(caption) > * > * {
    background-color: transparent !important;
    border-color: var(--border-color) !important;
}

/* Botones principales */
.btn-primary-custom {
    background-color: var(--btn-primary-bg) !important;
    color: var(--btn-primary-text) !important;
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

/* Badges */
.badge-primary-custom {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.badge-pdf {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.badge-image {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

/* Icon containers */
.icon-container {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--hover-bg) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-color);
}

/* Enlaces */
.link-custom {
    color: var(--text-primary);
    transition: color 0.3s ease;
}

.link-custom:hover {
    color: var(--btn-primary-bg);
}

/* Grupo de botones de acción */
.btn-group-custom {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
}

.btn-action {
    border: none;
    border-radius: 0;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
    background-color: transparent;
    position: relative;
}

/* Botón Vista */
.btn-view {
    color: var(--btn-outline-text);
    border: 1px solid var(--btn-outline-border) !important;
    border-right: none !important;
}

.btn-view:hover {
    background-color: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
    transform: none;
}

/* Botón Descargar */
.btn-download {
    color: var(--btn-outline-text);
    border: 1px solid var(--btn-outline-border) !important;
    border-right: none !important;
    border-left: none !important;
}

.btn-download:hover {
    background-color: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
    transform: none;
}

/* Botón Eliminar */
.btn-delete {
    color: #dc3545;
    border: 1px solid #dc3545 !important;
    border-left: none !important;
}

.btn-delete:hover {
    background-color: #dc3545;
    color: white;
    transform: none;
}

/* Primer y último botón del grupo con bordes redondeados */
.btn-group-custom .btn-action:first-child {
    border-top-left-radius: 6px !important;
    border-bottom-left-radius: 6px !important;
}

.btn-group-custom .btn-action:last-child {
    border-top-right-radius: 6px !important;
    border-bottom-right-radius: 6px !important;
}

/* Paginación */
.pagination .page-link {
    background-color: var(--card-bg);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.pagination .page-item.active .page-link {
    background-color: var(--btn-primary-bg);
    border-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.pagination .page-link:hover {
    background-color: var(--hover-bg);
    border-color: var(--border-color);
    color: var(--text-primary);
}

/* Responsive */
@media (max-width: 768px) {
    .btn-group-custom {
        flex-direction: column;
        border-radius: 8px;
    }
    
    .btn-action {
        border: 1px solid var(--border-color) !important;
        border-radius: 0 !important;
        margin-bottom: -1px;
    }
    
    .btn-group-custom .btn-action:first-child {
        border-top-left-radius: 6px !important;
        border-top-right-radius: 6px !important;
        border-bottom-left-radius: 0 !important;
    }
    
    .btn-group-custom .btn-action:last-child {
        border-bottom-left-radius: 6px !important;
        border-bottom-right-radius: 6px !important;
        border-top-right-radius: 0 !important;
    }

    @media (max-width: 576px) {
        .btn-create {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection