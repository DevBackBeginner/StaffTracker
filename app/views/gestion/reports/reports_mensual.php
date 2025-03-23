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
                <li class="breadcrumb-item"><a href="Inicio">Home</a></li>
                <li class="breadcrumb-item active">Reporte Diario</li>
            </ol>
        </nav>
    </div>

    <!-- Tabla de usuarios -->
    <table id="tablaUsuarios" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th> <!-- Columna para el contador -->
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Identificación</th>
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
                <td><?= $usuario['nombre']; ?></td>
                <td><?= $usuario['apellidos']; ?></td>
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

    <script>
        $(document).ready(function() {
            // Inicializar DataTables con botones de exportación
            $('#tablaUsuarios').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' // Español
                },
                dom: '<"top"<"left"l><"center"f><"right"B>>rt<"bottom"ip><"clear">', // Ajustar disposición de elementos
                buttons: [
                    {
                        extend: 'excelHtml5', // Botón para exportar a Excel
                        text: 'Excel', // Texto del botón
                        className: 'btn-export',
                        exportOptions: {
                            modifier: {
                                search: 'applied', // Exportar solo los datos filtrados
                                order: 'applied' // Mantener el orden aplicado
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5', // Botón para exportar a PDF
                        text: 'PDF', // Texto del botón
                        className: 'btn-export',
                        exportOptions: {
                            modifier: {
                                search: 'applied', // Exportar solo los datos filtrados
                                order: 'applied' // Mantener el orden aplicado
                            }
                        },
                        customize: function(doc) {
                            // Personalización del PDF (igual que antes)
                            doc.content[1].table.headerRows = 1;
                            doc.content[1].table.body[0].forEach(function(cell) {
                                cell.fillColor = '#007832';
                                cell.color = '#ffffff';
                                cell.alignment = 'center';
                            });
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.tableBodyEven.fontSize = 8;
                            doc.styles.tableBodyOdd.fontSize = 8;
                            doc.content[1].layout = {
                                hLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                vLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                hLineColor: function(i, node) {
                                    return '#cccccc';
                                },
                                vLineColor: function(i, node) {
                                    return '#cccccc';
                                },
                                paddingLeft: function(i, node) {
                                    return 10;
                                },
                                paddingRight: function(i, node) {
                                    return 10;
                                },
                                paddingTop: function(i, node) {
                                    return 5;
                                },
                                paddingBottom: function(i, node) {
                                    return 5;
                                },
                                fillColor: function(i, node) {
                                    return (i === 0) ? '#007832' : null;
                                }
                            };
                            doc.content[1].alignment = 'center';
                        }
                    }
                ],
                lengthMenu: [10, 25, 50, 100], // Opciones de cantidad de filas por página
                pageLength: 10 // Mostrar 10 filas por defecto
            });
        });
    </script>

<?php
include_once __DIR__ . '/../dashboard/layouts/footer_main.php';
?>