<?php
    session_start(); // Iniciar la sesión

    // Cargar el autoload de Composer desde la carpeta assets
    require_once __DIR__ . '/../../vendor/autoload.php';

    require_once __DIR__ . '/../Models/LoginModelo.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class LoginController {
        private $loginModelo;
        private $mailer;

        // Constructor: recibe una instancia del modelo
        public function __construct() {
            $this->loginModelo = new loginModelo();
            $this->mailer = new PHPMailer(true);
        
            // Configuración básica de PHPMailer
            $this->mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
            $this->mailer->Timeout = 30; // 30 segundos de timeout
        
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
                    header("Location: login");
                    exit;
                }

                // Obtener el usuario de la base de datos según el correo
                $usuario = $this->loginModelo->buscarPorCorreo($correo);

                // Verificar si el usuario existe y si la contraseña es correcta
                if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'apellido' => $usuario['apellido'],
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
                    header("Location: login");
                    exit;
                }
            } else {
                setcookie("flash_error", "Acceso no autorizado.", time() + 5, "/");
                header("Location: login");
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
        
                $usuario = $this->loginModelo->buscarPorCorreo($correo);
        
                if ($usuario) {
                    // Generar token en el controlador (lógica de aplicación)
                    $token = bin2hex(random_bytes(50));
                    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
                    // Delegar al modelo solo el guardado en la base de datos
                    $this->loginModelo->guardarTokenRecuperacion($usuario['id'], $token, $expiry);
        
                    // Enviar correo (también responsabilidad del controlador)
                    if ($this->enviarCorreoRecuperacion($correo, $token)) {
                        setcookie("flash_success", "Se ha enviado un enlace de recuperación a tu correo.", time() + 5, "/");
                    } else {
                        setcookie("flash_error", "Error al enviar el correo. Intenta nuevamente.", time() + 5, "/");
                    }
                    header("Location: login");
                    exit;
                } else {
                    setcookie("flash_success", "Si el correo existe, recibirás un enlace de recuperación.", time() + 5, "/");
                    header("Location: login");
                    exit;
                }
            }
        }

        /**
         * Muestra el formulario para restablecer la contraseña.
         */
        public function mostrarRestablecerContrasena(): void
        {
            // Obtener el token de la URL (método GET ?token=valor)
            $token = $_GET['token'] ?? '';
            
            if (empty($token)) {
                setcookie("flash_error", "Token no proporcionado", time() + 5, "/");
                header("Location: login");
                exit;
            }

            // Verificar si el token es válido
            $usuario = $this->loginModelo->buscarPorToken($token);

            if ($usuario && strtotime($usuario['reset_token_expiry']) > time()) {
                include_once __DIR__ . '/../Views/auth/restablecer_contraseña.php';
            } else {
                setcookie("flash_error", "El enlace de recuperación es inválido o ha expirado.", time() + 5, "/");
                header("Location: login");
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
                $usuario = $this->loginModelo->buscarPorToken($token);

                if ($usuario && strtotime($usuario['reset_token_expiry']) > time()) {
                    // Actualizar la contraseña
                    $this->loginModelo->actualizarContrasena($usuario['id'], $contrasena);
                    // Eliminar el token de recuperación
                    $this->loginModelo->eliminarTokenRecuperacion($usuario['id']);

                    // Mostrar un mensaje de éxito
                    setcookie("flash_success", "Contraseña actualizada correctamente.", time() + 5, "/");
                    header("Location: login");
                    exit;
                } else {
                    setcookie("flash_error", "El enlace de recuperación es inválido o ha expirado.", time() + 5, "/");
                    header("Location: login");
                    exit;
                }
            } else {
                setcookie("flash_error", "Acceso no autorizado.", time() + 5, "/");
                header("Location: login");
                exit;
            }
        }

        /**
         * Envía un correo electrónico con el enlace de recuperación.
         */
        private function enviarCorreoRecuperacion(string $correo, string $token): bool 
        {
            $mail = new PHPMailer(true);
            
            try {
                // 1. Configuración SMTP
                $mail->isSMTP();
                $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = getenv('SMTP_USER') ?: 'stafftracker84@gmail.com';
                $mail->Password = getenv('SMTP_PASS') ?: 'idgb fjgj boux wxpa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = getenv('SMTP_PORT') ?: 587;
                $mail->Timeout = 15;

                // 2. Configuración CRÍTICA para caracteres especiales
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                
                // 3. Configurar remitente y destinatario
                $mail->setFrom(
                    getenv('SMTP_FROM_EMAIL') ?: 'stafftracker84@gmail.com', 
                    mb_encode_mimeheader(
                        getenv('SMTP_FROM_NAME') ?: 'Sistema StaffTracker',
                        'UTF-8',
                        'Q'
                    )
                );
                $mail->addAddress($correo);
                $mail->isHTML(true);
                
                // 4. Asunto con codificación correcta
                $mail->Subject = mb_encode_mimeheader(
                    'Recuperación de Contraseña - StaffTracker',
                    'UTF-8',
                    'Q'
                );
                
                // 5. Generar URL y contenido
                $resetUrl = $this->generateResetUrl($token);
                $mail->Body = $this->createEmailBody($resetUrl);
                $mail->AltBody = "Para recuperar tu contraseña, visita: {$resetUrl}";

                return $mail->send();
                
            } catch (Exception $e) {
                error_log("[Email Error] Para: {$correo} - " . $e->getMessage());
                return false;
            }
        }

        /**
         * Genera la URL absoluta completa para restablecer contraseña
         */
        private function generateResetUrl(string $token): string
        {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $path = '/StaffTracker/public/restablecer-contrasena'; // Ruta exacta
            
            return $protocol . $host . $path . '?token=' . urlencode($token);
        }

        /**
         * Crea el cuerpo HTML del correo con URL completa en el botón
         */
        private function createEmailBody(string $resetUrl): string
        {
            return <<<HTML
            <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                </head>
                <body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #2c3e50;">Recuperación de Contraseña</h2>
                    <p>Haz clic en este botón para restablecer tu contraseña:</p>
                    
                    <div style="text-align: center; margin: 25px 0;">
                        <a href="{$resetUrl}" 
                        style="display: inline-block; background-color: #3498db; color: white; 
                                padding: 12px 24px; text-decoration: none; border-radius: 5px; 
                                font-weight: bold; margin: 10px 0;">
                        Restablecer Contraseña
                        </a>
                    </div>
                    
                    <p>O copia y pega esta URL en tu navegador:</p>
                    <div style="background: #f5f5f5; padding: 10px; border-radius: 5px; 
                                word-break: break-all; font-family: monospace;">
                        {$resetUrl}
                    </div>
                    
                    <p style="margin-top: 20px; font-size: 0.9em; color: #666;">
                        Este enlace expirará en 1 hora. Si no solicitaste este cambio, ignora este mensaje.
                    </p>
                </body>
            </html>
        HTML;
        }
    }
?>