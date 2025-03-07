<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Documento</th>
            <?php if ($rol === 'Instructor'): ?>
                <th>Curso</th>
                <th>Ubicación</th>
            <?php elseif ($rol === 'Funcionario'): ?>
                <th>Área</th>
                <th>Puesto</th>
            <?php elseif ($rol === 'Directiva'): ?>
                <th>Cargo</th>
                <th>Departamento</th>
            <?php elseif ($rol === 'Apoyo'): ?>
                <th>Área de Trabajo</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['numero_identidad']) ?></td>

                    <?php if ($rol === 'Instructor'): ?>
                        <td><?= htmlspecialchars($u['curso'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['ubicacion'] ?? '') ?></td>
                    <?php elseif ($rol === 'Funcionario'): ?>
                        <td><?= htmlspecialchars($u['area'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['puesto'] ?? '') ?></td>
                    <?php elseif ($rol === 'Directiva'): ?>
                        <td><?= htmlspecialchars($u['cargo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['departamento'] ?? '') ?></td>
                    <?php elseif ($rol === 'Apoyo'): ?>
                        <td><?= htmlspecialchars($u['area_trabajo'] ?? '') ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No hay usuarios en esta categoría.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
