<?php 

    // Incluir el archivo de configuración de la base de datos
    require_once '../config/DataBase.php';

    // Definir la clase RegistroIngresoModelo
    class RegistroModelo {
        private $db; // Variable para almacenar la conexión a la base de datos

        // Constructor de la clase
        public function __construct() {
            $conn = new DataBase(); // Crear una instancia de la clase DataBase
            $this->db = $conn->getConnection(); // Obtener la conexión a la base de datos
            date_default_timezone_set('America/Bogota'); // Establecer la zona horaria
        }

        public function obtenerUsuarioPorDocumento($codigo) {
            $stmt = $this->db->prepare("
                SELECT id_persona, nombre, apellido, tipo_documento, numero_documento, telefono, rol 
                FROM personas 
                WHERE numero_documento = :codigo
                LIMIT 1
            ");
            $stmt->execute([':codigo' => $codigo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function obtenerIdValidacionEquipo($id_equipo, $tipo_equipo) {
            $stmt = $this->db->prepare("
                SELECT id FROM validacion_equipos 
                WHERE id_equipo = :id_equipo 
                AND tipo_equipo = :tipo_equipo
                LIMIT 1
            ");
            $stmt->execute([
                ':id_equipo' => $id_equipo,
                ':tipo_equipo' => $tipo_equipo
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : null;
        }
        
        public function verificarAsignacionComputador($computador_id, $tipo_computador, $usuario_id) {
            if ($tipo_computador === 'computador_personal') {
                $tabla = 'computadores';
                $campo_id = 'id_computador';
            } else {
                $tabla = 'computadores_sena';
                $campo_id = 'id_computador_sena';
            }
            
            $stmt = $this->db->prepare("
                SELECT 1 FROM {$tabla} 
                WHERE {$campo_id} = ? AND asignado_a = ?
                LIMIT 1
            ");
            
            $stmt->execute([$computador_id, $usuario_id]);
            return (bool)$stmt->fetch();
        }
    
        /**
         * Obtiene registro del día para una persona
         */
        public function obtenerRegistroDelDia($persona_id, $fecha) {
            $stmt = $this->db->prepare("
                SELECT id_registro, hora_ingreso, hora_salida, id_validacion_equipo 
                FROM registro_ingreso_salida 
                WHERE id_persona = :persona_id AND fecha = :fecha
                ORDER BY id_registro DESC
                LIMIT 1
            ");
            $stmt->execute([
                ':persona_id' => $persona_id,
                ':fecha' => $fecha
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        /**
         * Registra nuevo movimiento de entrada
         */
        public function registrarNuevaEntrada($persona_id, $validacion_equipo_id = null) {
            $stmt = $this->db->prepare("
                INSERT INTO registro_ingreso_salida 
                (id_persona, id_validacion_equipo, fecha, hora_ingreso) 
                VALUES (:persona_id, :validacion_id, :fecha, :hora_ingreso)
            ");
            
            return $stmt->execute([
                ':persona_id' => $persona_id,
                ':validacion_id' => $validacion_equipo_id,
                ':fecha' => date('Y-m-d'),
                ':hora_ingreso' => date('H:i:s')
            ]);
        }

        public function obtenerRegistroActivo($persona_id, $id_validacion = null, $fecha = null) {
            $fecha = date('Y-m-d');
            
            $query = "
                SELECT * FROM registro_ingreso_salida
                WHERE id_persona = :persona_id
                AND fecha = :fecha
                AND hora_ingreso IS NOT NULL
                AND hora_salida IS NULL
            ";
            
            if ($id_validacion !== null) {
                $query .= " AND id_validacion_equipo = :id_validacion";
            }
            
            $query .= " ORDER BY hora_ingreso DESC LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $params = [
                ':persona_id' => $persona_id,
                ':fecha' => $fecha
            ];
            
            if ($id_validacion !== null) {
                $params[':id_validacion'] = $id_validacion;
            }
            
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerRegistroActivoUsuario($id_persona, $fecha) {
            $stmt = $this->db->prepare("
                SELECT id_registro, hora_ingreso, hora_salida, id_validacion_equipo
                FROM registro_ingreso_salida
                WHERE id_persona = ?
                AND DATE(fecha) = DATE(?)
                AND (hora_salida IS NULL OR hora_salida = '')
                ORDER BY hora_ingreso DESC
                LIMIT 1
            ");
            $stmt->execute([$id_persona, $fecha]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function obtenerDescripcionEquipo($id_validacion) {
            $stmt = $this->db->prepare("
                SELECT 
                    ve.id_equipo,
                    ve.tipo_equipo,
                    CASE ve.tipo_equipo
                        WHEN 'computador_personal' THEN 
                            (SELECT CONCAT('PC Personal: ', modelo, ' (', codigo, ')') 
                            FROM computadores WHERE id_computador = ve.id_equipo)
                        WHEN 'computador_sena' THEN 
                            (SELECT CONCAT('PC SENA: ', modelo, ' (', codigo, ')') 
                            FROM computadores_sena WHERE id_computador_sena = ve.id_equipo)
                    END AS descripcion
                FROM validacion_equipos ve
                WHERE ve.id = ?
                LIMIT 1
            ");
            $stmt->execute([$id_validacion]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['descripcion'] : 'Equipo no encontrado';
        }

        // Método para registrar la salida de un usuario
        public function registrarSalida($registro_id, $hora_salida) {
            $stmt = $this->db->prepare("
                UPDATE registro_ingreso_salida 
                SET 
                    hora_salida = :hora_salida,
                    estado_presencia = 'Fuera de la sede'
                WHERE id_registro = :registro_id
                AND hora_salida IS NULL  -- Solo si no tiene salida registrada
            ");
            
            $stmt->bindParam(':hora_salida', $hora_salida, PDO::PARAM_STR);
            $stmt->bindParam(':registro_id', $registro_id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        
        // Método para obtener los últimos registros de acceso del día actual
        public function obtenerUltimosRegistros() {
            try {
                $fechaHoy = date('Y-m-d');
                
                $sql = "SELECT 
                            ris.id_registro,
                            ris.fecha,
                            ris.hora_ingreso AS hora_entrada,
                            ris.hora_salida,
                            ris.estado_presencia,
                            p.id_persona,
                            p.nombre,
                            p.apellido,
                            p.tipo_documento,
                            p.numero_documento AS numero_identidad,
                            p.rol,
                            ve.id AS id_validacion,
                            ve.tipo_equipo AS tipo,
                            CASE 
                                WHEN ve.tipo_equipo = 'computador_personal' THEN cp.modelo
                                WHEN ve.tipo_equipo = 'computador_sena' THEN cs.modelo
                                ELSE NULL
                            END AS marca,
                            CASE 
                                WHEN ve.tipo_equipo = 'computador_personal' THEN cp.codigo
                                WHEN ve.tipo_equipo = 'computador_sena' THEN cs.codigo
                                ELSE NULL
                            END AS codigo
                        FROM 
                            registro_ingreso_salida ris
                        JOIN 
                            personas p ON ris.id_persona = p.id_persona
                        LEFT JOIN 
                            validacion_equipos ve ON ris.id_validacion_equipo = ve.id
                        LEFT JOIN 
                            computadores cp ON ve.id_equipo = cp.id_computador AND ve.tipo_equipo = 'computador_personal'
                        LEFT JOIN 
                            computadores_sena cs ON ve.id_equipo = cs.id_computador_sena AND ve.tipo_equipo = 'computador_sena'
                        WHERE 
                            ris.fecha = :fechaHoy
                        ORDER BY 
                            ris.id_registro DESC
                        LIMIT 5";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':fechaHoy', $fechaHoy, PDO::PARAM_STR);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                error_log("Error en obtenerUltimosRegistros: " . $e->getMessage());
                throw new Exception("Error al obtener los últimos registros");
            }
        }

        public function obtenerUltimosRegistrosSalida() {
            // Obtener la fecha actual
            $fechaHoy = date('Y-m-d');
            
            // Consulta SQL adaptada a tu estructura de tablas
            $sql = "SELECT 
                        ris.id_registro AS id,
                        ris.fecha,
                        ris.hora_ingreso AS hora_entrada,
                        ris.hora_salida,
                        CASE 
                            WHEN cs.estado IS NOT NULL THEN cs.estado
                            ELSE 'N/A'
                        END AS estado,
                        p.nombre,
                        p.numero_documento AS numero_identidad,
                        p.rol,
                        COALESCE(c.modelo, cs.modelo) AS marca,
                        COALESCE(c.codigo, cs.codigo) AS codigo,
                        CASE 
                            WHEN ve.tipo_equipo = 'computador_personal' THEN 'Personal'
                            WHEN ve.tipo_equipo = 'computador_sena' THEN 'SENA'
                            ELSE 'N/A'
                        END AS tipo
                    FROM registro_ingreso_salida ris
                    JOIN personas p ON ris.id_persona = p.id_persona
                    LEFT JOIN validacion_equipos ve ON ris.id_validacion_equipo = ve.id
                    LEFT JOIN computadores c ON (ve.id_equipo = c.id_computador AND ve.tipo_equipo = 'computador_personal')
                    LEFT JOIN computadores_sena cs ON (ve.id_equipo = cs.id_computador_sena AND ve.tipo_equipo = 'computador_sena')
                    WHERE ris.fecha = :fechaHoy
                    AND ris.hora_salida IS NOT NULL
                    ORDER BY ris.hora_salida DESC
                    LIMIT 5";
            
            try {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':fechaHoy', $fechaHoy, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error en obtenerUltimosRegistrosSalida: " . $e->getMessage());
                return [];
            }
        }
    }
?>