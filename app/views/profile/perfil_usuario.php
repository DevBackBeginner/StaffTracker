<?php include_once __DIR__ . '/../../views/gestion/dashboard/layouts/header_main.php'; ?>
    <!-- Incluir SweetAlert2 desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main id="main" class="main">
        <!-- end header -->
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600&display=swap" rel="stylesheet">

        <div class="pagetitle">
            <h1>Perfil</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Perfil</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card" style="width: 100%;">
                            
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
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="<?= $_SESSION['usuario']['foto_perfil'] ?>" alt="Profile" class="rounded-circle">
                            <h2><?= $_SESSION['usuario']['nombre']?></h2>
                            <h3><?= ($_SESSION['usuario']['rol'] === 'admin') ? 'Administrador' : (htmlspecialchars($_SESSION['usuario']['rol']) === 'guarda' ? 'Guardia de portería' : htmlspecialchars($_SESSION['usuario']['rol'])) ?></h3>
                            <div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card" style="width: 95%;">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
                                <!-- <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                                </li> -->
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?= $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos']?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8">Centro de Desarrollo Agroindustrial y Empresarial - CDAE (Villeta, Cundinamarca)</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Job</div>
                                        <div class="col-lg-9 col-md-8"><?= ($_SESSION['usuario']['rol'] === 'admin') ? 'Administrador' : htmlspecialchars($_SESSION['usuario']['rol'])?> del sistema</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8">Cl. 2 #13 - 3, Villeta, Cundinamarca</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8"><?= $_SESSION['usuario']['telefono'] ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?= $_SESSION['usuario']['correo'] ?></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form method="POST" action="actualizar" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <!-- Mostrar la imagen de perfil actual o una imagen por defecto -->
                                                <img src="<?= $_SESSION['usuario']['foto_perfil'] ?? 'default.png' ?>" alt="Profile" class="rounded-circle">
                                                <div class="pt-2">
                                                    <!-- Input de archivo (oculto) -->
                                                    <input type="file" name="imagen" id="imagen" style="display: none;" accept="image/*">

                                                    <!-- Botón para subir una nueva imagen -->
                                                    <a href="#" class="btn btn-primary btn-sm" onclick="document.getElementById('imagen').click(); return false;">
                                                    <i class="bi bi-upload me-1"></i> Upload profile image
                                                </a>
                                                <!-- Botón para eliminar la imagen -->
                                                <button class="btn btn-danger btn-sm" onclick="eliminarImagen()">
                                                    <i class="bi bi-trash me-1"></i> Remove my profile image
                                                </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="nombre" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nombre" type="text" class="form-control" id="nombre" 
                                                    value="<?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="apellidos" class="col-md-4 col-lg-3 col-form-label">Apellidos</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="apellidos" type="text" class="form-control" id="apellidos" 
                                                    value="<?= htmlspecialchars($_SESSION['usuario']['apellidos'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control" id="Phone" 
                                                    value="<?= htmlspecialchars($_SESSION['usuario']['telefono'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" 
                                                    value="<?= htmlspecialchars($_SESSION['usuario']['correo'] ?? '') ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- <div class="tab-pane fade pt-3" id="profile-settings"> -->
                                    <!-- Settings Form
                                    <form>
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                    <label class="form-check-label" for="changesMade">
                                                        Changes made to your account
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                    <label class="form-check-label" for="newProducts">
                                                        Information on new products and services
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="proOffers">
                                                    <label class="form-check-label" for="proOffers">
                                                        Marketing and promo offers
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                                    <label class="form-check-label" for="securityNotify">
                                                        Security alerts
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>End settings Form -->
                                <!-- </div> -->

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="actualizar-contrasena" method="POST">
                                    <div class="row mb-3">
                                        <label for="contrasena_actual" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9 input-group">
                                            <input name="contrasena_actual" type="password" class="form-control" id="contrasena_actual">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('contrasena_actual')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="nueva_contrasena" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9 input-group">
                                            <input name="nueva_contrasena" type="password" class="form-control" id="nueva_contrasena">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('nueva_contrasena')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="confirmar_contrasena" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9 input-group">
                                            <input name="confirmar_contrasena" type="password" class="form-control" id="confirmar_contrasena">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirmar_contrasena')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->
                                </div>

                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

<?php include_once __DIR__ . '/../../views/gestion/dashboard/layouts/footer_main.php'; ?>

<script>
    // Función para subir la imagen
    // Función para manejar la selección de la imagen
    document.getElementById('imagen').addEventListener('change', function(event) {
    const archivo = event.target.files[0]; // Obtener el archivo seleccionado
    if (archivo) {
        console.log("Archivo seleccionado:", archivo.name); // Verificar en la consola
        subirImagen(archivo);
    }
    });
        
    // Función para subir la imagen
    function subirImagen(archivo) {
        console.log("Subiendo imagen:", archivo.name); // Verificar en la consola
        const formData = new FormData();
        formData.append('imagen', archivo);

        fetch('subir-imagen', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor:", data); // Verificar en la consola
            if (data.success) {
                // Recargar la página para mostrar el mensaje de éxito
                window.location.reload();
            } else {
                // Recargar la página para mostrar el mensaje de error
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Recargar la página incluso si hay un error
            window.location.reload();
        });
    }
    // Función para eliminar la imagen
    function eliminarImagen() {
        if (confirm('¿Estás seguro de que deseas eliminar la imagen de perfil?')) {
            fetch('eliminar-imagen', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recargar la página para mostrar el mensaje de éxito
                    window.location.reload();
                } else {
                    // Recargar la página para mostrar el mensaje de error
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Recargar la página incluso si hay un error
                window.location.reload();
            });
        }
    }
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.querySelector(`[onclick="togglePassword('${inputId}')"] i`);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>