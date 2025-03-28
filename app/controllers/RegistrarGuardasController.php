<?php
session_start(); // Inicia la sesión para gestionar variables de sesión

require_once __DIR__ . '/../Models/RegistrarGuardasModelo.php'; // Incluye el modelo que maneja la base de datos

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


        include_once __DIR__ . '/../Views/gestion/registro_guardas/registro_guardas.php';
    }

    public function registrarGuardas() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturar y sanitizar los datos del formulario
            $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
            $apellido = htmlspecialchars(trim($_POST['apellido']), ENT_QUOTES, 'UTF-8');
            $tipo_documento = htmlspecialchars(trim($_POST['tipo_documento']), ENT_QUOTES, 'UTF-8');
            $telefono = trim($_POST['telefono']);
            $numeroIdentidad = trim($_POST['numero_identidad']);
            $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    
            // Tipos de documento permitidos
            $tiposDocumentoPermitidos = ['CC', 'CE', 'TI', 'PA', 'NIT', 'OTRO'];
    
            // Validar campos obligatorios
            if (empty($nombre) || empty($apellido) || empty($tipo_documento) || 
                empty($numeroIdentidad) || empty($correo) || empty($telefono)) {
                $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: registrar_guardas');
                exit();
            }
    
            // Validar tipo de documento
            if (!in_array($tipo_documento, $tiposDocumentoPermitidos)) {
                $_SESSION['mensaje'] = "Tipo de documento no válido.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: registrar_guardas');
                exit();
            }
    
            // Validar formato del teléfono
            if (!preg_match('/^[0-9]+$/', $telefono)) {
                $_SESSION['mensaje'] = "El teléfono debe contener solo números.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: registrar_guardas');
                exit();
            }
    
            // Validar formato del número de documento según tipo
            if (!preg_match('/^[0-9]+$/', $numeroIdentidad) && $tipo_documento !== 'OTRO') {
                $_SESSION['mensaje'] = "El número de documento debe contener solo números para este tipo de documento.";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: registrar_guardas');
                exit();
            }
    
            // La contraseña será el número de identidad
            $password = $numeroIdentidad;
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
            // Foto de perfil estándar
            $fotoPerfil = 'assets/img/perfiles/default.webp';
    
            // Insertar el nuevo guarda en la base de datos
            try {
                $resultado = $this->guardasModel->registrarGuarda(
                    $nombre,
                    $apellido,
                    $tipo_documento,
                    $telefono,
                    $numeroIdentidad,
                    $correo,
                    $passwordHash,
                    $fotoPerfil
                );
    
                if ($resultado) {
                    $_SESSION['mensaje'] = "Guarda registrado con éxito.";
                    $_SESSION['tipo_mensaje'] = 'success';
                } else {
                    $_SESSION['mensaje'] = "Error al registrar el guarda.";
                    $_SESSION['tipo_mensaje'] = 'error';
                }
            } catch (PDOException $e) {
                $errorCode = $e->getCode();
    
                if ($errorCode === '23000') {
                    $errorMessage = $e->getMessage();
    
                    if (strpos($errorMessage, 'numero_identidad') !== false) {
                        $_SESSION['mensaje'] = "El número de documento ya está registrado.";
                    } elseif (strpos($errorMessage, 'correo') !== false) {
                        $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
                    } else {
                        $_SESSION['mensaje'] = "Error al registrar el guarda: " . $e->getMessage();
                    }
                } else {
                    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                }
    
                $_SESSION['tipo_mensaje'] = 'error';
            } catch (Exception $e) {
                $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                $_SESSION['tipo_mensaje'] = 'error';
            }
    
            header('Location: registrar_guardas');
            exit();
        }
    }
}
?>
