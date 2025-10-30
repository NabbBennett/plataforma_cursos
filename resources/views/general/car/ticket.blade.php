@extends('layouts.app')

@section('title', 'Comprobante de Compra')

@section('content')
<div class="container mt-5">
    <h2>Comprobante de Compra</h2>
    <hr>

    @php
        $ticket = session('last_ticket');
        $user = $ticket['user'];
        $cart = $ticket['cart'];
    @endphp

    <div class="row">
        <div class="col-md-7">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Correo:</strong> {{ $user->email }}</p>

            <h5 class="mt-4">Cursos comprados</h5>
            <ul>
                @foreach($cart as $item)
                    <li>
                        <strong>{{ $item['title'] }}</strong><br>
                        Semanas pagadas: {{ count($item['weeks']) }}<br>
                        Total: ${{ number_format($item['price_per_week'] * count($item['weeks']), 2) }}
                    </li>
                @endforeach
            </ul>

            <div class="alert alert-info mt-4">
                <strong>Importante:</strong> Envía los datos de tu compra (nombre, curso, semanas pagadas) y tu comprobante a nuestro WhatsApp:<br>
                👉 <a href="https://wa.me/5211234567890" target="_blank">Enviar comprobante</a><br><br>
                <strong>NOTA:</strong> Tu curso se habilitará una vez mandes tu comprobante y te habilite administración
            </div>
        </div>

        <div class="col-md-5">
            <h5>Métodos de Pago</h5>
            <div class="card mb-3">
                <div class="card-header">Transferencia Bancaria</div>
                <div class="card-body">
                    <p><strong>Número de tarjeta:</strong> 1234 5678 9012 3456</p>
                    <p><strong>Nombre del destinatario:</strong> Instituto Resiliencia</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Pago en OXXO / Sucursal</div>
                <div class="card-body">
                    <p><strong>Número de tarjeta:</strong> 9876 5432 1098 7654</p>
                    <p><strong>Nombre del destinatario:</strong> Instituto Resiliencia</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
