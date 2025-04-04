<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
    <link href="assets/css/tablas.css" rel="stylesheet">

    <div class="pagetitle">
        <h1>Historial de Registros</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item"><a href="panel">Historial de Registro</a></li>
            </ol>
        </nav>
    </div>
    
    <style>
        /* Estilos para los inputs y selects al hacer clic (enfoque) */
        .form-control:focus,
        .form-select:focus {
            outline: none; /* Elimina el borde azul predeterminado */
            border: 2px solid #007832; /* Borde verde alrededor del input/select cuando se hace clic */
            box-shadow: none; /* Elimina cualquier sombra alrededor del input/select */
        }

        /* Estilos por defecto para los campos de input y select */
        .form-control,
        .form-select {
            border: 1px solid #ccc; /* Borde gris claro */
            border-radius: 4px; /* Bordes redondeados */
            padding: 10px; /* Relleno de los campos */
        }
    </style>

    <div class="container-fluid"> <!-- Cambiado a container-fluid para ocupar el 100% del ancho -->
        <section class="section register py-4">
            <div class="row">
                <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                    <!-- Captura de mensajes generales -->
                    <?php if (!empty($_SESSION['mensaje'])): ?>
                        <div class="alert <?= $_SESSION['tipo_mensaje'] === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['mensaje']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        unset($_SESSION['mensaje']);
                        unset($_SESSION['tipo_mensaje']);
                        ?>
                    <?php endif; ?>
                    <!-- Filtro de Búsqueda -->
                    <div class="card shadow-sm mb-2">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros de Búsqueda</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Campo: Documento -->
                                <div class="col-md-6">
                                    <label for="documentoInput" class="form-label fw-bold text-success">Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text  text-black"><i class="bi bi-credit-card"></i></span>
                                        <input type="text" 
                                            class="form-control" 
                                            id="documentoInput" 
                                            placeholder="Ej: 12345678"
                                            aria-label="Documento">
                                    </div>
                                </div>

                                <!-- Campo: Nombre -->
                                <div class="col-md-6">
                                    <label for="nombreInput" class="form-label fw-bold text-success">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text  text-black"><i class="bi bi-person"></i></span>
                                        <input type="text" 
                                            class="form-control" 
                                            id="nombreInput" 
                                            placeholder="Ej: Ana Pérez"
                                            aria-label="Nombre">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="d-flex align-items-stretch">
        <?php
        // Incluir la tabla de usuarios
        require_once __DIR__ . "/tabla_historial.php";
        ?>
    </div>
    <script src="assets/js/historial_registros.js"></script>
<?php
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
