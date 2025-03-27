<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link rel="stylesheet" href="assest/css/registro_visitante.css">
    <div class="pagetitle">
        <h1>Formulario de Registro Visitantes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item"><a href="panel">Registro Visitantes</a></li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid"> <!-- Cambiado a container-fluid para ocupar el 100% del ancho -->
        <section class="section register py-4">
            <div class="row">
                <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <!-- Mostrar mensajes de éxito o error -->
                            <?php if (isset($_SESSION['mensaje'])): ?>
                                <div class="alert <?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'alert-success' : 'alert-danger'; ?> text-center">
                                    <?php echo $_SESSION['mensaje']; ?>
                                </div>
                                <?php
                                // Limpiar el mensaje después de mostrarlo
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                            <?php endif; ?>

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

    
                            <form action="registrar_visitante" method="POST" class="row g-3 needs-validation" onsubmit="return validarFormulario()" novalidate>
                                <!-- Primera fila: Nombre, Apellido -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombres</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">Apellidos</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>

                                <!-- Segunda fila: Teléfono, Número de Identidad -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">Número de Identificación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su número de Identificación.</div>
                                </div>

                                <!-- Tercera fila: Asunto, ¿Tiene computador? -->
                                <div class="col-md-6">
                                    <label for="asunto" class="form-label fw-bold" style="color: #007832;">Asunto</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                                        <input type="text" name="asunto" id="asunto" class="form-control" placeholder="Asunto" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese el asunto.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="tiene_computador" class="form-label fw-bold" style="color: #007832;">¿Tiene computador?</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                        <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                                </div>

                                <!-- Campos adicionales para computador (se muestran solo si tiene computador) -->
                                <div id="camposComputador" class="campos-adicionales mb-3 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="marca" class="form-label fw-bold" style="color: #007832;">Marca del computador</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                                <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="codigo" class="form-label fw-bold" style="color: #007832;">Código del computador</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                                <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" style="color: #007832;">¿Trae mouse?</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-mouse"></i></span>
                                                <div class="form-check ms-2 d-flex align-items-center">
                                                    <input type="checkbox" name="mouse" id="mouse" class="form-check-input" value="Sí">
                                                    <label for="mouse" class="form-check-label ms-2">Sí</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" style="color: #007832;">¿Trae teclado?</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-keyboard"></i></span>
                                                <div class="form-check ms-2 d-flex align-items-center ">
                                                    <input type="checkbox" name="teclado" id="teclado" class="form-check-input" value="Sí">
                                                    <label for="teclado" class="form-check-label ms-2 ">Sí</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                        
                                        <div class="col-md-6">
                                            <input type="hidden" name="tipo_computador" value="Personal"> <!-- Tipo fijo como "Sena" -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón de registro -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                        <i class="bi bi-check-circle me-2"></i>Registrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="assets/js/registro_visitantes.js"></script>
    
<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>
