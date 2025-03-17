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

        public function registrarUsuario($nombre, $apellido, $telefono, $numero_identidad, $rol, $datosAdicionales)
        {
            try {

                // Iniciar una transacción
                $this->db->beginTransaction();

                // Insertar en la tabla de usuarios (tabla común)
                $sqlUsuario = "INSERT INTO usuarios (nombre, apellidos, telefono, numero_identidad, rol) 
                            VALUES (:nombre, :apellido, :telefono, :numero_identidad, :rol)";
                $stmtUsuario = $this->db->prepare($sqlUsuario);
                $stmtUsuario->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':telefono' => $telefono,
                    ':numero_identidad' => $numero_identidad,
                    ':rol' => $rol
                ]);

                // Obtener el ID del usuario recién insertado
                $usuario_id = $this->db->lastInsertId();

                // Insertar en la tabla correspondiente según el rol
                switch ($rol) {
                    case 'Funcionario':
                        $tabla = 'funcionarios';
                        $campos = ['area' => $datosAdicionales['area'], 'puesto' => $datosAdicionales['puesto']];
                        break;
                    case 'Instructor':
                        $tabla = 'instructores';
                        $campos = ['curso' => $datosAdicionales['curso'], 'ubicacion' => $datosAdicionales['ubicacion']];
                        break;
                    case 'Directiva':
                        $tabla = 'directivos';
                        $campos = ['cargo' => $datosAdicionales['cargo'], 'departamento' => $datosAdicionales['departamento']];
                        break;
                    case 'Apoyo':
                        $tabla = 'apoyo';
                        $campos = ['area_trabajo' => $datosAdicionales['area_trabajo']];
                        break;
                    default:
                        throw new Exception("Rol no válido: $rol");
                }

                // Construir la consulta SQL dinámicamente
                $columnas = implode(', ', array_keys($campos));
                $placeholders = ':' . implode(', :', array_keys($campos));

                $sql = "INSERT INTO $tabla (usuario_id, $columnas) VALUES (:usuario_id, $placeholders)";
                $stmt = $this->db->prepare($sql);

                // Asignar los valores a los parámetros
                $params = [':usuario_id' => $usuario_id];
                foreach ($campos as $campo => $valor) {
                    $params[":$campo"] = $valor;
                }

                // Ejecutar la consulta
                $stmt->execute($params);

                // Confirmar la transacción
                $this->db->commit();

                // Devolver el ID del usuario registrado
                return $usuario_id;
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                // Registrar el error
                error_log("Error al registrar usuario: " . $e->getMessage());
                return false;
            }
        }

        public function obtenerUsuarios($pagina = 1, $limite = 10, $filtros = [], $orden = 'nombre', $direccion = 'ASC')
        {
            // Calcular el offset
            $offset = ($pagina - 1) * $limite;

            // Construir la consulta SQL con JOIN
            $sql = "SELECT u.id, u.nombre, u.apellidos, u.telefono, u.numero_identidad, u.rol, 
                        i.curso, i.ubicacion, 
                        f.area, f.puesto, 
                        d.cargo, d.departamento, 
                        a.area_trabajo, 
                        v.asunto
                    FROM usuarios u
                    LEFT JOIN instructores i ON u.id = i.usuario_id AND u.rol = 'Instructor'
                    LEFT JOIN funcionarios f ON u.id = f.usuario_id AND u.rol = 'Funcionario'
                    LEFT JOIN directivos d ON u.id = d.usuario_id AND u.rol = 'Directivo'
                    LEFT JOIN apoyo a ON u.id = a.usuario_id AND u.rol = 'Apoyo'
                    LEFT JOIN visitantes v ON u.id = v.usuario_id AND u.rol = 'Visitante'
                    WHERE 1=1";

            // Aplicar filtros
            if (!empty($filtros['rol'])) {
                $sql .= " AND u.rol = :rol";
            }
            if (!empty($filtros['nombre'])) {
                $sql .= " AND u.nombre LIKE :nombre";
            }
            if (!empty($filtros['documento'])) {
                $sql .= " AND u.numero_identidad LIKE :documento";
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

        public function actualizarUsuario($id, $nombre, $apellido, $documento, $rol, $telefono, $infoAdicional)
        {
            try {
                // Validar que el ID y la información adicional no estén vacíos
                if (empty($id) || empty($infoAdicional)) {
                    throw new Exception("El ID o la información adicional están vacíos.");
                }
        
                // Obtener el rol actual del usuario
                $query = "SELECT rol FROM usuarios WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id]);
                $rolActual = $stmt->fetchColumn();
        
                // Si el rol ha cambiado, eliminar la información del rol anterior
                if ($rolActual !== $rol) {
                    $this->eliminarInformacionRol($id, $rolActual);
                }
        
                // Actualizar los datos comunes en la tabla de usuarios
                $queryUpdate = "UPDATE usuarios SET nombre = ?, apellidos = ?, numero_identidad = ?, rol = ?, telefono = ? WHERE id = ?";
                $stmtUpdate = $this->db->prepare($queryUpdate);
                $stmtUpdate->execute([$nombre, $apellido, $documento, $rol, $telefono, $id]);
        
                // Insertar o actualizar la información adicional del nuevo rol
                $configuracionRoles = [
                    'Instructor'  => ['tabla' => 'instructores',  'campos' => ['curso', 'ubicacion']],
                    'Funcionario' => ['tabla' => 'funcionarios', 'campos' => ['area', 'puesto']],
                    'Directivo'   => ['tabla' => 'directivos',   'campos' => ['cargo', 'departamento']],
                    'Apoyo'       => ['tabla' => 'apoyo',       'campos' => ['area_trabajo']],
                    'Visitante'   => ['tabla' => 'visitantes',   'campos' => ['asunto']],
                ];
        
                // Verificar si el rol es válido
                if (!isset($configuracionRoles[$rol])) {
                    throw new Exception("Rol no válido: $rol");
                }
        
                // Obtener la tabla y los campos según el rol
                $tabla = $configuracionRoles[$rol]['tabla'];
                $campos = $configuracionRoles[$rol]['campos'];
        
                // Verificar si ya existe un registro para este usuario_id
                $queryCheck = "SELECT COUNT(*) FROM $tabla WHERE usuario_id = ?";
                $stmtCheck = $this->db->prepare($queryCheck);
                $stmtCheck->execute([$id]);
                $existe = $stmtCheck->fetchColumn() > 0;
        
                // Construir la consulta SQL (UPDATE o INSERT)
                if ($existe) {
                    $camposUpdate = implode(' = ?, ', $campos) . ' = ?';
                    $query = "UPDATE $tabla SET $camposUpdate WHERE usuario_id = ?";
                } else {
                    $camposInsert = implode(', ', $campos);
                    $placeholders = implode(', ', array_fill(0, count($campos), '?'));
                    $query = "INSERT INTO $tabla (usuario_id, $camposInsert) VALUES (?, $placeholders)";
                }
        
                // Preparar y ejecutar la consulta
                $stmt = $this->db->prepare($query);
        
                // Construir los valores para la consulta
                $valores = [];
                foreach ($campos as $campo) {
                    if (!isset($infoAdicional[$campo])) {
                        throw new Exception("El campo '$campo' no está presente en la información adicional.");
                    }
                    $valores[] = $infoAdicional[$campo];
                }
        
                // Ordenar los valores según el tipo de consulta (UPDATE o INSERT)
                if ($existe) {
                    $valores[] = $id; // Para UPDATE: valores + usuario_id
                } else {
                    array_unshift($valores, $id); // Para INSERT: usuario_id + valores
                }
        
                // Ejecutar la consulta
                $stmt->execute($valores);
        
                return true; // Indicar que la operación fue exitosa
            } catch (Exception $e) {
                // Registrar el error
                error_log("Error en actualizarUsuario: " . $e->getMessage());
        
                // Retornar false para indicar que la operación falló
                return false;
            }
        }

        public function EliminarUsuario($id)
        {
            try {
                // Iniciar una transacción (para asegurar la integridad de los datos)
                $this->db->beginTransaction();

                // Obtener el rol del usuario antes de eliminarlo
                $queryRol = "SELECT rol FROM usuarios WHERE id = ?";
                $stmtRol = $this->db->prepare($queryRol);
                $stmtRol->execute([$id]);
                $rol = $stmtRol->fetchColumn();

                // Verificar si el usuario existe
                if ($rol === false) {
                    throw new Exception("El usuario con ID $id no existe.");
                }

                // Eliminar la información adicional del rol
                $this->eliminarInformacionRol($id, $rol);

                // Eliminar el usuario de la tabla principal
                $queryDelete = "DELETE FROM usuarios WHERE id = ?";
                $stmtDelete = $this->db->prepare($queryDelete);
                $stmtDelete->execute([$id]);

                // Confirmar la transacción
                $this->db->commit();

                // Retornar true para indicar que la operación fue exitosa
                return true;
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->db->rollBack();

                // Registrar el error (opcional)
                error_log("Error al eliminar usuario: " . $e->getMessage());

                // Retornar false para indicar que la operación falló
                return false;
            }
        }

        // Eliminar la información del rol anterior
        private function eliminarInformacionRol($id, $rol)
        {
            switch ($rol) {
                case 'Instructor':
                    $query = "DELETE FROM instructores WHERE usuario_id = ?";
                    break;
                case 'Funcionario':
                    $query = "DELETE FROM funcionarios WHERE usuario_id = ?";
                    break;
                case 'Directivo':
                    $query = "DELETE FROM directivos WHERE usuario_id = ?";
                    break;
                case 'Apoyo':
                    $query = "DELETE FROM apoyo WHERE usuario_id = ?";
                    break;
                case 'Visitante':
                    $query = "DELETE FROM visitantes WHERE usuario_id = ?";
                    break;
                default:
                    return; // No hacer nada si el rol no tiene información adicional
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        }
    }
?>