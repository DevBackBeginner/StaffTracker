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
            $sql = "SELECT  ua.*,
                            u.nombre, u.numero_identidad
                    FROM usuarios_autenticados ua
                    JOIN usuarios u ON ua.usuario_id = u.id
                    WHERE ua.correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR_CHAR);
            $stmt->execute(['correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function obtenerPorIdentidad($numero_identidad) {
            $sql = "SELECT * FROM usuarios WHERE numero_identidad = :codigo LIMIT 1"; // Verifica que 'codigo' sea la columna correcta
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $numero_identidad, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
    }
?>
