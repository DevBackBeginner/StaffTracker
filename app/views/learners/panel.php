<?php 
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../../views/layouts/header.php'; 
?>

<!-- Enlace al archivo CSS específico para el panel -->
<link rel="stylesheet" href="/ControlAssistance/public/assets/css/panel.css">

<!-- Contenedor principal con un margen inferior y fondo claro, y un padding superior para separar del header -->
<div class="container-fluid mb-4 bg-light" style="padding-top: 160px;">
    <!-- Fila para distribuir dos tarjetas en columnas -->
    <div class="row">
        <!-- Card: Registrar Asistencia -->
        <div class="col-md-6 d-flex align-items-stretch">
            <!-- Tarjeta con sombra, bordes redondeados y ancho personalizado -->
            <div class="card mb-4 shadow-sm rounded-lg" style="border: 1px solid #005f2f; width: 90%; margin: 0 auto;">
                <!-- Encabezado de la tarjeta con fondo y texto personalizado -->
                <div class="card-header text-white" style="background-color: #005f2f;">
                    <h2 class="h5 mb-0" style="color: white;">Registrar Asistencia</h2>
                </div>
                <!-- Cuerpo de la tarjeta con fondo claro -->
                <div class="card-body" style="background-color: #f5f5f5;">
                    <!-- Formulario de escaneo para registrar asistencia -->
                    <form id="form-escaneo" action="registrar_asistencia" method="post">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <!-- Campo de texto para ingresar o escanear el código -->
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
        <!-- Card: Buscar Ficha -->
        <div class="col-md-6 d-flex align-items-stretch">
            <!-- Tarjeta con sombra, bordes redondeados y ancho personalizado -->
            <div class="card mb-4 shadow-sm rounded-lg" style="border: 1px solid #005f2f; width: 90%; margin: 0 auto;">
                <!-- Encabezado de la tarjeta con fondo y texto personalizado -->
                <div class="card-header text-white" style="background-color: #005f2f;">
                    <h2 class="h5 mb-0" style="color: white;">Buscar Ficha</h2>
                </div>
                <!-- Cuerpo de la tarjeta con fondo claro -->
                <div class="card-body" style="background-color: #f5f5f5;">
                    <!-- Formulario para filtrar la búsqueda por Ficha y Documento -->
                    <form id="filterForm" class="row g-3">
                        <!-- Campo para buscar por ficha -->
                        <div class="col-md-6">
                            <label for="fichaInput" class="form-label">Ficha</label>
                            <input 
                                type="text" 
                                name="ficha" 
                                placeholder="Buscar por ficha" 
                                class="form-control" 
                                id="fichaInput">
                        </div>
                        <!-- Campo para buscar por documento -->
                        <div class="col-md-6">
                            <label for="documentoInput" class="form-label">Documento</label>
                            <input 
                                type="text" 
                                name="documento" 
                                placeholder="Buscar por documento" 
                                class="form-control" 
                                id="documentoInput">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de resultados que se actualiza vía AJAX -->
    <div id="tabla-resultados" class="card shadow-sm rounded-lg" style="border: 1px solid #005f2f; max-width: 95%; margin: 0 auto;">
        <!-- Encabezado fijo de la tarjeta de resultados -->
        <div class="card-header text-white" style="background-color: #005f2f;">
            <h2 class="h5 mb-0">Lista de Fichas</h2>
        </div>

        <!-- Cuerpo de la tarjeta que se recargará con el contenido de la tabla de aprendices -->
        <div id="tabla-body" class="card-body" style="background-color: #ffffff;">
            <!-- Se incluye el contenido inicial de la tabla de aprendices -->
            <?php include "tabla_aprendices.php"; ?>
        </div>
    </div>

</div>

<!-- Enlace al archivo JavaScript que maneja la lógica del panel (AJAX, eventos, etc.) -->
<script src="/ControlAssistance/public/assets/js/panel.js"></script>

<?php 
    // Incluimos el pie de página (footer) para cerrar la estructura HTML
    include_once __DIR__ . '/../../views/layouts/footer.php'; 
?>
