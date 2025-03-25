<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
<div class="pagetitle">
    <h1>Registro de Acceso</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Registro Acceso</li>
        </ol>
    </nav>
</div>
<div class="container-fluid">
    <section class="section register py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-4">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-4">
                                <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombres</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="documento" class="form-label fw-bold" style="color: #007832;">Numero de Identificación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="documento" id="documento" class="form-control" placeholder="Documento" value="<?= htmlspecialchars($documento) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span> <!-- Icono agregado -->
                                    <select name="rol" id="rol" class="form-select">
                                        <option value="">Todos los roles</option>
                                        <option value="Instructor" <?= $rol === 'Instructor' ? 'selected' : '' ?>>Instructores</option>
                                        <option value="Funcionario" <?= $rol === 'Funcionario' ? 'selected' : '' ?>>Funcionarios</option>
                                        <option value="Directivo" <?= $rol === 'Directivo' ? 'selected' : '' ?>>Directivos</option>
                                        <option value="Apoyo" <?= $rol === 'Apoyo' ? 'selected' : '' ?>>Apoyos</option>
                                        <option value="Visitante" <?= $rol === 'Visitante' ? 'selected' : '' ?>>Visitantes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                    <i class="bi bi-check-circle me-2"></i>Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Mostrar mensajes de éxito o error -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert <?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'alert-success' : 'alert-danger'; ?> text-center">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
                <?php
                // Limpiar el mensaje después de mostrarlo
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
                ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Identificación</th>
                                    <th>Rol</th>
                                    <th>Teléfono</th>
                                    <th>Información Adicional</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuario as $us): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($us['nombre']) ?></td>
                                        <td><?= htmlspecialchars($us['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($us['numero_identidad']) ?></td>
                                        <td><?= htmlspecialchars($us['rol']) ?></td>
                                        <td><?= htmlspecialchars($us['telefono']) ?></td>
                                        <td>
                                            <?php
                                            switch ($us['rol']) {
                                                case 'Instructor':
                                                    echo "Curso: " . htmlspecialchars($us['curso']) . "<br>";
                                                    echo "Ubicación: " . htmlspecialchars($us['ubicacion']);
                                                    break;
                                                case 'Funcionario':
                                                    echo "Área: " . htmlspecialchars($us['area']) . "<br>";
                                                    echo "Puesto: " . htmlspecialchars($us['puesto']);
                                                    break;
                                                case 'Directivo':
                                                    echo "Cargo: " . htmlspecialchars($us['cargo']) . "<br>";
                                                    echo "Departamento: " . htmlspecialchars($us['departamento']);
                                                    break;
                                                case 'Apoyo':
                                                    echo "Área de Trabajo: " . htmlspecialchars($us['area_trabajo']);
                                                    break;
                                                case 'Visitante':
                                                    echo "Asunto: " . htmlspecialchars($us['asunto']);
                                                    break;
                                                default:
                                                    echo "Sin información adicional.";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="<?= $us['id'] ?>">
                                                <i class="bi bi-pencil"></i> Editar  <!-- Icono agregado -->
                                            </button>
                                        </td>
                                        <td>
                                            <form method="POST" action="EliminarUsuario" style="display: inline;">
                                                <input type="hidden" name="id" value="<?= $us['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para Editar Usuario -->
        <?php include_once 'modal-editar.php' ?>

        <div class="row">
            <div class="col-12">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-4">
                        <nav aria-label="Paginación">
                            <ul class="pagination justify-content-center">
                                <?php if ($pagina > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" 
                                            href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina - 1 ?>" 
                                            aria-label="Anterior">
                                            <span aria-hidden="true">«</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-hidden="true">«</span>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
                                        <a class="page-link" 
                                            href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagina < $totalPaginas): ?>
                                    <li class="page-item">
                                        <a class="page-link" 
                                            href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina + 1 ?>" 
                                            aria-label="Siguiente">
                                            <span aria-hidden="true">»</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-hidden="true">»</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Script para manejar el modal -->
<script src="assets/js/listado_usuarios.js"></script>

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
<!-- Asegúrate de incluir Bootstrap Icons en el head -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">