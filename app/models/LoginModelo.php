<?php 

    require_once '../config/DataBase.php';

    class LoginModel{
        private $db;

        public function __construct (){
            $conn = new DataBase();
            // Obtener la conexión y asignarla a la variable $db
            $this->db = $conn->getConnection();        
        }

        public function obtenerPorCorreo($correo) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM porteros WHERE correo = :correo");
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el portero o `false`
            } catch (PDOException $e) {
                // Manejar el error según tus necesidades
                error_log("Error en la consulta: " . $e->getMessage());
                return false; // Opcional: devuelve `false` o lanza una excepción
            }
        }
        
        
    }
?>
