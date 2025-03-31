<?php 

    require_once '../config/DataBase.php';

    class LoginModelo{
        private $db;
        private const PASSWORD_ALGORITHM = PASSWORD_BCRYPT;
        private const TOKEN_EXPIRATION = '+1 hour';
        private const DB_TIMEOUT = 30; // 30 segundos de timeout
    

        public function __construct (){
            $conn = new DataBase();
            $this->db = $conn->getConnection();
            // Configurar timeout para la conexión
            $this->db->setAttribute(PDO::ATTR_TIMEOUT, self::DB_TIMEOUT);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            date_default_timezone_set('America/Bogota'); // Cambia por tu zona horaria   
        }

        public function buscarPorCorreo($correo) {
            $sql = "SELECT 
                            p.id_persona as id,
                            p.nombre,
                            p.apellido,
                            p.telefono,
                            p.tipo_documento,
                            p.numero_documento as numero_identidad,
                            p.rol,
                            pa.correo,
                            pa.contrasena,
                            pa.foto_perfil
                    FROM personal_administrativo pa
                    JOIN personas p ON pa.usuario_id = p.id_persona
                    WHERE pa.correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute(['correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function guardarTokenRecuperacion(int $usuarioId, string $token, ?string $expiry = null): bool {
            $this->db->beginTransaction();
            try {
                $expiry = $expiry ?? date('Y-m-d H:i:s', strtotime('+1 hour')); // 1 hora de expiración
                
                // Primero eliminamos cualquier token existente
                $stmt = $this->db->prepare(
                    'UPDATE personal_administrativo 
                    SET reset_token = NULL, 
                        reset_token_expiry = NULL 
                    WHERE id = :id'
                );
                $stmt->execute(['id' => $usuarioId]);
                
                // Luego guardamos el nuevo token
                $stmt = $this->db->prepare(
                    'UPDATE personal_administrativo 
                    SET reset_token = :token, 
                        reset_token_expiry = :expiry 
                    WHERE id = :id'
                );
                $result = $stmt->execute([
                    'token' => $token,
                    'expiry' => $expiry,
                    'id' => $usuarioId
                ]);
                
                $this->db->commit();
                return $result;
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error en guardarTokenRecuperacion: " . $e->getMessage());
                return false;
            }
        }
        
        public function buscarPorToken(string $token): ?array {
            if (empty($token)) {
                return null;
            }
        
            try {
                $stmt = $this->db->prepare(
                    'SELECT pa.*, p.nombre, p.apellido 
                    FROM personal_administrativo pa
                    JOIN personas p ON pa.usuario_id = p.id_persona
                    WHERE pa.reset_token = :token 
                    AND pa.reset_token_expiry > NOW()
                    LIMIT 1'
                );
                $stmt->execute(['token' => $token]);
                return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
            } catch (PDOException $e) {
                error_log("Error en buscarPorToken: " . $e->getMessage());
                return null;
            }
        }
        
        public function actualizarContrasena(int $usuarioId, string $contrasena): bool {
            if (empty($contrasena) || strlen($contrasena) < 8) {
                return false;
            }
        
            $this->db->beginTransaction();
            try {
                // Verificar que el usuario existe
                $stmt = $this->db->prepare('SELECT id FROM personal_administrativo WHERE id = :id');
                $stmt->execute(['id' => $usuarioId]);
                if (!$stmt->fetch()) {
                    return false;
                }
        
                $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);
                $stmt = $this->db->prepare(
                    'UPDATE personal_administrativo 
                    SET contrasena = :contrasena, 
                        reset_token = NULL, 
                        reset_token_expiry = NULL 
                    WHERE id = :id'
                );
                $result = $stmt->execute([
                    'contrasena' => $hashedPassword,
                    'id' => $usuarioId
                ]);
                
                $this->db->commit();
                return $result;
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Error en actualizarContrasena: " . $e->getMessage());
                return false;
            }
        }
        
        public function eliminarTokenRecuperacion(int $usuarioId): bool {
            try {
                $stmt = $this->db->prepare(
                    'UPDATE personal_administrativo 
                    SET reset_token = NULL, 
                        reset_token_expiry = NULL 
                    WHERE id = :id'
                );
                return $stmt->execute(['id' => $usuarioId]);
            } catch (PDOException $e) {
                error_log("Error en eliminarTokenRecuperacion: " . $e->getMessage());
                return false;
            }
        }
        
    }
?>
