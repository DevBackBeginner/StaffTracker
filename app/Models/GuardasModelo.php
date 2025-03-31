<?php
    require_once '../config/DataBase.php';

    class GuardasModelo {
        private $db;

        public function __construct() {
            // Crear una instancia de la clase DataBase para obtener la conexión
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();        
        }

        public function registrarGuarda($nombre, $apellidos, $tipo_documento, $telefono, $numero_documento, $correo, $passwordHash, $foto_perfil) {
            try {
                // Validar tipo de documento
                $tiposPermitidos = ['CC', 'CE', 'TI', 'PA', 'NIT', 'OTRO'];
                if (!in_array($tipo_documento, $tiposPermitidos)) {
                    throw new Exception("Tipo de documento no válido");
                }
        
                // Inicia la transacción
                $this->db->beginTransaction();
        
                // Inserta datos en la tabla "usuarios" (con tipo_documento)
                $stmt = $this->db->prepare("
                    INSERT INTO personas (nombre, apellido, tipo_documento, telefono, numero_documento, rol)
                    VALUES (:nombre, :apellidos, :tipo_documento, :telefono, :numero_documento, :rol)
                ");
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'tipo_documento' => $tipo_documento,
                    'telefono' => $telefono,
                    'numero_documento' => $numero_documento,
                    'rol' => 'guarda'
                ]);
        
                // Obtiene el ID generado
                $usuario_id = $this->db->lastInsertId();
        
                // Inserta datos en la tabla "usuarios_autenticados"
                $stmt = $this->db->prepare("
                    INSERT INTO personal_administrativo (usuario_id, correo, contrasena, foto_perfil)
                    VALUES (:usuario_id, :correo, :contrasena, :foto_perfil)
                ");
                $stmt->execute([
                    'usuario_id' => $usuario_id,
                    'correo' => $correo,
                    'contrasena' => $passwordHash,
                    'foto_perfil' => $foto_perfil
                ]);
        
                // Confirma la transacción
                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                // Revierte la transacción en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                // Manejo específico de errores de duplicidad
                if ($e->getCode() == 23000) { // Código de error para violación de restricción única
                    if (strpos($e->getMessage(), 'numero_documento') !== false) {
                        throw new Exception("El número de documento ya está registrado");
                    } elseif (strpos($e->getMessage(), 'correo') !== false) {
                        throw new Exception("El correo electrónico ya está registrado");
                    }
                }
                
                throw new Exception("Error al registrar el guarda: " . $e->getMessage());
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                throw $e;
            }
        }
    
        public function obtenerGuardas($pagina, $limite, $filtros = []) {
            $offset = ($pagina - 1) * $limite;
            
            $sql = "SELECT p.*, pa.correo 
                    FROM personas p
                    LEFT JOIN personal_administrativo pa ON p.id_persona = pa.usuario_id
                    WHERE p.rol = 'Guarda'";
            
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND p.numero_documento LIKE :documento";
            }
            
            $sql .= " ORDER BY p.apellido, p.nombre LIMIT :limite OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', "%{$filtros['nombre']}%");
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', "%{$filtros['documento']}%");
            }
            
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function contarGuardas($filtros = []) {
            $sql = "SELECT COUNT(*) as total 
                    FROM personas 
                    WHERE rol = 'Guarda'";
            
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (nombre LIKE :nombre OR apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND numero_documento LIKE :documento";
            }
            
            $stmt = $this->db->prepare($sql);
            
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', "%{$filtros['nombre']}%");
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', "%{$filtros['documento']}%");
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)$result['total'];
        }

        public function ActualizarGuarda($id_persona, $nombre, $apellido, $tipo_documento, $numerodocumento, $telefono, $correo)
        {
            try {
                // Iniciar transacción para asegurar la atomicidad
                $this->db->beginTransaction();
        
                // Actualizar datos en tabla persona
                $sqlPersona = "UPDATE personas SET 
                        nombre = :nombre,
                        apellido = :apellido,
                        tipo_documento = :tipo_documento,
                        numero_documento = :numero_documento,
                        telefono = :telefono
                        WHERE id_persona = :id_persona";
                
                $stmtPersona = $this->db->prepare($sqlPersona);
                $stmtPersona->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':tipo_documento' => $tipo_documento,
                    ':numero_documento' => $numerodocumento,
                    ':telefono' => $telefono,
                    ':id_persona' => $id_persona
                ]);
        
                // Verificar si existe en personal_administrativo
                $sqlAutorizado = "SELECT COUNT(*) FROM personal_administrativo WHERE usuario_id = :id_persona";
                $stmtAutorizado = $this->db->prepare($sqlAutorizado);
                $stmtAutorizado->execute([':id_persona' => $id_persona]);
                $existeGuarda = $stmtAutorizado->fetchColumn() > 0;
        
                //  Actualizar correo si existe
                if ($existeGuarda) {
                    $sqlActualizar = "UPDATE personal_administrativo SET correo = :correo WHERE usuario_id = :id_persona";
                    $stmtActualizar = $this->db->prepare($sqlActualizar);
                    $stmtActualizar->execute([
                        ':correo' => $correo,
                        ':id_persona' => $id_persona
                    ]);
                }
        
                // Confirmar transacción
                $this->db->commit();
                
                return true;
        
            } catch (PDOException $e) {
                // Revertir transacción en caso de error
                $this->db->rollBack();
                
                // Registrar error (opcional)
                error_log("Error al actualizar guarda: " . $e->getMessage());
                
                return false;
            }
        }
    }
?>