<?php 
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../../views/layouts/header.php'; 
?>

<!-- Enlace al archivo CSS específico para el panel -->
<link rel="stylesheet" href="/ControlAssistance/public/assets/css/panel.css">


<!-- Contenedor principal -->
<div class="container-fluid mb-4 bg-light" style="padding-top: 160px;">
    <div class="row">
        <!-- Card: Registrar Asistencia -->
        <div class="d-flex align-items-stretch">
            <div class="card mb-4 shadow-sm rounded-lg" style="border: 1px solid #005f2f; width: 95%; margin: 0 auto;">
                <div class="card-header text-white" style="background-color: #005f2f;">
                    <h2 class="h5 mb-0" style="color: white;">Registrar Asistencia</h2>
                </div>
                <div class="card-body" style="background-color: #f5f5f5;">
                    <form id="form-escaneo" action="registrar_asistencia" method="POST">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input 
                                type="text" 
                                id="codigo" 
                                name="codigo" 
                                placeholder="Escanea el código aquí" 
                                class="form-control" 
                                autofocus>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Nueva tabla: Últimos registros de asistencia -->
    <div id="tabla-ultimos-registros" class="card shadow-sm rounded-lg mt-4" style="border: 1px solid #005f2f; max-width: 95%; margin: 0 auto;">
        <div class="card-header text-white" style="background-color: #005f2f;">
            <h2 class="h5 mb-0">Últimos Registros de Asistencia</h2>
        </div>
        <div id="tabla-ultimos-body" class="card-body" style="background-color: #ffffff;">
            <?php include_once "tabla_ultimos_registros.php"; ?>
        </div>
    </div>
    <br>
</div>

<?php  include "alertas.php"?>

<!-- Enlace al archivo JavaScript que maneja la actualización de la tabla en tiempo real -->

<?php 
// Incluimos el pie de página (footer)
include_once __DIR__ . '/../../views/layouts/footer.php'; 
?>

<script src="/ControlAssistance/public/assets/js/registro_asistencia.js"></script>
