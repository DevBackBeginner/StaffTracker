<?php
    require_once '../config/DataBase.php';

    class RegistrarGuardasModelo {
        private $db;

        public function __construct() {
            // Crear una instancia de la clase DataBase para obtener la conexión
            $conn = new DataBase();
            // Asignar la conexión establecida a la propiedad $db
            $this->db = $conn->getConnection();        
        }

        public function registrarGuarda($nombre, $apellidos, $telefono, $numero_identidad, $correo, $passwordHash, $foto_perfil) {
            try {
                // Inicia la transacción
                $this->db->beginTransaction();
        
                // Inserta datos en la tabla "usuarios"
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios (nombre, apellidos, telefono, numero_identidad, rol)
                    VALUES (:nombre, :apellidos, :telefono, :numero_identidad, :rol)
                ");
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'telefono' => $telefono,
                    'numero_identidad' => $numero_identidad,
                    'rol' => 'guarda',
                ]);
        
                // Obtiene el ID generado
                $usuario_id = $this->db->lastInsertId();
        
                // Inserta datos en la tabla "usuarios_autenticados"
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios_autenticados (usuario_id, correo, contrasena, foto_perfil)
                    VALUES (:usuario_id, :correo, :contrasena, :foto_perfil)
                ");
                $stmt->execute([
                    'usuario_id' => $usuario_id,
                    'correo' => $correo,
                    'contrasena' => $passwordHash,
                    'foto_perfil' => $foto_perfil,
                ]);
        
                // Confirma la transacción
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                // Revierte la transacción en caso de error
                $this->db->rollBack();
                throw $e; // Lanza la excepción para manejarla en el controlador
            }
        }
    }
?>