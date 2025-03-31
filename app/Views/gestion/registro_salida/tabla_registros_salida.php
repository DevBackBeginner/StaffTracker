<?php if (!empty($ultimosRegistros)): ?>
    <table class="table table-bordered table-hover text-center">
        <thead class="thead-light">
            <tr>
                <th class="fs-6">Fecha</th>
                <th class="fs-6">Hora Entrada</th>
                <th class="fs-6">Hora Salida</th>
                <th class="fs-6">Identificación</th>
                <th class="fs-6">Nombre</th>
                <th class="fs-6">Rol</th>
                <th class="fs-6">Tipo del computador</th>
                <th class="fs-6">Modelo del Equipo</th>
                <th class="fs-6">Código</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimosRegistros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_salida']); ?></td>
                    <td><?php echo htmlspecialchars($registro['hora_salida']); ?></td>
                    <td><?php echo htmlspecialchars($registro['numero_identidad']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($registro['rol']); ?></td>
                    <td>
                        <?= !empty($registro['tipo']) 
                            ? ($registro['tipo'] === 'SENA' ? 'Computador SENA' : 
                            ($registro['tipo'] === 'Personal' ? 'Computador Personal' : 
                            htmlspecialchars($registro['tipo'])))
                            : 'No registrado' ?>
                    </td>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-success text-center mt-4" role="alert">
        No hay registros de asistencia aún.
    </div>
<?php endif; ?>
