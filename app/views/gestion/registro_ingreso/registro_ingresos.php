<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
<div class="pagetitle">
    <h1>Registro de Entradas y Salidas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
            <li class="breadcrumb-item active">Registro de Entradas y Salidas</li>
        </ol>
    </nav>
</div>
<div class="container-fluid"> <!-- Cambiado a container-fluid para ocupar el 100% del ancho -->
    <section class="section register py-4">
        <div class="row">
            <div class="col-12"> <!-- Ocupa el 100% del ancho -->
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

                        <form id="form-escaneo" method="POST" onsubmit="event.preventDefault();">
                            <div class="mt-2">
                                <label for="codigo" class="form-label fw-bold" style="color: #007832;">Código</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" id="codigo" name="codigo" placeholder="Escanea el código aquí" class="form-control" autofocus>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                <div class="card shadow-sm custom-card">
                    <div class="card-header bg-custom text-white">
                        <h2 class="h5 mb-0">Últimos Registros</h2>
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
<?php include_once 'wizard.php' ?>

<script src="assets/js/registro_ingreso.js"></script>
<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
