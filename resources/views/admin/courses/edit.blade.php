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
    }

    .week-block:hover {
        border-color: var(--btn-primary-bg);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .week-block.dragging {
        opacity: 0.6;
        transform: rotate(5deg);
        border: 2px dashed var(--btn-primary-bg);
    }

    .week-block.drag-over {
        border: 2px dashed #28a745;
        background-color: var(--hover-bg);
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
    }

    .drag-handle:hover {
        color: var(--text-primary);
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    .weeks-container {
        min-height: 100px;
        transition: all 0.3s ease;
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
            <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data" id="courseForm">
                @csrf
                @method('PUT')

                <!-- Información Básica -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Información Básica del Curso
                    </h3>
                    
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
                                   value="{{ old('start_date', $course->start_date) }}"
                                   min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Imagen del Curso</label>
                            <input type="file" class="form-control" name="image" accept="image/*" onchange="previewImage(this)">
                            @if($course->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $course->image) }}" class="image-preview" alt="Imagen actual del curso">
                                    <small class="text-secondary-custom d-block mt-1">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Imagen actual. Seleccione una nueva para reemplazar.
                                    </small>
                                </div>
                            @endif
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
                        @if(count($combined) > 0)
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
                        @else
                            <div class="empty-blocks-state">
                                <i class="bi bi-layout-text-window-reverse"></i>
                                <h5 class="text-secondary-custom">No hay semanas configuradas</h5>
                                <p class="text-secondary-custom">Comienza añadiendo semanas o bloques de evaluación</p>
                            </div>
                        @endif
                    </div>

                    <input type="hidden" name="deleted_weeks[]" id="deletedWeeksContainer">
                    <input type="hidden" name="deleted_evaluation_blocks[]" id="deletedEvaluationBlocksContainer">
                    <input type="hidden" name="block_order[]" id="blockOrderContainer">

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    let weekIndex = document.querySelectorAll('.week-block').length;
    let draggedItem = null;

    // Inicializar drag and drop
    initializeDragAndDrop();

    // Contador de caracteres
    initializeCharacterCounters();

    // Función para inicializar drag and drop
    function initializeDragAndDrop() {
        const container = document.getElementById('weeks-container');
        
        // Hacer todos los bloques arrastrables
        document.querySelectorAll('.week-block').forEach(block => {
            block.setAttribute('draggable', 'true');
            
            block.addEventListener('dragstart', function(e) {
                draggedItem = this;
                setTimeout(() => this.classList.add('dragging'), 0);
                e.dataTransfer.effectAllowed = 'move';
            });
            
            block.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                updateBlockOrder();
            });
        });

        // Configurar el contenedor para recibir elementos arrastrados
        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            const afterElement = getDragAfterElement(container, e.clientY);
            const draggable = document.querySelector('.dragging');
            
            if (afterElement == null) {
                container.appendChild(draggable);
            } else {
                container.insertBefore(draggable, afterElement);
            }
        });

        container.addEventListener('dragenter', function(e) {
            e.preventDefault();
            this.style.backgroundColor = 'var(--hover-bg)';
        });

        container.addEventListener('dragleave', function() {
            this.style.backgroundColor = '';
        });

        container.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.backgroundColor = '';
        });
    }

    // Función para determinar la posición del arrastre
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.week-block:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    // Actualizar el orden de los bloques
    function updateBlockOrder() {
        const orderContainer = document.getElementById('blockOrderContainer');
        const blocks = document.querySelectorAll('.week-block');
        const order = [];
        
        blocks.forEach((block, index) => {
            const blockId = block.querySelector('input[name*="[id]"]')?.value;
            const isEvaluation = block.classList.contains('evaluation-block');
            const type = isEvaluation ? 'evaluation' : 'week';
            
            if (blockId) {
                order.push({
                    id: blockId,
                    type: type,
                    position: index
                });
            }
        });
        
        orderContainer.value = JSON.stringify(order);
    }

    // Inicializar contadores de caracteres
    function initializeCharacterCounters() {
        const titleInput = document.getElementById('title');
        const titleCount = document.getElementById('titleCount');
        const descriptionInput = document.getElementById('description');
        const descriptionCount = document.getElementById('descriptionCount');
        
        if (titleInput && titleCount) {
            titleInput.addEventListener('input', function() {
                updateCharacterCounter(this, titleCount, 255);
            });
        }
        
        if (descriptionInput && descriptionCount) {
            descriptionInput.addEventListener('input', function() {
                updateCharacterCounter(this, descriptionCount, 1000);
            });
        }
    }

    function updateCharacterCounter(input, counter, max) {
        const length = input.value.length;
        counter.textContent = `${length}/${max} caracteres`;
        counter.className = 'character-count' + (length > max * 0.9 ? ' text-danger' : length > max * 0.75 ? ' text-warning' : '');
    }

    // Funciones existentes con mejoras
    window.addWeek = function() {
        fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}`)
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('weeks-container');
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div);
                
                // Actualizar drag and drop para el nuevo elemento
                const newBlock = container.lastElementChild;
                newBlock.setAttribute('draggable', 'true');
                initializeDragAndDrop();
                
                weekIndex++;
                hideEmptyState();
            });
    }

    window.addEvaluationBlock = function(afterWeekId = 0) {
        fetch(`{{ route('admin.courses.week-block') }}?index=${weekIndex}&evaluation=1&after_week_id=${afterWeekId}&course_id={{ $course->id }}`)
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('weeks-container');
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div);
                
                // Actualizar drag and drop para el nuevo elemento
                const newBlock = container.lastElementChild;
                newBlock.setAttribute('draggable', 'true');
                initializeDragAndDrop();
                
                weekIndex++;
                hideEmptyState();
            });
    }

    window.removeWeek = function(button, weekId = 0) {
        if (confirm("¿Estás seguro de eliminar esta semana?")) {
            const block = button.closest('.week-block');
            if (weekId && weekId !== 0) {
                const container = document.getElementById('deletedWeeksContainer');
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "deleted_weeks[]";
                input.value = weekId;
                container.parentNode.appendChild(input);
            }
            block.remove();
            checkEmptyState();
            updateBlockOrder();
        }
    }

    window.removeEvaluation = function(button, blockId = 0) {
        if (confirm("¿Eliminar bloque de evaluación?")) {
            const block = button.closest('.week-block');
            if (blockId && blockId !== 0) {
                const container = document.getElementById('deletedEvaluationBlocksContainer');
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "deleted_evaluation_blocks[]";
                input.value = blockId;
                container.parentNode.appendChild(input);
            }
            block.remove();
            checkEmptyState();
            updateBlockOrder();
        }
    }

    window.getLastWeekId = function() {
        const weeks = document.querySelectorAll('.week-block');
        let lastId = 0;

        weeks.forEach(w => {
            const idInput = w.querySelector('input[name*="[id]"]');
            if (idInput && !w.classList.contains('evaluation-block')) {
                const id = parseInt(idInput.value);
                if (!isNaN(id)) {
                    lastId = id;
                }
            }
        });

        return lastId;
    }

    // Funciones para mostrar/ocultar estado vacío
    function hideEmptyState() {
        const emptyState = document.querySelector('.empty-blocks-state');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
    }

    function checkEmptyState() {
        const container = document.getElementById('weeks-container');
        const blocks = container.querySelectorAll('.week-block');
        
        if (blocks.length === 0) {
            let emptyState = container.querySelector('.empty-blocks-state');
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'empty-blocks-state';
                emptyState.innerHTML = `
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <h5 class="text-secondary-custom">No hay semanas configuradas</h5>
                    <p class="text-secondary-custom">Comienza añadiendo semanas o bloques de evaluación</p>
                `;
                container.appendChild(emptyState);
            }
            emptyState.style.display = 'block';
        }
    }

    // Previsualización de imagen
    window.previewImage = function(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = input.parentNode.querySelector('.image-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.className = 'image-preview';
                    input.parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Funciones existentes para toggles
    window.toggleLive = function(index) {
        const block = document.getElementById(`live_link_block_${index}`);
        const checkbox = document.getElementById(`live_checkbox_${index}`);
        if (block && checkbox) {
            block.style.display = checkbox.checked ? 'block' : 'none';
        }
    }

    window.toggleRecorded = function(index) {
        const block = document.getElementById(`recorded_days_block_${index}`);
        const checkbox = document.getElementById(`recorded_checkbox_${index}`);
        if (block && checkbox) {
            block.style.display = checkbox.checked ? 'block' : 'none';
        }
    }

    window.toggleDayDetails = function(checkbox) {
        const details = checkbox.closest('.col-md-12').querySelector('.day-details');
        if (details) {
            details.style.display = checkbox.checked ? 'block' : 'none';
        }
    }

    window.previewExam = function(weekId) {
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

    // Inicializar el orden al cargar
    updateBlockOrder();
});
</script>
@endsection