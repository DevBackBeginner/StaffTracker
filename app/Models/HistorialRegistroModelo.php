<?php
    // Incluir la configuración de la base de datos
    require_once '../config/DataBase.php';

    /**
     * Modelo de Aprendiz para interactuar con la base de datos.
     */
    class HistorialRegistroModelo {
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

            date_default_timezone_set('America/Bogota');

        }

        public function obtenerPorIdentidad($numero_documento) {
            $sql = "SELECT id_persona, nombre, rol FROM personas WHERE numero_documento = :codigo LIMIT 1"; // Verifica que 'codigo' sea la columna correcta
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $numero_documento, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerUsuariosPorRol($rol, $limit, $offset) {
            try {
                // Verificar que el rol sea válido según tu ENUM
                $rolesPermitidos = ['Administrador', 'Guarda', 'Instructor', 'Visitante', 'Funcionario', 'Directivo'];
                if (!in_array($rol, $rolesPermitidos)) {
                    throw new Exception("Rol no válido");
                }
        
                // Consulta SQL actualizada
                $sql = "SELECT 
                            p.id_persona,
                            p.nombre,
                            p.apellido,
                            p.numero_documento, 
                            p.telefono,
                            p.rol,
                            ri.fecha, 
                            ri.hora_ingreso as hora_entrada, 
                            ri.hora_salida, 
                            ve.tipo_equipo as tipo_computador,
                            il.cargo,
                            il.tipo_contrato
                        FROM registro_ingreso_salida ri
                        LEFT JOIN validacion_equipos ve ON ri.id_validacion_equipo = ve.id
                        INNER JOIN personas p ON ri.id_persona = p.id_persona
                        LEFT JOIN informacion_laboral il ON p.id_persona = il.persona_id
                        WHERE p.rol = :rol
                        ORDER BY ri.fecha DESC, ri.hora_ingreso DESC
                        LIMIT :limit OFFSET :offset";
        
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
                $stmt->execute();
        
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            } catch (Exception $e) {
                error_log("Error en obtenerUsuariosPorRol: " . $e->getMessage());
                return [];
            }
        }

        public function contarUsuariosPorRol($rol) {
            try {
                // Validar rol según tu ENUM
                $rolesPermitidos = ['Administrador', 'Guarda', 'Instructor', 'Visitante', 'Funcionario', 'Directivo'];
                if (!in_array($rol, $rolesPermitidos)) {
                    return 0;
                }
        
                $sql = "SELECT COUNT(DISTINCT p.id_persona) as total 
                        FROM personas p
                        INNER JOIN registro_ingreso_salida ris ON p.id_persona = ris.id_persona
                        WHERE p.rol = :rol";
        
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
                $stmt->execute();
                
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return (int)$resultado['total'];
        
            } catch (PDOException $e) {
                error_log("Error en contarUsuariosPorRol: " . $e->getMessage());
                return 0;
            }
        }
        
        public function filtrarUsuarios($rol = '', $documento = '', $nombre = '') {
            try {
                $sql = "SELECT 
                            p.id_persona,
                            p.nombre,
                            p.apellido,
                            p.numero_documento,
                            p.telefono,
                            p.rol,
                            ri.fecha,
                            ri.hora_ingreso as hora_entrada,
                            ri.hora_salida,
                            ve.tipo_equipo as tipo_computador,
                            il.cargo,
                            il.tipo_contrato
                        FROM personas p
                        INNER JOIN registro_ingreso_salida ri ON p.id_persona = ri.id_persona
                        LEFT JOIN validacion_equipos ve ON ri.id_validacion_equipo = ve.id
                        LEFT JOIN informacion_laboral il ON p.id_persona = il.persona_id
                        WHERE 1=1";
        
                // Filtros
                $params = [];
                if (!empty($rol)) {
                    $sql .= " AND p.rol = :rol";
                    $params[':rol'] = $rol;
                }
                if (!empty($documento)) {
                    $sql .= " AND p.numero_documento LIKE :documento";
                    $params[':documento'] = "%$documento%";
                }
                if (!empty($nombre)) {
                    $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
                    $params[':nombre'] = "%$nombre%";
                }
        
                $sql .= " ORDER BY ri.fecha DESC, ri.hora_ingreso DESC";
        
                $stmt = $this->db->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
        
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            } catch (PDOException $e) {
                error_log("Error en filtrarUsuarios: " . $e->getMessage());
                return [];
            }
        }

        public function contarUsuariosFiltrados($rol = '', $documento = '', $nombre = '') {
            try {
                $sql = "SELECT COUNT(DISTINCT p.id_persona) AS total
                        FROM personas p
                        LEFT JOIN registro_ingreso_salida ri ON p.id_persona = ri.id_persona
                        WHERE 1=1";

                $params = [];
                if (!empty($rol)) {
                    $sql .= " AND p.rol = :rol";
                    $params[':rol'] = $rol;
                }
                if (!empty($documento)) {
                    $sql .= " AND p.numero_documento LIKE :documento";
                    $params[':documento'] = "%$documento%";
                }
                if (!empty($nombre)) {
                    $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
                    $params[':nombre'] = "%$nombre%";
                }

                $stmt = $this->db->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }

                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return (int)$resultado['total'];

            } catch (PDOException $e) {
                error_log("Error en contarUsuariosFiltrados: " . $e->getMessage());
                return 0;
            }
        }
    }

?>
