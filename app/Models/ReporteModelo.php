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
            $sql = "SELECT 
                        p.id_persona,
                        p.nombre,
                        p.apellido,
                        p.telefono,
                        p.tipo_documento,
                        p.numero_documento,
                        p.rol,
                        ris.fecha,
                        ris.hora_ingreso,
                        ris.hora_salida,
                        IFNULL(c.modelo, cs.modelo) AS modelo_computador,
                        IFNULL(c.codigo, cs.codigo) AS codigo_computador,
                        ve.tipo_equipo
                    FROM personas p
                    INNER JOIN registro_ingreso_salida ris ON p.id_persona = ris.id_persona
                    LEFT JOIN validacion_equipos ve ON ris.id_validacion_equipo = ve.id
                    LEFT JOIN computadores c ON (ve.id_equipo = c.id_computador AND ve.tipo_equipo = 'computador_personal')
                    LEFT JOIN computadores_sena cs ON (ve.id_equipo = cs.id_computador_sena AND ve.tipo_equipo = 'computador_sena')
                    WHERE ris.hora_ingreso IS NOT NULL
                    ORDER BY ris.fecha DESC, ris.hora_ingreso DESC";
        
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function registroHoy() {
            $fechaActual = date('Y-m-d');
            
            $sql = "SELECT 
                        p.id_persona,
                        p.nombre,
                        p.apellido,
                        p.telefono,
                        p.tipo_documento,
                        p.numero_documento,
                        p.rol,
                        ris.fecha,
                        ris.hora_ingreso,
                        ris.hora_salida,
                        IFNULL(c.modelo, cs.modelo) AS modelo_computador
                    FROM personas p
                    LEFT JOIN registro_ingreso_salida ris ON p.id_persona = ris.id_persona
                    LEFT JOIN validacion_equipos ve ON ris.id_validacion_equipo = ve.id
                    LEFT JOIN computadores c ON (ve.id_equipo = c.id_computador AND ve.tipo_equipo = 'computador_personal')
                    LEFT JOIN computadores_sena cs ON (ve.id_equipo = cs.id_computador_sena AND ve.tipo_equipo = 'computador_sena')
                    WHERE ris.fecha = :fechaActual
                    ORDER BY ris.hora_ingreso DESC";
        
            $query = $this->db->prepare($sql);
            $query->bindParam(':fechaActual', $fechaActual, PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function registroMensual() {
            $mesActual = date('Y-m');
            
            $sql = "SELECT 
                        p.id_persona,
                        p.nombre,
                        p.apellido,
                        p.numero_documento,
                        p.telefono,
                        p.rol,
                        ris.fecha,
                        ris.hora_ingreso,
                        ris.hora_salida,
                        ve.tipo_equipo
                    FROM personas p
                    JOIN registro_ingreso_salida ris ON p.id_persona = ris.id_persona
                    LEFT JOIN validacion_equipos ve ON ris.id_validacion_equipo = ve.id
                    WHERE DATE_FORMAT(ris.fecha, '%Y-%m') = :mesActual
                    ORDER BY ris.fecha DESC";
        
            $query = $this->db->prepare($sql);
            $query->bindParam(':mesActual', $mesActual, PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function obtenerIngresosPorHora() {
            try {
                $query = "SELECT 
                            HOUR(ris.hora_ingreso) AS hora,
                            MINUTE(ris.hora_ingreso) AS minuto,
                            p.rol,
                            COUNT(*) AS total_ingresos
                        FROM 
                            registro_ingreso_salida ris
                        JOIN 
                            personas p ON ris.id_persona = p.id_persona
                        WHERE 
                            ris.fecha = CURDATE()
                            AND HOUR(ris.hora_ingreso) BETWEEN 6 AND 23
                        GROUP BY 
                            HOUR(ris.hora_ingreso), MINUTE(ris.hora_ingreso), p.rol
                        ORDER BY 
                            hora, minuto, p.rol";
        
                $stmt = $this->db->query($query);
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($resultados as $registro) {
                    if (!isset($registro['hora']) || !isset($registro['minuto']) || !isset($registro['rol'])) {
                        throw new Exception("Los datos no están en el formato esperado.");
                    }
                }
                
                return $resultados;
            } catch (Exception $e) {
                error_log("Error en obtenerIngresosPorHora: " . $e->getMessage());
                return ["error" => "Hubo un problema al obtener los datos."];
            }
        }
        
        public function obtenerTotalUsuarios() {
            $query = "SELECT COUNT(*) AS total FROM personas";
            $stmt = $this->db->query($query);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        }
    }
?>