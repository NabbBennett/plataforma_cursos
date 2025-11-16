@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="configuration-container">
    <a href="{{ route('student.profile') }}" class="back-to-profile" title="Volver al perfil"> Volver al perfil
        <i class="bi bi-arrow-left"></i>
    </a>

    <div class="configuration-header">
        <h1>Configuración</h1>
        <p>Gestiona tu perfil y preferencias</p>
    </div>

    <div class="configuration-content">
        <!-- Sección: Cambiar Banner -->
        <div class="config-section">
            <div class="section-header">
                <h2>Cambiar Banner</h2>
            </div>

            <div class="banner-change">
                <div class="banner-preview" id="bannerPreview" style="background-image: url('{{ $user->banner_url }}')">
                    <button class="edit-banner-btn" data-bs-toggle="modal" data-bs-target="#bannerModal">
                        <i class="bi bi-pencil"></i>
                        Cambiar Banner
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección: Cambiar icono o nombre -->
        <div class="config-section">
            <div class="section-header">
                <h2>Cambiar icono o nombre</h2>
            </div>

            <div class="change-identity-section">
                <div class="identity-box">
                    <div class="identity-avatar">
                        <img id="avatarPreview" src="{{ $user->avatar_url }}" alt="Avatar" class="avatar-image">
                        <button class="edit-avatar-btn" data-bs-toggle="modal" data-bs-target="#avatarModal" aria-label="Cambiar icono">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>

                    <div class="identity-info">
                        <h3 id="currentName">{{ $user->name }}</h3>
                        <div class="identity-actions">
                            <button class="btn btn-outline-primary btn-edit-name" data-bs-toggle="modal" data-bs-target="#nameModal" aria-label="Editar nombre">
                                <i class="bi bi-pencil-square"></i>
                                Editar Nombre
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Seguridad -->
        <div class="config-section">
            <div class="section-header">
                <h2>Cambiar Contraseña</h2>
            </div>
            
            <form id="passwordForm" class="password-form">
                @csrf
                <div class="form-group">
                    <label for="current_password">Contraseña actual:</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    <div class="error-message" id="current_passwordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="new_password">Nueva contraseña:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6">
                    <div class="password-requirements">
                        Mínimo 6 caracteres
                    </div>
                    <div class="error-message" id="new_passwordError"></div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirma contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <div class="error-message" id="confirm_passwordError"></div>
                </div>
                
                <button type="submit" class="btn-save" id="savePasswordBtn">
                    <i class="bi bi-check-lg"></i>
                    GUARDAR CONTRASEÑA
                </button>
            </form>
        </div>

        
    </div>
</div>

<!-- Modal para Cambiar Avatar -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Seleccionar Avatar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="avatars-grid">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="avatar-option {{ $user->avatar == $i ? 'selected' : '' }}" data-avatar="{{ $i }}">
                        <img src="{{ asset('images/avatars/avatar' . $i . '.jpg') }}" alt="Avatar {{ $i }}">
                    </div>
                    @endfor
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveAvatarBtn">Guardar Avatar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Banner -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerModalLabel">Seleccionar Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="banners-grid">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="banner-option {{ $user->banner == $i ? 'selected' : '' }}" data-banner="{{ $i }}">
                        <img src="{{ asset('images/banners/banner' . $i . '.jpg') }}" alt="Banner {{ $i }}">
                    </div>
                    @endfor
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveBannerBtn">Guardar Banner</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Nombre -->
<div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameModalLabel">Editar Nombre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new_name">Nuevo nombre:</label>
                    <input type="text" id="new_name" class="form-control" value="{{ $user->name }}" required>
                    <div class="error-message" id="nameError"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveNameBtn">Guardar Nombre</button>
            </div>
        </div>
    </div>
</div>

<style>
.configuration-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.configuration-header {
    text-align: center;
    margin-bottom: 3rem;
}

.configuration-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.configuration-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
}

.config-section {
    background-color: var(--bg-secondary);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.section-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 0.5rem;
}

/* Profile Preview */
.profile-preview {
    position: relative;
}

.banner-section {
    margin-bottom: 80px;
}

.banner-preview {
    height: 200px;
    border-radius: 12px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    border: 2px solid var(--border-color);
}

.edit-banner-btn {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.edit-banner-btn:hover {
    background-color: rgba(0, 0, 0, 0.9);
}

.avatar-section {
    display: flex;
    align-items: flex-end; /* avatar en la parte superior, el texto queda un poco más bajo */
    gap: 1.25rem;
    position: absolute;
    bottom: -60px;
    left: 2rem;
}

.avatar-preview {
    position: relative;
}

.avatar-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--bg-primary);
    background-color: var(--bg-primary);
}

