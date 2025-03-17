<?php
    session_start(); // Inicia la sesión para gestionar variables de sesión

    require_once __DIR__ . '/../models/RegistrarGuardasModelo.php'; // Incluye el modelo que maneja la base de datos

    class RegistrarGuardasController {
        private $guardasModel;

        public function __construct() {
            // Instancia el modelo para interactuar con la base de datos
            $this->guardasModel = new RegistrarGuardasModelo(); 
        }

        // Método para mostrar el formulario de registro de guardas
        public function formularioRegistroGuardias() {
            // Recuperar mensajes de la sesión
            $mensaje = $_SESSION['mensaje'] ?? '';
            $tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';


            include_once __DIR__ . '/../views/gestion/registro_guardas/registro_guardas.php';
        }

        // Método para procesar el registro de un nuevo guarda
        public function registrarGuardas() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si la solicitud es de tipo POST
        
                // Capturar y sanitizar los datos del formulario
                $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
                $apellido = htmlspecialchars(trim($_POST['apellido']), ENT_QUOTES, 'UTF-8');
                $telefono = trim($_POST['telefono']); // Capturar el teléfono
                $numeroIdentidad = trim($_POST['numero_identidad']); // Capturar el número de identidad
                $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
                $password = trim($_POST['numero_identidad']);
        
                // Validar que los campos no estén vacíos
                if (empty($nombre) || empty($apellido) || empty($numeroIdentidad) || empty($correo) || empty($password) || empty($telefono)) {
                    $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: registrar_guardas'); // Redirigir al formulario
                    exit();
                }
        
                // Validar el formato del teléfono (10 dígitos, comenzando con 3)
                if (!preg_match('/^3[0-9]{9}$/', $telefono)) {
                    $_SESSION['mensaje'] = "El teléfono debe tener 10 dígitos y comenzar con 3 (formato colombiano).";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: registrar_guardas'); // Redirigir al formulario
                    exit();
                }
        
                // Validar el número de documento (exactamente 10 dígitos, solo números)
                if (!preg_match('/^[0-9]{6,}$/', $numeroIdentidad)) {
                    $_SESSION['mensaje'] = "El número de documento debe tener al menos 6 dígitos y solo contener números.";
                    $_SESSION['tipo_mensaje'] = 'error';
                    header('Location: registrar_guardas'); // Redirigir al formulario
                    exit();
                }
        
                // Manejo de la foto de perfil
                $fotoPerfil = 'assets/img/perfiles/default.png'; // Imagen por defecto    
                // Hashear la contraseña antes de guardarla en la base de datos
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
                // Insertar el nuevo guarda en la base de datos
                try {
                    $resultado = $this->guardasModel->registrarGuarda(
                        $nombre,
                        $apellido,
                        $telefono,
                        $numeroIdentidad,
                        $correo,
                        $passwordHash,
                        $fotoPerfil
                    );
        
                    if ($resultado) {
                        $_SESSION['mensaje'] = "Registro exitoso. ";
                        $_SESSION['tipo_mensaje'] = 'success';
                    } else {
                        $_SESSION['mensaje'] = "Error al registrar el guarda.";
                        $_SESSION['tipo_mensaje'] = 'error';
                    }
                } catch (Exception $e) {
                    // Capturar cualquier error en la base de datos y mostrarlo
                    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                    $_SESSION['tipo_mensaje'] = 'error';
                }
        
                // Redirigir al formulario después de procesar el registro
                header('Location: registrar_guardas');
                exit();
            }
        }
    }
?>