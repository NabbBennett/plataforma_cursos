<div class="week-block evaluation-block" draggable="true">
    <div class="week-block-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <div class="drag-handle">
                <i class="bi bi-grip-vertical"></i>
            </div>
            <span class="block-type-badge badge-evaluation">
                <i class="bi bi-clipboard-check me-1"></i>Evaluación
            </span>
            <small class="text-secondary-custom ms-2">
                @if($week->id)
                    ID: #{{ $week->id }}
                @else
                    Nuevo bloque
                @endif
            </small>
        </div>
        <button type="button" class="btn-action btn-danger-custom" 
                onclick="removeEvaluation(this, {{ $week->id ?? 0 }})"
                title="Eliminar bloque de evaluación">
            <i class="bi bi-trash"></i>
            <span class="mobile-hidden">Eliminar</span>
        </button>
    </div>

    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][id]" value="{{ $week->id ?? 0 }}">
    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][after_week_id]" value="{{ $after_week_id ?? 0 }}">
    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][course_id]" value="{{ $course_id }}">

    <div class="row">
        {{-- Clase en vivo --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-camera-video me-1"></i>Clase en vivo
            </label>
            <input type="url" class="form-control" 
                   name="evaluation_blocks[eval_after_{{ $index }}][live_meet_link]" 
                   placeholder="https://meet.google.com/..."
                   value="{{ old('evaluation_blocks.eval_after_'.$index.'.live_meet_link', $week->live_meet_link) }}">
            <small class="text-secondary-custom">Enlace para la sesión en vivo de evaluación</small>
        </div>

        {{-- Clase grabada --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-play-circle me-1"></i>Clase grabada
            </label>
            <input type="url" class="form-control" 
                   name="evaluation_blocks[eval_after_{{ $index }}][recording_link]" 
                   placeholder="https://youtube.com/..."
                   value="{{ $week->recording_link }}">
            <small class="text-secondary-custom">Enlace para la grabación de evaluación</small>
        </div>
    </div>

    <div class="row">
        {{-- Examen --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-text me-1"></i>Examen asignado
            </label>
            <select name="evaluation_blocks[eval_after_{{ $index }}][exam_id]" class="form-select">
                <option value="">-- Seleccionar examen --</option>
                @foreach ($allExams as $exam)
                   <option value="{{ $exam->id }}"
                        {{ isset($week->exam_id) && $week->exam_id == $exam->id ? 'selected' : '' }}>
                        Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Evaluación asociada a este bloque</small>
        </div>

        {{-- Recurso --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-earmark me-1"></i>Material de apoyo
            </label>
            <select name="evaluation_blocks[eval_after_{{ $index }}][resource_id]" class="form-select">
                <option value="">-- Seleccionar material --</option>
                @foreach ($resources as $res)
                    <option value="{{ $res->id }}"
                        {{ isset($week->resource_id) && $week->resource_id == $res->id ? 'selected' : '' }}>
                        {{ $res->title }}
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Recurso adicional para la evaluación</small>
        </div>
    </div>
</div>