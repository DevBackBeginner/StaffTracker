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

        public function registrarGuarda($nombre, $apellidos, $tipo_documento, $telefono, $numero_identidad, $correo, $passwordHash, $foto_perfil) {
            try {
                // Validar tipo de documento
                $tiposPermitidos = ['CC', 'CE', 'TI', 'PA', 'NIT', 'OTRO'];
                if (!in_array($tipo_documento, $tiposPermitidos)) {
                    throw new Exception("Tipo de documento no válido");
                }
        
                // Inicia la transacción
                $this->db->beginTransaction();
        
                // Inserta datos en la tabla "usuarios" (con tipo_documento)
                $stmt = $this->db->prepare("
                    INSERT INTO usuarios (nombre, apellidos, tipo_documento, telefono, numero_identidad, rol)
                    VALUES (:nombre, :apellidos, :tipo_documento, :telefono, :numero_identidad, :rol)
                ");
                $stmt->execute([
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'tipo_documento' => $tipo_documento,
                    'telefono' => $telefono,
                    'numero_identidad' => $numero_identidad,
                    'rol' => 'guarda'
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
                    'foto_perfil' => $foto_perfil
                ]);
        
                // Confirma la transacción
                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                // Revierte la transacción en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                
                // Manejo específico de errores de duplicidad
                if ($e->getCode() == 23000) { // Código de error para violación de restricción única
                    if (strpos($e->getMessage(), 'numero_identidad') !== false) {
                        throw new Exception("El número de documento ya está registrado");
                    } elseif (strpos($e->getMessage(), 'correo') !== false) {
                        throw new Exception("El correo electrónico ya está registrado");
                    }
                }
                
                throw new Exception("Error al registrar el guarda: " . $e->getMessage());
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                throw $e;
            }
        }
    }
?>