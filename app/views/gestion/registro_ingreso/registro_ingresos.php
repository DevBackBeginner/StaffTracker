<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';
    ?>
    <!-- Enlace al archivo CSS específico para el panel -->
    <link rel="stylesheet" href="assets/css/registro_ingreso.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
    <?php
    // Inicializar las variables con valores por defecto
    $tipo = $_SESSION['mensaje']['tipo'] ?? 'info'; // Valor por defecto: 'info'
    $texto = $_SESSION['mensaje']['texto'] ?? '';  // Valor por defecto: cadena vacía
    $alertClass = 'info'; // Clase de alerta por defecto

    // Asignar la clase de alerta según el tipo de mensaje
    switch ($tipo) {
        case 'danger':
            $alertClass = 'danger';
            break;
        case 'warning':
            $alertClass = 'warning';
            break;
        case 'salida':
            $alertClass = 'success';
            break;
        case 'entrada':
            $alertClass = 'success';
            break;
        default:
            $alertClass = 'info';
            break;
    }
    ?>
        <div class="pagetitle">
            <h1>Registro Ingresos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                    <li class="breadcrumb-item active">Registrar Ingresos</li>
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
                        <form id="form-escaneo" method="POST">
                            <div class="mt-2">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" id="codigo" name="codigo" placeholder="Escanea el código aquí" class="form-control" autofocus>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-escaneo" method="POST">
                        <div class="mt-2">
                            <label for="codigo" class="form-label" style="color: #00304D;">Código</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Escanea el código aquí" class="form-control" style="color: #00304D;" autofocus>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <?php include_once 'wizard.php' ?>
    </main>
    <script src="assets/js/registro_ingreso.js"></script>

<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
