@extends('layouts.admin')

@section('title', 'Dashboard de Administrador')

@section('content')
<div class="row g-4">
    <!-- Tarjetas de resumen -->
    <div class="col-md-3">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text fs-4">{{ $users }}</p>
                <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm mt-2">Ver tabla</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">Cursos</h5>
                <p class="card-text fs-4">{{ $courses }}</p>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-light btn-sm mt-2">Ver tabla</a> {{-- Actualiza cuando tengas la ruta --}}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h5 class="card-title">Exámenes</h5>
                <p class="card-text fs-4">{{ $exams }}</p>
                <a href="{{ route('admin.exams.index') }}" class="btn btn-light btn-sm mt-2">Ver tabla</a> {{-- Actualiza cuando tengas la ruta --}}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger">
            <div class="card-body">
                <h5 class="card-title">Materiales</h5>
                <p class="card-text fs-4">{{ $resources}}</p>
                <a href="{{ route('admin.resources.index') }}" class="btn btn-light btn-sm mt-2">Ver tabla</a> {{-- Actualiza cuando tengas la ruta --}}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger">
            <div class="card-body">
                <h5 class="card-title">Ventas</h5>
                <p class="card-text fs-4">{{ $sales }}</p>
                <a href="{{ route('admin.purchases.sales') }}" class="btn btn-light btn-sm mt-2">Ver tabla</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger">
            <div class="card-body">
                <h5 class="card-title">Informacion</h5>
                <p class="card-text fs-4">{{ \App\Models\InstitutionInformation::exists() ? 1 : 0 }}</p>
                <a href="{{ route('admin.information.index') }}" class="btn btn-light btn-sm mt-2">Editar información</a>
            </div>
        </div>
    </div>
</div>

<!-- Gráfica -->
<div class="mt-5">
    <canvas id="chartUsuariosCursos" height="100"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartUsuariosCursos').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Usuarios', 'Cursos', 'Exámenes', 'Compras'],
                datasets: [{
                    label: 'Totales',
                    data: [{{ $users }}, {{ $courses }}, {{ $exams }}, {{ $sales }}],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
