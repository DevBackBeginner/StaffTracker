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
            // Verificar que el rol sea válido (puedes agregar más roles si es necesario)
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
            if (!in_array($rol, $rolesPermitidos)) {
                return [];
            }
        
            // Consulta SQL para obtener usuarios registrados en registros sin filtrar por fecha
            $sql = "SELECT 
                        u.nombre,
                        u.apellidos,
                        u.numero_identidad, 
                        u.telefono,
                        ra.fecha, 
                        ra.hora_entrada, 
                        ra.hora_salida, 
                        ra.estado,
                        il.cargo,
                        il.tipo_contrato
                    FROM registros ra
                    INNER JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    INNER JOIN usuarios u ON ac.usuario_id = u.id
                    INNER JOIN informacion_laboral il ON u.id = il.usuario_id
                    WHERE u.rol = :rol -- Filtra por el rol especificado
                    ORDER BY ra.fecha DESC, ra.hora_entrada DESC
                    LIMIT :limit OFFSET :offset";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarUsuariosPorRol($rol) {
            // Consulta SQL para contar usuarios de un rol específico sin filtrar por fecha
            $sql = "SELECT COUNT(*) as total 
                    FROM registros ra
                    INNER JOIN asignaciones_computadores ac ON ra.asignacion_id = ac.id
                    INNER JOIN usuarios u ON ac.usuario_id = u.id
                    WHERE u.rol = :rol"; // Sin filtrar por fecha
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return (int)$resultado['total']; // Devuelve el total de registros
        }
        
        public function filtrarUsuarios($rol = '', $documento = '', $nombre = '') {
            // Construir la consulta SQL base
            $sql = "SELECT u.nombre, u.apellidos, u.numero_identidad, u.telefono,
                        ra.fecha, ra.hora_entrada, ra.hora_salida,
                        il.cargo, il.tipo_contrato
                    FROM usuarios u
                    INNER JOIN informacion_laboral il ON u.id = il.usuario_id
                    INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                    INNER JOIN registros ra ON ac.id = ra.asignacion_id
                    WHERE 1=1"; // WHERE 1=1 para facilitar la concatenación de condiciones

            // Filtrar por rol si se especifica
            if (!empty($rol)) {
                $sql .= " AND u.rol = :rol";
            }

            // Filtrar por documento (solo si no está vacío)
            if (!empty($documento)) {
                $sql .= " AND u.numero_identidad LIKE :documento";
            }

            // Filtrar por nombre (solo si no está vacío)
            if (!empty($nombre)) {
                $sql .= " AND (u.nombre LIKE :nombre OR u.apellidos LIKE :nombre)";
            }

            // Ordenar por fecha y hora de entrada descendente
            $sql .= " ORDER BY ra.fecha DESC, ra.hora_entrada DESC";

            // Preparar y ejecutar la consulta
            $stmt = $this->db->prepare($sql);

            // Bind de parámetros (solo si no están vacíos)
            if (!empty($rol)) {
                $stmt->bindValue(':rol', $rol, PDO::PARAM_STR);
            }
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
        public function contarUsuariosFiltrados($rol = '', $documento = '', $nombre = '') {
            // Construir la consulta SQL según el rol
            if ($rol === '') {
                // Consulta para todos los roles sin filtro
                $sql = "SELECT COUNT(*) AS total
                        FROM usuarios u
                        INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                        INNER JOIN registros ra ON ac.id = ra.asignacion_id
                        WHERE 1=1";
            } else {
                // Consulta para un rol específico
                $sql = "SELECT COUNT(*) AS total
                        FROM usuarios u
                        INNER JOIN asignaciones_computadores ac ON u.id = ac.usuario_id
                        INNER JOIN registros ra ON ac.id = ra.asignacion_id
                        WHERE 1=1";
            }
        
            // Filtrar por documento
            if (!empty($documento)) {
                $sql .= " AND u.numero_identidad LIKE :documento";
            }
        
            // Filtrar por nombre
            if (!empty($nombre)) {
                $sql .= " AND u.nombre LIKE :nombre";
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
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        }
    }

?>
