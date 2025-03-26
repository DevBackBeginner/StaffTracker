<?php
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>

    <!-- jQuery y DataTables -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <!-- Estilos de DataTables y Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Estilo personalizado para los botones -->
    <style>
        .dt-buttons {
            margin-left: 20px; /* Margen a la izquierda de los botones */
        }
    </style>

    <div class="pagetitle">
        <h1>Reporte Diario</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Reporte Diario</li>
            </ol>
        </nav>
    </div>

    <!-- Tabla de usuarios -->
    <table id="tablaUsuarios" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th> <!-- Columna para el contador -->
                <th>Nombres</th>
                <th>Numero de Identificación</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 1; // Inicializamos el contador en 1
            foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $contador; ?></td> <!-- Mostramos el contador -->
                <td><?= $usuario['nombre'] . "  " . $usuario['apellidos']; ?></td>
                <td><?= $usuario['numero_identidad']; ?></td>
                <td><?= $usuario['telefono']; ?></td>
                <td><?= $usuario['rol']; ?></td>
                <td><?= $usuario['fecha']; ?></td>
                <td><?= $usuario['hora_entrada']; ?></td>
                <td><?= $usuario['hora_salida']; ?></td>
            </tr>
            <?php
            $contador++; // Incrementamos el contador
            endforeach; ?>
        </tbody>
    </table>

    <script src="assets/js/reports_diarios.js"></script>
    
<?php
// Incluimos el footer que contiene la estructura HTML final
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>

