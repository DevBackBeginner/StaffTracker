<?php 

    // Incluir el archivo de configuración de la base de datos
    require_once '../config/DataBase.php';

    // Definir la clase RegistroIngresoModelo
    class RegistroAccesoModelo {
        private $db; // Variable para almacenar la conexión a la base de datos

        // Constructor de la clase
        public function __construct() {
            $conn = new DataBase(); // Crear una instancia de la clase DataBase
            $this->db = $conn->getConnection(); // Obtener la conexión a la base de datos
            date_default_timezone_set('America/Bogota'); // Establecer la zona horaria
        }

        // Método para obtener la asistencia del día por usuario
        public function obtenerAsistenciaDelDia($asignacion_id, $fecha) {
            // Consulta SQL para obtener el registro de acceso del día actual
            $sql = "SELECT * FROM registros WHERE asignacion_id  = :asignacion_id AND fecha = :fecha LIMIT 1";
            $stmt = $this->db->prepare($sql); // Preparar la consulta
            $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT); // Vincular el parámetro asignacion_id
            $stmt->bindParam(':fecha', $fecha); // Vincular el parámetro fecha
            $stmt->execute(); // Ejecutar la consulta
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retornar el resultado como un array asociativo
        }

        // Método para crear una nueva asignación de usuario y computador
        public function crearAsignacion($usuario_id, $computador_id) {
            // Consulta SQL para insertar una nueva asignación
            $sql = "INSERT INTO asignaciones_computadores (usuario_id, computador_id) 
                    VALUES (:usuario_id, :computador_id)";
            $stmt = $this->db->prepare($sql); // Preparar la consulta
            $stmt->bindValue(':usuario_id', $usuario_id); // Vincular el parámetro usuario_id
            $stmt->bindValue(':computador_id', $computador_id); // Vincular el parámetro computador_id
            $stmt->execute(); // Ejecutar la consulta
            return $this->db->lastInsertId(); // Retornar el ID de la última inserción
        }

        // Método para registrar la entrada de un usuario
        public function registrarEntrada($fecha, $hora, $asignacionId, $tipo_usuario) {
            try {
                // Consulta SQL para insertar el registro de entrada con el tipo de usuario
                $sql = "INSERT INTO registros (fecha, hora_entrada, asignacion_id, tipo_usuario) 
                        VALUES (:fecha, :hora, :asignacionId, :tipoUsuario)";
                $stmt = $this->db->prepare($sql); // Preparar la consulta
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR); // Vincular el parámetro fecha
                $stmt->bindParam(':hora', $hora, PDO::PARAM_STR); // Vincular el parámetro hora
                $stmt->bindParam(':asignacionId', $asignacionId, PDO::PARAM_INT); // Vincular el parámetro asignacionId
                $stmt->bindParam(':tipoUsuario', $tipo_usuario, PDO::PARAM_STR); // Vincular el parámetro tipoUsuario
                $stmt->execute(); // Ejecutar la consulta
            } catch (PDOException $e) {
                throw new Exception("Error al registrar entrada: " . $e->getMessage()); // Manejar excepciones
            }
        }
        
        // Método para registrar la salida de un usuario
        public function registrarSalida($asignacion_id, $fecha, $hora_salida) {
            // Consulta SQL para actualizar el registro de salida
            $sql = "UPDATE registros 
                    SET hora_salida = :hora_salida, estado = 'Finalizado' 
                    WHERE asignacion_id = :asignacion_id AND fecha = :fecha";
            $stmt = $this->db->prepare($sql); // Preparar la consulta
            $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT); // Vincular el parámetro asignacion_id
            $stmt->bindParam(':fecha', $fecha); // Vincular el parámetro fecha
            $stmt->bindParam(':hora_salida', $hora_salida); // Vincular el parámetro hora_salida
            return $stmt->execute(); // Ejecutar la consulta y retornar el resultado
        }

        // Método para obtener el ID de una asignación existente
        public function obtenerAsignacionId($usuarioId, $computadorId) {
            try {
                // Construir la consulta SQL dependiendo de si computadorId es NULL o no
                if ($computadorId === null) {
                    $sql = "SELECT id FROM asignaciones_computadores 
                            WHERE usuario_id = :usuarioId AND computador_id IS NULL";
                } else {
                    $sql = "SELECT id FROM asignaciones_computadores 
                            WHERE usuario_id = :usuarioId AND computador_id = :computadorId";
                }
        
                $stmt = $this->db->prepare($sql); // Preparar la consulta
                $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT); // Vincular el parámetro usuarioId
        
                // Solo vincular computadorId si no es NULL
                if ($computadorId !== null) {
                    $stmt->bindParam(':computadorId', $computadorId, PDO::PARAM_INT); // Vincular el parámetro computadorId
                }
        
                $stmt->execute(); // Ejecutar la consulta
        
                $asignacion = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado como un array asociativo
                return $asignacion ? $asignacion['id'] : null; // Retornar el ID de la asignación o null si no existe
            } catch (PDOException $e) {
                error_log("Error en obtenerAsignacionId: " . $e->getMessage()); // Registrar el error en el log
                return null; // Retornar null en caso de error
            }
        }
        
        // Método para obtener los últimos registros de acceso del día actual
        public function obtenerUltimosRegistros() {
            // Obtener la fecha actual en formato YYYY-MM-DD
            $fechaHoy = date('Y-m-d');
        
            // Consulta SQL para obtener los últimos 5 registros de acceso del día actual
            $sql = "SELECT 
                        ra.id,
                        ra.fecha,
                        ra.hora_entrada,
                        ra.hora_salida,
                        ra.estado,
                        u.nombre,
                        u.numero_identidad,
                        u.rol,
                        c.marca,
                        c.codigo,
                        c.tipo_computador AS tipo
                    FROM registros ra
                    JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    JOIN usuarios u ON ac.usuario_id = u.id
                    LEFT JOIN computadores c ON ac.computador_id = c.id -- Usar LEFT JOIN para incluir NULL
                    WHERE ra.fecha = :fechaHoy -- Filtra por la fecha de hoy
                    ORDER BY ra.id DESC
                    LIMIT 5";
        
            $stmt = $this->db->prepare($sql); // Preparar la consulta
            $stmt->bindParam(':fechaHoy', $fechaHoy); // Vincular el parámetro fechaHoy
            $stmt->execute(); // Ejecutar la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los registros como un array asociativo
        }

        public function obtenerUltimosRegistrosSalida() {
            // Obtener la fecha actual en formato YYYY-MM-DD
            $fechaHoy = date('Y-m-d');
        
            // Consulta SQL para obtener los últimos 5 registros de acceso del día actual con salida registrada
            $sql = "SELECT 
                        ra.id,
                        ra.fecha,
                        ra.hora_entrada,
                        ra.hora_salida,
                        ra.estado,
                        u.nombre,
                        u.numero_identidad,
                        u.rol,
                        c.marca,
                        c.codigo,
                        c.tipo_computador AS tipo
                    FROM registros ra
                    JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    JOIN usuarios u ON ac.usuario_id = u.id
                    LEFT JOIN computadores c ON ac.computador_id = c.id -- Usar LEFT JOIN para incluir NULL
                    WHERE ra.fecha = :fechaHoy -- Filtra por la fecha de hoy
                    AND ra.hora_salida IS NOT NULL -- Solo registros con salida registrada
                    ORDER BY ra.id DESC
                    LIMIT 5";
        
            $stmt = $this->db->prepare($sql); // Preparar la consulta
            $stmt->bindParam(':fechaHoy', $fechaHoy); // Vincular el parámetro fechaHoy
            $stmt->execute(); // Ejecutar la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar todos los registros como un array asociativo
        }
    }
?>