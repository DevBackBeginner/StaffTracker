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

        public function mostrarPerfil()
        {
            $id = $_SESSION['usuario']['id'];
            $usuario = $this->perfilModelo->obtenerPerfilPorId($id);
            include_once __DIR__ . '/../views/profile/perfil_usuario.php';
        }
    }            

?>