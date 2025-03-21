<?php
require_once '../config/DataBase.php';

class ReporteModelo {
    private $db;

    public function __construct() {
        // Crear una instancia de la clase DataBase para obtener la conexión
        $conn = new DataBase();
        // Asignar la conexión establecida a la propiedad $db
        $this->db = $conn->getConnection();
    }

    public function listadoHistorial() {
        // Construir la consulta SQL
        $sql = "SELECT  u.id, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol, 
                        i.curso, i.ubicacion, 
                        f.area, f.puesto, 
                        d.cargo, d.departamento, 
                        a.area_trabajo, 
                        v.asunto,
                        r.fecha, r.hora_entrada, r.hora_salida
                FROM usuarios u
                LEFT JOIN instructores i ON u.id = i.usuario_id AND u.rol = 'Instructor'
                LEFT JOIN funcionarios f ON u.id = f.usuario_id AND u.rol = 'Funcionario'
                LEFT JOIN directivos d ON u.id = d.usuario_id AND u.rol = 'Directivo'
                LEFT JOIN apoyo a ON u.id = a.usuario_id AND u.rol = 'Apoyo'
                LEFT JOIN visitantes v ON u.id = v.usuario_id AND u.rol = 'Visitante'
                INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                INNER JOIN registros r ON ac.id = r.asignacion_id
                WHERE 1=1";
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare($sql);
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