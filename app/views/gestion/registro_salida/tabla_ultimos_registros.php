<?php if (!empty($ultimosRegistros)): ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th class="fs-6">Fecha</th>
                <th class="fs-6">Hora Entrada</th>
                <th class="fs-6">Hora Salida</th>
                <th class="fs-6">Nombre</th>
                <th class="fs-6">Identificación</th>
                <th class="fs-6">Rol</th>
                <th class="fs-6">Marca del Equipo</th>
                <th class="fs-6">Código</th>
                <th class="fs-6">Tipo</th>
                <th class="fs-6">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimosRegistros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_salida']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_salida']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($registro['numero_identidad']); ?></td>
                    <td><?php echo htmlspecialchars($registro['rol']); ?></td>
                    <td>
                        <?php echo !empty($registro['marca']) 
                            ? htmlspecialchars($registro['marca']) 
                            : 'No registrado'; ?>
                    </td>
                    <td>
                        <?php echo !empty($registro['codigo']) 
                            ? htmlspecialchars($registro['codigo']) 
                            : 'No registrado'; ?>
                    </td>
                    <td>
                        <?php echo !empty($registro['tipo']) 
                            ? htmlspecialchars($registro['tipo']) 
                            : 'No registrado'; ?>
                    </td>
                    <td>
                        <span class="badge 
                            <?php echo ($registro['estado'] === 'Activo') ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo htmlspecialchars($registro['estado']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info text-center mt-4" role="alert">
        No hay registros de asistencia aún.
    </div>
<?php endif; ?>
