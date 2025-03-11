<?php
    require_once '../config/DataBase.php';

    class VisitantesModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();

            $this->db = $conn->getConnection();
        }

        public function registroVisitante($nombre, $apellido, $numero_identidad, $telefono, $asunto, $rol)
        {
            
        }
    }
?>