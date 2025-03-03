<?php
    session_start();
    require_once __DIR__ . '/../models/RegistrarGuardasModelo.php'; // Asegúrate que el nombre del archivo/clase sea el correcto

    class RegistrarGuardasController {
        private $guardasModel;

        public function __construct() {
            $this->guardasModel = new RegistrarGuardasModelo(); // Verifica que la clase se llame así en el modelo
        }

        public function registrarGuardas() {
            $mensaje = ""; // Variable para almacenar el mensaje
            $tipo_mensaje = ""; // Para saber si es éxito o error
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre           = trim($_POST['nombre'] ?? '');
                $numero_identidad = trim($_POST['numero_identidad'] ?? '');
                $correo           = trim($_POST['correo'] ?? '');
                $password         = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                $turno            = $_POST['turno'] ?? ''; // Capturar el turno
        
                // Validación
                if (empty($nombre) || empty($numero_identidad) || empty($correo) || empty($password) || empty($confirm_password) || empty($turno)) {
                    $mensaje = "Todos los campos son requeridos.";
                    $tipo_mensaje = "error";
                } elseif ($password !== $confirm_password) {
                    $mensaje = "Las contraseñas no coinciden.";
                    $tipo_mensaje = "error";
                } else {
                    try {
                        $this->guardasModel->registrarGuarda($nombre, $numero_identidad, $correo, $password, $turno);
                        $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
                        $tipo_mensaje = "exito";
                    } catch (Exception $e) {
                        $mensaje = "Error al registrar el guarda: " . $e->getMessage();
                        $tipo_mensaje = "error";
                    }
                }
            }
        
            // Cargar la vista con el mensaje
            include_once __DIR__ . '/../views/gestion/auth/registro.php';
        } 
    }

