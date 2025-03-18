<?php

// Iniciar la sesión para acceder a las variables de sesión
session_start();

// Incluir el modelo de Perfil para interactuar con la base de datos
require_once __DIR__ . '/../Models/PerfilModelo.php';

// Definir la clase PerfilController
class PerfilController
{
    // Propiedad para almacenar una instancia del modelo PerfilModelo
    private $perfilModelo;

    // Constructor de la clase
    public function __construct()
    {
        // Crear una nueva instancia del modelo PerfilModelo
        $this->perfilModelo = new PerfilModelo();
    }

    // Método para mostrar el perfil del usuario
    public function mostrarPerfil()
    {
        // Recuperar el mensaje y el tipo de mensaje de la sesión (si existen)
        $mensaje = $_SESSION['mensaje'] ?? '';
        $tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';

        // Obtener el ID del usuario desde la sesión
        $id = $_SESSION['usuario']['id'];

        // Obtener los datos del perfil del usuario desde el modelo
        $usuario = $this->perfilModelo->obtenerPerfilPorId($id);

        // Incluir la vista del perfil para mostrar la información
        include_once __DIR__ . '/../Views/profile/perfil_usuario.php';
    }

    // Método para procesar el formulario de edición de perfil
    public function actualizarPerfil()
    {
        // Verificar si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['usuario']['id'];

            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $telefono = $_POST['phone'];
            $correo = $_POST['email'];

            // Actualizar el perfil en la base de datos usando el modelo
            $actualizado = $this->perfilModelo->actualizarPerfil($idUsuario, $nombre, $apellidos, $telefono, $correo);

            // Verificar si la actualización fue exitosa
            if ($actualizado) {
                // Actualizar la sesión con los nuevos datos
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['telefono'] = $telefono;
                $_SESSION['usuario']['correo'] = $correo;

                // Guardar mensaje de éxito en la sesión
                $_SESSION['mensaje'] = "El perfil se actualizó correctamente.";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                // Guardar mensaje de error en la sesión
                $_SESSION['mensaje'] = "Hubo un error al actualizar el perfil.";
                $_SESSION['tipo_mensaje'] = "error";
            }

            // Redirigir al perfil después de la actualización
            header('Location: perfil');
            exit();
        }
    }

    // Método para procesar la subida de la imagen de perfil
    public function subirImagenPerfil()
    {
        // Verificar si la solicitud es de tipo POST y si se ha enviado un archivo de imagen
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['usuario']['id'];

            // Obtener la información del archivo de imagen
            $imagen = $_FILES['imagen'];

            // Definir las extensiones de archivo permitidas
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

            // Obtener la extensión del archivo
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            // Verificar si la extensión del archivo está permitida
            if (in_array($extension, $extensionesPermitidas)) {
                // Obtener la ruta de la imagen actual del perfil
                $rutaImagenActual = $_SESSION['usuario']['foto_perfil'];

                // Verificar si la imagen actual es "default.webp"
                $nombreImagenActual = basename($rutaImagenActual);
                if ($nombreImagenActual !== 'default.webp' && file_exists($rutaImagenActual)) {
                    // Si no es "default.webp", eliminar la imagen anterior
                    unlink($rutaImagenActual);
                }

                // Crear un nombre único para la nueva imagen
                $nombreLimpio = strtolower(str_replace(' ', '_', $_SESSION['usuario']['nombre'])); // Reemplazar espacios con guiones bajos
                $nombreLimpio = preg_replace('/[^a-z0-9_]/', '', $nombreLimpio); // Eliminar caracteres no permitidos

                // Si el nombre está vacío, generar un identificador único
                if (empty($nombreLimpio)) {
                    $nombreLimpio = uniqid('perfil_', true);
                }

                // Generar el nombre base del archivo
                $nombreArchivoBase = $nombreLimpio . '_perfil.webp';

                // Definir la ruta de destino para la nueva imagen
                $rutaDestino = 'assets/img/perfiles/' . $nombreArchivoBase;

                // Obtener las dimensiones de la imagen original
                list($anchoOriginal, $altoOriginal) = getimagesize($imagen['tmp_name']);

                // Crear una imagen redimensionada con un tamaño de 200x200 píxeles
                $imagenRedimensionada = imagecreatetruecolor(200, 200);

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
                        // Guardar mensaje de error en la sesión si el formato no es soportado
                        $_SESSION['mensaje'] = "Formato de imagen no soportado.";
                        $_SESSION['tipo_mensaje'] = "error";
                        header('Location: perfil');
                        exit();
                }

                // Redimensionar la imagen original a 200x200 píxeles
                imagecopyresampled(
                    $imagenRedimensionada, // Imagen de destino
                    $imagenOriginal,      // Imagen original
                    0, 0,                // Coordenadas de destino (x, y)
                    0, 0,                // Coordenadas de origen (x, y)
                    200, 200,            // Ancho y alto de destino
                    $anchoOriginal,      // Ancho original
                    $altoOriginal        // Alto original
                );

                // Guardar la imagen redimensionada en formato WebP
                if (imagewebp($imagenRedimensionada, $rutaDestino, 90)) { // Calidad: 90%
                    // Liberar memoria de las imágenes creadas
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
                // Guardar mensaje de error si el formato de imagen no es válido
                $_SESSION['mensaje'] = "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y GIF.";
                $_SESSION['tipo_mensaje'] = "error";
            }
        } else {
            // Guardar mensaje de error si la solicitud no es válida
            $_SESSION['mensaje'] = "Solicitud no válida.";
            $_SESSION['tipo_mensaje'] = "error";
        }

        // Redirigir al perfil después de procesar la imagen
        header('Location: perfil');
        exit();
    }

    // Método para procesar la eliminación de la imagen de perfil
    public function eliminarImagenPerfil()
    {
        // Verificar si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el ID del usuario desde la sesión
            $idUsuario = $_SESSION['usuario']['id'];

            // Definir la ruta de la imagen por defecto
            $imagenPorDefecto = 'assets/img/perfiles/default.webp';

            // Obtener la ruta de la imagen actual del usuario
            $rutaImagenActual = $_SESSION['usuario']['foto_perfil'];

            // Verificar si la imagen actual existe y no es la imagen por defecto
            if ($rutaImagenActual && $rutaImagenActual !== $imagenPorDefecto && file_exists($rutaImagenActual)) {
                // Eliminar la imagen actual del servidor
                if (unlink($rutaImagenActual)) {
                    // Actualizar la base de datos con la imagen por defecto
                    $actualizado = $this->perfilModelo->eliminarImagenPerfil($idUsuario, $imagenPorDefecto);

                    if ($actualizado) {
                        // Actualizar la sesión con la imagen por defecto
                        $_SESSION['usuario']['foto_perfil'] = $imagenPorDefecto;

                        // Guardar mensaje de éxito en la sesión
                        $_SESSION['mensaje'] = "La imagen de perfil se eliminó correctamente.";
                        $_SESSION['tipo_mensaje'] = "success";
                    } else {
                        // Guardar mensaje de error si no se pudo actualizar la base de datos
                        $_SESSION['mensaje'] = "Hubo un error al restablecer la imagen en la base de datos.";
                        $_SESSION['tipo_mensaje'] = "error";
                    }
                } else {
                    // Guardar mensaje de error si no se pudo eliminar la imagen del servidor
                    $_SESSION['mensaje'] = "Hubo un error al eliminar la imagen del servidor.";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            } else {
                // Guardar mensaje de error si no se encontró la imagen o ya es la imagen por defecto
                $_SESSION['mensaje'] = "No se encontró la imagen de perfil actual o ya es la imagen por defecto.";
                $_SESSION['tipo_mensaje'] = "error";
            }

            // Redirigir al perfil después de procesar la eliminación
            header('Location: perfil');
            exit();
        }
    }

    // Método para actualizar la contraseña del usuario
    public function actualizarContrasena()
    {
        // Verificar si la solicitud es de tipo POST
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
                        // Guardar mensaje de éxito en la sesión
                        $_SESSION['mensaje'] = "La contraseña se actualizó correctamente.";
                        $_SESSION['tipo_mensaje'] = "success";
                    } else {
                        // Guardar mensaje de error si no se pudo actualizar la contraseña
                        $_SESSION['mensaje'] = "Hubo un error al actualizar la contraseña.";
                        $_SESSION['tipo_mensaje'] = "error";
                    }
                } else {
                    // Guardar mensaje de error si la contraseña actual es incorrecta
                    $_SESSION['mensaje'] = "La contraseña actual es incorrecta.";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            } else {
                // Guardar mensaje de error si las contraseñas no coinciden
                $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
                $_SESSION['tipo_mensaje'] = "error";
            }

            // Redirigir al perfil después de procesar la actualización de la contraseña
            header('Location: perfil');
            exit();
        }
    }
}