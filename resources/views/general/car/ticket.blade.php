@extends('layouts.app')

@section('title', 'Comprobante de Compra')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold text-primary mb-2">Comprobante de Compra</h1>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <span class="badge bg-success">Compra Exitosa</span>
                    <span class="text-muted small">#{{ substr(md5(uniqid()), 0, 8) }}</span>
                </div>
            </div>

            <div class="row g-3">
                <!-- Información del Usuario -->
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-person me-2"></i>Información del Comprador
                            </h5>
                            <div class="mb-2">
                                <strong>Nombre:</strong>
                                <div class="text-primary">{{ auth()->user()->name }}</div>
                            </div>
                            <div class="mb-2">
                                <strong>Correo:</strong>
                                <div class="text-primary">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-credit-card me-2"></i>Métodos de Pago
                            </h5>
                            
                            <div class="row g-2">
                                <!-- Transferencia Bancaria -->
                                <div class="col-12 mb-3">
                                    <div class="payment-method border rounded p-3">
                                        <h6 class="fw-semibold mb-3 text-center">
                                            <i class="bi bi-bank2 text-primary me-2"></i>Transferencia Bancaria
                                        </h6>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Número de tarjeta:</small>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="text" class="form-control payment-input" value="1234 5678 9012 3456" readonly>
                                                <button class="btn btn-outline-secondary copy-btn" type="button" onclick="copyToClipboard('1234567890123456')">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Nombre del destinatario:</small>
                                            <div class="fw-semibold text-center small">Instituto Resiliencia</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pago en OXXO -->
                                <div class="col-12">
                                    <div class="payment-method border rounded p-3">
                                        <h6 class="fw-semibold mb-3 text-center">
                                            <i class="bi bi-shop text-warning me-2"></i>Pago en OXXO
                                        </h6>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Número de tarjeta:</small>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="text" class="form-control payment-input" value="9876 5432 1098 7654" readonly>
                                                <button class="btn btn-outline-secondary copy-btn" type="button" onclick="copyToClipboard('9876543210987654')">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Nombre del destinatario:</small>
                                            <div class="fw-semibold text-center small">Instituto Resiliencia</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cursos Comprados -->
                <div class="col-12 col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-cart-check me-2"></i>Cursos Comprados
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Curso</th>
                                            <th class="text-center">Semanas</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $cart = session('last_ticket.cart', []);
                                        @endphp
                                        @foreach($cart as $item)
                                            @php
                                                $subtotal = $item['price_per_week'] * count($item['weeks']);
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $item['title'] }}</div>
                                                    <small class="text-muted">${{ number_format($item['price_per_week'], 2) }} por semana</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ count($item['weeks']) }}</span>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    ${{ number_format($subtotal, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-group-divider">
                                        <tr>
                                            <td colspan="2" class="text-end fw-bold">Total:</td>
                                            <td class="text-end fw-bold text-success h5">
                                                ${{ number_format($total, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Instrucciones Importantes -->
                    <div class="alert alert-warning mb-0">
                        <div class="d-flex flex-column flex-md-row">
                            <div class="me-md-3 mb-2 mb-md-0 text-center">
                                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                            </div>
                            <div class="text-center text-md-start">
                                <h6 class="alert-heading mb-2">¡Importante! Sigue estos pasos:</h6>
                                <ol class="mb-2 ps-3">
                                    <li class="mb-1">Realiza el pago por el monto total indicado</li>
                                    <li class="mb-1">Toma foto o captura de pantalla del comprobante</li>
                                    <li class="mb-1">Envía tu comprobante por WhatsApp para activar tu curso</li>
                                </ol>
                                <div class="text-center">
                                    <a href="https://wa.me/5211234567890" target="_blank" class="btn btn-success btn-sm">
                                        <i class="bi bi-whatsapp me-1"></i> Enviar comprobante por WhatsApp
                                    </a>
                                </div>
                                <hr class="my-2">
                                <small class="text-muted">
                                    <strong>NOTA:</strong> Tu curso se habilitará una vez que envíes tu comprobante y sea verificado por administración.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="bi bi-house me-1"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const btn = event.target;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i>';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
<style>
/* Estilos base que usan las variables CSS */
.card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    color: var(--text-primary); /* Añadido para heredar color de texto */
}

.card-body {
    color: var(--text-primary); /* Añadido para heredar color de texto */
}

.card-title, .card-text {
    color: var(--text-primary) !important; /* Fuerza el color del texto */
}

.table {
    color: var(--text-primary);
    background-color: var(--bg-primary);
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color: var(--bg-secondary);
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary); /* Añadido para texto de headers */
}

.table td {
    border-bottom: 1px solid var(--border-color);
    background-color: var(--bg-primary);
    color: var(--text-primary); /* Añadido para texto de celdas */
}

.table-hover tbody tr:hover {
    background-color: var(--bg-secondary);
}

.table-group-divider {
    border-top-color: var(--border-color);
}

.input-group .form-control.payment-input {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.payment-method {
    background-color: var(--bg-secondary);
    border-color: var(--border-color) !important;
    color: var(--text-primary); /* Añadido para texto en métodos de pago */
}

.alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-left: 4px solid #ffc107;
    border-color: var(--border-color);
    color: var(--text-primary);
}

.btn-primary {
    background-color: var(--btn-primary-bg);
    border-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

.btn-primary:hover {
    background-color: var(--btn-outline-hover-bg);
    border-color: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
}

.btn-outline-primary {
    border-color: var(--btn-outline-border);
    color: var(--btn-outline-text);
}

.btn-outline-primary:hover {
    background-color: var(--btn-outline-hover-bg);
    border-color: var(--btn-outline-hover-bg);
    color: var(--btn-outline-hover-text);
}

.btn-outline-secondary {
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.text-primary {
    color: var(--btn-primary-bg) !important;
}

.text-muted {
    color: var(--text-secondary) !important;
}

.border-top {
    border-top-color: var(--border-color) !important;
}

.border {
    border-color: var(--border-color) !important;
}

/* Asegurar que todos los textos usen el color correcto */
strong, h1, h2, h3, h4, h5, h6, p, span, div, li {
    color: var(--text-primary);
}

/* Específico para elementos dentro de cards */
.card strong, 
.card h1, 
.card h2, 
.card h3, 
.card h4, 
.card h5, 
.card h6, 
.card p, 
.card span, 
.card div, 
.card li {
    color: var(--text-primary);
}

/* Estilos específicos para modo oscuro */
body.dark-mode .table-light {
    background-color: var(--dark-100) !important;
}

body.dark-mode .alert-warning {
    background-color: rgba(255, 193, 7, 0.15);
}

body.dark-mode .payment-method {
    background-color: var(--dark-50);
}

/* Estilos específicos para modo claro */
body.light-mode .table-light {
    background-color: var(--light-50) !important;
}

body.light-mode .payment-method {
    background-color: var(--light-50);
}

/* Mejoras para móvil */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .input-group .form-control {
        font-size: 0.8rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
    }
    
    .h3 {
        font-size: 1.5rem;
    }
}

@media print {
    .btn, .alert, .input-group {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
    
    .text-primary {
        color: #000 !important;
    }
}
</style>
@endsection