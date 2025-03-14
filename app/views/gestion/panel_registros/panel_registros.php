<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';

    ?>
    <!-- Enlace al archivo CSS específico para el panel -->
    <link rel="stylesheet" href="assets/css/panel.css">

        <div class="pagetitle">
            <h1>Panel de Registros</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                    <li class="breadcrumb-item"><a href="panel">Panel de Registro</a></li>
                </ol>
            </nav>
        </div>

        <!-- Card: Buscar Funcionario -->
        <div class="container-fluid">
            <div class="d-flex align-items-stretch">
                <div class="card shadow-sm rounded-lg w-100" style="border: 1px solid #005f2f;">
                <div class="card-header text-white" style="background-color: #005f2f;">
                    <h2 class="h5 mb-0" style="color: white;">Buscar Usuario</h2>
                </div>
                <div class="card-body">
                    <div class="row"> <!-- Fila para alinear los campos horizontalmente -->
                    <!-- Búsqueda por Documento -->
                    <div class="col-md-6">
                        <label for="documentoInput" class="form-label">Documento</label>
                        <input
                        type="text"
                        name="documento"
                        placeholder="Buscar por documento"
                        class="form-control"
                        id="documentoInput"
                        value="<?= htmlspecialchars($documento ?? '') ?>"
                        >
                    </div>

                    <!-- Búsqueda por Nombre -->
                    <div class="col-md-6">
                        <label for="nombreInput" class="form-label">Nombre</label>
                        <input
                        type="text"
                        name="nombre"
                        placeholder="Buscar por nombre"
                        class="form-control"
                        id="nombreInput"
                        value="<?= htmlspecialchars($nombre ?? '') ?>"
                        >
                    </div>
                    </div> <!-- Fin de la fila -->
                </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-stretch">
            <?php
            // Incluir la tabla de usuarios
            require_once __DIR__ . "/../partials/tabla_usuarios.php";
            ?>
        </div>
    <script src="assets/js/panel_registros.js"></script>
<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
