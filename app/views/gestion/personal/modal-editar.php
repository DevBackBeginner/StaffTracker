<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" method="POST" action="">
                    <input type="hidden" name="id" id="editarUsuarioId">
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
                            <label for="editarDocumento" class="form-label">Documento</label>
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

<!-- Script para manejar el modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('editarRol');
    const camposRol = document.querySelectorAll('.camposRol');

    // Función para mostrar los campos según el rol seleccionado
    function mostrarCamposPorRol() {
        camposRol.forEach(campo => campo.style.display = 'none'); // Oculta todos los campos
        const rolSeleccionado = rolSelect.value;
        document.getElementById(`campos${rolSeleccionado}`).style.display = 'block'; // Muestra los campos del rol seleccionado
    }

    // Evento para cambiar los campos cuando se selecciona un rol
    rolSelect.addEventListener('change', mostrarCamposPorRol);

    // Llenar el modal con los datos del usuario seleccionado
    const editarUsuarioModal = document.getElementById('editarUsuarioModal');
    editarUsuarioModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const row = button.closest('tr'); // Fila del usuario

        // Obtener datos de la fila
        const nombre = row.querySelector('td:nth-child(1)').innerText;
        const apellidos = row.querySelector('td:nth-child(2)').innerText;
        const documento = row.querySelector('td:nth-child(3)').innerText;
        const rol = row.querySelector('td:nth-child(4)').innerText;
        const telefono = row.querySelector('td:nth-child(5)').innerText;
        const informacionAdicional = row.querySelector('td:nth-child(6)').innerHTML; // Usamos innerHTML para capturar <br>

        // Llenar el modal con los datos comunes
        document.getElementById('editarNombre').value = nombre;
        document.getElementById('editarApellidos').value = apellidos;
        document.getElementById('editarDocumento').value = documento;
        document.getElementById('editarRol').value = rol;
        document.getElementById('editarTelefono').value = telefono;

        // Llenar los labels y inputs según el rol
        switch (rol) {
            case 'Instructor':
                const [curso, ubicacion] = informacionAdicional.split('<br>');
                document.getElementById('labelCurso').innerText = curso.replace('Curso: ', '').trim();
                document.getElementById('labelUbicacion').innerText = ubicacion.replace('Ubicación: ', '').trim();
                document.getElementById('editarCurso').value = curso.replace('Curso: ', '').trim();
                document.getElementById('editarUbicacion').value = ubicacion.replace('Ubicación: ', '').trim();
                break;
            case 'Funcionario':
                const [area, puesto] = informacionAdicional.split('<br>');
                document.getElementById('labelArea').innerText = area.replace('Área: ', '').trim();
                document.getElementById('labelPuesto').innerText = puesto.replace('Puesto: ', '').trim();
                document.getElementById('editarArea').value = area.replace('Área: ', '').trim();
                document.getElementById('editarPuesto').value = puesto.replace('Puesto: ', '').trim();
                break;
            case 'Directivo':
                const [cargo, departamento] = informacionAdicional.split('<br>');
                document.getElementById('labelCargo').innerText = cargo.replace('Cargo: ', '').trim();
                document.getElementById('labelDepartamento').innerText = departamento.replace('Departamento: ', '').trim();
                document.getElementById('editarCargo').value = cargo.replace('Cargo: ', '').trim();
                document.getElementById('editarDepartamento').value = departamento.replace('Departamento: ', '').trim();
                break;
            case 'Apoyo':
                const areaTrabajo = informacionAdicional.replace('Área de Trabajo: ', '').trim();
                document.getElementById('labelAreaTrabajo').innerText = areaTrabajo;
                document.getElementById('editarAreaTrabajo').value = areaTrabajo;
                break;
            case 'Visitante':
                const asunto = informacionAdicional.replace('Asunto: ', '').trim();
                document.getElementById('labelAsunto').innerText = asunto;
                document.getElementById('editarAsunto').value = asunto;
                break;
        }

        // Mostrar campos específicos del rol
        mostrarCamposPorRol();
    });
});
</script>