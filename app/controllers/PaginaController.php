<?php
    
    class PaginaController{

    
        public function mostrarHome()
        {
            include_once __DIR__ . '/../views/home/main.php';
        }

        /**
         * Método para mostrar la vista de login
        */
        public function mostrarLogin() 
        {
            include_once __DIR__ . '/../views/auth/login.php';
        }

        public function mostrarHomeMain()
        {
            include_once __DIR__ . '/../views/gestion/dashboard/main_home.php';
        }

        public function mostrarRegistro()
        {
            include_once __DIR__ . '/../views/gestion/auth/registro_guardas.php';
        }

    }

?>