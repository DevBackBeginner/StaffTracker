<?php
    // Incluir el modelo de login para manejar la autenticación de emails
    require_once __DIR__ . '/../models/LoginModelo.php';
    
    // Iniciar la sesión para manejar autenticación y mensajes de error/éxito
    session_start();

    class LoginController {
        
        private $loginModel;

        // Constructor: Inicializa el modelo de login
        public function __construct() {
            $this->loginModel = new LoginModel();
        }

        /**
         * Método para procesar el formulario de login
         */
        public function procesarLogin() {
            // Verificar que se haya enviado el formulario mediante POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Capturar y sanitizar los datos ingresados
                $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
                $contrasena = trim($_POST['password']);

                // Obtener el portero de la base de datos según el correo
                $portero = $this->loginModel->obtenerPorCorreo($correo);

                if ($portero && password_verify($contrasena, $portero['contrasena'])) {
                    // La contraseña es correcta, iniciar sesión
                    $_SESSION['usuario'] = $portero['nombre'];

                    // Redirigir al panel principal
                    header("Location: panel");
                    exit;
                } else {
                    // Credenciales incorrectas
                    $_SESSION['error'] = "Correo o contraseña incorrectos.";
                    header("Location: login");
                    exit;
                }
            } else {
                // Si no es una solicitud POST, redirigir al formulario de inicio de sesión
                header("Location: login");
                exit;
            }
        }

        public function Logout(){
            session_start();
            session_unset(); // Elimina todas las variables de sesión
            session_destroy(); // Destruye la sesión
            header("Location: login"); // Redirige al usuario a la página de inicio de sesión
            exit();
        }
    }
?>
