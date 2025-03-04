<?php

    require_once '../config/DataBase.php';

    class PerfilModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();
        }

        public function obtenerPerfilPorId($usuarioId)
        {
            $sql = "SELECT ua.id, u.nombre
                    FROM usuarios_autenticados ua
                    JOIN usuarios u ON u.id = ua.usuario_id
                    WHERE ua.id = :usuario";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>