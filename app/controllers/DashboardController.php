<?php 

    session_start();

    require_once __DIR__ . '/../models/DashboardModelo.php';

    class DashboardController
    {
        private $dashboardModelo;

        public function __construct()
        {
            $this->dashboardModelo = new DashboardModelo();
        }

        private function tieneRol()
        {
            return isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] !== '';
        }

        public function mostrarDashBoard()
        {
            // Verifica si el rol está vacío
            if (!$this->tieneRol()) {
                // Si no hay rol, muestra la página de inicio de sesión
                include_once __DIR__ . '/../views/home/main.php';
            } else {
                // Obtiene los registros diarios, semanales y mensuales
                $registrosDiarios = $this->dashboardModelo->obtenerRegistroDiario();
                $registrosDiaAnterior = $this->dashboardModelo->obtenerRegistrosDiaAnterior();
                $porcentajeAumentoDiario = $this->dashboardModelo->calcularPorcentajeAumento($registrosDiarios, $registrosDiaAnterior);


                // Si hay rol, muestra el dashboard
                include_once __DIR__ . '/../views/gestion/dashboard/main_home.php';
            }
        }

        /**
         * Obtener los datos filtrados para el dashboard.
         */
        public function obtenerDatosFiltrados()
        {
            // Leer el cuerpo de la solicitud POST
            $datos = json_decode(file_get_contents('php://input'), true);

            // Obtener el filtro del cuerpo de la solicitud
            $filtro = $datos['filtro'] ?? null;

            // Obtener los datos según el filtro
            switch ($filtro) {
                case 'diarios':
                    $actual = $this->dashboardModelo->obtenerRegistroDiario();
                    $anterior = $this->dashboardModelo->obtenerRegistrosDiaAnterior();
                    break;
                case 'semanales':
                    $actual = $this->dashboardModelo->obtenerRegistroSemanal();
                    $anterior = $this->dashboardModelo->obtenerRegistrosSemanaAnterior();
                    break;
                case 'mensuales':
                    $actual = $this->dashboardModelo->obtenerRegistroMensual();
                    $anterior = $this->dashboardModelo->obtenerRegistroMensualAnterior();
                    break;
                default:
                    $actual = 0;
                    $anterior = 0;
                    break;
            }

            // Calcular el porcentaje de aumento
            $porcentajeAumento = $this->dashboardModelo->calcularPorcentajeAumento($actual, $anterior);

            // Devolver los datos en formato JSON
            echo json_encode([
                'total' => $actual,
                'porcentajeAumento' => round($porcentajeAumento, 2) // Redondear a 2 decimales
            ]);
        }
    }

?>