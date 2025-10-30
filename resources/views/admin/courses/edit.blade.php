@extends('layouts.admin')

@section('title', 'Editar Curso')

@section('content')
<div class="container mt-4">
    <h2>Editar Curso</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre del curso</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $course->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="4" required>{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Inicio del curso</label>
            <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $course->start_date) }}">
        </div>

        <div class="mb-3">
            <label for="price_per_week" class="form-label">Precio por semana</label>
            <input type="number" name="price_per_week" class="form-control"
            step="0.01" min="0"
            value="{{ old('price_per_week', $course->price_per_week ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" class="form-control" name="image">
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" class="img-thumbnail mt-2" width="200">
            @endif
        </div>

        <hr>
        <h4>Semanas y bloques de evaluación</h4>

        <div id="weeks-container">
            @foreach($combined as $index => $item)
                @php
                    $isEvaluation = $item['type'] === 'evaluation';
                @endphp

                @if ($isEvaluation)
                    @include('admin.courses.partials.evaluation-block', [
                        'week' => $item['data'],
                        'index' => $index,
                        'isEvaluation' => true,
                        'course_id' => $course->id,
                        'resources' => $resources,
                        'allExams' => $allExams,
                        'after_week_id' => $item['data']->after_week_id ?? null
                    ])
                @else
                    @include('admin.courses.partials.week-block', [
                        'week' => $item['data'],
                        'index' => $index,
                        'isEvaluation' => false,
                        'course_id' => $course->id,
                        'resources' => $resources,
                        'allExams' => $allExams
                    ])
                @endif
            @endforeach
        </div>

        <input type="hidden" name="deleted_weeks[]" id="deletedWeeksContainer">
        <input type="hidden" name="deleted_evaluation_blocks[]" id="deletedEvaluationBlocksContainer">

        <div class="mt-3">
            <button type="button" class="btn btn-success" onclick="addWeek()">+ Añadir semana</button>
            <button type="button" class="btn btn-info" onclick="addEvaluationBlock(getLastWeekId())">+ Bloque de evaluación</button>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>

<script>
    let weekIndex = document.querySelectorAll('.week-block').length;

    function addWeek() {
        fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}`)
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('weeks-container');
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div);
                weekIndex++;
            });
    }

    function addEvaluationBlock(afterWeekId = 0) {
        fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}&evaluation=1&after_week_id=${afterWeekId}&course_id={{ $course->id }}`)
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('weeks-container');
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div);
                weekIndex++;
            });
    }

    function removeWeek(button, weekId = 0) {
        if (confirm("¿Estás seguro de eliminar esta semana?")) {
            const block = button.closest('.week-block');
            if (weekId && weekId !== 0) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "deleted_weeks[]";
                input.value = weekId;
                block.closest("form").appendChild(input);
            }
            block.remove();
        }
    }

    function removeEvaluation(button, blockId = 0) {
        if (confirm("¿Eliminar bloque de evaluación?")) {
            const block = button.closest('.week-block');
            if (blockId && blockId !== 0) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "deleted_evaluation_blocks[]";
                input.value = blockId;
                block.closest("form").appendChild(input);
            }
            block.remove();
        }
    }

    function getLastWeekId() {
        const weeks = document.querySelectorAll('.week-block');
        let lastId = 0;

        weeks.forEach(w => {
            const idInput = w.querySelector('input[name*="[id]"]');
            if (idInput && !w.innerHTML.includes('Bloque de Evaluación')) {
                const id = parseInt(idInput.value);
                if (!isNaN(id)) {
                    lastId = id;
                }
            }
        });

        return lastId;
    }

    function toggleLive(index) {
        document.getElementById(`live_link_block_${index}`).style.display =
            document.getElementById(`live_checkbox_${index}`).checked ? 'block' : 'none';
    }

    function toggleRecorded(index) {
        document.getElementById(`recorded_days_block_${index}`).style.display =
            document.getElementById(`recorded_checkbox_${index}`).checked ? 'block' : 'none';
    }

    function toggleDayDetails(checkbox) {
        checkbox.closest('.col-md-12').querySelector('.day-details').style.display =
            checkbox.checked ? 'block' : 'none';
    }

    function previewExam(weekId) {
        fetch(`/admin/exams/preview/${weekId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (response.status === 404) {
                alert('⚠ No hay examen creado para esta semana.');
            } else {
                window.location.href = `/admin/exams/preview/${weekId}`;
            }
        })
        .catch(() => {
            alert('⚠ Error al intentar cargar el examen.');
        });
    }
</script>
@endsection
