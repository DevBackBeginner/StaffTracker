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

        public function obtenerPerfilPorId($usuarioId)
        {
            $sql = "SELECT ua.id, u.nombre
                    FROM usuarios_autenticados ua
                    JOIN usuarios u ON u.id = ua.usuario_id
                    WHERE ua.id = :usuario";
        
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function actualizarPerfil($idUsuario, $nombre, $apellidos, $telefono, $correo)
        {
            try {
                // Iniciar una transacción
                $this->db->beginTransaction();
        
                // 1. Actualizar la tabla `usuarios`
                $sqlUsuarios = "UPDATE usuarios
                                SET nombre = :nombre, 
                                    apellidos = :apellidos, 
                                    telefono = :telefono
                                WHERE id = :id";
                $stmtUsuarios = $this->db->prepare($sqlUsuarios);
                $stmtUsuarios->bindValue(':id', $idUsuario, PDO::PARAM_INT);
                $stmtUsuarios->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $stmtUsuarios->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
                $stmtUsuarios->bindValue(':telefono', $telefono, PDO::PARAM_STR);
                $stmtUsuarios->execute();
        
                // 2. Actualizar la tabla `usuarios_autenticados`
                $sqlAutenticados = "UPDATE usuarios_autenticados
                                    SET correo = :correo
                                    WHERE usuario_id = :id";
                $stmtAutenticados = $this->db->prepare($sqlAutenticados);
                $stmtAutenticados->bindValue(':id', $idUsuario, PDO::PARAM_INT);
                $stmtAutenticados->bindValue(':correo', $correo, PDO::PARAM_STR);
                $stmtAutenticados->execute();
        
                // Confirmar la transacción
                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                // Revertir la transacción en caso de error
                $this->db->rollBack();
                error_log("Error al actualizar el perfil: " . $e->getMessage());
                return false;
            }
        }

        public function actualizarImagenPerfil($idUsuario, $rutaImagen)
        {
            $query = "UPDATE usuarios_autenticados SET foto_perfil = :foto_perfil WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':foto_perfil' => $rutaImagen,
                ':id' => $idUsuario
            ]);
    
            return $stmt->rowCount() > 0; // Retorna true si se actualizó correctamente
        }
    
        // Método para eliminar la imagen de perfil
        public function eliminarImagenPerfil($idUsuario, $imagenPorDefecto)
        {
            $sql = "UPDATE usuarios_autenticados SET foto_perfil = :imagenPorDefecto WHERE id = :idUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':imagenPorDefecto', $imagenPorDefecto, PDO::PARAM_STR);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            return $stmt->execute(); // Devuelve true si la ejecución fue exitosa
        }

        public function verificarContraseña($idUsuario, $contraseñaActual){
            $sql = "SELECT contrasena FROM usuarios_autenticados WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return password_verify($contraseñaActual, $resultado['contrasena']);
        }

        public function actualizarContraseña($idUsuario, $nuevaContraseña){
            $hash = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios_autenticados SET contrasena = :contrasena WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':contrasena', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
?>