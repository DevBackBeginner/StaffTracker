<?php
require_once '../config/DataBase.php';

class ReporteModelo {
    private $db;

    public function __construct() {
        // Crear una instancia de la clase DataBase para obtener la conexión
        $conn = new DataBase();
        // Asignar la conexión establecida a la propiedad $db
        $this->db = $conn->getConnection();

        date_default_timezone_set('America/Bogota'); // Cambia por tu zona horaria

    }

    public function registroGeneral() {
        // Construir la consulta SQL
        $sql = "SELECT u.id, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol, 
                    r.fecha, r.hora_entrada, r.hora_salida
                FROM usuarios u
                INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                INNER JOIN registros r ON ac.id = r.asignacion_id";
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // Retornar los resultados como un array asociativo
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registroHoy() {
        // Obtener la fecha actual en formato YYYY-MM-DD
        $fechaActual = date('Y-m-d');
    
        // Construir la consulta SQL
        $sql = "SELECT u.id, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol, 
                    r.fecha, r.hora_entrada, r.hora_salida
                FROM usuarios u
                INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                INNER JOIN registros r ON ac.id = r.asignacion_id
                WHERE r.fecha = :fechaActual"; // Filtrar por la fecha actual
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->bindParam(':fechaActual', $fechaActual, PDO::PARAM_STR);
        $query->execute();
    
        // Retornar los resultados como un array asociativo
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registroMensual() {
        // Obtener el mes y el año actual en formato YYYY-MM
        $mesActual = date('Y-m');
    
        // Construir la consulta SQL
        $sql = "SELECT u.id, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol, 
                    r.fecha, r.hora_entrada, r.hora_salida
                FROM usuarios u
                INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                INNER JOIN registros r ON ac.id = r.asignacion_id
                WHERE DATE_FORMAT(r.fecha, '%Y-%m') = :mesActual"; // Filtrar por el mes actual
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->bindParam(':mesActual', $mesActual, PDO::PARAM_STR);
        $query->execute();
    
        // Retornar los resultados como un array asociativo
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Obtiene los ingresos por hora, separados por rol.
     * Incluye la hora, los minutos y el rol.
     */
    public function obtenerIngresosPorHora() {
        try {
            $query = "
                SELECT 
                    HOUR(r.hora_entrada) AS hora, 
                    MINUTE(r.hora_entrada) AS minuto, 
                    u.rol, 
                    COUNT(*) AS total_ingresos
                FROM 
                    registros r
                INNER JOIN 
                    asignaciones_computadores ac ON r.asignacion_id = ac.id
                INNER JOIN 
                    usuarios u ON ac.usuario_id = u.id
                WHERE 
                    r.fecha = CURDATE() -- Filtra por el día actual
                    AND HOUR(r.hora_entrada) BETWEEN 6 AND 23 -- De 6:00 AM a 11:59 PM
                GROUP BY 
                    HOUR(r.hora_entrada), MINUTE(r.hora_entrada), u.rol
                ORDER BY 
                    hora, minuto, u.rol;
            ";
            $stmt = $this->db->query($query);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Validar el formato de los datos
            foreach ($resultados as $registro) {
                if (!isset($registro['hora']) || !isset($registro['minuto']) || !isset($registro['rol']) || !isset($registro['total_ingresos'])) {
                    throw new Exception("Los datos no están en el formato esperado.");
                }
            }
            
            return $resultados;
        } catch (Exception $e) {
            // Registrar el error (opcional)
            error_log("Error en obtenerIngresosPorHora: " . $e->getMessage());
            
            // Retornar un mensaje de error
            return ["error" => "Hubo un problema al obtener los datos."];
        }
    }

    public function obtenerTotalUsuarios() {
        $query = "SELECT COUNT(*) AS total FROM usuarios";
        $stmt = $this->db->query($query);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }
}
?>