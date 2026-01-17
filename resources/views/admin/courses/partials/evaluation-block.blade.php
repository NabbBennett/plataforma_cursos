<div class="week-block evaluation-block" data-block-type="evaluation">
    <input type="hidden"
           name="evaluation_blocks[{{ $index }}][id]"
           value="{{ isset($evaluationBlock) && $evaluationBlock->id ? $evaluationBlock->id : 0 }}">
    <div class="week-block-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <div class="drag-handle"><i class="bi bi-grip-vertical"></i></div>
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
            <i class="bi bi-trash"></i><span class="mobile-hidden">Eliminar</span>
        </button>
    </div>

    <input type="hidden" name="course_id" value="{{ $course_id }}">
    <input type="hidden"
           name="evaluation_blocks[{{ $index }}][after_week_id]"
           value="{{ $after_week_id ?? 0 }}">

    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-toggle2-on me-1"></i>Tipo de bloque
        </label>
        @php $selectedType = isset($evaluationBlock) && $evaluationBlock->evaluation_type ? $evaluationBlock->evaluation_type : 'universidad'; @endphp
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch"
                   id="evaluation-type-switch-{{ $index }}"
                   {{ $selectedType === 'preparatoria' ? 'checked' : '' }}
                   onchange="handleEvaluationTypeChange(this)">
            <label class="form-check-label" for="evaluation-type-switch-{{ $index }}">
                <span id="evaluation-type-label-{{ $index }}">{{ $selectedType === 'preparatoria' ? 'Preparatoria' : 'Universidad' }}</span>
            </label>
        </div>
        <input type="hidden" name="evaluation_blocks[{{ $index }}][evaluation_type]" id="evaluation-type-input-{{ $index }}" value="{{ $selectedType }}">
        <small class="text-secondary-custom">Usa el switch para elegir Universidad o Preparatoria.</small>
    </div>

    @php
        $type = isset($evaluationBlock) && $evaluationBlock->evaluation_type ? $evaluationBlock->evaluation_type : 'universidad';
        $categoryLabels = $type === 'preparatoria'
            ? [
                'slot1' => 'Pensamiento crítico y resolución de problemas',
                'slot2' => 'Comunicación, alfabetización multimodal y cultura',
                'slot3' => 'Razonamiento matemático y ciencias de datos',
                'slot4' => 'Sociedad, cultura y ciudadanía global',
                'slot5' => 'Ciencias y tecnología para el futuro',
            ]
            : [
                'slot1' => 'Español',
                'slot2' => 'Matemáticas',
                'slot3' => 'Área de conocimiento',
                'slot4' => 'Habilidades blandas',
                'slot5' => 'Inglés',
            ];

        $existingExams = isset($evaluationBlock) && $evaluationBlock->relationLoaded('exams')
            ? $evaluationBlock->exams->sortBy('id')->values()
            : collect();

        if ($existingExams->isEmpty() && isset($evaluationBlock) && $evaluationBlock->exam_id) {
            $fallbackExam = \App\Models\Exam::find($evaluationBlock->exam_id);
            if ($fallbackExam) {
                $existingExams = collect([$fallbackExam]);
            }
        }
    @endphp

    @foreach ($categoryLabels as $catKey => $label)
        @php
            $selectedExam = $existingExams->get($loop->index);
        @endphp
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-file-text me-1"></i>{{ $label }}
            </label>
            <select name="evaluation_blocks[{{ $index }}][exam_ids][{{ $catKey }}]" class="form-select">
                <option value="">-- Seleccionar examen --</option>
                @foreach ($allExams as $exam)
                    @php $examLabel = $exam->title ? $exam->title : "Examen #{$exam->id}"; @endphp
                    <option value="{{ $exam->id }}"
                        {{ ($selectedExam && $selectedExam->id == $exam->id) ? 'selected' : '' }}>
                        {{ $examLabel }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Puedes dejarlo vacío si no aplica</small>
        </div>
    @endforeach

    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Nota:</strong> Este bloque se mostrará después de
        {{ $after_week_id > 0 ? "la semana #$after_week_id" : "todas las semanas" }}.
    </div>
</div>