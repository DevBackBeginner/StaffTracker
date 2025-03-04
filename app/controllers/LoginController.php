<?php
    require_once __DIR__ . '/../models/LoginModelo.php';

    session_start(); // Iniciar la sesión

    class LoginController {
        private $loginModel;

        // Constructor: recibe una instancia del modelo
        public function __construct() {
            $this->loginModel = new LoginModel();
        }

        /**
         * Procesa el inicio de sesión del usuario.
         */
        public function procesarLogin() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Capturar y sanitizar los datos ingresados
                $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
                $contrasena = trim($_POST['password']);
        
                // Validar que el correo y la contraseña no estén vacíos
                if (empty($correo) || empty($contrasena)) {
                    // Se crea una cookie que durará 5 segundos
                    setcookie("flash_error", "Por favor, ingresa tu correo y contraseña.", time() + 5, "/");
                    header("Location: login");
                    exit;
                }
        
                // Obtener el usuario de la base de datos según el correo
                $usuario = $this->loginModel->buscarPorCorreo($correo);
    
                // $contrasenaIngresada = 'nicolas020';
                // var_dump(password_verify($contrasenaIngresada, $usuario['password'])); // Debe ser true si es correcta
                // exit;
                
                // Verificar si el usuario existe y si la contraseña es correcta
                if ($usuario && password_verify($contrasena, $usuario['password'])) {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'correo' => $usuario['correo'],
                        'rol' => $usuario['rol'],
                        'foto_perfil' => $usuario['foto_perfil'] ?? 'assets/img/perfiles/default.png' // Asegurar valor
                    ];
                    // Establece un mensaje de éxito en una cookie
                    header("Location: panel_administracion");
                    exit;
                } else {
                    // Establece un mensaje de error en una cookie
                    setcookie("flash_error", "Correo electrónico o contraseña incorrectos.", time() + 5, "/");
                    header("Location: login");
                    exit;
                }
            } else {
                setcookie("flash_error", "Acceso no autorizado.", time() + 5, "/");
                header("Location: login");
                exit;
            }
        }
        
        

        public function Logout(){
            session_start();
            session_unset(); // Elimina todas las variables de sesión
            session_destroy(); // Destruye la sesión
            header("Location: Inicio"); // Redirige al usuario a la página de inicio de sesión
            exit();
        }
    }
?>
