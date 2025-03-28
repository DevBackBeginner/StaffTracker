<?php

    require_once '../config/DataBase.php';

    class GestionPersonalModelo
    {
        private $db;
        
        public function __construct()
        {
            $conn = new DataBase;
            
            $this->db = $conn->getConnection();
        }

        public function registrarUsuario($nombre, $apellido, $tipo_documento, $numero_identidad, $telefono, $rol, $datosLaborales)
        {
            try {
                // Validar campos obligatorios
                if (empty($nombre) || empty($apellido) || empty($tipo_documento) || empty($numero_identidad) || empty($rol)) {
                    throw new Exception("Datos básicos del usuario incompletos");
                }

                if (!isset($datosLaborales['cargo'])) {
                    throw new Exception("El campo 'cargo' es obligatorio");
                }

                // Validar tipo de documento
                $tiposPermitidos = ['CC', 'CE', 'TI', 'PA', 'NIT', 'OTRO'];
                if (!in_array($tipo_documento, $tiposPermitidos)) {
                    throw new Exception("Tipo de documento no válido");
                }

                // Iniciar transacción
                $this->db->beginTransaction();

                // 1. Insertar en tabla usuarios (con tipo_documento)
                $sqlUsuario = "INSERT INTO usuarios 
                            (nombre, apellidos, tipo_documento, numero_identidad, telefono, rol) 
                            VALUES 
                            (:nombre, :apellido, :tipo_documento, :numero_identidad, :telefono, :rol)";
                
                $stmtUsuario = $this->db->prepare($sqlUsuario);
                $stmtUsuario->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':tipo_documento' => $tipo_documento,
                    ':numero_identidad' => $numero_identidad,
                    ':telefono' => $telefono,
                    ':rol' => $rol
                ]);

                $usuario_id = $this->db->lastInsertId();

                // 2. Insertar en informacion_laboral
                $sqlLaboral = "INSERT INTO informacion_laboral 
                            (usuario_id, cargo, tipo_contrato) 
                            VALUES 
                            (:usuario_id, :cargo, :tipo_contrato)";
                
                $stmtLaboral = $this->db->prepare($sqlLaboral);
                $stmtLaboral->execute([
                    ':usuario_id' => $usuario_id,
                    ':cargo' => $datosLaborales['cargo'],
                    ':tipo_contrato' => $datosLaborales['tipo_contrato'] ?? null
                ]);

                // Confirmar transacción
                $this->db->commit();

                return $usuario_id;

            } catch (Exception $e) {
                // Revertir en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                error_log("Error al registrar usuario: " . $e->getMessage());
                return false;
            }
        }

        public function obtenerUsuarios($pagina = 1, $limite = 10, $filtros = [], $orden = 'nombre', $direccion = 'ASC')
        {
            // Calcular el offset
            $offset = ($pagina - 1) * $limite;

            // Construir la consulta SQL simplificada
            $sql = "SELECT 
                        u.*,
                        il.cargo,
                        il.tipo_contrato
                    FROM usuarios u
                    LEFT JOIN informacion_laboral il ON u.id = il.usuario_id
                    WHERE 1=1";

            // Aplicar filtros
            if (!empty($filtros['rol'])) {
                $sql .= " AND u.rol = :rol";
            }
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (u.nombre LIKE :nombre OR u.apellidos LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND u.numero_identidad LIKE :documento";
            }
            if (!empty($filtros['cargo'])) {
                $sql .= " AND il.cargo LIKE :cargo";
            }
            if (!empty($filtros['tipo_contrato'])) {
                $sql .= " AND il.tipo_contrato = :tipo_contrato";
            }

            // Aplicar ordenamiento
            $sql .= " ORDER BY $orden $direccion";

            // Aplicar paginación
            $sql .= " LIMIT :limite OFFSET :offset";

            // Preparar y ejecutar la consulta
            $stmt = $this->db->prepare($sql);

            // Bind de parámetros
            if (!empty($filtros['rol'])) {
                $stmt->bindValue(':rol', $filtros['rol'], PDO::PARAM_STR);
            }
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', "%{$filtros['nombre']}%", PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', "%{$filtros['documento']}%", PDO::PARAM_STR);
            }
            if (!empty($filtros['cargo'])) {
                $stmt->bindValue(':cargo', "%{$filtros['cargo']}%", PDO::PARAM_STR);
            }
            if (!empty($filtros['tipo_contrato'])) {
                $stmt->bindValue(':tipo_contrato', $filtros['tipo_contrato'], PDO::PARAM_STR);
            }
            
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarUsuarios($filtros = [])
        {
            // Construir la consulta SQL para contar
            $sql = "SELECT COUNT(*) as total FROM usuarios WHERE 1=1";

            // Aplicar filtros
            if (!empty($filtros['rol'])) {
                $sql .= " AND rol = :rol";
            }
            if (!empty($filtros['nombre'])) {
                $sql .= " AND nombre LIKE :nombre";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND numero_identidad LIKE :documento";
            }

            // Preparar y ejecutar la consulta
            $stmt = $this->db->prepare($sql);

            // Bind de parámetros
            if (!empty($filtros['rol'])) {
                $stmt->bindValue(':rol', $filtros['rol'], PDO::PARAM_STR);
            }
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', "%{$filtros['nombre']}%", PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', "%{$filtros['documento']}%", PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function actualizarUsuario($id, $nombre, $apellido, $documento, $rol, $telefono, $datosLaborales)
        {
            try {
                // Validar campos obligatorios
                if (empty($id) || empty($nombre) || empty($apellido) || empty($documento) || empty($rol)) {
                    throw new Exception("Datos básicos del usuario incompletos");
                }

                if (!isset($datosLaborales['cargo'])) {
                    throw new Exception("El campo 'cargo' es obligatorio");
                }

                // Iniciar transacción
                $this->db->beginTransaction();

                // 1. Actualizar datos básicos en tabla usuarios
                $sqlUsuario = "UPDATE usuarios SET 
                            nombre = :nombre, 
                            apellidos = :apellido, 
                            numero_identidad = :documento, 
                            rol = :rol, 
                            telefono = :telefono 
                            WHERE id = :id";
                
                $stmtUsuario = $this->db->prepare($sqlUsuario);
                $stmtUsuario->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':documento' => $documento,
                    ':rol' => $rol,
                    ':telefono' => $telefono,
                    ':id' => $id
                ]);

                // 2. Actualizar o insertar en informacion_laboral
                $sqlCheck = "SELECT COUNT(*) FROM informacion_laboral WHERE usuario_id = :id";
                $stmtCheck = $this->db->prepare($sqlCheck);
                $stmtCheck->execute([':id' => $id]);
                $existeRegistro = $stmtCheck->fetchColumn() > 0;

                if ($existeRegistro) {
                    // Actualizar registro existente
                    $sqlLaboral = "UPDATE informacion_laboral SET 
                                cargo = :cargo, 
                                tipo_contrato = :tipo_contrato 
                                WHERE usuario_id = :usuario_id";
                } else {
                    // Insertar nuevo registro
                    $sqlLaboral = "INSERT INTO informacion_laboral 
                                (usuario_id, cargo, tipo_contrato) 
                                VALUES 
                                (:usuario_id, :cargo, :tipo_contrato)";
                }

                $stmtLaboral = $this->db->prepare($sqlLaboral);
                $stmtLaboral->execute([
                    ':usuario_id' => $id,
                    ':cargo' => $datosLaborales['cargo'],
                    ':tipo_contrato' => $datosLaborales['tipo_contrato'] ?? null
                ]);

                // Confirmar transacción
                $this->db->commit();

                return true;

            } catch (Exception $e) {
                // Revertir en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                error_log("Error en actualizarUsuario: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Elimina un usuario de la base de datos.
         *
         * @param int $id El ID del usuario a eliminar.
         * @return bool Retorna true si el usuario fue eliminado, false en caso contrario.
         */
        public function eliminar_Usuario($id)
        {
            try {
                // Preparar la consulta SQL para eliminar el usuario
                $query = 'DELETE FROM usuarios WHERE id = :id';
                $stmt = $this->db->prepare($query);

                // Vincular el parámetro :id
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();

                // Verificar si se eliminó alguna fila
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                // Registrar el error (opcional)
                error_log("Error al eliminar usuario: " . $e->getMessage());
                return false;
            }
        }
    }
?>