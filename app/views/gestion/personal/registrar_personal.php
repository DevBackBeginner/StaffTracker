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
    <div class="container-fluid">
        <section class="section register py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <!-- Mostrar mensajes de éxito o error -->
                            <?php if (isset($_SESSION['mensaje'])): ?>
                                <div class="alert <?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['mensaje']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                // Limpiar el mensaje después de mostrarlo
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                            ?>
                            <?php endif; ?>

                            <form class="row g-3 needs-validation" action="registrar_personal" method="POST" novalidate onsubmit="return validarFormulario()">
                                <!-- Campos comunes -->
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
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">Numero de Identificación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su número de identidad.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>
                                <div class="col-md-12">
                                    <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        <select name="rol" id="rol" class="form-select" required onchange="mostrarCamposAdicionales()">
                                            <option value="">Seleccione un rol</option>
                                            <option value="Funcionario">Funcionario</option>
                                            <option value="Instructor">Instructor</option>
                                            <option value="Directiva">Directiva</option>
                                            <option value="Apoyo">Apoyo</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione un rol.</div>
                                </div>

                                <!-- Campos adicionales para cada rol -->
                                <div id="camposFuncionario" class="campos-adicionales col-md-12 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="area" class="form-label fw-bold" style="color: #007832;">Área</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <input type="text" name="area" class="form-control" placeholder="Área">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="puesto" class="form-label fw-bold" style="color: #007832;">Puesto</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                                <input type="text" name="puesto" class="form-control" placeholder="Puesto">
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="camposInstructor" class="campos-adicionales col-md-12 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="curso" class="form-label fw-bold" style="color: #007832;">Curso</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-book"></i></span>
                                                <input type="text" name="curso" class="form-control" placeholder="Curso">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ubicacion" class="form-label fw-bold" style="color: #007832;">Ubicación</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                                <input type="text" name="ubicacion" class="form-control mt-2" placeholder="Ubicación">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="camposDirectiva" class="campos-adicionales col-md-12 d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="cargo" class="form-label fw-bold" style="color: #007832;">Cargo</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                <input type="text" name="cargo" class="form-control" placeholder="Cargo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="departamento" class="form-label fw-bold" style="color: #007832;">Departamento</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <input type="text" name="departamento" class="form-control" placeholder="Departamento">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="camposApoyo" class="campos-adicionales col-md-12 d-none">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tools"></i></span>
                                        <input type="text" name="area_trabajo" class="form-control" placeholder="Área de Trabajo">
                                    </div>
                                </div>

                                <!-- Preguntar si tiene computador -->
                                <div class="col-md-12">
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
                                <div id="camposComputador" class="campos-adicionales col-md-12 d-none">
                                    <div class="col-md-12 mb-3">
                                        <label for="tipo_computador" class="form-label fw-bold" style="color: #007832;">Tipo de computador</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                            <select name="tipo_computador" id="tipo_computador" class="form-select">
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Sena">Sena</option>
                                                <option value="Personal">Personal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="marca_computador" class="form-label fw-bold" style="color: #007832;">Marca del computador</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                                <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="codigo_computador" class="form-label fw-bold" style="color: #007832;">Código del computador</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-laptop"></i></span>
                                                <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
                                            </div>
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
                                                <div class="form-check ms-2 d-flex align-items-center">
                                                    <input type="checkbox" name="teclado" id="teclado" class="form-check-input" value="Sí">
                                                    <label for="teclado" class="form-check-label ms-2">Sí</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
    <script src="assets/js/registro_personal.js"></script>

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