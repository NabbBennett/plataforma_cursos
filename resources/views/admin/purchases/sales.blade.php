@extends('layouts.admin')

@section('title', 'Ventas registradas')

@section('content')
<div class="container mt-4">
    <h2>Ventas</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <!-- Buscador -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por alumno o curso...">
    </div>

    <!-- Formulario de activación -->
    <h4 class="mt-4">Activación o compra manual</h4>
    <form method="POST" action="{{ route('admin.purchases.manual.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <label for="user_id">Alumno</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Selecciona un alumno --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="course_id">Curso</label>
                <select name="course_id" class="form-select" id="courseSelect" required>
                    <option value="">-- Selecciona un curso --</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" data-semanas="{{ $course->number_of_weeks }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="paid_weeks">Semanas pagadas</label>
                <input type="number" name="paid_weeks" id="paidWeeksInput" class="form-control" min="1" required>
                <small class="text-muted" id="weeksLimitInfo"></small>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar acceso</button>
    </form>

    <hr class="my-5">

    <!-- Tabla de ventas -->
    <table class="table table-bordered table-striped" id="ventasTable">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Curso adquirido</th>
                <th>Semanas desbloqueadas</th>
                <th>Semanas pagadas</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                @php
                    $courseStart = \Carbon\Carbon::parse($venta->course->start_date);
                    $hoy = \Carbon\Carbon::today();
                    $semanasTranscurridas = $courseStart->isFuture() ? 0 : $courseStart->diffInWeeks($hoy);
                    $atraso = $semanasTranscurridas - $venta->paid_weeks;

                    if ($atraso <= 0) {
                        $estado = ['CORRIENTE', 'success'];
                    } elseif ($atraso <= 2) {
                        $estado = ['PENDIENTE', 'warning'];
                    } else {
                        $estado = ['ATRASADO', 'danger'];
                    }

                    $maxSemanas = $venta->course?->number_of_weeks ?? $venta->course?->weeks()->count() ?? 20;
                @endphp
                <tr data-start-date="{{ $venta->course->start_date }}">
                    <td>{{ $venta->user->name }}</td>
                    <td>{{ $venta->course->title }}</td>
                    <td>
                        <select class="form-select field-editable" data-id="{{ $venta->id }}" data-field="weeks_unlocked">
                            @for ($i = 0; $i <= $maxSemanas; $i++)
                                <option value="{{ $i }}" @selected($i == $venta->weeks_unlocked)>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    <td>
                        <select class="form-select field-editable" data-id="{{ $venta->id }}" data-field="paid_weeks">
                            @for ($i = 0; $i <= $maxSemanas; $i++)
                                <option value="{{ $i }}" @selected($i == $venta->paid_weeks)>{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    <td>
                        <span class="badge bg-{{ $estado[1] }}" id="status-{{ $venta->id }}">{{ $estado[0] }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
// Buscador
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#ventasTable tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});

// Límite dinámico para semanas pagadas
document.getElementById('courseSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const maxWeeks = selectedOption.dataset.semanas;
    const weeksInput = document.getElementById('paidWeeksInput');
    const infoText = document.getElementById('weeksLimitInfo');

    if (maxWeeks) {
        weeksInput.max = maxWeeks;
        infoText.textContent = `Máximo permitido: ${maxWeeks} semanas`;
    } else {
        weeksInput.removeAttribute('max');
        infoText.textContent = '';
    }

    if (parseInt(weeksInput.value) > parseInt(maxWeeks)) {
        weeksInput.value = maxWeeks;
    }
});

// Actualización inmediata con estatus visual dinámico
document.querySelectorAll('.field-editable').forEach(select => {
    select.addEventListener('change', function () {
        const id = this.dataset.id;
        const field = this.dataset.field;
        const value = this.value;

        fetch("{{ route('admin.purchases.updateField') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ purchase_id: id, field: field, value: value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = select.closest('tr');
                const weeksPaid = parseInt(row.querySelector('select[data-field="paid_weeks"]').value);
                const startDateStr = row.dataset.startDate;
                const courseStart = new Date(startDateStr);
                const today = new Date();
                const msPerWeek = 1000 * 60 * 60 * 24 * 7;
                const weeksSinceStart = courseStart > today ? 0 : Math.floor((today - courseStart) / msPerWeek);
                const atraso = weeksSinceStart - weeksPaid;

                let estadoTexto = '';
                let estadoColor = '';

                if (atraso <= 0) {
                    estadoTexto = 'CORRIENTE';
                    estadoColor = 'bg-success';
                } else if (atraso <= 2) {
                    estadoTexto = 'PENDIENTE';
                    estadoColor = 'bg-warning';
                } else {
                    estadoTexto = 'ATRASADO';
                    estadoColor = 'bg-danger';
                }

                const badge = row.querySelector('.badge');
                badge.classList.remove('bg-success', 'bg-danger', 'bg-warning');
                badge.classList.add(estadoColor);
                badge.textContent = estadoTexto;
            }
        });
    });
});
</script>
@endsection
