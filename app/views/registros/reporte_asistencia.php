<?php
    // Establecer la zona horaria correcta antes de llamar a date()
    date_default_timezone_set('America/Bogota');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Aprendices por Ficha</title>
        <!-- Estilos básicos en línea para el PDF -->
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            .container { width: 100%; margin: 0 auto; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h1 { color: #1D4ED8; }
            .header p { font-size: 14px; color: #555; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
            th { background-color: #1D4ED8; color: #fff; }
            .ficha-title { margin-top: 30px; font-size: 16px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Reporte de Aprendices por Ficha</h1>
                <!-- Mostrar la fecha y hora de generación del reporte -->
                <p>Fecha de generación: <?= date('d/m/Y H:i:s'); ?></p>
            </div>
            <?php if (!empty($aprendicesPorFicha)): ?>
                <?php foreach ($aprendicesPorFicha as $ficha => $aprendices): ?>
                    <div class="ficha-title">Ficha: <?= htmlspecialchars($ficha) ?></div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Turno</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Computador</th>
                                <th>Código Computador</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aprendices as $aprendiz): ?>
                                <tr>
                                    <td><?= htmlspecialchars($aprendiz['nombre']) ?></td>
                                    <td><?= htmlspecialchars($aprendiz['numero_identidad']) ?></td>
                                    <td><?= htmlspecialchars($aprendiz['turno']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($aprendiz['hora_entrada'] 
                                            ? date('h:i A', strtotime($aprendiz['hora_entrada'])) 
                                            : 'Sin registro') ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($aprendiz['hora_salida'] 
                                            ? date('h:i A', strtotime($aprendiz['hora_salida'])) 
                                            : 'Sin registro') ?>
                                    </td>
                                    <td><?= htmlspecialchars($aprendiz['computador'] ?? 'Sin registro') ?></td>
                                    <td><?= htmlspecialchars($aprendiz['codigo_computador'] ?? 'Sin registro') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay aprendices registrados.</p>
            <?php endif; ?>
        </div>
    </body>
</html>
