<?php
    // Se importa el modelo 'panelAsistenciaModelo' para poder interactuar con la base de datos
    require_once __DIR__ . '/../models/PanelAsistenciaModelo.php';

    class PanelAsistenciaController {

        // Se declara la propiedad para almacenar la instancia del modelo de aprendiz
        private $panelAsistenciaModelo;

        // Constructor de la clase
        public function __construct() {
            // Se inicializa la propiedad $modeloAprendiz con una nueva instancia del modelo 'panelAsistenciaModelo'
            $this->panelAsistenciaModelo = new PanelAsistenciaModelo();
        }

        /**
        * Muestra la lista de usuarios filtrados por rol, con paginación de 30 registros.
        * Ejemplo de uso: /funcionarios_asistencia?rol=Instructor&page=1
        */
        public function mostrarFuncionarios() {
            // 1) Obtener parámetros GET de forma segura
            $rol = $_GET['rol'] ?? 'Instructor';  // Valor por defecto
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Convertimos a int
        
            // 2) Validamos que la página sea al menos 1
            $page = max(1, $page);
        
            // 3) Definir roles permitidos
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directiva', 'Apoyo'];
            if (!in_array($rol, $rolesPermitidos)) {
                $rol = 'Instructor'; // Si el rol no es válido, asignamos uno por defecto
            }
        
            // 4) Definir el límite de usuarios por página y el offset
            $limit = 30;
            $offset = ($page - 1) * $limit;
        
            // 5) Obtener los usuarios del rol seleccionado
            $usuarios = $this->panelAsistenciaModelo->obtenerUsuariosPorRol($rol, $limit, $offset);
        
            // 6) Obtener el total de usuarios con ese rol
            $totalUsuarios = $this->panelAsistenciaModelo->contarUsuariosPorRol($rol);
            $totalPaginas = ($totalUsuarios > 0) ? ceil($totalUsuarios / $limit) : 1;
        
            // 7) Cargar la vista con los datos
            include_once __DIR__ . '/../views/gestion/panel_asistencias/panel_registros.php';
        }
        
        public function filtrarFuncionarios() {
            // 1. Capturar los valores GET
            $tipo = $_GET['tipo'] ?? '';          // Puede ser 'Instructor', 'Directiva', 'Funcionario' o ''
            $documento = $_GET['documento'] ?? ''; // El documento a buscar
    
            // 2. Llamar al modelo para obtener los datos filtrados
            $resultado = $this->panelAsistenciaModelo->filtroFuncionario($tipo, $documento);
    
            // 3. Cargar la vista que mostrará los resultados
            include_once __DIR__ . '/../views/gestion/panel_asistencias/tabla_funcionarios.php';
        }
        

        
        
    }
?>

