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