<?php 

    session_start();

    require_once __DIR__ . '/../models/DashboardModelo.php';
    require_once __DIR__ . '/../models/PerfilModelo.php';

    class DashboardController
    {
        private $dashboardMondelo;
        private $perfilModelo;
        public function __construct()
        {
            $this->dashboardMondelo = new DashboardModelo();
            $this->perfilModelo = new PerfilModelo();
        }

        private function tieneRol()
        {
            return isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] !== '';
        }

        public function mostrarDashBoard()
        {  
            // Verifica si el rol está vacío
            // Verifica si la sesión está iniciada y si el rol está vacío
            if (!$this->tieneRol()) 
            {            
                // Si no hay rol, muestra la página de inicio de sesión
                include_once __DIR__ . '/../views/home/main.php';
            }else {
                // Si hay rol, muestra el dashboard
                include_once __DIR__ . '/../views/gestion/dashboard/main_home.php';
            }
        }
    }

?>