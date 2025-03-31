<div id="resultados">
    <table class="table table-hover table-striped text-center">
        <thead class="thead-dark">
            <tr>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['fecha'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['hora_entrada'] ?? '') ?></td>
                        <td><?= !empty($u['hora_salida']) ? htmlspecialchars($u['hora_salida']) : 'No registrada' ?></td>
                        <td><?= htmlspecialchars($u['numero_documento']) ?></td>
                        <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
                        <td><?= htmlspecialchars($u['telefono']) ?></td>
                        <td><?= htmlspecialchars($u['rol']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <p class="text-muted mb-0">No hay usuarios registrados.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>