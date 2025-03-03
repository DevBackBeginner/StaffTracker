<?php 

    require_once '../config/DataBase.php';

    class LoginModel{
        private $db;

        public function __construct (){
            $conn = new DataBase();
            // Obtener la conexión y asignarla a la variable $db
            $this->db = $conn->getConnection();        
        }

        public function buscarPorCorreo($correo) {
            $stmt = $this->db->prepare("
                SELECT ua.*, u.nombre, u.numero_identidad 
                FROM usuarios_autenticados ua
                JOIN usuarios u ON ua.usuario_id = u.id
                WHERE ua.correo = :correo
            ");
            $stmt->execute(['correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
    
        /**
         * Verifica la contraseña ingresada contra el hash almacenado.
         * @param string $passwordInput
         * @param string $passwordHasheado
         * @return bool
         */
        public function verificarPassword($passwordInput, $passwordHasheado) {
            return password_verify($passwordInput, $passwordHasheado);
        }
        
        
    }
?>
