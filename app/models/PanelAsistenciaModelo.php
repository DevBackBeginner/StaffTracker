<?php
    // Incluir la configuración de la base de datos
    require_once '../config/DataBase.php';

    /**
     * Modelo de Aprendiz para interactuar con la base de datos.
     */
    class PanelAsistenciaModelo {
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
                'Instructor' => ['tabla' => 'usuarios_instructores', 'campos' => 'curso, ubicacion'],
                'Funcionario' => ['tabla' => 'usuarios_funcionarios', 'campos' => 'area, puesto'],
                'Directiva' => ['tabla' => 'usuarios_directivas', 'campos' => 'cargo, departamento'],
                'Apoyo' => ['tabla' => 'usuarios_apoyo', 'campos' => 'area_trabajo']
            ];
        
            if (!isset($tablas[$rol])) {
                return [];
            }
        
            $tabla = $tablas[$rol]['tabla'];
            $camposExtras = $tablas[$rol]['campos'];
        
            $sql = "SELECT u.nombre, u.numero_identidad, u.rol, t.$camposExtras
                    FROM usuarios u
                    LEFT JOIN $tabla t ON u.id = t.usuario_id
                    WHERE u.rol = :rol
                    LIMIT :limit OFFSET :offset";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        
        
        public function contarUsuariosPorRol($rol) {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE rol = :rol";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->execute();
        
            return $stmt->fetchColumn();
        }
        

        public function filtrofuncionario($tipo, $documento) {
            // Construimos la consulta base
            $sql = "SELECT 
                        u.id,
                        u.nombre,
                        u.numero_identidad,
                        u.rol,
                        i.curso,
                        i.ubicacion,
                        f.area,
                        f.puesto,
                        d.cargo,
                        d.departamento
                    FROM usuarios u
                    LEFT JOIN usuarios_instructores i ON u.id = i.usuario_id
                    LEFT JOIN usuarios_funcionarios f ON u.id = f.usuario_id
                    LEFT JOIN usuarios_directivas d ON u.id = d.usuario_id
                    WHERE 1=1"; // '1=1' para concatenar condiciones opcionales
    
            $params = [];
    
            // Si se especifica un tipo (Instructor, Directiva, etc.)
            if (!empty($tipo)) {
                $sql .= " AND u.rol = :tipo";
                $params[':tipo'] = $tipo;
            }
    
            // Si se especifica un documento
            if (!empty($documento)) {
                $sql .= " AND u.numero_identidad LIKE :documento";
                $params[':documento'] = "%$documento%";
            }
    
            $sql .= " ORDER BY u.nombre"; // Ordenar por nombre
    
            $stmt = $this->db->prepare($sql);
    
            // Enlazamos los parámetros
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    
    }

?>
