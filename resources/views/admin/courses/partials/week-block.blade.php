<div class="week-block" draggable="true" data-block-type="week">
    <!-- Input de ID para semanas -->
    <input type="hidden" name="weeks[{{ $index }}][id]" value="{{ isset($week) && $week->id ? $week->id : 0 }}">
    
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

        {{-- Recursos (Múltiples con checkboxes) --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="bi bi-file-earmark me-1"></i>Recursos Adicionales
            </label>
            
            {{-- Buscador de recursos --}}
            <div class="input-group mb-2">
                <span class="input-group-text bg-var-primary border-var-secondary">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       class="form-control resource-search" 
                       data-week-index="{{ $index }}"
                       placeholder="Buscar recursos..."
                       onkeyup="searchResources({{ $index }})">
            </div>

            {{-- Contenedor de recursos con scroll --}}
            <div class="resources-container border rounded p-4 bg-var-primary" 
                 id="resources-container-{{ $index }}"
                 style="max-height: 250px; overflow-y: auto;">
                @php
                    // Verificar si week tiene recursos cargados
                    $selectedResources = [];
                    if (isset($week) && $week->id) {
                        try {
                            $selectedResources = $week->resources()->pluck('resources.id')->toArray();
                        } catch (\Exception $e) {
                            // Si hay error, dejar el array vacío
                            $selectedResources = [];
                        }
                    }
                @endphp
                
                @forelse ($resources as $res)
                    <div class="form-check resource-item mb-2 p-2 rounded hover-bg" 
                         data-week-index="{{ $index }}"
                         data-resource-title="{{ strtolower($res->title) }}"
                         data-resource-type="{{ strtolower($res->type) }}">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="weeks[{{ $index }}][resource_ids][]" 
                               value="{{ $res->id }}"
                               id="resource_{{ $index }}_{{ $res->id }}"
                               {{ in_array($res->id, $selectedResources) ? 'checked' : '' }}
                               onchange="updateResourceCount({{ $index }})">
                        <label class="form-check-label w-100" for="resource_{{ $index }}_{{ $res->id }}">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-{{ $res->type == 'pdf' ? 'pdf' : ($res->type == 'video' ? 'play' : 'fill') }} me-2 text-primary-custom"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $res->title }}</div>
                                    <small class="text-secondary-custom">{{ ucfirst($res->type) }}</small>
                                </div>
                            </div>
                        </label>
                    </div>
                @empty
                    <div class="text-center text-secondary-custom py-3">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0">No hay recursos disponibles</p>
                    </div>
                @endforelse
            </div>

            {{-- Contador de seleccionados --}}
            <div class="mt-2">
                <small class="text-secondary-custom">
                    <i class="bi bi-check-circle me-1"></i>
                    <span id="selected-count-{{ $index }}">{{ count($selectedResources) }}</span> recursos seleccionados
                </small>
            </div>

            {{-- Lista de seleccionados --}}
            @if(count($selectedResources) > 0)
                <div class="mt-2 p-2 bg-var-secondary rounded" id="selected-resources-{{ $index }}">
                    <strong class="small text-primary-custom d-block mb-2">
                        <i class="bi bi-bookmarks me-1"></i>Recursos seleccionados:
                    </strong>
                    <div class="selected-resources-list">
                        @foreach($resources->whereIn('id', $selectedResources) as $resource)
                            <div class="badge bg-primary me-1 mb-1">
                                {{ $resource->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>