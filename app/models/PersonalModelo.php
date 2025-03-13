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

        
    }
?>