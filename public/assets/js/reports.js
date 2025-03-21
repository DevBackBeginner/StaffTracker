$(document).ready(function() {
    // Inicializar DataTables con botones de exportación
    $('#tablaUsuarios').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json' // Español
        },
        dom: 'lBfrtip', // Coloca los botones a la derecha del selector de registros
        buttons: [
            {
                extend: 'excelHtml5', // Botón para exportar a Excel
                text: 'Excel', // Texto del botón
                className: 'btn-export'
            },
            {
                extend: 'pdfHtml5', // Botón para exportar a PDF
                text: 'PDF', // Texto del botón
                className: 'btn-export',
                customize: function(doc) {
                    // Aplicar estilo al encabezado (color verde y texto blanco)
                    doc.content[1].table.headerRows = 1; // Asegurar que la cabecera se repita en cada página
                    doc.content[1].table.body[0].forEach(function(cell) {
                        cell.fillColor = '#007832'; // Color de fondo verde
                        cell.color = '#ffffff'; // Color del texto blanco
                        cell.alignment = 'center'; // Alinear el texto al centro
                    });

                    // Reducir el tamaño del texto en el PDF
                    doc.defaultStyle.fontSize = 8; // Tamaño de fuente general
                    doc.styles.tableHeader.fontSize = 9; // Tamaño de fuente para la cabecera
                    doc.styles.tableBodyEven.fontSize = 8; // Tamaño de fuente para filas pares
                    doc.styles.tableBodyOdd.fontSize = 8; // Tamaño de fuente para filas impares

                    // Centrar la tabla en el PDF
                    doc.content[1].layout = {
                        hLineWidth: function(i, node) {
                            return 0.5; // Grosor de las líneas horizontales
                        },
                        vLineWidth: function(i, node) {
                            return 0.5; // Grosor de las líneas verticales
                        },
                        hLineColor: function(i, node) {
                            return '#cccccc'; // Color de las líneas horizontales
                        },
                        vLineColor: function(i, node) {
                            return '#cccccc'; // Color de las líneas verticales
                        },
                        paddingLeft: function(i, node) {
                            return 10; // Espaciado izquierdo
                        },
                        paddingRight: function(i, node) {
                            return 10; // Espaciado derecho
                        },
                        paddingTop: function(i, node) {
                            return 5; // Espaciado superior
                        },
                        paddingBottom: function(i, node) {
                            return 5; // Espaciado inferior
                        },
                        fillColor: function(i, node) {
                            return (i === 0) ? '#007832' : null; // Color de fondo para la cabecera
                        }
                    };

                    // Centrar la tabla en la página
                    doc.content[1].alignment = 'center';
                }
            }
        ],
        lengthMenu: [10, 25, 50, 100], // Opciones de cantidad de filas por página
        pageLength: 10 // Mostrar 10 filas por defecto
    });
});