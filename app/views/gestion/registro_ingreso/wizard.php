<!-- Modal para preguntar si tiene computador -->
<div class="modal fade" id="modalTieneComputador" tabindex="-1" aria-labelledby="modalTieneComputadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTieneComputadorLabel">Registro de Asistencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                <div class="d-grid">
                    <button type="button" class="btn btn-success" id="btnConfirmarPC">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>