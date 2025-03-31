<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link rel="stylesheet" href="assest/css/registro_visitante.css">
    <div class="pagetitle">
        <h1>Formulario de Registro Visitantes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Control de Visitantes</li>
                <li class="breadcrumb-item"><a href="panel">Registro Visitantes</a></li>
            </ol>
        </nav>
    </div>
    <div class="container-fluid">
        <section class="section register py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <?php if (isset($_SESSION['mensaje'])): ?>
                                <div class="alert <?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'alert-success' : 'alert-danger'; ?> text-center">
                                    <?php echo $_SESSION['mensaje']; ?>
                                </div>
                                <?php
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                            <?php endif; ?>

                            <form action="registrar_visitante" method="POST" class="row g-3 needs-validation" onsubmit="return validarFormulario()" novalidate>
                                <!-- Primera fila: Tipo y número de documento -->
                                <div class="col-md-6">
                                    <label for="tipo_documento" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-list"></i> Tipo de Documento
                                    </label>
                                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PASAPORTE">Pasaporte</option>
                                        <option value="NIT">NIT</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione su tipo de documento.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-text"></i> Número de Documento
                                    </label>
                                    <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de documento" required>
                                    <div class="invalid-feedback">Por favor, ingrese su número de documento.</div>
                                </div>

                                <!-- Segunda fila: Nombre, Apellido -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Nombres
                                    </label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Apellidos
                                    </label>
                                    <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>

                                <!-- Tercera fila: Teléfono, Asunto -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-telephone"></i> Teléfono
                                    </label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="asunto" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-chat-dots"></i> Motivo de visita
                                    </label>
                                    <input type="text" name="asunto" id="asunto" class="form-control" placeholder="Motivo de visita" required>
                                    <div class="invalid-feedback">Por favor, ingrese el asunto.</div>
                                </div>

                                <!-- Cuarta fila: ¿Tiene computador? -->
                                <div class="col-md-12">
                                    <label for="tiene_computador" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-laptop"></i> ¿Tiene computador?
                                    </label>
                                    <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                                </div>

                                <!-- Campos adicionales para computador (se muestran solo si tiene computador) -->
                                <div id="camposComputador" class="campos-adicionales mb-3 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="marca" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-laptop"></i> Marca del computador
                                            </label>
                                            <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="codigo" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-upc-scan"></i> Código del computador
                                            </label>
                                            <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label" style="color: #007832;">
                                                <i class="bi bi-mouse"></i> ¿Trae mouse?
                                            </label>
                                            <div class="form-check">
                                                <input type="checkbox" name="mouse" id="mouse" class="form-check-input" value="Sí">
                                                <label for="mouse" class="form-check-label">Sí</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" style="color: #007832;">
                                                <i class="bi bi-keyboard"></i> ¿Trae teclado?
                                            </label>
                                            <div class="form-check">
                                                <input type="checkbox" name="teclado" id="teclado" class="form-check-input" value="Sí">
                                                <label for="teclado" class="form-check-label">Sí</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="tipo_computador" value="Personal">
                                </div>

                                <!-- Botón de registro -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                        <i class="bi bi-check-circle me-2"></i> Registrar Visitante
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
    
<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>