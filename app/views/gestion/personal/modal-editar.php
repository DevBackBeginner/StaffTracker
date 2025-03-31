<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-center w-100" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="EditarPersonal" method="POST">
                    <input type="hidden" name="id" id="editarId">
                    
                    <div class="row g-3">
                        <!-- Campos básicos -->
                        <div class="col-md-6">
                            <label for="editarNombre" class="form-label"><i class="bi bi-person"></i> Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidos" class="form-label"><i class="bi bi-person-bounding-box"></i> Apellidos</label>
                            <input type="text" class="form-control" id="editarApellidos" name="apellidos" required>
                        </div>

                        <!-- Tipo de Documento -->
                        <div class="col-md-6">
                            <label for="editarTipoDocumento" class="form-label"><i class="bi bi-card-list"></i> Tipo de Documento</label>
                            <select class="form-select" id="editarTipoDocumento" name="tipo_documento" required>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="PASAPORTE">Pasaporte</option>
                                <option value="NIT">NIT</option>
                                <option value="OTRO">Otro documento</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarDocumento" class="form-label"><i class="bi bi-card-id-card"></i> Número de Documento</label>
                            <input type="text" class="form-control" id="editarDocumento" name="numero_documento" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarTelefono" class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                            <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                        </div>
                        
                        <!-- Rol -->
                        <div class="col-md-6">
                            <label for="editarRol" class="form-label"><i class="bi bi-person-fill-lock"></i> Rol</label>
                            <select class="form-select" id="editarRol" name="rol" required>
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                            </select>
                        </div>
                        
                        <!-- Información laboral -->
                        <div class="col-md-6">
                            <label for="editarCargo" class="form-label"><i class="bi bi-briefcase"></i> Cargo</label>
                            <input type="text" class="form-control" id="editarCargo" name="cargo">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarTipoContrato" class="form-label"><i class="bi bi-file-earmark-text"></i> Tipo de Contrato</label>
                            <select class="form-select" id="editarTipoContrato" name="tipo_contrato">
                                <option value="">-- Seleccione --</option>
                                <option value="Planta">Planta</option>
                                <option value="Contratista">Contratista</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>