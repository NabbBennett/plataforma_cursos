@extends('layouts.admin')

@section('title', 'Crear Curso')

@section('content')
<style>
    .create-course-container {
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

    .form-control::placeholder {
        color: var(--text-secondary);
        opacity: 0.7;
    }

    .btn-submit {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        background-color: var(--btn-outline-hover-bg);
        color: var(--btn-outline-hover-text);
        transform: translateY(-2px);
    }

    .alert-custom {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-primary);
        padding: 1rem 1.5rem;
    }

    .alert-success {
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
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

    .image-preview {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid var(--border-color);
        margin-top: 0.5rem;
        display: none;
    }

    .file-input-custom {
        position: relative;
    }

    .file-input-custom input[type="file"] {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        background-color: var(--bg-primary);
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-secondary);
    }

    .file-input-label:hover {
        border-color: var(--btn-primary-bg);
        background-color: var(--hover-bg);
    }

    .file-input-label i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .character-count {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-align: right;
        margin-top: 0.25rem;
    }

    .character-count.warning {
        color: #ffc107;
    }

    .character-count.danger {
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .create-course-container {
            padding: 1rem 0;
        }

        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
        }

        .image-preview {
            width: 150px;
            height: 112px;
        }

        .file-input-label {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }

        .form-container {
            padding: 1rem;
        }

        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="create-course-container">
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 d-inline"><i class="bi bi-plus-circle me-2"></i>Crear Nuevo Curso</h1>
                    <p class="text-secondary-custom mb-0">Complete la información del nuevo curso</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Volver a Cursos
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
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
            <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" id="courseForm">
                @csrf

                <!-- Información Básica -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Información Básica
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Título del Curso *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Ingrese el título del curso"
                                   required
                                   maxlength="255">
                            <div class="character-count" id="titleCount">0/255 caracteres</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_per_week" class="form-label">Precio por Semana *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price_per_week" name="price_per_week"
                                       step="0.01" min="0" 
                                       value="{{ old('price_per_week') }}" 
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
                                  maxlength="1000">{{ old('description') }}</textarea>
                        <div class="character-count" id="descriptionCount">0/1000 caracteres</div>
                    </div>
                </div>

                <!-- Fechas y Duración -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-calendar-event"></i>
                        Fechas y Duración
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ old('start_date') }}">
                            <small class="text-secondary-custom">Seleccione la fecha de inicio del curso</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="capacity" class="form-label">Cupos Disponibles</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" 
                                   min="1" max="1000" 
                                   value="{{ old('capacity') }}"
                                   placeholder="Ilimitado">
                            <small class="text-secondary-custom">Dejar vacío para cupos ilimitados</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="number_of_weeks" class="form-label">Duración en Semanas *</label>
                            <input type="number" class="form-control" id="number_of_weeks" name="number_of_weeks" 
                                   min="1" max="52" 
                                   value="{{ old('number_of_weeks', 4) }}"
                                   required>
                            <small class="text-secondary-custom">Número total de semanas del curso (1-52)</small>
                        </div>
                    </div>
                </div>

                <!-- Imagen del Curso -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-image"></i>
                        Imagen del Curso
                    </h3>
                    
                    <div class="mb-3">
                        <label class="form-label">Imagen de Portada (Opcional)</label>
                        
                        <div class="file-input-custom mb-3">
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" 
                                   onchange="previewImage(this)">
                            <label for="image" class="file-input-label">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <span>Haga clic para seleccionar una imagen</span>
                                <br>
                                <small class="text-secondary-custom">Formatos: JPG, PNG, GIF • Máx: 2MB</small>
                            </label>
                        </div>
                        
                        <img id="imagePreview" class="image-preview" alt="Vista previa de la imagen">
                        
                        <div class="mt-2">
                            <small class="text-secondary-custom">
                                <i class="bi bi-info-circle me-1"></i>
                                Recomendado: 800x600px, formato JPG o PNG, máximo 2MB
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn-submit w-100">
                            <i class="bi bi-check-circle me-2"></i>Crear Curso
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contador de caracteres para título
    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('titleCount');
    
    titleInput.addEventListener('input', function() {
        const length = this.value.length;
        titleCount.textContent = `${length}/255 caracteres`;
        updateCounterStyle(titleCount, length, 255);
    });
    
    // Inicializar contador de título
    titleCount.textContent = `${titleInput.value.length}/255 caracteres`;
    updateCounterStyle(titleCount, titleInput.value.length, 255);

    // Contador de caracteres para descripción
    const descriptionInput = document.getElementById('description');
    const descriptionCount = document.getElementById('descriptionCount');
    
    descriptionInput.addEventListener('input', function() {
        const length = this.value.length;
        descriptionCount.textContent = `${length}/1000 caracteres`;
        updateCounterStyle(descriptionCount, length, 1000);
    });
    
    // Inicializar contador de descripción
    descriptionCount.textContent = `${descriptionInput.value.length}/1000 caracteres`;
    updateCounterStyle(descriptionCount, descriptionInput.value.length, 1000);

    // Función para actualizar el estilo del contador
    function updateCounterStyle(counter, length, max) {
        counter.classList.remove('warning', 'danger');
        if (length > max * 0.9) {
            counter.classList.add('danger');
        } else if (length > max * 0.75) {
            counter.classList.add('warning');
        }
    }

    // Previsualización de imagen
    window.previewImage = function(input) {
        const preview = document.getElementById('imagePreview');
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Validación del formulario
    const form = document.getElementById('courseForm');
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        // Validar precio
        const price = document.getElementById('price_per_week').value;
        if (price <= 0) {
            alert('El precio por semana debe ser mayor a 0');
            valid = false;
        }
        
        // Validar semanas
        const weeks = document.getElementById('number_of_weeks').value;
        if (weeks < 1 || weeks > 52) {
            alert('El número de semanas debe estar entre 1 y 52');
            valid = false;
        }
        
        if (!valid) {
            e.preventDefault();
        }
    });

    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Eliminar restricción de fecha mínima (permitir fechas pasadas)
    const startDateInput = document.getElementById('start_date');
    if (startDateInput) {
        startDateInput.removeAttribute('min');
    }
});
</script>
@endsection