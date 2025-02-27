<?php 

require_once '../config/DataBase.php';

class RegistroModelo {
    private $db;

    public function __construct() {
        $conn = new DataBase();
        $this->db = $conn->getConnection();
        date_default_timezone_set('America/Bogota');

    }
    // Obtener asistencia del día por usuario
    public function obtenerAsistenciaDelDia($asignacion_id, $fecha) {
        $sql = "SELECT * FROM registro_asistencia WHERE asignacion_id  = :asignacion_id AND fecha = :fecha LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarEntrada($asignacion_id, $fecha, $hora_entrada) {
        $sql = "INSERT INTO registro_asistencia (asignacion_id, fecha, hora_entrada, estado) 
                VALUES (:asignacion_id, :fecha, :hora_entrada, 'Activo')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora_entrada', $hora_entrada);
        return $stmt->execute();
    }
    

    // Registrar salida
    public function registrarSalida($asignacion_id, $fecha, $hora_salida) {
        $sql = "UPDATE registro_asistencia 
                SET hora_salida = :hora_salida, estado = 'Finalizado' 
                WHERE asignacion_id = :asignacion_id AND fecha = :fecha";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':asignacion_id', $asignacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora_salida', $hora_salida);
        return $stmt->execute();
    }
    
    
    public function verificarComputadorAsignado($usuario_id) {
        $sql = "SELECT id FROM asignaciones_computadores WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna false si no tiene computador
    }

    public function obtenerUltimoRegistro() {
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
            FROM registro_asistencia ra
            JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
            JOIN usuarios u ON ac.usuario_id = u.id
            JOIN computadores c ON ac.computador_id = c.id
            ORDER BY ra.id DESC
            LIMIT 1";

        $stmt =$this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
