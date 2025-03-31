<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <link rel="stylesheet" href="assets/css/registro_personal.css">
    <div class="pagetitle">
        <h1>Registro de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Gestion de Personal</li>

                <li class="breadcrumb-item active">Registro de Personal</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">
        <section class="section register py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <?php if (isset($_SESSION['mensaje'])): ?>
                                <script>
                                    Swal.fire({
                                        title: '<?= $_SESSION['tipo_mensaje'] === 'success' ? 'Éxito' : 'Error' ?>',
                                        text: "<?= addslashes($_SESSION['mensaje']) ?>",
                                        icon: '<?= $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'error' ?>',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#007832',
                                        background: '#ffffff',
                                        allowOutsideClick: false,
                                        customClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        }
                                    });
                                </script>
                                <?php
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                            <?php endif; ?>

                            <form class="row g-3 needs-validation" action="registrar_personal" method="POST" novalidate>
                                <!-- Documentación -->
                                <div class="col-md-6">
                                    <label for="tipo_documento" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-list"></i> Tipo de Documento
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-card-heading text-success"></i>
                                        </span>
                                        <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                            <option value="" selected disabled>Seleccione su documento...</option>
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PASAPORTE">Pasaporte</option>
                                            <option value="NIT">NIT</option>
                                            <option value="OTRO">Otro documento</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione su tipo de documento.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-text"></i> Número de Documento
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-card-text text-success"></i>
                                        </span>
                                        <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Ej: 1001234567" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su número de documento.</div>
                                </div>

                                <!-- Información Básica -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Nombres
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-circle text-success"></i>
                                        </span>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: María José" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Apellidos
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-vcard text-success"></i>
                                        </span>
                                        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ej: González Pérez" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>

                                <!-- Contacto -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-telephone"></i> Teléfono
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-telephone-outbound text-success"></i>
                                        </span>
                                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ej: 3001234567" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>

                                <!-- Información Laboral -->
                                <div class="col-md-6">
                                    <label for="rol" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-briefcase"></i> Rol
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-gear text-success"></i>
                                        </span>
                                        <select name="rol" id="rol" class="form-select" onchange="mostrarCamposAdicionales()" required>
                                            <option value="" selected disabled>Seleccione su rol...</option>
                                            <option value="Funcionario">Funcionario</option>
                                            <option value="Instructor">Instructor</option>
                                            <option value="Directivo">Directivo</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione un rol.</div>
                                </div>

                                <!-- Contenedor para Cargo y Tipo de Contrato -->
                                <div id="camposComunes" class="d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="cargo" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-person-badge"></i> Cargo
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-person-video3 text-success"></i>
                                                </span>
                                                <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Ej: Asistente administrativo" required>
                                            </div>
                                            <div class="invalid-feedback">Por favor, ingrese el cargo.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tipo_contrato" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-file-earmark-text"></i> Tipo de Contrato
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-file-earmark-medical text-success"></i>
                                                </span>
                                                <select name="tipo_contrato" id="tipo_contrato" class="form-select" required>
                                                    <option value="" selected disabled>Seleccione tipo de contrato...</option>
                                                    <option value="Planta">Planta</option>
                                                    <option value="Contratista">Contratista</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">Por favor, seleccione el tipo de contrato.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Computador -->
                                <div class="col-md-12">
                                    <label for="tiene_computador" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-laptop"></i> ¿Tiene computador?
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-pc-display text-success"></i>
                                        </span>
                                        <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                                            <option value="" selected disabled>Seleccione una opción...</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                                </div>

                                <!-- Campos de computador -->
                                <div id="camposComputador" class="col-md-12 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="marca" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-laptop"></i> Marca del computador
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-tag text-success"></i>
                                                </span>
                                                <input type="text" name="marca" class="form-control" placeholder="Ej: HP, Lenovo, Dell">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="codigo" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-upc-scan"></i> Código del computador
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-upc text-success"></i>
                                                </span>
                                                <input type="text" name="codigo" class="form-control" placeholder="Ej: SN-123456789">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-mouse"></i> ¿Trae mouse?
                                            </label>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="mouse" id="mouse" value="Sí">
                                                <label class="form-check-label" for="mouse">Sí</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-keyboard"></i> ¿Trae teclado?
                                            </label>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="teclado" id="teclado" value="Sí">
                                                <label class="form-check-label" for="teclado">Sí</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="tipo_computador" value="Personal">
                                </div>

                                <!-- Botón de registro -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                        <i class="bi bi-check-circle me-2"></i> Registrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="assets/js/registro_personal.js"></script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>