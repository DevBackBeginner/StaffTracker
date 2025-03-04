<?php
    require_once '../config/DataBase.php';

    class DashboardModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();
        }

        
        
    }   
?>