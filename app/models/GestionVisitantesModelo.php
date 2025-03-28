<?php
    require_once '../config/DataBase.php';

    class GestionVisitantesModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();

            $this->db = $conn->getConnection();
        }

        public function registroVisitante($nombre, $apellido, $tipo_documento, $numero_identidad, $telefono, $asunto, $rol)
        {
            // Iniciar una transacción
            $this->db->beginTransaction();

            try {
                // 1. Insertar en la tabla `usuarios` (sin asunto)
                $queryUsuario = "INSERT INTO usuarios (nombre, apellidos, tipo_documento, numero_identidad, telefono, rol) 
                                VALUES (:nombre, :apellido, :tipo_documento, :numero_identidad, :telefono, :rol)";
                $stmtUsuario = $this->db->prepare($queryUsuario);
                $stmtUsuario->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':tipo_documento' => $tipo_documento,
                    ':numero_identidad' => $numero_identidad,
                    ':telefono' => $telefono,
                    ':rol' => $rol
                ]);

                // Obtener el ID del usuario
                $usuarioId = $this->db->lastInsertId();

                // 2. Insertar en la tabla `visitantes` con el asunto
                $queryVisitante = "INSERT INTO visitantes (usuario_id, asunto) 
                                VALUES (:usuario_id, :asunto)";
                $stmtVisitante = $this->db->prepare($queryVisitante);
                $stmtVisitante->execute([
                    ':usuario_id' => $usuarioId,
                    ':asunto' => $asunto
                ]);

                // Confirmar la transacción
                $this->db->commit();
                return $usuarioId;

            } catch (PDOException $e) {
                // Revertir en caso de error
                $this->db->rollBack();
                
                // Manejar errores específicos
                if ($e->getCode() == 23000) {
                    if (strpos($e->getMessage(), 'numero_identidad') !== false) {
                        throw new Exception("El número de documento ya está registrado");
                    }
                    throw new Exception("Error de duplicidad en la base de datos");
                }
                
                error_log("Error en registroVisitante: " . $e->getMessage());
                throw new Exception("Error al registrar el visitante: " . $e->getMessage());
            }
        }
    }
?>