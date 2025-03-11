<?php

    session_start();

    // Se importa el modelo 'panelIngresoModelo' para poder interactuar con la base de datos
    require_once __DIR__ . '/../models/PanelIngresoModelo.php';

    class PanelIngresoController {

        // Se declara la propiedad para almacenar la instancia del modelo de aprendiz
        private $panelIngresoModelo;

        // Constructor de la clase
        public function __construct() {
            // Se inicializa la propiedad $modeloAprendiz con una nueva instancia del modelo 'panelIngresoModelo'
            $this->panelIngresoModelo = new PanelIngresoModelo();
        }

        /**
        * Muestra la lista de usuarios filtrados por rol, con paginación de 30 registros.
        * Ejemplo de uso: /funcionarios_asistencia?rol=Instructor&page=1
        */
        public function mostrarUsuarios() {
            // 1) Obtener parámetros GET de forma segura
            $rol = $_GET['rol'] ?? 'Instructor';  // Valor por defecto
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Convertimos a int
        
            // 2) Validamos que la página sea al menos 1
            $page = max(1, $page);
        
            // 3) Definir roles permitidos
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = 'Instructor'; // Si el rol no es válido, asignamos uno por defecto
            }
        
            // 4) Definir el límite de usuarios por página y el offset
            $limit = 1;
            $offset = ($page - 1) * $limit;
        
            // 5) Obtener los usuarios del rol seleccionado
            $usuarios = $this->panelIngresoModelo->obtenerUsuariosPorRol($rol, $limit, $offset);
        
            // 6) Obtener el total de usuarios con ese rol
            $totalUsuarios = $this->panelIngresoModelo->contarUsuariosPorRol($rol);
            $totalPaginas = ($totalUsuarios > 0) ? ceil($totalUsuarios / $limit) : 1;
                    
            // 7) Cargar la vista con los datos
            require_once __DIR__ . '/../views/gestion/panel_ingreso/panel_registros.php';
        }

        public function filtroUsuarios()
        {
            // Obtener parámetros GET de forma segura
            $rol = $_GET['rol'] ?? '';
            $documento = $_GET['documento'] ?? '';
            $page = $_GET['page'] ?? 1; // Página actual (por defecto 1)
            $limit = 10; // Número de usuarios por página

            // Validar que el rol sea permitido
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = ''; // Si el rol no es válido, buscar en todos los tipos
            }

            // Validar el documento (solo números y longitud máxima)
            if (!empty($documento)) {
                $documento = preg_replace('/[^0-9]/', '', $documento); // Eliminar caracteres no numéricos
                $documento = substr($documento, 0, 20); // Limitar la longitud del documento
            }

            // Obtener los usuarios filtrados por rol y documento
            $usuarios = $this->panelIngresoModelo->filtrarUsuarios($rol, $documento, $page, $limit);

            // Calcular el número total de páginas
            $totalUsuarios = count($usuarios); // Total de usuarios
            $totalPaginas = ceil($totalUsuarios / $limit); // Redondear hacia arriba

            // Pasar los datos a la vista de la tabla
            $data = [
                'usuarios' => $usuarios,
                'rol' => $rol,
                'documento' => $documento,
                'page' => $page,
                'totalPaginas' => $totalPaginas // Añadir el total de páginas
            ];

            // Incluir solo la tabla (sin layout)
            require_once __DIR__ . '/../views/gestion/partials/informacion_tabla.php';
        }
        
    }

?>

