<div class="week-block" draggable="true" data-block-type="week">
    <!-- Input de ID para semanas -->
    <input type="hidden" name="weeks[{{ $index }}][id]" value="{{ isset($week) && $week->id ? $week->id : 0 }}">
    @php
        $selectedResourceId = isset($week) && isset($week->resource_id) ? $week->resource_id : 0;
    @endphp
    <div class="week-block-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1">
            <div class="drag-handle">
                <i class="bi bi-grip-vertical"></i>
            </div>
            <span class="block-type-badge badge-week">
                <i class="bi bi-calendar-week me-1"></i>Semana
            </span>
            <span class="week-number text-primary-custom fw-bold ms-2">
                #{{ $index + 1 }}
            </span>
            <small class="text-secondary-custom ms-2">
                @if(isset($week) && $week->id)
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

    <input type="hidden" name="weeks[{{ $index }}][course_id]" value="{{ $course_id }}">

    {{-- Título de la semana --}}
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-text-paragraph me-1"></i>Título de la Semana
        </label>
        <input type="text" class="form-control" 
               name="weeks[{{ $index }}][title]" 
               placeholder="Ej: Introducción al tema..."
               value="{{ isset($week) ? $week->title : '' }}">
    </div>

    {{-- Clase en vivo --}}
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-camera-video me-1"></i>Clase en vivo
        </label>
        <input type="url" class="form-control" 
               name="weeks[{{ $index }}][live_meet_link]" 
               placeholder="https://meet.google.com/..."
               value="{{ isset($week) ? $week->live_meet_link : '' }}">
        <small class="text-secondary-custom">Enlace para la sesión en vivo de esta semana</small>
    </div>

    {{-- Clases grabadas --}}
    <div class="mb-3">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" 
                   id="recorded_checkbox_{{ $index }}"
                   name="weeks[{{ $index }}][has_recorded]"
                   value="1"
                   onchange="toggleRecordedDays({{ $index }})"
                   {{ (isset($week) && ($week->recording_link || $week->weekDays->count())) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="recorded_checkbox_{{ $index }}">
                <i class="bi bi-play-circle me-1"></i>Clases Grabadas
            </label>
        </div>

        <div id="recorded_days_block_{{ $index }}" 
             class="border rounded p-3 bg-var-primary" 
             style="{{ (isset($week) && ($week->recording_link || $week->weekDays->count())) ? '' : 'display:none;' }}">
            
            <label class="form-label mb-3">Configurar días de clase grabada</label>
            
            <div class="row g-2">
                @for ($day = 1; $day <= 5; $day++)
                    @php
                        $dayData = isset($week) ? $week->weekDays->firstWhere('day_number', $day) : null;
                    @endphp
                    <div class="col-12">
                        <div class="card bg-var-secondary border">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" 
                                           id="day_{{ $index }}_{{ $day }}_enabled"
                                           name="weeks[{{ $index }}][days][{{ $day }}][enabled]"
                                           value="1"
                                           data-week-index="{{ $index }}"
                                           data-day="{{ $day }}"
                                           onchange="toggleDayDetails(this)"
                                           {{ $dayData ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="day_{{ $index }}_{{ $day }}_enabled">
                                        Día {{ $day }}
                                    </label>
                                </div>

                                <div id="day-{{ $index }}-{{ $day }}-details" 
                                     class="day-details mt-2" 
                                     style="{{ $dayData ? '' : 'display:none;' }}">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label small">Título del día</label>
                                            <input type="text" class="form-control form-control-sm" 
                                                   name="weeks[{{ $index }}][days][{{ $day }}][title]"
                                                   placeholder="Ej: Introducción a..."
                                                   value="{{ $dayData ? $dayData->title : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small">Link de grabación</label>
                                            <input type="url" class="form-control form-control-sm" 
                                                   name="weeks[{{ $index }}][days][{{ $day }}][recording_link]"
                                                   placeholder="https://youtube.com/..."
                                                   value="{{ $dayData ? $dayData->recording_link : '' }}">
                                        </div>
                                    </div>
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
                <i class="bi bi-file-text me-1"></i>Examen
            </label>
            <select name="weeks[{{ $index }}][exam_id]" class="form-select">
                <option value="">-- Sin examen --</option>
                @foreach ($allExams as $exam)
                    <option value="{{ $exam->id }}"
                        {{ (isset($week) && $week->exam_id == $exam->id) ? 'selected' : '' }}>
                        Examen #{{ $exam->id }} ({{ $exam->questions_count }} preguntas, {{ $exam->duration_minutes }} min)
                    </option>
                @endforeach
            </select>
            <small class="text-secondary-custom">Evaluación al final de esta semana</small>
            
            @if(isset($week) && $week->exam_id)
                <div class="mt-2">
                    <button type="button" class="btn-action btn-info-custom btn-sm" 
                            onclick="previewExam({{ $week->id }})">
                        <i class="bi bi-eye me-1"></i>Vista previa
                    </button>
                </div>
            @endif
        </div>

        {{-- Recursos (Único recurso con radios) --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-earmark me-1"></i>Recurso (solo uno)
            </label>
            <div class="border rounded p-2" style="max-height:230px;overflow-y:auto;">
                @forelse($resources as $res)
                    <div class="form-check mb-2">
                        <input class="form-check-input"
                               type="radio"
                               name="weeks[{{ $index }}][resource_id]"
                               id="resource_{{ $index }}_{{ $res->id }}"
                               value="{{ $res->id }}"
                               {{ $res->id == $selectedResourceId ? 'checked' : '' }}>
                        <label class="form-check-label" for="resource_{{ $index }}_{{ $res->id }}">
                            {{ $res->title }}
                            <small class="text-muted ms-1">({{ $res->type }})</small>
                        </label>
                    </div>
                @empty
                    <div class="text-muted">Sin recursos disponibles.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>