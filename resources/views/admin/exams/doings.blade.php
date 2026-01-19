@extends('layouts.admin')
@section('title', 'Resultados - ' . $exam->title)

@section('content')
<style>
.results-container { background: var(--bg-secondary); border:1px solid var(--border-color); border-radius:15px; padding:2rem; }
.results-table { background: transparent; color: var(--text-primary); }
.results-table th { background: var(--bg-secondary); border-color: var(--border-color); font-size:.75rem; letter-spacing:.5px; text-transform:uppercase; }
.results-table td { background: transparent; border-color: var(--border-color); vertical-align: middle; }
.score-badge { padding:.35rem .6rem; border-radius:8px; font-size:.75rem; font-weight:600; }
.score-good { background:#198754; color:#fff; }
.score-mid { background:#ffc107; color:#000; }
.score-bad { background:#dc3545; color:#fff; }
.action-btn { padding:.4rem .7rem; font-size:.7rem; border-radius:6px; border:none; display:inline-flex; gap:.25rem; align-items:center; }
.btn-reset { background:#dc3545; color:#fff; }
.btn-reset:hover { background:#c82333; }
.empty { text-align:center; padding:3rem; color:var(--text-secondary); }

/* Paginación personalizada */
.pagination-custom .page-link {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.pagination-custom .page-link:hover {
    background-color: var(--hover-bg);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.pagination-custom .page-item.active .page-link {
    background-color: var(--btn-primary-bg);
    border-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

/* Modo oscuro (si usas clase en body) */
body.dark-mode .results-container,
body.dark-mode .results-table,
body.dark-mode .results-table th,
body.dark-mode .results-table td,
body.dark-mode .results-container h1,
body.dark-mode .results-container .empty {
    color:#fff !important;
}

body.dark-mode .results-table th {
    background: rgba(255,255,255,0.08);
}

body.dark-mode .results-table td {
    background: transparent;
}

body.dark-mode .results-table .text-secondary {
    color:#d0d0d0 !important;
}

/* Soporte si usas data-theme="dark" */
[data-theme="dark"] .results-container,
[data-theme="dark"] .results-table,
[data-theme="dark"] .results-table th,
[data-theme="dark"] .results-table td,
[data-theme="dark"] .results-container h1,
[data-theme="dark"] .results-container .empty {
    color:#fff !important;
}

[data-theme="dark"] .results-table th {
    background: rgba(255,255,255,0.08);
}

[data-theme="dark"] .results-table .text-secondary {
    color:#d0d0d0 !important;
}

.btn-create {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-create:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">
            <i class="bi bi-check2-circle me-2"></i>Resultados del Examen: {{ $exam->title }}
        </h1>
        <a href="{{ route('admin.exams.index') }}" class="btn-create">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="results-container">
        @if(session('success'))
            <div class="alert alert-success alert-custom mb-3">
                <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-custom mb-3">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ session('error') }}
            </div>
        @endif

            {{-- Buscador de alumnos debajo del título del examen --}}
            <div class="mb-3">
                <form method="GET" action="{{ route('admin.exams.doings', $exam->id) }}" class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-0"><i class="bi bi-search me-2"></i>Buscar alumno</h6>
                    </div>
                    <div class="col-md-6">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Buscar por nombre o correo...">
                    </div>
                </form>
            </div>

        @if($results->count() > 0)
            <div class="table-responsive">
                <table class="table results-table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correctas</th>
                            <th>Incorrectas</th>
                            <th>Puntuación</th>
                            <th>Duración (min)</th>
                            <th>Promedio (seg/preg)</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $r)
                            @php
                                $score = $r->scorePercent();
                                $scoreClass = $score >= 80 ? 'score-good' : ($score >= 50 ? 'score-mid' : 'score-bad');
                            @endphp
                            <tr>
                                <td>#{{ $r->id }}</td>
                                <td>{{ $r->user->name }}<br><small class="text-secondary">{{ $r->user->email }}</small></td>
                                <td>{{ $r->correct_answers }}</td>
                                <td>{{ $r->wrong_answers }}</td>
                                <td>
                                    <span class="score-badge {{ $scoreClass }}">{{ $score }}%</span>
                                </td>
                                <td>{{ round($r->total_duration / 60,1) }}</td>
                                <td>{{ $r->average_time }}</td>
                                <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.exams.results.reset', [$exam->id, $r->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Reiniciar intento de {{ $r->user->name }}? Se eliminarán respuestas y resultado.');">
                                        @csrf
                                        <button type="submit" class="action-btn btn-reset">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reiniciar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación de resultados --}}
            @if(method_exists($results, 'hasPages') && $results->hasPages())
                <div class="mt-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <small class="text-secondary">
                                Mostrando {{ $results->count() }} intentos
                                @if(method_exists($results, 'total'))
                                    de {{ $results->total() }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Paginación de resultados" class="d-flex justify-content-end">
                                @php
                                    $paginator = $results->appends([
                                        'search' => request('search'),
                                    ]);

                                    $currentPage = $paginator->currentPage();
                                    $lastPage = $paginator->lastPage();
                                    $pages = [];

                                    if ($lastPage <= 5) {
                                        for ($i = 1; $i <= $lastPage; $i++) {
                                            $pages[] = $i;
                                        }
                                    } else {
                                        $pages[] = 1; // siempre primera

                                        if ($currentPage <= 3) {
                                            $pages[] = 2;
                                            $pages[] = 3;
                                            $pages[] = 4;
                                        } elseif ($currentPage >= $lastPage - 2) {
                                            $pages[] = $lastPage - 3;
                                            $pages[] = $lastPage - 2;
                                            $pages[] = $lastPage - 1;
                                        } else {
                                            $pages[] = $currentPage - 1;
                                            $pages[] = $currentPage;
                                            $pages[] = $currentPage + 1;
                                        }

                                        $pages[] = $lastPage; // siempre última

                                        $pages = array_values(array_unique($pages));
                                        sort($pages);
                                    }

                                    $previousPage = null;
                                @endphp

                                <ul class="pagination pagination-sm pagination-custom mb-0">
                                    {{-- Anterior --}}
                                    @if ($paginator->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="bi bi-chevron-left me-1"></i> Anterior
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                                <i class="bi bi-chevron-left me-1"></i> Anterior
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Números de página --}}
                                    @foreach ($pages as $page)
                                        @if (!is_null($previousPage) && $page - $previousPage > 1)
                                            <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
                                        @endif

                                        @if ($page == $currentPage)
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif

                                        @php $previousPage = $page; @endphp
                                    @endforeach

                                    {{-- Siguiente --}}
                                    @if ($paginator->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                                                Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="empty">
                <i class="bi bi-clipboard-check" style="font-size:3rem;"></i>
                <h5 class="mt-3">Sin resultados aún</h5>
                <p>Los alumnos aún no han realizado este examen.</p>
            </div>
        @endif
    </div>
</div>
@endsection