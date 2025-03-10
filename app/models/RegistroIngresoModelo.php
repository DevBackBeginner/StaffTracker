<?php 

require_once '../config/DataBase.php';

class RegistroIngresoModelo {
    private $db;

    public function __construct() {
        $conn = new DataBase();
        $this->db = $conn->getConnection();
        date_default_timezone_set('America/Bogota');

    }
    // Obtener asistencia del día por usuario
    public function obtenerAsistenciaDelDia($asignacion_id, $fecha) {
        $sql = "SELECT * FROM registro_acceso WHERE asignacion_id  = :asignacion_id AND fecha = :fecha LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarEntrada($fecha, $hora, $asignacionId) {
        try {
            $sql = "INSERT INTO registro_acceso ( fecha, hora_entrada, asignacion_id) 
                    VALUES ( :fecha, :hora, :asignacionId)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
            $stmt->bindParam(':asignacionId', $asignacionId, PDO::PARAM_INT); // Acepta NULL
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al registrar entrada: " . $e->getMessage());
        }
    }
    

    // Registrar salida
    public function registrarSalida($asignacion_id, $fecha, $hora_salida) {
        $sql = "UPDATE registro_acceso 
                SET hora_salida = :hora_salida, estado = 'Finalizado' 
                WHERE asignacion_id = :asignacion_id AND fecha = :fecha";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora_salida', $hora_salida);
        return $stmt->execute();
    }

    public function obtenerAsignacionId($usuarioId, $computadorId) {
        try {
            $sql = "SELECT id FROM asignaciones_computadores 
                    WHERE usuario_id = :usuarioId AND computador_id = :computadorId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->bindParam(':computadorId', $computadorId, PDO::PARAM_INT);
            $stmt->execute();
    
            $asignacion = $stmt->fetch(PDO::FETCH_ASSOC);
            return $asignacion ? $asignacion['id'] : null;
        } catch (PDOException $e) {
            error_log("Error en obtenerAsignacionId: " . $e->getMessage());
            return null;
        }
    }
    
    
    public function obtenerUltimosRegistros() {
        // Obtener la fecha actual en formato YYYY-MM-DD
        $fechaHoy = date('Y-m-d');
    
        $sql = "SELECT 
                    ra.id,
                    ra.fecha,
                    ra.hora_entrada,
                    ra.hora_salida,
                    ra.estado,
                    u.nombre,
                    u.numero_identidad,
                    c.marca,
                    c.codigo,
                    c.tipo_computador AS tipo
                FROM registro_acceso ra
                JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                JOIN usuarios u ON ac.usuario_id = u.id
                JOIN computadores c ON ac.computador_id = c.id
                WHERE ra.fecha = :fechaHoy -- Filtra por la fecha de hoy
                ORDER BY ra.id DESC
                LIMIT 5";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fechaHoy', $fechaHoy); // Asignar el valor de la fecha actual
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los registros de hoy
    }   
}
?>
