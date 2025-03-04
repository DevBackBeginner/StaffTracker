<?php
    session_start(); // Inicia la sesión para gestionar variables de sesión

    require_once __DIR__ . '/../models/RegistrarGuardasModelo.php'; // Incluye el modelo que maneja la base de datos

    class RegistrarGuardasController {
        private $guardasModel;
        private $mensaje; 
        private $tipo_mensaje;

        public function __construct() {
            // Instancia el modelo para interactuar con la base de datos
            $this->guardasModel = new RegistrarGuardasModelo(); 
            $this->mensaje = '';
            $this->tipo_mensaje = '';
        }

        // Método para mostrar el formulario de registro de guardas
        public function formularioRegistroGuardias() {
            include_once __DIR__ . '/../views/gestion/registro_guardas/registro_guardas.php';
        }

        // Método para procesar el registro de un nuevo guarda
        public function registrarGuardas() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si la solicitud es de tipo POST

                // Capturar y sanitizar los datos del formulario
                $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
                $numeroIdentidad = htmlspecialchars(trim($_POST['numero_identidad']), ENT_QUOTES, 'UTF-8');
                $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
                $password = trim($_POST['password']);
                $confirmPassword = trim($_POST['confirm_password']);
                $turno = htmlspecialchars(trim($_POST['turno']), ENT_QUOTES, 'UTF-8');

                // Validar que los campos no estén vacíos
                if (empty($nombre) || empty($numeroIdentidad) || empty($correo) || empty($password) || empty($confirmPassword) || empty($turno)) {
                    $this->mensaje = "Todos los campos son obligatorios.";
                    $this->tipo_mensaje = 'error';
                    return;
                }

                // Validar que las contraseñas coincidan
                if ($password !== $confirmPassword) {
                    $this->mensaje = "Las contraseñas no coinciden.";
                    $this->tipo_mensaje = 'error';
                    return;
                }

                // Manejo de la foto de perfil
                $fotoPerfil = 'assets/img/perfiles/default.png'; // Imagen por defecto

                if ($_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                    $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
                    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
                
                    // Verifica si la extensión es válida
                    if (in_array(strtolower($extension), $extensionesPermitidas)) {
                        // Formatear el nombre del archivo
                        $nombreLimpio = strtolower(str_replace(' ', '_', $nombre)); // Reemplaza espacios con guiones bajos
                        $nombreLimpio = preg_replace('/[^a-z0-9_]/', '', $nombreLimpio); // Elimina caracteres no permitidos
                
                        // Si el nombre está vacío, genera un identificador único
                        if (empty($nombreLimpio)) {
                            $nombreLimpio = uniqid('perfil_', true);
                        }
                
                        // Generar el nombre base sin sufijo numérico
                        $nombreArchivoBase = $nombreLimpio . '_perfil.webp';
                        $rutaDestino = 'assets/img/perfiles/' . $nombreArchivoBase;
                        
                        // Si el archivo ya existe, genera un nombre único
                        $contador = 1;
                        while (file_exists($rutaDestino)) {
                            $rutaDestino = 'assets/img/perfiles/' . $nombreLimpio . '_perfil_' . $contador . '.webp';
                            $contador++;
                        }
                
                        // Redimensionar y convertir la imagen a formato WebP
                        list($anchoOriginal, $altoOriginal) = getimagesize($_FILES['foto_perfil']['tmp_name']);
                        $imagenRedimensionada = imagecreatetruecolor(200, 200);
                        $imagenOriginal = imagecreatefromstring(file_get_contents($_FILES['foto_perfil']['tmp_name']));
                        imagecopyresampled($imagenRedimensionada, $imagenOriginal, 0, 0, 0, 0, 200, 200, $anchoOriginal, $altoOriginal);
                        imagewebp($imagenRedimensionada, $rutaDestino, 90); // Guardar en formato WebP con calidad 90
                
                        $fotoPerfil = $rutaDestino; // Guardar la ruta en la base de datos
                    } else {
                        $this->mensaje = "Formato de archivo no permitido.";
                        $this->tipo_mensaje = 'error';
                        return;
                    }
                }
                

                // Hashear la contraseña antes de guardarla en la base de datos
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo guarda en la base de datos
                try {
                    $resultado = $this->guardasModel->registrarGuarda($nombre, $numeroIdentidad, $correo, $passwordHash, $turno, $fotoPerfil);

                    if ($resultado) {
                        $this->mensaje = "Registro exitoso. ¡Bienvenido!";
                        $this->tipo_mensaje = 'success';
                    } else {
                        $this->mensaje = "Error al registrar el guarda.";
                        $this->tipo_mensaje = 'error';
                    }
                } catch (Exception $e) {
                    // Capturar cualquier error en la base de datos y mostrarlo
                    $this->mensaje = "Error: " . $e->getMessage();
                    $this->tipo_mensaje = 'error';
                }
            }

            // Cargar la vista con el mensaje de éxito o error
            include_once __DIR__ . '/../views/gestion/registro_guardas/registro_guardas.php';
        }
    }
?>
