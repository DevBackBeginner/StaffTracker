<?php

    require_once '../config/DataBase.php';

    class PersonalModelo
    {
        private $db;
        
        public function __construct()
        {
            $conn = new DataBase;
            
            $this->db = $conn->getConnection();
        }

        public function registrarPersona($nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $rol) {
            $stmt = $this->db->prepare("INSERT INTO personas (nombre, apellido, tipo_documento, numero_documento, telefono, rol) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $rol]);
            return $this->db->lastInsertId();
        }

        public function registrarInformacionLaboral($persona_id, $cargo, $tipo_contrato) {
            $stmt = $this->db->prepare("INSERT INTO informacion_laboral (persona_id, cargo, tipo_contrato)VALUES (?, ?, ?)");
            return $stmt->execute([$persona_id, $cargo, $tipo_contrato]);
        }

        public function obtenerPersonas($pagina = 1, $limite = 10, $filtros = [], $orden = 'nombre', $direccion = 'ASC')
        {
            $offset = ($pagina - 1) * $limite;
            
            $sql = "SELECT p.*, il.cargo, il.tipo_contrato 
                    FROM personas p
                    LEFT JOIN informacion_laboral il ON p.id_persona = il.persona_id
                    WHERE p.rol IN ('Instructor', 'Funcionario', 'Directivo')"; // Filtro fijo para los roles
            
            // Aplicar filtros adicionales
            if (!empty($filtros['rol'])) {
                $sql .= " AND p.rol = :rol"; // Filtro adicional si se especifica un rol
            }
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND p.numero_documento LIKE :documento";
            }
            
            // Validar orden
            $columnasPermitidas = ['nombre', 'apellido', 'numero_documento', 'rol', 'cargo'];
            $orden = in_array($orden, $columnasPermitidas) ? $orden : 'nombre';
            $direccion = strtoupper($direccion) === 'DESC' ? 'DESC' : 'ASC';
            
            $sql .= " ORDER BY $orden $direccion";
            $sql .= " LIMIT :limite OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            
            // Bind de parámetros
            if (!empty($filtros['rol'])) {
                $stmt->bindValue(':rol', $filtros['rol'], PDO::PARAM_STR);
            }
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', '%' . $filtros['nombre'] . '%', PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', '%' . $filtros['documento'] . '%', PDO::PARAM_STR);
            }
            
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarPersonas($filtros = [])
        {
            $sql = "SELECT COUNT(*) as total 
                    FROM personas p
                    LEFT JOIN informacion_laboral il ON p.id_persona = il.persona_id
                    WHERE p.rol IN ('Instructor', 'Funcionario', 'Directivo')"; // Filtro fijo para los roles
            
            // Aplicar filtros adicionales
            if (!empty($filtros['rol'])) {
                $sql .= " AND p.rol = :rol"; // Filtro adicional si se especifica un rol
            }
            if (!empty($filtros['nombre'])) {
                $sql .= " AND (p.nombre LIKE :nombre OR p.apellido LIKE :nombre)";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND p.numero_documento LIKE :documento";
            }
            
            $stmt = $this->db->prepare($sql);
            
            // Bind de parámetros
            if (!empty($filtros['rol'])) {
                $stmt->bindValue(':rol', $filtros['rol'], PDO::PARAM_STR);
            }
            if (!empty($filtros['nombre'])) {
                $stmt->bindValue(':nombre', '%' . $filtros['nombre'] . '%', PDO::PARAM_STR);
            }
            if (!empty($filtros['documento'])) {
                $stmt->bindValue(':documento', '%' . $filtros['documento'] . '%', PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }


        public function actualizarUsuario($id_persona, $nombre, $apellido, $tipo_documento, $numero_documento, $rol, $telefono, $datosLaborales)
        {
            try {
                // Validar campos obligatorios
                if (empty($id_persona) || empty($nombre) || empty($apellido) || empty($numero_documento) || empty($rol)) {
                    throw new Exception("Datos básicos del usuario incompletos");
                }

                if (!isset($datosLaborales['cargo'])) {
                    throw new Exception("El campo 'cargo' es obligatorio");
                }

                // Iniciar transacción
                $this->db->beginTransaction();

                // Actualizar datos básicos en tabla personas
                $sqlPersona = "UPDATE personas SET 
                            nombre = :nombre, 
                            apellido = :apellido, 
                            tipo_documento = :tipo_documento,
                            numero_documento = :numero_documento, 
                            rol = :rol, 
                            telefono = :telefono 
                            WHERE id_persona = :id_persona";
                
                $stmtPersona = $this->db->prepare($sqlPersona);
                $stmtPersona->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':tipo_documento' => $tipo_documento,
                    ':numero_documento' => $numero_documento,
                    ':rol' => $rol,
                    ':telefono' => $telefono,
                    ':id_persona' => $id_persona
                ]);

                // Actualizar o insertar en informacion_laboral
                $sqlCheck = "SELECT COUNT(*) FROM informacion_laboral WHERE persona_id = :id_persona";
                $stmtCheck = $this->db->prepare($sqlCheck);
                $stmtCheck->execute([':id_persona' => $id_persona]);
                $existeRegistro = $stmtCheck->fetchColumn() > 0;

                if ($existeRegistro) {
                    // Actualizar registro existente
                    $sqlLaboral = "UPDATE informacion_laboral SET 
                                cargo = :cargo, 
                                tipo_contrato = :tipo_contrato 
                                WHERE persona_id = :persona_id";
                } else {
                    // Insertar nuevo registro
                    $sqlLaboral = "INSERT INTO informacion_laboral 
                                (persona_id, cargo, tipo_contrato) 
                                VALUES 
                                (:persona_id, :cargo, :tipo_contrato)";
                }

                $stmtLaboral = $this->db->prepare($sqlLaboral);
                $stmtLaboral->execute([
                    ':persona_id' => $id_persona,
                    ':cargo' => $datosLaborales['cargo'],
                    ':tipo_contrato' => $datosLaborales['tipo_contrato'] ?? 'Planta' // Valor por defecto
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