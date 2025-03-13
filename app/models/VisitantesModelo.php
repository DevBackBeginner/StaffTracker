<?php
    require_once '../config/DataBase.php';

    class VisitantesModelo
    {
        private $db;

        public function __construct()
        {
            $conn = new DataBase();

            $this->db = $conn->getConnection();
        }

        public function registroVisitante($nombre, $apellido, $numero_identidad, $telefono, $asunto, $rol)
        {
            // Iniciar una transacción para asegurar la atomicidad de las operaciones
            $this->db->beginTransaction();

            try {
                $queryUsuario = "INSERT INTO usuarios (nombre, apellidos, numero_identidad, telefono, rol) 
                                VALUES (:nombre, :apellido, :numero_identidad, :telefono, :rol)";
                $stmtUsuario = $this->db->prepare($queryUsuario);
                $stmtUsuario->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':numero_identidad' => $numero_identidad,
                    ':telefono' => $telefono,
                    ':rol' => $rol
                ]);

                // Obtener el ID del usuario recién insertado
                $usuarioId = $this->db->lastInsertId();

                $queryVisitante = "INSERT INTO visitantes (usuario_id, asunto) 
                                VALUES (:usuario_id, :asunto)";
                $stmtVisitante = $this->db->prepare($queryVisitante);
                $stmtVisitante->execute([
                    ':usuario_id' => $usuarioId,
                    ':asunto' => $asunto
                ]);

                // Confirmar la transacción si todo está bien
                $this->db->commit();

                return true; // Éxito
            } catch (PDOException $e) {
                // Si hay un error, revertir la transacción
                $this->db->rollBack();
                error_log("Error en registroVisitante: " . $e->getMessage()); // Log del error
                return false; // Fallo
            }
        }
    }
?>