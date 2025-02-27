<?php
    // Asegúrate de tener cargado el autoload de Composer
    require_once __DIR__ . '/../../vendor/autoload.php';
    
    use Dompdf\Dompdf;

    require_once __DIR__ . '/../models/PanelAsistenciaModelo.php';

    class ReporteController {
                
        /**
         * Método para generar un PDF con el reporte de aprendices agrupados por ficha.
         */
        // public function generarPDF() {
        //     // Instanciar el modelo para obtener los datos
        //     $asistenciaModelo = new PanelAsistenciaModelo();
        //     $aprendicesPorFicha = $asistenciaModelo->obtenerTodosPorFicha();

        //     // Incluir la vista que genera el HTML para el PDF.
        //     // Se utiliza output buffering para capturar el HTML.
        //     ob_start();

        //     include_once __DIR__ . '/../views/reports/reporte_aprendices_pdf.php';

        //     $html = ob_get_clean();

        //     // Crear instancia de Dompdf
        //     $dompdf = new Dompdf();

        //     // Cargar el HTML
        //     $dompdf->loadHtml($html);

        //     // Opcional: configurar tamaño de papel y orientación
        //     $dompdf->setPaper('A4', 'landscape');

        //     // Renderizar el HTML como PDF
        //     $dompdf->render();

        //     // Enviar el PDF generado al navegador (Attachment => false para visualizar en el navegador)
        //     $dompdf->stream("reporte_aprendices.pdf", ["Attachment" => true]);
        // }
    }
?>
