<?php
    // Incluir la configuración de la base de datos
    require_once '../config/DataBase.php';

    /**
     * Modelo de Aprendiz para interactuar con la base de datos.
     */
    class PanelModelo {
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

        public function obtenerTodosLosAprendices() {
            $sql = "SELECT nombre, numero_identidad FROM aprendices";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Método para obtener todos los aprendices agrupados por ficha.
         *
         * Esta consulta obtiene información de los estudiantes, su ficha, sus asistencias y datos de computadores asociados.
         *
         * @return array Arreglo asociativo donde cada clave es el código de la ficha y su valor es un arreglo de estudiantes asociados.
         */
        public function obtenerTodosPorFichaPaginadas($limite, $offset) {
            // Primero, obtener los códigos de ficha distintos (grupos) para la página actual.
            $sql = "SELECT DISTINCT f.codigo_ficha AS ficha
                    FROM aprendices a
                    INNER JOIN fichas f ON a.ficha_id = f.id
                    INNER JOIN asistencias asi ON asi.aprendiz_id = a.id
                    WHERE asi.estado = 'activo'
                    ORDER BY f.codigo_ficha
                    LIMIT :limite OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            $fichas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Si no se encontraron fichas, retorna un arreglo vacío.
            if (empty($fichas)) {
                return [];
            }
            
            // Extraer los códigos de ficha en un arreglo.
            $fichaCodes = array_column($fichas, 'ficha');
            
            // Preparar los placeholders para la consulta IN
            $placeholders = implode(',', array_fill(0, count($fichaCodes), '?'));
            
            // Ahora, obtener los registros de aprendices correspondientes a las fichas encontradas.
            $sql2 = "SELECT 
                        a.id, 
                        a.numero_identidad, 
                        a.nombre, 
                        f.codigo_ficha AS ficha, 
                        f.turno, 
                        asi.hora_entrada, 
                        asi.hora_salida, 
                        asi.entrada_computador,
                        asi.salida_computador,
                        c.marca_computador AS computador, 
                        c.codigo_computador
                    FROM aprendices a
                    INNER JOIN fichas f ON a.ficha_id = f.id
                    INNER JOIN asistencias asi ON asi.aprendiz_id = a.id
                    LEFT JOIN computadores c ON c.aprendiz_id = a.id
                    WHERE asi.estado = 'activo'
                        AND f.codigo_ficha IN ($placeholders)
                    ORDER BY f.codigo_ficha";
            
            $stmt2 = $this->db->prepare($sql2);
            // Vincular cada código de ficha
            foreach ($fichaCodes as $i => $code) {
                $stmt2->bindValue($i + 1, $code, PDO::PARAM_STR);
            }
            $stmt2->execute();
            
            $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
            // Agrupar los aprendices por ficha
            $studentsByFicha = [];
            foreach ($result as $student) {
                $studentsByFicha[$student['ficha']][] = $student;
            }
            
            return $studentsByFicha;
        }

        public function obtenerTodosPorFicha() {
            // Definir la consulta SQL con JOIN para relacionar las tablas aprendices, fichas, asistencias y computadores
            $sql = "SELECT 
                a.id, 
                a.numero_identidad, 
                a.nombre, 
                f.codigo_ficha AS ficha, 
                f.turno, 
                asi.hora_entrada, 
                asi.hora_salida, 
                asi.entrada_computador,
                asi.salida_computador,
                c.marca_computador AS computador, 
                c.codigo_computador
            FROM aprendices a
            INNER JOIN fichas f ON a.ficha_id = f.id
            LEFT JOIN asistencias asi ON asi.aprendiz_id = a.id
            LEFT JOIN computadores c ON c.aprendiz_id = a.id
            ORDER BY f.codigo_ficha";
        
            $stmt = $this->db->prepare($sql);
            $stmt->execute(); // Ejecutar la consulta
        
            // Obtener los resultados como un arreglo asociativo
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Inicializar un arreglo para almacenar los aprendices agrupados por ficha
            $studentsByFicha = [];
        
            // Recorrer cada fila del resultado
            foreach ($result as $student) {
                // Agrupar los aprendices usando el código de ficha como clave
                $studentsByFicha[$student['ficha']][] = $student;
            }
            
            // Retornar el arreglo de estudiantes agrupados por ficha
            return $studentsByFicha;
        }
        
        
        public function contarFichas() {
            $sql = "SELECT COUNT(DISTINCT fichas.id) as total
                    FROM fichas
                    JOIN aprendices ON fichas.id = aprendices.ficha_id
                    JOIN asistencias ON aprendices.id = asistencias.aprendiz_id
                    WHERE asistencias.estado = 'activo'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }
        
        
        
        public function obtenerAprendicesFiltrados($ficha, $documento) {
            // Seleccionamos las columnas que necesitamos de aprendices, fichas, computadores
            // e incluimos la tabla asistencias para filtrar por estado 'activo'.
            $sql = "SELECT 
                        a.*, 
                        f.codigo_ficha AS ficha, 
                        f.turno,
                        c.marca_computador, 
                        c.codigo_computador
                    FROM aprendices a
                    INNER JOIN fichas f ON a.ficha_id = f.id
                    LEFT JOIN computadores c ON c.aprendiz_id = a.id
                    INNER JOIN asistencias asi ON asi.aprendiz_id = a.id
                    WHERE asi.estado = 'activo'"; // Solo aprendices con asistencias activas
            
            // Array para los parámetros de filtro (ficha y documento)
            $params = [];
        
            // Filtro opcional por código de ficha
            if (!empty($ficha)) {
                $sql .= " AND f.codigo_ficha LIKE ?";
                $params[] = "%$ficha%";
            }
        
            // Filtro opcional por número de identidad
            if (!empty($documento)) {
                $sql .= " AND a.numero_identidad LIKE ?";
                $params[] = "%$documento%";
            }
        
            // Prepara y ejecuta la consulta
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        
            // Obtener resultados
            $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Agrupar por ficha (alias 'ficha' = f.codigo_ficha)
            $aprendicesPorFicha = [];
            foreach ($aprendices as $aprendiz) {
                $aprendicesPorFicha[$aprendiz['ficha']][] = $aprendiz;
            }
        
            return $aprendicesPorFicha;
        }
        
        public function obtenerPorIdentidad($numero_identidad) {
            $fechaHoy = date('Y-m-d');
        
            $sql = "SELECT a.id, a.numero_identidad, a.nombre, asi.hora_entrada, asi.hora_salida 
                    FROM aprendices a
                    LEFT JOIN asistencias asi ON asi.aprendiz_id = a.id AND DATE(asi.hora_entrada) = :fecha
                    WHERE a.numero_identidad = :numero_identidad";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':numero_identidad', $numero_identidad, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fechaHoy, PDO::PARAM_STR);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        
        

        // Método para obtener un computador por su ID (opcional)
        public function obtenerComputadoresPorAprendizId($aprendizId) {
            $sql = "SELECT id, marca_computador, codigo_computador FROM computadores WHERE aprendiz_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['aprendizId' => $aprendizId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
