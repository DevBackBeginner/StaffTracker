<?php

    session_start();

    // Se importa el modelo 'histroialModelo' para poder interactuar con la base de datos
    require_once __DIR__ . '/../Models/HistorialRegistroModelo.php';

    class HistorialRegistroController {

        // Se declara la propiedad para almacenar la instancia del modelo de aprendiz
        private $histroialModelo;

        // Constructor de la clase
        public function __construct() {
            // Se inicializa la propiedad $modeloAprendiz con una nueva instancia del modelo 'histroialModelo'
            $this->histroialModelo = new HistorialRegistroModelo();
        }

        /**
        * Muestra la lista de usuarios filtrados por rol, con paginación de 30 registros.
        * Ejemplo de uso: /funcionarios_asistencia?rol=Instructor&page=1
        */
        public function mostrarUsuarios() {
            // Obtener parámetros GET de forma segura
            $rol = $_GET['rol'] ?? 'Instructor';  // Valor por defecto
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Convertimos a int
        
            // Validamos que la página sea al menos 1
            $page = max(1, $page);
        
            // Definir roles permitidos
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = 'Instructor'; // Si el rol no es válido, asignamos uno por defecto
            }
        
            // Definir el límite de usuarios por página y el offset
            $limit = 15;
            $offset = ($page - 1) * $limit;
            
            // Obtener los usuarios del rol seleccionado
            $usuarios = $this->histroialModelo->obtenerUsuariosPorRol($rol, $limit, $offset);
        
            // Obtener el total de usuarios con ese rol
            $totalUsuarios = $this->histroialModelo->contarUsuariosPorRol($rol);
            $totalPaginas = ($totalUsuarios > 0) ? ceil($totalUsuarios / $limit) : 1;
                    
            // Cargar la vista con los datos
            require_once __DIR__ . '/../Views/gestion/historial_registros/historial_registros.php';
        }

        public function filtroUsuarios() {
            // Obtener parámetros GET de forma segura
            $rol = $_GET['rol'] ?? '';
            $documento = $_GET['documento'] ?? '';
            $nombre = $_GET['nombre'] ?? ''; // Nuevo parámetro para nombre
        
            // Validar que el rol sea permitido
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = 'Instructor'; // Si el rol no es válido, buscar en todos los tipos
            }
        
            // Validar el documento (solo números y longitud máxima)
            if (!empty($documento)) {
                $documento = preg_replace('/[^0-9]/', '', $documento); // Eliminar caracteres no numéricos
                $documento = substr($documento, 0, 20); // Limitar la longitud del documento
            } else {
                $documento = ''; // Asegurar que esté vacío si no hay valor
            }
        
            // Validar el nombre (eliminar caracteres no permitidos)
            if (!empty($nombre)) {
                $nombre = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', $nombre); // Solo letras y espacios
                $nombre = substr($nombre, 0, 100); // Limitar la longitud del nombre
            } else {
                $nombre = ''; // Asegurar que esté vacío si no hay valor
            }
        
            // Obtener los usuarios filtrados por rol, documento y nombre con paginación
            $usuarios = $this->histroialModelo->filtrarUsuarios($rol, $documento, $nombre);
            // Obtener el número total de usuarios (sin paginación)
            $totalUsuarios = $this->histroialModelo->contarUsuariosFiltrados($rol, $documento, $nombre);
        
            // Pasar los datos a la vista de la tabla
            $data = [
                'usuarios' => $usuarios,
                'rol' => $rol,
                'documento' => $documento,
                'nombre' => $nombre, // Añadir el nombre a los datos
                'totalUsuarios' => $totalUsuarios, // Pasar el total de usuarios para la paginación
            ];
        
            // Incluir solo la tabla (sin layout)
            include_once __DIR__ . '/../Views/gestion/partials/informacion_tabla.php';
        }
                
    }

?>

