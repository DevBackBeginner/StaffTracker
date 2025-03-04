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

        public function mostrarDashBoard()
        {   
            include_once __DIR__ . '/../views/gestion/dashboard/main_home.php';
        }
    }
?>