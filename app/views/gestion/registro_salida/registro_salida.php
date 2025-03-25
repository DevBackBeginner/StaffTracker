<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>

<link href="assets/css/tablas.css" rel="stylesheet">

<div class="pagetitle">
    <h1>Registro de Salidas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Registro de Salidas</li>
        </ol>
    </nav>
</div>
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
<?php include_once 'modal_salida.php' ?>

<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/footer_main.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>

<script src="assets/vendor/echarts/echarts.min.js"></script>

<script src="assets/vendor/chart.js/chart.js"></script>

<script src="assets/vendor/quill/quill.js"></script>

<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

<script src="assets/vendor/tinymce/tinymce.min.js"></script>

<script src="assets/vendor/php-email-form/validate.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/script.js"></script>

<script src="assets/js/main_home.js"></script>

<script src="assets/js/footer.js"></script>
<!-- <script src="assets/js/registro_salida.js"></script>  -->

