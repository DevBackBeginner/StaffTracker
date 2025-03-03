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
            $stmt = $this->db->prepare("SELECT * FROM usuarios_autenticados WHERE correo = :correo LIMIT 1");
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
