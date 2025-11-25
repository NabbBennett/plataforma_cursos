@extends('layouts.admin')

@section('title', 'Editar Cupón')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Editar Cupón
            </h1>
            <p class="text-muted mb-0">Modifica la información del cupón</p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver a Cupones
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-tag me-2 text-secondary"></i>Editar Cupón: <code>{{ $coupon->code }}</code>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Código del Cupón -->
                            <div class="col-12 col-md-6">
                                <label for="code" class="form-label">
                                    Código del Cupón <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-tag text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('code') is-invalid @enderror" 
                                           id="code" 
                                           name="code" 
                                           value="{{ old('code', $coupon->code) }}" 
                                           placeholder="EJEMPLO20" 
                                           required>
                                </div>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Código único que los usuarios ingresarán al comprar.
                                </small>
                            </div>

                            <!-- Tipo de Descuento -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">
                                    Tipo de Descuento <span class="text-danger">*</span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="form-check card border h-100 discount-option">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="discount_type"
                                                   id="percentage"
                                                   value="percentage"
                                                   {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label w-100 h-100 d-flex flex-column justify-content-center align-items-center" for="percentage">
                                                <i class="bi bi-percent fs-4 text-info mb-2"></i>
                                                <span>Porcentaje</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check card border h-100 discount-option">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="discount_type"
                                                   id="fixed"
                                                   value="fixed"
                                                   {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 h-100 d-flex flex-column justify-content-center align-items-center" for="fixed">
                                                <i class="bi bi-currency-dollar fs-4 text-warning mb-2"></i>
                                                <span>Monto Fijo</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('discount_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Valor del Descuento -->
                            <div class="col-12 col-md-6">
                                <label for="discount_value" class="form-label">
                                    Valor del Descuento <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light" id="discount_prefix">
                                        <span id="discount_icon">
                                            @if($coupon->discount_type === 'percentage')
                                                <i class="bi bi-percent text-info"></i>
                                            @else
                                                <i class="bi bi-currency-dollar text-warning"></i>
                                            @endif
                                        </span>
                                    </span>
                                    <input type="number" 
                                           class="form-control @error('discount_value') is-invalid @enderror" 
                                           id="discount_value" 
                                           name="discount_value" 
                                           value="{{ old('discount_value', $coupon->discount_value) }}" 
                                           min="0" 
                                           step="{{ $coupon->discount_type === 'percentage' ? '1' : '0.01' }}"
                                           max="{{ $coupon->discount_type === 'percentage' ? '100' : '' }}"
                                           placeholder="0.00" 
                                           required>
                                </div>
                                @error('discount_value')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted" id="discount_help">
                                    @if($coupon->discount_type === 'percentage')
                                        Porcentaje de descuento a aplicar (ej: 20 para 20%).
                                    @else
                                        Monto fijo de descuento (ej: 50 para $50 de descuento).
                                    @endif
                                </small>
                            </div>

                            <!-- Límite de Usos -->
                            <div class="col-12 col-md-6">
                                <label for="max_uses" class="form-label">
                                    Límite de Usos
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-people text-muted"></i>
                                    </span>
                                    <input type="number" 
                                           class="form-control @error('max_uses') is-invalid @enderror" 
                                           id="max_uses" 
                                           name="max_uses" 
                                           value="{{ old('max_uses', $coupon->max_uses) }}" 
                                           min="1" 
                                           placeholder="Dejar vacío para ilimitado">
                                </div>
                                @error('max_uses')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Número máximo de veces que se puede usar este cupón.
                                    @if($coupon->max_uses)
                                        <br><strong>Usos actuales: {{ $coupon->used_count }} / {{ $coupon->max_uses }}</strong>
                                    @else
                                        <br><strong>Usos actuales: {{ $coupon->used_count }} / Ilimitado</strong>
                                    @endif
                                </small>
                            </div>

                            <!-- Fecha de Expiración -->
                            <div class="col-12 col-md-6">
                                <label for="expires_at" class="form-label">
                                    Fecha de Expiración
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </span>
                                    <input type="datetime-local" 
                                           class="form-control @error('expires_at') is-invalid @enderror" 
                                           id="expires_at" 
                                           name="expires_at" 
                                           value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}"
                                           min="{{ now()->format('Y-m-d\TH:i') }}">
                                </div>
                                @error('expires_at')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    @if($coupon->expires_at)
                                        @if($coupon->expires_at->isPast())
                                            <span class="text-danger">
                                                <i class="bi bi-exclamation-triangle"></i> Este cupón ya expiró.
                                            </span>
                                        @else
                                            Expira el {{ $coupon->expires_at->format('d/m/Y \a \l\a\s H:i') }}
                                        @endif
                                    @else
                                        Este cupón no tiene fecha de expiración.
                                    @endif
                                </small>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-end">
                                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary order-2 order-md-1">
                                        <i class="bi bi-x-circle me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary order-1 order-md-2">
                                        <i class="bi bi-check-circle me-1"></i> Actualizar Cupón
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountTypeRadios = document.querySelectorAll('input[name="discount_type"]');
    const discountIcon = document.getElementById('discount_icon');
    const discountPrefix = document.getElementById('discount_prefix');
    const discountHelp = document.getElementById('discount_help');
    const discountValueInput = document.getElementById('discount_value');

    function updateDiscountUI() {
        const selectedType = document.querySelector('input[name="discount_type"]:checked').value;
        
        if (selectedType === 'percentage') {
            discountIcon.innerHTML = '<i class="bi bi-percent text-info"></i>';
            discountPrefix.classList.remove('text-warning');
            discountPrefix.classList.add('text-info');
            discountHelp.textContent = 'Porcentaje de descuento a aplicar (ej: 20 para 20%).';
            discountValueInput.setAttribute('max', '100');
            discountValueInput.setAttribute('step', '1');
        } else {
            discountIcon.innerHTML = '<i class="bi bi-currency-dollar text-warning"></i>';
            discountPrefix.classList.remove('text-info');
            discountPrefix.classList.add('text-warning');
            discountHelp.textContent = 'Monto fijo de descuento (ej: 50 para $50 de descuento).';
            discountValueInput.removeAttribute('max');
            discountValueInput.setAttribute('step', '0.01');
        }
    }

    // Actualizar UI al cambiar tipo de descuento
    discountTypeRadios.forEach(radio => {
        radio.addEventListener('change', updateDiscountUI);
    });

    // Inicializar UI
    updateDiscountUI();
});

