<?php

session_start();

require_once __DIR__ . '/../models/PerfilModelo.php';

class PerfilController
{
    private $perfilModelo;

    public function __construct()
    {
        $this->perfilModelo = new PerfilModelo();
    }

    public function mostrarPerfil()
    {
        // Recuperar el mensaje y el tipo de mensaje de la sesión
        $mensaje = $_SESSION['mensaje'] ?? '';
        $tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';

        // Obtener los datos del perfil
        $id = $_SESSION['usuario']['id'];
        $usuario = $this->perfilModelo->obtenerPerfilPorId($id);

        // Incluir la vista del perfil
        include_once __DIR__ . '/../views/profile/perfil_usuario.php';
    }

    // Método para procesar el formulario de edición de perfil
    public function actualizarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['usuario']['id'];

            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $telefono = $_POST['phone'];
            $correo = $_POST['email'];

            // Actualizar el perfil en la base de datos
            $actualizado = $this->perfilModelo->actualizarPerfil($idUsuario, $nombre, $apellidos, $telefono, $correo);

            if ($actualizado) {
                // Actualizar la sesión con los nuevos datos
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['telefono'] = $telefono;
                $_SESSION['usuario']['correo'] = $correo;

                // Guardar mensaje de éxito
                $_SESSION['mensaje'] = "El perfil se actualizó correctamente.";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                // Guardar mensaje de error
                $_SESSION['mensaje'] = "Hubo un error al actualizar el perfil.";
                $_SESSION['tipo_mensaje'] = "error";
            }

