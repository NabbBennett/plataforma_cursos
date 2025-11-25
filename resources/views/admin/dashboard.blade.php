@extends('layouts.admin')

@section('title', 'Dashboard de Administrador')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row g-4">
        @if(auth()->user()->isAdmin() || auth()->user()->isAyudante())
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
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isMaestro())
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
        @endif

        @if(auth()->user()->isAdmin())
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
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isAyudante())
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
        @endif
    </div>    
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Solo generar gráfica si hay datos visibles
        const stats = {
            users: {{ $users }},
            courses: {{ $courses }},
            exams: {{ $exams }},
            resources: {{ $resources }},
            coupons: {{ $coupons ?? 0 }},
            sales: {{ $sales }}
        };

        const labels = [];
        const data = [];
        const colors = [];

        if (stats.users > 0) {
            labels.push('Usuarios');
            data.push(stats.users);
            colors.push('#3498db');
        }

        if (stats.courses > 0) {
            labels.push('Servicios');
            data.push(stats.courses);
            colors.push('#27ae60');
        }

        if (stats.exams > 0) {
            labels.push('Exámenes');
            data.push(stats.exams);
            colors.push('#f39c12');
        }

        if (stats.resources > 0) {
            labels.push('Recursos');
            data.push(stats.resources);
            colors.push('#9b59b6');
        }

        if (stats.coupons > 0) {
            labels.push('Cupones');
            data.push(stats.coupons);
            colors.push('#16a085');
        }

        if (stats.sales > 0) {
            labels.push('Ventas');
            data.push(stats.sales);
            colors.push('#e74c3c');
        }

        if (labels.length > 0) {
            const ctx = document.getElementById('chartUsuariosCursos').getContext('2d');
            const isDarkMode = document.body.classList.contains('dark-mode');
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = isDarkMode ? '#FAFAFA' : '#171717';
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Totales',
                        data: data,
                        backgroundColor: colors,
                        borderColor: colors.map(color => color.replace('0.8', '1')),
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
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
                            grid: { color: gridColor },
                            ticks: {
                                font: { size: 12 },
                                color: textColor
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 12 },
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
        }
    });
</script>
@endsection
@endsection