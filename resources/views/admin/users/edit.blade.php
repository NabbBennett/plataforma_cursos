<!-- Modal para Editar Usuario -->
<div class="modal fade modal-custom" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editUserName" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editUserEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editUserPhone" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="editUserPhone" name="phone_mobile" placeholder="Ej: +52 123 456 7890">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editUserRole" class="form-label">Rol del usuario</label>
                            <select class="form-select" id="editUserRole" name="role" required>
                                <option value="admin">Administrador</option>
                                <option value="ayudante">Ayudante</option>
                                <option value="maestro">Maestro</option>
                                <option value="alumno">Alumno</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    <strong>Información sobre roles:</strong><br>
                                    • <strong>Administrador:</strong> Acceso completo al dashboard<br>
                                    • <strong>Ayudante:</strong> Solo módulo de Ventas y Usuarios<br>
                                    • <strong>Maestro:</strong> Solo Cursos, Exámenes y Materiales<br>
                                    • <strong>Alumno:</strong> Sin acceso al dashboard
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal de edición
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.getAttribute('data-user-email');
            const userPhone = button.getAttribute('data-user-phone');
            const userRole = button.getAttribute('data-user-role');

            // Actualizar el formulario
            const form = document.getElementById('editUserForm');
            form.action = `{{ url('admin/users') }}/${userId}`;
            
            document.getElementById('editUserName').value = userName;
            document.getElementById('editUserEmail').value = userEmail;
            document.getElementById('editUserPhone').value = userPhone || '';
            document.getElementById('editUserRole').value = userRole;

            // Actualizar título del modal
            document.getElementById('editUserModalLabel').innerHTML = 
                `<i class="bi bi-pencil-square me-2"></i>Editar Usuario: ${userName}`;
        });

        // Limpiar formulario cuando se cierra el modal
        editUserModal.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('editUserForm');
            form.reset();
        });
    }

    // Manejo de envío del formulario del modal
    const editForm = document.getElementById('editUserForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Guardando...';
            submitBtn.disabled = true;
            
            // El formulario se enviará normalmente
        });
    }
});
</script>