<?php
    session_start(); // Inicia la sesión para gestionar variables de sesión

    // Cargar el autoload de Composer desde la carpeta assets
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__ . '/../Models/RecuperarContraseñaModelo.php'; // Incluye el modelo que maneja la base de datos

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    class RecuperarContraseñaController
    {
        private $recuperarModelo;
        private $mailer;
        public function __construct()
        {
            $this->recuperarModelo = new RecuperarContraseñaModelo();
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
        public function mostrarRestablecerContrasena(): void
        {
            // Obtener el token de la URL (método GET ?token=valor)
            $token = $_GET['token'] ?? '';
            
            if (empty($token)) {
                setcookie("flash_error", "Token no proporcionado", time() + 5, "/");
                header("Location: Login");
                exit;
            }

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
        private function enviarCorreoRecuperacion(string $correo, string $token): bool 
        {
            $mail = new PHPMailer(true);
            
            try {
                // 1. Configuración SMTP (usa variables de entorno en producción)
                $mail->isSMTP();
                $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = getenv('SMTP_USER') ?: 'stafftracker84@gmail.com';
                $mail->Password = getenv('SMTP_PASS') ?: 'idgb fjgj boux wxpa';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = getenv('SMTP_PORT') ?: 587;
                $mail->Timeout = 15;

                // 2. Configurar remitente y destinatario
                $mail->setFrom(getenv('SMTP_FROM_EMAIL') ?: 'stafftracker84@gmail.com', 
                            getenv('SMTP_FROM_NAME') ?: 'Sistema StaffTracker');
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña - StaffTracker';
                
                // 3. Generar URL COMPLETA y ABSOLUTA
                $resetUrl = $this->generateResetUrl($token);
                
                // 4. Contenido del correo con URL explícita
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
            $path = '/controlAsistencia/public/restablecer-contrasena'; // Ruta exacta
            
            return $protocol . $host . $path . '?token=' . urlencode($token);
        }

        /**
         * Crea el cuerpo HTML del correo con URL completa en el botón
         */
        private function createEmailBody(string $resetUrl): string
        {
            return <<<HTML
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
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
            </div>
        HTML;
        }
    }
?>