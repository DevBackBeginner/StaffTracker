<?php
    session_start();
    require_once __DIR__ . '/../Models/ReporteModelo.php';
    class ReportController {
        private $reporteModelo;

        public function __construct() {
            // Configurar manejo de errores
            ini_set('display_errors', 0);
            error_reporting(E_ALL);
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/php-errors.log');
    
            // Instanciar el modelo
            $this->reporteModelo = new ReporteModelo();
        }

        public function ReporteGeneral()
        {
            $usuarios = $this->reporteModelo->registroGeneral();

            // Incluir la vista para PDF
            include_once __DIR__ . '/../Views/gestion/reports/reports_general.php';

        }

        public function ReporteDiario()
        {
            // Obtener los registros del día actual desde el modelo
            $usuarios = $this->reporteModelo->registroHoy();
        
            // Incluir la vista para mostrar el reporte diario
            include_once __DIR__ . '/../Views/gestion/reports/reports_diarios.php';
        }

        public function ReporteMensual()
        {
            // Obtener los registros del día actual desde el modelo
            $usuarios = $this->reporteModelo->registroMensual();
        
            // Incluir la vista para mostrar el reporte diario
            include_once __DIR__ . '/../Views/gestion/reports/reports_mensual.php';
        }

        /**
         * Genera el reporte gráfico.
         * Obtiene los datos del modelo y los pasa a la vista.
         */
        public function generarReporteGraficos() {
        try {
            // Obtener los datos desde el modelo
            $ingresosPorHora = $this->reporteModelo->obtenerIngresosPorHora();
            // Obtener el total de usuarios desde el modelo
            $totalUsuarios = $this->reporteModelo->obtenerTotalUsuarios();

         
            
            // Validar el formato de los datos
            foreach ($ingresosPorHora as $registro) {
                if (!isset($registro['hora']) || !isset($registro['minuto']) || !isset($registro['rol']) || !isset($registro['total_ingresos'])) {
                    throw new Exception("Los datos no están en el formato esperado.");
                }
            }
            
            // Incluir la vista y pasar los datos
            include_once __DIR__ . '/../Views\gestion\reports_graficos.php\reports_graficos.php';
        } catch (Exception $e) {
            // Manejar el error
            echo "Error: " . $e->getMessage();
        }
    }
    }
?>