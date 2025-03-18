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
                        <form method="GET" action="" class="row g-3 needs-validation" novalidate>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="documento" class="form-label fw-bold" style="color: #007832;">Documento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="documento" id="documento" class="form-control" placeholder="Documento" value="<?= htmlspecialchars($documento) ?>" required>
                                </div>
                                <div class="invalid-feedback">Por favor, ingrese su documento.</div>
                            </div>
                            <div class="col-md-12">
                                <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                                <select name="rol" id="rol" class="form-select" required>
                                    <option value="">Todos los roles</option>
                                    <option value="Instructor" <?= $rol === 'Instructor' ? 'selected' : '' ?>>Instructor</option>
                                    <option value="Funcionario" <?= $rol === 'Funcionario' ? 'selected' : '' ?>>Funcionario</option>
                                    <option value="Directivo" <?= $rol === 'Directivo' ? 'selected' : '' ?>>Directivo</option>
                                    <option value="Apoyo" <?= $rol === 'Apoyo' ? 'selected' : '' ?>>Apoyo</option>
                                    <option value="Visitante" <?= $rol === 'Visitante' ? 'selected' : '' ?>>Visitante</option>
                                </select>
                                <div class="invalid-feedback">Por favor, seleccione un rol.</div>
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
            <div class="col-12">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Documento</th>
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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                                            Editar Usuario
                                        </button>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-hidden="true">&laquo;</span>
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
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link" aria-hidden="true">&raquo;</span>
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

<!-- Modal para Editar Usuario -->
<?php include_once 'modal-editar.php' ?>
<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" method="POST" action="">
                    <input type="hidden" name="id" id="editarUsuarioId">
                    <div class="row g-3">
                        <!-- Campos comunes -->
                        <div class="col-md-6">
                            <label for="editarNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarApellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="editarApellidos" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarDocumento" class="form-label">Documento</label>
                            <input type="text" class="form-control" id="editarDocumento" name="documento" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editarRol" class="form-label">Rol</label>
                            <select class="form-select" id="editarRol" name="rol" required>
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Visitante">Visitante</option>
                            </select>
                        </div>

                        <!-- Campos específicos por rol -->
                        <div id="camposInstructor" class="camposRol" style="display: none;">
                            <div class="col-md-6">
                                <label for="editarCurso" class="form-label">Curso</label>
                                <input type="text" class="form-control" id="editarCurso" name="curso">
                            </div>
                            <div class="col-md-6">
                                <label for="editarUbicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="editarUbicacion" name="ubicacion">
                            </div>
                        </div>
                        <div id="camposFuncionario" class="camposRol" style="display: none;">
                            <div class="col-md-6">
                                <label for="editarArea" class="form-label">Área</label>
                                <input type="text" class="form-control" id="editarArea" name="area">
                            </div>
                            <div class="col-md-6">
                                <label for="editarPuesto" class="form-label">Puesto</label>
                                <input type="text" class="form-control" id="editarPuesto" name="puesto">
                            </div>
                        </div>
                        <div id="camposDirectivo" class="camposRol" style="display: none;">
                            <div class="col-md-6">
                                <label for="editarCargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="editarCargo" name="cargo">
                            </div>
                            <div class="col-md-6">
                                <label for="editarDepartamento" class="form-label">Departamento</label>
                                <input type="text" class="form-control" id="editarDepartamento" name="departamento">
                            </div>
                        </div>
                        <div id="camposApoyo" class="camposRol" style="display: none;">
                            <div class="col-md-6">
                                <label for="editarAreaTrabajo" class="form-label">Área de Trabajo</label>
                                <input type="text" class="form-control" id="editarAreaTrabajo" name="area_trabajo">
                            </div>
                        </div>
                        <div id="camposVisitante" class="camposRol" style="display: none;">
                            <div class="col-md-6">
                                <label for="editarAsunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="editarAsunto" name="asunto">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el modal -->

<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>
