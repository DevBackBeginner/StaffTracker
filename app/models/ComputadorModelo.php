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

        
        // Obtener computadores según el tipo ("SENA", "Personal")
        public function obtenerComputadoresPorUsuario($usuarioId, $tipo) {
            $sql = "SELECT c.id, c.marca, c.codigo, c.tipo_computador
                    FROM asignaciones_computadores ac
                    JOIN computadores c ON ac.computador_id = c.id
                    WHERE ac.usuario_id = :usuario_id
                      AND c.tipo_computador = :tipo";  // Eliminamos la comilla extra
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        

        // Registrar la asignación del computador a un usuario (si es que guardas en 'asignaciones_computadores')
        public function asignarComputador($usuarioId, $computadorId) {
            // Suponiendo que en 'asignaciones_computadores' guardas la relación
            $sql = "INSERT INTO asignaciones_computadores (usuario_id, computador_id)
                    VALUES (:usuario_id, :computador_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmt->bindParam(':computador_id', $computadorId, PDO::PARAM_INT);
            return $stmt->execute();
        }
        
        
    }
?>