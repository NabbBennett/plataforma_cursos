<div class="week-block border p-3 mb-4 rounded">
    <h5>
        Bloque de Evaluación
        <button type="button" class="btn btn-danger btn-sm float-end" onclick="removeEvaluation(this, {{ $week->id ?? 0 }})">Eliminar</button>
    </h5>

    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][id]" value="{{ $week->id ?? 0 }}">
    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][after_week_id]" value="{{ $after_week_id ?? 0 }}">
    <input type="hidden" name="evaluation_blocks[eval_after_{{ $index }}][course_id]" value="{{ $course_id }}">

    {{-- Clase en vivo --}}
    <div class="mb-3">
        <label>Clase en vivo</label>
        <input type="url" class="form-control" name="evaluation_blocks[eval_after_{{ $index }}][live_meet_link]" value="{{ old('evaluation_blocks.eval_after_'.$index.'.live_meet_link', $week->live_meet_link) }}">
    </div>

    {{-- Una sola clase grabada --}}
    <div class="mb-3">
        <label>Clase grabada</label>
        <input type="url" class="form-control" name="evaluation_blocks[eval_after_{{ $index }}][recording_link]" value="{{ $week->recording_link }}">
    </div>

    {{-- Examen --}}
    <div class="mb-3">
        <label class="form-label">Examen asignado</label>
            <select name="evaluation_blocks[eval_after_{{ $index }}][exam_id]" class="form-select">
            <option value="">-- Sin examen --</option>
            @foreach ($allExams as $exam)
               <option value="{{ $exam->id }}"
                    {{ isset($week->exam_id) && $week->exam_id == $exam->id ? 'selected' : '' }}>
                    Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                </option>
            @endforeach
        </select>
    </div>

    {{-- Recurso --}}
    <div class="mb-3">
        <label class="form-label">Material asignado</label>
        <select name="evaluation_blocks[eval_after_{{ $index }}][resource_id]" class="form-select">
            <option value="">-- Sin material --</option>
            @foreach ($resources as $res)
                <option value="{{ $res->id }}"
                    {{ isset($week->resource_id) && $week->resource_id == $res->id ? 'selected' : '' }}>
                    {{ $res->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>
