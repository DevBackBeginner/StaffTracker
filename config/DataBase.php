<?php
class DataBase {
    private $host = "localhost";
    private $db = "control_entrada_salida";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function __construct() {
        try {
            // Establecer la conexión con PDO
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->pass);
            // Configurar PDO para lanzar excepciones en caso de error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Manejo de errores de conexión
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Obtener la conexión PDO
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Cerrar la conexión (aunque PDO la cierra automáticamente al final del script)
     */
    public function close() {
        $this->conn = null;
    }
}
?>
