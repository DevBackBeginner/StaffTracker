<?php

    session_start();

    require_once __DIR__ . '/../models/PerfilModelo.php';

    class PerfilController
    {
        private $perfilModelo;

        public function __construct()
        {
            $this->perfilModelo = new PerfilModelo();
        }

    
    }
?>