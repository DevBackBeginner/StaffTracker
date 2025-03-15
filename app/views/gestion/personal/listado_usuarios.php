<?php include_once __DIR__ . '/../dashboard/layouts/header_main.php'; ?>

    <!-- Filtros -->
    <form method="GET" action="">
        <input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($nombre) ?>">
        <input type="text" name="documento" placeholder="Documento" value="<?= htmlspecialchars($documento) ?>">
        <select name="rol">
            <option value="">Todos los roles</option>
            <option value="Instructor" <?= $rol === 'Instructor' ? 'selected' : '' ?>>Instructor</option>
            <option value="Funcionario" <?= $rol === 'Funcionario' ? 'selected' : '' ?>>Funcionario</option>
            <option value="Directivo" <?= $rol === 'Directivo' ? 'selected' : '' ?>>Directivo</option>
            <option value="Apoyo" <?= $rol === 'Apoyo' ? 'selected' : '' ?>>Apoyo</option>
            <option value="Visitante" <?= $rol === 'Visitante' ? 'selected' : '' ?>>Visitante</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <!-- Tabla de usuarios -->
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Documento</th>
                <th>Rol</th>
                <th>Teléfono</th>
                <th>Información Adicional</th>
                <th>Acciones</th> <!-- Nueva columna para los botones -->
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
                        // Mostrar información adicional según el rol
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
                    <!-- Columna de acciones -->
                    <td>
                        <!-- Botón de Editar -->
                        <button class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editarUsuarioModal" 
                                onclick="cargarDatosUsuario(
                                    <?= $usuario['id'] ?>, 
                                    '<?= htmlspecialchars($usuario['nombre']) ?>',
                                    '<?= htmlspecialchars($usuario['apellidos']) ?>', // Nuevo campo
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
                        <!-- Botón de Eliminar -->
                        <a href="#" class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?= $usuario['id'] ?>, '<?= $usuario['rol'] ?>')">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Paginación">
        <ul class="pagination justify-content-center">
            <!-- Botón "Anterior" -->
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

            <!-- Números de página -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
                    <a class="page-link" 
                        href="?rol=<?= urlencode($rol) ?>&nombre=<?= urlencode($nombre) ?>&documento=<?= urlencode($documento) ?>&orden=<?= urlencode($orden) ?>&direccion=<?= urlencode($direccion) ?>&pagina=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Botón "Siguiente" -->
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

    <!-- Modal para Editar Usuario -->
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editarUsuarioForm" action="EditarUsuarios" method="POST">
                        <!-- Campo oculto para el ID del usuario -->
                        <input type="hidden" name="id" id="usuarioId">

                        <!-- Campos comunes -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label">N° Identidad</label>
                            <input type="text" class="form-control" id="documento" name="documento" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" name="rol" required onchange="actualizarCamposAdicionales()">
                                <option value="Instructor">Instructor</option>
                                <option value="Funcionario">Funcionario</option>
                                <option value="Directivo">Directivo</option>
                                <option value="Apoyo">Apoyo</option>
                                <option value="Visitante">Visitante</option>
                            </select>
                        </div>

                        <!-- Campos adicionales para cada rol -->
                        <!-- Instructor -->
                        <div id="camposInstructor" class="campos-adicionales">
                            <div class="mb-3">
                                <label for="curso" class="form-label">Curso</label>
                                <input type="text" class="form-control" id="curso" name="curso">
                            </div>
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                            </div>
                        </div>

                        <!-- Funcionario -->
                        <div id="camposFuncionario" class="campos-adicionales">
                            <div class="mb-3">
                                <label for="area" class="form-label">Área</label>
                                <input type="text" class="form-control" id="area" name="area">
                            </div>
                            <div class="mb-3">
                                <label for="puesto" class="form-label">Puesto</label>
                                <input type="text" class="form-control" id="puesto" name="puesto">
                            </div>
                        </div>

                        <!-- Directivo -->
                        <div id="camposDirectivo" class="campos-adicionales">
                            <div class="mb-3">
                                <label for="cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="cargo" name="cargo">
                            </div>
                            <div class="mb-3">
                                <label for="departamento" class="form-label">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento">
                            </div>
                        </div>

                        <!-- Apoyo -->
                        <div id="camposApoyo" class="campos-adicionales">
                            <div class="mb-3">
                                <label for="area_trabajo" class="form-label">Área de Trabajo</label>
                                <input type="text" class="form-control" id="area_trabajo" name="area_trabajo">
                            </div>
                        </div>

                        <!-- Visitante -->
                        <div id="camposVisitante" class="campos-adicionales">
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto">
                            </div>
                        </div>

                        <!-- Botón para enviar el formulario -->
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/listado_usuarios.js"></script>


<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>