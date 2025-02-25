<?php 

require_once '../config/DataBase.php';

class RegistroModelo {
    private $db;

    public function __construct() {
        $conn = new DataBase();
        $this->db = $conn->getConnection();
        date_default_timezone_set('America/Bogota');

    }

    public function obtenerAsistenciaDelDia($aprendiz_id, $fecha) {
        $sql = 'SELECT * FROM asistencias WHERE aprendiz_id = :aprendiz_id AND fecha = :fecha';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':aprendiz_id', $aprendiz_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarEntrada($aprendiz_id, $hora_entrada) {
        $fecha = date('Y-m-d', strtotime($hora_entrada));
        $asistencia = $this->obtenerAsistenciaDelDia($aprendiz_id, $fecha);

        if ($asistencia) {
            // Ya existe un registro de asistencia para este día
            if (is_null($asistencia['hora_entrada'])) {
                // Actualizar la hora de entrada si está vacía
                $sql = 'UPDATE asistencias SET hora_entrada = :hora_entrada WHERE id = :id';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':hora_entrada', $hora_entrada, PDO::PARAM_STR);
                $stmt->bindParam(':id', $asistencia['id'], PDO::PARAM_INT);
                return $stmt->execute();
            } else {
                // La hora de entrada ya está registrada
                return false;
            }
        } else {
            // No existe un registro de asistencia para este día, crear uno nuevo
            $sql = 'INSERT INTO asistencias (aprendiz_id, fecha, hora_entrada) VALUES (:aprendiz_id, :fecha, :hora_entrada)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':aprendiz_id', $aprendiz_id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':hora_entrada', $hora_entrada, PDO::PARAM_STR);
            return $stmt->execute();
        }
    }

    public function registrarSalida($aprendiz_id, $hora_salida) {
        $fecha = date('Y-m-d', strtotime($hora_salida));
        $asistencia = $this->obtenerAsistenciaDelDia($aprendiz_id, $fecha);

        if ($asistencia) {
            if (empty($asistencia['hora_salida'])) {
                // Actualizar la hora de salida si está vacía
                $sql = 'UPDATE asistencias SET hora_salida = :hora_salida WHERE id = :id';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':hora_salida', $hora_salida, PDO::PARAM_STR);
                $stmt->bindParam(':id', $asistencia['id'], PDO::PARAM_INT);
                return $stmt->execute();
            } else {
                // La hora de salida ya está registrada
                return false;
            }
        } else {
            // No existe un registro de asistencia para este día
            return false;
        }
    }

    // Registrar un nuevo computador
    public function registroComputador($aprendizId, $marca, $codigo) {
        if (empty($aprendizId) || empty($marca) || empty($codigo)) {
            error_log("Datos incompletos: aprendiz_id, marca o codigo están vacíos");
            return false;
        }
    
        try {
            $query = $this->db->prepare("INSERT INTO computadores (aprendiz_id, marca, codigo) VALUES (?, ?, ?)");
            $query->execute([$aprendizId, $marca, $codigo]);
            return true;
        } catch (Exception $e) {
            error_log("Error al registrar computador: " . $e->getMessage());
            return false;
        }
    }
    

}
?>
