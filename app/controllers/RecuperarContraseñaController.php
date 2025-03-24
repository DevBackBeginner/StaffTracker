<?php
    session_start(); // Inicia la sesión para gestionar variables de sesión

    // Cargar el autoload de Composer desde la carpeta assets
    require_once __DIR__ . '/../../public/assets/vendor/autoload.php';
    require_once __DIR__ . '/../Models/RecuperarContraseñaModelo.php'; // Incluye el modelo que maneja la base de datos

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    class RecuperarContraseñaController
    {
        private $recuperarModelo;

        public function __construct()
        {
            $this->recuperarModelo = new RecuperarContraseñaModelo();
        }

        /**
         * Muestra el formulario para solicitar la recuperación de contraseña.
         */
        public function mostrarRecuperarContrasena() {
            include_once __DIR__ . '/../Views/auth/recuperar_contrasena.php';
        }

        /**
         * Procesa la solicitud de recuperación de contraseña.
         */
        public function procesarRecuperarContrasena() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
        
                if (empty($correo)) {
                    setcookie("flash_error", "Por favor, ingresa tu correo electrónico.", time() + 5, "/");
                    header("Location: RecuperarContrasena");
                    exit;
                }
        
                $usuario = $this->recuperarModelo->buscarPorCorreo($correo);
        
                if ($usuario) {
                    // Generar token en el controlador (lógica de aplicación)
                    $token = bin2hex(random_bytes(50));
                    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
                    // Delegar al modelo solo el guardado en la base de datos
                    $this->recuperarModelo->guardarTokenRecuperacion($usuario['id'], $token, $expiry);
        
                    // Enviar correo (también responsabilidad del controlador)
                    if ($this->enviarCorreoRecuperacion($correo, $token)) {
                        setcookie("flash_success", "Se ha enviado un enlace de recuperación a tu correo.", time() + 5, "/");
                    } else {
                        setcookie("flash_error", "Error al enviar el correo. Intenta nuevamente.", time() + 5, "/");
                    }
                    header("Location: Login");
                    exit;
                } else {
                    setcookie("flash_success", "Si el correo existe, recibirás un enlace de recuperación.", time() + 5, "/");
                    header("Location: Login");
                    exit;
                }
            }
        }

        /**
         * Muestra el formulario para restablecer la contraseña.
         */
        public function mostrarRestablecerContrasena($token) {
            // Verificar si el token es válido
            $usuario = $this->recuperarModelo->buscarPorToken($token);

            if ($usuario && strtotime($usuario['reset_token_expiry']) > time()) {
                include_once __DIR__ . '/../Views/auth/restablecer_contraseña.php';
            } else {
                setcookie("flash_error", "El enlace de recuperación es inválido o ha expirado.", time() + 5, "/");
                header("Location: Login");
                exit;
            }
        }

        /**
         * Procesa el restablecimiento de la contraseña.
         */
        public function procesarRestablecerContrasena() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $token = $_POST['token'];
                $contrasena = trim($_POST['password']);

                // Buscar el usuario por token
                $usuario = $this->recuperarModelo->buscarPorToken($token);

                if ($usuario && strtotime($usuario['reset_token_expiry']) > time()) {
                    // Actualizar la contraseña
                    $this->recuperarModelo->actualizarContrasena($usuario['id'], $contrasena);
                    // Eliminar el token de recuperación
                    $this->recuperarModelo->eliminarTokenRecuperacion($usuario['id']);

                    // Mostrar un mensaje de éxito
                    setcookie("flash_success", "Contraseña actualizada correctamente.", time() + 5, "/");
                    header("Location: Login");
                    exit;
                } else {
                    setcookie("flash_error", "El enlace de recuperación es inválido o ha expirado.", time() + 5, "/");
                    header("Location: Login");
                    exit;
                }
            } else {
                setcookie("flash_error", "Acceso no autorizado.", time() + 5, "/");
                header("Location: Login");
                exit;
            }
        }

        /**
         * Envía un correo electrónico con el enlace de recuperación.
         */
        private function enviarCorreoRecuperacion($correo, $token) {
            // Crear una instancia de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.tudominio.com'; // Servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'stafftracker84@gmail.com'; // Tu correo
                $mail->Password = 'idgb fjgj boux wxpa'; // Tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encriptación TLS
                $mail->Port = 587; // Puerto SMTP

                // Remitente y destinatario
                $mail->setFrom('stafftracker84@gmail.com', 'stafftracker');
                $mail->addAddress($correo); // Correo del destinatario

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body = "Para recuperar tu contraseña, haz clic en el siguiente enlace: 
                            <a href='http://localhost/ControlAsistencia/public/restablecer-contrasena?token=$token'>Restablecer Contraseña</a>";

                // Enviar el correo
                $mail->send();
                return true;
            } catch (Exception $e) {
                // Si hay un error, puedes registrarlo o manejarlo
                error_log("Error al enviar el correo: " . $mail->ErrorInfo);
                return false;
            }
        }
    }
?>