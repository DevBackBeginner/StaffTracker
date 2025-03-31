<?php

    require_once '../config/DataBase.php';

    class PerfilModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();
        }

        public function obtenerPerfilPorId($usuarioId) {
            $sql = "SELECT 
                        p.id_persona,
                        p.nombre,
                        p.apellido,
                        p.tipo_documento,
                        p.numero_documento,
                        p.telefono,
                        p.rol,
                        pa.correo,
                        pa.foto_perfil
                    FROM personas p
                    LEFT JOIN personal_administrativo pa ON p.id_persona = pa.usuario_id
                    WHERE p.id_persona = :usuarioId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function actualizarPerfil($idUsuario, $nombre, $apellido, $telefono, $correo) {
            try {
                // Iniciar transacción
                $this->db->beginTransaction();
        
                // 1. Actualizar tabla 'personas'
                $sqlPersonas = "UPDATE personas 
                                SET nombre = :nombre,
                                    apellido = :apellido,
                                    telefono = :telefono
                                WHERE id_persona = :id";
                
                $stmtPersonas = $this->db->prepare($sqlPersonas);
                $stmtPersonas->bindValue(':id', $idUsuario, PDO::PARAM_INT);
                $stmtPersonas->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $stmtPersonas->bindValue(':apellido', $apellido, PDO::PARAM_STR);
                $stmtPersonas->bindValue(':telefono', $telefono, PDO::PARAM_STR);
                $stmtPersonas->execute();
        
                // 2. Actualizar tabla 'personal_administrativo'
                $sqlAdmin = "UPDATE personal_administrativo
                                SET correo = :correo
                                WHERE usuario_id = :id";
                
                $stmtAdmin = $this->db->prepare($sqlAdmin);
                $stmtAdmin->bindValue(':id', $idUsuario, PDO::PARAM_INT);
                $stmtAdmin->bindValue(':correo', $correo, PDO::PARAM_STR);
                $stmtAdmin->execute();
        
                // Confirmar transacción
                $this->db->commit();
                return true;
                
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error al actualizar perfil: " . $e->getMessage());
                return false;
            }
        }

        public function actualizarImagenPerfil($idUsuario, $rutaImagen) {
            try {
                $query = "UPDATE personal_administrativo 
                          SET foto_perfil = :foto_perfil 
                          WHERE usuario_id = :idUsuario";  // Cambiado a usuario_id
                
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':foto_perfil', $rutaImagen, PDO::PARAM_STR);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->execute();
            
                return $stmt->rowCount() > 0;
                
            } catch (PDOException $e) {
                error_log("Error al actualizar imagen: " . $e->getMessage());
                return false;
            }
        }
        
        public function eliminarImagenPerfil($idUsuario, $imagenPorDefecto) {
            try {
                $sql = "UPDATE personal_administrativo 
                        SET foto_perfil = :imagenPorDefecto 
                        WHERE usuario_id = :idUsuario";  // Cambiado a usuario_id
                
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':imagenPorDefecto', $imagenPorDefecto, PDO::PARAM_STR);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                return $stmt->execute();
                
            } catch (PDOException $e) {
                error_log("Error al eliminar imagen: " . $e->getMessage());
                return false;
            }
        }

        public function verificarContraseña($idUsuario, $contraseñaActual) {
            try {
                $sql = "SELECT pa.contrasena 
                        FROM personal_administrativo pa
                        WHERE pa.usuario_id = :idUsuario";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->execute();
                
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$resultado || !isset($resultado['contrasena'])) {
                    return false; // Usuario no encontrado o sin contraseña
                }
                
                return password_verify($contraseñaActual, $resultado['contrasena']);
                
            } catch (PDOException $e) {
                error_log("Error al verificar contraseña: " . $e->getMessage());
                return false;
            }
        }

        public function actualizarContraseña($idUsuario, $nuevaContraseña) {
            try {
                // 1. Generar hash seguro
                $hash = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
                
                // 2. Consulta actualizada con usuario_id
                $sql = "UPDATE personal_administrativo 
                        SET contrasena = :contrasena 
                        WHERE usuario_id = :idUsuario";  // Cambiado a usuario_id
                
                // 3. Transacción para seguridad
                $this->db->beginTransaction();
                
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':contrasena', $hash, PDO::PARAM_STR);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $resultado = $stmt->execute();
                
                $this->db->commit();
                return $resultado;
                
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error al actualizar contraseña: " . $e->getMessage());
                return false;
            }
        }
    }
?>