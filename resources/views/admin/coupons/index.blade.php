@extends('layouts.admin')

@section('title', 'Gestión de Cupones')

@section('content')
<div class="container-fluid">
    <!-- Header -->

    <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-file-text me-2"></i>Gestión de Exámenes</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.coupons.create') }}" class="btn-create">
                        <i class="bi bi-plus-circle"></i> Crear Cupón
                    </a>
                </div>
            </div>
    </div>

    <!-- Tabla de cupones -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2 text-secondary"></i>Lista de Cupones
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Código</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Usos</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr class="align-middle">
                            <!-- Código -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <code class="bg-light px-2 py-1 rounded border">{{ $coupon->code }}</code>
                                    @if($coupon->expires_at && $coupon->expires_at->isPast())
                                        <span class="badge bg-danger ms-2" title="Expirado">
                                            <i class="bi bi-clock-history me-1"></i>Expirado
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Tipo -->
                            <td>
                                <span class="badge bg-{{ $coupon->discount_type === 'percentage' ? 'info' : 'warning' }} rounded-pill">
                                    <i class="bi bi-{{ $coupon->discount_type === 'percentage' ? 'percent' : 'currency-dollar' }} me-1"></i>
                                    {{ $coupon->discount_type === 'percentage' ? 'Porcentaje' : 'Fijo' }}
                                </span>
                            </td>
                            
                            <!-- Valor -->
                            <td>
                                <span class="fw-bold text-{{ $coupon->discount_type === 'percentage' ? 'info' : 'warning' }}">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        ${{ number_format($coupon->discount_value, 2) }}
                                    @endif
                                </span>
                            </td>
                            
                            <!-- Usos -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px; max-width: 80px;">
                                        @php
                                            $usagePercentage = $coupon->max_uses ? ($coupon->used_count / $coupon->max_uses) * 100 : 0;
                                            $progressClass = $usagePercentage >= 80 ? 'bg-danger' : ($usagePercentage >= 50 ? 'bg-warning' : 'bg-success');
                                        @endphp
                                        <div class="progress-bar {{ $progressClass }}" style="width: {{ min($usagePercentage, 100) }}%"></div>
                                    </div>
                                    <small class="text-nowrap">
                                        {{ $coupon->used_count }} 
                                        @if($coupon->max_uses)
                                            / {{ $coupon->max_uses }}
                                        @else
                                            / ∞
                                        @endif
                                    </small>
                                </div>
                            </td>
                            
                            <!-- Estado -->
                            <td>
                                <span class="badge bg-{{ $coupon->is_active ? 'success' : 'danger' }} rounded-pill">
                                    <i class="bi bi-{{ $coupon->is_active ? 'check' : 'x' }}-circle me-1"></i>
                                    {{ $coupon->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       title="Editar cupón">
                                        <i class="bi bi-pencil"></i>
                                        <span class="d-none d-md-inline ms-1">Editar</span>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('¿Estás seguro de eliminar este cupón?')"
                                                title="Eliminar cupón">
                                            <i class="bi bi-trash"></i>
                                            <span class="d-none d-md-inline ms-1">Eliminar</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-tags fs-1 text-muted"></i>
                                    <h5 class="text-muted mt-3">No hay cupones registrados</h5>
                                    <p class="text-muted">Comienza creando tu primer cupón de descuento</p>
                                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle me-1"></i> Crear Primer Cupón
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginación -->
        @if($coupons->hasPages())
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ $coupons->firstItem() ?? 0 }} - {{ $coupons->lastItem() ?? 0 }} de {{ $coupons->total() }} cupones
                </div>
                <div>
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
}

.progress {
    border-radius: 10px;
    background-color: var(--bg-secondary);
}

.badge {
    font-size: 0.75em;
}

/* Encabezado adaptado a tema */
.page-header {
    background-color: var(--bg-secondary);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px rgba(0,0,0,0.12);
    color: var(--text-primary);
}

/* Botón crear usando variables */
.btn-create {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: 1px solid var(--btn-primary-bg);
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

/* Tabla */
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
}

.table td {
    background-color: transparent !important;
    vertical-align: middle;
    border-color: var(--border-color);
    color: var(--text-primary);
}

.table-hover tbody tr {
    background-color: transparent !important;
}

/* Code tag adaptado */
code {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

/* Card header/footer */
.card-header,
.card-footer {
    background-color: transparent !important;
    border-color: var(--border-color);
    color: var(--text-primary);
}

body.dark-mode .bg-light {
    background-color: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

/* Ajuste progres-bar colores en modo oscuro si deseas contraste */
body.dark-mode .progress-bar.bg-success { background-color: #3CA26E !important; }
body.dark-mode .progress-bar.bg-warning { background-color: #C89226 !important; }
body.dark-mode .progress-bar.bg-danger  { background-color: #C84A48 !important; }

/* Badges (solo texto principal se mantiene legible) */
body.dark-mode .badge.bg-info    { background-color: #0D6EFD !important; }
body.dark-mode .badge.bg-warning { background-color: #D99000 !important; }
body.dark-mode .badge.bg-success { background-color: #198754 !important; }
body.dark-mode .badge.bg-danger  { background-color: #DC3545 !important; }

/* Botones outline adaptados */
.btn-outline-primary {
    color: var(--btn-outline-text);
    border-color: var(--btn-outline-border);
}
.btn-outline-primary:hover {
    background-color: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
}
.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}
body.dark-mode .btn-outline-danger:hover {
    background-color: #dc3545;
    color: #000;
}

/* Paginación */
.pagination .page-link {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--text-primary);
}
.pagination .page-link:hover {
    background-color: var(--hover-bg);
}
.pagination .active .page-link {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border-color: var(--btn-primary-bg);
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background-color: var(--card-bg);
    }
    .card-body {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 12px;
        padding-right: 12px;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.775rem;
    }
    .btn-create {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
}
</style>
@endsection