document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="discount_type"]');
    function markSelected() {
        document.querySelectorAll('.discount-option').forEach(c => c.classList.remove('selected'));
        const checked = document.querySelector('input[name="discount_type"]:checked');
        if (checked) checked.closest('.discount-option').classList.add('selected');
    }
    radios.forEach(r => r.addEventListener('change', () => { markSelected(); updateDiscountUI && updateDiscountUI(); }));
    markSelected();
});
</script>

<style>
/* Card y secciones totalmente transparentes */
.card,
.card-header,
.card-body,
.card-footer {
    background: transparent !important;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
}

/* Tabla transparente (si agregas una) */
.table,
.table thead,
.table tbody,
.table th,
.table td {
    background: transparent !important;
}
.table th,
.table td {
    color: var(--text-primary);
    border-color: var(--border-color);
}
.table-hover tbody tr:hover {
    background: var(--hover-bg);
}

/* Inputs transparentes */
.input-group-text {
    background: transparent !important;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    border-radius: 8px 0 0 8px;
}
.form-control {
    background: transparent !important;
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 0 8px 8px 0;
}
.form-control:focus {
    background: transparent !important;
    border-color: var(--btn-primary-bg);
    box-shadow: 0 0 0 .2rem rgba(0,0,0,.05);
}

/* Radios (opciones) */
.form-check .card {
    background: transparent !important;
    border: 1px solid var(--border-color);
    transition: .2s;
    cursor: pointer;
}
.form-check .card:hover {
    border-color: var(--btn-primary-bg);
    background: var(--hover-bg);
}
.form-check-input:checked + .card,
.form-check-input:checked + .form-check-label {
    box-shadow: 0 0 0 2px var(--btn-primary-bg) inset;
    border-radius: 8px;
}

/* Ocultar radio visualmente pero mantener accesible */
.form-check-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}

/* Base de la opción */
.discount-option {
    background: transparent !important;
    border: 1px solid var(--border-color);
    transition: .2s;
    cursor: pointer;
    min-height: 140px;
}

/* Hover ligero */
.discount-option:hover {
    border-color: var(--btn-primary-bg);
    background: var(--hover-bg);
}

/* Seleccionado: borde grueso */
.discount-option.selected {
    border: 3px solid var(--btn-primary-bg);
    background: var(--hover-bg);
    box-shadow: 0 0 0 2px var(--btn-primary-bg) inset;
}

/* Centrado del contenido */
.discount-option .form-check-label {
    margin: 0;
    font-weight: 600;
}

/* Quitar estilos previos si existían */
.form-check-input:checked + .form-check-label {
    box-shadow: none !important;
    border-radius: 0 !important;
}

/* Code */
code {
    background: transparent !important;
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 2px 6px;
    border-radius: 6px;
    font-size: .85em;
}

/* Botones */
.btn-primary {
    background: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border-color: var(--btn-primary-bg);
}
.btn-primary:hover {
    background: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
    border-color: var(--btn-outline-hover-bg);
}
.btn-outline-secondary {
    color: var(--btn-outline-text);
    border-color: var(--btn-outline-border);
}
.btn-outline-secondary:hover {
    background: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
    border-color: var(--btn-outline-hover-bg);
}

/* Texto secundario */
.text-muted,
.form-text { color: var(--text-secondary) !important; }

/* Switch */
.form-check-input[type=checkbox]:checked {
    background: var(--btn-primary-bg);
    border-color: var(--btn-primary-bg);
}

/* Responsive */
@media (max-width:768px){
    .btn { width:100%; }
    .form-check .card { padding:1rem .5rem; }
}
</style>
@endsection