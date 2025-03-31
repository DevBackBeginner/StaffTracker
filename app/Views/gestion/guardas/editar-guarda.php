<!-- Modal Editar Guarda -->
<div class="modal fade" id="editarGuardaModal" tabindex="-1" aria-labelledby="editarGuardaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editarGuardaModalLabel">
                    <i class="bi bi-pencil-square"></i> Editar Guarda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="EditarGuarda">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_guarda_id">
                    
                    <div class="mb-3">
                        <label for="edit_guarda_nombre" class="form-label"><i class="bi bi-person"></i> Nombre</label>
                        <input type="text" class="form-control" id="edit_guarda_nombre" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_guarda_apellido" class="form-label"><i class="bi bi-person"></i> Apellido</label>
                        <input type="text" class="form-control" id="edit_guarda_apellido" name="apellido" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_guarda_tipo_doc" class="form-label"><i class="bi bi-card-list"></i> Tipo Documento</label>
                        <select class="form-select" id="edit_guarda_tipo_doc" name="tipo_documento" required>
                            <option value="CC">Cédula de Ciudadanía (CC)</option>
                            <option value="CE">Cédula de Extranjería (CE)</option>
                            <option value="TI">Tarjeta de Identidad (TI)</option>
                            <option value="PASAPORTE">Pasaporte</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_guarda_num_doc" class="form-label"><i class="bi bi-card-text"></i> Número Documento</label>
                        <input type="text" class="form-control" id="edit_guarda_num_doc" name="numero_documento" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_guarda_telefono" class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                        <input type="tel" class="form-control" id="edit_guarda_telefono" name="telefono">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_guarda_correo" class="form-label"><i class="bi bi-envelope"></i> Correo</label>
                        <input type="email" class="form-control" id="edit_guarda_correo" name="correo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>