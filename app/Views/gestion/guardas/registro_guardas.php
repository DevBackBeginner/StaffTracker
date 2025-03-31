<?php
// Incluimos el encabezado (header) que contiene la estructura HTML inicial, head, etc.
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>

    <div class="pagetitle">
        <h1>Formulario de Registro Guardas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Gestion de Personal</li>
                <li class="breadcrumb-item"><a href="panel">Registro Guardas</a></li>
            </ol>
        </nav>
    </div>

    <style>
        .input-group input:focus, .input-group select:focus {
            outline: none;
            border: 2px solid #007832;
            box-shadow: none;
        }
        .input-group-text {
            background-color: #f8f9fa;
            color: #007832;
        }
    </style>

    <div class="container-fluid">
        <section class="section register py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <?php if (!empty($_SESSION['mensaje'])): ?>
                                <script>
                                    Swal.fire({
                                        title: '<?= $_SESSION['tipo_mensaje'] === 'error' ? 'Error' : 'Éxito' ?>',
                                        text: "<?= addslashes($_SESSION['mensaje']) ?>",
                                        icon: '<?= $_SESSION['tipo_mensaje'] === 'error' ? 'error' : 'success' ?>',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#007832'
                                    });
                                </script>
                                <?php
                                unset($_SESSION['mensaje']);
                                unset($_SESSION['tipo_mensaje']);
                                ?>
                            <?php endif; ?>

                            <form class="row g-3 needs-validation" action="registro_guarda" method="POST" novalidate>
                                <!-- Documentación -->
                                <div class="col-md-6">
                                    <label for="tipo_documento" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-text"></i> Tipo de Documento
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                                        <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                            <option value="" selected disabled>Seleccione su documento...</option>
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PA">Pasaporte</option>
                                            <option value="NIT">NIT</option>
                                            <option value="OTRO">Otro documento</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">Por favor, seleccione su tipo de identificación.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="numero_identidad" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-card-text"></i> Número de Documento
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" name="numero_identidad" class="form-control" id="numero_identidad" 
                                            placeholder="Ej: 123456789" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su número de identificación.</div>
                                </div>

                                <!-- Información Personal -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Nombres
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                        <input type="text" name="nombre" class="form-control" id="nombre" 
                                            placeholder="Ej: Juan Carlos" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-person"></i> Apellidos
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input type="text" name="apellido" class="form-control" id="apellido" 
                                            placeholder="Ej: Pérez Gómez" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                                </div>

                                <!-- Contacto -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-telephone"></i> Teléfono
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone-outbound"></i></span>
                                        <input type="text" name="telefono" class="form-control" id="telefono" 
                                            placeholder="Ej: 3001234567" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="correo" class="form-label fw-bold" style="color: #007832;">
                                        <i class="bi bi-envelope"></i> Correo Electrónico
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                                        <input type="email" name="correo" class="form-control" id="correo" 
                                            placeholder="Ej: ejemplo@correo.com" required>
                                    </div>
                                    <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                                </div>

                                <!-- Botón de registro -->
                                <div class="col-12 mt-4">
                                    <button class="btn btn-success w-100 py-2 fw-bold" type="submit" style="background-color: #007832; border-color: #007832;">
                                        <i class="bi bi-check-circle me-2"></i> Registrar Guarda
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