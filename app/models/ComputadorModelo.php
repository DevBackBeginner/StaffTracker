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
            // Consulta SQL para obtener los computadores asignados al usuario
            $sql = "SELECT c.id, c.marca, c.codigo 
                    FROM computadores c
                    INNER JOIN asignaciones_computadores ac ON c.id = ac.computador_id
                    INNER JOIN usuarios u ON ac.usuario_id = u.id
                    WHERE u.id = :usuario_id AND c.tipo_computador = :tipo"; // Cambia :codigo por :usuario_id
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT); // Asegúrate de que coincida con el nombre en la consulta
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->execute();
        
            // Retornar los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ingresarComputador($marca, $codigo, $mouse, $teclado, $tipo_computador)
        {
            try {
                // Consulta SQL para insertar un nuevo computador
                $sql = "INSERT INTO computadores (marca, codigo, mouse, teclado, tipo_computador) 
                        VALUES (:marca, :codigo, :mouse, :teclado, :tipo_computador)";
                
                // Preparar la consulta
                $stmt = $this->db->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmt->bindParam(':mouse', $mouse, PDO::PARAM_STR); // Nuevo parámetro
                $stmt->bindParam(':teclado', $teclado, PDO::PARAM_STR); // Nuevo parámetro
                $stmt->bindParam(':tipo_computador', $tipo_computador, PDO::PARAM_STR);
                
                // Ejecutar la consulta
                $stmt->execute();
                
                // Devolver el ID del computador registrado
                return $this->db->lastInsertId();
            } catch (PDOException $e) {
                // Manejar errores de la base de datos
                error_log("Error al registrar computador: " . $e->getMessage());
                return false;
            }
        }

        public function registrarAsignacionComputador($usuario_id, $computador_id)
        {
            try {
                // Consulta SQL para insertar la asignación
                $sql = "INSERT INTO asignaciones_computadores (usuario_id, computador_id) 
                        VALUES (:usuario_id, :computador_id)";
                
                // Preparar la consulta
                $stmt = $this->db->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                
                // Manejar el valor NULL para computador_id
                if ($computador_id === null) {
                    $stmt->bindValue(':computador_id', null, PDO::PARAM_NULL);
                } else {
                    $stmt->bindParam(':computador_id', $computador_id, PDO::PARAM_INT);
                }
                
                // Ejecutar la consulta
                $stmt->execute();
                
                // Devolver el ID de la asignación registrada
                return $this->db->lastInsertId();
            } catch (PDOException $e) {
                // Manejar errores de la base de datos
                error_log("Error al registrar asignación de computador: " . $e->getMessage());
                return false; // Retornar false en caso de error
            }
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