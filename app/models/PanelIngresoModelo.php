<?php
    // Incluir la configuración de la base de datos
    require_once '../config/DataBase.php';

    /**
     * Modelo de Aprendiz para interactuar con la base de datos.
     */
    class PanelIngresoModelo {
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
        }

        public function obtenerPorIdentidad($numero_identidad) {
            $sql = "SELECT * FROM usuarios WHERE numero_identidad = :codigo LIMIT 1"; // Verifica que 'codigo' sea la columna correcta
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $numero_identidad, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerUsuariosPorRol($rol, $limit, $offset) {
            $tablas = [
                'Instructor' => ['tabla' => 'instructores', 'campos' => 'curso, ubicacion'],
                'Funcionario' => ['tabla' => 'funcionarios', 'campos' => 'area, puesto'],
                'Directivo' => ['tabla' => 'directivos', 'campos' => 'cargo, departamento'],
                'Apoyo' => ['tabla' => 'apoyo', 'campos' => 'area_trabajo'],
                'Visitante' => ['tabla' => 'visitantes', 'campos' => 'asunto'] // Agregar Visitante
            ];
        
            if (!isset($tablas[$rol])) {
                return [];
            }
        
            $tabla = $tablas[$rol]['tabla'];
            $camposExtras = $tablas[$rol]['campos'];
        
            // Modificar la consulta SQL para incluir un INNER JOIN con registro_acceso
            $sql = "SELECT u.nombre, u.numero_identidad, t.$camposExtras
                    FROM $tabla t
                    INNER JOIN usuarios u ON t.usuario_id = u.id
                    INNER JOIN registro_acceso ra ON u.id = ra.asignacion_id
                    LIMIT :limit OFFSET :offset";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function contarUsuariosPorRol($rol) {
            $tablas = [
                'Instructor' => 'instructores',
                'Funcionario' => 'funcionarios',
                'Directivo' => 'directivos',
                'Apoyo' => 'apoyo',
                'Visitante' => 'visitantes'
            ];
        
            if (!isset($tablas[$rol])) {
                return 0;
            }
        
            $tabla = $tablas[$rol];
        
            // Modificar la consulta SQL para incluir un INNER JOIN con registro_acceso
            $sql = "SELECT COUNT(*)
                    FROM $tabla t
                    INNER JOIN usuarios u ON t.usuario_id = u.id
                    INNER JOIN registro_acceso ra ON u.id = ra.asignacion_id";
        
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        
            return $stmt->fetchColumn();
        }

        public function filtrarUsuarios($rol = '', $documento = '')
        {
            // Definir variables para la tabla, alias y campos específicos del rol
            $tabla = '';       // Nombre de la tabla asociada al rol
            $alias = '';       // Alias de la tabla para usar en la consulta SQL
            $campos = '';      // Campos específicos del rol que se seleccionarán

            // Determinar la tabla, alias y campos según el rol proporcionado
            switch ($rol) {
                case 'Instructor':
                    $tabla = 'instructores';  // Tabla de instructores
                    $alias = 'i';             // Alias para la tabla de instructores
                    $campos = 'i.curso, i.ubicacion';  // Campos específicos de instructores
                    break;
                case 'Funcionario':
                    $tabla = 'funcionarios';  // Tabla de funcionarios
                    $alias = 'f';             // Alias para la tabla de funcionarios
                    $campos = 'f.area, f.puesto';  // Campos específicos de funcionarios
                    break;
                case 'Directivo':
                    $tabla = 'directivos';    // Tabla de directivos
                    $alias = 'd';             // Alias para la tabla de directivos
                    $campos = 'd.cargo, d.departamento';  // Campos específicos de directivos
                    break;
                case 'Apoyo':
                    $tabla = 'apoyo';         // Tabla de apoyo
                    $alias = 'a';             // Alias para la tabla de apoyo
                    $campos = 'a.area_trabajo';  // Campos específicos de apoyo
                    break;
                case 'Visitante':
                    $tabla = 'visitantes';    // Tabla de visitantes
                    $alias = 'v';             // Alias para la tabla de visitantes
                    $campos = 'v.asunto';     // Campos específicos de visitantes
                    break;
                default:
                    // Si no se especifica un rol, se buscan todos los usuarios
                    $tabla = 'usuarios';      // Tabla de usuarios
                    $alias = 'u';             // Alias para la tabla de usuarios
                    $campos = '';             // No se seleccionan campos adicionales
                    break;
            }

            // Construir la consulta SQL según el rol
            if ($rol === '') {
                // Consulta para todos los roles (sin filtro de rol específico)
                $sql = "SELECT 
                            u.nombre,
                            u.numero_identidad
                        FROM usuarios u
                        INNER JOIN registro_acceso ra ON u.id = ra.asignacion_id
                        WHERE (u.numero_identidad LIKE :documento OR :documento = '')
                        AND DATE(ra.fecha) = CURDATE()";
            } else {
                // Consulta para un rol específico
                $sql = "SELECT 
                            u.nombre,
                            u.numero_identidad,
                            $campos
                        FROM usuarios u
                        INNER JOIN $tabla $alias ON u.id = $alias.usuario_id
                        INNER JOIN registro_acceso ra ON u.id = ra.asignacion_id
                        WHERE (u.numero_identidad LIKE :documento OR :documento = '')
                        AND DATE(ra.fecha) = CURDATE()";
            }

            // Preparar la consulta SQL
            $stmt = $this->db->prepare($sql);

            // Asignar valores a los parámetros de la consulta
            $params = [
                ':documento' => "%$documento%"  // Búsqueda por número de identidad
            ];

            // Ejecutar la consulta con los parámetros proporcionados
            $stmt->execute($params);

            // Retornar los resultados de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>
