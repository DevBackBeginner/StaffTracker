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
                $sqlUsuario = "INSERT INTO usuarios (nombre, apellidos, telefono, numero_identidad, rol) VALUES (?, ?, ?, ?, ?)";
                $stmtUsuario = $this->db->prepare($sqlUsuario);
                $stmtUsuario->execute([$nombre, $apellido, $telefono, $numero_identidad, $rol]);
    
                // Obtener el ID del usuario recién insertado
                $personal_id = $this->db->lastInsertId();

                // Insertar en la tabla correspondiente según el rol
                switch ($rol) {
                    case 'Funcionario':
                        $sqlRol = "INSERT INTO funcionarios (usuario_id, area, puesto) VALUES (?, ?, ?)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->execute([$personal_id, $datosAdicionales['area'], $datosAdicionales['puesto']]);
                        break;
                    case 'Instructor':
                        $sqlRol = "INSERT INTO instructores (usuario_id, curso, ubicacion) VALUES (?, ?, ?)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->execute([$personal_id, $datosAdicionales['curso'], $datosAdicionales['ubicacion']]);
                        break;
                    case 'Directiva':
                        $sqlRol = "INSERT INTO directivos (usuario_id, cargo, departamento) VALUES (?, ?, ?)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->execute([$personal_id, $datosAdicionales['cargo'], $datosAdicionales['departamento']]);
                        break;
                    case 'Apoyo':
                        $sqlRol = "INSERT INTO apoyo (usuario_id, area_trabajo) VALUES (?, ?)";
                        $stmtRol = $this->db->prepare($sqlRol);
                        $stmtRol->execute([$personal_id, $datosAdicionales['area_trabajo']]);
                        break;
                    default:
                        throw new Exception("Rol no válido.");
                }
    
                // Confirmar la transacción
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->db->rollBack();
                error_log("Error al registrar usuario: " . $e->getMessage());
                return false;
            }
        }
    }
?>