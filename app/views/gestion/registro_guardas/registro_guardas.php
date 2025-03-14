<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once __DIR__ . '/../dashboard/layouts/header_main.php'; 
?>
    <div class="pagetitle">
        <h1>Formulario de Registro Guardas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item"><a href="panel">Registro Guardas</a></li>
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

                            <form class="row g-3 needs-validation" action="registro_guarda" method="POST" enctype="multipart/form-data" novalidate>
                                <!-- Primera fila: Nombre, Apellidos -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" class="form-control" id="nombre" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">Apellidos</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="apellido" class="form-control" id="apellido" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>

                                <!-- Segunda fila: Número de Identidad, Teléfono -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">Número de Identidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="numero_identidad" class="form-control" id="numero_identidad" required
                                            pattern="\d{10}" title="El número de identidad debe tener exactamente 10 dígitos.">
                                    </div>
                                    <div class="invalid-feedback">El número de identidad debe tener exactamente 10 dígitos.</div>
                                </div>
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="telefono" class="form-control" id="telefono" required
                                            pattern="3[0-9]{9}" title="El teléfono debe tener 10 dígitos y comenzar con 3.">
                                    </div>
                                    <div class="invalid-feedback">El teléfono debe tener 10 dígitos y comenzar con 3.</div>
                                </div>

                                <!-- Tercera fila: Correo Electrónico, Turno -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="correo" class="form-label fw-bold" style="color: #007832;">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="correo" class="form-control" id="correo" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                </div>
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="turno" class="form-label fw-bold" style="color: #007832;">Turno</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                        <select name="turno" id="turno" class="form-control" required>
                                            <option value="" selected disabled>Selecciona un turno</option>
                                            <option value="Mañana">Mañana</option>
                                            <option value="Tarde">Tarde</option>
                                            <option value="Noche">Noche</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione un turno.</div>
                                </div>

                                <!-- Cuarta fila: Contraseña, Confirmar Contraseña -->
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="password" class="form-label fw-bold" style="color: #007832;">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon1')">
                                            <i id="togglePasswordIcon1" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese una contraseña.</div>
                                </div>
                                <div class="col-md-6"> <!-- Cambiado a col-md-6 -->
                                    <label for="confirm_password" class="form-label fw-bold" style="color: #007832;">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', 'togglePasswordIcon2')">
                                            <i id="togglePasswordIcon2" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Por favor, confirme su contraseña.</div>
                                </div>

                                <!-- Quinta fila: Foto de Perfil -->
                                <div class="col-12"> <!-- Ocupa el 100% del ancho -->
                                    <label for="foto_perfil" class="form-label fw-bold" style="color: #007832;">Foto de Perfil</label>
                                    <input type="file" name="foto_perfil" class="form-control" id="foto_perfil" accept="image/*">
                                    <div class="invalid-feedback">Por favor, suba una foto de perfil.</div>
                                </div>

                                <!-- Sexta fila: Términos y Condiciones -->
                                <div class="col-12 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                        <label class="form-check-label" for="acceptTerms">Estoy de acuerdo con los <a href="#" class="text-decoration-none">términos y condiciones</a></label>
                                        <div class="invalid-feedback">Debes aceptar los términos antes de enviar.</div>
                                    </div>
                                </div>

                                <!-- Botón de registro -->
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary w-100 py-2 fw-bold" type="submit">Registrarse</button>
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
    include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; 
?>