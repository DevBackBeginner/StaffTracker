<?php include_once __DIR__ . '/../../views/gestion/dashboard/layouts/header_main.php'; ?>
<link href="assets/css/perfil_usuario.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="pagetitle">
    <h1>Perfil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <?php if (!empty($_SESSION['mensaje'])): ?>
                    <div class="alert <?= $_SESSION['tipo_mensaje'] === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['mensaje']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                    <?php
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo_mensaje']);
                    ?>
                <?php endif; ?>
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="<?= $_SESSION['usuario']['foto_perfil'] ?>" alt="Perfil" class="rounded-circle mb-3" style="width: 100%; height: 100%;">
                    <h2><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h2>
                    <h3><?= ($_SESSION['usuario']['rol'] === 'Admin') ? 'Administrador' : (htmlspecialchars($_SESSION['usuario']['rol']) === 'Guarda' ? 'Guardia de portería' : htmlspecialchars($_SESSION['usuario']['rol'])) ?></h3>
                </div>
            </div>
        </div>
        <style>
    .mb-3 input:focus {
        outline: none; /* Elimina el borde azul predeterminado */
        border: 2px solid #007832; /* Borde verde alrededor del input cuando se hace clic */
        box-shadow: none; /* Elimina cualquier sombra alrededor del input */
    }

    .mb-3 .form-control {
        border-radius: 0.25rem; /* Asegura que los bordes no se vean cuadrados */
    }
</style>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Informacion</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Contraseña</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Acerca de</h5>
                            <p class="text-muted">informacion del guarda/admin</p>

                            <h5 class="card-title">Detalles del Perfil</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Nombre Completo</div>
                                <div class="col-lg-9 col-md-8 text-muted"><?= htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos']) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Compañía</div>
                                <div class="col-lg-9 col-md-8 text-muted">Centro de Desarrollo Agroindustrial y Empresarial - CDAE (Villeta, Cundinamarca)</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Cargo</div>
                                <div class="col-lg-9 col-md-8 text-muted"><?= ($_SESSION['usuario']['rol'] === 'Admin') ? 'Coordinador' : htmlspecialchars($_SESSION['usuario']['rol']) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Dirección</div>
                                <div class="col-lg-9 col-md-8 text-muted">Cl. 2 #13 - 3, Villeta, Cundinamarca</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Teléfono</div>
                                <div class="col-lg-9 col-md-8 text-muted"><?= htmlspecialchars($_SESSION['usuario']['telefono']) ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Correo Electrónico</div>
                                <div class="col-lg-9 col-md-8 text-muted"><?= htmlspecialchars($_SESSION['usuario']['correo']) ?></div>
                            </div>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <form method="POST" action="actualizar" enctype="multipart/form-data" class="container mt-4 p-4 border rounded shadow-sm bg-light">
                                <div class="row mb-3 justify-content-center">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label text-center"></label>
                                    <div class="col-12 d-flex flex-column align-items-center">
                                        <img src="<?= $_SESSION['usuario']['foto_perfil'] ?? 'default.png' ?>" alt="Perfil" class="rounded-circle">
                                        <div class="pt-2">
                                            <input type="file" name="imagen" id="imagen" style="display: none;" accept="image/*">
                                            <a href="#" class="btn btn-primary btn-sm" id="boton_subir" onclick="document.getElementById('imagen').click(); return false;" style="background-color: #007832; border-color: #007832;">
                                                <i class="bi bi-upload me-1"></i> Subir Imagen
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="eliminarImagen()" style="background-color:rgb(255, 0, 0); border-color:rgb(255, 0, 0);">
                                                <i class="bi bi-trash me-1"></i> Eliminar Imagen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                                
    
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombres</label>
                                    <input name="nombre" type="text" class="form-control" id="nombre" value="<?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input name="apellidos" type="text" class="form-control" id="apellidos" value="<?= htmlspecialchars($_SESSION['usuario']['apellidos'] ?? '') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Phone" class="form-label">Teléfono</label>
                                    <input name="phone" type="text" class="form-control" id="Phone" value="<?= htmlspecialchars($_SESSION['usuario']['telefono'] ?? '') ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Email" class="form-label">Correo Electrónico</label>
                                    <input name="email" type="email" class="form-control" id="Email" value="<?= htmlspecialchars($_SESSION['usuario']['correo'] ?? '') ?>" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" style="background-color: #007832; border-color: #007832;">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <form action="actualizar-contrasena" method="POST" class="container mt-4 p-4 border rounded shadow-sm bg-light">
                                <div class="mb-3">
                                    <label for="contrasena_actual" class="form-label" style="color: #007832;">Contraseña Actual</label>
                                    <div class="input-group">
                                        <input name="contrasena_actual" type="password" class="form-control" id="contrasena_actual" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('contrasena_actual')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nueva_contrasena" class="form-label" style="color: #007832;">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input name="nueva_contrasena" type="password" class="form-control" id="nueva_contrasena" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('nueva_contrasena')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirmar_contrasena" class="form-label" style="color: #007832;">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input name="confirmar_contrasena" type="password" class="form-control" id="confirmar_contrasena" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirmar_contrasena')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" style="background-color: #007832; border-color: #007832;">Cambiar Contraseña</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- End Bordered Tabs -->
                </div>
            </div>
        </div>
    </div>
</section>



<script src="assets/js/perfil.js"></script>

<?php include_once __DIR__ . '/../../views/gestion/dashboard/layouts/footer_main.php'; ?>
