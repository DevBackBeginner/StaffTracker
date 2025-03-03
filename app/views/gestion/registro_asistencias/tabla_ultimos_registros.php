<?php if (!empty($ultimosRegistros)): ?>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Marca PC</th>
                <th>Código PC</th>
                <th>Tipo PC</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimosRegistros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($registro['numero_identidad']); ?></td>
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
                    <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_salida'] ?? 'N/A'); ?></td>
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
    <div class="alert alert-info text-center" role="alert">
        No hay registros de asistencia aún.
    </div>
<?php endif; ?>