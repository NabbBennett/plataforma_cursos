<!-- Modal Custom para imágenes -->
<div id="customImageModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-overlay" onclick="closeCustomModal()"></div>
    <div class="custom-modal-content">
        <button class="custom-modal-close" onclick="closeCustomModal()">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="custom-modal-header">
            <h5 id="customModalTitle">Evidencia</h5>
        </div>
        <div class="custom-modal-body">
            <img id="customModalImage" src="" alt="Evidencia">
        </div>
    </div>
</div>

<style>
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
}

.custom-modal-content {
    position: relative;
    width: 95%;
    max-width: 1200px;
    max-height: 95vh;
    background-color: var(--light-base);
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    animation: modalSlideIn 0.3s ease-out;
}

body.dark-mode .custom-modal-content {
    background-color: var(--dark-300);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.custom-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.custom-modal-close:hover {
    background-color: rgba(255, 0, 0, 0.8);
    transform: rotate(90deg);
}

.custom-modal-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background-color: var(--bg-secondary);
}

.custom-modal-header h5 {
    margin: 0;
    color: var(--text-primary);
    font-weight: 600;
}

.custom-modal-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #000;
    overflow: hidden;
    padding: 0;
}

.custom-modal-body img {
    width: 100%;
    height: 100%;
    max-height: 80vh;
    object-fit: contain;
    user-select: none;
}

/* Responsive */
@media (max-width: 768px) {
    .custom-modal-content {
        width: 100%;
        max-width: 100%;
        height: 100%;
        max-height: 100vh;
        border-radius: 0;
    }
    
    .custom-modal-body img {
        max-height: 90vh;
    }
    
    .custom-modal-close {
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
    }
}

/* Animación de cierre */
.custom-modal.closing {
    animation: modalFadeOut 0.3s ease-out;
}

@keyframes modalFadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

.custom-modal.closing .custom-modal-content {
    animation: modalSlideOut 0.3s ease-out;
}

@keyframes modalSlideOut {
    from {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
    to {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
    }
}
</style>

<script>
function openCustomModal(imageSrc, title) {
    const modal = document.getElementById('customImageModal');
    const modalImage = document.getElementById('customModalImage');
    const modalTitle = document.getElementById('customModalTitle');
    
    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    modal.style.display = 'flex';
    
    // Prevenir scroll del body
    document.body.style.overflow = 'hidden';
}

function closeCustomModal() {
    const modal = document.getElementById('customImageModal');
    
    // Agregar clase de animación de cierre
    modal.classList.add('closing');
    
    setTimeout(() => {
        modal.style.display = 'none';
        modal.classList.remove('closing');
        
        // Restaurar scroll del body
        document.body.style.overflow = '';
    }, 300);
}

// Cerrar con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('customImageModal');
        if (modal && modal.style.display === 'flex') {
            closeCustomModal();
        }
    }
});
</script>
