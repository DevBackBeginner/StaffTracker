<?php if ($ultimoRegistro): ?>
    <table class="table table-bordered">
        <thead>
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
            <tr>
                <td><?php echo htmlspecialchars($ultimoRegistro['nombre']); ?></td>
                <td><?php echo htmlspecialchars($ultimoRegistro['numero_identidad']); ?></td>
                <td>
                    <?php echo !empty($ultimoRegistro['marca']) 
                        ? htmlspecialchars($ultimoRegistro['marca']) 
                        : 'No registrado'; ?>
                </td>
                <td>
                    <?php echo !empty($ultimoRegistro['codigo']) 
                        ? htmlspecialchars($ultimoRegistro['codigo']) 
                        : 'No registrado'; ?>
                </td>
                <td>
                <?php echo !empty($ultimoRegistro['tipo']) 
                    ? htmlspecialchars($ultimoRegistro['tipo']) 
                    : 'No registrado'; ?>
                </td>
                <td><?php echo htmlspecialchars($ultimoRegistro['fecha']); ?></td>
                <td><?php echo htmlspecialchars($ultimoRegistro['hora_entrada']); ?></td>
                <td><?php echo htmlspecialchars($ultimoRegistro['hora_salida'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($ultimoRegistro['estado']); ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay registros de asistencia aún.</p>
<?php endif; ?>
