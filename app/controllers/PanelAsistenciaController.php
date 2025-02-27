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
            $rolesPermitidos = ['Instructor', 'Funcionario', 'Directiva'];
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
            include_once __DIR__ . '/../views/reports/panel_reportes.php';
        }
        
        


        public function filtrarFuncionarios() {
            // 1. Capturar los valores GET
            $tipo = $_GET['tipo'] ?? '';          // Puede ser 'Instructor', 'Directiva', 'Funcionario' o ''
            $documento = $_GET['documento'] ?? ''; // El documento a buscar
    
            // 2. Llamar al modelo para obtener los datos filtrados
            $resultado = $this->panelAsistenciaModelo->filtroFuncionario($tipo, $documento);
    
            // 3. Cargar la vista que mostrará los resultados
            include_once __DIR__ . '/../views/reports/tabla_funcionarios.php';
        }
        

        // public function mostralPanelAsistenciasPaginado() {
        //     // Definir la cantidad de fichas por página
        //     $limite = 3;
        //     // Obtener la página actual
        //     $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        //     $offset = ($pagina - 1) * $limite;
            
        //     // Obtener los aprendices agrupados por ficha de forma paginada
        //     $aprendicesPorFicha = $this->panelAsistenciaModelo->obtenerTodosPorFichaPaginadas($limite, $offset);
        
        //     // Calcular el total de fichas para la paginación
        //     // Ajusta el método para que cuente únicamente las fichas activas, si es tu caso.
        //     $totalFichas = $this->panelAsistenciaModelo->contarFichas();
        //     $totalPaginas = ceil($totalFichas / $limite);
        
        //     // Opcional: método para detectar si es una petición AJAX
        //     if ($this->esAjax()) {
        //         // Si es AJAX, solo cargamos la vista parcial (tabla_aprendices.php)
        //         // Asegúrate de que estas variables estén disponibles en la vista
        //         include_once __DIR__ . '/../views/reports/tabla_aprendices.php';
        //     } else {
        //         // Si NO es AJAX, cargamos la vista completa (panel.php)
        //         include_once __DIR__ . '/../views/reports/panel_reportes.php';

        //         // Dentro de panel.php, puedes tener un contenedor (div) para inyectar la tabla vía AJAX
        //     }
        // }
        
        
        // /**
        //  * Verifica si la petición es AJAX revisando el encabezado X-Requested-With
        //  */
        // private function esAjax() {
        //     return (
        //         isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
        //         && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        //     );
        // }
        

        // public function filtrarAprendices() {
        //     // Filtros
        //     $ficha = $_POST['ficha'] ?? '';
        //     $documento = $_POST['documento'] ?? '';
        
        //     // Paginación
        //     // Podrías recibir la página desde un input hidden o por JS (por ejemplo, 'pagina' en el FormData).
        //     // Si no la recibes, asume página = 1.
        //     $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        //     $limite = 3;
        //     $offset = ($pagina - 1) * $limite;
        
        //     // Consulta al modelo: versión filtrada + paginación
        //     $aprendicesPorFicha = $this->panelAsistenciaModelo->obtenerAprendicesFiltrados($ficha, $documento, $limite, $offset);
        
        //     // Contar cuántos resultados hay en total (versión filtrada)
        //     $totalFiltrados = $this->panelAsistenciaModelo->contarFichas($ficha, $documento);
        //     $totalPaginas = ceil($totalFiltrados / $limite);
        
        //     // Incluir la vista parcial
        //     // Allí tendrás acceso a $aprendicesPorFicha, $pagina, $totalPaginas, etc.
        //     include_once __DIR__ . '/../views/reports/tabla_aprendices.php';
        // }
        
    }
?>

