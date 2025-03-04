<?php 
    // Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
    include_once  __DIR__ . '/../dashboard/layouts/header_main.php' ; 
?>

<body>
    <main>
        <div class="container" > 
            <section class="section register min-vh-70 d-flex flex-column align-items-center justify-content-center py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">ControlAssistance</span>
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Registro de Guardas</h5>
                                        <p class="text-center small">Ingresa tus datos personales para crear tu cuenta</p>
                                    </div>
                                    <!-- Captura de mensajes -->
                                    <?php if (!empty($mensaje)): ?>
                                        <div class="alert <?= $tipo_mensaje === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
                                            <?= htmlspecialchars($mensaje) ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="row g-3 needs-validation" action="registro_guarda" method="POST" enctype="multipart/form-data">
                                        <div class="col-12">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                                            <div class="invalid-feedback">Por favor, ingresa tu nombre.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="numero_identidad" class="form-label">Número de Identidad</label>
                                            <input type="text" name="numero_identidad" class="form-control" id="numero_identidad" required>
                                            <div class="invalid-feedback">Por favor, ingresa tu número de identidad.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                            <input type="email" name="correo" class="form-control" id="correo" required>
                                            <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                            <input type="file" name="foto_perfil" class="form-control" id="foto_perfil" accept="image/*">
                                            <div class="invalid-feedback">Por favor, sube una foto de perfil.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control" id="password" required>
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon1')">
                                                    <i id="togglePasswordIcon1" class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">Por favor, ingresa tu contraseña.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', 'togglePasswordIcon2')">
                                                    <i id="togglePasswordIcon2" class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">Por favor, confirma tu contraseña.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="turno" class="form-label">Turno</label>
                                            <select name="turno" id="turno" class="form-control" required>
                                                <option value="" selected disabled>Selecciona un turno</option>
                                                <option value="Mañana">Mañana</option>
                                                <option value="Tarde">Tarde</option>
                                                <option value="Noche">Noche</option>
                                            </select>
                                            <div class="invalid-feedback">Por favor, selecciona un turno.</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                                <label class="form-check-label" for="acceptTerms">Estoy de acuerdo con los <a href="#">términos y condiciones</a></label>
                                                <div class="invalid-feedback">Debes aceptar los términos antes de enviar.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Registrarse</button>
                                        </div>
                                    </form>
                                </div><!-- End Card Body -->
                            </div><!-- End Card -->
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
