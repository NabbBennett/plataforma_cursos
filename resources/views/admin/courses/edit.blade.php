@extends('layouts.admin')

@section('title', 'Editar Curso')

@section('content')
<style>
    .edit-course-container {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        min-height: calc(100vh - var(--header-height));
        padding: 2rem 0;
    }

    .page-header {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-container {
        background-color: var(--bg-secondary);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: var(--bg-primary);
        border-color: var(--btn-primary-bg);
        color: var(--text-primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    .btn-primary-custom:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .btn-success-custom {
        background-color: #28a745;
        color: white;
    }

    .btn-success-custom:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btn-info-custom {
        background-color: #17a2b8;
        color: white;
    }

    .btn-info-custom:hover {
        background-color: #138496;
        transform: translateY(-2px);
    }

    .btn-danger-custom {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger-custom:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .week-block {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
        cursor: move; /* Indicar que es arrastrable */
    }

    .week-block:hover {
        border-color: var(--btn-primary-bg);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .week-block.dragging {
        opacity: 0.8;
        transform: rotate(2deg) scale(1.02);
        border: 2px dashed var(--btn-primary-bg);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        background-color: var(--bg-secondary);
    }

    .week-block.drag-over {
        border: 2px solid #28a745;
        background-color: var(--hover-bg);
        transform: scale(1.02);
    }

    .week-block-body {
        margin-top: 1rem;
    }

    .week-block.collapsed .week-block-body {
        display: none;
    }

    .collapse-toggle-btn {
        padding: 0.35rem 0.6rem;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background-color: var(--bg-secondary);
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .collapse-toggle-btn:hover {
        background-color: var(--hover-bg);
        color: var(--text-primary);
    }

    .evaluation-block {
        border-left: 4px solid #6f42c1;
    }

    .week-block-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .block-type-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-week {
        background-color: #17a2b8;
        color: white;
    }

    .badge-evaluation {
        background-color: #6f42c1;
        color: white;
    }

    .drag-handle {
        cursor: grab;
        padding: 0.5rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
    }

    .drag-handle:hover {
        color: var(--text-primary);
        background: var(--hover-bg);
        cursor: grab;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    /* Indicador visual de zona de drop */
    .weeks-container {
        min-height: 100px;
        transition: all 0.3s ease;
        border: 2px dashed transparent;
        border-radius: 10px;
        padding: 10px;
    }

    .weeks-container.drag-active {
        border-color: var(--btn-primary-bg);
        background-color: var(--hover-bg);
    }

    /* Línea indicadora de posición */
    .drop-indicator {
        height: 4px;
        background-color: #28a745;
        border-radius: 2px;
        margin: 5px 0;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .drop-indicator.active {
        opacity: 1;
    }

    .empty-blocks-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .empty-blocks-state i {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .image-preview {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid var(--border-color);
        margin-top: 0.5rem;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-custom {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
    }

    .alert-success {
        border-left: 4px solid #28a745;
    }

    .character-count {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-align: right;
        margin-top: 0.25rem;
    }

    /* NicEdit styling to match theme */
    .nicEdit-panel {
        background-color: var(--bg-primary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
    }

    .nicEdit-panelContain {
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .nicEdit-container {
        width: 100% !important;
        max-width: 100% !important;
        display: block !important;
        box-sizing: border-box !important;
    }

    .nicEdit-main {
        width: 100% !important;
        box-sizing: border-box !important;
        min-height: 140px;
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 6px !important;
        padding: 0.5rem !important;
    }

    .nicEdit-main textarea {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 6px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        font-family: inherit !important;
        font-size: inherit !important;
    }

    /* Ensure editor blocks do not float and expand fully */
    .nicEdit-container,
    .nicEdit-main {
        float: none !important;
        display: block !important;
    }

    @media (max-width: 768px) {
        .edit-course-container {
            padding: 1rem 0;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .week-block {
            padding: 1rem;
        }

        .week-block-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .mobile-stack {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .form-container {
            padding: 1rem;
        }

        .image-preview {
            width: 150px;
            height: 112px;
        }
    }

    .bg-var-primary {
    background-color: var(--bg-primary);
}

.bg-var-secondary {
    background-color: var(--bg-secondary);
}

.form-switch .form-check-input:checked {
    background-color: var(--btn-primary-bg);
    border-color: var(--btn-primary-bg);
}

.form-switch .form-check-input:focus {
    border-color: var(--btn-primary-bg);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.week-block .form-control:focus,
.week-block .form-select:focus {
    border-color: var(--btn-primary-bg);
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
}

.week-block .alert-info {
    border-left: 4px solid #17a2b8;
    background-color: var(--bg-primary);
}

/* Contenedores ocultos para items eliminados */
#deletedWeeksContainer,
#deletedEvaluationBlocksContainer {
    display: none;
}

/* Animación al eliminar */
.week-block.removing {
    opacity: 0.5;
    transform: scale(0.95);
    transition: all 0.3s ease;
}

/* Mejoras para móviles */
@media (max-width: 768px) {
    .week-block-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .week-block-header .btn-action {
        width: 100%;
        justify-content: center;
    }
    
    .day-details .row {
        flex-direction: column;
    }
    
    .day-details .col-md-6 {
        width: 100%;
    }
}
</style>

<div class="edit-course-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-pencil-square me-2"></i>Editar Curso</h1>
                    <p class="text-secondary-custom mb-0">Editando: {{ $course->title }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.courses.index') }}" class="btn-action btn-primary-custom">
                        <i class="bi bi-arrow-left me-2"></i>Volver a Cursos
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-custom mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-custom mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Por favor, corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <div class="form-container">
            <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Input para el orden de los bloques -->
                <input type="hidden" name="block_order" id="blockOrderContainer" value="">
                
                <!-- Contenedores para items eliminados -->
                <div id="deletedWeeksContainer"></div>
                <div id="deletedEvaluationBlocksContainer"></div>
                
                <!-- Información Básica -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Información Básica del Curso
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_group" class="form-label">Grupo de Curso (1-10) *</label>
                            <input type="number" class="form-control" id="course_group" name="course_group" 
                                min="1" max="10" 
                                   value="{{ old('course_group', $course->course_group) }}" 
                                placeholder="Seleccione 1, 2, 3 ... 10"
                                   required>
                            <small class="text-secondary-custom">Agrupa horarios diferentes en la tienda</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="schedule" class="form-label">Horario *</label>
                            <input type="text" class="form-control" id="schedule" name="schedule" 
                                   value="{{ old('schedule', $course->schedule) }}" 
                                   placeholder="Ej: Lunes 9:00 AM - 11:00 AM"
                                   required
                                   maxlength="100">
                            <small class="text-secondary-custom">Ej: Martes y Jueves 3:00 PM</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Título del Curso *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $course->title) }}" 
                                   placeholder="Ingrese el título del curso"
                                   required
                                   maxlength="255">
                            <div class="character-count" id="titleCount">{{ strlen($course->title) }}/255 caracteres</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_per_week" class="form-label">Precio por Semana *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price_per_week" name="price_per_week"
                                       step="0.01" min="0" 
                                       value="{{ old('price_per_week', $course->price_per_week) }}" 
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción *</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="4" 
                                  placeholder="Describa el contenido y objetivos del curso..."
                                  required
                                  maxlength="1000">{{ old('description', $course->description) }}</textarea>
                        <div class="character-count" id="descriptionCount">{{ strlen($course->description) }}/1000 caracteres</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ old('start_date', $course->start_date) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="capacity" class="form-label">Cupos Disponibles</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" 
                                   min="1" max="1000" 
                                   value="{{ old('capacity', $course->capacity) }}"
                                   placeholder="Ilimitado">
                            <small class="text-secondary-custom">Dejar vacío para cupos ilimitados</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Imagen del Curso</label>
                            <input type="file" class="form-control" id="imageInput" name="image" accept="image/*" onchange="previewImage(this)">
                            <div class="mt-2" id="imagePreviewContainer">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="image-preview" id="currentImage" alt="Imagen actual del curso">
                                    <small class="text-secondary-custom d-block mt-1" id="imageHint">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Imagen actual. Seleccione una nueva para reemplazar.
                                    </small>
                                @else
                                    <img class="image-preview" id="currentImage" alt="Vista previa" style="display: none;">
                                    <small class="text-secondary-custom d-block mt-1" id="imageHint" style="display: none;">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Nueva imagen seleccionada
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Semanas y Bloques de Evaluación -->
                <div class="form-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="section-title mb-0">
                            <i class="bi bi-layout-text-window-reverse"></i>
                            Estructura del Curso
                        </h3>
                        <small class="text-secondary-custom">
                            <i class="bi bi-arrows-move me-1"></i>
                            Arrastra para reordenar
                        </small>
                    </div>

                    <div id="weeks-container" class="weeks-container">
                        @forelse($combined as $index => $item)
                            @if($item['type'] === 'week')
                                @include('admin.courses.partials.week-block', [
                                    'week' => $item['data'],
                                    'index' => $index,
                                    'course_id' => $course->id,
                                    'allExams' => $allExams,
                                    'resources' => $resources
                                ])
                            @else
                                @include('admin.courses.partials.evaluation-block', [
                                    'evaluationBlock' => $item['data'],
                                    'index' => $index,
                                    'course_id' => $course->id,
                                    'after_week_id' => $item['data']->after_week_id ?? 0,
                                    'allExams' => $allExams,
                                    'resources' => $resources
                                ])
                            @endif
                        @empty
                            <div id="empty-blocks-state" class="empty-blocks-state">
                                <i class="bi bi-inbox"></i>
                                <p>No hay semanas ni bloques de evaluación configurados</p>
                                <small>Usa los botones de arriba para comenzar</small>
                            </div>
                        @endforelse
                    </div>

                    <input type="hidden" name="deleted_weeks[]" id="deletedWeeksContainer">
                    <input type="hidden" name="deleted_evaluation_blocks[]" id="deletedEvaluationBlocksContainer">

                    <div class="d-flex gap-2 mt-3 mobile-stack">
                        <button type="button" class="btn-action btn-success-custom" onclick="addWeek()">
                            <i class="bi bi-plus-circle"></i> Añadir Semana
                        </button>
                        <button type="button" class="btn-action btn-info-custom" onclick="addEvaluationBlock(getLastWeekId())">
                            <i class="bi bi-clipboard-check"></i> Bloque de Evaluación
                        </button>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('admin.courses.index') }}" class="btn-action btn-danger-custom w-100">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <button type="submit" class="btn-action btn-primary-custom w-100">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.nicedit.com/nicEdit-latest.js"></script>
<script>
let descriptionEditor;
// Mover estas variables y funciones FUERA del DOMContentLoaded para que sean globales
let weekIndex = 0;
let draggedItem = null;
let autoScrollInterval = null;

function startAutoScroll(direction) {
    stopAutoScroll();
    if (direction === 0) return;
    autoScrollInterval = setInterval(() => {
        window.scrollBy(0, direction * 20);
    }, 16);
}

function stopAutoScroll() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
        autoScrollInterval = null;
    }
}

// Funciones globales para añadir bloques
window.addWeek = function() {
    fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}`)
        .then(response => response.text())
        .then(html => {
            const container = document.getElementById('weeks-container');
            const div = document.createElement('div');
            div.innerHTML = html;
            
            const newBlock = div.firstElementChild;
            
            // Asegurar que el bloque tenga el atributo de tipo
            newBlock.setAttribute('data-block-type', 'week');
            
            container.appendChild(newBlock);
            setupDragAndDropForElement(newBlock);
            
            weekIndex++;
            hideEmptyState();
            updateBlockOrder();
        })
        .catch(error => {
            console.error('Error al añadir semana:', error);
        });
}

window.addEvaluationBlock = function(afterWeekId = 0) {
    fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}&evaluation=1&after_week_id=${afterWeekId}&course_id={{ $course->id }}`)
        .then(response => response.text())
        .then(html => {
            const container = document.getElementById('weeks-container');
            const div = document.createElement('div');
            div.innerHTML = html;
            
            const newBlock = div.firstElementChild;
            
            // Asegurar que el bloque tenga el atributo de tipo
            newBlock.setAttribute('data-block-type', 'evaluation');
            
            container.appendChild(newBlock);
            setupDragAndDropForElement(newBlock);
            
            weekIndex++;
            hideEmptyState();
            updateBlockOrder();
        })
        .catch(error => {
            console.error('Error al añadir bloque de evaluación:', error);
        });
}

window.removeEvaluation = function(button, blockId = 0) {
    const block = button.closest('.week-block');
    if (confirm('¿Estás seguro de que deseas eliminar este bloque de evaluación?')) {
        // Si tiene ID (ya existe en BD), agregarlo a la lista de eliminados
        if (blockId > 0) {
            // Buscar o crear el contenedor de bloques eliminados
            let deletedContainer = document.getElementById('deletedEvaluationBlocksContainer');
            
            if (!deletedContainer) {
                // Crear el contenedor si no existe
                deletedContainer = document.createElement('div');
                deletedContainer.id = 'deletedEvaluationBlocksContainer';
                document.querySelector('form').appendChild(deletedContainer);
            }
            
            // Crear el input hidden con el ID del bloque a eliminar
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_evaluation_blocks[]';
            input.value = blockId;
            deletedContainer.appendChild(input);
            
            console.log('Bloque de evaluación marcado para eliminar:', blockId);
        }
        
        // Eliminar el bloque del DOM
        block.remove();
        
        // Verificar si quedan bloques
        checkEmptyState();
        
        // Actualizar el orden de bloques
        updateBlockOrder();
    }
}

window.removeWeek = function(button, weekId = 0) {
    const block = button.closest('.week-block');
    if (confirm('¿Estás seguro de que deseas eliminar esta semana?')) {
        // Si tiene ID (ya existe en BD), agregarlo a la lista de eliminados
        if (weekId > 0) {
            // Buscar o crear el contenedor de semanas eliminadas
            let deletedContainer = document.getElementById('deletedWeeksContainer');
            
            if (!deletedContainer) {
                // Crear el contenedor si no existe
                deletedContainer = document.createElement('div');
                deletedContainer.id = 'deletedWeeksContainer';
                document.querySelector('form').appendChild(deletedContainer);
            }
            
            // Crear el input hidden con el ID de la semana a eliminar
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_weeks[]';
            input.value = weekId;
            deletedContainer.appendChild(input);
            
            console.log('Semana marcada para eliminar:', weekId);
        }
        
        // Eliminar el bloque del DOM
        block.remove();
        
        // Verificar si quedan bloques
        checkEmptyState();
        
        // Actualizar el orden de bloques
        updateBlockOrder();
    }
}

window.getLastWeekId = function() {
    const weekBlocks = document.querySelectorAll('.week-block:not(.evaluation-block)');
    if (weekBlocks.length === 0) return 0;
    
    const lastWeek = weekBlocks[weekBlocks.length - 1];
    const idInput = lastWeek.querySelector('input[name*="weeks"][name*="[id]"]');
    return idInput ? (idInput.value || 0) : 0;
}

window.previewImage = function(input) {
    const currentImage = document.getElementById('currentImage');
    const imageHint = document.getElementById('imageHint');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validar tamaño del archivo (2MB máximo)
        if (file.size > 2 * 1024 * 1024) {
            alert('La imagen es demasiado grande. El tamaño máximo es 2MB.');
            input.value = '';
            return;
        }
        
        // Validar tipo de archivo
        if (!file.type.match('image.*')) {
            alert('Por favor seleccione un archivo de imagen válido.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            currentImage.src = e.target.result;
            currentImage.style.display = 'block';
            imageHint.innerHTML = '<i class="bi bi-check-circle me-1"></i>Nueva imagen seleccionada. Se reemplazará al guardar.';
            imageHint.style.display = 'block';
            imageHint.style.color = '#28a745';
        }
        reader.readAsDataURL(file);
    }
}

window.toggleLive = function(index) {
    const container = document.getElementById(`live-container-${index}`);
    const checkbox = document.getElementById(`has-live-${index}`);
    if (container) {
        container.style.display = checkbox.checked ? 'block' : 'none';
    }
}

window.toggleRecorded = function(index) {
    const container = document.getElementById(`recorded-container-${index}`);
    const checkbox = document.getElementById(`has-recorded-${index}`);
    if (container) {
        container.style.display = checkbox.checked ? 'block' : 'none';
    }
}

window.toggleRecordedDays = function(index) {
    const checkbox = document.getElementById(`recorded_checkbox_${index}`);
    const container = document.getElementById(`recorded_days_block_${index}`);
    
    if (!container || !checkbox) return;

    container.style.display = checkbox.checked ? 'block' : 'none';

    // Al activar "Clases grabadas" mostramos y activamos los 7 días
    const dayCheckboxes = container.querySelectorAll(`input.form-check-input[id^="day_${index}_"][data-day]`);
    dayCheckboxes.forEach(cb => {
        cb.checked = checkbox.checked;
        const day = cb.dataset.day;
        const detailsDiv = document.getElementById(`day-${index}-${day}-details`);
        if (detailsDiv) {
            detailsDiv.style.display = checkbox.checked ? 'block' : 'none';

            // Si apagamos el switch general, limpiamos los campos
            if (!checkbox.checked) {
                detailsDiv.querySelectorAll('input[type="text"], input[type="url"]').forEach(input => {
                    input.value = '';
                });
            }
        }
    });
}

window.toggleDayDetails = function(checkbox) {
    const dayNumber = checkbox.dataset.day;
    const weekIndex = checkbox.dataset.weekIndex;
    const detailsDiv = document.getElementById(`day-${weekIndex}-${dayNumber}-details`);
    
    if (detailsDiv) {
        detailsDiv.style.display = checkbox.checked ? 'block' : 'none';
    }
}

// Mostrar/ocultar bloque de recursos (7 días independientes)
window.toggleResourceDays = function(index) {
    const checkbox = document.getElementById(`resources_checkbox_${index}`);
    const container = document.getElementById(`resource_days_block_${index}`);
    if (!container || !checkbox) return;

    container.style.display = checkbox.checked ? 'block' : 'none';

    // Si se apaga, limpiar selects de recursos
    if (!checkbox.checked) {
        const selects = container.querySelectorAll('select');
        selects.forEach(sel => sel.value = '');
    }
}

window.previewExam = function(weekId) {
    window.open(`/admin/weeks/${weekId}/exam`, '_blank');
}

// Cambiar tipo de bloque de evaluación (Universidad / Preparatoria)
window.handleEvaluationTypeChange = function(checkbox) {
    const container = checkbox.closest('.evaluation-block');
    if (!container) return;

    const type = checkbox.checked ? 'preparatoria' : 'universidad';

    // Actualizar input oculto y etiqueta visible del switch
    const typeInput = container.querySelector('input[name*="[evaluation_type]"]');
    const typeLabelSpan = container.querySelector('.form-check-label span');
    if (typeInput) typeInput.value = type;
    if (typeLabelSpan) typeLabelSpan.innerText = type === 'preparatoria' ? 'Preparatoria' : 'Universidad';

    // Etiquetas de categorías según el tipo
    const labels = type === 'preparatoria'
        ? [
            'Pensamiento crítico y resolución de problemas',
            'Comunicación, alfabetización multimodal y cultura',
            'Razonamiento matemático y ciencias de datos',
            'Sociedad, cultura y ciudadanía global',
            'Ciencias y tecnología para el futuro'
        ]
        : [
            'Español',
            'Matemáticas',
            'Área de conocimiento',
            'Habilidades blandas',
            'Inglés'
        ];

    // Actualizar los labels de exámenes dentro de este bloque
    const formGroups = container.querySelectorAll('.mb-3');
    let labelIdx = 0;
    formGroups.forEach(group => {
        const labelEl = group.querySelector('.form-label');
        const hasIcon = labelEl && labelEl.querySelector('i.bi-file-text');
        if (labelEl && hasIcon && labelIdx < labels.length) {
            labelEl.innerHTML = '<i class="bi bi-file-text me-1"></i>' + labels[labelIdx++];
        }
    });
}

// Función para configurar drag and drop en un elemento específico
function setupDragAndDropForElement(element) {
    element.setAttribute('draggable', 'true');
    
    element.addEventListener('dragstart', function(e) {
        draggedItem = this;
        setTimeout(() => this.classList.add('dragging'), 0);
        e.dataTransfer.effectAllowed = 'move';
    });
    
    element.addEventListener('dragend', function() {
        this.classList.remove('dragging');
        document.querySelectorAll('.week-block').forEach(block => {
            block.classList.remove('drag-over');
        });
        stopAutoScroll();
        updateBlockOrder();
    });
    
    element.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });
    
    element.addEventListener('dragenter', function(e) {
        e.preventDefault();
        if (this !== draggedItem) {
            this.classList.add('drag-over');
        }
    });
    
    element.addEventListener('dragleave', function(e) {
        if (!this.contains(e.relatedTarget)) {
            this.classList.remove('drag-over');
        }
    });
    
    element.addEventListener('drop', function(e) {
        e.preventDefault();
        if (this !== draggedItem) {
            const container = document.getElementById('weeks-container');
            const rect = this.getBoundingClientRect();
            const midY = rect.top + rect.height / 2;
            
            if (e.clientY < midY) {
                container.insertBefore(draggedItem, this);
            } else {
                container.insertBefore(draggedItem, this.nextSibling);
            }
        }
        this.classList.remove('drag-over');
    });
}

function updateBlockOrder() {
    const orderContainer = document.getElementById('blockOrderContainer');
    
    if (!orderContainer) {
        console.error('❌ No se encontró el contenedor blockOrderContainer');
        return;
    }
    
    const blocks = document.querySelectorAll('.week-block');
    const order = [];
    let lastWeekId = null; // Guardar el ID real de la última semana
    
    console.log(`📊 Total de bloques encontrados: ${blocks.length}`);
    
    blocks.forEach((block, index) => {
        let idInput = null;
        let blockId = null;
        let type = '';
        
        // Determinar el tipo de bloque
        if (block.classList.contains('evaluation-block') || block.dataset.blockType === 'evaluation') {
            type = 'evaluation';
            idInput = block.querySelector('input[name*="evaluation_blocks"][name*="[id]"]');
            
            // ACTUALIZAR after_week_id PARA BLOQUES DE EVALUACIÓN
            // El bloque de evaluación debe venir después de la última semana
            const afterWeekIdInput = block.querySelector('input[name*="evaluation_blocks"][name*="[after_week_id]"]');
            if (afterWeekIdInput && lastWeekId) {
                afterWeekIdInput.value = lastWeekId;
                console.log(`📝 Actualizando after_week_id de bloque evaluación a ${lastWeekId}`);
            }
        } else {
            type = 'week';
            idInput = block.querySelector('input[name*="weeks"][name*="[id]"]');
            
            // Obtener el ID real de la semana
            if (idInput && idInput.value) {
                lastWeekId = idInput.value;
                console.log(`📍 Semana ID detectada: ${lastWeekId}`);
            }
        }
        
        // Obtener el ID del bloque
        if (idInput) {
            blockId = idInput.value && idInput.value !== '0' && idInput.value !== '' 
                ? idInput.value 
                : `new_${type}_${index}`;
        } else {
            blockId = `new_${type}_${index}`;
        }
        
        order.push({
            id: blockId,
            type: type,
            position: index + 1
        });
        
        // Actualizar los nombres de los inputs para reflejar el nuevo índice
        updateBlockInputNames(block, index, type);
    });
    
    // Convertir a JSON string
    const jsonString = JSON.stringify(order);
    
    // Asignar al input hidden
    orderContainer.value = jsonString;
    
    console.log('✅ Orden actualizado:', order);
    console.log('📤 JSON enviado:', jsonString);
    console.log('📝 Valor del input:', orderContainer.value);
}

function updateBlockInputNames(block, newIndex, type) {
    const prefix = type === 'evaluation' ? 'evaluation_blocks' : 'weeks';
    const inputs = block.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        if (input.name && input.name.includes(prefix)) {
            const regex = new RegExp(`${prefix}\\[\\d+\\]`, 'g');
            input.name = input.name.replace(regex, `${prefix}[${newIndex}]`);
        }
    });
    
    const labels = block.querySelectorAll('label[for]');
    labels.forEach(label => {
        if (label.getAttribute('for')) {
            const forAttr = label.getAttribute('for');
            label.setAttribute('for', forAttr.replace(/_\d+/, `_${newIndex}`));
        }
    });
    
    inputs.forEach(input => {
        if (input.id) {
            input.id = input.id.replace(/_\d+/, `_${newIndex}`);
        }
    });
}

function hideEmptyState() {
    const emptyState = document.getElementById('empty-blocks-state');
    if (emptyState) {
        emptyState.style.display = 'none';
    }
}

function checkEmptyState() {
    const blocks = document.querySelectorAll('.week-block');
    const emptyState = document.getElementById('empty-blocks-state');
    if (emptyState) {
        emptyState.style.display = blocks.length === 0 ? 'block' : 'none';
    }
}

function initializeDragAndDrop() {
    document.querySelectorAll('.week-block').forEach(block => {
        setupDragAndDropForElement(block);
    });
}

function initializeCharacterCounters() {
    const textarea = document.querySelector('textarea[name="description"]');
    if (textarea) {
        const counter = document.getElementById('descriptionCounter');
        if (counter) {
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    }
}

// Colapsar / expandir bloques (acordeón)
window.toggleBlockCollapse = function(button) {
    const block = button.closest('.week-block');
    if (!block) return;

    const isCollapsed = block.classList.contains('collapsed');

    if (isCollapsed) {
        // Al expandir uno, colapsar todos los demás
        document.querySelectorAll('.week-block').forEach(b => {
            b.classList.add('collapsed');
            const icon = b.querySelector('.collapse-toggle-icon');
            if (icon) {
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            }
        });
        block.classList.remove('collapsed');
    } else {
        // Colapsar solo este
        block.classList.add('collapsed');
    }

    const icon = button.querySelector('.collapse-toggle-icon');
    if (icon) {
        if (block.classList.contains('collapsed')) {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        } else {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        }
    }
}

// Función para buscar recursos
window.searchResources = function(weekIndex) {
    const searchInput = document.querySelector(`.resource-search[data-week-index="${weekIndex}"]`);
    const searchTerm = searchInput.value.toLowerCase();
    const container = document.getElementById(`resources-container-${weekIndex}`);
    const resourceItems = container.querySelectorAll('.resource-item');
    
    let visibleCount = 0;
    
    resourceItems.forEach(item => {
        const title = item.dataset.resourceTitle;
        const type = item.dataset.resourceType;
        
        if (title.includes(searchTerm) || type.includes(searchTerm)) {
            item.classList.remove('hidden');
            visibleCount++;
        } else {
            item.classList.add('hidden');
        }
    });
    
    // Mostrar mensaje si no hay resultados
    const noResultsMsg = container.querySelector('.no-results-message');
    if (visibleCount === 0 && !noResultsMsg) {
        const msg = document.createElement('div');
        msg.className = 'no-results-message text-center text-secondary-custom py-3';
        msg.innerHTML = '<i class="bi bi-search"></i><p class="mb-0">No se encontraron recursos</p>';
        container.appendChild(msg);
    } else if (visibleCount > 0 && noResultsMsg) {
        noResultsMsg.remove();
    }
}

// Función para actualizar el contador de recursos seleccionados
function updateResourceCount(weekIndex) {
    const checkboxes = document.querySelectorAll(`input[name="weeks[${weekIndex}][resource_ids][]"]:checked`);
    const counter = document.getElementById(`selected-count-${weekIndex}`);
    
    if (counter) {
        counter.textContent = checkboxes.length;
    }
    
    // Actualizar la lista de badges
    updateSelectedResourcesList(weekIndex);
}

// Función para actualizar la lista visual de recursos seleccionados
function updateSelectedResourcesList(weekIndex) {
    const container = document.getElementById(`selected-resources-${weekIndex}`);
    const checkboxes = document.querySelectorAll(`input[name="weeks[${weekIndex}][resource_ids][]"]:checked`);
    
    if (checkboxes.length > 0) {
        let html = `
            <strong class="small text-primary-custom d-block mb-2">
                <i class="bi bi-bookmarks me-1"></i>Recursos seleccionados:
            </strong>
            <div class="selected-resources-list">
        `;
        
        checkboxes.forEach(checkbox => {
            const label = document.querySelector(`label[for="${checkbox.id}"]`);
            const title = label.querySelector('.fw-bold').textContent;
            html += `<div class="badge bg-primary me-1 mb-1">${title}</div>`;
        });
        
        html += '</div>';
        
        if (!container) {
            const newContainer = document.createElement('div');
            newContainer.id = `selected-resources-${weekIndex}`;
            newContainer.className = 'mt-2 p-2 bg-var-secondary rounded';
            newContainer.innerHTML = html;
            
            const parent = document.getElementById(`resources-container-${weekIndex}`).parentElement;
            parent.appendChild(newContainer);
        } else {
            container.innerHTML = html;
            container.style.display = 'block';
        }
    } else {
        if (container) {
            container.style.display = 'none';
        }
    }
}

// Funciones para búsqueda y selección de recursos (versión simplificada)
function searchResourcesSingle(weekIndex){
    const term = document.querySelector('.resource-search[data-week-index="'+weekIndex+'"]').value.toLowerCase();
    document.querySelectorAll('#resources-container-'+weekIndex+' .resource-item').forEach(item=>{
        const title = item.getAttribute('data-resource-title');
        item.style.display = title.includes(term) ? '' : 'none';
    });
}
function updateSingleResourceSelected(weekIndex){
    const checked = document.querySelector('#resources-container-'+weekIndex+' input.form-check-input:checked');
    const labelSpan = document.getElementById('selected-single-'+weekIndex);
    if(checked){
        const text = checked.closest('.resource-item').querySelector('.fw-bold').textContent.trim();
        labelSpan.textContent = text;
    } else {
        labelSpan.textContent = 'Ninguno';
    }
}

// Inicializar event listeners cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function() {
    // Agregar listeners a los checkboxes de recursos
    document.addEventListener('change', function(e) {
        if (e.target.matches('input[name*="[resource_ids][]"]')) {
            const weekIndex = e.target.closest('.week-block').querySelector('input[name*="[id]"]').name.match(/\[(\d+)\]/)[1];
            updateResourceCount(weekIndex);
        }
    });
    
    // Inicializar contadores al cargar
    document.querySelectorAll('.week-block').forEach((block, index) => {
        updateResourceCount(index);
    });
    
    // Inicializar el índice de semanas basado en bloques existentes
    weekIndex = document.querySelectorAll('.week-block').length;
    
    // Inicializar drag and drop
    initializeDragAndDrop();

    // Auto-scroll al arrastrar cerca de los bordes de la ventana
    document.addEventListener('dragover', function(e) {
        if (!draggedItem) return;

        const threshold = 80; // px desde el borde
        const y = e.clientY;
        const viewportHeight = window.innerHeight;
        let direction = 0;

        if (y < threshold) {
            direction = -1; // subir
        } else if (y > viewportHeight - threshold) {
            direction = 1; // bajar
        }

        startAutoScroll(direction);
    });

    document.addEventListener('drop', function() {
        stopAutoScroll();
    });
    
    // Contador de caracteres
    initializeCharacterCounters();
    
    // Inicializar el orden al cargar
    updateBlockOrder();

    // Iniciar todos los bloques colapsados por defecto
    document.querySelectorAll('.week-block').forEach(block => {
        block.classList.add('collapsed');
        const icon = block.querySelector('.collapse-toggle-icon');
        if (icon) {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    });
});

// NicEdit initialization and syncing for course description
document.addEventListener('DOMContentLoaded', function() {
    // Initialize NicEdit after a brief delay to ensure DOM is ready
    setTimeout(() => {
        descriptionEditor = new nicEditor({ fullPanel: true }).panelInstance('description');
        updateDescriptionCount();
        adjustDescriptionEditorWidth();
        // Hide original textarea after editor is ready
        const descriptionInputEl = document.getElementById('description');
        if (descriptionInputEl) descriptionInputEl.style.display = 'none';
    }, 100);

    const descriptionInput = document.getElementById('description');
    const descriptionCount = document.getElementById('descriptionCount');

    function updateDescriptionCount() {
        if (!descriptionEditor || !descriptionCount) return;
        const content = descriptionEditor.getContent() || '';
        const length = content.replace(/<[^>]*>/g, '').length;
        descriptionCount.textContent = `${length}/1000 caracteres`;
        // Optional visual hints using existing style classes
        descriptionCount.classList.remove('warning', 'danger');
        if (length > 900) {
            descriptionCount.classList.add('danger');
        } else if (length > 750) {
            descriptionCount.classList.add('warning');
        }
    }

    if (descriptionInput) {
        descriptionInput.addEventListener('input', updateDescriptionCount);
    }

    const form = document.querySelector('.form-container form');
    if (form) {
        form.addEventListener('submit', function() {
            if (descriptionEditor && descriptionInput) {
                descriptionInput.value = descriptionEditor.getContent();
            }
        });
    }
    
    // Adjust editor width to match container and observe resizing
    function adjustDescriptionEditorWidth() {
        const textarea = document.getElementById('description');
        const fieldContainer = textarea ? (textarea.closest('.mb-3') || textarea.parentElement) : null;
        const fallbackContainer = document.querySelector('.form-container');
        const containerWidth = fieldContainer ? fieldContainer.getBoundingClientRect().width : (fallbackContainer ? fallbackContainer.getBoundingClientRect().width : null);
        if (!containerWidth) return;

        const scope = fieldContainer || document;
        const panel = scope.querySelector('.nicEdit-panelContain');
        const main = scope.querySelector('.nicEdit-main');
        const container = scope.querySelector('.nicEdit-container') || (panel ? panel.parentElement : null);
        const parent1 = main ? main.parentElement : null;
        const parent2 = parent1 ? parent1.parentElement : null;
        [panel, main, container, parent1, parent2].forEach(el => {
            if (el) {
                el.style.width = containerWidth + 'px';
                el.style.maxWidth = '100%';
                el.style.boxSizing = 'border-box';
                el.style.float = 'none';
                el.style.display = 'block';
            }
        });
    }

    (function setupDescriptionWidthObserver(){
        const textarea = document.getElementById('description');
        const fieldContainer = textarea ? (textarea.closest('.mb-3') || textarea.parentElement) : null;
        if (fieldContainer && window.ResizeObserver) {
            const ro = new ResizeObserver(() => adjustDescriptionEditorWidth());
            ro.observe(fieldContainer);
        }
        window.addEventListener('resize', adjustDescriptionEditorWidth);
        // Mutation observer to catch NicEdit DOM insertion
        const mo = new MutationObserver(() => adjustDescriptionEditorWidth());
        mo.observe(fieldContainer || document.body, { childList: true, subtree: true });
    })();
});
</script>
@endsection