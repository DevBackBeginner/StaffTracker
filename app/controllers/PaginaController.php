<?php
    
    class PaginaController{

        /**
         * Método para mostrar la vista de login
        */
        public function mostrarLogin() 
        {
            include_once __DIR__ . '/../views/auth/login.php';
        }

        public function mostrarMain()
        {
            include_once __DIR__ . '/../views/home/home.php';
        }

    }

?>