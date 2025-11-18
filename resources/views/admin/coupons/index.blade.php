@extends('layouts.admin')

@section('title', 'Gestión de Cupones')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Cupones</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Crear Cupón
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Usos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td><code>{{ $coupon->code }}</code></td>
                            <td>
                                <span class="badge bg-{{ $coupon->discount_type === 'percentage' ? 'info' : 'warning' }}">
                                    {{ $coupon->discount_type === 'percentage' ? 'Porcentaje' : 'Fijo' }}
                                </span>
                            </td>
                            <td>
                                @if($coupon->discount_type === 'percentage')
                                    {{ $coupon->discount_value }}%
                                @else
                                    ${{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </td>
                            <td>
                                {{ $coupon->used_count }} 
                                @if($coupon->max_uses)
                                    / {{ $coupon->max_uses }}
                                @else
                                    / ∞
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $coupon->is_active ? 'success' : 'danger' }}">
                                    {{ $coupon->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar cupón?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay cupones registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection