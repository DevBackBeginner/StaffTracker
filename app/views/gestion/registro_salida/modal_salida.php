<!-- En el <head> -->
<div class="modal fade" id="modalTieneComputador" tabindex="-1" aria-labelledby="modalTieneComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTieneComputadorLabel">Registro de Asistencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>            </div>
            <div class="modal-body">
                <p class="mb-3">¿Tienes computador?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" id="btnSiComputador">Sí</button>
                    <button type="button" class="btn btn-danger" id="btnNoComputador">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para preguntar si el computador es Personal o del Sena -->
<div class="modal fade" id="modalTipoComputador" tabindex="-1" aria-labelledby="modalTipoComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTipoComputadorLabel">Tipo de Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">¿El computador es Personal o del Sena?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="btnPersonal">Personal</button>
                    <button type="button" class="btn btn-info" id="btnSena">Sena</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar el computador -->
<div class="modal fade" id="modalSeleccionarComputador" tabindex="-1" aria-labelledby="modalSeleccionarComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSeleccionarComputadorLabel">Seleccionar Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Selecciona un computador:</p>
                <select id="selectComputadores" class="form-select mb-3"></select>
                
                <!-- Botón Confirmar -->
                <div class="d-grid mb-3">
                    <button type="button" class="btn btn-success" id="btnConfirmarPC">Confirmar</button>
                </div>
                
                <!-- Contenedor para botones inferiores -->
                <div class="d-flex gap-2">
                    <!-- Botón Volver -->
                    <button type="button" class="btn btn-secondary flex-grow-1" id="btnVolverTipoDesdeSeleccion">Volver atrás</button>
                    
                    <!-- Botón Registrar Nuevo (se agregará dinámicamente aquí) -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar un nuevo computador -->
<div class="modal fade" id="modalRegistrarComputador" tabindex="-1" aria-labelledby="modalRegistrarComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalRegistrarComputadorLabel">Registrar Nuevo Computador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarComputador">
                    <div class="mb-3">
                        <label for="marcaComputador" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marcaComputador" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigoComputador" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigoComputador" required>
                    </div>
                    <!-- Checkbox para "Tiene mouse" -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="tieneMouse">
                        <label class="form-check-label" for="tieneMouse">Tiene mouse</label>
                    </div>
                    <!-- Checkbox para "Tiene teclado" -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="tieneTeclado">
                        <label class="form-check-label" for="tieneTeclado">Tiene teclado</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>