<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';
     // Obtener los últimos registros de acceso
    $ultimosRegistros = $this->registroModelo->obtenerUltimosRegistrosSalida();
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
                        <?php if (isset($_SESSION['mensaje'])): ?>
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                Swal.fire({
                                    title: '<?= $_SESSION['tipo_mensaje'] === 'success' ? 'Éxito' : 'Error' ?>',
                                    text: "<?= addslashes($_SESSION['mensaje']) ?>",
                                    icon: '<?= $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'error' ?>',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#007832',  // Verde corporativo
                                    background: '#ffffff',          // Fondo blanco
                                    allowOutsideClick: false,       // Obligar a hacer clic en el botón
                                    customClass: {
                                        popup: 'animate__animated animate__fadeInDown' // Animación
                                    }
                                });
                            </script>
                            <?php
                            unset($_SESSION['mensaje']);
                            unset($_SESSION['tipo_mensaje']);
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
                    <div class="card-header bg-custom bg-success text-white text-center ">
                        <h2 class="h5 mb-0 ">Últimos Registros</h2>
                    </div>
                    <div class="card-body">
                        <?php include_once "tabla_registros_salida.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<?php include_once 'modal_salida.php' ?>

<!-- <script src="assets/js/registro_salida.js"></script> -->

<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
