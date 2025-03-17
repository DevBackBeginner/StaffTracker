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

        public function obtenerPorIdentidad($numero_identidad) {
            $sql = "SELECT id, nombre, rol FROM usuarios WHERE numero_identidad = :codigo LIMIT 1"; // Verifica que 'codigo' sea la columna correcta
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $numero_identidad, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerUsuariosPorRol($rol, $limit, $offset) {
            // Definir las tablas y campos adicionales según el rol
            $tablas = [
                'Instructor' => ['tabla' => 'instructores', 'campos' => 'curso, ubicacion'],
                'Funcionario' => ['tabla' => 'funcionarios', 'campos' => 'area, puesto'],
                'Directivo' => ['tabla' => 'directivos', 'campos' => 'cargo, departamento'],
                'Apoyo' => ['tabla' => 'apoyo', 'campos' => 'area_trabajo'],
                'Visitante' => ['tabla' => 'visitantes', 'campos' => 'asunto']
            ];
        
            // Verificar si el rol existe
            if (!isset($tablas[$rol])) {
                return [];
            }
        
            // Obtener la tabla y campos adicionales para el rol
            $tablaRol = $tablas[$rol]['tabla'];
            $camposExtras = $tablas[$rol]['campos'];
        
            // Consulta SQL para obtener usuarios registrados en registro_acceso sin filtrar por fecha
            $sql = "SELECT 
                        u.nombre,
                        u.apellidos,
                        u.numero_identidad, 
                        u.telefono,
                        ra.fecha, 
                        ra.hora_entrada, 
                        ra.hora_salida, 
                        ra.estado,
                        tr.$camposExtras
                    FROM registro_acceso ra
                    INNER JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    INNER JOIN usuarios u ON ac.usuario_id = u.id
                    INNER JOIN $tablaRol tr ON u.id = tr.usuario_id -- Unión con la tabla específica del rol
                    WHERE u.rol = :rol -- Filtra por el rol especificado
                    ORDER BY ra.fecha DESC, ra.hora_entrada DESC
                    LIMIT :limit OFFSET :offset";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR); // Filtra por el rol
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarUsuariosPorRol($rol) {
            // Consulta SQL para contar usuarios de un rol específico sin filtrar por fecha
            $sql = "SELECT COUNT(*) as total 
                    FROM registro_acceso ra
                    INNER JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    INNER JOIN usuarios u ON ac.usuario_id = u.id
                    WHERE u.rol = :rol"; // Sin filtrar por fecha
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return (int)$resultado['total']; // Devuelve el total de registros
        }
        
        public function filtrarUsuarios($rol = '', $documento = '', $nombre = '')
        {
            // Definir variables para la tabla, alias y campos específicos del rol
            $tabla = '';
            $alias = '';
            $campos = '';
        
            // Determinar la tabla, alias y campos según el rol proporcionado
            switch ($rol) {
                case 'Instructor':
                    $tabla = 'instructores';
                    $alias = 'i';
                    $campos = 'i.curso, i.ubicacion';
                    break;
                case 'Funcionario':
                    $tabla = 'funcionarios';
                    $alias = 'f';
                    $campos = 'f.area, f.puesto';
                    break;
                case 'Directivo':
                    $tabla = 'directivos';
                    $alias = 'd';
                    $campos = 'd.cargo, d.departamento';
                    break;
                case 'Apoyo':
                    $tabla = 'apoyo';
                    $alias = 'a';
                    $campos = 'a.area_trabajo';
                    break;
                case 'Visitante':
                    $tabla = 'visitantes';
                    $alias = 'v';
                    $campos = 'v.asunto';
                    break;
                default:
                    $tabla = '';
                    $alias = '';
                    $campos = '';
                    break;
            }
        
            // Construir la consulta SQL según el rol
            if ($rol === '') {
                // Consulta para todos los roles sin filtro
                $sql = "SELECT u.nombre, u.apellidos, u.numero_identidad, u.telefono,
                               ra.fecha, ra.hora_entrada, ra.hora_salida
                        FROM usuarios u
                        INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                        INNER JOIN registro_acceso ra ON ac.id = ra.asignacion_id
                        WHERE DATE(ra.fecha) = CURDATE()";
        
                // Filtrar por documento
                if (!empty($documento)) {
                    $sql .= " AND u.numero_identidad LIKE :documento";
                }
        
                // Filtrar por nombre
                if (!empty($nombre)) {
                    $sql .= " AND u.nombre LIKE :nombre";
                }
            } else {
                // Consulta para un rol específico
                $sql = "SELECT u.nombre, u.apellidos, u.numero_identidad, u.telefono,
                                ra.fecha, ra.hora_entrada, ra.hora_salida";
        
                // Agregar los campos del rol si existen
                if (!empty($campos)) {
                    $sql .= ", $campos";
                }
        
                $sql .= " FROM usuarios u
                        INNER JOIN $tabla $alias ON u.id = $alias.usuario_id
                        INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                        INNER JOIN registro_acceso ra ON ac.id = ra.asignacion_id
                        WHERE DATE(ra.fecha) = CURDATE()";
        
                // Filtrar por documento
                if (!empty($documento)) {
                    $sql .= " AND u.numero_identidad LIKE :documento";
                }
        
                // Filtrar por nombre
                if (!empty($nombre)) {
                    $sql .= " AND u.nombre LIKE :nombre";
                }
            }
        
            // Preparar y ejecutar la consulta
            $stmt = $this->db->prepare($sql);
        
            // Bind de parámetros
            if (!empty($documento)) {
                $stmt->bindValue(':documento', "%$documento%", PDO::PARAM_STR);
            }
            if (!empty($nombre)) {
                $stmt->bindValue(':nombre', "%$nombre%", PDO::PARAM_STR);
            }
        
            $stmt->execute();
        
            // Retornar los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarUsuariosFiltrados($rol, $documento) {
            $sql = "SELECT COUNT(*) AS total FROM usuarios 
                    WHERE (:rol = '' OR rol = :rol) 
                    AND (:documento = '' OR numero_identidad LIKE :documento)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindValue(':documento', "%$documento%", PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        }
    }

?>
