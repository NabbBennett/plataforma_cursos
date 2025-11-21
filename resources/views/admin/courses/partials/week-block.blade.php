<div class="week-block" draggable="true">
    <div class="week-block-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <div class="drag-handle">
                <i class="bi bi-grip-vertical"></i>
            </div>
            <span class="block-type-badge badge-week">
                <i class="bi bi-calendar-week me-1"></i>Semana
            </span>
            <span class="week-number text-primary-custom fw-bold ms-2">
                {{ $week->number ?? ($index + 1) }}
            </span>
            <small class="text-secondary-custom ms-2">
                @if($week->id)
                    ID: #{{ $week->id }}
                @else
                    Nueva semana
                @endif
            </small>
        </div>
        <button type="button" class="btn-action btn-danger-custom" 
                onclick="removeWeek(this, {{ $week->id ?? 0 }})"
                title="Eliminar semana">
            <i class="bi bi-trash"></i>
            <span class="mobile-hidden">Eliminar</span>
        </button>
    </div>

    <input type="hidden" name="weeks[{{ $index }}][id]" value="{{ $week->id ?? 0 }}">
    <input type="hidden" name="course_id" value="{{ $course_id }}">

    {{-- Clase en vivo --}}
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-camera-video me-1"></i>Clase en vivo
        </label>
        <input type="url" class="form-control" 
               name="weeks[{{ $index }}][live_meet_link]" 
               placeholder="https://meet.google.com/..."
               value="{{ $week->live_meet_link }}">
        <small class="text-secondary-custom">Enlace para la sesión en vivo de esta semana</small>
    </div>

    {{-- Clases grabadas --}}
    <div class="mb-3">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" 
                   id="recorded_checkbox_{{ $index }}" 
                   onchange="toggleRecorded({{ $index }})" 
                   name="weeks[{{ $index }}][has_recorded]" 
                   {{ $week->recording_link || $week->weekDays->count() ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="recorded_checkbox_{{ $index }}">
                <i class="bi bi-play-circle me-1"></i>Clases grabadas
            </label>
        </div>

        <div id="recorded_days_block_{{ $index }}" 
             class="border rounded p-3 bg-var-primary" 
             style="{{ $week->recording_link || $week->weekDays->count() ? '' : 'display:none;' }}">
            
            <label class="form-label mb-3">Configurar días de clase grabada</label>
            
            <div class="row g-2">
                @for ($i = 1; $i <= 7; $i++)
                    @php $day = $week->weekDays->firstWhere('day_number', $i); @endphp
                    <div class="col-md-12 border rounded p-3 mb-2 bg-var-secondary">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" 
                                   id="day_{{ $index }}_{{ $i }}" 
                                   name="weeks[{{ $index }}][days][{{ $i }}][enabled]" 
                                   onchange="toggleDayDetails(this)" 
                                   {{ $day ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="day_{{ $index }}_{{ $i }}">
                                Día {{ $i }}
                            </label>
                        </div>
                        
                        <div class="day-details mt-2" style="{{ $day ? '' : 'display:none;' }}">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" 
                                           name="weeks[{{ $index }}][days][{{ $i }}][title]" 
                                           placeholder="Título de la clase (ej: 'Introducción a...')" 
                                           value="{{ $day->title ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" class="form-control" 
                                           name="weeks[{{ $index }}][days][{{ $i }}][recording_link]" 
                                           placeholder="https://youtube.com/..."
                                           value="{{ $day->recording_link ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Examen --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-text me-1"></i>Examen de la semana
            </label>
            <select name="weeks[{{ $index }}][exam_id]" class="form-select">
                <option value="">-- Seleccionar examen --</option>
                @foreach ($allExams as $exam)
                    <option value="{{ $exam->id }}"
                        @if(isset($week->exam) && $week->exam->id == $exam->id) selected @endif>
                        Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Evaluación al final de esta semana</small>
            
            @if(isset($week->exam_id) && $week->exam_id)
                <div class="mt-2">
                    <button type="button" class="btn-action btn-info-custom btn-sm" 
                            onclick="previewExam({{ $week->exam_id }})">
                        <i class="bi bi-eye me-1"></i>Vista previa
                    </button>
                </div>
            @endif
        </div>

        {{-- Recurso --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-earmark me-1"></i>Material de la semana
            </label>
            <select name="weeks[{{ $index }}][resource_id]" class="form-select">
                <option value="">-- Seleccionar material --</option>
                @foreach ($resources as $res)
                    <option value="{{ $res->id }}"
                        {{ isset($week->resource_id) && $week->resource_id == $res->id ? 'selected' : '' }}>
                        {{ $res->title }}
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Recursos adicionales para esta semana</small>
        </div>
    </div>
</div>