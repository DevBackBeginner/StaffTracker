<?php
require_once '../config/DataBase.php';

class RecuperarContraseñaModelo {
    private $db;
    private const PASSWORD_ALGORITHM = PASSWORD_BCRYPT; // Algoritmo de cifrado

    public function __construct() {
        $conn = new DataBase();
        $this->db = $conn->getConnection();
    }

    /**
     * Busca un usuario por su correo electrónico.
     *
     * @param string $correo El correo electrónico del usuario.
     * @return array|false Retorna los datos del usuario o false si no se encuentra.
     */
    public function buscarPorCorreo($correo) {
        try {
            $sql = "SELECT  ua.*,
                            u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol
                    FROM usuarios_autenticados ua
                    JOIN usuarios u ON ua.usuario_id = u.id
                    WHERE ua.correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en buscarPorCorreo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Guarda el token de recuperación y su fecha de expiración.
     *
     * @param int $usuarioId El ID del usuario.
     * @param string $token El token de recuperación.
     * @param string $expiry La fecha de expiración del token.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     */
    public function guardarTokenRecuperacion($usuarioId, $token, $expiry) {
        try {
            $stmt = $this->db->prepare('UPDATE usuarios_autenticados SET reset_token = :token, reset_token_expiry = :expiry WHERE id = :id');
            return $stmt->execute(['token' => $token, 'expiry' => $expiry, 'id' => $usuarioId]);
        } catch (PDOException $e) {
            error_log("Error en guardarTokenRecuperacion: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca un usuario por su token de recuperación.
     *
     * @param string $token El token de recuperación.
     * @return array|false Retorna los datos del usuario o false si no se encuentra.
     */
    public function buscarPorToken($token) {
        if (empty($token)) {
            return false;
        }

        try {
            $stmt = $this->db->prepare('SELECT * FROM usuarios_autenticados WHERE reset_token = :token AND reset_token_expiry > NOW()');
            $stmt->execute(['token' => $token]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en buscarPorToken: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza la contraseña de un usuario.
     *
     * @param int $usuarioId El ID del usuario.
     * @param string $contrasena La nueva contraseña.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     */
    public function actualizarContrasena($usuarioId, $contrasena) {
        if (empty($contrasena)) {
            return false;
        }

        try {
            $hashedPassword = password_hash($contrasena, self::PASSWORD_ALGORITHM);
            $stmt = $this->db->prepare('UPDATE usuarios_autenticados SET contrasena = :contrasena WHERE id = :id');
            return $stmt->execute(['contrasena' => $hashedPassword, 'id' => $usuarioId]);
        } catch (PDOException $e) {
            error_log("Error en actualizarContrasena: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina el token de recuperación de un usuario.
     *
     * @param int $usuarioId El ID del usuario.
     * @return bool Retorna true si la operación fue exitosa, false en caso contrario.
     */
    public function eliminarTokenRecuperacion($usuarioId) {
        try {
            $stmt = $this->db->prepare('UPDATE usuarios_autenticados SET reset_token = NULL, reset_token_expiry = NULL WHERE id = :id');
            return $stmt->execute(['id' => $usuarioId]);
        } catch (PDOException $e) {
            error_log("Error en eliminarTokenRecuperacion: " . $e->getMessage());
            return false;
        }
    }
}
?>