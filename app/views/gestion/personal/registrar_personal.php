<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
    <div class="pagetitle">
        <h1>Registro de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Registro de Personal</li>
            </ol>
        </nav>
<<<<<<< HEAD
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
=======
    </div><!-- End Page Title -->
    <form action="registrar_personal" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light" onsubmit="return validarFormulario()" novalidate>
        <!-- Campos comunes -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
        </div>
        <div class="mb-3">
            <label for="numero_identidad" class="form-label">Número de Identidad</label>
            <input type="text" name="numero_identidad" id="numero_identidad" class="form-control" placeholder="Número de Identidad" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required onchange="mostrarCamposAdicionales()">
                <option value="">Seleccione un rol</option>
                <option value="Funcionario">Funcionario</option>
                <option value="Instructor">Instructor</option>
                <option value="Directiva">Directiva</option>
                <option value="Apoyo">Apoyo</option>
            </select>
        </div>
>>>>>>> c184e3e91ff70a50bfbbf9d39aab8804851b13e2

                            <form class="row g-3 needs-validation" action="registrar_personal" method="POST" novalidate onsubmit="return validarFormulario()">
                                <!-- Campos comunes -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">Apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">Número de Identidad</label>
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
                                <div class="col-md-6">
                                    <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                    <select name="rol" id="rol" class="form-select" required onchange="mostrarCamposAdicionales()">
                                        <option value="">Seleccione un rol</option>
                                        <option value="Funcionario">Funcionario</option>
                                        <option value="Instructor">Instructor</option>
                                        <option value="Directiva">Directiva</option>
                                        <option value="Apoyo">Apoyo</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione un rol.</div>
                                </div>

                                <!-- Campos adicionales para cada rol -->
                                <div id="camposFuncionario" class="campos-adicionales col-md-12 d-none">
                                    <input type="text" name="area" class="form-control" placeholder="Área">
                                    <input type="text" name="puesto" class="form-control mt-2" placeholder="Puesto">
                                </div>
                                <div id="camposInstructor" class="campos-adicionales col-md-12 d-none">
                                    <input type="text" name="curso" class="form-control" placeholder="Curso">
                                    <input type="text" name="ubicacion" class="form-control mt-2" placeholder="Ubicación">
                                </div>
                                <div id="camposDirectiva" class="campos-adicionales col-md-12 d-none">
                                    <input type="text" name="cargo" class="form-control" placeholder="Cargo">
                                    <input type="text" name="departamento" class="form-control mt-2" placeholder="Departamento">
                                </div>
                                <div id="camposApoyo" class="campos-adicionales col-md-12 d-none">
                                    <input type="text" name="area_trabajo" class="form-control" placeholder="Área de Trabajo">
                                </div>

                                <!-- Preguntar si tiene computador -->
                                <div class="col-md-6">
                                    <label for="tiene_computador" class="form-label fw-bold" style="color: #007832;">¿Tiene computador?</label>
                                    <select name="tiene_computador" id="tiene_computador" class="form-select" onchange="mostrarCamposComputador()" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, seleccione una opción.</div>
                                </div>

                                <!-- Campos adicionales para computador (se muestran solo si tiene computador) -->
                                <div id="camposComputador" class="campos-adicionales col-md-12 d-none">
                                    <div class="mb-3">
                                        <label for="tipo_computador" class="form-label fw-bold" style="color: #007832;">Tipo de computador</label>
                                        <select name="tipo_computador" id="tipo_computador" class="form-select">
                                            <option value="">Seleccione un tipo</option>
                                            <option value="Sena">Sena</option>
                                            <option value="Personal">Personal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
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
<<<<<<< HEAD
        </section>
    </div>
=======

            <div class="mb-3">
                <label class="form-label">Marca del computador</label>
                <input type="text" name="marca" class="form-control" placeholder="Marca del computador">
            </div>

            <div class="mb-3">
                <label class="form-label">Codigo del computador</label>
                <input type="text" name="codigo" class="form-control" placeholder="Código del computador">
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">¿Trae mouse?</label>
                    <div class="form-check">
                        <input type="checkbox" name="mouse" id="mouse" class="form-check-input" value="Sí">
                        <label for="mouse" class="form-check-label">Sí</label>
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">¿Trae teclado?</label>
                    <div class="form-check">
                        <input type="checkbox" name="teclado" id="teclado" class="form-check-input" value="Sí">
                        <label for="teclado" class="form-check-label">Sí</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary" style="background-color: #007832; border-color: #007832;">Registrar</button>
        </div>
    </form>
    
>>>>>>> c184e3e91ff70a50bfbbf9d39aab8804851b13e2
    <script src="assets/js/registro_personal.js"></script>

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>