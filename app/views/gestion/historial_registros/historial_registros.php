<?php
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
    <div class="pagetitle">
        <h1>Historial de Registros</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item"><a href="panel">Historial de Registro</a></li>
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
                                <div class="alert <?= $_SESSION['tipo_mensaje'] === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_SESSION['mensaje']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                            <?php endif; ?>

                            <form class="row g-3 needs-validation" action="panel_registro" method="POST" novalidate>
                                <!-- Primera fila: Filtrar por Nombre -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="nombreInput" class="form-label fw-bold" style="color: #007832;">Nombres</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" class="form-control" id="nombreInput" placeholder="Filtrar por nombres" value="<?= htmlspecialchars($nombre ?? '') ?>">
                                    </div>
                                </div>
                                <!-- Segunda fila: Filtrar por Documento -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="documentoInput" class="form-label fw-bold" style="color: #007832;">Documentos</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="documento" class="form-control" id="documentoInput" placeholder="Filtrar por documentos" value="<?= htmlspecialchars($documento ?? '') ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="d-flex align-items-stretch">
        <?php
        // Incluir la tabla de usuarios
        require_once __DIR__ . "/../partials/tabla_usuarios.php";
        ?>
    </div>
    <script src="assets/js/panel_registros.js"></script>
<?php
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
