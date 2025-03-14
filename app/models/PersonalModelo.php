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

        public function registrarUsuario($nombre, $apellido, $telefono, $numero_identidad, $rol, $datosAdicionales)
        {
            try {
                // Validar datos adicionales según el rol
                switch ($rol) {
                    case 'Funcionario':
                        if (!isset($datosAdicionales['area']) || !isset($datosAdicionales['puesto'])) {
                            throw new Exception("Datos adicionales incompletos para el rol de funcionario.");
                        }
                        break;
                    case 'Instructor':
                        if (!isset($datosAdicionales['curso']) || !isset($datosAdicionales['ubicacion'])) {
                            throw new Exception("Datos adicionales incompletos para el rol de instructor.");
                        }
                        break;
                    case 'Directiva':
                        if (!isset($datosAdicionales['cargo']) || !isset($datosAdicionales['departamento'])) {
                            throw new Exception("Datos adicionales incompletos para el rol de directiva.");
                        }
                        break;
                    case 'Apoyo':
                        if (!isset($datosAdicionales['area_trabajo'])) {
                            throw new Exception("Datos adicionales incompletos para el rol de apoyo.");
                        }
                        break;
                    default:
                        throw new Exception("Rol no válido.");
                }

                // Iniciar una transacción (para asegurar la integridad de los datos)
                $this->db->beginTransaction();

                // Insertar en la tabla de usuarios (tabla común)
                $sqlUsuario = "INSERT INTO usuarios (nombre, apellidos, telefono, numero_identidad, rol) VALUES (:nombre, :apellido, :telefono, :numero_identidad, :rol)";
                $stmtUsuario = $this->db->prepare($sqlUsuario);
                $stmtUsuario->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmtUsuario->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $stmtUsuario->bindParam(':telefono', $telefono, PDO::PARAM_STR);
                $stmtUsuario->bindParam(':numero_identidad', $numero_identidad, PDO::PARAM_STR);
                $stmtUsuario->bindParam(':rol', $rol, PDO::PARAM_STR);
                $stmtUsuario->execute();

                // Obtener el ID del usuario recién insertado
                $usuario_id = $this->db->lastInsertId();

                // Insertar en la tabla correspondiente según el rol
                switch ($rol) {
                    case 'Funcionario':
                        $sqlRol = "INSERT INTO funcionarios (usuario_id, area, puesto) VALUES (:usuario_id, :area, :puesto)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                        $stmtRol->bindParam(':area', $datosAdicionales['area'], PDO::PARAM_STR);
                        $stmtRol->bindParam(':puesto', $datosAdicionales['puesto'], PDO::PARAM_STR);
                        $stmtRol->execute();
                        break;
                    case 'Instructor':
                        $sqlRol = "INSERT INTO instructores (usuario_id, curso, ubicacion) VALUES (:usuario_id, :curso, :ubicacion)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                        $stmtRol->bindParam(':curso', $datosAdicionales['curso'], PDO::PARAM_STR);
                        $stmtRol->bindParam(':ubicacion', $datosAdicionales['ubicacion'], PDO::PARAM_STR);
                        $stmtRol->execute();
                        break;
                    case 'Directiva':
                        $sqlRol = "INSERT INTO directivos (usuario_id, cargo, departamento) VALUES (:usuario_id, :cargo, :departamento)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                        $stmtRol->bindParam(':cargo', $datosAdicionales['cargo'], PDO::PARAM_STR);
                        $stmtRol->bindParam(':departamento', $datosAdicionales['departamento'], PDO::PARAM_STR);
                        $stmtRol->execute();
                        break;
                    case 'Apoyo':
                        $sqlRol = "INSERT INTO apoyo (usuario_id, area_trabajo) VALUES (:usuario_id, :area_trabajo)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                        $stmtRol->bindParam(':area_trabajo', $datosAdicionales['area_trabajo'], PDO::PARAM_STR);
                        $stmtRol->execute();
                        break;
                    default:
                        throw new Exception("Rol no válido.");
                }

                // Confirmar la transacción
                $this->db->commit();

                // Devolver el ID del usuario registrado
                return $usuario_id;
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->db->rollBack();
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
        
    }
?>