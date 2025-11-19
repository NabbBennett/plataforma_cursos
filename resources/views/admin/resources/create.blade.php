@extends('layouts.admin')

@section('title', 'Subir recurso')

@section('content')
<div class="container-fluid px-4 mt-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold mb-2 text-primary-custom">
                <i class="fas fa-cloud-upload-alt me-2"></i>Subir Nuevo Recurso
            </h2>
            <p class="mb-0 text-secondary-custom">Agrega nuevos archivos PDF o imágenes al sistema</p>
        </div>
        <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-custom btn-lg shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Volver a la lista
        </a>
    </div>

    <!-- Card del formulario -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg card-custom">
                <div class="card-header py-3 border-bottom card-header-custom">
                    <h5 class="card-title mb-0 text-primary-custom">
                        <i class="fas fa-file-upload me-2"></i>Información del Recurso
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 mb-4">
                            <div class="d-flex">
                                <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">Errores encontrados:</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        
                        <!-- Campo Título -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold text-primary-custom">
                                Título del Recurso <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg input-custom @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Ingresa un título descriptivo para el recurso"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text text-secondary-custom">
                                Este título ayudará a identificar el recurso en el sistema.
                            </div>
                        </div>

                        <!-- Campo Archivo -->
                        <div class="mb-4">
                            <label for="file" class="form-label fw-semibold text-primary-custom">
                                Archivo <span class="text-danger">*</span>
                            </label>
                            <input type="file" 
                                   class="form-control form-control-lg input-custom @error('file') is-invalid @enderror" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   required>
                            @error('file')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text text-secondary-custom">
                                Formatos permitidos: PDF, JPG, JPEG, PNG. Tamaño máximo: 10MB.
                            </div>
                        </div>

                        <!-- Información de validación -->
                        <div class="alert alert-info-custom border-0 mb-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2 text-primary-custom">Requisitos del archivo</h6>
                                    <ul class="mb-0 ps-3 text-secondary-custom">
                                        <li>Formatos aceptados: PDF, JPG, JPEG, PNG</li>
                                        <li>Tamaño máximo: 10 Megabytes</li>
                                        <li>El archivo debe estar libre de virus y contenido malicioso</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex gap-3 justify-content-end pt-3">
                            <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-custom btn-lg">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary-custom btn-lg shadow-sm" id="submitBtn">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Subir Recurso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variables y utilidades */
.text-primary-custom { color: var(--text-primary) !important; }
.text-secondary-custom { color: var(--text-secondary) !important; }

.card-custom { 
    background-color: var(--card-bg); 
    border-radius: 15px;
}

.card-header-custom { 
    background-color: var(--card-bg) !important; 
    border-color: var(--border-color) !important; 
}

/* Inputs personalizados */
.input-custom {
    background-color: var(--bg-primary) !important;
    border: 1px solid var(--border-color) !important;
    color: var(--text-primary) !important;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.input-custom:focus {
    box-shadow: 0 0 0 0.2rem rgba(var(--btn-primary-bg), 0.25);
    border-color: var(--btn-primary-bg) !important;
}

.input-custom::placeholder {
    color: var(--text-secondary) !important;
}

/* Botón principal */
.btn-primary-custom {
    background-color: var(--btn-primary-bg) !important;
    color: var(--btn-primary-text) !important;
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
}

/* Botón outline */
.btn-outline-custom {
    background-color: transparent !important;
    border: 1px solid var(--btn-outline-border) !important;
    color: var(--btn-outline-text) !important;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-outline-custom:hover {
    background-color: var(--btn-outline-hover-bg) !important;
    color: var(--btn-outline-hover-text) !important;
    transform: translateY(-2px);
}

/* Alertas personalizadas */
.alert-info-custom {
    background-color: rgba(13, 110, 253, 0.1) !important;
    border: 1px solid rgba(13, 110, 253, 0.2) !important;
    color: var(--text-primary) !important;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
    border: 1px solid rgba(220, 53, 69, 0.2) !important;
    color: var(--text-primary) !important;
}

.alert-danger .alert-heading {
    color: #dc3545 !important;
}

/* Invalid feedback */
.invalid-feedback {
    display: block;
    color: #dc3545 !important;
}

/* Form labels */
.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 1rem !important;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Mostrar loading en el botón
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Subiendo...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection