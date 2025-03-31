<?php
    
    require_once '../config/DataBase.php';

    class VisitantesModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();

            $this->db = $conn->getConnection();
            date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

        }

        public function registrarPersona($nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $rol) {
            $sql = "INSERT INTO personas 
                    (nombre, apellido, tipo_documento, numero_documento, telefono, rol) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $rol]);
            return $this->db->lastInsertId();
        }
        
        public function registrarVisita($personaId, $asunto, $fechaVisita, $registrador) {
            $sql = "INSERT INTO visitantes 
                    (id_persona, asunto_visita, fecha_visita, registrado_por) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$personaId, $asunto, $fechaVisita, $registrador]);
            return $this->db->lastInsertId();
        }

        public function registrarEntrada($id_persona, $fecha, $hora_ingreso, $id_validacion_equipo = null) {
            try {
                $sql = "INSERT INTO registro_ingreso_salida 
                        (id_persona, fecha, hora_ingreso, id_validacion_equipo) 
                        VALUES (:id_persona, :fecha, :hora_ingreso, :id_validacion_equipo)";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':id_persona', $id_persona, PDO::PARAM_INT);
                $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
                $stmt->bindValue(':hora_ingreso', $hora_ingreso, PDO::PARAM_STR);
                $stmt->bindValue(':id_validacion_equipo', $id_validacion_equipo, 
                                $id_validacion_equipo ? PDO::PARAM_INT : PDO::PARAM_NULL);
                
                if (!$stmt->execute()) {
                    throw new Exception("Error al ejecutar el registro");
                }
        
                return $this->db->lastInsertId();
                
            } catch (PDOException $e) {
                error_log("Error DB: " . $e->getMessage());
                throw new Exception("Error al registrar entrada");
            }
        }

        public function obtenerVisitantes($pagina = 1, $limite = 10, $filtros = []) {
            $offset = ($pagina - 1) * $limite;
            
            $sql = "SELECT v.*, p.nombre, p.apellido, p.tipo_documento, p.numero_documento, p.telefono
                    FROM visitantes v
                    JOIN personas p ON v.id_persona = p.id_persona
                    WHERE p.rol = 'Visitante'";
            
            // Aplicar filtros
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND p.numero_documento LIKE :documento";
            }
            
            $sql .= " ORDER BY p.nombre ASC LIMIT :limite OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', '%' . $filtros['nombre'] . '%', PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', '%' . $filtros['documento'] . '%', PDO::PARAM_STR);
            }
            
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        public function contarVisitantes($filtros = []) {
            $sql = "SELECT COUNT(*) as total
                    FROM visitantes v
                    JOIN personas p ON v.id_persona = p.id_persona
                    WHERE p.rol = 'Visitante'";
            
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND p.numero_documento LIKE :documento";
            }
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', '%' . $filtros['nombre'] . '%', PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', '%' . $filtros['documento'] . '%', PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }
    }
?>