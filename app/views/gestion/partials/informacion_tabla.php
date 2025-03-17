<div id="resultados">
    <table class="table table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <!-- Columnas comunes -->
                <th>Nombre</th>
                <th>Telefono</th>
                <th>N° Identidad</th>
                <!-- Nuevas columnas -->
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <!-- Columnas específicas según el rol -->
                <?php if ($rol === 'Instructor'): ?>
                    <th>Curso</th>
                    <th>Ubicación</th>
                <?php elseif ($rol === 'Funcionario'): ?>
                    <th>Área</th>
                    <th>Puesto</th>
                <?php elseif ($rol === 'Directivo'): ?>
                    <th>Cargo</th>
                    <th>Departamento</th>
                <?php elseif ($rol === 'Apoyo'): ?>
                    <th>Área de Trabajo</th>
                <?php endif; ?>
                <?php if ($rol === 'Visitante'): ?>
                    <th>Asunto</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <!-- Mostrar datos de usuarios si existen -->
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']) ?></td>
                        <td><?= htmlspecialchars($u['telefono']) ?></td>
                        <td><?= htmlspecialchars($u['numero_identidad']) ?></td>

                        <!-- Nuevas columnas -->
                        <td><?= htmlspecialchars($u['fecha'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['hora_entrada'] ?? '') ?></td>
                        <td>
                            <?= !empty($u['hora_salida']) ? htmlspecialchars($u['hora_salida']) : 'No registrada' ?>
                        </td>
                        <!-- Columnas específicas según el rol -->
                        <?php if ($rol === 'Instructor'): ?>
                            <td><?= htmlspecialchars($u['curso'] ?? '') ?></td>
                            <td><?= htmlspecialchars($u['ubicacion'] ?? '') ?></td>
                        <?php elseif ($rol === 'Funcionario'): ?>
                            <td><?= htmlspecialchars($u['area'] ?? '') ?></td>
                            <td><?= htmlspecialchars($u['puesto'] ?? '') ?></td>
                        <?php elseif ($rol === 'Directivo'): ?>
                            <td><?= htmlspecialchars($u['cargo'] ?? '') ?></td>
                            <td><?= htmlspecialchars($u['departamento'] ?? '') ?></td>
                        <?php elseif ($rol === 'Apoyo'): ?>
                            <td><?= htmlspecialchars($u['area_trabajo'] ?? '') ?></td>
                        <?php endif; ?>
                        <?php if ($rol === 'Visitante'): ?>
                            <td><?= htmlspecialchars($u['asunto'] ?? '') ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mensaje cuando no hay usuarios -->
                <tr>
                    <td colspan="100%" class="text-center py-4">
                        <p class="text-muted mb-0">No hay usuarios en esta categoría.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
