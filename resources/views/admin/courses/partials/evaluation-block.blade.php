<div class="week-block evaluation-block" data-block-type="evaluation">
    <!-- Input de ID para bloques de evaluación -->
    <input type="hidden" 
           name="evaluation_blocks[{{ $index }}][id]" 
           value="{{ isset($evaluationBlock) && $evaluationBlock->id ? $evaluationBlock->id : 0 }}">
    
    <div class="week-block-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <div class="drag-handle">
                <i class="bi bi-grip-vertical"></i>
            </div>
            <span class="block-type-badge badge-evaluation">
                <i class="bi bi-clipboard-check me-1"></i>Bloque de Evaluación
            </span>
            <small class="text-secondary-custom ms-2">
                @if(isset($evaluationBlock) && $evaluationBlock->id)
                    ID: #{{ $evaluationBlock->id }}
                @else
                    Nuevo bloque
                @endif
            </small>
        </div>
        <button type="button" class="btn-action btn-danger-custom" 
                onclick="removeEvaluation(this, {{ isset($evaluationBlock) && $evaluationBlock->id ? $evaluationBlock->id : 0 }})"
                title="Eliminar bloque">
            <i class="bi bi-trash"></i>
            <span class="mobile-hidden">Eliminar</span>
        </button>
    </div>

    <input type="hidden" name="course_id" value="{{ $course_id }}">
    <input type="hidden" 
           name="evaluation_blocks[{{ $index }}][after_week_id]" 
           value="{{ $after_week_id ?? 0 }}">

    {{-- Clase en vivo --}}
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-camera-video me-1"></i>Clase en vivo de evaluación
        </label>
        <input type="url" class="form-control" 
               name="evaluation_blocks[{{ $index }}][live_meet_link]" 
               placeholder="https://meet.google.com/..."
               value="{{ isset($evaluationBlock) ? $evaluationBlock->live_meet_link : '' }}">
        <small class="text-secondary-custom">Enlace para la sesión en vivo de evaluación</small>
    </div>

    {{-- Clase grabada --}}
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-play-circle me-1"></i>Clase grabada de evaluación
        </label>
        <input type="url" class="form-control" 
               name="evaluation_blocks[{{ $index }}][recording_link]" 
               placeholder="https://youtube.com/..."
               value="{{ isset($evaluationBlock) ? $evaluationBlock->recording_link : '' }}">
        <small class="text-secondary-custom">Enlace de la grabación de la clase de evaluación</small>
    </div>

    <div class="row">
        {{-- Examen --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-text me-1"></i>Examen de evaluación
            </label>
            <select name="evaluation_blocks[{{ $index }}][exam_id]" class="form-select">
                <option value="">-- Seleccionar examen --</option>
                @foreach ($allExams as $exam)
                    <option value="{{ $exam->id }}"
                        {{ (isset($evaluationBlock) && $evaluationBlock->exam_id == $exam->id) ? 'selected' : '' }}>
                        Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Examen final de evaluación</small>
            
            @if(isset($evaluationBlock) && $evaluationBlock->exam_id)
                <div class="mt-2">
                    <button type="button" class="btn-action btn-info-custom btn-sm" 
                            onclick="previewExam({{ $evaluationBlock->exam_id }})">
                        <i class="bi bi-eye me-1"></i>Vista previa
                    </button>
                </div>
            @endif
        </div>

        {{-- Recurso --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-earmark me-1"></i>Material de evaluación
            </label>
            <select name="evaluation_blocks[{{ $index }}][resource_id]" class="form-select">
                <option value="">-- Seleccionar material --</option>
                @foreach ($resources as $res)
                    <option value="{{ $res->id }}"
                        {{ (isset($evaluationBlock) && $evaluationBlock->resource_id == $res->id) ? 'selected' : '' }}>
                        {{ $res->title }}
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Recursos para la evaluación</small>
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Nota:</strong> Este bloque de evaluación se mostrará después de 
        {{ $after_week_id > 0 ? "la semana #$after_week_id" : "todas las semanas" }}.
    </div>
</div>