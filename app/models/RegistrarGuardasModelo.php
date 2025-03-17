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

        public function registrarGuarda($nombre, $apellidos, $telefono, $numero_identidad, $correo, $passwordHash, $turno, $foto_perfil) {
            try {
                // Inicia la transacción
                $this->db->beginTransaction();
        
                // Inserta datos en la tabla "usuarios" (incluyendo apellidos y teléfono)
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios (nombre, apellidos, telefono, numero_identidad, rol)
                    VALUES (:nombre, :apellidos, :telefono, :numero_identidad, :rol)
                    
                ");
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellidos' => $apellidos, 
                    'telefono' => $telefono,    // Agregar teléfono
                    'numero_identidad' => $numero_identidad,
                    'rol' => 'guarda',
                ]);
        
                // Obtiene el ID generado
                $usuario_id = $this->db->lastInsertId();
        
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios_autenticados (usuario_id, correo, contrasena,  foto_perfil)
                    VALUES (:usuario_id, :correo, :contrasena, :foto_perfil)
                ");
                
                $stmt->execute([
                    'usuario_id' => $usuario_id,
                    'correo'     => $correo,
                    'contrasena'   => $passwordHash,
                    'foto_perfil' => $foto_perfil
                ]);
        
                // Inserta el turno en la tabla "guardas"
                $stmt = $this->db->prepare("
                    INSERT INTO guardas (usuario_id, turno)
                    VALUES (:usuario_id, :turno)
                ");
                $stmt->execute([
                    'usuario_id' => $usuario_id,
                    'turno'      => $turno
                ]);
        
                // Confirma la transacción
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                // Revierte la transacción en caso de error
                $this->db->rollBack();
                throw $e;
            }
        }
        
    }
?>