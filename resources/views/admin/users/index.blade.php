@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<style>
    .users-container {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        min-height: calc(100vh - var(--header-height));
        padding: 2rem 0;
    }

    .page-header {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filter-card {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .table-container {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .table-custom {
        background-color: transparent;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .table-custom th {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        border-color: var(--border-color);
        font-weight: 600;
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-custom td {
        background-color: transparent;
        border-color: var(--border-color);
        padding: 1rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .table-custom tbody tr {
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--hover-bg);
    }

    .role-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin { background-color: #dc3545; color: white; }
    .role-ayudante { background-color: #fd7e14; color: white; }
    .role-maestro { background-color: #20c997; color: white; }
    .role-alumno { background-color: #6f42c1; color: white; }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-edit {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .btn-edit:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 1rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .pagination-custom .page-link {
        background-color: var(--bg-primary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .pagination-custom .page-item.active .page-link {
        background-color: var(--btn-primary-bg);
        border-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .pagination-custom .page-link:hover {
        background-color: var(--hover-bg);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .stats-badge {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }

    .text-primary-custom {
        color: var(--text-primary) !important;
    }

    .text-secondary-custom {
        color: var(--text-secondary) !important;
    }

    .search-box {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        color: var(--text-primary);
    }

    .search-box:focus {
        border-color: var(--btn-primary-bg);
        box-shadow: 0 0 0 0.2rem rgba(var(--btn-primary-bg-rgb), 0.25);
    }

    @media (max-width: 768px) {
        .users-container {
            padding: 1rem 0;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .table-container {
            padding: 1rem;
        }

        .table-custom {
            font-size: 0.85rem;
        }

        .table-custom th,
        .table-custom td {
            padding: 0.75rem 0.5rem;
        }

        .btn-action {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }

        .mobile-stack {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .table-container {
            padding: 0.75rem;
            overflow-x: auto;
        }

        .table-responsive-custom {
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
    }
</style>

<div class="users-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col mb-3 mb-md-0">
                    <h1 class="mb-2 d-inline"><i class="bi bi-people-fill me-2"></i>Gestión de Usuarios</h1>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="stats-badge">
                        Total: {{ $users->total() }} usuarios
                    </span>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="filter-card">
            <div class="col g-3">
                <!-- Búsqueda -->
                <div class="col mt-4">
                    <h6 class="mb-3 text-primary-custom"><i class="bi bi-search me-2"></i>Buscar usuario</h6>
                    <form method="GET" action="{{ route('admin.users') }}" class="row g-2">
                        <div class="col-md-8">
                            <input type="text" 
                                   name="search" 
                                   class="form-control search-box" 
                                   placeholder="Buscar por ID, nombre o correo..." 
                                   value="{{ request('search') }}"
                                   aria-label="Buscar usuarios">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filtro por rol -->
                <div class="col mt-4">
                    <h6 class="mb-3 text-primary-custom"><i class="bi bi-funnel-fill me-2"></i>Filtrar por rol</h6>
                    <form method="GET" action="{{ route('admin.users') }}" class="row g-2">
                        <div class="col-md-8">
                            <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                                <option value="">Todos los roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administradores</option>
                                <option value="ayudante" {{ request('role') === 'ayudante' ? 'selected' : '' }}>Ayudantes</option>
                                <option value="maestro" {{ request('role') === 'maestro' ? 'selected' : '' }}>Maestros</option>
                                <option value="alumno" {{ request('role') === 'alumno' ? 'selected' : '' }}>Alumnos</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                            </a>
                        </div>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>
            </div>

            <!-- Información de resultados -->
            <div class="row mt-3">
                <div class="col-12">
                    <small class="text-secondary-custom">
                        @if(request('search') || request('role'))
                            Mostrando {{ $users->count() }} de {{ $users->total() }} usuarios
                            @if(request('search'))
                                para "{{ request('search') }}"
                            @endif
                            @if(request('role'))
                                con rol {{ request('role') }}
                            @endif
                        @else
                            Mostrando {{ $users->count() }} usuarios por página
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-container">
            <div class="table-responsive table-responsive-custom">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <strong class="text-primary-custom">#{{ $user->id }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong class="text-primary-custom">{{ $user->name }}</strong>
                                            <br>
                                            <small class="text-secondary-custom">
                                                Registrado: {{ $user->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-primary-custom">{{ $user->email }}</div>
                                    <small class="text-secondary-custom">
                                        @if($user->email_verified_at)
                                            <i class="bi bi-patch-check-fill text-success"></i> Verificado
                                        @else
                                            <i class="bi bi-patch-exclamation text-warning"></i> No verificado
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($user->phone_mobile)
                                        <div class="text-primary-custom">{{ $user->phone_mobile }}</div>
                                    @else
                                        <span class="text-secondary-custom">No especificado</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $roleClass = 'role-' . $user->role;
                                        $roleNames = [
                                            'admin' => 'Administrador',
                                            'ayudante' => 'Ayudante', 
                                            'maestro' => 'Maestro',
                                            'alumno' => 'Alumno'
                                        ];
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">
                                        {{ $roleNames[$user->role] ?? ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 mobile-stack">
                                        <button type="button" 
                                                class="btn btn-action btn-edit" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                data-user-email="{{ $user->email }}"
                                                data-user-phone="{{ $user->phone_mobile }}"
                                                data-user-role="{{ $user->role }}"
                                                title="Editar usuario">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>

                                        <form action="{{ route('admin.users.delete', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar al usuario {{ $user->name }}? Esta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="role" value="{{ request('role') }}">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-action btn-delete" title="Eliminar usuario">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state text-center py-4">
                                        <i class="bi bi-people d-block mb-3" style="font-size: 3rem; opacity: 0.4;"></i>
                                        <h5 class="text-secondary-custom mb-2">No se encontraron usuarios</h5>
                                        <p class="text-secondary-custom mb-3">
                                            @if(request('search') || request('role'))
                                                No hay usuarios que coincidan con los criterios de búsqueda.
                                            @else
                                                No hay usuarios registrados en el sistema.
                                            @endif
                                        </p>
                                        <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Ver todos los usuarios
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
                <div class="mt-4">
                    <nav aria-label="Paginación de usuarios">
                        <ul class="pagination pagination-custom justify-content-center">
                            {{ $users->appends([
                                'search' => request('search'),
                                'role' => request('role')
                            ])->links() }}
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Incluir el modal de edición -->
@include('admin.users.edit')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación suave para las filas de la tabla
    const tableRows = document.querySelectorAll('.table-custom tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 100);
    });

    // Confirmación mejorada para eliminación
    const deleteForms = document.querySelectorAll('form[onsubmit]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const userName = this.closest('tr').querySelector('strong').textContent;
            if (!confirm(`¿Estás seguro de eliminar al usuario "${userName}"?\n\nEsta acción eliminará permanentemente todos los datos del usuario y no se puede deshacer.`)) {
                e.preventDefault();
            }
        });
    });

    // Mejora de accesibilidad para móviles
    if (window.innerWidth < 768) {
        const actionButtons = document.querySelectorAll('.btn-action');
        actionButtons.forEach(btn => {
            btn.style.padding = '0.5rem 0.75rem';
            btn.style.fontSize = '0.8rem';
        });
    }

    // Auto-enfocar el campo de búsqueda
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar notificación de éxito si existe
    const successMessage = "{{ session('success') }}";
    if (successMessage) {
        // Crear notificación toast
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong class="me-auto">Éxito</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${successMessage}
                </div>
            </div>
        `;
        document.body.appendChild(toast);
    }
});
</script>
@endif
@endsection