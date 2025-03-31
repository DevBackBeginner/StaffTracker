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