<?php
include_once __DIR__ . '/../dashboard/layouts/header_main.php';
?>
    <div class="pagetitle">
        <h1>Registro de Personal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Inicio">Inicio</a></li>
                <li class="breadcrumb-item">Gestion de Personal</li>

                <li class="breadcrumb-item active">Registro de Personal</li>
            </ol>
        </nav>
    </div>
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

<!-- Estilos personalizados -->
<style>
    .dt-buttons .btn {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 12px;
        margin-right: 10px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .dt-buttons .btn:hover {
        background-color: #218838;
        transform: translateY(-2px);
        cursor: pointer;
    }

    .table {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
    }

    .table th {
        background-color: #28a745;
        color: white;
    }

    /* Mejora del diseño del buscador de DataTables */
    .dataTables_filter input {
        border: 2px solid #28a745;
        border-radius: 20px;
        padding: 8px 15px;
        outline: none;
        transition: all 0.3s ease-in-out;
    }

    .dataTables_filter input:focus {
        border-color: #218838;
        box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
    }
</style>


    <!-- Tabla de usuarios -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tablaUsuarios" class="table table-bordered table-striped" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>N° Identificación</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Fecha</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1;
                    foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $contador; ?></td>
                        <td><?= $usuario['nombre'] . " " . $usuario['apellido']; ?></td>
                        <td><?= $usuario['numero_documento']; ?></td>
                        <td><?= $usuario['telefono']; ?></td>
                        <td><?= $usuario['rol']; ?></td>
                        <td><?= $usuario['fecha']; ?></td>
                        <td><?= $usuario['hora_ingreso']; ?></td>
                        <td><?= $usuario['hora_salida']; ?></td>
                    </tr>
                    <?php
                    $contador++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablaUsuarios').DataTable({
            dom: '<"" B>frtip', // Centrar botones
            buttons: [
                {
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-success'
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-success'
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            }
        });
    });
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="assets/js/reports_mensual.js"></script>

<?php
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>