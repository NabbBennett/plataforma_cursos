<div class="week-block border p-3 mb-4 rounded">
    <h5>
        Semana <span class="week-number">{{ $week->number ?? ($index + 1) }}</span>
        <button type="button" class="btn btn-danger btn-sm float-end" onclick="removeWeek(this, {{ $week->id ?? 0 }})">Eliminar</button>
    </h5>

    <input type="hidden" name="weeks[{{ $index }}][id]" value="{{ $week->id ?? 0 }}">
    <input type="hidden" name="course_id" value="{{ $course_id }}">

    {{-- Clase en vivo --}}
    <div class="mb-3">
        <label>Clase en vivo</label>
        <input type="url" class="form-control" name="weeks[{{ $index }}][live_meet_link]" value="{{ $week->live_meet_link }}">
    </div>

    {{-- Clases grabadas --}}
    <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" id="recorded_checkbox_{{ $index }}" onchange="toggleRecorded({{ $index }})" name="weeks[{{ $index }}][has_recorded]" {{ $week->recording_link || $week->weekDays->count() ? 'checked' : '' }}>
        <label class="form-check-label" for="recorded_checkbox_{{ $index }}">Clases grabadas</label>
    </div>

    <div id="recorded_days_block_{{ $index }}" class="mb-3" style="{{ $week->recording_link || $week->weekDays->count() ? '' : 'display:none;' }}">
        <label>Días de clase grabada</label>
        <div class="row">
            @for ($i = 1; $i <= 7; $i++)
                @php $day = $week->weekDays->firstWhere('day_number', $i); @endphp
                <div class="col-md-12 border p-2 mb-2 rounded">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="day_{{ $index }}_{{ $i }}" name="weeks[{{ $index }}][days][{{ $i }}][enabled]" onchange="toggleDayDetails(this)" {{ $day ? 'checked' : '' }}>
                        <label class="form-check-label" for="day_{{ $index }}_{{ $i }}">Día {{ $i }}</label>
                    </div>
                    <div class="day-details mt-2" style="{{ $day ? '' : 'display:none;' }}">
                        <input type="text" class="form-control mt-1" name="weeks[{{ $index }}][days][{{ $i }}][title]" placeholder="Título" value="{{ $day->title ?? '' }}">
                        <input type="url" class="form-control mt-1" name="weeks[{{ $index }}][days][{{ $i }}][recording_link]" placeholder="Enlace" value="{{ $day->recording_link ?? '' }}">
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- Examen --}}
    <div class="mb-3">
        <label class="form-label">Examen asignado</label>
        <select name="weeks[{{ $index }}][exam_id]" class="form-select">
            <option value="">-- Sin examen --</option>
            @foreach ($allExams as $exam)
                <option value="{{ $exam->id }}"
                    @if(isset($week->exam) && $week->exam->id == $exam->id) selected @endif>
                    Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                </option>
            @endforeach
        </select>
    </div>

    {{-- Recurso --}}
    <div class="mb-3">
        <label class="form-label">Material asignado</label>
        <select name="weeks[{{ $index }}][resource_id]" class="form-select">
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
