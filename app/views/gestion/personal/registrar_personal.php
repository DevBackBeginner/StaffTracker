<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <div class="pagetitle">
        <h1>Registro de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Registro de Personal</li>
            </ol>
        </nav>
    </div>
    
    <style>
    .form-control:focus,
    .form-select:focus {
        outline: none;
        border: 2px solid #007832;
        box-shadow: none;
    }
    .form-control,
    .form-select {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
    }
    </style>

    <div class="container-fluid">
        <section class="section register py-4">
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
                                    <select name="tipo_documento" id="tipo_documento" class="form-select" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PA">Pasaporte</option>
                                        <option value="NIT">NIT</option>
                                        <option value="OTRO">Otro documento</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione su tipo de documento.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_identidxad" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-text"></i> Número de Documento
                                    </label>
                                    <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de documento" required>
                                    <div class="invalid-feedback">Por favor, ingrese su número de documento.</div>
                                </div>
                                <!-- Información Básica -->
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

                                <!-- Contacto -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-telephone"></i> Teléfono
                                    </label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>

                                <!-- Información Laboral -->
                                <div class="col-md-6">
                                    <label for="rol" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-briefcase"></i> Rol
                                    </label>
                                    <select name="rol" id="rol" class="form-select" onchange="mostrarCamposAdicionales()" required>
                                        <option value="" selected disabled>Seleccione un rol</option>
                                        <option value="Funcionario">Funcionario</option>
                                        <option value="Instructor">Instructor</option>
                                        <option value="Directivo">Directivo</option>
                                        <option value="Apoyo">Apoyo</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione un rol.</div>
                                </div>
                                <!-- Contenedor para Cargo y Tipo de Contrato (inicialmente oculto) -->
                                <div id="camposComunes" class="d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="cargo" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-person-badge"></i> Cargo
                                            </label>
                                            <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo" required>
                                            <div class="invalid-feedback">Por favor, ingrese el cargo.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tipo_contrato" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-file-earmark-text"></i> Tipo de Contrato
                                            </label>
                                            <select name="tipo_contrato" id="tipo_contrato" class="form-select" required>
                                                <option value="" selected disabled>Seleccione...</option>
                                                <option value="Planta">Planta</option>
                                                <option value="Contratista">Contratista</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                            <div class="invalid-feedback">Por favor, seleccione el tipo de contrato.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Computador -->
                                <div class="col-md-12">
                                    <label for="tiene_computador" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-laptop"></i> ¿Tiene computador?
                                    </label>
                                    <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                                </div>

                                <!-- Campos de computador (ocultos inicialmente) -->
                                <div id="camposComputador" class="col-md-12 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="marca" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-laptop"></i> Marca del computador
                                            </label>
                                            <input type="text" name="marca" class="form-control" placeholder="Marca">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="codigo" class="form-label fw-bold" style="color: #007832;">
                                                <i class="bi bi-upc-scan"></i> Código del computador
                                            </label>
                                            <input type="text" name="codigo" class="form-control" placeholder="Código">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
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