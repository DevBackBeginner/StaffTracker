<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/header_main.php' ; 
?>

    <!-- Enlace al archivo CSS específico para el panel -->
    <link rel="stylesheet" href="assets/css/panel_asistencia.css">

    <!-- Contenedor principal -->
    <div class="container-fluid mb-4 bg-light" >
        <div class="row justify-content-center" style="padding-top: 100px; padding-left: 250px">
            <!-- Card: Registrar Asistencia -->
            <div class="col-lg-10 col-md-10">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Registrar Asistencia</h2>
                    </div>
                    <div class="card-body">
                        <form id="form-escaneo" action="registrar_asistencia" method="POST">
                            <div class="mt-2">
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
        <div class="row justify-content-center" style=" padding-left: 250px"> 
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Últimos Registros de Asistencia</h2>
                    </div>
                    <div class="card-body">
                        <?php include_once "tabla_ultimos_registros.php"; ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>

    <?php  include "alertas.php"?>

    <!-- Enlace al archivo JavaScript que maneja la actualización de la tabla en tiempo real -->

<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/footer_main.php' ; 
?>

    <script src="assets/js/registro_asistencia.js"></script>
