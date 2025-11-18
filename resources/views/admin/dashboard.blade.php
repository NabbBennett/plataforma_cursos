@extends('layouts.admin')

@section('title', 'Dashboard de Administrador')

@section('content')
<div class="container-fluid">

    <!-- Stats Cards -->
    <div class="row g-4">
        <!-- Usuarios -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-users text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-people card-icon"></i>
                    <h6 class="card-title">USUARIOS</h6>
                    <div class="card-value">{{ $users }}</div>
                    <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>

        <!-- Servicios -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-services text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-briefcase card-icon"></i>
                    <h6 class="card-title">SERVICIOS</h6>
                    <div class="card-value">{{ $courses }}</div>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>

        <!-- Exámenes -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-exams text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-file-text card-icon"></i>
                    <h6 class="card-title">EXÁMENES</h6>
                    <div class="card-value">{{ $exams }}</div>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>

        <!-- Recursos -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-resources text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-folder card-icon"></i>
                    <h6 class="card-title">RECURSOS</h6>
                    <div class="card-value">{{ $resources }}</div>
                    <a href="{{ route('admin.resources.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>

        <!-- Cupones -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-coupons text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-tag card-icon"></i>
                    <h6 class="card-title">CUPONES</h6>
                    <div class="card-value">{{ $coupons ?? 0 }}</div>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>

        <!-- Ventas -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card stats-card bg-sales text-white">
                <div class="card-body position-relative">
                    <i class="bi bi-graph-up card-icon"></i>
                    <h6 class="card-title">VENTAS</h6>
                    <div class="card-value">{{ $sales }}</div>
                    <a href="{{ route('admin.purchases.sales') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-table"></i> Ver tabla
                    </a>
                </div>
            </div>
        </div>
    </div>    
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartUsuariosCursos').getContext('2d');
        
        // Colores dinámicos según el tema
        const isDarkMode = document.body.classList.contains('dark-mode');
        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        const textColor = isDarkMode ? '#FAFAFA' : '#171717';
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Usuarios', 'Servicios', 'Exámenes', 'Recursos', 'Cupones', 'Ventas'],
                datasets: [{
                    label: 'Totales',
                    data: [
                        {{ $users }}, 
                        {{ $courses }}, 
                        {{ $exams }}, 
                        {{ $resources }}, 
                        {{ $coupons ?? 0 }}, 
                        {{ $sales }}
                    ],
                    backgroundColor: [
                        '#3498db', '#27ae60', '#f39c12', 
                        '#9b59b6', '#16a085', '#e74c3c'
                    ],
                    borderColor: [
                        '#2980b9', '#229954', '#e67e22',
                        '#8e44ad', '#1abc9c', '#c0392b'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { 
                        display: false 
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? 'rgba(255, 255, 255, 0.9)' : 'rgba(0, 0, 0, 0.8)',
                        titleColor: isDarkMode ? '#000' : '#fff',
                        bodyColor: isDarkMode ? '#000' : '#fff',
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: textColor
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: textColor
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Actualizar gráfica cuando cambie el tema
        document.getElementById('themeToggle').addEventListener('click', function() {
            setTimeout(() => {
                location.reload(); // Recargar para actualizar colores del gráfico
            }, 100);
        });
    });
</script>
@endsection
@endsection