
<?php

    session_start();

    require_once __DIR__ . '/../models/ComputadorModelo.php';
    require_once __DIR__ . '/../models/panelIngresoModelo.php';

    class ComputadorController {
        private $computadorModelo;
        private $panelIngresoModelo;

        public function __construct() {
            $this->computadorModelo = new ComputadorModelo();
            $this->panelIngresoModelo = new PanelIngresoModelo();
        }

    }
?>