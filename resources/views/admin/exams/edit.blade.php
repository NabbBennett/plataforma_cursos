@extends('layouts.admin')

@section('title', 'Editar Examen')
@include('layouts.help')

@section('content')
<style>
    .math-preview-container {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        display: none;
    }

    .math-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .btn-toggle-preview {
        background: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        border-radius: 4px;
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-toggle-preview:hover {
        background: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
    }

    .math-preview-content {
        min-height: 60px;
        background-color: var(--bg-primary);
        padding: 1rem;
        border-radius: 4px;
        border: 1px solid var(--border-color);
    }

    /* Estilos para fórmulas MathJax */
    .math-preview-content mjx-container {
        display: inline-block;
        margin: 0 0.2em;
        vertical-align: middle;
    }

    .math-preview-content mjx-container[jax="CHTML"][display="true"] {
        display: block;
        margin: 1em 0;
        text-align: center;
    }

    /* Estilos para CKEditor */
    .ck-editor__editable_inline {
        min-height: 150px;
        background-color: var(--bg-primary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
    }

    .ck-editor__editable_inline.answer-editor {
        min-height: 100px;
    }

    .ck.ck-toolbar {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-bottom: none;
    }

    .ck.ck-editor__main .ck-editor__editable {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .math-preview-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
        
        .btn-toggle-preview {
            width: 100%;
            text-align: center;
        }
    }

    /*CKEditor Custom Styles*/
    .ck-editor__editable_inline {
        min-height: 150px;
    }

    .ck-editor__editable_inline.answer-editor {
        min-height: 100px; 
    }

    .exam-create-container {
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

    .question-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .question-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--border-color);
    }

    .question-number {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .btn-remove {
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .btn-add {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-add:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    a.btn-outline-secondary {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        margin: 0 !important;
    }

    .btn-submit:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .form-label {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 0.75rem;
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--bg-primary);
        border-color: var(--btn-primary-bg);
        color: var(--text-primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--btn-primary-bg-rgb), 0.25);
    }

    .answer-option {
        margin-bottom: 1rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-secondary);
    }

    .answer-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .answer-label {
        font-weight: 600;
        color: var(--text-primary);
    }

    .correct-badge {
        background-color: #28a745;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .incorrect-badge {
        background-color: #6c757d;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .file-upload-container {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: var(--bg-primary);
    }

    .file-upload-container:hover {
        border-color: var(--btn-primary-bg);
        background-color: var(--hover-bg);
    }

    .file-upload-container.dragover {
        border-color: var(--btn-primary-bg);
        background-color: var(--hover-bg);
    }

    .file-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 0.5rem;
    }

    .input-type-toggle {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .toggle-btn {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-btn.active {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border-color: var(--btn-primary-bg);
    }

    .text-input, .image-input {
        display: none;
    }

    .text-input.active, .image-input.active {
        display: block;
    }

    .alert-custom {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    .ckeditor-container {
        margin-bottom: 1rem;
    }

    .image-preview-container {
        margin-top: 1rem;
    }

    .image-preview {
        max-width: 300px;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .input-type-section {
        margin-bottom: 1rem;
    }

    .type-toggle-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .exam-create-container {
            padding: 1rem 0;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-container {
            padding: 1rem;
        }

        .question-card {
            padding: 1rem;
        }

        .input-type-toggle {
            flex-direction: column;
            gap: 0.5rem;
        }

        .toggle-btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .form-container {
            padding: 0.75rem;
        }

        .question-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }

    /* AGREGAR AL CSS EXISTENTE */
.existing-image-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 4px;
    font-size: 0.8rem;
}

.image-preview-container {
    transition: all 0.3s ease;
}

.image-preview {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Asegurar que las previsualizaciones sean visibles */
.image-input.active .image-preview-container {
    display: block !important;
}

.text-input.active .image-preview-container {
    display: none !important;
}
</style>

<div class="exam-create-container">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2"><i class="bi bi-pencil-square me-2"></i>Editar Examen</h1>
                    <p class="mb-0 text-muted">Modifica el examen existente con todas las opciones avanzadas</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver a Exámenes
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-custom mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form id="exam-form" method="POST" action="{{ route('admin.exams.update', $exam->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título del examen</label>
                            <input type="text" name="title" class="form-control" required 
                                   placeholder="Ej: Examen de Matemáticas - Unidad 1"
                                   value="{{ old('title', $exam->title) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duration_minutes" class="form-label">Duración (minutos)</label>
                            <input type="number" name="duration_minutes" class="form-control" required 
                                   min="1" max="480" value="{{ old('duration_minutes', $exam->duration_minutes) }}"
                                   placeholder="Ej: 60">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="mb-4"><i class="bi bi-question-circle me-2"></i>Preguntas del Examen</h4>

                <div id="questions-container"></div>

                <div class="text-center mt-4">
                    <button type="button" class="btn-add" onclick="addQuestion()">
                        <i class="bi bi-plus-circle"></i> Añadir Nueva Pregunta
                    </button>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-4 pt-4 border-top">
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle me-1"></i> Actualizar Examen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="question-template">
    <div class="question-card" data-index="__INDEX__">
        <div class="question-header">
            <h5 class="question-number mb-0">Pregunta <span class="question-number-display"></span></h5>
            <button type="button" class="btn-remove" onclick="removeQuestion(this)">
                <i class="bi bi-trash me-1"></i> Eliminar
            </button>
        </div>

        <!-- Campos ocultos para IDs existentes -->
        <input type="hidden" name="questions[__INDEX__][id]" value="__QUESTION_ID__">

        <div class="input-type-section">
            <label class="type-toggle-label">Tipo de pregunta:</label>
            <div class="input-type-toggle">
                <button type="button" class="toggle-btn active" data-type="text" onclick="toggleQuestionInputType(this, '__INDEX__')">
                    <i class="bi bi-text-paragraph me-1"></i> Texto
                </button>
                <button type="button" class="toggle-btn" data-type="image" onclick="toggleQuestionInputType(this, '__INDEX__')">
                    <i class="bi bi-image me-1"></i> Imagen
                </button>
            </div>
        </div>

        <div class="mb-3 text-input active" id="question-text-__INDEX__">
            <label class="form-label">Texto de la pregunta</label>
            <textarea name="questions[__INDEX__][text]" class="form-control ckeditor-text" 
                      id="editor-question-__INDEX__" data-editor-type="question" 
                      placeholder="Escribe la pregunta aquí...">__QUESTION_TEXT__</textarea>
        </div>

        <div class="mb-3 image-input" id="question-image-__INDEX__">
            <label class="form-label">Imagen de la pregunta</label>
            <div class="file-upload-container" onclick="document.getElementById('question-image-input-__INDEX__').click()">
                <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                <p class="mb-1">Haz clic para subir una imagen</p>
                <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                <input type="file" name="questions[__INDEX__][image]" 
                       id="question-image-input-__INDEX__" 
                       class="d-none" accept="image/*"
                       onchange="previewQuestionImage(this, '__INDEX__')">
            </div>
            <div class="image-preview-container" id="question-image-preview-__INDEX__">
                __QUESTION_IMAGE_PREVIEW__
            </div>
            <input type="hidden" name="questions[__INDEX__][existing_image]" value="__QUESTION_EXISTING_IMAGE__">
        </div>

        <div class="mb-3">
            <label class="form-label">Tema o categoría (opcional)</label>
            <input type="text" name="questions[__INDEX__][theme]" class="form-control" 
                   placeholder="Ej: Álgebra, Trigonometría, etc." value="__QUESTION_THEME__">
        </div>

        <div class="answers-container">
            <!-- Respuesta correcta -->
            <div class="answer-option">
                <div class="answer-header">
                    <span class="answer-label">Respuesta correcta</span>
                    <span class="correct-badge">Correcta</span>
                </div>
                
                <input type="hidden" name="questions[__INDEX__][correct_id]" value="__CORRECT_ANSWER_ID__">
                
                <div class="input-type-toggle mb-2">
                    <button type="button" class="toggle-btn active" data-type="text" onclick="toggleAnswerInputType(this, '__INDEX__', 'correct')">
                        <i class="bi bi-text-paragraph me-1"></i> Texto
                    </button>
                    <button type="button" class="toggle-btn" data-type="image" onclick="toggleAnswerInputType(this, '__INDEX__', 'correct')">
                        <i class="bi bi-image me-1"></i> Imagen
                    </button>
                </div>
                
                <div class="text-input active" id="correct-text-__INDEX__">
                    <textarea name="questions[__INDEX__][correct]" class="form-control ckeditor-answer" 
                              id="editor-correct-__INDEX__" data-editor-type="answer" 
                              placeholder="Escribe la respuesta correcta...">__CORRECT_ANSWER_TEXT__</textarea>
                </div>
                
                <div class="image-input" id="correct-image-__INDEX__">
                    <div class="file-upload-container" onclick="document.getElementById('correct-image-input-__INDEX__').click()">
                        <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                        <p class="mb-1">Haz clic para subir una imagen</p>
                        <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                        <input type="file" name="questions[__INDEX__][correct_image]" 
                               id="correct-image-input-__INDEX__" 
                               class="d-none" accept="image/*"
                               onchange="previewAnswerImage(this, '__INDEX__', 'correct')">
                    </div>
                    <div class="image-preview-container" id="correct-image-preview-__INDEX__">
                        __CORRECT_ANSWER_IMAGE_PREVIEW__
                    </div>
                    <input type="hidden" name="questions[__INDEX__][correct_existing_image]" value="__CORRECT_ANSWER_EXISTING_IMAGE__">
                </div>
            </div>

            <!-- Respuestas incorrectas -->
            @foreach(['wrong1', 'wrong2', 'wrong3'] as $wrongIndex)
            <div class="answer-option">
                <div class="answer-header">
                    <span class="answer-label">Respuesta incorrecta {{ $loop->iteration }}</span>
                    <span class="incorrect-badge">{{ $loop->first ? 'Obligatoria' : 'Opcional' }}</span>
                </div>
                
                <input type="hidden" name="questions[__INDEX__][{{ $wrongIndex }}_id]" value="__{{ strtoupper($wrongIndex) }}_ANSWER_ID__">
                
                <div class="input-type-toggle mb-2">
                    <button type="button" class="toggle-btn active" data-type="text" onclick="toggleAnswerInputType(this, '__INDEX__', '{{ $wrongIndex }}')">
                        <i class="bi bi-text-paragraph me-1"></i> Texto
                    </button>
                    <button type="button" class="toggle-btn" data-type="image" onclick="toggleAnswerInputType(this, '__INDEX__', '{{ $wrongIndex }}')">
                        <i class="bi bi-image me-1"></i> Imagen
                    </button>
                </div>
                
                <div class="text-input active" id="{{ $wrongIndex }}-text-__INDEX__">
                    <textarea name="questions[__INDEX__][{{ $wrongIndex }}]" class="form-control ckeditor-answer" 
                              id="editor-{{ $wrongIndex }}-__INDEX__" data-editor-type="answer" 
                              placeholder="Escribe una respuesta incorrecta{{ !$loop->first ? ' (opcional)' : '' }}...">__{{ strtoupper($wrongIndex) }}_ANSWER_TEXT__</textarea>
                </div>
                
                <div class="image-input" id="{{ $wrongIndex }}-image-__INDEX__">
                    <div class="file-upload-container" onclick="document.getElementById('{{ $wrongIndex }}-image-input-__INDEX__').click()">
                        <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                        <p class="mb-1">Haz clic para subir una imagen</p>
                        <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                        <input type="file" name="questions[__INDEX__][{{ $wrongIndex }}_image]" 
                               id="{{ $wrongIndex }}-image-input-__INDEX__" 
                               class="d-none" accept="image/*"
                               onchange="previewAnswerImage(this, '__INDEX__', '{{ $wrongIndex }}')">
                    </div>
                    <div class="image-preview-container" id="{{ $wrongIndex }}-image-preview-__INDEX__">
                        __{{ strtoupper($wrongIndex) }}_ANSWER_IMAGE_PREVIEW__
                    </div>
                    <input type="hidden" name="questions[__INDEX__][{{ $wrongIndex }}_existing_image]" value="__{{ strtoupper($wrongIndex) }}_ANSWER_EXISTING_IMAGE__">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</template>
@endsection

@section('scripts')

{{-- CKEditor 5 Classic Build --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

{{-- MathJax para renderizado de fórmulas --}}
<script>
window.MathJax = {
    tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']],
        packages: { '[+]': ['mhchem'] }
    },
    svg: { 
        fontCache: 'global',
        scale: 0.9
    },
    startup: {
        typeset: false
    }
};
</script>
<script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<script>
let questionIndex = 0;
const ckeditorInstances = {}; 

// Datos del examen para edición
const examData = @json($examData ?? []);

function addQuestion(questionData = {}) {
    const template = document.getElementById('question-template').innerHTML;
    
    // Determinar si la pregunta tiene imagen existente
    const questionHasImage = !!(questionData.image_path || questionData.existing_image);
    
    // Preparar datos para la plantilla con valores por defecto seguros
    const templateData = {
        '__INDEX__': questionIndex,
        '__QUESTION_ID__': questionData.id || '',
        '__QUESTION_TEXT__': questionData.text || '',
        '__QUESTION_THEME__': questionData.theme || '',
        '__QUESTION_IMAGE_PREVIEW__': questionData.image_preview || '',
        '__QUESTION_EXISTING_IMAGE__': questionData.existing_image || '',
        '__CORRECT_ANSWER_ID__': questionData.correct_id || '',
        '__CORRECT_ANSWER_TEXT__': questionData.correct_text || '',
        '__CORRECT_ANSWER_IMAGE_PREVIEW__': questionData.correct_image_preview || '',
        '__CORRECT_ANSWER_EXISTING_IMAGE__': questionData.correct_existing_image || '',
        '__WRONG1_ANSWER_ID__': questionData.wrong1_id || '',
        '__WRONG1_ANSWER_TEXT__': questionData.wrong1_text || '',
        '__WRONG1_ANSWER_IMAGE_PREVIEW__': questionData.wrong1_image_preview || '',
        '__WRONG1_ANSWER_EXISTING_IMAGE__': questionData.wrong1_existing_image || '',
        '__WRONG2_ANSWER_ID__': questionData.wrong2_id || '',
        '__WRONG2_ANSWER_TEXT__': questionData.wrong2_text || '',
        '__WRONG2_ANSWER_IMAGE_PREVIEW__': questionData.wrong2_image_preview || '',
        '__WRONG2_ANSWER_EXISTING_IMAGE__': questionData.wrong2_existing_image || '',
        '__WRONG3_ANSWER_ID__': questionData.wrong3_id || '',
        '__WRONG3_ANSWER_TEXT__': questionData.wrong3_text || '',
        '__WRONG3_ANSWER_IMAGE_PREVIEW__': questionData.wrong3_image_preview || '',
        '__WRONG3_ANSWER_EXISTING_IMAGE__': questionData.wrong3_existing_image || ''
    };

    let html = template;
    Object.keys(templateData).forEach(key => {
        html = html.replace(new RegExp(key, 'g'), templateData[key]);
    });

    const div = document.createElement('div');
    div.innerHTML = html;
    document.getElementById('questions-container').appendChild(div);
    
    // Actualizar número de pregunta
    div.querySelector('.question-number-display').textContent = questionIndex + 1;
    
    // NUEVO: Determinar qué modo activar por defecto
    const currentIndex = questionIndex;
    
    setTimeout(() => {
        // CONFIGURAR TIPOS DE INPUT BASADO EN CONTENIDO EXISTENTE
        
        // PREGUNTA: Si tiene texto, activar modo texto; si solo imagen, modo imagen
        const hasQuestionText = !!(questionData.text && questionData.text.trim());
        
        if (!hasQuestionText && questionHasImage) {
            // Solo imagen - activar modo imagen
            const imageBtn = div.querySelector('.input-type-toggle .toggle-btn[data-type="image"]');
            if (imageBtn) {
                imageBtn.click();
            }
            
            // Mostrar preview de imagen existente
            if (questionData.image_path) {
                const previewContainer = document.getElementById(`question-image-preview-${currentIndex}`);
                if (previewContainer) {
                    previewContainer.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = questionData.image_path;
                    img.className = 'image-preview';
                    img.alt = 'Imagen de pregunta existente';
                    previewContainer.appendChild(img);
                    previewContainer.style.display = 'block';
                }
            }
        } else {
            // Tiene texto (o nada) - modo texto activo por defecto
            // Inicializar CKEditor para pregunta
            setTimeout(() => initializeCKEditor(currentIndex, 'question'), 150);
        }
        
        // RESPUESTA CORRECTA
        const hasCorrectText = !!(questionData.correct_text && questionData.correct_text.trim());
        
        if (!hasCorrectText && questionData.correct_image_path) {
            // Solo imagen
            const imageBtn = div.querySelector('.answer-option:first-child .toggle-btn[data-type="image"]');
            if (imageBtn) {
                imageBtn.click();
            }
            
            const previewContainer = document.getElementById(`correct-image-preview-${currentIndex}`);
            if (previewContainer && questionData.correct_image_path) {
                previewContainer.innerHTML = '';
                const img = document.createElement('img');
                img.src = questionData.correct_image_path;
                img.className = 'image-preview';
                previewContainer.appendChild(img);
                previewContainer.style.display = 'block';
            }
        } else {
            // Tiene texto - inicializar CKEditor
            setTimeout(() => initializeCKEditor(currentIndex, 'correct'), 150);
        }
        
        // RESPUESTAS INCORRECTAS
        ['wrong1', 'wrong2', 'wrong3'].forEach((wrongType, idx) => {
            const textKey = `${wrongType}_text`;
            const imageKey = `${wrongType}_image_path`;
            const hasText = !!(questionData[textKey] && questionData[textKey].trim());
            
            if (!hasText && questionData[imageKey]) {
                // Solo imagen
                const answerOptions = div.querySelectorAll('.answer-option');
                const targetIndex = idx + 1;
                if (answerOptions[targetIndex]) {
                    const imageBtn = answerOptions[targetIndex].querySelector('.toggle-btn[data-type="image"]');
                    if (imageBtn) {
                        imageBtn.click();
                    }
                }
                
                const previewContainer = document.getElementById(`${wrongType}-image-preview-${currentIndex}`);
                if (previewContainer && questionData[imageKey]) {
                    previewContainer.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = questionData[imageKey];
                    img.className = 'image-preview';
                    previewContainer.appendChild(img);
                    previewContainer.style.display = 'block';
                }
            } else if (hasText || (!hasText && !questionData[imageKey])) {
                // Tiene texto o está vacío - inicializar CKEditor
                setTimeout(() => initializeCKEditor(currentIndex, wrongType), 150);
            }
        });
        
        // Crear previsualizaciones MathJax después de que se inicialicen los editores
        setTimeout(() => createMathPreviews(), 300);
        
    }, 100);
    
    questionIndex++;
}

// MODIFICAR LAS FUNCIONES TOGGLE PARA MANEJAR MEJOR LOS ESTADOS
function toggleQuestionInputType(button, index) {
    const type = button.dataset.type;
    const container = button.closest('.input-type-toggle');
    
    // Actualizar botones activos
    container.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
    
    // Mostrar/ocultar inputs
    document.getElementById(`question-text-${index}`).classList.toggle('active', type === 'text');
    document.getElementById(`question-image-${index}`).classList.toggle('active', type === 'image');

    if (type === 'text') {
        // Destruir editor si existe y reinicializar
        destroyCKEditorInstances(index, 'question');
        setTimeout(() => initializeCKEditor(index, 'question'), 100);
    } else {
        // Modo imagen - destruir editor
        destroyCKEditorInstances(index, 'question');
    }
}

function toggleAnswerInputType(button, index, answerType) {
    const type = button.dataset.type;
    const container = button.closest('.input-type-toggle');
    
    // Actualizar botones activos
    container.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
    
    // Mostrar/ocultar inputs
    document.getElementById(`${answerType}-text-${index}`).classList.toggle('active', type === 'text');
    document.getElementById(`${answerType}-image-${index}`).classList.toggle('active', type === 'image');

    if (type === 'text') {
        // Destruir editor si existe y reinicializar
        destroyCKEditorInstances(index, answerType);
        setTimeout(() => initializeCKEditor(index, answerType), 100);
    } else {
        // Modo imagen - destruir editor
        destroyCKEditorInstances(index, answerType);
    }
}

// AGREGAR FUNCIÓN PARA FORZAR VISUALIZACIÓN DE IMÁGENES EXISTENTES
function forceImagePreview(elementKey, imageUrl) {
    const previewContainer = document.getElementById(`${elementKey}-image-preview`);
    if (previewContainer && imageUrl) {
        previewContainer.innerHTML = '';
        const img = document.createElement('img');
        img.src = imageUrl;
        img.className = 'image-preview';
        img.alt = 'Imagen existente';
        previewContainer.appendChild(img);
    }
}

// FUNCIÓN PARA ACTUALIZAR VISIBILIDAD DE PREVIEW DE IMÁGENES EXISTENTES
function updateImagePreviewVisibility(index, elementType, inputType) {
    const previewContainers = [
        `question-image-preview-${index}`,
        `correct-image-preview-${index}`,
        `wrong1-image-preview-${index}`,
        `wrong2-image-preview-${index}`,
        `wrong3-image-preview-${index}`
    ];
    
    previewContainers.forEach(containerId => {
        const container = document.getElementById(containerId);
        if (container) {
            // Mostrar previsualización solo si estamos en modo imagen Y hay imagen existente
            const hasExistingImage = container.querySelector('img') !== null;
            const shouldShow = inputType === 'image' && hasExistingImage;
            
            container.style.display = shouldShow ? 'block' : 'none';
            
            // Si estamos cambiando a modo texto y hay imagen existente, mostrar advertencia
            if (inputType === 'text' && hasExistingImage) {
                const existingWarning = container.querySelector('.existing-image-warning');
                if (!existingWarning) {
                    const warning = document.createElement('div');
                    warning.className = 'existing-image-warning alert alert-warning mt-2 p-2 small';
                    warning.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Esta pregunta tiene una imagen existente. Al guardar en modo texto, la imagen se eliminará.';
                    container.appendChild(warning);
                }
            } else {
                // Remover advertencia si existe
                const existingWarning = container.querySelector('.existing-image-warning');
                if (existingWarning) {
                    existingWarning.remove();
                }
            }
        }
    });
}

// FUNCIÓN PARA MOSTRAR IMAGEN INMEDIATAMENTE AL CAMBIAR A MODO IMAGEN
function showExistingImagesImmediately(index) {
    const previewContainers = [
        `question-image-preview-${index}`,
        `correct-image-preview-${index}`,
        `wrong1-image-preview-${index}`,
        `wrong2-image-preview-${index}`,
        `wrong3-image-preview-${index}`
    ];
    
    previewContainers.forEach(containerId => {
        const container = document.getElementById(containerId);
        if (container) {
            const img = container.querySelector('img');
            if (img) {
                img.style.display = 'block';
                container.style.display = 'block';
            }
        }
    });
}

// Inicialización para edición
document.addEventListener('DOMContentLoaded', function() {
    // Cargar preguntas existentes
    if (examData.questions && examData.questions.length > 0) {
        examData.questions.forEach(question => {
            // Verificar que la pregunta tenga datos válidos
            if (question && typeof question === 'object') {
                addQuestion(question);
            }
        });
    } else {
        // Agregar una pregunta vacía si no hay preguntas
        addQuestion();
    }
    
    // Configurar observador de visibilidad
    setupVisibilityObserver();
    
    // Inicializar MathJax cuando esté listo
    if (window.MathJax) {
        MathJax.startup.promise.then(() => {
            console.log('MathJax cargado correctamente para edición');
            createMathPreviews();
        }).catch(error => {
            console.warn('Error cargando MathJax:', error);
        });
    }
    
    // Validación del formulario (igual que en create)
    document.getElementById('exam-form').addEventListener('submit', function(e) {
        let isValid = true;
        const questions = document.querySelectorAll('.question-card');
        
        if (questions.length === 0) {
            alert('Debe haber al menos una pregunta en el examen.');
            isValid = false;
        }
        
        questions.forEach((question, index) => {
            const qEditor = ckeditorInstances[`question-${index}`];
            let questionText = '';
            
            if (qEditor) {
                questionText = qEditor.getData();
            } else {
                questionText = document.querySelector(`#editor-question-${index}`)?.value || '';
            }
            
            const questionImage = document.querySelector(`#question-image-input-${index}`)?.files[0];
            const hasExistingImage = document.querySelector(`input[name="questions[${index}][existing_image]"]`)?.value;
            
            if (!questionText.trim() && !questionImage && !hasExistingImage) {
                alert(`La pregunta ${index + 1} debe tener texto o una imagen.`);
                isValid = false;
            }
            
            // Validar que al menos la primera respuesta incorrecta tenga contenido
            const wrongKey = `wrong1-${index}`;
            let wrong1Text = '';
            if (ckeditorInstances[wrongKey]) {
                wrong1Text = ckeditorInstances[wrongKey].getData();
            } else {
                wrong1Text = document.querySelector(`#editor-wrong1-${index}`)?.value || '';
            }
            
            const wrong1Image = document.querySelector(`#wrong1-image-input-${index}`)?.files[0];
            const hasWrong1ExistingImage = document.querySelector(`input[name="questions[${index}][wrong1_existing_image]"]`)?.value;
            
            if (!wrong1Text.trim() && !wrong1Image && !hasWrong1ExistingImage) {
                alert(`La pregunta ${index + 1} debe tener al menos una respuesta incorrecta (la primera es obligatoria).`);
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
        } else {
            updateAllMathPreviews();
        }
    });
});

// Limpiar editores antes de cerrar
window.addEventListener('beforeunload', function() {
    Object.keys(ckeditorInstances).forEach(key => {
        if (ckeditorInstances[key]) {
            try {
                ckeditorInstances[key].destroy();
            } catch(e) {
                console.warn(`Error limpiando ${key}:`, e);
            }
        }
    });
});

// ... (EL CÓDIGO ANTERIOR SE MANTIENE IGUAL HASTA ESTA PARTE)

// FUNCIONES DEL CREATE.BLADE.PHP QUE FALTAN
function removeQuestion(button) {
    const questionCard = button.closest('.question-card');
    const index = questionCard.dataset.index;
    
    // Destruir instancias de CKEditor 5
    destroyCKEditorInstances(index);
    
    if (document.querySelectorAll('.question-card').length > 1) {
        questionCard.remove();
        updateQuestionNumbers();
    } else {
        alert('Debe haber al menos una pregunta en el examen.');
    }
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-card');
    questions.forEach((card, index) => {
        card.querySelector('.question-number-display').textContent = index + 1;
    });
}

function previewQuestionImage(input, index) {
    const previewContainer = document.getElementById(`question-image-preview-${index}`);
    previewContainer.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview';
            previewContainer.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function previewAnswerImage(input, index, answerType) {
    const previewContainer = document.getElementById(`${answerType}-image-preview-${index}`);
    previewContainer.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview';
            previewContainer.appendChild(img);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// FUNCIÓN CKEDITOR 5: Configuración y Inicialización
function initializeCKEditor(index, type = null) {
    if (typeof ClassicEditor === 'undefined') {
        console.error('CKEditor 5 (ClassicEditor) no está cargado.');
        return;
    }
    
    const elementsToInit = [];
    
    if (type === 'question' || type === null) {
        elementsToInit.push({
            id: `editor-question-${index}`,
            key: `question-${index}`,
            heightClass: 'ck-editor__editable_inline'
        });
    }

    const answerTypes = (type && type !== 'question') ? [type] : ['correct', 'wrong1', 'wrong2', 'wrong3'];
    
    answerTypes.forEach(answerType => {
        elementsToInit.push({
            id: `editor-${answerType}-${index}`,
            key: `${answerType}-${index}`,
            heightClass: 'ck-editor__editable_inline answer-editor'
        });
    });

    // Configuración Base de CKEditor 5
    const editorConfig = {
        toolbar: {
            items: [
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'undo', 'redo'
            ]
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        }
    };
    
    elementsToInit.forEach(el => {
        const element = document.getElementById(el.id);
        const existingInstance = ckeditorInstances[el.key];

        // VERIFICACIÓN MEJORADA: No inicializar si ya existe
        if (!element) {
            console.log(`Elemento ${el.id} no encontrado`);
            return;
        }

        if (existingInstance) {
            console.log(`⚠️ Editor ${el.key} ya existe, saltando inicialización`);
            return;
        }

        // Verificar que el contenedor padre esté visible
        const parent = element.closest('.text-input');
        if (!parent || !parent.classList.contains('active')) {
            console.log(`Saltando ${el.key} - contenedor no activo`);
            return;
        }

        // Verificar que no haya un editor CKEditor ya renderizado
        if (element.nextElementSibling && element.nextElementSibling.classList.contains('ck-editor')) {
            console.log(`⚠️ Ya existe un editor renderizado para ${el.key}`);
            return;
        }
        
        ClassicEditor
            .create(element, editorConfig)
            .then(editor => {
                // Agrega clases separadas para evitar InvalidCharacterError
                (el.heightClass || '').trim().split(/\s+/).filter(Boolean)
                    .forEach(cls => editor.ui.view.editable.element.classList.add(cls));
                ckeditorInstances[el.key] = editor;
                console.log(`✅ CKEditor 5 inicializado: ${el.key}`);
                
                // Event listener para actualizar previsualización MathJax
                editor.model.document.on('change:data', () => {
                    updateMathPreview(el.key);
                });
            })
            .catch(error => {
                console.error(`❌ Error al inicializar CKEditor 5 para ${el.key}`, error);
            });
    });
}

// FUNCIÓN CKEDITOR 5: Destrucción MEJORADA
function destroyCKEditorInstances(index, type = null) {
    const keysToDestroy = [];
    
    if (type === 'question' || type === null) {
        keysToDestroy.push(`question-${index}`);
    }

    const answerTypes = (type && type !== 'question') ? [type] : ['correct', 'wrong1', 'wrong2', 'wrong3'];
    answerTypes.forEach(answerType => {
        keysToDestroy.push(`${answerType}-${index}`);
    });
    
    keysToDestroy.forEach(key => {
        if (ckeditorInstances[key]) {
            try { 
                ckeditorInstances[key].destroy();
                delete ckeditorInstances[key];
                console.log(`CKEditor 5 destruido: ${key}`);
            } catch(e) {
                console.warn(`No se pudo destruir CKEditor 5 para ${key}:`, e);
                // Forzar eliminación del registro incluso si falla la destrucción
                delete ckeditorInstances[key];
            }
        }
    });
}

// FUNCIONES MATHJAX
function createMathPreviews() {
    document.querySelectorAll('.question-card').forEach(card => {
        const index = card.dataset.index;
        
        // Para pregunta
        createMathPreviewElement(`question-${index}`);
        
        // Para respuestas
        ['correct', 'wrong1', 'wrong2', 'wrong3'].forEach(answerType => {
            createMathPreviewElement(`${answerType}-${index}`);
        });
    });
}

function createMathPreviewElement(elementKey) {
    const editorContainer = document.getElementById(`editor-${elementKey}`)?.parentNode;
    if (editorContainer && !document.getElementById(`math-preview-${elementKey}`)) {
        const previewDiv = document.createElement('div');
        previewDiv.id = `math-preview-${elementKey}`;
        previewDiv.className = 'math-preview-container';
        previewDiv.innerHTML = `
            <div class="math-preview-header">
                <small class="text-muted">Vista previa:</small>
                <button type="button" class="btn-toggle-preview" onclick="togglePreview('${elementKey}')">
                    <i class="bi bi-eye"></i> Ocultar vista previa
                </button>
            </div>
            <div class="math-preview-content" id="math-content-${elementKey}"></div>
        `;
        editorContainer.appendChild(previewDiv);
    }
}

function updateMathPreview(elementKey) {
    const editor = ckeditorInstances[elementKey];
    const previewContent = document.getElementById(`math-content-${elementKey}`);
    
    if (editor && previewContent) {
        const content = editor.getData();
        previewContent.innerHTML = content;
        
        // Reprocesar MathJax si está disponible
        if (window.MathJax && MathJax.typesetPromise) {
            MathJax.typesetPromise([previewContent]).catch(error => {
                console.warn('Error procesando MathJax:', error);
            });
        }
    }
}

function togglePreview(elementKey) {
    const editorElement = document.getElementById(`editor-${elementKey}`);
    const previewElement = document.getElementById(`math-preview-${elementKey}`);
    const toggleButton = previewElement?.querySelector('.btn-toggle-preview');
    
    if (editorElement && previewElement && toggleButton) {
        const isPreviewVisible = previewElement.style.display !== 'none';
        
        if (isPreviewVisible) {
            // Ocultar previsualización, mostrar editor
            previewElement.style.display = 'none';
            editorElement.style.display = 'block';
            toggleButton.innerHTML = '<i class="bi bi-eye"></i> Mostrar vista previa';
        } else {
            // Mostrar previsualización, ocultar editor
            editorElement.style.display = 'none';
            previewElement.style.display = 'block';
            toggleButton.innerHTML = '<i class="bi bi-eye-slash"></i> Ocultar vista previa';
            updateMathPreview(elementKey);
        }
    }
}

function updateAllMathPreviews() {
    Object.keys(ckeditorInstances).forEach(key => {
        updateMathPreview(key);
    });
}

function setupVisibilityObserver() {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const target = mutation.target;
                if (target.classList.contains('active') && target.classList.contains('text-input')) {
                    const textarea = target.querySelector('textarea[id^="editor-"]');
                    if (textarea) {
                        const id = textarea.id;
                        const match = id.match(/editor-(question|correct|wrong[123])-(\d+)/);
                        if (match) {
                            const type = match[1];
                            const index = match[2];
                            
                            setTimeout(() => {
                                initializeCKEditor(parseInt(index), type === 'question' ? 'question' : type);
                                createMathPreviews();
                            }, 200);
                        }
                    }
                }
            }
        });
    });

    document.querySelectorAll('.text-input').forEach(el => {
        observer.observe(el, { attributes: true });
    });
}

</script>
@endsection