<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
    <link href="assets/css/tablas.css" rel="stylesheet">

    <div class="pagetitle">
        <h1>Registro de Entradas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Registro de Entradas</li>
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

    <div class="container-fluid">
        <section class="section register py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <!-- Captura de mensajes generales -->
                            <?php if (!empty($_SESSION['mensaje'])): ?>
                                <div class="alert <?= $_SESSION['mensaje']['tipo'] === 'danger' ? 'alert-danger' : ($_SESSION['mensaje']['tipo'] === 'warning' ? 'alert-warning' : 'alert-success') ?> alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_SESSION['mensaje']['texto']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                unset($_SESSION['mensaje']);
                                ?>
                            <?php endif; ?>
                            <!-- Escaner de carnets y/o documento de identidad -->
                            <?php include_once __DIR__ . "/../partials/escaner_codigo.php"  ;?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                    <div class="card shadow-sm custom-card">
                        <div class="card-header bg-custom ">
                            <h2 class="h5 mb-0 "style="color: #007832;">Últimos Registros</h2>
                        </div>
                        <div class="card-body">
                            <?php include_once "tabla_ultimos_registros.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <?php include_once 'modal_entrada.php' ?>

    <script src="assets/js/registro_ingreso.js"></script> 
    
<?php
    // Incluimos el footer que contiene la estructura HTML final
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>


   