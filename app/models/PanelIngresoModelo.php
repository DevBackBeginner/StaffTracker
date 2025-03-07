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
            'Apoyo' => ['tabla' => 'apoyo', 'campos' => 'area_trabajo']
            ];
        
            if (!isset($tablas[$rol])) {
            return [];
            }
        
            $tabla = $tablas[$rol]['tabla'];
            $camposExtras = $tablas[$rol]['campos'];
        
            $sql = "SELECT u.nombre, u.numero_identidad, t.$camposExtras
                FROM $tabla t
                INNER JOIN usuarios u ON t.usuario_id = u.id
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
            'Apoyo' => 'apoyo'
            ];
        
            if (!isset($tablas[$rol])) {
            return 0;
            }
        
            $tabla = $tablas[$rol];
        
            $sql = "SELECT COUNT(*) FROM $tabla";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        
            return $stmt->fetchColumn();
        }

        public function filtrarUsuarios($rol = '', $documento = '')
        {
            // Construir la consulta SQL base
            $sql = "SELECT 
                        u.id AS usuario_id,
                        u.nombre,
                        u.apellidos,
                        u.telefono,
                        u.numero_identidad,
                        CASE
                            WHEN i.usuario_id IS NOT NULL THEN 'Instructor'
                            WHEN f.usuario_id IS NOT NULL THEN 'Funcionario'
                            WHEN d.usuario_id IS NOT NULL THEN 'Directivo'
                            WHEN a.usuario_id IS NOT NULL THEN 'Apoyo'
                            ELSE 'Sin Rol'
                        END AS rol,
                        COALESCE(i.curso, f.area, d.cargo, a.area_trabajo) AS informacion_especifica
                    FROM 
                        usuarios u
                    LEFT JOIN 
                        instructores i ON u.id = i.usuario_id
                    LEFT JOIN 
                        funcionarios f ON u.id = f.usuario_id
                    LEFT JOIN 
                        directivos d ON u.id = d.usuario_id
                    LEFT JOIN 
                        apoyo a ON u.id = a.usuario_id
                    WHERE 
                        (:rol = '' OR 
                            (:rol = 'Instructor' AND i.usuario_id IS NOT NULL) OR
                            (:rol = 'Funcionario' AND f.usuario_id IS NOT NULL) OR
                            (:rol = 'Directivo' AND d.usuario_id IS NOT NULL) OR
                            (:rol = 'Apoyo' AND a.usuario_id IS NOT NULL))
                        AND (u.numero_identidad LIKE :documento OR :documento = '')";
    
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);
    
            // Asignar valores a los parámetros
            $params = [
                ':rol' => $rol,
                ':documento' => "%$documento%"
            ];
    
            // Ejecutar la consulta
            $stmt->execute($params);
    
            // Retornar los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>