.edit-avatar-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: 2px solid var(--bg-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.3s;
}

.edit-avatar-btn:hover {
    transform: scale(1.1);
}

.profile-info {
    
    display: flex;           /* nombre y botón en la misma línea */
    align-items: center;
    gap: .75rem;
    margin-top: 8px;         /* baja todo el bloque un poco */
}

.profile-info h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    padding-top: 6px;        /* empuja el texto hacia abajo respecto al avatar */
}

.btn-edit-name {
    margin: 0;
    padding: .45rem .9rem;
    white-space: nowrap;
}

/* Password Form */
.password-form {
    max-width: 500px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-primary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background-color: var(--bg-primary);
    color: var(--text-primary);
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: var(--btn-primary-bg);
}

.password-requirements {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

.error-message {
    color: #dc3545;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: none;
}

.btn-save {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-save:hover {
    background-color: var(--btn-outline-hover-bg);
    transform: translateY(-2px);
}

/* Modals */
.modal-content {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
}

.modal-footer {
    border-top: 1px solid var(--border-color);
}

/* Avatars Grid */
.avatars-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    padding: 1rem 0;
}

.avatar-option {
    cursor: pointer;
    border-radius: 8px;
    padding: 0.5rem;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.avatar-option:hover {
    background-color: var(--bg-secondary);
}

.avatar-option.selected {
    border-color: var(--btn-primary-bg);
    background-color: var(--bg-secondary);
}

.avatar-option img {
    width: 100%;
    border-radius: 50%;
    aspect-ratio: 1;
    object-fit: cover;
}

/* Banners Grid */
.banners-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1rem 0;
}

.banner-option {
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.banner-option:hover {
    transform: scale(1.05);
}

.banner-option.selected {
    border-color: var(--btn-primary-bg);
}

.banner-option img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

/* Estilos para "Cambiar icono o nombre" */
.change-identity-section {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 1.25rem;
    flex-wrap: wrap;
}

.identity-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    width: 100%;
}

.identity-avatar {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid var(--bg-primary);
    background: var(--bg-primary);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    flex: 0 0 auto;
}

.identity-avatar .avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 50%;
}

/* botón lápiz sobre el avatar (pequeño círculo) */
.edit-avatar-btn {
    position: absolute;
    right: 6px;
    bottom: 6px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(0,0,0,0.9);
    color: #fff;
    border: 2px solid #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* info y botón junto al avatar */
.identity-info {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex: 1 1 auto;
}

.identity-info h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.1;
}

/* acción (botón editar nombre) alineada a la derecha del nombre en desktop */
.identity-actions {
    display: flex;
    gap: .5rem;
    margin-top: 6px;
}

/* Reutiliza clase existente para consistencia */
.btn-edit-name {
    margin-left:20px;
    padding: .45rem .9rem;
    white-space: nowrap;
}

/* Responsive: en móvil apilar y centrar */
@media (max-width: 768px) {
    .change-identity-section {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .identity-box { 
        flex-direction: column;
        align-items: center; 
        gap: .75rem; 
    }

    .identity-info { 
        align-items: center; 
        padding-top: 6px; 
    }

    .identity-info h3 { 
        font-size: 1.25rem; 
        padding-top: 0; 
    }

    .edit-avatar-btn { 
        right: 8px; 
        bottom: 8px; 
        width: 36px; 
        height: 36px; 
    }
}

.configuration-content { 
    padding-bottom: 80px; 
} /* evita solapamientos finales */

/* Notifications */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    color: white;
    z-index: 9999;
    animation: slideIn 0.3s ease;
}

.notification.success {
    background-color: #28a745;
}

.notification.error {
    background-color: #dc3545;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.back-to-profile {
    left: 1rem;
    top: 1rem;
    z-index: 999;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: .5rem 1rem;
    gap: 1rem;
    border-radius: 8px;
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: transform .12s ease, background .12s ease;
}
.back-to-profile:hover { 
    transform: translateY(-2px); 
    background: var(--bg-secondary); 
}

