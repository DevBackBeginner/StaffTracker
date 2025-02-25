<div id="modal-<?= $aprendizId ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header" style="background: linear-gradient(90deg, <?= empty($aprendiz['hora_entrada']) ? '#28a745' : '#007bff' ?>, <?= empty($aprendiz['hora_entrada']) ? '#218838' : '#0056b3' ?>);">
                <h5 class="modal-title">
                    <?= empty($aprendiz['hora_entrada']) ? 'Registro de Entrada' : 'Registro de Salida' ?>
                </h5>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro de entrada -->
                <?php if (empty($aprendiz['hora_entrada'])): ?>
                    <!-- Fase 1: Registro de Entrada -->
                    <div id="fase-1-<?= $aprendizId ?>">
                        <form id="asistencia-form-<?= $aprendizId ?>" method="POST" onsubmit="return registrar_EntradaAjax('<?= $aprendizId ?>')">
                            <input type="hidden" name="tipo" value="entrada">
                            <input type="hidden" name="aprendiz_id" value="<?= htmlspecialchars($aprendiz['id']) ?>">                         

                            <!-- Selección de carnet o huella -->
                            <div class="form-group mb-3">
                                <label>Seleccione una opción:</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="mostrarCarnet('<?= $aprendizId ?>')">Carnet</button>
                                    <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarHuella('<?= $aprendizId ?>')">Huella</button>
                                </div>
                            </div>

                            <!-- Área para mostrar el escaneo en tiempo real -->
                            <div id="escaneo-<?= $aprendizId ?>" class="mb-3" style="display: none;">
                                <label>Escaneo en tiempo real:</label>
                                <div id="escaneo-contenido-<?= $aprendizId ?>"></div>
                            </div>

                            <!-- Botón para registrar entrada -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-lg fw-bold w-100">Registrar Entrada</button>
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100" onclick="closeActiveModal()">Cerrar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Fase 2: Pregunta sobre el Computador -->
                    <div id="fase-2-<?= $aprendizId ?>" style="display: none;">
                        <h6>¿Tienes un computador?</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary w-100" onclick="mostrarFase3('<?= $aprendizId ?>', true)">Sí</button>
                            <button type="button" class="btn btn-secondary w-100" onclick="closeActiveModal()">No</button>
                        </div>
                    </div>

                    <!-- Fase 3: Registro del Computador -->
                    <div id="fase-3-<?= $aprendizId ?>" style="display: none;">
                        <?php if (empty($computadores)): ?>
                            <form id="form-computador-<?= $aprendizId ?>" method="POST" action="registrar_computador">
                                <input type="hidden" name="aprendiz_id" value="<?= $aprendizId ?>">
                                
                                <div class="form-group mb-3">
                                    <label for="marca-<?= $aprendizId ?>">Marca del Computador</label>
                                    <input type="text" class="form-control" id="marca-<?= $aprendizId ?>" name="marca" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="codigo-<?= $aprendizId ?>">Código del Computador</label>
                                    <input type="text" class="form-control" id="codigo-<?= $aprendizId ?>" name="codigo" required>
                                </div>
                            
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success btn-lg fw-bold w-100">Registrar Computador</button>
                                    <button type="button" class="btn btn-outline-secondary btn-lg w-100" onclick="closeActiveModal()">Cerrar</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- Listado de computadores registrados -->
                            <div class="form-group mb-3">
                                <label>Seleccione un computador:</label>
                                <select class="form-control" name="computador_id">
                                    <?php foreach ($computadores as $computador): ?>
                                        <option value="<?= htmlspecialchars($computador['id']) ?>">
                                            <?= htmlspecialchars($computador['marca']) ?> - <?= htmlspecialchars($computador['codigo']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <!-- Formulario de registro de salida (similar al de entrada) -->
                    <form id="asistencia-salida-form-<?= $aprendizId ?>" method="POST" onsubmit="return registrar_SalidaAjax('<?= $aprendizId ?>')">
                        <input type="hidden" name="tipo" value="salida">
                        <input type="hidden" name="aprendiz_id" value="<?= htmlspecialchars($aprendiz['id']) ?>">

                        <!-- Selección de carnet o huella -->
                        <div class="form-group mb-3">
                            <label>Seleccione una opción:</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="mostrarCarnet('<?= $aprendizId ?>')">Carnet</button>
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="mostrarHuella('<?= $aprendizId ?>')">Huella</button>
                            </div>
                        </div>

                        <!-- Área para mostrar el escaneo en tiempo real -->
                        <div id="escaneo-<?= $aprendizId ?>" class="mb-3" style="display: none;">
                            <label>Escaneo en tiempo real:</label>
                            <div id="escaneo-contenido-<?= $aprendizId ?>"></div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold w-100">Registrar Salida</button>
                            <button type="button" class="btn btn-outline-secondary btn-lg w-100" onclick="closeActiveModal()">Cerrar</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
