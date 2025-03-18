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
                                <div class="col-md-6">
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
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                            <td><?= htmlspecialchars($usuario['apellidos'])?></td>
                                            <td><?= htmlspecialchars($usuario['numero_identidad']) ?></td>
                                            <td><?= htmlspecialchars($usuario['rol']) ?></td>
                                            <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                            <td>
                                                <?php
                                                switch ($usuario['rol']) {
                                                    case 'Instructor':
                                                        echo "Curso: " . htmlspecialchars($usuario['curso']) . "<br>";
                                                        echo "Ubicación: " . htmlspecialchars($usuario['ubicacion']);
                                                        break;
                                                    case 'Funcionario':
                                                        echo "Área: " . htmlspecialchars($usuario['area']) . "<br>";
                                                        echo "Puesto: " . htmlspecialchars($usuario['puesto']);
                                                        break;
                                                    case 'Directivo':
                                                        echo "Cargo: " . htmlspecialchars($usuario['cargo']) . "<br>";
                                                        echo "Departamento: " . htmlspecialchars($usuario['departamento']);
                                                        break;
                                                    case 'Apoyo':
                                                        echo "Área de Trabajo: " . htmlspecialchars($usuario['area_trabajo']);
                                                        break;
                                                    case 'Visitante':
                                                        echo "Asunto: " . htmlspecialchars($usuario['asunto']);
                                                        break;
                                                    default:
                                                        echo "Sin información adicional.";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editarUsuarioModal" 
                                                        onclick="cargarDatosUsuario(
                                                            <?= $usuario['id'] ?>, 
                                                            '<?= htmlspecialchars($usuario['nombre']) ?>',
                                                            '<?= htmlspecialchars($usuario['apellidos']) ?>',
                                                            '<?= htmlspecialchars($usuario['numero_identidad']) ?>', 
                                                            '<?= htmlspecialchars($usuario['rol']) ?>', 
                                                            '<?= htmlspecialchars($usuario['telefono']) ?>', 
                                                            {
                                                                curso: '<?= $usuario['curso'] ?? '' ?>',
                                                                ubicacion: '<?= $usuario['ubicacion'] ?? '' ?>',
                                                                area: '<?= $usuario['area'] ?? '' ?>',
                                                                puesto: '<?= $usuario['puesto'] ?? '' ?>',
                                                                cargo: '<?= $usuario['cargo'] ?? '' ?>',
                                                                departamento: '<?= $usuario['departamento'] ?? '' ?>',
                                                                area_trabajo: '<?= $usuario['area_trabajo'] ?? '' ?>',
                                                                asunto: '<?= $usuario['asunto'] ?? '' ?>'
                                                            }
                                                        )">
                                                    <i class="fas fa-edit"></i> Editar
                                                </button>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?= $usuario['id'] ?>, '<?= $usuario['rol'] ?>')">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>
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
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editarUsuarioForm" action="EditarUsuarios" method="POST" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id" id="usuarioId">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-bold" style="color: #007832;">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="apellidos" class="form-label fw-bold" style="color: #007832;">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                            <div class="invalid-feedback">Por favor, ingrese sus apellidos.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="documento" class="form-label fw-bold" style="color: #007832;">N° Identidad</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                <input type="text" class="form-control" id="documento" name="documento" required>
                            </div>
                            <div class="invalid-feedback">Por favor, ingrese su número de identidad.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-bold" style="color: #007832;">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="invalid-feedback">Por favor, ingrese su teléfono.</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="rol" class="form-label fw-bold" style="color: #007832;">Rol</label>
                            <select class="form-select" id="rol" name="rol" required onchange="actualizarCamposAdicionales()">
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Visitante">Visitante</option>
                            </select>
                            <div class="invalid-feedback">Por favor, seleccione un rol.</div>
                        </div>

                        <div id="camposInstructor" class="campos-adicionales col-md-6">
                            <label for="curso" class="form-label fw-bold" style="color: #007832;">Curso</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-book"></i></span>
                                <input type="text" class="form-control" id="curso" name="curso">
                            </div>
                        </div>
                        <div id="camposInstructor" class="campos-adicionales col-md-6">
                            <label for="ubicacion" class="form-label fw-bold" style="color: #007832;">Ubicación</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                            </div>
                        </div>

                        <div id="camposFuncionario" class="campos-adicionales col-md-6">
                            <label for="area" class="form-label fw-bold" style="color: #007832;">Área</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                <input type="text" class="form-control" id="area" name="area">
                            </div>
                        </div>
                        <div id="camposFuncionario" class="campos-adicionales col-md-6">
                            <label for="puesto" class="form-label fw-bold" style="color: #007832;">Puesto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <input type="text" class="form-control" id="puesto" name="puesto">
                            </div>
                        </div>

                        <div id="camposDirectivo" class="campos-adicionales col-md-6">
                            <label for="cargo" class="form-label fw-bold" style="color: #007832;">Cargo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" class="form-control" id="cargo" name="cargo">
                            </div>
                        </div>
                        <div id="camposDirectivo" class="campos-adicionales col-md-6">
                            <label for="departamento" class="form-label fw-bold" style="color: #007832;">Departamento</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                                <input type="text" class="form-control" id="departamento" name="departamento">
                            </div>
                        </div>

                        <div id="camposApoyo" class="campos-adicionales col-md-6">
                            <label for="area_trabajo" class="form-label fw-bold" style="color: #007832;">Área de Trabajo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tools"></i></span>
                                <input type="text" class="form-control" id="area_trabajo" name="area_trabajo">
                            </div>
                        </div>

                        <div id="camposVisitante" class="campos-adicionales col-md-6">
                            <label for="asunto" class="form-label fw-bold" style="color: #007832;">Asunto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                                <input type="text" class="form-control" id="asunto" name="asunto">
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #007832; border-color: #007832;">
                                <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/listado_usuarios.js"></script>

    <?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>
