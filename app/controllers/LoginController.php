<?php
    require_once __DIR__ . '/../Models/LoginModelo.php';
    session_start(); // Iniciar la sesión

class LoginController {
    private $loginModel;

    // Constructor: recibe una instancia del modelo
    public function __construct() {
        $this->loginModel = new LoginModel();
    }

    public function mostrarLogin() {
        include_once __DIR__ . '/../Views/auth/login.php';
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
                header("Location: Login");
                exit;
            }

            // Obtener el usuario de la base de datos según el correo
            $usuario = $this->loginModel->buscarPorCorreo($correo);

            // Verificar si el usuario existe y si la contraseña es correcta
            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                    'telefono' => $usuario['telefono'],
                    'correo' => $usuario['correo'],
                    'rol' => $usuario['rol'],
                    'foto_perfil' => $usuario['foto_perfil'] ?? 'assets/img/perfiles/default.png' // Asegurar valor
                ];
                // Establece un mensaje de éxito en una cookie
                header("Location: Inicio");
                exit;
            } else {
                // Establece un mensaje de error en una cookie
                setcookie("flash_error", "Correo electrónico o contraseña incorrectos.", time() + 5, "/");
                header("Location: Login");
                exit;
            }
        } else {
            setcookie("flash_error", "Acceso no autorizado.", time() + 5, "/");
            header("Location: Login");
            exit;
        }
    }

    public function Logout() {
        // Iniciar la sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Eliminar todas las variables de sesión
        $_SESSION = array();

        // Si desea destruir la sesión completamente, borra también la cookie de sesión.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Regenerar el ID de sesión para prevenir la fijación de sesión
        session_regenerate_id(true);

        // Redirigir al usuario a la página de inicio de sesión
        header("Location: Inicio");
        exit();
    }
}
?>