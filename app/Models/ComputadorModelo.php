<?php
    require_once '../config/DataBase.php';

    class ComputadorModelo
    {
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

        
        public function obtenerComputadoresPersonales($idPersona) {
            // Validar que el ID sea numérico
            if (!is_numeric($idPersona)) {
                throw new InvalidArgumentException("ID de persona debe ser numérico");
            }
        
            $sql = "SELECT 
                        c.id_computador AS id,
                        c.modelo, 
                        c.codigo, 
                        c.teclado, 
                        c.mouse, 
                        'Disponible' AS estado,
                        'computador_personal' AS tipo
                    FROM 
                        computadores c
                    WHERE 
                        c.asignado_a = :idPersona";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPersona', $idPersona, PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                throw new RuntimeException("Error al ejecutar consulta de computadores personales");
            }
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Asegurar que todos los IDs son numéricos
            return array_map(function($item) {
                $item['id'] = (int)$item['id'];
                return $item;
            }, $resultados);
        }
        
        public function obtenerComputadoresSena($idPersona = null) {
            $sql = $idPersona
                    ? "SELECT 
                            cs.id_computador_sena AS id,
                            cs.modelo, 
                            cs.codigo, 
                            cs.teclado, 
                            cs.mouse, 
                            cs.estado, 
                            'computador_sena' AS tipo
                    FROM 
                            computadores_sena cs
                    WHERE 
                            cs.asignado_a = :idPersona"
                    : "SELECT 
                            cs.id_computador_sena AS id,
                            cs.modelo, 
                            cs.codigo, 
                            cs.teclado, 
                            cs.mouse, 
                            cs.estado, 
                            'computador_sena' AS tipo
                    FROM 
                            computadores_sena cs
                    WHERE 
                            cs.estado = 'Disponible'";
            
            $stmt = $this->db->prepare($sql);
            
            if ($idPersona) {
                if (!is_numeric($idPersona)) {
                    throw new InvalidArgumentException("ID de persona debe ser numérico");
                }
                $stmt->bindParam(':idPersona', $idPersona, PDO::PARAM_INT);
            }
            
            if (!$stmt->execute()) {
                throw new RuntimeException("Error al ejecutar consulta de computadores SENA");
            }
        
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Asegurar que todos los IDs son numéricos
            return array_map(function($item) {
                $item['id'] = (int)$item['id'];
                return $item;
            }, $resultados);
        }

        public function obtenerComputadoresDisponibles()
        {
            try {
                // Consulta SQL para obtener computadores disponibles
                $query = "
                    SELECT 
                        id_computador_sena,
                        modelo,
                        codigo,
                        teclado,
                        mouse
                    FROM 
                        computadores_sena
                    WHERE 
                        estado = 'Disponible'
                    ORDER BY 
                        modelo ASC
                ";
                
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                
                // Retornar resultados como array asociativo
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                // Registrar error y retornar array vacío en caso de fallo
                error_log("Error al obtener computadores disponibles: " . $e->getMessage());
                return [];
            }
        }
        public function ingresarComputador($marca, $codigo, $mouse, $teclado, $tipo_computador)
        {
            try {
                // Consulta SQL para insertar un nuevo computador
                $sql = "INSERT INTO computadores (marca, codigo, mouse, teclado, tipo_computador) 
                        VALUES (:marca, :codigo, :mouse, :teclado, :tipo_computador)";
                
                // Preparar la consulta
                $stmt = $this->db->prepare($sql);
                
                // Vincular los parámetros
                $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmt->bindParam(':mouse', $mouse, PDO::PARAM_STR); // Nuevo parámetro
                $stmt->bindParam(':teclado', $teclado, PDO::PARAM_STR); // Nuevo parámetro
                $stmt->bindParam(':tipo_computador', $tipo_computador, PDO::PARAM_STR);
                
                // Ejecutar la consulta
                $stmt->execute();
                
                // Devolver el ID del computador registrado
                return $this->db->lastInsertId();
            } catch (PDOException $e) {
                // Manejar errores de la base de datos
                error_log("Error al registrar computador: " . $e->getMessage());
                return false;
            }
        }

        public function obtenerIdPersonaPorDocumento($documento) {
            try {
                $stmt = $this->db->prepare("
                    SELECT id_persona 
                    FROM personas 
                    WHERE numero_documento = :documento
                    LIMIT 1
                ");
                
                $stmt->bindValue(':documento', $documento, PDO::PARAM_STR);
                $stmt->execute();
                
                // Verificar explícitamente si hay resultados
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    return (int)$result['id_persona']; // Forzar tipo entero
                }
                return null;
            } catch (PDOException $e) {
                error_log("Error en obtenerIdPersonaPorDocumento: " . $e->getMessage());
                return null;
            }
        }
        
        public function registrarComputadorPersonal($modelo, $codigo, $teclado, $mouse, $asignado_a) {
            try {
                $this->db->beginTransaction();
                
                $stmt = $this->db->prepare("
                    INSERT INTO computadores 
                    (modelo, codigo, teclado, mouse, asignado_a) 
                    VALUES (:modelo, :codigo, :teclado, :mouse, :asignado_a)
                ");
                
                // Bind de parámetros con tipos explícitos
                $stmt->bindValue(':modelo', trim($modelo), PDO::PARAM_STR);
                $stmt->bindValue(':codigo', trim($codigo), PDO::PARAM_STR);
                $stmt->bindValue(':teclado', $teclado === 'Si' ? 'Si' : 'No', PDO::PARAM_STR);
                $stmt->bindValue(':mouse', $mouse === 'Si' ? 'Si' : 'No', PDO::PARAM_STR);
                $stmt->bindValue(':asignado_a', $asignado_a, PDO::PARAM_INT);
                
                $stmt->execute();
                
                $id = (int)$this->db->lastInsertId();
                $this->db->commit();
                
                return $id;
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error en registrarComputadorPersonal: " . $e->getMessage());
                throw new Exception("Error al registrar computador personal", 0, $e);
            }
        }
        
        public function registrarComputadorSena($modelo, $codigo, $teclado, $mouse, $estado, $asignado_a) {
            try {
                $this->db->beginTransaction();
                
                $stmt = $this->db->prepare("
                    INSERT INTO computadores_sena 
                    (modelo, codigo, teclado, mouse, estado, asignado_a) 
                    VALUES (:modelo, :codigo, :teclado, :mouse, :estado, :asignado_a)
                ");
                
                // Validar y bindear parámetros
                $estado = in_array($estado, ['Disponible', 'Asignado']) ? $estado : 'Disponible';
                
                $stmt->bindValue(':modelo', trim($modelo), PDO::PARAM_STR);
                $stmt->bindValue(':codigo', trim($codigo), PDO::PARAM_STR);
                $stmt->bindValue(':teclado', $teclado === 'Si' ? 'Si' : 'No', PDO::PARAM_STR);
                $stmt->bindValue(':mouse', $mouse === 'Si' ? 'Si' : 'No', PDO::PARAM_STR);
                $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
                $stmt->bindValue(':asignado_a', $asignado_a, PDO::PARAM_INT);
                
                $stmt->execute();
                
                $id = (int)$this->db->lastInsertId();
                $this->db->commit();
                
                return $id;
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error en registrarComputadorSena: " . $e->getMessage());
                throw new Exception("Error al registrar computador SENA", 0, $e);
            }
        }

        public function registrarValidacionEquipo($id_equipo, $tipo_equipo) {
            try {
                // Validar tipo de equipo
                $tiposPermitidos = ['computador_personal', 'computador_sena'];
                if (!in_array($tipo_equipo, $tiposPermitidos)) {
                    throw new InvalidArgumentException("Tipo de equipo no válido");
                }
                
                $stmt = $this->db->prepare("
                    INSERT INTO validacion_equipos 
                    (id_equipo, tipo_equipo, fecha_registro) 
                    VALUES (:id_equipo, :tipo_equipo, NOW())
                ");
                
                $stmt->bindValue(':id_equipo', (int)$id_equipo, PDO::PARAM_INT);
                $stmt->bindValue(':tipo_equipo', $tipo_equipo, PDO::PARAM_STR);
                
                if (!$stmt->execute()) {
                    throw new RuntimeException("Error al ejecutar la consulta");
                }
                
                return (int)$this->db->lastInsertId();
            } catch (PDOException $e) {
                error_log("Error en registrarValidacionEquipo: " . $e->getMessage());
                throw new Exception("Error al registrar validación de equipo", 0, $e);
            }
        }

        public function obtenerIdValidacionEquipo($computadorId) {
            $sql = "SELECT id FROM validacion_equipos 
                    WHERE id_equipo = ? AND tipo_equipo = 'computador_personal'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$computadorId]);
            return $stmt->fetchColumn();
        }

        public function actualizarEstadoComputadorSena($computador_id, $estado) {
            $stmt = $this->db->prepare("
                UPDATE computadores_sena 
                SET estado = :estado 
                WHERE id_computador_sena = :id
            ");
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':id', $computador_id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function vincularEquipoAEvento($id_evento, $id_equipo) {
            $stmt = $this->db->prepare("
                INSERT INTO equipos_evento 
                (id_evento, id_equipo_sena)
                VALUES (?, ?)
            ");
            return $stmt->execute([$id_evento, $id_equipo]);
        }
        
        public function actualizarEstadoEquipo($id_equipo, $estado, $id_asignado_a) {
            $stmt = $this->db->prepare("
                UPDATE computadores_sena 
                SET estado = :estado,
                    asignado_a = :asignado_a
                WHERE id_computador_sena = :id_equipo
            ");
            
            return $stmt->execute([
                ':estado' => $estado,
                ':asignado_a' => $id_asignado_a,
                ':id_equipo' => $id_equipo
            ]);
        }

        public function obtenerEquiposPorEvento($idEvento) {
            $stmt = $this->db->prepare("
                SELECT 
                    cs.id_computador_sena,
                    cs.modelo,
                    cs.codigo
                FROM equipos_evento ee
                JOIN computadores_sena cs ON ee.id_equipo_sena = cs.id_computador_sena
                WHERE ee.id_evento = ?
            ");
            $stmt->execute([$idEvento]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function registrarDevolucionEquipo($idEquipo) {
            $stmt = $this->db->prepare("
                UPDATE computadores_sena 
                SET estado = 'Disponible',
                    asignado_a = NULL
                WHERE id_computador_sena = ?
            ");
            return $stmt->execute([$idEquipo]);
        }

        
    }
?>