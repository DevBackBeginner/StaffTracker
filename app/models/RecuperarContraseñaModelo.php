<?php
require_once '../config/DataBase.php';

class RecuperarContraseñaModelo {
    private $db;
    private const PASSWORD_ALGORITHM = PASSWORD_BCRYPT;
    private const TOKEN_EXPIRATION = '+1 hour';
    private const DB_TIMEOUT = 30; // 30 segundos de timeout

    public function __construct() {
        $conn = new DataBase();
        $this->db = $conn->getConnection();
        // Configurar timeout para la conexión
        $this->db->setAttribute(PDO::ATTR_TIMEOUT, self::DB_TIMEOUT);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        date_default_timezone_set('America/Bogota'); // Cambia por tu zona horaria

    }

    public function buscarPorCorreo(string $correo): ?array {
        try {
            $sql = "SELECT ua.*, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol
                    FROM usuarios_autenticados ua
                    JOIN usuarios u ON ua.usuario_id = u.id
                    WHERE ua.correo = :correo
                    LIMIT 1"; // Añadido LIMIT para optimización
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error en buscarPorCorreo: " . $e->getMessage());
            return null;
        }
    }

    public function guardarTokenRecuperacion(int $usuarioId, string $token, ?string $expiry = null): bool {
        $this->db->beginTransaction(); // Iniciar transacción
        try {
            $expiry = $expiry ?? date('Y-m-d H:i:s', strtotime(self::TOKEN_EXPIRATION));
            
            // Primero eliminamos cualquier token existente
            $stmt = $this->db->prepare(
                'UPDATE usuarios_autenticados 
                SET reset_token = NULL, 
                    reset_token_expiry = NULL 
                WHERE id = :id'
            );
            $stmt->execute(['id' => $usuarioId]);
            
            // Luego guardamos el nuevo token
            $stmt = $this->db->prepare(
                'UPDATE usuarios_autenticados 
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
                'SELECT ua.*, u.nombre, u.apellidos 
                FROM usuarios_autenticados ua
                JOIN usuarios u ON ua.usuario_id = u.id
                WHERE reset_token = :token 
                AND reset_token_expiry > NOW()
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
            $stmt = $this->db->prepare('SELECT id FROM usuarios_autenticados WHERE id = :id');
            $stmt->execute(['id' => $usuarioId]);
            if (!$stmt->fetch()) {
                return false;
            }

            $hashedPassword = password_hash($contrasena, self::PASSWORD_ALGORITHM);
            $stmt = $this->db->prepare(
                'UPDATE usuarios_autenticados 
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
                'UPDATE usuarios_autenticados 
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