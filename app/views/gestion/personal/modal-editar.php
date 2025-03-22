<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="EditarUsuarios" method="POST">
                    <!-- Campo oculto para el ID del usuario -->
                    <input type="hidden" name="id" id="editarId">
                    <div class="row g-3">
                        <!-- Campos comunes -->
                        <div class="col-md-6">
                            <label for="editarNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="editarApellidos" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarDocumento" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="editarDocumento" name="documento" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                        </div>
                        <div class="col-md-12">
                            <label for="editarRol" class="form-label">Rol</label>
                            <select class="form-select" id="editarRol" name="rol" required>
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Visitante">Visitante</option>
                            </select>
                        </div>

                        <!-- Campos específicos por rol -->
                        <div id="camposInstructor" class="camposRol" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editarCurso" class="form-label">Curso: <span id="labelCurso"></span></label>
                                    <input type="text" class="form-control" id="editarCurso" name="curso">
                                </div>
                                <div class="col-md-6">
                                    <label for="editarUbicacion" class="form-label">Ubicación: <span id="labelUbicacion"></span></label>
                                    <input type="text" class="form-control" id="editarUbicacion" name="ubicacion">
                                </div>
                            </div>
                        </div>
                        <div id="camposFuncionario" class="camposRol" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editarArea" class="form-label">Área: <span id="labelArea"></span></label>
                                    <input type="text" class="form-control" id="editarArea" name="area">
                                </div>
                                <div class="col-md-6">
                                    <label for="editarPuesto" class="form-label">Puesto: <span id="labelPuesto"></span></label>
                                    <input type="text" class="form-control" id="editarPuesto" name="puesto">
                                </div>
                            </div>
                        </div>
                        <div id="camposDirectivo" class="camposRol" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editarCargo" class="form-label">Cargo: <span id="labelCargo"></span></label>
                                    <input type="text" class="form-control" id="editarCargo" name="cargo">
                                </div>
                                <div class="col-md-6">
                                    <label for="editarDepartamento" class="form-label">Departamento: <span id="labelDepartamento"></span></label>
                                    <input type="text" class="form-control" id="editarDepartamento" name="departamento">
                                </div>
                            </div>
                        </div>
                        <div id="camposApoyo" class="camposRol" style="display: none;">
                            <div class="col-md-12">
                                <label for="editarAreaTrabajo" class="form-label">Área de Trabajo: <span id="labelAreaTrabajo"></span></label>
                                <input type="text" class="form-control" id="editarAreaTrabajo" name="area_trabajo">
                            </div>
                        </div>
                        <div id="camposVisitante" class="camposRol" style="display: none;">
                            <div class="col-md-12">
                                <label for="editarAsunto" class="form-label">Asunto: <span id="labelAsunto"></span></label>
                                <input type="text" class="form-control" id="editarAsunto" name="asunto">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

