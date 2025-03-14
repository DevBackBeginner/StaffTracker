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
<!-- Tabla de usuarios -->
<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Rol</th>
            <th>Teléfono</th>
            <th>Información Adicional</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
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
<?php include_once __DIR__ . '/../dashboard/layouts/footer_main.php'; ?>