@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container mt-4" style="max-width: 1100px;">
    <h2 class="mb-4">Mi Carrito</h2>
    @if (empty($cart) || count($cart) === 0)
        <p>No tienes cursos en el carrito.</p>
    @else
    
    <div class="row">
        <!-- Carrito -->
        <div class="col-md-8">
            @foreach($cart as $courseId => $item)
                @php
                    $weeks = count($item['weeks']);
                    $totalCurso = $item['price_per_week'] * $weeks;
                    $userHasCourse = in_array($courseId, $userCourses ?? []);
                @endphp
                <div class="card mb-3 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-3 text-center">
                            @if(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid rounded shadow" alt="Imagen del curso" style="width:100%;max-width:400px;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width:120px;height:120px;border-radius:8px;margin:1rem auto;">Sin imagen</div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                <div>
                                    <div class="fw-bold fs-5">{{ $item['title'] }}</div>
                                    <div class="text-muted mb-2">Precio/semana: ${{ number_format($item['price_per_week'], 2) }}</div>
                                    @php
                                        // Calcula semanas ya compradas y el máximo permitido
                                        $weeksTotal = $item['max_weeks'] + ($item['weeks_compradas'] ?? 0);
                                        $weeksCompradas = isset($item['weeks_compradas']) ? $item['weeks_compradas'] : 0;
                                    @endphp
                                    <div class="text-muted mb-2 small">
                                        SEMANAS YA COMPRADAS: <span class="fw-bold">{{ $item['weeks_compradas'] ?? 0 }}</span>
                                    </div>
                                    <form action="{{ route('cart.update', $courseId) }}" method="POST" class="d-inline-flex align-items-center" id="form-{{ $courseId }}">
                                        @csrf
                                        <span class="me-2">Semanas:</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeWeeks('{{ $courseId }}', -1)">-</button>
                                        <input type="number" name="weeks_count" id="weeks_count_{{ $courseId }}" min="1" max="{{ $item['max_weeks'] }}" value="{{ $weeks }}" class="form-control mx-1" style="width: 60px; display:inline-block;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeWeeks('{{ $courseId }}', 1)">+</button>
                                    </form>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold fs-6 mb-2">Total: ${{ number_format($totalCurso, 2) }}</div>
                                    <form action="{{ route('cart.remove', $courseId) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-link text-danger fs-4 p-0" title="Quitar del carrito">&times;</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Resumen -->
        <div class="col-md-4">
            @php
                $subtotal = 0;
                $extra = 0;
                foreach($cart as $courseId => $item) {
                    $weeks = count($item['weeks']);
                    $subtotal += $item['price_per_week'] * $weeks;
                    if (!in_array($courseId, $userCourses ?? [])) $extra += 200;
                }
                $discount = session('discount') ?? 0;
                $total = $subtotal + $extra - $discount;
            @endphp
            <div class="card p-4 mb-3 shadow-sm">
                <h5 class="mb-3">Resumen</h5>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Inscripción</span>
                    <span>${{ number_format($extra, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Descuento cupón</span>
                    <span class="text-success">- ${{ number_format($discount, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                @if(session('coupon_error'))
                    <div class="alert alert-danger py-1 my-2">{{ session('coupon_error') }}</div>
                    @php
                        session()->forget('coupon_error');
                    @endphp
                @endif
                @if(session('coupon_success'))
                    <div class="alert alert-success py-1 my-2">{{ session('coupon_success') }}</div>
                @endif
                <form action="{{ route('cart.coupon') }}" method="POST" class="mb-3 mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="coupon" class="form-control" placeholder="Código de cupón" required>
                        <button class="btn btn-outline-secondary" type="submit">Aplicar</button>
                    </div>
                </form>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button class="btn btn-success w-100">Confirmar compra</button>
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
    document.getElementById('form-' + courseId).submit();
}
</script>
@endsection
