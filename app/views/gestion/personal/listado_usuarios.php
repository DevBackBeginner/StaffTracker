<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>
<link href="assets/css/listado_usuarios.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                                <label for="documento" class="form-label fw-bold" style="color: #007832;">Número de Identificación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="documento" id="documento" class="form-control" placeholder="Documento" value="<?= htmlspecialchars($documento) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
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
                                    <i class="bi bi-check-circle me-2"></i> Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['mensaje'])): ?>
                <script>
                    Swal.fire({
                        title: '<?= ($_SESSION['tipo_mensaje'] === 'success') ? 'Éxito' : 'Error' ?>',
                        text: "<?= addslashes($_SESSION['mensaje']) ?>",
                        icon: '<?= $_SESSION['tipo_mensaje'] ?>',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#007832'
                    });
                </script>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card shadow-lg mb-2">
                    <div class="card-header text-center text-white" style="background-color: green;">
                        <h5 class="mb-0">Lista de Personal</h5>
                    </div>
                    <div class="card-body p-4" style="background-color:rgb(255, 255, 255);">
                        <table class="table table-striped table-hover text-center mb-2">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Doc.</th>
                                    <th>Identificación</th>
                                    <th>Teléfono</th>
                                    <th>Rol</th>
                                    <th>Cargo</th>
                                    <th>Tipo Contrato</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuario as $us): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($us['nombre']) ?></td>
                                        <td><?= htmlspecialchars($us['apellidos']) ?></td>
                                        <td data-tipo-documento="<?= htmlspecialchars($us['tipo_documento']) ?>">
                                            <?= htmlspecialchars($us['tipo_documento']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($us['numero_identidad']) ?></td>
                                        <td><?= htmlspecialchars($us['telefono']) ?></td>
                                        <td><?= htmlspecialchars($us['rol']) ?></td>
                                        <td><?= !empty($us['cargo']) ? htmlspecialchars($us['cargo']) : '<span class="text-muted">---</span>' ?></td>
                                        <td><?= !empty($us['tipo_contrato']) ? htmlspecialchars($us['tipo_contrato']) : '<span class="text-muted">---</span>' ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Botón Editar -->
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" data-id="<?= $us['id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                
                                                <!-- Botón Eliminar -->
                                                <form method="POST" action="EliminarUsuario" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $us['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <!-- Paginación -->
                        <div class="mt-2">
                            <nav aria-label="Paginación">
                                <ul class="pagination justify-content-center mb-0">
                                    <?php if ($pagina > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" 
                                                href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina - 1 ?>" 
                                                aria-label="Anterior"
                                                style="color: #007832;">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true" style="color: #6c757d;">&laquo;</span>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                        <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
                                            <a class="page-link" 
                                                href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $i ?>"
                                                style="<?= ($i === $pagina) ? 'background-color: #007832; border-color: #007832; color: white;' : 'color: #007832;' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($pagina < $totalPaginas): ?>
                                        <li class="page-item">
                                            <a class="page-link" 
                                                href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $pagina + 1 ?>" 
                                                aria-label="Siguiente"
                                                style="color: #007832;">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true" style="color: #6c757d;">&raquo;</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-center w-100" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="EditarUsuarios" method="POST">
                    <input type="hidden" name="id" id="editarId">
                    
                    <div class="row g-3">
                        <!-- Campos básicos -->
                        <div class="col-md-6">
                            <label for="editarNombre" class="form-label"><i class="bi bi-person"></i> Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidos" class="form-label"><i class="bi bi-person-bounding-box"></i> Apellidos</label>
                            <input type="text" class="form-control" id="editarApellidos" name="apellidos" required>
                        </div>

                        <!-- Tipo de Documento -->
                        <div class="col-md-6">
                            <label for="editarTipoDocumento" class="form-label"><i class="bi bi-card-list"></i> Tipo de Documento</label>
                            <select class="form-select" id="editarTipoDocumento" name="tipo_documento" required>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="PA">Pasaporte</option>
                                <option value="NIT">NIT</option>
                                <option value="OTRO">Otro documento</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarDocumento" class="form-label"><i class="bi bi-card-id-card"></i> Número de Documento</label>
                            <input type="text" class="form-control" id="editarDocumento" name="documento" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarTelefono" class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                            <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                        </div>
                        
                        <!-- Rol -->
                        <div class="col-md-6">
                            <label for="editarRol" class="form-label"><i class="bi bi-person-fill-lock"></i> Rol</label>
                            <select class="form-select" id="editarRol" name="rol" required>
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Visitante">Visitante</option>
                            </select>
                        </div>
                        
                        <!-- Información laboral -->
                        <div class="col-md-6">
                            <label for="editarCargo" class="form-label"><i class="bi bi-briefcase"></i> Cargo</label>
                            <input type="text" class="form-control" id="editarCargo" name="cargo">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="editarTipoContrato" class="form-label"><i class="bi bi-file-earmark-text"></i> Tipo de Contrato</label>
                            <select class="form-select" id="editarTipoContrato" name="tipo_contrato">
                                <option value="">-- Seleccione --</option>
                                <option value="Planta">Planta</option>
                                <option value="Contratista">Contratista</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/modal-editar.js"></script>


<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>