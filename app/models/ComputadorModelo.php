<?php
    require_once '../config/DataBase.php';

    class ComputadorModelo
    {
        // Propiedad para almacenar la conexión a la base de datos
        private $db;

        /**
            * Constructor: Crea una nueva instancia de la base de datos y asigna la conexión a la propiedad $db.
            */
        public function __construct() {
            // Crear una instancia de la clase DataBase para obtener la conexión
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();
        }
    
    
    }
?>