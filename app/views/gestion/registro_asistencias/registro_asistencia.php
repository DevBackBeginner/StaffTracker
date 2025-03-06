<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/header_main.php' ; 

?>

    <!-- Enlace al archivo CSS específico para el panel -->
    <link rel="stylesheet" href="assets/css/registro_asistencias.css">
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Registro Asistencia</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Registrar Asistencias</li>
            </ol>
            </nav>
        </div><!-- End Page Title -->
        <!-- Contenedor principal -->
        <div class="row">
            <!-- Fila para el formulario de registro -->
            <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                <div class="card mb-4 shadow-sm custom-card">
                    <div class="card-header bg-custom text-white">
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

            <!-- Fila para la tabla de últimos registros -->
            <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                <div class="card shadow-sm custom-card">
                    <div class="card-header bg-custom text-white">
                        <h2 class="h5 mb-0">Últimos Registros de Asistencia</h2>
                    </div>
                    <div class="card-body">
                        <?php include_once "tabla_ultimos_registros.php"; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php  include "alertas.php"?>

    </main>
<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/footer_main.php' ; 
?>

    <script src="assets/js/registro_asistencia.js"></script>