            // Redirigir al perfil
            header('Location: perfil');
            exit();
        }
    }

    // Método para procesar la subida de la imagen de perfil
    public function subirImagenPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
            $idUsuario = $_SESSION['usuario']['id'];
            $imagen = $_FILES['imagen'];

            // Validar que el archivo sea una imagen
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (in_array($extension, $extensionesPermitidas)) {
                // Crear un nombre único para la imagen
                $nombreLimpio = strtolower(str_replace(' ', '_', $_SESSION['usuario']['nombre'])); // Reemplaza espacios con guiones bajos
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

                // Redimensionar y convertir la imagen a WebP
                list($anchoOriginal, $altoOriginal) = getimagesize($imagen['tmp_name']);
                $imagenRedimensionada = imagecreatetruecolor(200, 200); // Tamaño deseado: 200x200 píxeles

                // Crear la imagen original según su formato
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        $imagenOriginal = imagecreatefromjpeg($imagen['tmp_name']);
                        break;
                    case 'png':
                        $imagenOriginal = imagecreatefrompng($imagen['tmp_name']);
                        break;
                    case 'gif':
                        $imagenOriginal = imagecreatefromgif($imagen['tmp_name']);
                        break;
                    default:
                        // Guardar mensaje de error en la sesión
                        $_SESSION['mensaje'] = "Formato de imagen no soportado.";
                        $_SESSION['tipo_mensaje'] = "error";
                        header('Location: perfil');
                        exit();
                }

                // Redimensionar la imagen
                imagecopyresampled(
                    $imagenRedimensionada, // Imagen de destino
                    $imagenOriginal,      // Imagen original
                    0, 0,                // Coordenadas de destino (x, y)
                    0, 0,                // Coordenadas de origen (x, y)
                    200, 200,            // Ancho y alto de destino
                    $anchoOriginal,      // Ancho original
                    $altoOriginal        // Alto original
                );

                // Guardar la imagen en formato WebP
                if (imagewebp($imagenRedimensionada, $rutaDestino, 90)) { // Calidad: 90%
                    // Liberar memoria
                    imagedestroy($imagenRedimensionada);
                    imagedestroy($imagenOriginal);

                    // Actualizar la ruta de la imagen en la base de datos
                    $this->perfilModelo->actualizarImagenPerfil($idUsuario, $rutaDestino);

                    // Actualizar la sesión con la nueva imagen
                    $_SESSION['usuario']['foto_perfil'] = $rutaDestino;

                    // Guardar mensaje de éxito en la sesión
                    $_SESSION['mensaje'] = "La imagen de perfil se actualizó correctamente.";
                    $_SESSION['tipo_mensaje'] = "success";
                } else {
                    // Guardar mensaje de error en la sesión
                    $_SESSION['mensaje'] = "Hubo un error al guardar la imagen.";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            } else {
                // Guardar mensaje de error en la sesión
                $_SESSION['mensaje'] = "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y GIF.";
                $_SESSION['tipo_mensaje'] = "error";
            }
        } else {
            // Guardar mensaje de error en la sesión
            $_SESSION['mensaje'] = "Solicitud no válida.";
            $_SESSION['tipo_mensaje'] = "error";
        }

        exit();
    }
    // Método para procesar la eliminación de la imagen de perfil
    public function eliminarImagenPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_SESSION['usuario']['id'];

            // Ruta de la imagen por defecto
            $imagenPorDefecto = 'assets/img/perfiles/default.png';

            // Obtener la ruta de la imagen actual del usuario
            $rutaImagenActual = $_SESSION['usuario']['foto_perfil'];

            // Verificar si la imagen actual existe y no es la imagen por defecto
            if (file_exists($rutaImagenActual) && $_SESSION['usuario']['foto_perfil'] !== $imagenPorDefecto) {
                // Eliminar la imagen actual del servidor
                if (unlink($rutaImagenActual)) {
                    // Actualizar la base de datos con la imagen por defecto
                    $actualizado = $this->perfilModelo->eliminarImagenPerfil($idUsuario, $imagenPorDefecto);

                    if ($actualizado) {
                        // Actualizar la sesión con la imagen por defecto
                        $_SESSION['usuario']['foto_perfil'] = $imagenPorDefecto;
                        // Guardar mensaje de éxito
                        $_SESSION['mensaje'] = "La imagen de perfil se elimino correctamente.";
                        $_SESSION['tipo_mensaje'] = "success";
                    } else {
                        // Guardar mensaje de error
                        $_SESSION['mensaje'] = "Hubo un error al restablecer la imagen en la base de datos.";
                        $_SESSION['tipo_mensaje'] = "error";
                    }
                } else {
                    // Guardar mensaje de error
                    $_SESSION['mensaje'] = "Hubo un error al eliminar la imagen del servidor.";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            } else {
                // Guardar mensaje de error
                $_SESSION['mensaje'] = "No se encontró la imagen de perfil actual.";
                $_SESSION['tipo_mensaje'] = "error";
            }
            exit();
        }
    }

    public function actualizarContrasena(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['usuario']['id'];

            // Obtener los datos del formulario
            $contraseñaActual = $_POST['contrasena_actual'];
            $nuevaContraseña = $_POST['nueva_contrasena'];
            $confirmarContraseña = $_POST['confirmar_contrasena'];

            // Verificar que la nueva contraseña y la confirmación coincidan
            if ($nuevaContraseña === $confirmarContraseña) {
                // Verificar que la contraseña actual sea correcta
                $contraseñaCorrecta = $this->perfilModelo->verificarContraseña($idUsuario, $contraseñaActual);

                if ($contraseñaCorrecta) {
                    // Actualizar la contraseña en la base de datos
                    $actualizado = $this->perfilModelo->actualizarContraseña($idUsuario, $nuevaContraseña);

                    if ($actualizado) {
                        // Guardar mensaje de éxito
                        $_SESSION['mensaje'] = "La contraseña se actualizó correctamente.";
                        $_SESSION['tipo_mensaje'] = "success";
                    } else {
                        // Guardar mensaje de error
                        $_SESSION['mensaje'] = "Hubo un error al actualizar la contraseña.";
                        $_SESSION['tipo_mensaje'] = "error";
                    }
                } else {
                    // Guardar mensaje de error
                    $_SESSION['mensaje'] = "La contraseña actual es incorrecta.";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            } else {
                // Guardar mensaje de error
                $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
                $_SESSION['tipo_mensaje'] = "error";
            }
            // Redirigir al perfil
            header('Location: perfil');
            exit();
        }
    }
}