/* Ajuste para pantallas pequeñas */
@media (max-width: 576px) {
    .back-to-profile { 
        padding: .4rem .8rem;
        gap: .5rem;
        margin-bottom: 1rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales para selecciones
    let selectedAvatar = null;
    let selectedBanner = null;
    
    // Modal de Avatar
    const avatarModal = document.getElementById('avatarModal');
    const avatarOptions = document.querySelectorAll('.avatar-option');
    
    avatarOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remover selección anterior
            avatarOptions.forEach(opt => opt.classList.remove('selected'));
            // Seleccionar nuevo avatar
            this.classList.add('selected');
            selectedAvatar = this.getAttribute('data-avatar');
        });
    });
    
    // Modal de Banner
    const bannerModal = document.getElementById('bannerModal');
    const bannerOptions = document.querySelectorAll('.banner-option');
    
    bannerOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remover selección anterior
            bannerOptions.forEach(opt => opt.classList.remove('selected'));
            // Seleccionar nuevo banner
            this.classList.add('selected');
            selectedBanner = this.getAttribute('data-banner');
        });
    });
    
    // Guardar Avatar
    document.getElementById('saveAvatarBtn').addEventListener('click', function() {
        if (selectedAvatar) {
            updateAvatar(selectedAvatar);
        } else {
            showNotification('Por favor selecciona un avatar', 'error');
        }
    });
    
    // Guardar Banner
    document.getElementById('saveBannerBtn').addEventListener('click', function() {
        if (selectedBanner) {
            updateBanner(selectedBanner);
        } else {
            showNotification('Por favor selecciona un banner', 'error');
        }
    });
    
    // Guardar Nombre
    document.getElementById('saveNameBtn').addEventListener('click', function() {
        const newName = document.getElementById('new_name').value.trim();
        const nameError = document.getElementById('nameError');
        
        if (!newName) {
            showError(nameError, 'El nombre no puede estar vacío');
            return;
        }
        
        if (newName.length < 2) {
            showError(nameError, 'El nombre debe tener al menos 2 caracteres');
            return;
        }
        
        updateName(newName);
    });
    
    // Validación de contraseña
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        const currentError = document.getElementById('current_passwordError');
        const newError = document.getElementById('new_passwordError');
        const confirmError = document.getElementById('confirm_passwordError');
        
        // Reset errors
        hideError(currentError);
        hideError(newError);
        hideError(confirmError);
        
        let isValid = true;
        
        if (!currentPassword) {
            showError(currentError, 'La contraseña actual es requerida');
            isValid = false;
        }
        
        if (newPassword.length < 6) {
            showError(newError, 'La contraseña debe tener al menos 6 caracteres');
            isValid = false;
        }
        
        if (newPassword !== confirmPassword) {
            showError(confirmError, 'Las contraseñas no coinciden');
            isValid = false;
        }
        
        if (isValid) {
            updatePassword(currentPassword, newPassword);
        }
    });
    
    // Funciones para enviar al servidor
    async function updateAvatar(avatarNumber) {
        try {
            const response = await fetch('{{ route("student.update.avatar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    avatar: avatarNumber
                })
            });

            const data = await response.json();

            if (data.success) {
                // Actualizar vista previa
                document.getElementById('avatarPreview').src = data.avatar_url;
                showNotification('Avatar actualizado correctamente', 'success');
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(avatarModal);
                modal.hide();
            } else {
                showNotification('Error al actualizar el avatar', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error al actualizar el avatar', 'error');
        }
    }

    async function updateBanner(bannerNumber) {
        try {
            const response = await fetch('{{ route("student.update.banner") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    banner: bannerNumber
                })
            });

            const data = await response.json();

            if (data.success) {
                // Actualizar vista previa
                document.getElementById('bannerPreview').style.backgroundImage = `url('${data.banner_url}')`;
                showNotification('Banner actualizado correctamente', 'success');
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(bannerModal);
                modal.hide();
            } else {
                showNotification('Error al actualizar el banner', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error al actualizar el banner', 'error');
        }
    }

    async function updateName(name) {
        try {
            const response = await fetch('{{ route("student.update.name") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name
                })
            });

            const data = await response.json();

            if (data.success) {
                // Actualizar vista
                document.getElementById('currentName').textContent = name;
                showNotification('Nombre actualizado correctamente', 'success');
                
                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('nameModal'));
                modal.hide();
            } else {
                showNotification('Error al actualizar el nombre', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error al actualizar el nombre', 'error');
        }
    }

    async function updatePassword(currentPassword, newPassword) {
        try {
            const response = await fetch('{{ route("student.update.password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    current_password: currentPassword,
                    new_password: newPassword,
                    new_password_confirmation: newPassword
                })
            });

            const data = await response.json();

            if (data.success) {
                showNotification('Contraseña actualizada correctamente', 'success');
                document.getElementById('passwordForm').reset();
            } else {
                // Mostrar errores de validación
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const errorElement = document.getElementById(field + 'Error');
                        if (errorElement) {
                            showError(errorElement, data.errors[field][0]);
                        }
                    });
                } else {
                    showNotification('Error al actualizar la contraseña', 'error');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error al actualizar la contraseña', 'error');
        }
    }
    
    // Funciones auxiliares
    function showError(element, message) {
        element.textContent = message;
        element.style.display = 'block';
    }
    
    function hideError(element) {
        element.style.display = 'none';
    }
    
    function showNotification(message, type) {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        // Agregar al documento
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endsection