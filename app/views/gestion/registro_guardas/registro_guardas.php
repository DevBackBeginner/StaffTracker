<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/header_main.php' ; 
?>

<main id="main" class="main">
    <div class="container">
        <section class="section register min-vh-70 d-flex flex-column align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="" class="me-2" style="height: 40px;">
                                <span class="d-none d-lg-block fs-4 fw-bold">ControlAssistance</span>
                            </a>
                        </div><!-- End Logo -->
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body p-4">
                                <div class="pb-3 text-center">
                                    <h5 class="card-title pb-0 fs-4 fw-bold">Registro de Guardas</h5>
                                    <p class="text-muted small">Ingresa tus datos personales para crear tu cuenta</p>
                                </div>
                                <!-- Captura de mensajes generales -->
                                <?php if (!empty($_SESSION['mensaje'])): ?>
                                    <div class="alert <?= $_SESSION['tipo_mensaje'] === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
                                        <?= htmlspecialchars($_SESSION['mensaje']) ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php
                                    // Limpiar el mensaje después de mostrarlo
                                    unset($_SESSION['mensaje']);
                                    unset($_SESSION['tipo_mensaje']);
                                    ?>
                                <?php endif; ?>

                                <form class="row g-3 needs-validation" action="registro_guarda" method="POST" enctype="multipart/form-data" novalidate>
                                    <!-- Primera fila: Nombre y Apellidos -->
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                                        </div>
                                        <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellido" class="form-label fw-bold">Apellidos</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" name="apellido" class="form-control" id="apellido" required>
                                        </div>
                                        <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                    </div>

                                    <!-- Segunda fila: Número de Identidad y Teléfono -->
                                    <div class="col-md-6">
                                        <label for="numero_identidad" class="form-label fw-bold">Número de Identidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                            <input type="text" name="numero_identidad" class="form-control" id="numero_identidad" required
                                                   pattern="\d{10}" title="El número de identidad debe tener exactamente 10 dígitos.">
                                        </div>
                                        <div class="invalid-feedback">El número de identidad debe tener exactamente 10 dígitos.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="telefono" class="form-control" id="telefono" required
                                                   pattern="3[0-9]{9}" title="El teléfono debe tener 10 dígitos y comenzar con 3.">
                                        </div>
                                        <div class="invalid-feedback">El teléfono debe tener 10 dígitos y comenzar con 3.</div>
                                    </div>

                                    <!-- Tercera fila: Correo Electrónico y Turno -->
                                    <div class="col-md-6">
                                        <label for="correo" class="form-label fw-bold">Correo Electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="correo" class="form-control" id="correo" required>
                                        </div>
                                        <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="turno" class="form-label fw-bold">Turno</label>
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

                                    <!-- Cuarta fila: Contraseña y Confirmar Contraseña -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-bold">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon1')">
                                                <i id="togglePasswordIcon1" class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Por favor, ingrese una contraseña.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="confirm_password" class="form-label fw-bold">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', 'togglePasswordIcon2')">
                                                <i id="togglePasswordIcon2" class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Por favor, confirme su contraseña.</div>
                                    </div>

                                    <!-- Quinta fila: Foto de Perfil (sola) -->
                                    <div class="col-12">
                                        <label for="foto_perfil" class="form-label fw-bold">Foto de Perfil</label>
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
            </div>
        </section>
    </div>
</main><!-- End #main -->

<script src="assets/js/registro_guardas.js"></script>

<?php 
    // Incluimos el pie de pagina (footer) que contiene la estructura HTML final, footer, js, etc.
    include_once  __DIR__ . '/../dashboard/layouts/footer_main.php' ; 
?>
