<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>

<div class="pagetitle">
    <h1>Formulario de Registro Guardas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item"><a href="panel">Registro Guardas</a></li>
        </ol>
    </nav>
</div>

<style>
    .input-group input:focus {
        outline: none; /* Elimina el borde azul predeterminado */
        border: 2px solid #007832; /* Borde verde alrededor del input cuando se hace clic */
        box-shadow: none; /* Elimina cualquier sombra alrededor del input */
    }


</style>
<div class="input-group">
    
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

                        <form class="row g-3 needs-validation" action="registro_guarda" method="POST" novalidate>
                            <!-- Primera fila: Nombre, Apellidos -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombres</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label fw-bold" style="color: #007832;">Apellidos</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="apellido" class="form-control" id="apellido" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                            </div>

                            <!-- Segunda fila: Número de Identidad, Teléfono -->
                            <div class="col-md-6">
                                <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">Numero de Identificación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="numero_identidad" class="form-control" id="numero_identidad" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese su número de identificación.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label fw-bold" style="color: #007832;">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="telefono" class="form-control" id="telefono" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                            </div>

                            <!-- Tercera fila: Correo Electrónico -->
                            <div class="col-md-12">
                                <label for="correo" class="form-label fw-bold" style="color: #007832;">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="correo" class="form-control" id="correo" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                            </div>

                            <!-- Botón de registro -->
                            <div class="col-12 mt-4">
                                <button class="btn btn-success w-100 py-2 fw-bold" type="submit" style="background-color: #007832; border-color: #007832;">
                                    <i class="bi bi-check-circle me-2"></i>Registrarse
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="assets/js/registro_guardas.js"></script>

<?php
    // Incluimos el footer que contiene la estructura HTML final
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>

