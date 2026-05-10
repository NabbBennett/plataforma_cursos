@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<style>
    .cart-section {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .cart-header {
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .cart-item {
        background: var(--bg-secondary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .cart-item-image-container {
        align-items: center;
        justify-content: center;
        display: flex;
        padding: 1.5rem;
    }
    
    .cart-item-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .cart-item-content {
        align-items: center;
        padding: 1rem 0;
        flex: 1;
    }
    
    .course-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }
    
    .price-info {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    
    .weeks-info {
        background: var(--bg-primary);
        padding: 0.5rem;
        border-radius: 8px;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
    
    .weeks-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .weeks-input {
        width: 70px;
        text-align: center;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    
    .btn-weeks {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.2s ease;
    }
    
    .btn-weeks:hover {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-color: var(--btn-primary-bg);
    }
    
    .cart-item-total {
        text-align: right;
        padding: 1.5rem;
        border-left: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
    }
    
    .total-amount {
        font-weight: 700;
        font-size: 1.3rem;
        color: var(--success-color);
    }
    
    .btn-remove {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .btn-remove:hover {
        background: rgba(220, 53, 69, 0.1);
        transform: scale(1.1);
    }
    
    .summary-card {
        background: var(--bg-secondary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 2rem;
        position: sticky;
        top: 2rem;
    }
    
    .summary-title {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        font-size: 1.3rem;
    }
    
    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .summary-line:last-child {
        border-bottom: none;
    }
    
    .summary-total {
        font-weight: 700;
        font-size: 1.4rem;
        color: var(--text-primary);
    }
    
    .coupon-form {
        margin: 1.5rem 0;
    }
    
    .coupon-input {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    
    .btn-checkout {
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-cart-icon {
        font-size: 4rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    .btn-continue-shopping {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-continue-shopping:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .alert-coupon {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin: 1rem 0;
        border: none;
    }
    
    .coupon-applied {
        background: var(--success-color);
        color: white;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .coupon-info {
        display: flex;
        justify-content: between;
        align-items: center;
        gap: 1rem;
    }
    
    .coupon-details {
        flex: 1;
    }
    
    .coupon-code {
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .coupon-type {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .btn-remove-coupon {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-remove-coupon:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .coupon-amount {
    font-size: 0.8rem;
    opacity: 0.9;
    margin-top: 0.25rem;
}

.summary-line strong {
    color: var(--text-primary);
}

.btn-remove-coupon:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

    /* Estilos para móvil */
    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
        }
        
        .cart-item-image-container {
            width: 100%;
            margin: auto 0;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .cart-item-image {
            width: 100px;
            height: 100px;
        }
        
        .cart-item-content {
            padding: 1.25rem;
        }
        
        .cart-item-total {
            border-left: none;
            border-top: 1px solid var(--border-color);
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
        }
        
        .weeks-control {
            justify-content: center;
        }
        
        .summary-card {
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .cart-header h2 {
            font-size: 1.5rem;
        }
        
        .coupon-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .cart-item-content {
            padding: 1rem;
        }
        
        .course-title {
            font-size: 1.1rem;
        }
        
        .weeks-input {
            width: 60px;
        }
        
        .btn-weeks {
            width: 32px;
            height: 32px;
        }
        
        .total-amount {
            font-size: 1.1rem;
        }
        
        .summary-card {
            padding: 1.25rem;
        }
        
        .summary-title {
            font-size: 1.2rem;
        }
        
        .btn-checkout {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
        
        .empty-cart {
            padding: 3rem 1rem;
        }
        
        .empty-cart-icon {
            font-size: 3rem;
        }
    }
</style>

<div class="container mt-4 mb-5 cart-section" style="max-width: 1200px;">
    
    @if (empty($cart) || count($cart) === 0)
        <!-- Estado vacío -->
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="bi bi-cart-x"></i>
            </div>
            <h3 class="mb-3">Tu carrito está vacío</h3>
            <p class="text-muted mb-4">Agrega algunos cursos para comenzar tu aprendizaje</p>
            <a href="{{ route('store') }}" class="btn btn-continue-shopping">
                <i class="bi bi-arrow-left me-2"></i>
                Continuar Comprando
            </a>
        </div>
    @else
        <div class="row">
            <!-- Lista de cursos en el carrito -->
            <div class="col-lg-8">
                @foreach($cart as $courseId => $item)
                    @php
                        $weeks = count($item['weeks']);
                        $totalCurso = $item['price_per_week'] * $weeks;
                        $userHasCourse = in_array($courseId, $userCourses ?? []);
                    @endphp
                    
                    <div class="cart-item d-flex flex-column flex-md-row">
                        <!-- Imagen del curso -->
                        <div class="cart-item-image-container">
                            @if(!empty($item['image_url']))
                                <img src="{{ $item['image_url'] }}" 
                                     class="cart-item-image" 
                                     alt="{{ $item['title'] }}">
                            @elseif(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                     class="cart-item-image" 
                                     alt="{{ $item['title'] }}">
                            @else
                                <div class="cart-item-image bg-secondary d-flex align-items-center justify-content-center text-white">
                                    <i class="bi bi-image fs-4"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Contenido del curso -->
                        <div class="cart-item-content">
                            <div class="course-title">{{ $item['title'] }}</div>
                            <div class="price-info">
                                <i class="bi bi-currency-dollar me-1"></i>
                                Precio por semana: ${{ number_format($item['price_per_week'], 2) }}
                            </div>
                            
                            <div class="weeks-info">
                                <i class="bi bi-check-circle me-1 text-success"></i>
                                Semanas compradas: <strong>{{ $item['weeks_compradas'] ?? 0 }}</strong>
                            </div>
                            
                            <!-- Control de semanas -->
                            <form action="{{ route('cart.update', $courseId) }}" method="POST" id="form-{{ $courseId }}">
                                @csrf
                                <div class="weeks-control">
                                    <span class="me-2 fw-medium">Semanas a comprar:</span>
                                    <button type="button" class="btn-weeks" onclick="changeWeeks('{{ $courseId }}', -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" 
                                           name="weeks_count" 
                                           id="weeks_count_{{ $courseId }}" 
                                           min="1" 
                                           max="{{ $item['max_weeks'] }}" 
                                           value="{{ $weeks }}" 
                                           class="form-control weeks-input">
                                    <button type="button" class="btn-weeks" onclick="changeWeeks('{{ $courseId }}', 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <span class="ms-2 text small">
                                        Máx: {{ $item['max_weeks'] }}
                                    </span>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Total y acciones -->
                        <div class="cart-item-total">
                            <div>
                                <div class="total-amount mb-2">
                                    ${{ number_format($totalCurso, 2) }}
                                </div>
                                <form action="{{ route('cart.remove', $courseId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove" title="Eliminar del carrito">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Resumen del pedido -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4 class="summary-title">Resumen del Pedido</h4>
                    
                    @php
                        $subtotal = 0;
                        $extra = 0;
                        $userCourses = auth()->user()->purchases->pluck('course_id')->toArray();
                        
                        foreach($cart as $courseId => $item) {
                            $weeks = count($item['weeks']);
                            $subtotal += $item['price_per_week'] * $weeks;
                            
                            if (!in_array($courseId, $userCourses)) $extra += 250;
                        }
                        
                        // Obtener información del cupón aplicado
                        $appliedCoupon = session('applied_coupon');
                        $discount = session('discount') ?? 0;
                        $total = $subtotal + $extra - $discount;
                    @endphp

                    <div class="summary-line">
                        <span>Semanas:</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if($extra > 0)
                    <div class="summary-line">
                        <span>
                            <i class="bi bi-plus-circle me-1"></i>
                            Inscripción:
                        </span>
                        <span>${{ number_format($extra, 2) }}</span>
                    </div>
                    @endif
                    
                    @if($discount > 0)
                        <div class="summary-line text-success">
                            <span>
                                <i class="bi bi-tag me-1"></i>
                                Descuento:
                            </span>
                            <span>- ${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                    
                    <div class="summary-line summary-total">
                        <span>Total a pagar:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <!-- Sección de Cupones -->
                    <div class="coupon-form">
                        @if(session('coupon_error'))
                            <div class="alert alert-danger alert-coupon">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('coupon_error') }}
                            </div>
                            @php session()->forget('coupon_error'); @endphp
                        @endif
                        
                        @if(session('coupon_success'))
                            <div class="alert alert-success alert-coupon">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('coupon_success') }}
                            </div>
                        @endif
                        
                        @if($appliedCoupon)
                            <!-- Cupón aplicado -->
                            <div class="coupon-applied">
                                <div class="coupon-info">
                                    <div class="coupon-details">
                                        <div class="coupon-code">
                                            <i class="bi bi-ticket-perforated me-2"></i>
                                            {{ $appliedCoupon['code'] }}
                                        </div>
                                        <div class="coupon-type">
                                            @if($appliedCoupon['type'] === 'percentage')
                                                {{ $appliedCoupon['value'] }}% de descuento
                                            @else
                                                Cupón de ${{ number_format($appliedCoupon['value'], 2) }} 
                                            @endif
                                        </div>
                                        <div class="coupon-amount small">
                                            <strong>Descuento aplicado: ${{ number_format($appliedCoupon['discount_amount'], 2) }}</strong>
                                        </div>
                                        @if($appliedCoupon['type'] === 'fixed' && $appliedCoupon['discount_amount'] < $appliedCoupon['value'])
                                            <div class="coupon-note small text-warning">
                                                <i class="bi bi-info-circle me-1"></i>
                                                El descuento se ajustó al subtotal de semanas disponible
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('coupon.remove') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-remove-coupon" title="Remover cupón">
                                            <i class="bi bi-x-lg me-1"></i>Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Formulario para aplicar cupón -->
                            <form action="{{ route('coupon.apply') }}" method="POST">
                                @csrf
                                <label class="form-label small fw-medium mb-2">
                                    <i class="bi bi-ticket-perforated me-1"></i>
                                    ¿Tienes un cupón?
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                        name="coupon" 
                                        class="form-control coupon-input" 
                                        placeholder="Ingresa tu código"
                                        value="{{ old('coupon') }}"
                                        required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </div>
                                <small class="form-text text mt-1">
                                    El descuento se aplica sobre el total de semanas
                                </small>
                            </form>
                        @endif
                    </div>
                    
                    <!-- Checkout -->
                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function changeWeeks(courseId, delta) {
    const input = document.getElementById('weeks_count_' + courseId);
    let value = parseInt(input.value) || 1;
    const min = parseInt(input.min);
    const max = parseInt(input.max);
    value += delta;
    if (value < min) value = min;
    if (value > max) value = max;
    input.value = value;
    
    // Enviar formulario automáticamente
    document.getElementById('form-' + courseId).submit();
}

// Efectos hover para elementos interactivos
document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.querySelectorAll('.cart-item');
    const removeButtons = document.querySelectorAll('.btn-remove');
    
    removeButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Auto-ocultar mensajes después de 5 segundos
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const fadeEffect = setInterval(() => {
                if (!alert.style.opacity) {
                    alert.style.opacity = 1;
                }
                if (alert.style.opacity > 0) {
                    alert.style.opacity -= 0.1;
                } else {
                    clearInterval(fadeEffect);
                    alert.style.display = 'none';
                }
            }, 50);
        });
    }, 5000);
});
</script>
@endsection